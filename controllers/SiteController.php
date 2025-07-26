<?php

namespace app\controllers;

use app\forms\UrlForm;
use app\repository\UrlRepository;
use Da\QrCode\Contracts\ErrorCorrectionLevelInterface;
use Da\QrCode\QrCode;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex(): Response|string|array
    {
        $model = new UrlForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new UrlForm();
        if (
            Yii::$app->request->isAjax
            && $model->load(Yii::$app->request->post())
            && $model->validate()
        ) {
            $idCode = UrlRepository::createUrl($model->url);
            $host = Yii::$app->request->getHostInfo();
            return [
                'success' => true,
                'shortUrl' => "{$host}/redirect/{$idCode}",
                'idCode' => $idCode
            ];
        } else {
            return [
                'success' => false,
                'errors' => $model->errors,
            ];
        }
    }

    public function actionRedirect($idCode): Response
    {
        $url = UrlRepository::getUrl(['id_code' => $idCode]);
        $userIP = Yii::$app->request->getUserIP();
        $userAgent = Yii::$app->request->getUserAgent();
        UrlRepository::createUrlLog($idCode, $userIP, $userAgent);
        UrlRepository::incrementCounter($idCode);
        return $this->redirect($url->original_url);
    }

    public function actionQr($idCode): string
    {
        /** @var QrCode $qr */
        $qr = Yii::$app->get('qr');

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', $qr->getContentType());
        $host = Yii::$app->request->getHostInfo();
        return $qr
            ->setErrorCorrectionLevel(ErrorCorrectionLevelInterface::HIGH)
            ->setText("{$host}/redirect/{$idCode}")
            ->writeString();
    }

}
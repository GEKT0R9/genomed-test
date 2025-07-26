<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\forms\UrlForm $model */

use app\assets\CreateUrlAsset;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

CreateUrlAsset::register($this);
$this->title = 'Сократить URL';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'id' => 'url-form',
                'enableAjaxValidation' => true,
            ]); ?>

            <?= $form->field($model, 'url')->textInput(['autofocus' => true]) ?>

            <div class="form-group text-center">
                <div>
                    <?= Html::submitButton('ОК', ['class' => 'btn btn-primary px-5 py-2 fs-5', 'id' => 'url-ok-button', 'disabled' => true]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <div id="result-container" class="mt-4" style="display: none;">
        <div class="card col-lg-5 m-auto">
            <div class="card-body">
                <h5 class="card-title">Ваша короткая ссылка</h5>
                <div class="col">
                    <div class="input-group mb-3">
                        <input type="text" id="short-url" class="form-control" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="copy-btn">
                            <i class="bi bi-clipboard"></i> Копировать
                        </button>
                    </div>
                </div>
                <div class="text-center">
                    <div id="qr-code-container">
                        <p class="text-muted">QR-код появится здесь</p>
                    </div>
                    <small class="text-muted">Наведите камеру телефона для сканирования</small>
                </div>
            </div>
        </div>
    </div>
</div>

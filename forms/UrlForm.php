<?php

namespace app\forms;

use yii\web\UploadedFile;

class UrlForm extends \yii\base\Model
{
    public string $url = '';

    public function rules(): array
    {
        return [
            [['url'], 'required'],
            [['url'], 'url', 'validSchemes' => ['http', 'https'], 'defaultScheme' => 'https'],
            [['url'], 'validateUrlAvailability'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'url' => 'Адрес'
        ];
    }

    public function validateUrlAvailability($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $ch = curl_init($this->url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode < 200 || $httpCode >= 400) {
                $this->addError($attribute, 'Данный URL не доступен');
            }
        }
    }


}
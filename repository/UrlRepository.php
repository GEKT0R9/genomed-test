<?php

namespace app\repository;

use app\models\UrlLogs;
use app\models\Urls;

class UrlRepository
{
    public static function getUrl($where): Urls|null{
        return Urls::find()->where($where)->one();
    }

    public static function createUrl(string $urlAddress): string
    {
        $url = new Urls();
        $url->original_url = $urlAddress;
        $url->id_code = \Yii::$app->security->generateRandomString(30);
        $url->save();
        return $url->id_code;
    }

    public static function createUrlLog($url_id_code, $user_ip, $user_agent){
        $urlLog = new UrlLogs();
        $urlLog->url_id_code = $url_id_code;
        $urlLog->ip_address = $user_ip;
        $urlLog->user_agent = $user_agent;
        $urlLog->save();
        return $urlLog->id;
    }
    public static function incrementCounter($url_id_code){
        $url = self::getUrl(['id_code' => $url_id_code]);
        $url->updateCounters(['counter' => 1]);
        $url->save();
    }
}
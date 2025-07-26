<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url_logs".
 *
 * @property int $id
 * @property string $url_id_code
 * @property string $ip_address
 * @property string|null $user_agent
 * @property string $access_time
 *
 * @property Urls $url
 */
class UrlLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_id_code' => 'Url Id Code',
            'ip_address' => 'Ip Address',
            'user_agent' => 'User Agent',
            'access_time' => 'Access Time',
        ];
    }

    /**
     * Gets query for [[UrlIdCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUrl()
    {
        return $this->hasOne(Urls::class, ['id_code' => 'url_id_code']);
    }
}

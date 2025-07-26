<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "urls".
 *
 * @property string $id_code
 * @property string $original_url
 * @property string $created_at
 * @property int|null $counter
 *
 * @property UrlLogs $urlLogs
 */
class Urls extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'urls';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_code' => 'Id Code',
            'original_url' => 'Original Url',
            'created_at' => 'Created At',
            'counter' => 'Counter',
        ];
    }

    /**
     * Gets query for [[UrlLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUrlLogs()
    {
        return $this->hasOne(UrlLogs::class, ['url_id_code' => 'id_code']);
    }
}

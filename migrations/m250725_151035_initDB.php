<?php

use yii\db\Migration;

/**
 * Class m250725_151035_initDB
 */
class m250725_151035_initDB extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('urls', [
            'id_code' => $this->string(30)->notNull()->unique(),
            'original_url' => $this->string(512)->notNull(),
            'created_at' => $this->timestamp()
                ->defaultExpression('current_timestamp')
                ->notNull(),
            'counter' => $this->integer()->defaultValue(0),
        ]);
        $this->addPrimaryKey('urls_id_code_pk', 'urls', 'id_code');

        $this->createTable('url_logs', [
            'id' => $this->primaryKey(),
            'url_id_code' => $this->string(30)->notNull(),
            'ip_address' => $this->string(45)->notNull(),
            'user_agent' => $this->string(512),
            'access_time' => $this->timestamp()
                ->defaultExpression('current_timestamp')
                ->notNull(),
        ]);
        $this->addForeignKey(
            'url_to_logs_fk',
            'url_logs',
            'url_id_code',
            'urls',
            'id_code',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('url_logs');
        $this->dropTable('urls');
    }
}

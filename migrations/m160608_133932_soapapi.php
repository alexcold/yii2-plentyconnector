<?php
use yii\db\Schema;
use yii\db\Migration;

class m160608_133932_soapapi extends Migration
{
    public function up()
    {
        $this->createTable('{{%soap_setting}}', [
            'ID' => Schema::TYPE_PK,
            'connection_uri' => Schema::TYPE_STRING . '(25) NOT NULL',
            'version' => Schema::TYPE_STRING . '(255) NOT NULL',
            'enabled' => Schema::TYPE_STRING . '(60) NOT NULL',
            'username' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password' => Schema::TYPE_STRING . '(32)',
            'user_id' => Schema::TYPE_INTEGER,
        ]);
        $this->createTable('{{%app_value}}', [
            'ID' => Schema::TYPE_PK,
            'key' => Schema::TYPE_STRING . '(255) NOT NULL',
            'value' => Schema::TYPE_STRING . '(255) NOT NULL',
        ]);
    }
}

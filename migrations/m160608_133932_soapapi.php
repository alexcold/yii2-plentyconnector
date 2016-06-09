<?php
use yii\db\Schema;
use yii\db\Migration;

class m160608_133932_soapapi extends Migration
{
    public function up()
    {
        $this->createTable('{{%soap_setting}}', [
            'ID' => Schema::TYPE_PK,
            'connection_uri' => Schema::TYPE_STRING . '(255) NOT NULL',
            'version' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'enabled' => Schema::TYPE_INTEGER . '(1) NOT NULL',
            'username' => Schema::TYPE_STRING . '(45) NOT NULL',
            'password' => Schema::TYPE_STRING . '(64)',
            'soap_header' => Schema::TYPE_STRING . '(255)',
            'last_token' => Schema::TYPE_INTEGER . '(11)',
        ]);
    }
}

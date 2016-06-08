<?php

namespace alexcold\plentyconnector\models;

use Yii;

/**
 * This is the model class for table "soap_setting".
 *
 * @property integer $ID
 * @property string $connection_uri
 * @property integer $version
 * @property integer $enabled
 * @property string $username
 * @property string $password
 * @property integer $user_id
 *
 * @property UserModel $user
 */
class SoapSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'soap_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version', 'enabled'], 'integer'],
            [['connection_uri', 'password'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'connection_uri' => 'Connection Uri',
            'version' => 'Version',
            'enabled' => 'Enabled',
            'username' => 'Username',
            'password' => 'Password',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
     
    public static function getDefaultSetting($id = null)
    {
        if($id)
            $model = self::findOne($id);
        else
            $model = self::findOne(['enabled' => 1]);
        return isset($model->ID) ? $model : null;
    }
}

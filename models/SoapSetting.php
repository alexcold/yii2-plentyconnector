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
 * @property string $soap_header
 * @property integer $last_token
 *
 * @property UserModel $user
 */
class SoapSetting extends \yii\db\ActiveRecord {
    /**
     * @inheritdoc
     */
     
    public static function tableName () {
        return 'soap_setting';
    }

    /**
     * @inheritdoc
     */
     
    public function rules () {
        return [
            [['version', 'enabled', 'last_token'], 'integer'],
            [['connection_uri', 'password', 'soap_header'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
     
    public function attributeLabels () {
        return [
            'ID' => Yii::t('app', 'ID'),
            'connection_uri' => Yii::t('app', 'Connection Uri'),
            'version' => Yii::t('app', 'Version'),
            'enabled' => Yii::t('app', 'Enabled'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'user_id' => Yii::t('app', 'User ID'),
            'soap_header' => Yii::t('app', 'Soap Header'),
            'last_token' => Yii::t('app', 'Last Token')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
     
    public static function getDefaultSetting ($id = null) {
        if ($id)
            $model = self::findOne($id);
        else
            $model = self::findOne(['enabled' => 1]);
        return isset($model->ID) ? $model : null;
    }
    
    /**
     * 
     * Public Setters
     * 
     */
    
    public function resetSoapHeader () {
        $this->soap_header = null;
        $this->last_token = null;
        if ( $this->save())
            return true;
        return false;
    }
    
    public function testPlentyCall () {
        try {
            $soapClient = new \alexcold\plentyconnector\components\SOAP($this->ID);
            if ($soapClient->getInstance()) {
                Yii::$app->session->setFlash('info', Yii::t('app', 'Successfully connected to ') . $this->connection_uri);
               return true;
            }
        } catch (\Exception $e) {
            $this->delete();
            Yii::$app->session->setFlash('info', Yii::t('app', 'Conneciton data is invalid'));
            return false;
        }
    }
}

<?php

namespace alexcold\plentyconnector\models;

use Yii;

/**
 * This is the model class for table "app_value".
 *
 * @property integer $ID
 * @property string $key
 * @property string $value
 */
class AppValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'string', 'max' => 128],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }
    public static function Get($name, $default = NULL)
	{
		$setting = self::findOne(array("key" => $name));
		if($setting == NULL) 
		{
			self::Set($name, $default);
			return $default;
		}
		return $setting->value;
	}
	public static function GetInt($name, $default = 0) 
	{
		return (int)self::Get($name, $default);
	}
	public static function Set($name, $value)
	{
		$setting =  self::findOne(array("key" => $name));
		if($setting == NULL)
		{

			$setting = new AppValue();
			$setting->key = $name;
		}
		$setting->value = (string)$value;
		$setting->save();
	}
}

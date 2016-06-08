<?php
namespace alexcold\plentyconnector\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use alexcold\plentyconnector\models\SoapSetting;
use alexcold\plentyconnector\models\AppValue;

class SOAP extends Component
{
	public $getInstance = null;
	public $ID = null;
	
	public function __construct()
	{
		$this->getInstance = $this->_getInstance();
	}
	private function getSoapClient($version = null, $rcon = null)
	{
		ini_set('max_execution_time', 3600);
		
		date_default_timezone_set("CET");
		
		$settings = SoapSetting::getDefaultSetting($rcon);
		$this->ID = $settings->ID;
		
		if($version)
			$settings->version = $version;
		
		$soapClient = new \SoapClient($settings->connection_uri."version".$settings->version."/?xml", array('trace' => 1));
		
		$soapHeader = AppValue::Get("soap_import_header_".$settings->ID, "UNSET");
		$lastToken = AppValue::GetInt("soap_import_last_token_".$settings->ID, 0);
			
		if($soapHeader == "UNSET" || date("z", $lastToken) != date("z", time()))
		{
		    $authentification = $soapClient->GetAuthentificationToken( array('Username' => $settings->username, 'Userpass' => $settings->password));
		    if(isset($authentification->Token))
			{
				$headerbody = new \stdClass();
				$headerbody->UserID = $authentification->UserID;
				$headerbody->Token = $authentification->Token;
				$headerbody->Username = $settings->username;

				$serializedHeader = serialize($headerbody);
				
				AppValue::Set("soap_import_header_".$settings->ID, $serializedHeader);
				AppValue::Set("soap_import_last_token_".$settings->ID, time());
			}
		}

		$soapHeader = AppValue::Get("soap_import_header_".$settings->ID, "UNSET");
		$headerbody = unserialize($soapHeader);

		$header = new \SOAPHeader('Authentification', 'verifyingToken', $headerbody, false); 
		$soapClient->__setSoapHeaders($header);

		return $soapClient;
	}
	public function _getInstance()
	{
		return $this->getSoapClient();
	}
	public function reconnect($rcon)
	{
		$this->getInstance = $this->getSoapClient(null, $rcon);
	}
}
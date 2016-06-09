<?php
/**
 * 
 * Plenty Markets SOAP API connector - component 
 * @author Aleksandr Cerkasov <coldworld333@gmnail.com>
 * 
 */
namespace alexcold\plentyconnector\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use alexcold\plentyconnector\models\SoapSetting;
use alexcold\plentyconnector\models\AppValue;

class SOAP extends Component {
	private $instance;
	public $ID;
	
	public function __construct ($id) {
		$this->ID = $id;
	}
	
	private function getSoapClient () {
		ini_set('max_execution_time', 3600);
		date_default_timezone_set("CET");
		
		$settings = SoapSetting::getDefaultSetting($this->ID);
		$this->ID = $settings->ID;
		
		if($version)
			$settings->version = $version;
		
		$soapClient = new \SoapClient($settings->connection_uri."version".$settings->version."/?xml", array('trace' => 1));
		
		$soapHeader = $settings->soap_header;
		$lastToken = $settings->last_token;
			
		if(!$soapHeader || date("z", $lastToken) != date("z", time()))
		{
		    $authentification = $soapClient->GetAuthentificationToken( array('Username' => $settings->username, 'Userpass' => $settings->password));
		    if(isset($authentification->Token))
			{
				$headerbody = new \stdClass();
				$headerbody->UserID = $authentification->UserID;
				$headerbody->Token = $authentification->Token;
				$headerbody->Username = $settings->username;

				$serializedHeader = serialize($headerbody);
				
				$settings->soap_header = $serializedHeader;
				$settings->last_token = time();
				$settings->save();
			}
		}

		$soapHeader = $settings->soap_header;
		$headerbody = unserialize($soapHeader);

		$header = new \SOAPHeader('Authentification', 'verifyingToken', $headerbody, false); 
		$this->instance = $soapClient->__setSoapHeaders($header);
	}
	
	public function init () {
		parent::init();
		$this->getSoapClient();
	}
	
	public function getInstance () {
		return $this->instance;
	}
}
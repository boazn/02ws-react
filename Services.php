<?php
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
include_once("include.php"); 
include_once "start.php";
include_once ("requiredDBTasks.php");
include_once "sigweathercalc.php";
$forecastDaysDB = $mem->get('forecastDaysDB');
//print_r($forecastDaysDB);
$forecastHour = $mem->get('forecasthour');
$sigforecastHour = $mem->get('sigforecastHour');
//logger("rss_forecast read");
class SimpleRest {
	
	private $httpVersion = "HTTP/1.1";

	public function setHttpHeaders($contentType, $statusCode){
		
		$statusMessage = $this -> getHttpStatusMessage($statusCode);
		
		header($this->httpVersion. " ". $statusCode ." ". $statusMessage);		
		header("Content-Type:". $contentType);
	}
	
	public function getHttpStatusMessage($statusCode){
		$httpStatus = array(
			100 => 'Continue',  
			101 => 'Switching Protocols',  
			200 => 'OK',
			201 => 'Created',  
			202 => 'Accepted',  
			203 => 'Non-Authoritative Information',  
			204 => 'No Content',  
			205 => 'Reset Content',  
			206 => 'Partial Content',  
			300 => 'Multiple Choices',  
			301 => 'Moved Permanently',  
			302 => 'Found',  
			303 => 'See Other',  
			304 => 'Not Modified',  
			305 => 'Use Proxy',  
			306 => '(Unused)',  
			307 => 'Temporary Redirect',  
			400 => 'Bad Request',  
			401 => 'Unauthorized',  
			402 => 'Payment Required',  
			403 => 'Forbidden',  
			404 => 'Not Found',  
			405 => 'Method Not Allowed',  
			406 => 'Not Acceptable',  
			407 => 'Proxy Authentication Required',  
			408 => 'Request Timeout',  
			409 => 'Conflict',  
			410 => 'Gone',  
			411 => 'Length Required',  
			412 => 'Precondition Failed',  
			413 => 'Request Entity Too Large',  
			414 => 'Request-URI Too Long',  
			415 => 'Unsupported Media Type',  
			416 => 'Requested Range Not Satisfiable',  
			417 => 'Expectation Failed',  
			500 => 'Internal Server Error',  
			501 => 'Not Implemented',  
			502 => 'Bad Gateway',  
			503 => 'Service Unavailable',  
			504 => 'Gateway Timeout',  
			505 => 'HTTP Version Not Supported');
		return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
	}
}

class ForecastRestHandler extends SimpleRest {

	private $m_forecastDaysDB = Array();
	private $m_forecastDaysOut = Array();
	private $m_current = Array();
	private $m_currentOut = Array();
	
	private function generateForecastOut(){
		foreach ($this->m_forecastDaysDB as $forecastDay){
			array_push($this->m_forecastDaysOut, array('date' => $forecastDay['date'], 'day_name' => $forecastDay['day_name'], 'lang0' => $forecastDay['lang0'], 'lang1' => $forecastDay['lang1'], 'TempLow' => $forecastDay['TempLow'], 'TempHigh' => $forecastDay['TempHigh'], 'TempNight' => $forecastDay['TempNight'], 'humDay' => $forecastDay['humDay']));
		}
		
	}
	Public function generateCurrentOut($current, $today){
		
			array_push($this->m_currentOut, array('time' => $current->get_time()));
			array_push($this->m_currentOut, array('temp' => $current->get_temp()));
			array_push($this->m_currentOut, array('temp2' => $current->get_temp2()));
			array_push($this->m_currentOut, array('temp3' => $current->get_temp3()));
			array_push($this->m_currentOut, array('hum' => $current->get_hum()));
			array_push($this->m_currentOut, array('pressure' => $current->get_pressure()));
			array_push($this->m_currentOut, array('winddir' => $current->get_winddir()));
			array_push($this->m_currentOut, array('windspd' => $current->get_windspd()));
			array_push($this->m_currentOut, array('rainrate' => $current->get_rainrate()));
			array_push($this->m_currentOut, array('rainchance' => $current->get_rainchance()));
			array_push($this->m_currentOut, array('solarradiation' => $current->get_solarradiation()));
			array_push($this->m_currentOut, array('sunshinehours' => $today->get_sunshinehours()));
			array_push($this->m_currentOut, array('rain' => $today->get_rain2()));
				
		
	}
	public function __construct($forecastDaysDB)
    {
		$this->m_forecastDaysDB = $forecastDaysDB;
		$this->generateForecastOut();
	} 

	function output($rawData) {
		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('error' => 'No mobiles found!');		
		} else {
			$statusCode = 200;
		}
		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		//$this ->setHttpHeaders($requestContentType, $statusCode);
				
		if(strpos($requestContentType,'application/json') !== false){
			$this ->setHttpHeaders('application/json', $statusCode);
			$response = $this->encodeJson($rawData);
			echo $response;
		} else if(strpos($requestContentType,'text/html') !== false){
			$this ->setHttpHeaders('text/html', $statusCode);
			$response = $this->encodeHtml($rawData);
			echo $response;
		} else if(strpos($requestContentType,'application/xml') !== false){
			$this ->setHttpHeaders('application/xml', $statusCode);
			$response = $this->encodeXml($rawData);
			echo $response;
		}
	}

	
	
	public function encodeHtml($responseData) {
	
		$htmlResponse = "<table>";
		foreach($responseData as $key=>$value) {
    			$htmlResponse .= "<tr><td>". $key. "</td><td>". $value. "</td></tr>";
		}
		$htmlResponse .= "</table>";
		return $htmlResponse;		
	}
	
	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}
	
	public function encodeXml($responseData) {
		// creating object of SimpleXMLElement
		$xml = new SimpleXMLElement('<?xml version="1.0"?><mobile></mobile>');
		foreach($responseData as $key=>$value) {
			$xml->addChild($key, $value);
		}
		return $xml->asXML();
	}
	
	function getAllForecast($lang, $tempunit) {	
			
		$rawData = $this->m_forecastDaysOut;
		$this->output($rawData);
		//$this->output($rawData);
	}
	public function getForecast($id, $lang, $tempunit) {
	
		$keys = array_keys($this->m_forecastDaysOut);
		if ($id > 0){ 
			$rawData = $this->m_forecastDaysOut[$keys[$id-1]];
			$this->output($rawData);
		}
		else
			$this->getAllForecast($lang, $tempunit);
		
	}
	public function getCurrent($id, $lang, $tempunit) {

		$keys = array_keys($this->m_currentOut);
		if ($id > 0){
			$rawData = $this->m_currentOut[$keys[$id-1]];
			$this->output($rawData);
		}
		else
			$this->getAllCurrent($lang, $tempunit);

		
	}

	public function getAllCurrent($lang, $tempunit) {
		$rawData = $this->m_currentOut;
		$this->output($rawData);
	}
}
$view = "";
$lang = 1;
$tempunit = '�c';
if(isset($_GET["view"]))
	$view = $_GET["view"];
if(isset($_GET["lang"]))
	$lang = $_GET["lang"];
if(isset($_GET["tempunit"]))
	$tempunit = $_GET["tempunit"];
/*
controls the RESTful services
URL mapping
*/
switch($view){

	case "all":
		// to handle REST Url /mobile/list/
		$forecastRestHandler = new ForecastRestHandler($forecastDaysDB);
		$forecastRestHandler->getAllForecast($lang, $tempunit);
		break;
		
	case "single":
		// to handle REST Url /mobile/show/<id>/
		$forecastRestHandler = new ForecastRestHandler($forecastDaysDB);
		$forecastRestHandler->getForecast($_GET["id"], $lang, $tempunit);
		break;
	case "now":
		$forecastRestHandler = new ForecastRestHandler($forecastDaysDB);
		$forecastRestHandler->generateCurrentOut($current, $today);
		$forecastRestHandler->getCurrent($_GET["id"], $lang, $tempunit);
		break;
	case "" :
		//404 - not found;
		break;
}
?>
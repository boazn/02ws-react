<?php
define("DATE_FORMAT", "j/m/y");
define("BASE_URL","https://www.02ws.co.il");
define("INTERVAL",10);    
define("RAIN_TOTAL",522.1);    
define("RAINYDAYS_TOTAL",58);  
define("ELEVATION",775);
define("TAF_STATION","OJAM"); // OJAM OJAI LLBG BIRK
define("FILE_ARCHIVE", $_SERVER['DOCUMENT_ROOT']."reports/downld02.txt");
define("FILE_THIS_MONTH",$_SERVER['DOCUMENT_ROOT']."reports/NOAAMO.TXT");    
define("FILE_PREV_MONTH",$_SERVER['DOCUMENT_ROOT']."reports/NOAAPRMO.TXT");
define("FILE_THIS_YEAR","reports/NOAAYR.TXT");
define("FILE_PREV_YEAR","reports/NOAAPRYR.TXT");
define("IMAGE_TYPE","gif");
define("LIMIT_CHAT_LINES","10");
define("JSON_FILE_PATH", "/home/boazn/public/02ws.com/public/02wsjson.txt");
define("FILE_XML_FULLDATA",$_SERVER['DOCUMENT_ROOT']."fulldatacumulus.xml");
define("FILE_XML_FULLDATA2",$_SERVER['DOCUMENT_ROOT']."fulldata.xml");
define("FILE_XML_FULLDATA3",$_SERVER['DOCUMENT_ROOT']."realtimemb.xml");
define("FILE_XML_MONTHLY_YEARLY",$_SERVER['DOCUMENT_ROOT']."monthlyyearlymb.xml");
define("FILE_CACHE","APC");
define("EMAIL_ADDRESS","02ws.yerushamaim@gmail.com");
define("GOOGLE_API_KEY", "AIzaSyA6nyCsWgrwXuh2tbsisPopkdgVRjQcTeQ");
define("FCM_API_KEY", "AAAAM0yT7d4:APA91bEwbOz3O68Co8T38Jj7N_A1fIoYJIPGNRI83RfRNwdaG6TxEFs4Nw6aoLjd1B90nNIebV6kg1TcmcHoGDORb5-H-p9z5kCws3LxLiooivyXOpkroMqYtyCGEIDJ38E3IaNKRYSW");
//AAAA9gsUJcw:APA91bGWiMagV4yTqG_0saibvybFuMFnuQr7TrdDmRAcaFpEKRfWIDjsgkM_MfF5guyMmrgFnBEIf0kjLbP9nvF5ToemJBPxXS96jnCWGpLoMxKAWXA-83sC9spXbAD18U45CuCe3ZL0
//AAAAJtcpURM:APA91bHa5_OrxIjKMr2P07pcBYjJytkoTnjtmKsdVCACrlouLucehSPFDmSgq6E00S80ej7t8_6Jes5gCMQULoff_8uR9jaR2hRvMgnPyq1TUmAGzDZaTqnc73R_bqlMjF2jEWSDVnlc
//AAAAM0yT7d4:APA91bEwbOz3O68Co8T38Jj7N_A1fIoYJIPGNRI83RfRNwdaG6TxEFs4Nw6aoLjd1B90nNIebV6kg1TcmcHoGDORb5-H-p9z5kCws3LxLiooivyXOpkroMqYtyCGEIDJ38E3IaNKRYSW
define("active_notification_key", "APA91bENtneEEOGI14MDUQY2LXX_sSqMdxVXYMaGLbf1uSddpX5xdb9qCMsQAoKITC6cYHVdmYFGKGJdbQ4xo_HdoqSgKqyHrABLF72pz5SONBrwEwIzf8g");
define("active_rain_etc_notification_key", "APA91bHeh6crYlUpYFcHqtPYbJROq_4ZVIGJ2qaH8L85-2cGKvLwLTCDQ5LeWQcaWhg-bYKdsVly_aDdV59hsX7gV7-r_mVINx46XlGQhwszOnNP0MKVt0NhNHhZ3J-28WieL2-1xN3b");
define("active_tips_notification_key", "APA91bEQzwEwUf_S4p5Y5Bu1P8c8DoPG76cA4fPDyn0Xr7aYaw0I9q1feJzxr82XnEsTrDVEmD1GDecLjJ67Q8u3uelTnqjp-oI8uRb1L15gFwrrpGcAF34");
define("active_dust_notification_key", "APA91bFNKHLHRL4jYrkrqHLQSOW5058ckQS-FgQMQ_kqD2PJvEtGYU4mNR5qzhG8vwvjWs6EviiQ9oP3m6_ZkNlWvEPUT1S22CU836KP6I1tzmGvjdmi6B4");
define("active_uv_notification_key", "APA91bHGn66oclmoo1M0v8PxJbxRo0J_u0c5m_Ge4uctXcomlaWqGER1P0P1ZO_jT3gOLPoEErgxEc0xeI9A8sntSMHbeMp7qpbfMxg2xUZ8mU9L2feGPXs");
define("active_dry_notification_key", "APA91bHqB_47tE-JWxOUqcm7i2qZpsFmXbDpNYpOmgwErnSj_ppYu9v-532Iyu8DIqEdFQ0IbVeLfZN71xp6YBFWg3MSWOVg7djGkWuWcnJzbvIYscysxqA");
define("MYSQL_DB","jws");
define("MYSQL_IP","localhost");	
define("MYSQL_USER","boazn");	
define("MYSQL_PASS","Boaz1972");
define("SENDMAIL_SLEEP_INTERVAL","42200");
define ("SERVER_CLOCK_DIFF", "+0 hours 0 minutes");
define ("GMT_TZ", "2");
define ("TASHKIF_START", "5");
define ("IS_SNOWING", 0);
define ("SNOW_IS_MELTING", 0);
define ("SNOW_ON_THE_GROUND", 0);
define("CAR_CLEANING_WORTH",3);
date_default_timezone_set('Asia/Jerusalem');
$recapcha_secret_key = "6LcQXKMcAAAAAEYEjtSTYpwZmzFhFq1EcRkTNzjF";
$header_pic = "img/logo.png";//header_small1.JPG//header_lights11.jpg
$PLACE = array("Jerusalem", "ירושלים", "Jerusalem");
$SLOGAN = array("Jerusalem Weather Station", "תחנת מזג-אוויר עדכנית בי-ם עם קור-טוב של הומור", "Иерусалимская метеорологическая станция");
$LOGO = array("02WS", "ירושמים", "02WS");
$WEBSITE_TITLE = array ("Jerusalem Weather Forecast Station", "ירושמים - תחזית ומזג-האוויר בירושלים בזמן אמת", "Иерусалимская метеорологическая станция");
$error_db = false;
$fulldatatotake = FILE_XML_FULLDATA;
$mySite = true;
$user_locked = false;
$PIVOT_TEMP = 22;
$PRIMARY_TEMP = 2;
// 30 min diff
if (((@filemtime(FILE_XML_FULLDATA) + 900) < @filemtime(FILE_XML_FULLDATA2)) || (!file_exists(FILE_XML_FULLDATA)))
	$fulldatatotake = FILE_XML_FULLDATA2;
$fulldatatotake = FILE_XML_FULLDATA3;
//$fulldatatotake = FILE_XML_FULLDATA2;
/***********************************************************************/

/*

for testings


$EmailsToSend = array();
$link = @mysql_connect(MYSQL_IP, MYSQL_USER, MYSQL_PASS) or $error_db = true;
	mysql_select_db("boaz") or die(".....connection failer......");
	if (!$error_db)
		{
			$query = "SELECT * From UserPrefs WHERE priority > '0'";
			$result = mysql_query($query);
			while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$lines++;
				array_push ($EmailsToSend, $line["email"]);
			} 
		}
var_dump($EmailsToSend);
*/
?>

<?
define("DATE_FORMAT", "j/m/y");
define("BASE_URL","http://www.02ws.co.il");
define("INTERVAL",10);    
define("RAIN_TOTAL",537);    
define("RAINYDAYS_TOTAL",60);  
define("ELEVATION",775);
define("TAF_STATION","OJAM"); // OJAM OJAI LLBG BIRK
define("FILE_ARCHIVE","./reports/downld02.txt");
define("FILE_THIS_MONTH","./reports/NOAAMO.TXT");    
define("FILE_PREV_MONTH","./reports/NOAAPRMO.TXT");
define("FILE_THIS_YEAR","./reports/NOAAYR.TXT");
define("FILE_PREV_YEAR","./reports/NOAAPRYR.TXT");
define("IMAGE_TYPE","gif");
define("JSON_FILE_PATH", "/home/boazn/public/02ws.com/public/02wsjson.txt");
define("FILE_XML_FULLDATA","fulldatacumulus.xml");
define("FILE_XML_FULLDATA2","fulldata.xml");
define("FILE_XML_FULLDATA3","realtimemb.xml");
define("FILE_XML_MONTHLY_YEARLY","monthlyyearlymb.xml");
define("FILE_CACHE","APC");
define("EMAIL_ADDRESS","02ws.yerushamaim@gmail.com");
define("GOOGLE_API_KEY", "AAAA9gsUJcw:APA91bGWiMagV4yTqG_0saibvybFuMFnuQr7TrdDmRAcaFpEKRfWIDjsgkM_MfF5guyMmrgFnBEIf0kjLbP9nvF5ToemJBPxXS96jnCWGpLoMxKAWXA-83sC9spXbAD18U45CuCe3ZL0");//AIzaSyA6nyCsWgrwXuh2tbsisPopkdgVRjQcTeQ
define("FCM_API_KEY", "AAAA9gsUJcw:APA91bGWiMagV4yTqG_0saibvybFuMFnuQr7TrdDmRAcaFpEKRfWIDjsgkM_MfF5guyMmrgFnBEIf0kjLbP9nvF5ToemJBPxXS96jnCWGpLoMxKAWXA-83sC9spXbAD18U45CuCe3ZL0");//AIzaSyCmSolZFAUmCnkVpY85bNp4ntzFZgz6fo4
define("MYSQL_DB","02ws");
define("MYSQL_IP","localhost");	
define("MYSQL_USER","boazn");	
define("MYSQL_PASS","854456");
define("SENDMAIL_SLEEP_INTERVAL","42200");
define ("SERVER_CLOCK_DIFF", "+0 hours 0 minutes");
define ("GMT_TZ", "3");
define ("TASHKIF_START", "4");
define ("IS_SNOWING", 0);
define ("SNOW_IS_MELTING", 0);
define ("SNOW_ON_THE_GROUND", 0);
date_default_timezone_set('Asia/Jerusalem');
$header_pic = "img/logo.png";//header_small1.JPG//header_lights11.jpg
$PLACE = array("Jerusalem", "ירושלים", "Jerusalem");
$SLOGAN = array("Jerusalem Weather Station", "תחנת מזג-אוויר עדכנית בי-ם", "Иерусалимская метеорологическая станция");
$LOGO = array("02WS", "ירושמים", "02WS");
$WEBSITE_TITLE = array ("Jerusalem Weather Forecast Station", "ירושמים - תחזית ומזג-האוויר בירושלים בזמן אמת", "Иерусалимская метеорологическая станция");
$error_db = false;
$fulldatatotake = FILE_XML_FULLDATA;
$mySite = true;
$user_locked = false;
$PIVOT_TEMP = 22;
$PRIMARY_TEMP = 2;
// 30 min diff
if (((@filemtime(FILE_XML_FULLDATA) + 1800) < @filemtime(FILE_XML_FULLDATA2)) || (!file_exists(FILE_XML_FULLDATA)))
	$fulldatatotake = FILE_XML_FULLDATA2;
$fulldatatotake = FILE_XML_FULLDATA3;
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

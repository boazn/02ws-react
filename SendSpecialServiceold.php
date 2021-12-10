<?
ini_set("display_errors","On");
include_once("start.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
class CloudMessageType {

    const Gcm = 1;
    const Fcm = 2;
}
/*******************************************************************************************/


function sendAPNMessage($messageBody, $title, $picture_url, $embedded_url, $short_range, $long_range, $tip, $dailyforecast)
{
  
    global $TIP, $ALERTS_PAYMENT;
    // Report all PHP errors
    error_reporting(-1);
    $registrationIDs0 = array();
    $registrationIDs1 = array();
    $short_range = ($short_range === 'true');
    $long_range = ($long_range === 'true');
    $tip = ($tip === 'true');
    if (boolval($tip)){
        $messageBody[0] = $TIP[0].": ".$messageBody[0];
        $messageBody[1] = $TIP[1].": ".$messageBody[1];
    }
   
    //$reg_id = "6d5c6ca8d3d36348ea4c52f6e0813e6713ef9b823a3da66a3714228e67146a10"; //d057506a9d09770900a09fbeb25c9e404829937bc1b3da0d34216f9cc57608e5//6d5c6ca8d3d36348ea4c52f6e0813e6713ef9b823a3da66a3714228e67146a10 
    //array_push ($registrationIDs1,array('apn_regid' => $reg_id, 'id' => '8025'));
   $query_extension = "";
        
    if ((boolval($long_range))&&(boolval($short_range))){
        $query = "select * FROM apn_users where active=1 or active_rain_etc=1".$query_extension;
    }
    else if (boolval($long_range)){
        $query = "select * FROM apn_users where active=1".$query_extension;
    }
    else if (boolval($short_range)){
        $query = "select * FROM apn_users where active_rain_etc=1 and approved=1".$query_extension;
    }
    else if (boolval($tip)){
        $query = "select * FROM apn_users where active_tips=1".$query_extension;
    }
    else if (boolval($dailyforecast)){
        $query = "select * FROM apn_users where dailyforecast=".date("H").$query_extension;
    }
    logger($query);
     $result = db_init($query, "");   
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
	  if ($line["apn_regid"] != "")
          {
              if ($line["lang"] == 0)
            array_push ($registrationIDs0, array('apn_regid' => $line["apn_regid"], 'id' => $line["id"]));
            elseif ($line["lang"] == 1)
            array_push ($registrationIDs1, array('apn_regid' => $line["apn_regid"], 'id' => $line["id"]));
          }
    }
 $result = "";
 if (strlen($title[1]) > 0){
    $messageBody[0] = $title[0].": ".$messageBody[0];
    $messageBody[1] = $title[1].": ".$messageBody[1];
 }
 $result = sendAPNToRegIDs($registrationIDs1, date('H:i')." ".$messageBody[1], $picture_url, $embedded_url);
 $result .= sendAPNToRegIDs($registrationIDs0, date('H:i')." ".$messageBody[0], $picture_url, $embedded_url);
 return $result;

}

function sendGCMMessage($messageBody, $title, $picture_url, $embedded_url, $short_range, $long_range, $tip, $dailyforecast, $CloudMessageType)
{
    global $TIP, $REPLY_ENGAGE, $ALERTS_PAYMENT;
    $key = "";
    $registrationIDs0 = array();
    $registrationIDs1 = array();
    $lines = 0;
    $query = "";
    $short_range = ($short_range === 'true');
    $long_range = ($long_range === 'true');
    $tip = ($tip === 'true');
    if (empty($picture_url)){
      //  $picture_url = 'http://www.02ws.co.il/02ws_short.png';
      //  $picture_url = 'http://www.02ws.co.il/images/webCamera0.jpg';
    }
    if (boolval($tip)){
        $messageBody[0] = $TIP[0].": ".$messageBody[0];
        $messageBody[1] = $TIP[1].": ".$messageBody[1];
    }
    $messageBody[0] = date('H:i')." ".$messageBody[0];
    $messageBody[1] = date('H:i')." ".$messageBody[1];
    if ($CloudMessageType == CloudMessageType::Fcm)
    {
        $key = FCM_API_KEY;
        $query_extension = " and fcm=1";
    }
    else
    {
        $key = GOOGLE_API_KEY;
        $query_extension = " and fcm<>1";
    }
    if ((boolval($long_range))&&(boolval($short_range))){
        $query = "select * FROM fcm_users where active=1 or active_rain_etc=1".$query_extension;
    }
    else if (boolval($long_range)){
        $query = "select * FROM fcm_users where active=1".$query_extension;
    }
    else if (boolval($short_range)){
        $query = "select * FROM fcm_users where active_rain_etc=1 and approved=1".$query_extension;
    }
    else if (boolval($tip)){
        $query = "select * FROM fcm_users where active_tips=1".$query_extension;
    }
    else if (boolval($dailyforecast)){
        $query = "select * FROM fcm_users where dailyforecast=".date("H").$query_extension;
    }
    $result = db_init($query, "");
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
	$lines++;
        //echo "<br />".$line["gcm_regid"]."<br />";
        if ($line["lang"] == 0)
            array_push ($registrationIDs0, $line["gcm_regid"]);
        elseif ($line["lang"] == 1)
            array_push ($registrationIDs1, $line["gcm_regid"]);
    }
    
    logger($query);
    logger("sendingGCMMessage CloudMessageType=".$CloudMessageType.": En:".count($registrationIDs0)." Heb:".count($registrationIDs1)." Pic:".$picture_url);
     
    /* test
   
        $registrationIDs = array();
        $registrationIDs0 = array();
        $registrationIDs1 = array();
    
	 //test boazn1@gmail.com
	 // test efrat
         if ($CloudMessageType == CloudMessageType::Fcm)
            array_push ($registrationIDs1, "cPzSkq79gR8:APA91bEGTjUIg8wceFjU9h0dK-GpooqUbH2qbjPiFZMVsmmyvdGLvcDxBHbdEaFr4WJYWfqyWauoxupi3cbV2rTecW3EqlxoNuR42IX0X94pdUmqRJSl8CFN25WI3GkTn1Hst7obPIkJ");
         else
            array_push ($registrationIDs1, "APA91bHeuwNkpfuhTy5IUUseUL-BOPwnhmY8nJNS_uuV_ZpcYnRDVjQfcaiiQnEI0MxH2W1dDyViJDF22It_ZYawz8UkxDcXgIaZxOMnM1GZBSTz-TPvzfmRCo38KTZLLKZnmqoe1SgICq88Ymy92_cBHWuam8nINA");
       */   
     //
     $result = "";
     $resultCall = array();
     $arrOfRegID0 = array_chunk($registrationIDs0, 1000);
     foreach ($arrOfRegID0 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[0], $title[0], $picture_url, $embedded_url);
        if ($CloudMessageType == CloudMessageType::Fcm){
            logger($resultCall[1]);
        }
        handleInvalidTokens($resultCall[1], $regIDs, $key);
      }
    
     $arrOfRegID1 = array_chunk($registrationIDs1, 1000);
     foreach ($arrOfRegID1 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[1], $title[1], $picture_url, $embedded_url);
        //logger($resultCall[1]);
        handleInvalidTokens($resultCall[1], $regIDs, $key);
     }
    
     
     $result .= '<br/> --- '.count($registrationIDs1).' GCMs Completed';
     $result .= '<br/> --- '.count($registrationIDs0).' GCMs Completed';
     //logger($result);
    return $result;        
}
function getForecastDay()
{
    global $NIGHT, $NOW, $NOON, $EN, $HEB, $current;
    $query = "select * FROM forecast_days order by idx";
    $result = db_init($query, "");
    $first_day = array();$idx = 0; 
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        $idx++;
        logger(date("H")." ".date("d/n")." ".$line["date"]);
        if (((date("H")<11)&&($idx == 1))||((date("H")>17)&&($line["date"])!=date("d/n")))
            {
                $lang_idx=0;
                $first_day0 = replaceDays($line["day_name"]." ").$line["date"]."\n".$line["lang0"]."\n".$NOW[$EN].": ".$current->get_temp()."°\n".$NOON[$EN].": ".$line["TempHigh"]."° - ".getClothTitle($line["TempHighCloth"], $line["TempHigh"])."\n".$NIGHT[$EN].": ".$line["TempNight"]."° - ".getClothTitle($line["TempNightCloth"], $line["TempNight"]);
                $lang_idx=1;
                $first_day1 = replaceDays($line["day_name"]." ").$line["date"]."\n".$line["lang1"]."\n".$NOW[$HEB].": ".$current->get_temp()."°\n".$NOON[$HEB].": ".$line["TempHigh"]."° - ".getClothTitle($line["TempHighCloth"], $line["TempHigh"])."\n".$NIGHT[$HEB].": ".$line["TempNight"]."° - ".getClothTitle($line["TempNightCloth"], $line["TempNight"]); 
                $first_day = array($first_day0, $first_day1);
                break;
            }
      }
      return $first_day;
}
function updateMessageFromMessages ($description, $active, $type, $lang, $href, $img_src, $title)
{
    global $ALERTS_PAYMENT, $PATREON_LINK;
    try
    {
        global $lang_idx;
        $lang_idx = $lang;
        $description = nl2br($description);
        $now = replaceDays(date('D H:i'));
        $append = true;
        $res = db_init("SELECT * FROM  `content_sections` WHERE (TYPE =  'forecast') and (lang=?)", $lang);
        while ($line = mysqli_fetch_array($res["result"], MYSQLI_ASSOC) ){
            $descriptionforecast = $line["Description"];
        }
        $res = db_init("SELECT * FROM  `content_sections` WHERE (TYPE =  'LAlert') and (lang=?)", $lang);
        while ($line = mysqli_fetch_array($res["result"], MYSQLI_ASSOC) ){
            $latestalert = $line["Description"];
        }
        $description_appended = $latestalert."\n</br>".$descriptionforecast;
        $description = "<div class=\"alerttime\">".$now."</div>".$description;
        //$now = getLocalTime(time());

        $query = "UPDATE `content_sections` SET Description='{$description_appended}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}'  WHERE (type='forecast') and (lang=$lang)";
        apc_store('descriptionforecast'.$lang, $description_appended);
        $res = db_init($query, "" );
        $query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}'  WHERE (type='$type') and (lang=$lang)";
        apc_store('latestalert'.$lang, $description);
        apc_store('latestalerttime'.$lang, time());
        $res = db_init($query, "" );
        // Free resultset 
        @mysqli_free_result($res);
    }
    catch (Exception $ex) {
        $result .= " exception:".$ex->getMessage();
    }   
	
}
$empty = $post = array();
foreach ($_POST as $varname => $varvalue) {
   if (empty($varvalue)) {
       $empty[$varname] = $varvalue;
   } else {
       $post[$varname] = $varvalue;
   }
}
if (empty($empty)) {
   print "None of the POSTed values are empty, posted:\n";
   //var_dump($post);
} else {
   //$result .= "We have " . count($empty) . " empty values\n";
   //$result .= "Posted:\n"; var_dump($post);
   //$result .= "Empty:\n";  var_dump($empty);
   
}
    $result = "";
    $msgSent = true;
    $name = array($_POST['name0'], $_POST['name1']);
    $email = $_POST['email'];
    $message = array($_POST['message0'], $_POST['message1']);
    $msgSpecial = array($_POST['message0'], $_POST['message1']);
    $title = array($_POST['title0'], $_POST['title1']);
    $picture_url = $_POST['picture_url'];
    echo "picture_url=".$picture_url;
    $embedded_url = $_POST['embedded_url'];
    if (!empty($_POST['dailyforecast'])||!empty($_GET['dailyforecast'])){
        $msgSpecial = getForecastDay();
        $title = array("Daily Forecast", "תחזית יומית");
        
    }
    if ($msgSpecial == ""){
        $result = "Empty Message";
        echo $result;
        exit;
    }
    
    if (empty($picture_url))
        $img_tag = "";
    else
        $img_tag = "<div id=\"alertbg\" style=\"background-image: url(".$picture_url.")\"></div>";
    
    

    try{
        $msgToAlertSection = array("<div id=\"alerttxt\">".$message[0]."</div>".$img_tag, "<div id=\"alerttxt\">".$message[1]."</div>".$img_tag);
        if (strlen($title[0]) > 0){
            $msgToAlertSection[0] = "<div class=\"title\">".$title[0].":</div> ".$msgToAlertSection[0];
            $msgToAlertSection[1] = "<div class=\"title\">".$title[1].":</div> ".$msgToAlertSection[1];
        }
        if ($_POST["short_range"]=="true"){
            $msgToAlertSection[0] = $msgToAlertSection[0]." ".$ALERTS_PAYMENT[0];
            $msgToAlertSection[1] = $msgToAlertSection[1]." ".$ALERTS_PAYMENT[1];
        }
        if ($_POST["alert_section"]=="1"){
            
            updateMessageFromMessages ($msgToAlertSection[0], 1, 'LAlert', 0 ,'' ,'','');
            updateMessageFromMessages ($msgToAlertSection[1], 1, 'LAlert', 1 ,'' ,'','');
    
          }
        } 
    catch (Exception $ex) {
        $result .= " exception updateMessageFromMessages:".$ex->getMessage();
    }
    
    try{
        //$result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"]);   
        $result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], $_POST["dailyforecast"], CloudMessageType::Gcm);
        $result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], $_POST["dailyforecast"], CloudMessageType::Fcm);
    
    } catch (Exception $ex) {
        $result .= " exception sendGCMMessage:".$ex->getMessage();
    }
    
    try{
        $result .= sendAPNMessage($msgSpecial, $title, $picture_url, "alerts.php", $_POST["short_range"], $_POST["long_range"], $_POST["tip"], $_POST["dailyforecast"]);
    } 
    catch (Exception $ex) {
        $result .= " exception sendAPNMessage:".$ex->getMessage();
    }
    
    try {
        if  ($_POST["email"]=="1"){
        if (empty($_POST['title1']))
        $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
        else {
        $EmailSubject = array($title[0], $title[1]);
        }
        }
        //$result .= send_Email(array($_POST['message0']." ".$img_tag, $_POST['message1']." ".$img_tag), ALL, EMAIL_ADDRESS, "", "", $EmailSubject);
    } 
    catch (Exception $ex) {
       $result .= " exception send_Email:".$ex->getMessage();
    }
    
    try {
        
         $msgToBuffer = $msgSpecial[1]." ".$picture_url;
         if (strlen($title[1]) > 0) {$msgToBuffer = $title[1].": ".$msgToBuffer;}
         if ($_POST["tip"]=="true")
	        $result .= post_to_bufferApp($msgToBuffer, $picture_url); 
    } 
    catch (Exception $ex) {
        $result .= " exception post_to_bufferApp:".$ex->getMessage();
    }
       
    try{
    //   $result = cleanInvalidAPNTokens();
    } catch (Exception $ex) {
        $result .= " exception sendAPNMessage:".$ex->getMessage();
    }
    print_r($result);
?>

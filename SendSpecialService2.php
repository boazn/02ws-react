<?
ini_set("display_errors","On");
include ("include.php");
include "start.php";
include ("lang.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
class CloudMessageType {

    const Gcm = 1;
    const Fcm = 2;
}
/*******************************************************************************************/


function getFirstForecastDay()
{
    $query = "select * FROM forecast_days order by idx";
    $result = db_init($query, "");
    $first_day = array();$idx = 0; 
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        $idx++;
        if ($idx == 1)
            {
                $lang_idx=0;
                $first_day0 = $line["day_name"]." ".$line["date"].": ".$line["TempLow"].", ".$line["TempHigh"].", ".getClothName($line["TempHighCloth"]).", ".$line["TempNight"].", ".getClothName($line["TempNightCloth"]).", ".$line["lang0"];
                $lang_idx=1;
                $first_day1 = $line["day_name"]." ".$line["date"].": ".$line["TempLow"].", ".$line["TempHigh"].", ".getClothName($line["TempHighCloth"])." ".$line["TempNight"].", ".getClothName($line["TempNightCloth"]).", ".$line["lang1"]; 
                $first_day = array($first_day0, $first_day1);
                $first_day = array("test", "test");
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
        $now = replaceDays(date('D j/m/y H:i'));
        $append = true;
        if ($append)
        {

            $res = db_init("SELECT * FROM  `content_sections` WHERE (TYPE =  'forecast') and (lang=?)", $lang);
            while ($line = mysqli_fetch_array($res["result"], MYSQLI_ASSOC) ){
                $description = "<div class=\"alerttime\">".$now."</div>".$description."</br>".$line["Description"];
            }
        }

        //$now = getLocalTime(time());

        $query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}'  WHERE (type='$type') and (lang=$lang)";
        apc_store('descriptionforecast'.$lang, $description);
        $res = db_init($query, "" );
        // Free resultset 
        @mysqli_free_result($res);
    }
    catch (Exception $ex) {
        $result .= " exception:".$ex->getMessage();
    }   
	
}
$empty = $post = array();
foreach ($_REQUEST as $varname => $varvalue) {
   if (empty($varvalue)) {
       $empty[$varname] = $varvalue;
   } else {
       $post[$varname] = $varvalue;
   }
}
if (empty($empty)) {
   print "None of the POSTed values are empty, posted:\n";
   var_dump($post);
} else {
   $result .= "We have " . count($empty) . " empty values\n";
   $result .= "Posted:\n"; var_dump($post);
   $result .= "Empty:\n";  var_dump($empty);
   
}
    $result = "";
    $msgSent = true;
    $name = array($_REQUEST['name0'], $_REQUEST['name1']);
    $email = $_REQUEST['email'];
    $message = array($_REQUEST['message0'], $_REQUEST['message1']);
    $msgSpecial = array($_REQUEST['message0'], $_REQUEST['message1']);
    
    $title = array($_REQUEST['title0'], $_REQUEST['title1']);
    $picture_url = $_REQUEST['picture_url'];
    $embedded_url = $_REQUEST['embedded_url'];
        
    if (empty($picture_url))
        $img_tag = "";
    else
        $img_tag = " <img src=\"".$picture_url."\" id=\"alert_image\" alt=\"alert image\" />";
    
    

    try{
        $msgToAlertSection = array($message[0]."<br />".$img_tag, $message[1]."<br />".$img_tag);
        if (strlen($title[0]) > 0){
            $msgToAlertSection[0] = $title[0].": ".$msgToAlertSection[0];
            $msgToAlertSection[1] = $title[1].": ".$msgToAlertSection[1];
        }
        /*if (boolval($_REQUEST["short_range"])){
            $msgToAlertSection[0] = $msgToAlertSection[0]."<br />".$ALERTS_PAYMENT[0]." ".$PATREON_LINK[0];
            $msgToAlertSection[1] = $msgToAlertSection[1]."<br />".$ALERTS_PAYMENT[1]." ".$PATREON_LINK[1];
        }*/
        if  (!empty($_REQUEST["alert_section"])){
         //   updateMessageFromMessages ($msgToAlertSection[0], 1, 'forecast', 0 ,'' ,'','');
         //   updateMessageFromMessages ($msgToAlertSection[1], 1, 'forecast', 1 ,'' ,'','');
        }
       
    } 
    catch (Exception $ex) {
        $result .= " exception updateMessageFromMessages:".$ex->getMessage();
    }
    
    try{
        //$result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_REQUEST["short_range"], $_REQUEST["long_range"], $_REQUEST["tip"]);   
      //  $result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_REQUEST["short_range"], $_REQUEST["long_range"], $_REQUEST["tip"], CloudMessageType::Gcm, $_REQUEST["daily_forecast"]);
     //   $result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_REQUEST["short_range"], $_REQUEST["long_range"], $_REQUEST["tip"], CloudMessageType::Fcm, $_REQUEST["daily_forecast"]);
    
    } catch (Exception $ex) {
        $result .= " exception sendGCMMessage:".$ex->getMessage();
    }
    
    try{
     //   $result .= sendAPNMessage($msgSpecial, $title, $picture_url, "alerts.php", $_REQUEST["short_range"], $_REQUEST["long_range"], $_REQUEST["tip"], $_REQUEST["daily_forecast"]);
    } 
    catch (Exception $ex) {
        $result .= " exception sendAPNMessage:".$ex->getMessage();
    }
    
    try {
        if  ($_REQUEST["email"] != ""){
            if (empty($_REQUEST['title1']))
            $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
            else {
            $EmailSubject = array($title[0], $title[1]);
            }
        }
        $result .= send_Email(array($_REQUEST['message0']." ".$img_tag, $_REQUEST['message1']." ".$img_tag), HS, EMAIL_ADDRESS, "", "", $EmailSubject);
    } 
    catch (Exception $ex) {
       $result .= " exception send_Email:".$ex->getMessage();
    }
    
    try {
        if  ($_REQUEST["buffer"] != ""){
         $msgToBuffer = $msgSpecial[1]." ".$picture_url;
         if (strlen($title[1]) > 0) {$msgToBuffer = $title[1].": ".$msgToBuffer;}
      //  $result .= post_to_bufferApp($msgToBuffer, $picture_url);
        } 
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

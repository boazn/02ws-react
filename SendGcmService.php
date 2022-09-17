<?
ini_set("display_errors","On");
include ("include.php");
include ("lang.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
class CloudMessageType {

    const Gcm = 1;
    const Fcm = 2;
}
/*******************************************************************************************/


function sendGCMMessage($messageBody, $title, $picture_url, $embedded_url, $short_range, $long_range, $tip, $CloudMessageType)
{
    global $TIP;
    
    $registrationIDs0 = array();
    $registrationIDs1 = array();
    $lines = 0;
    $short_range = ($short_range === 'true');
    $long_range = ($long_range === 'true');
    $tip = ($tip === 'true');
    if (boolval($tip)){
        $messageBody[0] = $TIP[0].": ".$messageBody[0];
        $messageBody[1] = $TIP[1].": ".$messageBody[1];
    }
    $messageBody[0] = date('H:i')." ".$messageBody[0];
    $messageBody[1] = date('H:i')." ".$messageBody[1];
    
    $key = FCM_API_KEY;
    $query_extension = "";
    
    if ((boolval($long_range))&&(boolval($short_range))){
        $result = db_init("select * FROM fcm_users where active=1 or active_rain_etc=1".$query_extension, "");
    }
    else if (boolval($long_range)){
        $result = db_init("select * FROM fcm_users where active=1".$query_extension, "");
    }
    else if (boolval($short_range)){
        $result = db_init("select * FROM fcm_users where active_rain_etc=1".$query_extension, "");
    }
    else if (boolval($tip)){
        $result = db_init("select * FROM fcm_users where active_tips=1".$query_extension, "");
    }
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
	$lines++;
        //echo "<br />".$line["gcm_regid"]."<br />";
        if ($line["lang"] == 0)
            array_push ($registrationIDs0, $line["gcm_regid"]);
        elseif ($line["lang"] == 1)
            array_push ($registrationIDs1, $line["gcm_regid"]);
    }
    
    logger(" short_range=".$short_range." long_range=".$long_range, 0, "FCM", "sendingGCMMessage", "sendingGCMMessage");
    
     
    /* test */
   
    $registrationIDs = array();
    $registrationIDs0 = array();
    $registrationIDs1 = array();
    
	 //test boazn1@gmail.com
	 // test efrat
     //    if ($CloudMessageType == CloudMessageType::Fcm)
                                            
        //    array_push ($registrationIDs1, "evd817pyPEQ:APA91bFnYtfu--Y3WwDec_KkNV_Xw76suJ67z2cjZUBR5ZICNetjx_vqWmNYr3DaT4qIRSMwcO7qe6rqEjGVUubIWp5IeVtOFnUwYdbVMT0YMUVBnDo3H6Hnh-EFS_SFd3Z1pMIurNgw");
      //   else
      //      array_push ($registrationIDs1, "d2Y_RLBmKGM:APA91bHCtyGWSLtRYdCW6E0RYCkHEBScvzkcVS5zza88k7RXnyelE9_HJ2shxjJKIJUl1Rw-LJg-rCFCK_RvndH0CP3coto3Ld9bPGcAN5ntj9SLlTYybkDYPwHqc8hDysXT2a4f7u_p");
         
     //
     array_push ($registrationIDs1, "cKbcV13UTLGh3M0nDlSjch:APA91bH3aGoeHh10EkcGbuYJIk-1N27k1VkyFqYR0qRPAgDKvy8zaYEwqMAu02vTKciQEO6zX_7QzQkVVLUp3mUD29CjJ7Y2aDGUTKoKGAnfT1SZdxEfWsEJjo1EkaUN4v--d8Y17ELs");
     array_push ($registrationIDs1, $_REQUEST["reg_id"]);    
     logger("sendingGCMMessage CloudMessageType=".$CloudMessageType.": En:".count($registrationIDs0)." Heb:".count($registrationIDs1), 0, "FCM", "sendingGCMMessage", "sendingGCMMessage");
     $result = "";
     $resultCall = array();
     $arrOfRegID0 = array_chunk($registrationIDs0, 1000);
     foreach ($arrOfRegID0 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[0], $title[0], $picture_url, $embedded_url);
        print_r($resultCall[1]);
        handleInvalidTokens($resultCall[1], $regIDs, $key);
      }
    
     $arrOfRegID1 = array_chunk($registrationIDs1, 1000);
     foreach ($arrOfRegID1 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[1], $title[1], $picture_url, $embedded_url);
        print_r($resultCall[1]);
        handleInvalidTokens($resultCall[1], $regIDs, $key);
     }
    
     
     
     //logger($result);
    return "";        
}
function updateMessageFromMessages ($description, $active, $type, $lang, $href, $img_src, $title)
{
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
                $description = $line["Description"]."<div class=\"alerttime\">".$now."</div>".$description;
            }
        }

        //$now = getLocalTime(time());

        $query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}'  WHERE (type='$type') and (lang=$lang)";
       // apc_store('descriptionforecast'.$lang, $description);
        $res = db_init($query, "" );
        // Free resultset 
        @mysqli_free_result($res);
    }
    catch (Exception $ex) {
      //  $result .= " exception:".$ex->getMessage();
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
   $result .= "We have " . count($empty) . " empty values\n";
   $result .= "Posted:\n"; var_dump($post);
   $result .= "Empty:\n";  var_dump($empty);
   
}
    $result = "";
    $msgSent = true;
    $name = array($_POST['name0'], $_POST['name1']);
    $email = $_POST['email'];
    $message = array($_POST['message0'], $_POST['message1']);
    $msgSpecial = array($_POST['message0'], $_POST['message1']);
    
    $title = array($_POST['title0'], $_POST['title1']);
    $picture_url = $_POST['picture_url'];
    $embedded_url = $_POST['embedded_url'];
    if ($msgSpecial == ""){
        $result = "Empty Message";
        echo $result;
        exit;
    }
    
    if (empty($picture_url))
        $img_tag = "";
    else
        $img_tag = " <img src=\"".$picture_url."\" id=\"alert_image\" alt=\"alert image\" />";
    
    try{
 //   updateMessageFromMessages ($title[0]." - ".$message[0]."<br />".$img_tag, 1, 'forecast', 0 ,'' ,'','');
 //    updateMessageFromMessages ($title[1]." - ".$message[1]."<br />".$img_tag, 1, 'forecast', 1 ,'' ,'','');
    } 
    catch (Exception $ex) {
        $result .= " exception updateMessageFromMessages:".$ex->getMessage();
    }
    
    try{
         //$result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], CloudMessageType::Gcm);
         $result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], CloudMessageType::Fcm);
    } catch (Exception $ex) {
        $result .= " exception sendGCMMessage:".$ex->getMessage();
    }
   
    
    try {
        if (empty($_POST['title1']))
        $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
        else {
        $EmailSubject = array($title[0], $title[1]);
        }
//        $result .= send_Email(array($_POST['message0']." ".$img_tag, $_POST['message1']." ".$img_tag), ALL, EMAIL_ADDRESS, "", "", $EmailSubject);
    } 
    catch (Exception $ex) {
       $result .= " exception send_Email:".$ex->getMessage();
    }
    
    try {
//	 $result .= post_to_bufferApp($title[1]." - ".$msgSpecial[1]." ".$picture_url, $picture_url); 
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

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
      //      array_push ($registrationIDs1, "fgI8C6OaSCiDzZm5r1W8vj:APA91bFdPevwP4fBuexfvGgJbUhycxKl7sUQsz3PcKZDk7cYf2zpA1z1nYX-QssATz7njbFIaC7orMqcov1WQsrfM9DKF0m9AjAe1uy-rGRGIG93Zlg8mmh3pkZDB94pXHg953QTePXx");
         
     //
     array_push ($registrationIDs1, "e4_JdCeBSdCXDxVP0aycU7:APA91bFcqJTeZJhL9-3HfO8UtwwEbM1C9F-KG4IcRcqqeWTIA8-7SxPS4Q8yjOugBLw2SLNdWv1NLnjCBtreVz9vnEfifyJOOyokJX94DpU5sqTDgCt6JhVzVPpWmdNt7aA0zBVh57vB");
     //array_push ($registrationIDs1, $_REQUEST["reg_id"]);    
     logger("sendingGCMMessage CloudMessageType=".$CloudMessageType.": En:".count($registrationIDs0)." Heb:".count($registrationIDs1), 0, "FCM", "sendingGCMMessage", "sendingGCMMessage");
     $result = "";
     $resultCall = array();
     $channelId = ($short_range == 'true') ? "short_range" : ( ($long_range == 'true') ? "long_range" : "tip");
     $arrOfRegID0 = array_chunk($registrationIDs0, 1000);
     foreach ($arrOfRegID0 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[0], $title[0], $picture_url, $embedded_url, $channelId);
        print_r($resultCall[1]);
        handleInvalidTokens($resultCall[1], $regIDs, $key);
      }
    
     $arrOfRegID1 = array_chunk($registrationIDs1, 1000);
     foreach ($arrOfRegID1 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[1], $title[1], $picture_url, $embedded_url, $channelId);
        print_r($resultCall[1]);
        handleInvalidTokens($resultCall[1], $regIDs, $key);
     }
    
     
     
     //logger($result);
    return "";        
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
    // send_push "title0" "title1" "msg0" "msg1" short_range long_range tip picture_url
    logger("sendingGCMMessage argv count:".count($argv), 0, "FCM", "sendingGCMServiceBackground", "sendingGCMServiceBackground");
    $result = "";
    $msgSent = true;
    $name = array($_POST['name0'], $_POST['name1']);
    $email = $_POST['email'];
    $message = array($_POST['message0'], $_POST['message1']);
    $msgSpecial = array($_POST['message0'], $_POST['message1']);
    $short_range = $_POST["short_range"];
    $long_range = $_POST["long_range"];
    $tip = $_POST["tip"];
    $title = array($_POST['title0'], $_POST['title1']);
    $picture_url = $_POST['picture_url'];
    $embedded_url = $_POST['embedded_url'];
    if (empty($_POST['title0']) && (!empty($argv[1])))
    {
        
        $msgSpecial = array(urldecode($argv[3]), urldecode($argv[4]));
        $short_range = $argv[5];
        $long_range = $argv[6];
        $tip = $argv[7];
        $title = array(urldecode($argv[1]), urldecode($argv[2]));
        $picture_url = $argv[8];
        $embedded_url = $argv[8];
        
    }
    if ($msgSpecial == ""){
        $result = "Empty Message";
        echo $result;
        exit;
    }
    var_dump($post);
    if (empty($picture_url))
        $img_tag = "";
    else
        $img_tag = " <img src=\"".$picture_url."\" id=\"alert_image\" alt=\"alert image\" />";
    
   
    try{
         //$result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], CloudMessageType::Gcm);
         $result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $short_range,  $long_range, $tip, CloudMessageType::Fcm);
    } catch (Exception $ex) {
        $result .= " exception sendGCMMessage:".$ex->getMessage();
    }
   
    
    print_r($result);
?>

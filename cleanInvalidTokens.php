<?
ini_set("display_errors","On");
include ("include.php");
include ("lang.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
/*******************************************************************************************/

function cleanInvalidAPNTokens()
{
    $result = db_init("select * FROM apn_users", "");
    $registrationIDs = array();
    $invalidregistrationIDs = array();
     while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
	  if ($line["apn_regid"] != "")
          {
             array_push ($registrationIDs, array('apn_regid' => $line["apn_regid"], 'id' => $line["id"]));
          }
    }
    logger("cleanInvalidAPNTokens : ".count($registrationIDs)." ".$message, 0, "APN", "Push", "cleanInvalidAPNTokens");
    
    $apnsHost = 'feedback.push.apple.com';
    $apnsPort = 2196;
    $apnsCert = 'CertPushProd.pem';
       
    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
    if(!$apns) {
        logger( "cleanInvalidAPNTokens stream_socket_client: ERROR $errcode: $errstr", 4, "APN", "Push", "cleanInvalidAPNTokens");
        return;
    }


    $feedback_tokens = array();
    //and read the data on the connection:
    while(!feof($apns)) {
        $data = fread($apns, 38);
        if(strlen($data)) {
            $feedback_tokens[] = unpack("N1timestamp/n1length/H*devtoken", $data);
        }
    }
    fclose($apns);
    $invalid_feedback_tokens = "";
    foreach ($feedback_tokens as $feedback_token){
        $invalid_feedback_tokens .= ",'".$feedback_token['devtoken']."'";
    }
    logger ("invalid feedback_tokens: ".$invalid_feedback_tokens, 0, "APN", "Push", "cleanInvalidAPNTokens");
    foreach ($feedback_tokens as $feedback_token){
        db_init("delete from `apn_users` WHERE apn_regid =  '{$feedback_token['devtoken']}' ", ""); 
    }
    return $feedback_tokens;
}

    
    try{
      $result = cleanInvalidAPNTokens();
    } catch (Exception $ex) {
        $result .= " exception cleanInvalidAPNTokens:".$ex->getMessage();
    }
    print_r($result);
?>

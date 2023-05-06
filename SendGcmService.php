<?
ini_set("display_errors","On");
//include_once ("include.php");
include ("lang.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
class CloudMessageType {

    const Gcm = 1;
    const Fcm = 2;
}
/*******************************************************************************************/
// send_push "title0" "title1" "msg0" "msg1" short_range long_range tip picture_url
function send_push($msgSpecial, $title, $picture_url, $embedded_url, $short_range,  $long_range, $tip) {
    // prepare the command
    $command = "php /home/boazn/public/02ws.com/public/SendGcmServiceBackground.php '".urlencode($title[0])."' '".urlencode($title[1])."' '".urlencode($msgSpecial[0])."' '".urlencode($msgSpecial[1])."' {$short_range} {$long_range} {$tip} {$picture_url} ";
    $result = "<br/>{$command}";
    // execute in shell
    //$output = shell_exec("/usr/bin/nohup {$command} >/dev/null 2>&1 &");
    $result .= $output;
    return $result;
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
        
        $msgSpecial = array($argv[3], $argv[4]);
        $short_range = $argv[5];
        $long_range = $argv[6];
        $tip = $argv[7];
        $title = array($argv[1], $argv[2]);
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
         
        $result .= send_push($msgSpecial, $title, $picture_url, $embedded_url, $short_range,  $long_range, $tip);
    } catch (Exception $ex) {
        $result .= " exception sendGCMMessage:".$ex->getMessage();
    }
   
    
    print_r($result);
?>

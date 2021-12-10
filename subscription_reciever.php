
<?php
 require_once 'include.php';
 require_once 'lang.php';
 ini_set("display_errors","On");
    ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
    $REMOVE_AD_DESC = array("Put this code in the setting menu of the app to remove the ads from 02ws: ", "את הקוד מכניסים בתוך תפריט ההגדרות של האפליקציה.    הקוד שלך להסרת הפרסומות מאפליקציית ירושמיים", "");
    $REMOVE_AD_TITLE = array("Ads removal - 02WS", "ירושמיים - הסרת פרסומות");

    function isAndroid($reg_id){
        return (strlen($reg_id) >= 152);
    }
    class DB_Functions {
 
    private $db;
 
      
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeSub($email, $status, $reg_id) {
        // insert user into database
        $email = strtolower($email);
        $approved = ($status == 1 ? 1 : 0);
        $lang_idx = $_GET['lang'];
        if (empty($lang_idx)) 
            $lang_idx = 1;
        global $REMOVE_AD_DESC, $REMOVE_AD_TITLE, $SHORT_TERM_DESC, $SHORT_TERM_TITLE; 
        global $link;
		
            				
            //$result = db_init("call SaveUserPic ('$name', '$comment', '$user', '$picname', '$x', '$y')");
            logger("StoreSub:".$email." ".$reg_id." ".$status, 0, "Subscriptions", "storeSub", "storeSub");
            $result = db_init("INSERT INTO `Subscriptions` (guid, email, approved, reg_id) VALUES(UUID_SHORT(), '$email' ,$status, '$reg_id');", "");
			// check for successful store
			// get user details
			$id = $link->insert_id; // last inserted id
			
			
         if ($result["error"] != "") {
            $db = new DB_Functions();
            //logger("New storeSub exception:".$result["error"]);
            $sub = json_decode($db->getSubFromEmail($email), true);
            $res_sub =  $db->UpdateRegId($email, $reg_id, $sub["Subscription"]["guid"], $status, true);
           
        }
        else{
            if (strlen($reg_id) == 0)
                exit; 
               
            if (isAndroid($reg_id))
                $query = "update `fcm_users` set Approved=".$approved." where gcm_regid='".$reg_id."'";
                else
                    $query = "update `apn_users` set Approved=".$approved." where apn_regid='".$reg_id."'";
                db_init($query, "") ;
                logger($query, 0, "Subscriptions", "storeSub", "storeSub");
        }
        
							

        $query = "select id, guid, email, approved from `Subscriptions` where email=?";
        $result = db_init($query, $email);
        $line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
        @mysqli_free_result($result["result"]);
        global $link;
        mysqli_close($link);
            //echo " status=".$line[0];
        $userJSON = "{\"Subscription\":";
        $userJSON .= "{";

        $userJSON .= "\"id\":"."\"".$line['index']."\"";
        $userJSON .= ",";
        $userJSON .= "\"guid\":"."\"".$line['guid']."\"";
        $userJSON .= ",";
        $userJSON .= "\"email\":"."\"".$line['email']."\"";
        $userJSON .= ",";
        $userJSON .= "\"approved\":"."\"".$line['approved']."\"";
        //logger("New sub updated:".$line['guid']." => ".$email);
       /* if ($status == 1)
            send_Email(array($REMOVE_AD_DESC[0]." <br />".$line['guid'],$REMOVE_AD_DESC[1]." <br />".$line['guid'] ), $email, EMAIL_ADDRESS, "", "",  $REMOVE_AD_TITLE);
        else if ($status == 2)
            send_Email(array($SHORT_TERM_DESC[0]." <br />".$line['guid'],$SHORT_TERM_DESC[1]." <br />".$line['guid'] ), $email, EMAIL_ADDRESS, "", "",  $SHORT_TERM_TITLE);*/
        $userJSON .= "}";
        $userJSON .= "}";
        return $userJSON;
                   
        
   
    }
    
    public function UpdateRegId($email, $reg_id, $guid, $approved, $isAdmin) {
        // insert user into database
        $guid = trim($guid);
        global $link;
		try{
							
		$link = new mysqli(MYSQL_IP, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
                
                // only update Approved if removed
                $query = "update `Subscriptions` set reg_id='".$reg_id."'  where guid=?";
                $stmt = $link->stmt_init();
                $stmt->prepare($query);
                $stmt->bind_param('s' , $guid);
                $stmt->execute();
                logger($query." ".$guid, 0, "Subscriptions", "storeSub", "UpdateRegId");
                if ($isAdmin)
                {
                    $query = "update `Subscriptions` set Approved=".$approved."  where guid='".$guid."'";
                    db_init($query, "") ;
                    logger($query, 0, "Subscriptions", "storeSub", "UpdateRegId");
                }
                $stmt->close();
                
                if ($guid!=""){
                    if (isAndroid($reg_id))
                     $query = "update `fcm_users` set Approved=".$approved." where gcm_regid='".$reg_id."'";
                    else
                        $query = "update `apn_users` set Approved=".$approved." where apn_regid='".$reg_id."'";
                    db_init($query, "") ;
                    logger($query, 0, "Subscriptions", "storeSub", "UpdateRegId");
                }
                mysqli_close($link);
                $query = "select id, guid, email, approved from `Subscriptions` where guid=?";
                $result = db_init($query, $guid);
                $line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
                @mysqli_free_result($result["result"]);
                global $link;
                mysqli_close($link);
                    //echo " status=".$line[0];
                $userJSON = "{\"Subscription\":";
                $userJSON .= "{";

                $userJSON .= "\"id\":"."\"".$line['index']."\"";
                $userJSON .= ",";
                $userJSON .= "\"guid\":"."\"".$line['guid']."\"";
                $userJSON .= ",";
                $userJSON .= "\"email\":"."\"".$line['email']."\"";
                $userJSON .= ",";
                $userJSON .= "\"approved\":"."\"".$line['approved']."\"";
                $userJSON .= "}";
                $userJSON .= "}";
                return $userJSON;
                return "affected_rows:".$link->affected_rows;
               
                
                   
        } catch (Exception $ex) {
            logger("UpdateRegId: ".$reg_id." ".$ex." "." ", 4, "Subscriptions", "storeSub", "UpdateRegId");
        }
   
    }
    
    public function isApproved($id) {
        // insert user into database
        global $link;
		try{
							
		
                $query = "select guid, email, approved from `Subscriptions` where reg_id=?";
                $result = db_init($query, $id);
                $line = mysqli_fetch_array($result["result"]);
                @mysqli_free_result($result["result"]);
                global $link;
                mysqli_close($link);
                logger("isApproved? ".$query." ".$id." ".$line['email']." approved:".$line['approved'], 0, "Subscriptions", "storeSub", "isApproved");
                    //echo " status=".$line[0];
                $userJSON = "{\"Subscription\":";
                $userJSON .= "{";

                $userJSON .= "\"id\":"."\"".$id."\"";
                $userJSON .= ",";
                $userJSON .= "\"guid\":"."\"".$line['guid']."\"";
                $userJSON .= ",";
                $userJSON .= "\"email\":"."\"".$line['email']."\"";
                $userJSON .= ",";
                $userJSON .= "\"approved\":"."\"".$line['approved']."\"";

                $userJSON .= "}";
                $userJSON .= "}";
                return $userJSON;
        } catch (Exception $ex) {
            logger("New isApproved:.".$id." ".$ex, 4, "Subscriptions", "storeSub", "isApproved");
        }
   
    }
    public function getSubFromRegId($regid) {
        // insert user into database
        
        $guid = trim($guid);
        global $link;
		try{
							
		
                $query = "select id, email, approved from `Subscriptions` where reg_id='{$regid}'";
                 
                $result = db_init($query, "");
                $line = mysqli_fetch_array($result["result"]);
                @mysqli_free_result($result["result"]);
                global $link;
                mysqli_close($link);
                    //echo " status=".$line[0];
                //$userJSON = "{\"Subscription\":";
                //$userJSON .= "{";

                $userJSON .= "\"id\":"."\"".$line['id']."\"";
                $userJSON .= ",";
                $userJSON .= "\"guid\":"."\"".$guid."\"";
                $userJSON .= ",";
                $userJSON .= "\"email\":"."\"".$line['email']."\"";
                $userJSON .= ",";
                $userJSON .= "\"approved\":"."\"".$line['approved']."\"";

                //$userJSON .= "}";
                //$userJSON .= "}";
                if ($line['id'] != "")
                    logger($regid." ".$userJSON, 0, "subscriptions", "", "getSubFromRegId");
                return $userJSON;
                
        } catch (Exception $ex) {
            logger("New getSubFromGUI:.".$gui." "." ", 0, "Subscriptions", "storeSub", "getSubFromRegId");
        }
   
    }
    public function getSubFromGUI($guid) {
        // insert user into database
        
        $guid = trim($guid);
        global $link;
		try{
							
		
                $query = "select id, email, approved from `Subscriptions` where guid='{$guid}'";
                 
                $result = db_init($query, "");
                $line = mysqli_fetch_array($result["result"]);
                @mysqli_free_result($result["result"]);
                global $link;
                mysqli_close($link);
                    //echo " status=".$line[0];
                //$userJSON = "{\"Subscription\":";
                //$userJSON .= "{";

                $userJSON .= "\"id\":"."\"".$line['id']."\"";
                $userJSON .= ",";
                $userJSON .= "\"guid\":"."\"".$guid."\"";
                $userJSON .= ",";
                $userJSON .= "\"email\":"."\"".$line['email']."\"";
                $userJSON .= ",";
                $userJSON .= "\"approved\":"."\"".$line['approved']."\"";

                //$userJSON .= "}";
                //$userJSON .= "}";
                //logger($userJSON);
                return $userJSON;
                
        } catch (Exception $ex) {
            logger("New getSubFromGUI:.".$gui." "." ", 0, "Subscriptions", "storeSub", "getSubFromGUI");
        }
   
    }

    public function getSubFromEmail($email) {
        // insert user into database
        
        $guid = trim($guid);
        global $link;
		try{
							
		
                $query = "select id, reg_id, email, guid, approved from `Subscriptions` where email='{$email}'";
                 
                $result = db_init($query, "");
                $line = mysqli_fetch_array($result["result"]);
                @mysqli_free_result($result["result"]);
                global $link;
                mysqli_close($link);
                    //echo " status=".$line[0];
                $userJSON = "{\"Subscription\":";
                $userJSON .= "{";

                $userJSON .= "\"id\":"."\"".$line['id']."\"";
                $userJSON .= ",";
                $userJSON .= "\"guid\":"."\"".$line['guid']."\"";
                $userJSON .= ",";
                $userJSON .= "\"reg_id\":"."\"".$line['reg_id']."\"";
                $userJSON .= ",";
                $userJSON .= "\"email\":"."\"".$line['email']."\"";
                $userJSON .= ",";
                $userJSON .= "\"approved\":"."\"".$line['approved']."\"";

                $userJSON .= "}";
                $userJSON .= "}";
                //logger($userJSON);
                return $userJSON;
                
        } catch (Exception $ex) {
            logger("New getSubFromGUI:.".$gui." "." ", 4, "Subscriptions", "storeSub", "getSubFromEmail");
        }
   
    }
 
 
  
 
}

// response json
$json = array();
 
/**
 * Registering a user device
 * Store reg id in users table
 */
$db = new DB_Functions();
if ($_REQUEST['action']=="isapproved"){
    $res_sub = $db->isApproved($_REQUEST["id"]);
    echo ($res_sub);
}
else if ($_REQUEST['action']=="getsubfromgui"){
    $res_sub = $db->getSubFromGUI($_REQUEST["guid"]);
    //echo ($res_sub);
}
else if ($_REQUEST['action']=="getsubfromregid"){
    $res_sub = $db->getSubFromRegId($_REQUEST["reg_id"]);
    //if (!empty($_SESSION['email'])) 
    //logger ($res_sub);
}
else if ($_REQUEST['action']=="storeSub"){
    $res_sub = $db->storeSub($_REQUEST["email"], $_REQUEST["status"], $_REQUEST["reg_id"]);
    echo ($res_sub);
}
else if ($_REQUEST['action']=="storeSubAlert"){
    $res_sub = $db->storeSub($_REQUEST["email"], 2, $_REQUEST["reg_id"]);
    echo ($res_sub);
}
else if ($_REQUEST['action']=="D"){
    $sub = json_decode($db->getSubFromEmail($_REQUEST["email"]), true);
    $res_sub =  $db->UpdateRegId($_REQUEST["email"], $sub["Subscription"]["reg_id"], $sub["Subscription"]["guid"], 0, true);
    echo ($res_sub);
}
else if ($_REQUEST['action']=="updateregid"){
    $res_sub = $db->UpdateRegId($_REQUEST["email"], $_REQUEST["regId"], $_REQUEST["guid"], 1, false);
    echo ($res_sub);
}
else {
    
	/*$res_post = "";
	foreach ($_POST as $varname => $varvalue) {
	   if (empty($varvalue)) {
		   $empty[$varname] = $varvalue;
		   $res_post=$res_post." ".$varname."=".$varvalue;
	   } else {
		   $post[$varname] = $varvalue;
		   $res_post=$res_post." ".$varname."=".$varvalue;
	   }
	}
	if (empty($empty)) {
	   print "None of the POSTed values are empty, posted:\n";
	   var_dump($post);
	   
	} else {
	   $result .= "We have " . count($empty) . " empty values\n";
	   var_dump($empty);
	   $result .= "We have " . count($post) . " posted values\n";
	   var_dump($post);
	   echo $result;
	   
	}

    logger( "subscription_reciever: user details is missing; ".$res_post);*/
?>
<input id="email" name="email" size="3"  value=""  onclick="" style="width:180px"/>
<img src="images/x.png" width="16px" onclick="getOneUFService('D')" style="cursor:pointer" />
<img src="images/check.png" width="16px" onclick="getOneUFService('storeSub')" style="cursor:pointer" alt="ad"/>ads
<img src="images/plus.png" width="16px" onclick="getOneUFService('storeSubAlert')" style="cursor:pointer" alt="short term alerts"/>alerts
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script language="javascript">
function getOneUFService(command)
{
    var email = $('#email').val();
   $.ajax({
        type: "POST",
        url: "subscription_reciever.php",
        data: {email:email,action:command,status:1},
   }).done(function(str){alert(str);});
}

</script>
    <?
}
?>


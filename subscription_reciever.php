
<?php
 require_once 'include.php';
 ini_set("display_errors","On");
    ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
    $REMOVE_AD_DESC = array("Put this code in the setting menu of the app to remove the ads from 02ws: ", "את הקוד מכניסים בתוך תפריט ההגדרות של האפליקציה.    הקוד שלך להסרת הפרסומות מאפליקציית ירושמיים", "");
    $REMOVE_AD_TITLE = array("Ads removal - 02WS", "ירושמיים - הסרת פרסומות");
class DB_Functions {
 
    private $db;
 
      
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeSub($email) {
        // insert user into database
        $email = strtolower($email);
        $lang_idx = $_GET['lang'];
        if (empty($lang_idx)) 
            $lang_idx = 1;
        global $REMOVE_AD_DESC, $REMOVE_AD_TITLE; 
        global $link;
		try{
							
			//$result = db_init("call SaveUserPic ('$name', '$comment', '$user', '$picname', '$x', '$y')");
                        $result = db_init("INSERT INTO `Subscriptions` (guid, email, approved) VALUES(UUID_SHORT(), ? ,1);", $email);
			// check for successful store
			// get user details
			$id = $link->insert_id; // last inserted id
			
			
        } catch (Exception $ex) {
            logger("New storeSub exception:.".$gui." ".$email." ".$ex);
        }
        try{
							
		
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
                logger("New sub updated:".$line['guid']." => ".$email);
                send_Email(array($REMOVE_AD_DESC[0]." <br />".$line['guid'],$REMOVE_AD_DESC[1]." <br />".$line['guid'] ), $email, EMAIL_ADDRESS, "", "",  $REMOVE_AD_TITLE);
                $userJSON .= "}";
                $userJSON .= "}";
                return $userJSON;
                   
        } catch (Exception $ex) {
            logger("New isApproved:.".$id." ".$ex);
        }
   
    }
    
    public function UpdateRegId($reg_id, $guid) {
        // insert user into database
        $guid = trim($guid);
        global $link;
		try{
							
		$link = new mysqli(MYSQL_IP, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
                
                
                $query = "update `Subscriptions` set reg_id=? where guid=?";
                $stmt = $link->stmt_init();
                $stmt->prepare($query);
                $stmt->bind_param('ss' ,$reg_id, $guid);
                $stmt->execute();
                $stmt->close();
                logger($query." ".$guid." ".$reg_id);
                
                mysqli_close($link);
                if($link->affected_rows==1)
                    return "OK";
                else
                    return "NOT OK";
                   
        } catch (Exception $ex) {
            logger("UpdateRegId: ".$reg_id." ".$ex." "." ");
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
                logger($query." ".$id." ".$line['email']." approved:".$line['approved']);
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
            logger("New isApproved:.".$id." ".$ex);
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
                //logger($userJSON);
                return $userJSON;
                
        } catch (Exception $ex) {
            logger("New getSubFromGUI:.".$gui." "." ");
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
            logger("New getSubFromGUI:.".$gui." "." ");
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
    if (!empty($_SESSION['email'])) 
    logger ($res_sub);
}
else if ($_REQUEST['action']=="storeSub"){
    $res_sub = $db->storeSub($_REQUEST["email"]);
    echo ($res_sub);
}
else if ($_REQUEST['action']=="updateregid"){
    $res_sub = $db->UpdateRegId($_REQUEST["regId"], $_REQUEST["guid"]);
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
}
?>

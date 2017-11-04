
<?php
 require_once 'include.php';
class DB_Functions {
 
    private $db;
 
      
 
    /**
     * Storing new user
     * returns user details
     */
    public function storePic($name, $pic_data, $comment, $user, $picname, $x, $y, $base64, $reg_id) {
        // insert user into database
        global $link;
		try{
			$file_path = "images/userpic/";
     
			$file_path = $file_path .$picname;
                        if ($base64 == 1){
                            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST["pic"]));
                            file_put_contents($file_path, $data);
                        }
                         else
                            move_uploaded_file($_FILES['pic']['tmp_name'], $file_path);
				
			//$result = db_init("call SaveUserPic ('$name', '$comment', '$user', '$picname', '$x', '$y')");
                        $result = db_init("INSERT INTO `UserPicture` (name, comment, approved, uploadedAt, User, x, y, picname, reg_id) VALUES('$name', '$comment', 0, SYSDATE(), '$user', '$x', '$y', '$picname', '$reg_id');");
			// check for successful store
			// get user details
			$id = $link->insert_id; // last inserted id
			logger("New pic user updated:".$id." ".$name." ".$comment." ".$user." ".$picname." ".$x." ".$y);
                        send_Email("New pic user updated:".$id." ".$name." ".$comment." ".$user." ".$picname." ".$x." ".$y." <a href=\"http://www.02ws.co.il/station.php?section=userPicsManager.php\">click here</a> ", ME, $email, $email, "", array('New pic user updated', 'תמונה חדשה נשלחה'));
			return $result;
        } catch (Exception $ex) {
            logger("New storePic exception:.".$name." ".$comment." ");
        }
   
    }
 
  
 
}

// response json
$json = array();
 
/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($_FILES["pic"])||isset($_POST["pic"])) {
    $name = $_POST["name"];
    $picname = $_POST["picname"];
    $x = $_POST["x"];
    $y = $_POST["y"];
    $base64 = $_POST["base64"];
    $user = $_POST["user"];
    $reg_id = $_POST["reg_id"];
    $comment = $_POST["comment"]; // GCM Registration ID
    $db = new DB_Functions();
    $res = $db->storePic($name, $pic, $comment, $user, $picname, $x, $y, $base64, $reg_id);
    echo ($res);
} else {
    
	$res_post = "";
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

	logger( "user_picture_reciever: user details is missing; ".$res_post);
}
?>

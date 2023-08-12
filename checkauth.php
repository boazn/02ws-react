<?
//ini_set("display_errors","On");
include ("include.php");
include ("lang.php");
session_start();


function get_user_from_email($email){
    $query = "select user_login, u_pswd, user_status, display_name, user_rememberme, user_nicename, user_icon, priority, locked, admin, MsgCount, MsgStart, classification, PersonalColdMeter, SeasonPref, VoteCount  from users where email=?";
    $result = db_init($query, $email);
    $line = mysqli_fetch_array($result["result"]);
    $_SESSION['isAdmin'] = $line['admin'];
    return $line;
}
function getAdFreeSection() {
    if (($_GET['reg_id'] != "")&&($_GET['reg_id'] != "null")) {
        if (!empty($_SESSION['email']))
            logger ("getAdFreeSection: ".$_GET['qs']." reg_id=".$_GET['reg_id']." email:".$_SESSION['email'], 0, "auth", "db", "getAdFreeSection");
        $_REQUEST['action']="getsubfromregid";
        $_REQUEST["reg_id"] = $_GET['reg_id'];
        include 'subscription_reciever.php';
        return $res_sub;
    }
	else
		return "\"\":\"\"";
}
function get_user(){
    global $user_locked, $session, $cookie;
    $rememberme = empty($_REQUEST['rememberme']) ? $_COOKIE['rememberme'] : $_REQUEST['rememberme'];
    $locked_value = "false";
    //logger($_SESSION['email']." ".$_COOKIE['rememberme']);
    $userJSON = "{\"user\":";
     if (!empty($_SESSION['email']) && is_valid_email($_SESSION['email'])) {
        // This means both the session file exists and contains a valid userid in the database.
        // So the user is authenticated and we can proceed as normal.
        /*
           Handle authenticated procedures here...
        */
        $line = get_user_from_email($_SESSION['email']);
        //logger( $_SESSION['email']." authenticated with Session: "."\"display\":"."\"".$line['display_name']."\""." \"nicename\":"."\"".$line['user_nicename']."\""." \"priority\":".$line['priority']." \"admin\":".$line['admin']);
        $_SESSION['loggedin'] = "true";
    }
    else if (!empty($_GET['email'])){
        $line = get_user_from_email($_GET['email']);
        //logger( $_GET['email']." authenticated with _GET: "."\"display\":"."\"".$line['display_name']."\""." \"nicename\":"."\"".$line['user_nicename']."\""." \"priority\":".$line['priority']." \"admin\":".$line['admin']);
        $_SESSION['loggedin'] = "true";
    }
    else {
        // This means the session file doesn't exist, is empty, or there is no valid userid
        // This is where we will check for a 'rememberme' cookie if one exists
        if (!empty($rememberme)) {
            // The user has a valid rememberme cookie and the token matches a user in the database
            /* The session is already started so just generate the session data accordingly as if the user has already authenticated */
            $line = get_user_from_key($rememberme);
            if (!empty($line[0])&&($line[0]==1))
            {
                $_SESSION['loggedin'] = "true";
                $_SESSION['email'] = $line['email'];
                //logger( $_SESSION['email']." authenticated with cookie {$_COOKIE['rememberme']}: "."\"display\":"."\"".$line['display_name']."\""." \"nicename\":"."\"".$line['user_nicename']."\""." \"priority\":".$line['priority']." \"admin\":".$line['admin']);
	        }
            else
                $_SESSION['loggedin'] = "false";
        } else 
           $_SESSION['loggedin'] = "false";
          
    }
    if ($user_locked)
        $_SESSION['loggedin'] = "false";
    
    
    $userJSON .= "{";
    $userJSON .= "\"loggedin\":".$_SESSION['loggedin'];
    $userJSON .= ",";
    if ((empty($user_locked))||($user_locked == 0))
        $userJSON .= "\"locked\":false";
    else
        $userJSON .= "\"locked\":true";
    
   
    if ($_SESSION['loggedin'] == "true")
    {
        if ($line['PersonalColdMeter'] != $_COOKIE[PERSONAL_COLD_METER])
        setcookie(PERSONAL_COLD_METER, $line['PersonalColdMeter'], time()+3600*24*360);
            $_SESSION['isAdmin'] = $line['admin'];
            $_SESSION['user_icon'] = $line['user_icon'];
            $_SESSION['MsgCount'] = $line['MsgCount'];
            $_SESSION['MsgStart'] = $line['MsgStart'];
            $userJSON .= ",";
            $userJSON .= "\"display\":"."\"".str_replace("\\", "", $line['display_name'])."\"";
            $userJSON .= ",";
            $userJSON .= "\"nicename\":"."\"".$line['user_nicename']."\"";
            $userJSON .= ",";
            $userJSON .= "\"icon\":"."\"".$line['user_icon']."\"";
	    $userJSON .= ",";
            $userJSON .= "\"priority\":".$line['priority'];
            $userJSON .= ",";
            $userJSON .= "\"login\":"."\"".$line['user_login']."\"";
            $userJSON .= ",";
            $userJSON .= "\"email\":"."\"".$_SESSION['email']."\"";
            $userJSON .= ",";
            $userJSON .= "\"admin\":".$line['admin'];
            $userJSON .= ",";
            $userJSON .= "\"MsgCount\":".$line['MsgCount'];
            $userJSON .= ",";
            $userJSON .= "\"MsgStart\":".$line['MsgStart'];
            $userJSON .= ",";
            $userJSON .= "\"clss\":".$line['classification'];
            $userJSON .= ",";
            $userJSON .= "\"PersonalColdMeter\":".$line['PersonalColdMeter'];
            $userJSON .= ",";
            $userJSON .= "\"voteCount\":".$line['VoteCount'];
            
            //logger("get_user: ".$_SESSION['email']." ".$_SESSION['loggedin']." ".$_COOKIE[PERSONAL_COLD_METER]." ".$_COOKIE['rememberme']);
    }
    $userJSON .= ",";
    $userJSON .= getAdFreeSection();
    $userJSON .= "}";
    $userJSON .= "}";
    //logger($userJSON);
    echo $userJSON;
    
 }
function is_valid_userid($user){
   
    $result = db_init("select user_status from users where user_login=?", $user);
    $line = mysqli_fetch_row($result);
    @mysqli_free_result($result);
    global $link;
    mysqli_close($link);
    if (!empty($line[0])&&($line[0]==1))
        return true;
    return false;
}
function is_valid_email($email){
    global $user_locked;
    $email = strtolower($email);
    $query = "select user_status, locked from users where lower(email)=?";
    $result = db_init($query, $email);
    $line = mysqli_fetch_row($result["result"]);
    @mysqli_free_result($result["result"]);
    global $link;
    mysqli_close($link);
	//echo " status=".$line[0];
    if ($line[1] > 0) $user_locked = true;
    if (($line[0]==1)&&($line[1]==0))
        return true;
    return false;
}
function get_user_from_key($key){
    $result = db_init("select user_status, u_pswd, display_name, user_nicename, user_icon, priority, locked, admin, email, MsgCount, MsgStart, classification, PersonalColdMeter, SeasonPref, VoteCount from users where user_rememberme='$key'", "");
    $line = mysqli_fetch_array($result["result"]);
    @mysqli_free_result($result["result"]);
    global $link;
    mysqli_close($link);
    return $line;
}

function is_valid_rememberme_cookie($key){
    $line = get_user_from_key($key);
	
    if (!empty($line[0])&&($line[0]==1))
        return true;
    return false;
}
function get_userid_from_key($key){
   $line = get_user_from_key($key); 
   if (!empty($line[1]))
       return $line[1];
   return null;
}
function user_wants_to_register($email, $user, $pass, $user_nice_name, $user_display_name, $user_icon, $reg_id){
    // if is checked "remember me" when registaring
    global $CLICK_TO_CONFIRM, $lang_idx, $REGISTRATION_TO_02WS;
    $email = strtolower($email);
    
    $key = base64_encode(random_bytes(20)); // 
    $link = new mysqli(MYSQL_IP, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
    $link->query("SET NAMES utf8;");
    $email = $link->real_escape_string ($email);
    $user = $link->real_escape_string ($user);
    $pass = $link->real_escape_string ($pass);
    $user_nice_name = $link->real_escape_string ($user_nice_name);
    $user_display_name = $link->real_escape_string ($user_display_name);
    $query = "call saveUser ('$email','$user', '$pass', '$user_nice_name', '$key', '$user_display_name', '$user_icon', '$reg_id')";
    $link->query($query);
    
    if($link->affected_rows==1)
    {
      // now send_email with activation code
        $key = urlencode($key);
        $href="https://www.02ws.co.il/regConfirm.php?k=$key&email=$email&user=$user&lang=$lang_idx&reg_id=$reg_id";
        send_Email("<br /><br /><br /><h1><a href=\"$href\" >".$CLICK_TO_CONFIRM[$lang_idx]."</a></h1><br /><br /><br />", $email, EMAIL_ADDRESS, ""  , "", array($REGISTRATION_TO_02WS[$lang_idx],$REGISTRATION_TO_02WS[$lang_idx]));
        echo "0";
    }
    else
        echo "error: ".$link->errno." ".$link->error; 
    
}
function user_wants_to_update_profile($email, $pass, $user_nice_name, $user_display_name, $user_icon, $priority, $personal_coldmeter){
    $email = strtolower($email);
    $link = new mysqli(MYSQL_IP, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
    $link->query("SET NAMES utf8;");
    $email = $link->real_escape_string ($email);
    $user_nice_name = $link->real_escape_string ($user_nice_name);
    $user_display_name = $link->real_escape_string ($user_display_name);
    $query = "update users set u_pswd=?, user_nicename=?, display_name=?, user_icon=?, priority=?, PersonalColdMeter=?  where LOWER(email)=?";
    setcookie(PERSONAL_COLD_METER, $personal_coldmeter, time()+3600*24*360); // Set the cookie to expire after 360 days
    //echo $query;
     $stmt = $link->stmt_init();
     $stmt->prepare($query);
     $stmt->bind_param('ssssdds' , $pass, $user_nice_name, $user_display_name, $user_icon, $priority, $personal_coldmeter, $email);
    $stmt->execute();
          
    if($stmt->affected_rows==1)
    {
    	echo "0";
        logger("user_wants_to_update_profile: succeed ".$email." ".$user_nice_name." ".$user_display_name." ".$user_icon." ".$personal_coldmeter, 0, "auth", "db", "user_wants_to_update_profile");
    }
    else
    {
        if (mysqli_errno ($link) == 0)
        echo "0";
        else
        echo "error: ".mysqli_errno ($link).", ".mysqli_error ($link); 
        logger("user_wants_to_update_profile mysqli_affected_rows=0: ".mysqli_errno ($link)." ".mysqli_error ($link).$email." ".$user_nice_name." ".$user_display_name." ".$user_icon, 0, "auth", "db", "user_wants_to_update_profile");
    }
    $stmt->close();
}
function forgot_password($email)
{
    $email = strtolower($email);
    
    global $NO_USER_EXIST, $CLICK_TO_RESET, $CHECK_EMAIL_RESET_PASS, $lang_idx, $FORGOT_PASS, $SEND, $LOGO;
    $result = db_init("SELECT u_pswd, email FROM users WHERE lower(email) = ?", $email);
     $dbarray = $result["result"]->fetch_array(MYSQLI_ASSOC);
      if(sizeof($dbarray) < 1){
         echo $NO_USER_EXIST[$lang_idx]." ".$email;
      }
      else
      {
          $href="https://www.02ws.co.il/regConfirm.php?email=$email&lang=$lang_idx";
          send_Email("<br /><br />Hi שלום,<br /><br/><br/><br/><h2><a href=\"$href\" >".$CLICK_TO_RESET[$lang_idx]."</a></h2><br /><br />", $email, EMAIL_ADDRESS, ""  , "", array( $LOGO[$lang_idx]." - ".$FORGOT_PASS[$lang_idx], $LOGO[$lang_idx]." - ".$FORGOT_PASS[$lang_idx]));
          echo $CHECK_EMAIL_RESET_PASS[$lang_idx];
      }
}

function set_new_password($email, $pass)
{
    $email = strtolower($email);
    $link = new mysqli(MYSQL_IP, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
    $email = $link->real_escape_string ($email);
    $pass = $link->real_escape_string ($pass);
    $query = "update users set u_pswd=? where LOWER(email)=?";
    $stmt = $link->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('ss' ,$pass, $email);
    $stmt->execute();
    if($stmt->affected_rows<1){
        $stmt->close();
       logger("set_new_password affected rows = 0: ".$query, 0, "auth", "db", "set_new_password");
        if (mysqli_connect_errno ($link) == 0)
             header("location:regConfirm.php?action=done&email=".$email);
        echo "<br />reset password failed";
        echo "<br />error: ".mysqli_connect_errno ($link)." ".mysqli_error ($link); 
      }
      else
      {
          $stmt->close();
          logger($query, 0, "auth", "db", "set_new_password");
          $_SESSION['email'] = $email;
        header("location:regConfirm.php?action=done&email=".$email);
      }
}



 /**
    * confirmUserPass - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given password is the same password in the database
    * for that user. If the user doesn't exist or if the
    * passwords don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserPass($email, $password, $isrememberme){
      /* Add slashes if necessary (for query) */
     global $PROBLEM_USER_PASSWORD, $lang_idx, $link, $stmt, $NO_USER_EXIST, $CHECK_EMAIL, $cookie, $session;
     $reg_id = $_REQUEST['reg_id'];
      $email = strtolower($email);
           
        
     $dbarray = get_user_from_email($email);
          
      if(is_null($dbarray)){
          //Indicates username failure
          logger("email not found=".$email, 0, "auth", "db", "confirmUserPass");
         $userJSON = "{\"user\":";
	    $userJSON .= "{";
	   
	    $userJSON .= "\"loggedin\":false";
	    $userJSON .= ",";
	    $userJSON .= "\"display\":"."\"".$PROBLEM_USER_PASSWORD[$lang_idx]." ".$email." \"";
	    $userJSON .= ",";
            $userJSON .= "\"isrememberme\":\"".$isrememberme."\"";
	    
	    $userJSON .= "}";
	    $userJSON .= "}";
            return $userJSON;
      }
      else if ($dbarray['user_status'] == 0)
      {
           logger("email found=".$email. " user status = 0", 0, "auth", "db", "confirmUserPass");
         $userJSON = "{\"user\":";
	    $userJSON .= "{";
	   
	    $userJSON .= "\"loggedin\":false";
	    $userJSON .= ",";
	    $userJSON .= "\"display\":"."\"".$CHECK_EMAIL[$lang_idx]."\"";
	    $userJSON .= ",";
            $userJSON .= "\"isrememberme\":\"".$isrememberme."\"";
	    
	    $userJSON .= "}";
	    $userJSON .= "}";
            return $userJSON;
      }
          

      /* Retrieve password from result, strip slashes */
      
      //logger("ConfirmingUserPass: email=".$email." password=".$password." u_pswd=".$dbarray['u_pswd']);
      $dbarray['u_pswd'] = stripslashes($dbarray['u_pswd']);
      $password = stripslashes($password);
      //echo $email."<br/>".$password."<br/>".$dbarray['u_pswd']."<br/>";
      /* Validate that password is correct */
      if($password == $dbarray['u_pswd']){
         $_SESSION['email'] = $email;
	     $_SESSION['user_icon'] = $dbarray['user_icon'];
         $_SESSION['MsgCount'] = $dbarray['MsgCount'];
        $_SESSION['MsgStart'] = $dbarray['MsgStart'];
        $locked_value = ((empty($dbarray['locked']))||($dbarray['locked'] == 0)) ? false : true;
	    $userJSON = "{\"user\":";
	    $userJSON .= "{";
	    if ($locked_value)
            $userJSON .= "\"loggedin\":false";
        else{
            $userJSON .= "\"loggedin\":true";
            $_SESSION['loggedin'] = "true";
			setcookie(PERSONAL_COLD_METER, $dbarray['PersonalColdMeter'], time()+3600*24*360); // Set the cookie to expire after 360 days
			if ($isrememberme){
     			   setcookie("rememberme", $dbarray['user_rememberme'], time()+3600*24*360); // Set the cookie to expire after 360 days
            }
        }
	    $userJSON .= ",";
	    $userJSON .= "\"locked\":\"".$locked_value."\"";
	    $userJSON .= ",";
	    $userJSON .= "\"display\":"."\"".str_replace("\\", "", $dbarray['display_name'])."\"";
	    $userJSON .= ",";
        $userJSON .= "\"icon\":"."\"".$dbarray['user_icon']."\"";
	    $userJSON .= ",";
	    $userJSON .= "\"nicename\":"."\"".$dbarray['user_nicename']."\"";
	    $userJSON .= ",";
	    $userJSON .= "\"priority\":".$dbarray['priority'];
	    $userJSON .= ",";
	    $userJSON .= "\"email\":"."\"".$_SESSION['email']."\"";
	    $userJSON .= ",";
        $userJSON .= "\"MsgCount\":".$dbarray['MsgCount'];
        $userJSON .= ",";
        $userJSON .= "\"MsgStart\":".$dbarray['MsgStart'];
        $userJSON .= ",";
        $userJSON .= "\"PersonalColdMeter\":".$dbarray['PersonalColdMeter'];
        $userJSON .= ",";
        $userJSON .= "\"SeasonPref\":".$dbarray['SeasonPref'];
        $userJSON .= ",";
        $userJSON .= "\"voteCount\":".$dbarray['VoteCount'];
        $userJSON .= ",";
        $userJSON .= "\"clss\":".$dbarray['classification'];
        $userJSON .= ",";
	    $userJSON .= "\"admin\":".$dbarray['admin'];
	    $userJSON .= ",";
	    $userJSON .= "\"isrememberme\":".$isrememberme;
	    
	    $userJSON .= "}";
	    $userJSON .= "}";
        $_SESSION['isAdmin'] = $dbarray['admin'];
        $_SESSION['email'] = $email;
        logger("confirmUserPass: ".$_SESSION['email']." ".$_SESSION['loggedin']." ".$_COOKIE[PERSONAL_COLD_METER]." ".$_COOKIE['rememberme'], 0, "auth", "db", "confirmUserPass");
        
        $reg_id = $_GET['reg_id'];
        if (!empty($reg_id)){
            $result = db_init("INSERT INTO `Subscriptions` (guid, email, approved, reg_id) VALUES(UUID_SHORT(), '$email' ,0, '$reg_id');", "");
            logger("After Activation - StoreSub:".$email." ".$reg_id." 0", 0, "auth", "db", "confirmUserPass");
        }
        else
            logger("After Activation no regID:".$email." ".$reg_id." 0", 0, "auth", "db", "confirmUserPass");
            
            
        
         return $userJSON; //Success! Username and password confirmed
      }
      else{
          //Indicates password failure
            logger("email=".$email." password=".$password." u_pswd=".$dbarray['u_pswd'], 0, "auth", "db", "confirmUserPass");
         $userJSON = "{\"user\":";
	    $userJSON .= "{";
	   
	    $userJSON .= "\"loggedin\":false";
	    $userJSON .= ",";
	    $userJSON .= "\"display\":"."\"".$PROBLEM_USER_PASSWORD[$lang_idx]."\"";
	    $userJSON .= ",";
            $userJSON .= "\"isrememberme\":".$isrememberme;
	    
	    $userJSON .= "}";
	    $userJSON .= "}";
        return $userJSON;
      }
   }
   
   /**
    * confirmUserID - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given userid is the same userid in the database
    * for that user. If the user doesn't exist or if the
    * userids don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserID($username, $userid){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $result = db_init("SELECT user_login FROM users WHERE username = ?", $username);
     
      if(!$result || (mysqli_num_rows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve userid from result, strip slashes */
      $dbarray = mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
      $dbarray['user_login'] = stripslashes($dbarray['user_login']);
      $userid = stripslashes($userid);

      /* Validate that userid is correct */
      if($userid == $dbarray['user_login']){
         return 0; //Success! Username and userid confirmed
      }
      else{
         return 2; //Indicates userid invalid
      }
   }
   
   /**
    * usernameTaken - Returns true if the username has
    * been taken by another user, false otherwise.
    */
   function usernameTaken($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $result = db_init("SELECT username FROM users WHERE username = ?", $username);
      return (mysqli_num_rows($result) > 0);
   }

    function signOut(){
		$_SESSION['loggedin'] = "false";
		$_SESSION['email'] = "";
		$_SESSION['isAdmin'] = "false";
		setcookie ("rememberme", "", time() - 3600);
                setcookie(PERSONAL_COLD_METER, "", time() - 3600);
		echo 0;
		
	}
   

if ($_REQUEST['action']=="login"){

   $return = confirmUserPass(trim($_REQUEST['email']), md5($_REQUEST['password']), $_REQUEST['isrememberme'] );
   echo $return;
  
}
else if ($_REQUEST['action']=="signout"){
		signOut();
}
else if ($_REQUEST['action']=="register"){
    $email_ok = check_email_address(trim($_REQUEST['email']));
    if ($email_ok)
        user_wants_to_register(trim($_REQUEST['email']), $_POST['username'], md5($_REQUEST['password']), $_REQUEST['user_nice_name'], $_REQUEST['user_display_name'], $_REQUEST['user_icon'], $_REQUEST['reg_id']);
    else
        echo "Email not OK";
    
}
else if ($_REQUEST['action']=="forgotpass"){
    forgot_password($_REQUEST['email']);
}
else if ($_REQUEST['action']=="newpass"){
    set_new_password(trim($_REQUEST['email']), md5($_REQUEST['password']));
}
else if ($_REQUEST['action']=="getuser"){
    get_user();
}
else if ($_REQUEST['action']=="updateprofile"){
    //echo $_POST['priority'];
    user_wants_to_update_profile(trim($_REQUEST['email']), md5($_REQUEST['password']), $_REQUEST['user_nice_name'], $_REQUEST['user_display_name'], $_REQUEST['user_icon'], $_REQUEST['priority'], $_REQUEST['personal_coldmeter']);
    
}
else { echo "no action selected";}?>
 
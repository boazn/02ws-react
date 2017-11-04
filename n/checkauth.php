<?
ini_set("display_errors","On");
include ("include.php");
include ("lang.php");
$CLICK_TO_CONFIRM = array("Click here to confirm your registration to 02ws.co.il and make your user active", "הקליקו כאן כדי לאשר הרשמה לאתר ירושמיים");
$CLICK_TO_RESET = array("Click here to reset your password", "הקליקו כאן כדי לאפס ססמא לאתר ירושמיים");
$CHECK_EMAIL_RESET_PASS = array("Go to your email for password reset", "יש לגשת אל האימייל שלך כדי לבצע איפוס ססמא");
$PROBLEM_USER_PASSWORD =  array("Problem with user or password", "סיסמא לא נכונה או משתמש לא קיים");
$NO_USER_EXIST = array("No user exists with", "אין משתמש עם");

session_start();


function get_user_from_email($email){
    $query = "select user_login, user_pass, display_name, user_nicename, user_icon, priority, locked, admin  from users where email='$email'";
    $result = db_init($query);
    $line = mysqli_fetch_array($result["result"]);
    $_SESSION['isAdmin'] = $line['admin'];
    @mysqli_free_result($result);
    return $line;
}

function get_user(){
    global $user_locked;
    $userJSON = "{\"user\":";
     if (!empty($_SESSION['email']) && is_valid_email($_SESSION['email'])) {
        // This means both the session file exists and contains a valid userid in the database.
        // So the user is authenticated and we can proceed as normal.
        /*
           Handle authenticated procedures here...
        */
        $line = get_user_from_email($_SESSION['email']);
        if (!$user_locked)
            $_SESSION['loggedin'] = "true";
        else
            $_SESSION['loggedin'] = "false";
        
  
    }
    else {
        // This means the session file doesn't exist, is empty, or there is no valid userid
        // This is where we will check for a 'rememberme' cookie if one exists
        if (!empty($_COOKIE['rememberme']) && is_valid_rememberme_cookie($_COOKIE['rememberme'])) {
            // The user has a valid rememberme cookie and the token matches a user in the database
            /* The session is already started so just generate the session data accordingly as if the user has already authenticated */
            $line = get_user_from_key($_COOKIE['rememberme']);
			$_SESSION['email'] = $line['email'];
            logger( $_SESSION['email']." authenticated with cookie {$_COOKIE['rememberme']}: "."\"display\":"."\"".$line['display_name']."\""." \"nicename\":"."\"".$line['user_nicename']."\""." \"priority\":".$line['priority']." \"admin\":".$line['admin']);
			
            if (!$user_locked)
                $_SESSION['loggedin'] = "true";
            else
                $_SESSION['loggedin'] = "false";
        }else 
        { 
            $_SESSION['loggedin'] = "false";
         } 
    }
    
    $_SESSION['isAdmin'] = $line['admin'];
    $_SESSION['user_icon'] = $line['user_icon'];
    $userJSON .= "{";
    $userJSON .= "\"loggedin\":".$_SESSION['loggedin'];
    $userJSON .= ",";
    if ((empty($user_locked))||($user_locked == 0))
      $locked_value = "false";
    else
      $locked_value = "true"; 
    $userJSON .= "\"locked\":".$locked_value;
    if ($_SESSION['loggedin'] == "true")
    {
            $userJSON .= ",";
            $userJSON .= "\"display\":"."\"".$line['display_name']."\"";
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
    }
    $userJSON .= "}";
    $userJSON .= "}";
    echo $userJSON;
 }
function is_valid_userid($user){
   
    $result = db_init("select user_status from users where user_login='$user'");
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
    $query = "select user_status, locked from users where lower(email)='$email'";
    $result = db_init($query);
    $line = mysqli_fetch_row($result);
    @mysqli_free_result($result);
    global $link;
    mysqli_close($link);
	//echo " status=".$line[0];
    if ($line[1] > 0) $user_locked = true;
    if (($line[0]==1)&&($line[1]==0))
        return true;
    return false;
}
function get_user_from_key($key){
    $result = db_init("select user_status, user_pass, display_name, user_nicename, user_icon, priority, locked, admin, email from users where user_rememberme='$key'");
    $line = mysqli_fetch_array($result["result"]);
    @mysqli_free_result($result);
    global $link;
    mysqli_close($link);
    return $line;
}

function is_valid_rememberme_cookie($key){
    $line = get_user_from_key($key);
	//logger("is_valid_rememberme_cookie:".$line[0]);
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
function user_wants_to_register($email, $user, $pass, $user_nice_name, $user_display_name, $user_icon){
    // if is checked "remember me" when registaring
    global $CLICK_TO_CONFIRM, $lang_idx, $REGISTRATION_TO_02WS;
    $email = strtolower($email);
    $key = base64_encode(mcrypt_create_iv(20,MCRYPT_DEV_URANDOM)); // 
    $query = "call saveUser ('$email','$user', '$pass', '$user_nice_name', '$key', '$user_display_name', '$user_icon')";
    //echo $query;
    $result = db_init($query);
    global $link;
    if(mysqli_affected_rows($link)==1)
    {
      // now send_email with activation code
        $key = urlencode($key);
        $href="http://www.02ws.co.il/regConfirm.php?k=$key&email=$email&user=$user&lang=$lang_idx";
        send_Email("<a href=\"$href\" >".$CLICK_TO_CONFIRM[$lang_idx]."</a>.<br /><br /><br />", $email, EMAIL_ADDRESS, $REGISTRATION_TO_02WS[$lang_idx], "");
        echo "0";
    }
    else
        echo "error: ".mysqli_errno($link)." ".mysqli_error ($link); 
    
}
function user_wants_to_update_profile($email, $pass, $user_nice_name, $user_display_name, $user_icon, $priority){
    $email = strtolower($email);
    $query = "update users set user_pass='$pass', user_nicename='$user_nice_name', display_name='$user_display_name', user_icon='$user_icon', priority='$priority' where lower(email)='$email'";
    //echo $query;
    $result = db_init($query);
    global $link;
    if(mysqli_affected_rows($link)==1)
    {
    	echo "0";
      
    }
    else
    {
        if (mysqli_errno ($link) == 0)
        echo "0";
        else
        echo "error: ".mysqli_errno ($link).", ".mysqli_error ($link); 
    }
}
function forgot_password($email)
{
    $email = strtolower($email);
	 global $CLICK_TO_RESET, $CHECK_EMAIL_RESET_PASS, $lang_idx, $FORGOT_PASS;
    $result = db_init("SELECT user_pass, email FROM users WHERE lower(email) = '$email'");
      global $link;
      if(!$result || (mysqli_num_rows($result ) < 1)){
         echo $NO_USER_EXIST[$lang_idx]." ".$email;
      }
      else
      {
          /* Retrieve password from result, strip slashes */
         $dbarray = mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
         $href="http://www.02ws.co.il/regConfirm.php?email=$email&lang=$lang_idx";
          send_Email("<a href=\"$href\" >".$CLICK_TO_RESET[$lang_idx]."</a>.<br /><br />", $email, EMAIL_ADDRESS, "02ws ".$FORGOT_PASS[$lang_idx], "");
          echo $CHECK_EMAIL_RESET_PASS[$lang_idx];
      }
}

function set_new_password($email, $pass)
{
    $email = strtolower($email);
    $query = "update users set user_pass='$pass' where LOWER(email)='$email'";
    //echo $query;
   $result = db_init($query);
    global $link;
    if(mysqli_affected_rows($link)<1){
       logger("set_new_password affected rows = 0: ".$query);
        if (mysqli_connect_errno ($link) == 0)
             header("location:station.php");
        echo "<br />reset password failed";
        echo "<br />error: ".mysqli_connect_errno ($link)." ".mysqli_error ($link); 
      }
      else
      {
        header("location:station.php");
      }
}

function user_login($user_id){
     // if is checked "remember me" when registaring
    $key = base64_encode(mcrypt_create_iv(100,MCRYPT_DEV_URANDOM)); // 
    // Be sure to store the $key value in your database
    setcookie("rememberme", $key, time()+3600*24*30); // Set the cookie to expire after 30 days
    $result = db_init("update users set user_rememberme=$key where user_login=$user_id");
    @mysqli_free_result($result);
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
     
      $email = strtolower($email);
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $result = db_init("SELECT user_pass, email, display_name, user_icon, user_rememberme, user_nicename, priority, locked, admin FROM users WHERE lower(email) = '$email' and user_status=1 ");
      global $link;
      if(!$result || (mysqli_num_rows($result ) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve password from result, strip slashes */
      
      $dbarray = mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
      $dbarray['user_pass'] = stripslashes($dbarray['user_pass']);
      $password = stripslashes($password);
      //echo $email."<br/>".$password."<br/>".$dbarray['user_pass']."<br/>";
      /* Validate that password is correct */
      if($password == $dbarray['user_pass']){
         $_SESSION['email'] = $dbarray['email'];
	 $_SESSION['user_icon'] = $dbarray['user_icon'];	 
         if ((empty($dbarray['locked']))||($dbarray['locked'] == 0))
			$locked_value = "false";
	    else
			$locked_value = "true"; 
        $userJSON = "{\"user\":";
	    $userJSON .= "{";
	    if ($locked_value == "true")
	    $userJSON .= "\"loggedin\":false";
	    else
	    $userJSON .= "\"loggedin\":true";
	    $userJSON .= ",";
	    $userJSON .= "\"locked\":".$locked_value;
	    $userJSON .= ",";
	    $userJSON .= "\"display\":"."\"".$dbarray['display_name']."\"";
	    $userJSON .= ",";
            $userJSON .= "\"icon\":"."\"".$dbarray['user_icon']."\"";
	    $userJSON .= ",";
	    $userJSON .= "\"nicename\":"."\"".$dbarray['user_nicename']."\"";
	    $userJSON .= ",";
	    $userJSON .= "\"priority\":".$dbarray['priority'];
	    $userJSON .= ",";
	    $userJSON .= "\"email\":"."\"".$_SESSION['email']."\"";
	    $userJSON .= ",";
	    $userJSON .= "\"admin\":".$dbarray['admin'];
	    $userJSON .= ",";
	    $userJSON .= "\"isrememberme\":".$isrememberme;
	    
	    $userJSON .= "}";
	    $userJSON .= "}";
        if ($locked_value != "true")  {
             $_SESSION['loggedin'] = "true";
			 logger( $_SESSION['email']." authenticated: "."\"display\":"."\"".$dbarray['display_name']."\""." \"nicename\":"."\"".$dbarray['user_nicename']."\""." \"priority\":".$dbarray['priority']." \"admin\":".$dbarray['admin']);
			if ($isrememberme)
				setcookie("rememberme", $dbarray['user_rememberme'], time()+3600*24*60); // Set the cookie to expire after 60 days
		}
		$_SESSION['isAdmin'] = $dbarray['admin'];
         return $userJSON; //Success! Username and password confirmed
      }
      else{
         return 2; //Indicates password failure
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
      $result = db_init("SELECT user_login FROM users WHERE username = '$username'");
      global $link;
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
      $result = db_init("SELECT username FROM users WHERE username = '$username'");
      return (mysqli_num_rows($result) > 0);
   }

    function signOut(){
		$_SESSION['loggedin'] = "false";
		$_SESSION['email'] = "";
		$_SESSION['isAdmin'] = "false";
		setcookie ("rememberme", "", time() - 3600);
		echo 0;
		
	}
   

if ($_REQUEST['action']=="login"){

   $return = confirmUserPass($_POST['email'], md5($_POST['password']), $_POST['isrememberme'] );
   if (is_int($return)&&($return > 0))
       echo $PROBLEM_USER_PASSWORD[$lang_idx];
   else
       echo $return;
  
}
else if ($_REQUEST['action']=="signout"){
		signOut();
}
else if ($_REQUEST['action']=="register"){
    $email_ok = check_email_address($_POST['email']);
    if ($email_ok)
        user_wants_to_register($_POST['email'], $_POST['username'], md5($_POST['password']), $_POST['user_nice_name'], $_POST['user_display_name'], $_POST['user_icon']);
    else
        echo "Email not OK";
    
}
else if ($_REQUEST['action']=="forgotpass"){
    forgot_password($_POST['email']);
}
else if ($_REQUEST['action']=="newpass"){
    set_new_password($_POST['email'], md5($_POST['password']));
}
else if ($_REQUEST['action']=="getuser"){
    get_user();
}
else if ($_REQUEST['action']=="updateprofile"){
    //echo $_POST['priority'];
    user_wants_to_update_profile($_POST['email'], md5($_POST['password']), $_POST['user_nice_name'], $_POST['user_display_name'], $_POST['user_icon'], $_POST['priority']);
    
}
else { echo "no action selected";}?>
 
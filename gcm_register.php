
<?php
 require_once 'include.php';
class DB_Functions {
 
    private $db;
 
      
    public function get_user_from_email($email){
        $query = "select user_login, u_pswd, user_status, display_name, user_rememberme, user_nicename, user_icon, priority, locked, admin, MsgCount, MsgStart, classification, PersonalColdMeter, SeasonPref, VoteCount  from users where email=?";
        $result = db_init($query, $email);
        $line = mysqli_fetch_array($result["result"]);
        $_SESSION['isAdmin'] = $line['admin'];
        return $line;
    }
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $gcm_regid, $lang, $active, $active_rain_etc, $active_tips, $active_dust, $active_uv, $active_dry, $approved, $billingtoken, $billingtime, $dailyforecast, $oldregid) {
        // insert user into database
        global $link;
        $billingDate = date('Y-m-d H:i:s', (int)$billingtime);
        if (empty($active_dust))
            $active_dust = 0;
        if (empty($active_uv))
            $active_uv = 0;
        if (empty($active_dry))
            $active_dry = 0;
        try {
            //$active_rain_etc = $_POST["active_rain_etc"];
            if ($active_rain_etc == "")
            {
                $active_rain_etc = $active;
                
            }
            if ($active_tips == "")
            {
                $active_tips = $active;
            }
            $dailyforecast = (empty($dailyforecast)? 'null' : $dailyforecast);
            $approved = (empty($approved)? 'null' : $approved);
            $query = "call SaveGCMUser ('$name', '$email', '$gcm_regid', $lang, $active, $active_rain_etc, $active_tips, $active_dust, $active_uv,  $active_dry, $approved, '$billingtoken', '$billingDate', $dailyforecast, '$oldregid')";
            $result = db_init($query, "");
            logger("New FC user updated:".$name." ".$email." ".$gcm_regid." ".$lang." active=".$active." active_rain_etc=".$active_rain_etc." active_tips=".$active_tips." dailyforecast=".$dailyforecast,0, "gcm_register", "SaveGCMUser", "storeUser");
            // check for successful store
        
            // get user details
            $id = $link->insert_id; // last inserted id
            
            if (!empty($email)){
                $query = "update `Subscriptions` set reg_id='".$gcm_regid."', UpdatedAt=now() where Email='".$email."'";
                db_init($query, "");
                //logger($query, 0, "lib", "Forecastlib", "Forecastlib");
                $line = $this->get_user_from_email($email);
                if ($line['user_status'] != 1){
                    $key = base64_encode(random_bytes(20)); // 
                    $pass = md5($email);
                    $parts = explode("@", $email);
                    $user = $parts[0];
                    $query = "call saveUser ('$email','$user', '$pass', '$user', '$key', '$user', '', '$gcm_regid')";
                    logger($query, 0, "saveUser", "gcm_register", "storeUser");
                    db_init($query, "");
                    // approve user
                    $query = "update users set user_status=1 where email='$email'";
                    db_init($query, "");
                    
                }
                else
                    logger("user ".$email." has already saved and signed in with ".$gcm_regid, 0, "FCM", "storeUser", "storeUser");
                // Be sure to store the $key value in your database
                setcookie("rememberme", $key, time()+3600*24*360); // Set the cookie to expire after 360 days
                $_SESSION['loggedin'] = "true";
                $_SESSION['email'] = $email;
            }
            
            return $email;
        } catch (Exception $ex) {
            logger("New GCM user updated exception:.".$ex." ".$id." ".$email." ".$lang." active=".$active." active_rain_etc=".$active_rain_etc, 4, "FCM", "storeUser", "storeUser");
        }
   
    }
 
    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = db_init("select * FROM fcm_users", "");
        return $result;
    }
 
}

// response json
$json = array();
 
/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($_POST["regId"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $_SESSION['email'] = $email;
    $_SESSION['loggedin'] == "true";
    $gcm_regid = $_POST["regId"]; // GCM Registration ID
    $lang = $_POST["lang"];
    $active = $_POST["active"];
    $db = new DB_Functions();
    $res = $db->storeUser($name, $email, $gcm_regid, $lang, $active, $_POST["active_rain_etc"], $_POST["active_tips"], $_POST["active_dust"], $_POST["active_uv"], $_POST["active_dry"], $_POST["Approved"], $_POST["BillingToken"], $_POST["BillingTime"], $_POST["dailyforecast"], $_POST["oldregId"]);
    echo ($res);
} else {
    logger("user details is missing; name=".$_POST["name"]." email=".$_POST["email"]." regId=".$_POST["regId"]." lang=".$_POST["lang"]." active=".$_POST["active"], 4, "FCM", "storeUser", "storeUser");
}
?>

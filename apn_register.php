
<?php
header("Access-Control-Allow-Origin: null");
 require_once 'include.php';
class DB_Functions {
 
    private $db;
 
      
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $apn_regid, $lang, $active, $active_shortterm, $active_tips, $dailyforecast, $active_dust, $active_uv, $active_dry) {
        // insert user into database
        global $link;
        if ($active_shortterm == ""){
            $active_shortterm = $active;
            $active_tips = $active;
        }
        if ($dailyforecast == "") {
            $dailyforecast = "null";
        }   
        $active_shortterm = (empty($active_shortterm)? '0' : $active_shortterm);
        $active_tips = (empty($active_tips)? '0' : $active_tips);
        $active = (empty($active)? '0' : $active);
        $dailyforecast = (empty($dailyforecast)? 'null' : $dailyforecast);
        $active_dust = (empty($active_dust)? '0' : $active_dust);
        $active_uv = (empty($active_uv)? '0' : $active_uv);
        $active_dry = (empty($active_dry)? '0' : $active_dry);
        $lang = (empty($lang)? 'null' : $lang);
        $result = db_init("call SaveAPNUser ('$name', '$email', '$apn_regid', $lang, $active, $active_shortterm, $active_tips, $dailyforecast, $active_dust, $active_uv, $active_dry)", "");
        //$query = "call SaveGCMUser ('$name', '$email', '$gcm_regid', $lang, $active, $active_rain_etc, $active_tips, $active_dust, $active_uv,  $active_dry, $approved, '$billingtoken', '$billingDate', $dailyforecast, '$oldregid', 1)";
        // check for successful store
       
        // get user details
        $id = $link->insert_id; // last inserted id
        //logger("New APN user updated:".$id." name=".$name." email=".$email." regId".$apn_regid." lang=".$lang." active=".$active." active_rain_etc=".$active_shortterm." active_tips=".$active_tips." active_dust=".$active_dust." active_uv=".$active_uv." active_dry=".$active_dry." dailyforecast=".$dailyforecast,0, "apn_register", "SaveAPNUser", "storeUser");
        return $email;
   
    }
 
    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = db_init("select * FROM apn_users", "");
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
    $apn_regid = $_POST["regId"]; // GCM Registration ID
    $lang = $_POST["lang"];
    $active = $_POST["active"];
    $active_shortterm = $_POST["active_rain_etc"];
    $active_tips = $_POST["active_tips"];
    $active_uv = $_POST["active_uv"];
    $active_dry = $_POST["active_dry"];
    $active_dust = $_POST["active_dust"];
    $dailyforecast = $_POST["dailyforecast"];
    $db = new DB_Functions();
    
    $res = $db->storeUser($name, $email, $apn_regid, $lang, $active, $active_shortterm, $active_tips, $dailyforecast, $active_dust, $active_uv, $active_dry);
    echo ($res);
} else {
    logger("user details is missing; name=".$_POST["name"]." email=".$_POST["email"]." regId=".$_POST["regId"]." lang=".$_POST["lang"]." active_rain_etc=".$_POST["active_rain_etc"]." active=".$_POST["active"]." active_tips=".$_POST["active_tips"], 4, "register", "", "storeUser");
}
?>

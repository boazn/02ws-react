
<?php
 require_once 'include.php';
class DB_Functions {
 
    private $db;
 
      
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $gcm_regid, $lang, $active) {
        // insert user into database
        global $link;
        try {
            
        
        $result = db_init("call SaveGCMUser ('$name', '$email', '$gcm_regid', $lang, $active)");
        // check for successful store
       
        // get user details
        $id = $link->insert_id; // last inserted id
        logger("New GCM user updated:".$id." ".$email." ".$lang." active=".$active);
        return $email;
        } catch (Exception $ex) {
            logger("New GCM user updated exception:.".$ex." ".$id." ".$email." ".$lang." active=".$active);
        }
   
    }
 
    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = db_init("select * FROM gcm_users");
        return $result;
    }
 
}

// response json
$json = array();
 
/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["regId"])&& isset($_POST["lang"])&& isset($_POST["active"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $gcm_regid = $_POST["regId"]; // GCM Registration ID
    $lang = $_POST["lang"];
    $active = $_POST["active"];
    $db = new DB_Functions();
    
    $res = $db->storeUser($name, $email, $gcm_regid, $lang, $active);
    echo ($res);
} else {
    echo "user details is missing; name=".$_POST["name"]." email=".$_POST["email"]." regId=".$_POST["regId"]." lang=".$_POST["lang"]." active=".$_POST["active"];
}
?>

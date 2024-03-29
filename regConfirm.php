<?php

ini_set("display_errors","Off");
include ("include.php");
include ("start.php");
function handle_action($action){
    global $DONE, $lang_idx, $REGISTRATION_TO_02WS, $REGISTRATION_TO_02WS_DONE, $LOGO, $header_pic, $HOME_PAGE;

    if ($action == "done")
    {
        echo "<div style=\"margin:3em;padding:3em\"></div>";
        echo "<div class=\"big success\"  style=\"margin:1em;padding:1em\"><h1>".$DONE[$lang_idx];
        echo "</h1>";
        echo "<h2>".$REGISTRATION_TO_02WS_DONE[$lang_idx]."</h2>";
        echo "</div>";
    }

}
function make_user_active($email, $user_id, $key, $reg_id){
    global $DONE, $lang_idx, $REGISTRATION_TO_02WS, $REGISTRATION_TO_02WS_DONE, $LOGO, $header_pic, $HOME_PAGE;
    $key = str_replace(" ", "+", $key);
    $query = "update users set user_status=1 where user_activation_key='$key' and email='$email'";
    //echo $query;
    $result = db_init($query,"");
    global $link;
   
    echo "<div class=\"big float\" style=\"padding:1em\"><img src=\"".$header_pic."\" align=\"absmiddle\"/>&nbsp;&nbsp;".$REGISTRATION_TO_02WS[$lang_idx];
    
    if(mysqli_affected_rows($link)==1)
    {
    	
		//logger("make_user_active succeed for ".$email);
        
    }
    else
    {
       
       logger("make_user_active failed for ".$email.": error - ".mysqli_connect_errno ($link)." ".mysqli_error ($link)." ".$query, 0, "registration", "regConfirm", "make_user_active");
        
    }
    $result = db_init("INSERT INTO `Subscriptions` (guid, email, approved, reg_id) VALUES(UUID_SHORT(), '$email' ,0, '$reg_id');", "");
    logger("After Activation - StoreSub:".$email." ".$reg_id." 0", 0, "registration", "regConfirm", "make_user_active");

    @mysqli_free_result($result);
     $_SESSION['email'] = $email;
    	$_SESSION['loggedin'] = "true";
        echo "<div class=\"big success\"  style=\"margin:1em;padding:1em\"><h1>".$DONE[$lang_idx];
        echo "</h1>";
        echo $REGISTRATION_TO_02WS_DONE[$lang_idx];
        echo "</div></div>";
}	
        
    ?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap<?=$lang_idx; ?>.css" type="text/css" >
<link rel="stylesheet"  href="css/main<?=$lang_idx;?>.css" type="text/css">
<link rel="stylesheet" href="<?=BASE_URL?>/css/mobile<?=$lang_idx;?>.css" type="text/css" />
<style>
	body{
		background: white;
	}
	#forgotpass
	{
		text-decoration: none;
	}
</style>
</head>
<body>
<div id="logo">
    
</div>

<? if (!check_email_address($_GET['email']))
   echo "Email not valid.";
else if ((isset($_GET['k']))&&(isset($_GET['email'])))
    make_user_active($_GET['email'], $_GET['user'], urldecode($_GET['k']), $_GET['reg_id']);
else if (isset($_GET['action']))
    handle_action($_GET['action']);
else
{
    ?>

<div id="loginform" style="padding:1em" class="inv_plain_3_zebra float big">
<form action="checkauth.php?action=newpass" method="post">
       <input type="text" name="email" value="<?=$_GET['email']?>" readonly="readonly" size="25" /><br /><br />
        <?=$NEW_PASSWORD[$lang_idx]?><br /> <input type="password" name="password" value="" style="direction:ltr" /><br /><br /><br />
        <input type="submit" value="<?=$SEND[$lang_idx]?>" class="float clear inv_plain_3_zebra big"  />
    </form>
</div>
<?
}
?>
</body>
</html>
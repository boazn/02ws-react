<?php

ini_set("display_errors","On");
include ("include.php");
include ("start.php");
function check_email_address($email) {
  // First, we check that there's one @ symbol, and that the lengths are right
  if (!ereg("[^@]{1,64}@[^@]{1,255}", $email)) {
    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
     if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }  
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}
function make_user_active($email, $user_id, $key){
    global $DONE, $lang_idx, $REGISTRATION_TO_02WS, $LOGO, $header_pic, $HOME_PAGE;
    $key = str_replace(" ", "+", $key);
    $query = "update users set user_status=1 where user_activation_key='$key' and email='$email'";
    //echo $query;
    $result = db_init($query,"");
    global $link;
   
    echo "<div class=\"inv_plain_3_zebra big float\" style=\"padding:1em\"><img src=\"".$header_pic."\" align=\"absmiddle\"/>&nbsp;&nbsp;".$REGISTRATION_TO_02WS[$lang_idx];
    
    if(mysqli_affected_rows($link)==1)
    {
    	
		logger("make_user_active succeed for ".$email);
        
    }
    else
    {
       
             logger("make_user_active failed for ".$email.": error - ".mysqli_connect_errno ($link)." ".mysqli_error ($link));
        
    }
    @mysqli_free_result($result);
     $_SESSION['email'] = $email;
    	$_SESSION['loggedin'] = "true";
        echo "<div class=\"big success \"  style=\"margin:1em;padding:1em\">".$DONE[$lang_idx];
        echo "<br /><br /><br /><a href=\"".BASE_URL."\" style=\"text-decoration:underline\">".$HOME_PAGE[$lang_idx]."</a>".get_arrow();
        echo "</div></div>";
}	
        
    ?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<link title="Default Colors" href="main.php<?echo "?lang=".$lang_idx; ?>" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>


<? if (!check_email_address($_GET['email']))
   echo "Email not valid.";
else if ((isset($_GET['k']))&&(isset($_GET['email'])))
    make_user_active($_GET['email'], $_GET['user'], urldecode($_GET['k']));
else
{
    ?>

<div id="loginform" style="padding:10em" class="inv_plain_3_zebra float">
<form action="checkauth.php?action=newpass" method="post">
        <?=$EMAIL[$lang_idx]?>:<input type="text" name="email" value="<?=$_GET['email']?>" readonly="readonly" size="30" /><br />
        <?=$NEW_PASSWORD[$lang_idx]?>:<input type="password" name="password" value="" />
        <input type="submit" value="<?=$SEND[$lang_idx]?>" />
    </form>
</div>
<?
}
?>
</body>
</html>
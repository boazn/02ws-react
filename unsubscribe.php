<?php

ini_set("display_errors","On");
include ("include.php");
include ("start.php");
function make_user_unsubscribed($email){
    global $DONE, $lang_idx, $REGISTRATION_TO_02WS, $LOGO, $header_pic, $HOME_PAGE;
    $key = str_replace(" ", "+", $key);
    $query = "update users set priority=0 where email='$email'";
    //echo $query;
    $result = db_init($query,"");
    global $link;
   
    //echo "<div class=\"inv_plain_3_zebra big float\" style=\"padding:1em\"><img src=\"".$header_pic."\" align=\"absmiddle\"/>&nbsp;&nbsp;".$REGISTRATION_TO_02WS[$lang_idx];
    
    if(mysqli_affected_rows($link)==1)
    {
    	
		logger("make_user_unsubscribed succeed for ".$email);
                return true;
        
    }
    else
    {
       
             logger("make_user_unsubscribed failed for ".$email.": error - ".mysqli_connect_errno ($link)." ".mysqli_error ($link)." ".$query, 0, "Subscriptions", "storeSub", "make_user_unsubscribed");
             return false;
        
    }
    
}
?>


<!DOCTYPE html>
<head>
<meta charset="utf-8">
<link title="Default Colors" href="main.php<?echo "?lang=".$lang_idx; ?>" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>


<? 
    if (make_user_unsubscribed($_GET['email']))
        echo "<h1>".$_GET['email']." Removed!</h1>";
    else
        echo "<h1>done but with errors</h1>";
?>



</body>
</html>

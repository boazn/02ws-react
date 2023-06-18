<?php

ini_set("display_errors","On");
include ("include.php");
include ("start.php");
function make_user_removed($reg_id){
    global $DONE, $lang_idx, $REGISTRATION_TO_02WS, $LOGO, $header_pic, $HOME_PAGE;
    $reg_id = str_replace("document", "", $reg_id);
    $reg_id  = htmlspecialchars($reg_id);
    $reg_id  = Strip_tags($reg_id);
    $query = "call RemoveUser ('$reg_id')";
    
    //echo $query;
   $result = db_init($query,"");
    global $link;
   
    //echo "<div class=\"inv_plain_3_zebra big float\" style=\"padding:1em\"><img src=\"".$header_pic."\" align=\"absmiddle\"/>&nbsp;&nbsp;".$REGISTRATION_TO_02WS[$lang_idx];
   
    if(mysqli_affected_rows($link)==1)
    {
    	
		logger("make_user_removed succeed for ".$reg_id);
                return true;
        
    }
    else
    {
       
             logger("make_user_removed failed for ".$reg_id.": error - ".mysqli_connect_errno ($link)." ".mysqli_error ($link)." ".$query, 0, "Subscriptions", "storeSub", "make_user_unsubscribed");
             return false;
        
    }
    
}
?>


<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap<?=$lang_idx; ?>.css" type="text/css" >
<link rel="stylesheet"  href="css/main<?=$lang_idx;?>.css" type="text/css">
<link rel="stylesheet" href="<?=BASE_URL?>/css/mobile<?=$lang_idx;?>.css" type="text/css" />
<style>
	body{
		background: white;
	}
	
	@media only screen and (min-width: 1000px) {
		h2
		{
			height: 2em;
			font-size: 2em;
			width: 280px;
		}
    }
	
</style>
</head>
<body>


<? 
    if (make_user_removed($_GET['reg_id']))
        echo "<h2>"." הוסר Removed </h2>";
    else
        echo "<h2> - done but with errors</h2>";
?>



</body>
</html>

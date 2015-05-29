<? header('Content-type: text/html; charset=utf-8');include_once("include.php"); include_once("start.php");?>
<!DOCTYPE html> 
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\""; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/main.php<?echo "?lang=".$lang_idx;?>" rel="stylesheet" type="text/css" /> 
<title><? echo $LOGO[$lang_idx];?></title>
</head>
<body>
<div class="base">
<h1><?=$FAQ[$lang_idx]?></h1>
</div>
<div class="span12" id="msgDetails">
           
<?
 
 getSpecificChat(17798);
 getSpecificChat(19874);
 getSpecificChat(23337);
 getSpecificChat(17412);
 getSpecificChat(11549);
 getSpecificChat(17688);
?>
</div>
</body>
<html>
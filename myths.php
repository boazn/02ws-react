<? header('Content-type: text/html; charset=utf-8');include_once("include.php"); include_once("start.php");?>
<!DOCTYPE html> 
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\""; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/main.php<?echo "?lang=".$lang_idx;?>" rel="stylesheet" type="text/css" /> 
<title><? echo $LOGO[$lang_idx];?></title>
</head>
<body>
<div class="base">
<h1><?=$MYTHS[$lang_idx]?></h1>
</div>
<div class="span12" id="msgDetails">
           
<?
 getSpecificChat(32236);
 getSpecificChat(32235);
 getSpecificChat(32272);
 getSpecificChat(32271);
?>
</div>
</body>
<html>
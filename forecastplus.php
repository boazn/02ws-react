<?
header('Content-type: text/html; charset=utf-8');
if ($_GET['debug'] == '')
    include "begin_caching.php";
include_once("include.php"); 
include "start.php";
include_once ("requiredDBTasks.php");
$style=$_GET['style'];
if ($style < 2) $style = "";
?>
 <!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\""; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link title="Default Colors" href="generalstyle.php<?echo "?lang=".$lang_idx."&amp;forground_color=".$forground_color."&amp;base_color=".$base_color;?>" rel="stylesheet" type="text/css" media="screen" />
<script language="javascript" src="ajax.js"></script>
<meta http-equiv="Refresh" content="600" />
<title><? echo $LOGO[$lang_idx];?></title>
</head>
<body>
<table width="660px">
<tr><td class="inv_plain_3_minus" align="center"><? echo $date;?></td></tr>
<!-- <tr class=tbl><td> <? echo $ELEVATION[$lang_idx]." ".ELEVATION ; ?>m</td></tr> -->
<tr ><td class="inv_plain_3 slogan" align="center" id="templabel"> <a href="images/profile1/OutsideTempHistory.<?=IMAGE_TYPE?>"><? echo $TEMP[$lang_idx]." ".$NOW[$lang_idx];?></a><br />
<span id="tempvalue" style="font-size:110%">
	<? echo $current->get_temp();?><? echo $current->get_tempunit(); ?>
</span>
</td></tr>
<tr><td class="inv_plain_3"> 
<div id="forecast" style="width:98%;clear:both;float:<?echo get_s_align();?>" class="container">
		<?
		include "forecast.php";
		?>
		
</div>
</td></tr>
</table>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-647172-1";
urchinTracker();
</script>
</body>
</html>
<?
if ($_GET['debug'] == '')
    include "end_caching.php";
 ?>
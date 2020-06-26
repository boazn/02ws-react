<?
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link title="Default Colors" href="main.php" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<?
include_once("include.php");
include "start.php";
include_once("requiredDBTasks.php");
include_once "sigweathercalc.php";
include_once "runwalkcalc.php";
ini_set("display_errors","On");
$pageToPrint = $_GET['section'];
if  ((stristr($pageToPrint, 'txt'))||(stristr($pageToPrint, 'TXT')))
	echo "<div align=\"left\" style=\"padding:1em\"><pre>";
try
{
	if(!@include($pageToPrint)) {
        throw new Exception('Failed to load $pageToPrint');
    }
}
catch (Exception $e)
{
	echo "<iframe src=\"{$url}\" scrolling=\"auto\" id=\"iframemain\" class=\"tbl\" allowtransparency=\"true\" marginHeight=\"0\" marginWidth=\"0\" width=\"{$width}\" height=\"{$height}\" frameborder=\"0\" style=\"\"></iframe>\n</td>";
}
if  ((stristr($pageToPrint, 'txt'))||(stristr($pageToPrint, 'TXT')))
		echo "</pre></div>";
?>
<script language="javascript">
	print();
</script>
</body>
</html>
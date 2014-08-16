<?php header("Content-type: text/css");
include_once("csscolor.php");
$forground = new CSS_Color(@$_GET['forground_color']);
$base = new CSS_Color(@$_GET['base_color']);
$lang_idx = @$_GET['lang'];
include_once("basestyle2.php");
?>

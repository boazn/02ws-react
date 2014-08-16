<?php
include_once("include.php"); 
include "begin_caching.php";
include "start.php";
?>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<a href="<? echo BASE_URL;?>" title="<? echo $TITLE[$lang_idx];?>" target="_blank">
<img src="banner.php?lang=<?=$lang_idx?>" border="0"/>
</a>
<? include "end_caching.php"; ?>
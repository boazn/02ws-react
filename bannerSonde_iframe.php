<?php
include_once("include.php"); 
include "begin_caching.php";
include "start.php";
$res = true;
$res = getRadioData();
if (isHeb())
{
	$text = "  ".sprintf("%02dZ ", $hoursonde).utf8_strrev($RADIOSONDE[$HEB])."^850T = ".$t850."C      ^700T = ".$t700."C       ^500T = ".$t500."C       ^".$baseInversionHeight."m = ".utf8_strrev($BASE[$HEB])."^".$inversionThickness."m"." = ".utf8_strrev($THICKNESS[$HEB]);
	$text = htmlspecialchars($text);
	if ($FireIdx > 4)
		$text .= "^".$FireIdx." = ".utf8_strrev($FIRE_INDEX[$HEB]);
	if (!$res)
		$text = utf8_strrev("אין נתוני רדיוסונדה ^כרגע");
}
else
{
	$text = "   ^".sprintf("%02dZ ", $hoursonde).$RADIOSONDE[$EN]."       ^850T = ".$t850."C      ^700T = ".$t700."C       ^500T = ".$t500."C       ^".$INVERSION[$EN]." ".$BASE[$EN]." = ".$baseInversionHeight."m         ^".$THICKNESS[$EN]." = ".$inversionThickness."m         ";
	$text = htmlspecialchars($text);
	if ($FireIdx > 4)
		$text .= "^".$FireIdx." = ".$FIRE_INDEX[$EN];
	if (!$res)
		$text = "No radiosonde data^";
}

?>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<a href="<? echo BASE_URL."/station.php?section=radiosonde";?>" title="<? echo $TITLE[$lang_idx];?>" target="_blank">
<img src="button.php?text=<?=$text?>&R=66&G=102&B=125&width=196&height=120&size=10&forR=255&forG=255&forB=255" border="0" />
</a>
<? include "end_caching.php"; ?>
<?
include_once("lang.php");
include_once("start.php");
?>

<div id="forecast_desc" class="inv_plain_2_zebra" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
<h1><?=$WHAT_IS_FORECAST[$lang_idx]?></h1>
<?=$FORECAST_DESC[$lang_idx]?>
</div>
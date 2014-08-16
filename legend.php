<? header('Content-type: text/html; charset=utf-8');include_once("include.php"); include_once("start.php");?>
<!DOCTYPE html> 
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\""; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="basestyle.php<?echo "?lang=".$lang_idx."&amp;forground_color=".$forground_color."&amp;base_color=".$base_color;?>" rel="stylesheet" type="text/css" /> 
<title><? echo $LOGO[$lang_idx];?></title>
</head>
<body <? if (isHeb()) echo "style=\"direction:rtl\""; ?>>
<div class="float" style="width:20%">
<div><img align="absmiddle" src="images/clothes/shorts_n.png" width="50px" height="50px"><?=getClothTitle("images/clothes/shorts.png")?></div>
<div><img align="absmiddle" src="images/clothes/tshirt_n.png" width="50px" height="50px"><?=getClothTitle("images/clothes/tshirt.png")?></div>
<div><img align="absmiddle" src="images/clothes/longsleeves_n.png" width="50px" height="50px"><?=getClothTitle("images/clothes/longsleeves.png")?></div>
<div><img align="absmiddle" src="images/clothes/sweater_n.png" width="50px" height="50px"><?=getClothTitle("images/clothes/sweater.png")?></div>
<div><img align="absmiddle" src="images/clothes/jacketlight_n.png" width="50px" height="50px"><?=getClothTitle("images/clothes/jacketlight.png")?></div>
<div><img align="absmiddle" src="images/clothes/jacket_n.png" width="50px" height="50px"><?=getClothTitle("images/clothes/jacket.png")?></div>
<div><img align="absmiddle" src="images/clothes/coat_n.png" width="50px" height="50px"><?=getClothTitle("images/clothes/coat.png")?></div>
<div><img align="absmiddle" src="images/clothes/umbrella.png" width="50px" height="50px"><?=getClothTitle("images/clothes/umbrella.png")?></div>
<div><img align="absmiddle" src="images/clothes/coatrain_n.png" width="50px" height="50px" ><?=getClothTitle("images/clothes/coatrain.png")?></div>
</div>

<div class="float" style="width:30%">
<div><img align="absmiddle" src="images/icons/day/heatwave.gif" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/heatwave.png" width="65px" width="65px" ><?=$VERY_HOT_HEAT_WAVE[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/clear.png" width="65px" height="65px" ><?=$CLEAR[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/dust.png" width="65px" height="65px" ><?=$DUST[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/tzirus_few.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/tzirus_partly2.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/pcFew.png" width="65px" height="65px" ><?=$FEW_CLOUDS[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/partlycloudy.png" width="65px" height="65px" ><?=$PARTLY_CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/mostlycloudy2.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/tzirus_mostly.png" width="65px" height="65px" ><?echo "$MOSTLY[$lang_idx] $CLOUDY[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/cloudy.png" width="65px" height="65px" ><?=$CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/fogy.png" width="65px" height="65px" ><?=$FOG[$lang_idx]?></div>
</div>
<div class="float" style="width:30%">
<div><img align="absmiddle" src="images/icons/day/TS2.gif" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/TS.gif" width="65px" height="65px" ><?=$THUNDERSTORM[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/becomingrain.gif" width="65px" height="65px" ><?echo "$BECMG[$lang_idx] $RAIN[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/lightrain.gif" width="65px" height="65px" ><?=$LIGHT_RAIN[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rainy.gif" width="65px" height="65px" ><?=$RAIN[$lang_idx]?> <?=$AT_TIMES[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/TSRA.gif" width="65px" height="65px" ><?echo"$THUNDERSTORM[$lang_idx] $RAIN[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/hail.gif" width="50px" height="50px" ><?=$HAIL[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rainSnow.png" width="50px" height="50px" ><img align="absmiddle" src="images/icons/day/rainSnow.gif" width="50px" height="50px" ><?echo "$RAIN[$lang_idx] $SNOW[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/snowshow2.png" width="50px" height="50px" ><img align="absmiddle" src="images/icons/day/snow.gif" width="50px" height="50px" ><?=$SNOW[$lang_idx]?></div>
</div>
<div class="float" style="width:15%">
<?=$RAIN[$lang_idx]." - ".$ISOLATED[$lang_idx]?><br />
<?=$RAIN[$lang_idx]." ".$OCCASIONALLY[$lang_idx]?><br />
<?=$RAIN[$lang_idx]." ".$ALTERNATELY[$lang_idx]?><br />
<?=$RAIN[$lang_idx]." ".$AT_TIMES[$lang_idx]?><br />
<?=$RAINY[$lang_idx]?><br /><br /><br />
<?=$WEAK_WINDS[$lang_idx]?><br />
<?=$MODERATE_WINDS[$lang_idx]?><br />
<?=$STRONG_WINDS[$lang_idx]?><br />
<?=$EXTREME_WINDS[$lang_idx]?><br />


</div>
</body>
</html>
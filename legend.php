<? header('Content-type: text/html; charset=utf-8');include_once("include.php"); include_once("start.php");?>
<!DOCTYPE html> 
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\""; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="basestyle.php<?echo "?lang=".$lang_idx."&amp;forground_color=".$forground_color."&amp;base_color=".$base_color;?>" rel="stylesheet" type="text/css" /> 
<title><? echo $LOGO[$lang_idx];?></title>
</head>
<body <? if (isHeb()) echo "style=\"direction:rtl\""; ?>>
<div class="float" style="width:20%">
<div><img align="absmiddle" src="images/clothes/shorts_n.png" width="50px" height="50px"><?=getClothTitle("images/clothes/shorts.png", $current->get_temp())?></div>
<div><img align="absmiddle" src="images/clothes/tshirt_n2.png" width="50px" height="50px"><?=getClothTitle("images/clothes/tshirt.png", $current->get_temp())?></div>
<div><img align="absmiddle" src="images/clothes/longsleeves_n2.png" width="50px" height="50px"><?=getClothTitle("images/clothes/longsleeves.png", $current->get_temp())?></div>
<div><img align="absmiddle" src="images/clothes/sweater_n2.png" width="50px" height="50px"><?=getClothTitle("images/clothes/sweater.png", $current->get_temp())?></div>
<div><img align="absmiddle" src="images/clothes/jacketlight_n2.png" width="50px" height="50px"><?=getClothTitle("images/clothes/jacketlight.png", $current->get_temp())?></div>
<div><img align="absmiddle" src="images/clothes/jacket_n2.png" width="50px" height="50px"><?=getClothTitle("images/clothes/jacket.png", $current->get_temp())?></div>
<div><img align="absmiddle" src="images/clothes/coat_n2.png" width="50px" height="50px"><?=getClothTitle("images/clothes/coat.png", $current->get_temp())?></div>
<div><img align="absmiddle" src="images/clothes/umbrella.png" width="50px" height="50px"><?=getClothTitle("images/clothes/umbrella.png", $current->get_temp())?></div>
<div><img align="absmiddle" src="images/clothes/coatrain_n2.png" width="50px" height="50px" ><?=getClothTitle("images/clothes/coatrain.png", $current->get_temp())?></div>
</div>

<div class="float" style="width:30%">
<div><img align="absmiddle" src="images/icons/day/sunHot.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/Hot.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/hot_tzirus_5.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/hot_tzirus_4.png" width="65px" width="65px" ><img align="absmiddle" src="images/icons/day/hot_tzirus_3.png" width="65px" width="65px" ><?=$VERY_HOT_HEAT_WAVE[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/BecomingHot.gif" width="65px" height="65px" ><?echo "$BECMG[$lang_idx] $VERY_HOT_HEAT_WAVE[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/clear.png" width="65px" height="65px" ><?=$CLEAR[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/sunCold.png" width="65px" height="65px" ><?=$COLD_SUN[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/dust.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/cloudy_zirus.png" width="65px" height="65px" ><?=$DUST[$lang_idx]?>, <?=$SANDSTORM[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/tzirus_few.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/tzirus_partly2.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/pcFew.png" width="65px" height="65px" ><?=$FEW_CLOUDS[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/partlycloudy.png" width="65px" height="65px" ><?=$PARTLY_CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/mostlycloudy.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/tzirus_mostly2.png" width="65px" height="65px" ><?echo "$MOSTLY[$lang_idx] $CLOUDY[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/cloudy.png" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/cloudy_zirus.png" width="65px" height="65px" ><?=$CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/fogy.png" width="65px" height="65px" ><?=$FOG[$lang_idx]?></div>
</div>
<div class="float" style="width:30%">
<div><img align="absmiddle" src="images/icons/day/TS2.gif" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/TS.gif" width="65px" height="65px" ><?=$THUNDERSTORM[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/becomingrain.gif" width="65px" height="65px" ><?=$CLEAR[$lang_idx]?>, <?=$CLEAR[$lang_idx]?>, <?=$PARTLY_CLOUDY[$lang_idx]?>, <?=$PARTLY_CLOUDY[$lang_idx]?>, <?=$RAIN[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rainPC.gif" width="65px" height="65px" ><?=$PARTLY_CLOUDY[$lang_idx]?>, <?=$RAIN[$lang_idx]?>, <?=$PARTLY_CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rainPC2.gif" width="65px" height="65px" ><?=$PARTLY_CLOUDY[$lang_idx]?>, <?=$LIGHT_RAIN[$lang_idx]?>, <?=$PARTLY_CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rain.gif" width="65px" height="65px" ><?=$RAIN[$lang_idx]?> <?=$AT_TIMES[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/Showers.gif" width="65px" height="65px" ><?=$LIGHT_RAIN[$lang_idx]?>, <?=$LOCAL_RAIN[$lang_idx]?>, <?=$CLOUDY[$lang_idx]?>, <?=$DRIZZLE[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rainTS.gif" width="65px" height="65px" ><?echo"$THUNDERSTORM[$lang_idx] $RAIN[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/hail.gif" width="50px" height="50px" ><?=$HAIL[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rainSnow.png" width="50px" height="50px" ><img align="absmiddle" src="images/icons/day/rainSnow.gif" width="50px" height="50px" ><?echo "$RAIN[$lang_idx] $SNOW[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/snowshow2.png" width="50px" height="50px" ><img align="absmiddle" src="images/icons/day/snow.gif" width="50px" height="50px" ><?=$SNOW[$lang_idx]?></div>
</div>
<div class="float" style="width:15%">
<div><img align="absmiddle" src="images/icons/day/rainPC.gif" width="65px" height="65px" ><?=$RAIN[$lang_idx]." - ".$ISOLATED[$lang_idx]?></div>
<div><?=$RAIN[$lang_idx]." ".$OCCASIONALLY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rain.gif" width="65px" height="65px" ><?=$RAIN[$lang_idx]." ".$ALTERNATELY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rain.gif" width="65px" height="65px" ><?=$RAIN[$lang_idx]." ".$AT_TIMES[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/rain.gif" width="65px" height="65px" ><?=$RAINY[$lang_idx]?></div>
<br /><br /><br />
<div><div class="wind_icon no_wind"></div><?=$NO_WIND[$lang_idx]?></div>
<div><div class="wind_icon light_wind"></div><?=$WEAK_WINDS[$lang_idx]?></div>
<div><div class="wind_icon moderate_wind"></div><?=$MODERATE_WINDS[$lang_idx]?></div>
<div><div class="wind_icon high_wind"></div><?=$STRONG_WINDS[$lang_idx]?></div>
<div><div class="wind_icon high_wind"></div><?=$EXTREME_WINDS[$lang_idx]?></div>


</div>
</body>
</html>
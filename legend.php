<? header('Content-type: text/html; charset=utf-8');include_once("include.php"); include_once("start.php");?>
<!DOCTYPE html> 
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\""; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="basestyle.php<?echo "?lang=".$lang_idx."&amp;forground_color=".$forground_color."&amp;base_color=".$base_color;?>" rel="stylesheet" type="text/css" /> 
<title><? echo $LOGO[$lang_idx];?></title>
</head>
<body <? if (isHeb()) echo "style=\"direction:rtl\""; ?>>
<div class="float" style="width:20%">
<div><img align="absmiddle" src="images/clothes/singlet.svg" width="50px" height="50px"><?=getClothTitle("images/clothes/singlet.png", $current->get_temp(), 0, 0)?></div>
<div><img align="absmiddle" src="images/clothes/shorts_n4.svg" width="50px" height="50px"><?=getClothTitle("images/clothes/shorts.png", $current->get_temp(), 0, 0)?></div>
<div><img align="absmiddle" src="images/clothes/tshirt_n4.svg" width="50px" height="50px"><?=getClothTitle("images/clothes/tshirt.png", $current->get_temp(), 0, 0)?></div>
<div><img align="absmiddle" src="images/clothes/longsleeves_n4.svg" width="50px" height="50px"><?=getClothTitle("images/clothes/longsleeves.png", $current->get_temp(), 0, 0)?></div>
<div><img align="absmiddle" src="images/clothes/jacketlight_n4.svg" width="50px" height="50px"><?=getClothTitle("images/clothes/jacketlight.png", $current->get_temp(), 0, 0)?></div>
<div><img align="absmiddle" src="images/clothes/jacket_n4.svg" width="50px" height="50px"><?=getClothTitle("images/clothes/jacket.png", $current->get_temp(), 0, 0)?></div>
<div><img align="absmiddle" src="images/clothes/coat_n4.svg" width="50px" height="50px"><?=getClothTitle("images/clothes/coat.png", $current->get_temp(), 0, 0)?></div>
<div><img align="absmiddle" src="images/clothes/coatrain_n4.svg" width="50px" height="50px" ><?=getClothTitle("images/clothes/coatrain.png", $current->get_temp(), 0, 0)?></div>
<div><img align="absmiddle" src="images/clothes/gloves.svg" width="50px" height="50px" ><?=getClothTitle("images/clothes/gloves.svg", $current->get_temp(), 0, 0)?></div>
<div><img align="absmiddle" src="images/clothes/cold.svg" width="50px" height="50px" ><?=getClothTitle("images/clothes/cold.svg", $current->get_temp(), 0, 0)?></div>
</div>

<div class="float" style="width:30%">
<div><img align="absmiddle" src="images/icons/day/n4_cloud_3_sun_1.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_cloud_2_sun_1.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_cloud_1_sun_1.svg" width="65px" width="65px" ><img align="absmiddle" src="images/icons/day/n4_cloud_0_sun_1.svg" width="65px" width="65px" ><?=$VERY_HOT_HEAT_WAVE[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_clear.svg" width="65px" height="65px" ><?=$CLEAR[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_cloud_3_sun_4.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_cloud_2_sun_4.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_cloud_0_sun_4.svg" width="65px" width="65px" ><?=$COLD_SUN[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_dust.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/cloudy_zirus.svg" width="65px" height="65px" ><?=$DUST[$lang_idx]?>, <?=$SANDSTORM[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_cloud_1_sun_2.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_cloud_1_sun_3.svg" width="65px" height="65px" ><?=$FEW_CLOUDS[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_cloud_2_sun_2.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_cloud_2_sun_3.svg" width="65px" height="65px" ><?=$PARTLY_CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_cloud_3_sun_2.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_cloud_3_sun_3.svg" width="65px" height="65px" ><?echo "$MOSTLY[$lang_idx] $CLOUDY[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/n4_cloudy2.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_cloudy3.svg" width="65px" height="65px" ><?=$CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_fog2.svg" width="65px" height="65px" ><?=$FOG[$lang_idx]?></div>
</div>
<div class="float" style="width:30%">
<div><img align="absmiddle" src="images/icons/day/n4_TS.svg" width="65px" height="65px" ><?=$THUNDERSTORM[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_becomingrain.svg" width="65px" height="65px" ><?=$CLEAR[$lang_idx]?>, <?=$CLEAR[$lang_idx]?>, <?=$PARTLY_CLOUDY[$lang_idx]?>, <?=$PARTLY_CLOUDY[$lang_idx]?>, <?=$RAIN[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_rainPC.svg" width="65px" height="65px" ><?=$PARTLY_CLOUDY[$lang_idx]?>, <?=$RAIN[$lang_idx]?>, <?=$PARTLY_CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_rainPC2.svg" width="65px" height="65px" ><?=$PARTLY_CLOUDY[$lang_idx]?>, <?=$LIGHT_RAIN[$lang_idx]?>, <?=$PARTLY_CLOUDY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_sun_lightrain.svg" width="65px" height="65px" ><?=$LIGHT_RAIN[$lang_idx]?>, <?=$LOCAL_RAIN[$lang_idx]?>, <?=$CLOUDY[$lang_idx]?>, <?=$DRIZZLE[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_TSRA.svg" width="65px" height="65px" ><?echo"$THUNDERSTORM[$lang_idx] $RAIN[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/n4_hail.svg" width="50px" height="50px" ><?=$HAIL[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_snowrain.svg" width="50px" height="50px" ><?echo "$RAIN[$lang_idx] $SNOW[$lang_idx]";?></div>
<div><img align="absmiddle" src="images/icons/day/n4_snow.svg" width="50px" height="50px" ><?=$SNOW[$lang_idx]?></div>
</div>
<div class="float" style="width:15%">
<div><img align="absmiddle" src="images/icons/day/n4_sun_lightrain.svg" width="65px" height="65px" ><?=$RAIN[$lang_idx]." - ".$ISOLATED[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_lightshowers.svg" width="65px" height="65px" ><?=$RAIN[$lang_idx]." ".$OCCASIONALLY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_sun_rain2.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_moonrain.svg" width="65px" height="65px" ><?=$RAIN[$lang_idx]." ".$ALTERNATELY[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_sun_rain.svg" width="65px" height="65px" ><img align="absmiddle" src="images/icons/day/n4_rain2.svg" width="65px" height="65px" ><?=$RAIN[$lang_idx]." ".$AT_TIMES[$lang_idx]?></div>
<div><img align="absmiddle" src="images/icons/day/n4_rain2.svg" width="65px" height="65px" ><?=$RAINY[$lang_idx]?></div>
<br /><br /><br />
<div><div class="wind_icon no_wind"></div><?=$NO_WIND[$lang_idx]?></div>
<div><div class="wind_icon light_wind"></div><?=$WEAK_WINDS[$lang_idx]?></div>
<div><div class="wind_icon moderate_wind"></div><?=$MODERATE_WINDS[$lang_idx]?></div>
<div><div class="wind_icon high_wind"></div><?=$STRONG_WINDS[$lang_idx]?></div>
<div><div class="wind_icon high_wind"></div><?=$EXTREME_WINDS[$lang_idx]?></div>


</div>
</body>
</html>

<?
include_once("include.php"); 
include_once("start.php");
include_once "sigweathercalc.php";
include_once "activities.php";
$forecastDaysDB = $mem->get('forecastDaysDB');
$dayid = 0;
foreach ($forecastDaysDB as $key => &$forecastday) 
{
    $dayid++;
    if ($_REQUEST['dayid'] == $dayid)
        break;
}

$day_recommendations = getRecommendations(TimeFrame::Daily, $dayid--, $forecastday['TempHigh'], $forecastday['windDay'], $forecastday['humDay'], $forecastday['rain'], 0, 0);
    
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title><? echo getPageTitle()?></title>
        <link rel="stylesheet"  href="<?=BASE_URL?>/css/main<?=$lang_idx;?>.css" type="text/css" />
        <? if ($_REQUEST['m'] == 1) { ?>
        <link rel="stylesheet" href="<?=BASE_URL?>/css/mobile<?=$lang_idx;?>.css" type="text/css" />
        <?}?>
        <? if ($current->is_sunset()) { ?>
        <link rel="stylesheet" title="mystyle" href="css/sunset.min.css" type="text/css">
        <? }?>
        <? if ($current->is_sunrise()) { ?>
        <link rel="stylesheet" title="mystyle" href="css/sunrise.min.css" type="text/css">
        <? }?>
        <? if (($current->is_light())&&($current->get_cloudiness() > 6)) {?>
             <link rel="stylesheet" title="mystyle" href="css/cloudy.min.css" type="text/css" media="screen">
        <? }?>
        <? if ($current->get_pm10() > 300) { ?>
        <link rel="stylesheet" title="mystyle" href="css/dust.min.css" type="text/css">
        <? }?>
        <? if (!$current->is_light()){  ?>       
            <link rel="stylesheet" title="mystyle" href="css/night<?=$lang_idx?>.min.css" type="text/css">\
            <? if ($current->get_pm10() > 300) { ?>
            <link rel="stylesheet" title="mystyle" href="css/dust-night.min.css" type="text/css">
            <? }?>
        <? }?>
        <? if (isRaining()){ ?>
	<link rel="stylesheet" title="mystyle" href="css/rain.min.css" type="text/css">
        <? }?>
        <? if (isSnowing()) { ?>
        <? if ($current->is_light()){?>
        <link rel="stylesheet" title="mystyle" href="css/snow.min.css" type="text/css">
        <? } else {?>
        <link rel="stylesheet" title="mystyle" href="css/snow_night.min.css" type="text/css">
        <? }?>
        <? }?>
        </head>
        <style>
            body { height: 500vh}
            #activities_yes li, #activities_no li
            {
                width: 32px;
                height:32px;
            }
        </style>
    <body>
<ul id="forcast_days" class="detailed">
<li class="forcast_each <?if ($i >= TASHKIF_START) echo "tashkif";?>" id="<?=$key?>" name="<?=$key?>">
        
        <ul>
                                          
            <li class="forcast_day inv_plain_3">
            <? echo replaceDays($forecastday['day_name']." ");?><? if ($i >= TASHKIF_START) echo "<p>".$overlook_d."</p>";?><br/><br/><? echo $forecastday['date'];?>
                    <div id="latest_laundry" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_ac" class="inparamdiv">
                    <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_bicycle" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_campfire" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_camping" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_car" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_children" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_dinneratbalcony" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_dog" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_eventoutside" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_gazellepark" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_heater" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_irrigation" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_openwindow" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_picnic" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_sport" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_westernwall" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_yoga" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
                    <div id="latest_sacker" class="inparamdiv">
                        <div class="paramtitle slogan">
                        </div>
                        <div class="exp">
                        </div>
                    </div>
            </li>
            <li class="forcast_text inv_plain_3_zebra">
                <? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastday[$dscpIdx]);$textsum = $textsum + strlen(urldecode($forecastday[$dscpIdx]));?>
                <br/>
                <br/>
                <div><?=$VISIBILITY[$lang_idx]?>: <?=$forecastday['visDay']." ".$KM[$lang_idx]?></div>
                <br/>
                <?if ($forecastday['rainTo']>0){?>
                <div><?=$RAIN[$lang_idx]?>:<?=$forecastday['rainFrom']?> - <?=$forecastday['rainTo']?> mm</div>
                <?}?>
                <br/>
                <div><?=$GOOD_TIME_FOR[$lang_idx]?></div>   
                <? foreach ($day_recommendations as $r) {
                    $act_container = 'latest_' . strtolower($r['activity']);
                     if ($r['value'] == 1)
                     $activities_yes .= "<li id=\"" .strtolower($r['activity'])."_btn\" class=\"span-value\" data-value=\"" . getActivityTitle($r['activity'], $lang_idx). "\"  onclick=\"change_circle('".strtolower($r['activity']). "', '" .$act_container. "')\"><img src=\"images/activities/" .strtolower($r['activity']).".png\" width=\"25\" height=\"25\" /></li>" ;
                  else
                     $activities_no .= "<li id=\"" .strtolower($r['activity'])."_btn\" class=\"no span-value\" data-value=\"" . getActivityTitle($r['activity'], $lang_idx). "\"  onclick=\"change_circle('".strtolower($r['activity']). "', '".$act_container. "')\"><img src=\"images/activities/" .strtolower($r['activity']).".png\" width=\"25\" height=\"25\" /></li>" ;
            
               
                } ?>

                <ul id="activities_yes"><?=$activities_yes?></ul>
                <ul id="activities_no" ><?=$activities_no?></ul>
            </li>
            <li class="forcast_morning inv_plain_3_zebra">
            <div class="title"><? echo $EARLY_MORNING[$lang_idx];?></div>
            <div class="line">
            <div class="number"><?=c_or_f($forecastday['TempLow'])?>°</div><div class="cloth extra<?=$i?>"><a href="WhatToWear.php#<?=$prefTempLowCloth?>" rel="external" ><img src="<? echo "images/clothes/".$forecastday['TempLowCloth']; ?>" width="50" height="46" /><br/><?=getClothTitle($forecastday['TempLowCloth'], $forecastday['TempLow'],$forecastday['WindMorning'], $forecastday['HumMorning'])?></a></div>
            <div class="icon humidity extra<?=$i?>"><?=$forecastday['humMorning']?>% <?=$HUMIDITY[$lang_idx]?></div>
            <div class="icon extra<?=$i?>" id="morning_icon<?=$i?>"><a href="legend.php" rel="external" ><img  src="images/icons/day/<?=c_or_f($forecastday['iconmorning'])?>" width="50" height="50" alt="images/icons/day/<?=c_or_f($forecastday['iconmorning'])?>"/></a></div>
            </div>
            <div class="icon extra<?=$i?>" ><div class="wind_icon <?echo getWindInfo($forecastday['windMorning'], $lang_idx)['wind_class'];?>" title="<?echo getWindInfo($forecastday['windMorning'], $lang_idx)['windtitle']." - ".getWindInfo($forecastday['windMorning'], $lang_idx)['winddesc'];?>"><?=$forecastday['windMorning']." <span class=\"small\">".$KMH[$lang_idx]."</span>"?></div><div class="winddesc"><?echo getWindInfo($forecastday['windMorning'], $lang_idx)['windtitle']." - ".getWindInfo($forecastday['windMorning'], $lang_idx)['winddesc'];?></div></div>
            <div class="icon extra<?=$i?>" ><?=$DUST[$lang_idx]?><div class="number"><?=$forecastday['dustMorning']?>µg/m3</div> </div>
           
            </li>
            <li class="forcast_noon inv_plain_3_zebra">
            <div class="title"><? echo $NOON[$lang_idx];?></div>
            <div class="line">
            <div class="number"><?=c_or_f($forecastday['TempHigh'])?>°</div><div class="cloth extra<?=$i?>"><a href="WhatToWear.php#<?=$prefTempHighCloth?>" rel="external" ><img src="<? echo "images/clothes/".$forecastday['TempHighCloth']; ?>" width="50" height="46" /><br/><?=getClothTitle($forecastday['TempHighCloth'], $forecastday['TempHigh'],$forecastday['WindDay'], $forecastday['HumDay'])?></a></div>
            <div class="icon humidity extra<?=$i?>"><?=$forecastday['humDay']?>% <?=$HUMIDITY[$lang_idx]?></div>
             <div class="icon extra<?=$i?>" id="day_icon<?=$i?>"><a href="legend.php" rel="external" ><img  src="images/icons/day/<?=c_or_f($forecastday['icon'])?>" width="50" height="50" alt="images/icons/day/<?=c_or_f($forecastday['icon'])?>"/></a></div>
            </div>                                        
            <div class="icon extra<?=$i?>" ><div class="wind_icon <?echo getWindInfo($forecastday['windDay'], $lang_idx)['wind_class'];?>" title="<?echo getWindInfo($forecastday['windDay'], $lang_idx)['windtitle']." - ".getWindInfo($forecastday['windDay'], $lang_idx)['winddesc'];?>"><?=$forecastday['windDay']." <span class=\"small\">".$KMH[$lang_idx]."</span>"?></div><div class="winddesc"><?echo getWindInfo($forecastday['windDay'], $lang_idx)['windtitle']." - ".getWindInfo($forecastday['windDay'], $lang_idx)['winddesc'];?></div></div>
            <div class="icon extra<?=$i?> " > <?=$DUST[$lang_idx]?><div class="number"><?=$forecastday['dustDay']?>µg/m3</div></div>
            </li>
            <li class="forcast_night inv_plain_3_zebra">
            <div class="title" ><? echo $NIGHT[$lang_idx];?></div>
            <div class="line"><div id="night_icon_exp"> <?// echo $NIGHT_TEMP_EXP[$lang_idx];?></div>
            <div class="number"><?=c_or_f($forecastday['TempNight'])?>°</div><div class="cloth extra<?=$i?>"><a href="WhatToWear.php#<?=$prefTempNightCloth?>" rel="external" ><img src="<? echo "images/clothes/".$forecastday['TempNightCloth']; ?>" width="50" height="46" /><br/><?=getClothTitle($forecastday['TempNightCloth'], $forecastday['TempNight'],$forecastday['WindNight'], $forecastday['HumNight'])?></a></div>
            <div class="icon humidity extra<?=$i?>" ><?=$forecastday['humNight']?>% <?=$HUMIDITY[$lang_idx]?></div>
            <div class="icon extra<?=$i?>" id="night_icon<?=$i?>"><a href="legend.php" rel="external" ><img  src="images/icons/day/<?=c_or_f($forecastday['iconnight'])?>" width="50" height="50" alt="images/icons/day/<?=c_or_f($forecastday['iconnight'])?>"/></a></div>
            </div> 
            <div class="icon extra<?=$i?>" ><div class="wind_icon <?echo getWindInfo($forecastday['windNight'], $lang_idx)['wind_class'];?>" title="<?echo getWindInfo($forecastday['windNight'], $lang_idx)['windtitle']." - ".getWindInfo($forecastday['windNight'], $lang_idx)['winddesc'];?>"><?=$forecastday['windNight']." <span class=\"small\">".$KMH[$lang_idx]."</span>"?></div><div class="winddesc"><?echo getWindInfo($forecastday['windNight'], $lang_idx)['windtitle']." - ".getWindInfo($forecastday['windNight'], $lang_idx)['winddesc'];?></div></div>
            <div class="icon extra<?=$i?> " > <?=$DUST[$lang_idx]?><div class="number"><?=$forecastday['dustNight']?>µg/m3</div></div>
            </li>
            
        </ul>
            </li>
</ul>

</body>
</html>
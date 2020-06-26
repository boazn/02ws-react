<h1>
    <?=$LIKED_FORECAST[$lang_idx]?>
    <?
    $MAX_EMOTIONS = array("Max emotions", "מעוררי אמוציות");
    $MAX_DISLIKE_LIKE = array("Max dislike minus like", "הפרש גבוה של דיסלייק-לייק");
    $MAX_LIKE_DISLIKE = array("Max like minus dislike", "הפרש גבוה של לייק-דיסלייק");
    $MAX_DISLIKE = array("Max dislike", "הכי הרבה דיסלייק");
    $MAX_LIKE = array("Max like", "הכי הרבה לייקים");
    $LATEST = array("Latest", "החדשות ביותר");
    ?>
</h1>
<div class="clear"> </div>
<div id="ForecastDaysNavigator">
<a href="javascript:void(0)" onclick="javascript:OnClickGetForecastDays(this, 'likes', 'desc','', '')" class="inv_plain_3"><?=$MAX_LIKE[$lang_idx]?></a>
<!--<a href="javascript:void(0)" onclick="javascript:OnClickGetForecastDays(this, 'likes', 'asc','', '')" class="inv_plain_3">like asc</a>-->
<a href="javascript:void(0)" onclick="javascript:OnClickGetForecastDays(this, 'dislikes', 'desc','', '')" class="inv_plain_3"><?=$MAX_DISLIKE[$lang_idx]?></a>
<!--<a href="javascript:void(0)" onclick="javascript:OnClickGetForecastDays(this, 'dislikes', 'asc','', '')" class="inv_plain_3">dislike asc</a>-->
<a href="javascript:void(0)" onclick="javascript:OnClickGetForecastDays(this, 'likes-dislikes', 'desc','', '')" class="inv_plain_3"><?=$MAX_LIKE_DISLIKE[$lang_idx]?></a>
<a href="javascript:void(0)" onclick="javascript:OnClickGetForecastDays(this, 'dislikes-likes', 'desc','', '')" class="inv_plain_3"><?=$MAX_DISLIKE_LIKE[$lang_idx]?></a>
<a href="javascript:void(0)" onclick="javascript:OnClickGetForecastDays(this, 'dislikes+likes', 'desc','', '')" class="inv_plain_3"><?=$MAX_EMOTIONS[$lang_idx]?></a>
<a href="javascript:void(0)" onclick="javascript:OnClickGetForecastDays(this, 'updated_at', 'desc','', 'WHERE updated_at < DATE_ADD(CURDATE(), INTERVAL -5 DAY)')" class="inv_plain_3"><?=$LATEST[$lang_idx]?></a>
</div>
<div id="forecastDaysContainer">
   <div id="forecastnextdays_table" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="border-spacing:1px 8px;padding:3px;width:100%">
        
   </div> 
</div>
<script type="text/javascript" >
    function OnClickGetForecastDays(anchor, param, ascordesc, maxOrMin, condition){
        $('#ForecastDaysNavigator a').addClass('inv_plain_3');
        $('#ForecastDaysNavigator a').removeClass('inv_plain_3_zebra');
        $(anchor).removeClass('inv_plain_3');
        $(anchor).addClass('inv_plain_3_zebra');
        getForecastDays(param, ascordesc, maxOrMin, condition);
    }
    function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    function fillDays(jsonstr)
    {
       var tempunit = getParameterByName('tempunit');
       var json = JSON.parse(jsonstr);
       var forecastDays;
       forecastDays = "<table style=\"border-spacing:4px;width:100%\">";
       forecastDays += "<tr style=\"height:2em\">";
       forecastDays += "<th></th>";
       forecastDays += "<th id=\"morning_icon\"></th>";
       forecastDays += "<th id=\"noon_icon\"></td>";
       forecastDays += "<th id=\"night_icon\"></th>";
       forecastDays += "<th></th>";
       
       forecastDays += "<th><img src=\"js/tinymce/plugins/emoticons/img/good.png\" width=\"32px\" /></th>";
       forecastDays += "<th><img src=\"js/tinymce/plugins/emoticons/img/bad.png\" width=\"32px\" /></th>";
       forecastDays += "</tr>";
       for (i = 0; i< json.jws.forecastDays.length; i++){
            TempHighCloth = '&nbsp;<a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempHighCloth+'\" width=\"20\" height=\"15\" title=\"'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'</span></a>';
            TempNightCloth = '&nbsp;<a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempNightCloth+'\" width=\"20\" height=\"15\" title=\"'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'</span></a>';
            forecastDays += "<tr style=\"height:4em\">";
            link_for_yest = "";
            forecastDays += "<td class=\"tsfh\" style=\"text-align:center;line-height: 0.9em;\">" + link_for_yest + json.jws.forecastDays[i].day_name<?=$lang_idx?> + "<br />" + json.jws.forecastDays[i].date + '/'+ json.jws.forecastDays[i].updated_at +"</td>";
            forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(json.jws.forecastDays[i].TempLow, tempunit) +"</td>";
            forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(json.jws.forecastDays[i].TempHigh, tempunit) + TempHighCloth + "</td>";
            forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(json.jws.forecastDays[i].TempNight, tempunit) + TempNightCloth + "</td>";
            fulltextforecast = json.jws.forecastDays[i].lang<? echo $lang_idx;?>;
            forecastDays += "<td class=\"text\" style=\"width:200px;padding:0 0.2em 0 0.2em\">";
            forecastDays += "<img src=\"" + json.jws.forecastDays[i].icon + "\" width=\"32\" height=\"32\" alt=\"" + json.jws.forecastDays[i].icon +"\" />";
            forecastDays += fulltextforecast;
            forecastDays += "</td>";
            forecastDays += "<td class=\"text\" >" + json.jws.forecastDays[i].likes +"</td>";
            forecastDays += "<td class=\"text\" >" + json.jws.forecastDays[i].dislikes +"</td>";
            forecastDays += "</tr>";
       }
       forecastDays += "</table>";
       
       $('#forecastnextdays_table').html(forecastDays);
    }
    function c_or_f(temp, tempunit) {
        if (tempunit == '°F') {
            return ( Math.round(((9 * temp) / 5) + 32));
        }
        return temp;
    }
    function getForecastDays(param, ascordesc, maxOrMin, condition){
        $.ajax({
        type: "POST",
        url: "forecastlikes_service.php",
        data: {param:param,command:'get',ascordesc:ascordesc, maxOrMin:maxOrMin, condition:condition},
        }).done(function(str){fillDays(str);});
    }
     
</script>


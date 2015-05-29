<?  
    ini_set("display_errors","On");
    header("Content-type: text/css");
include ('ini.php');
$lang_idx = @$_GET['lang'];
$css_comp = explode (",",$_GET['type']);
function isHeb()
{
	global $lang_idx;
	return ($lang_idx == 1);
}
function get_s_align(){
    if (isHeb()) 
            return "right";
    else
            return "left";
}
function get_inv_s_align(){
        if (isHeb()) 
                return "left";
        else
                return "right";
}
function get_deg ($deg)
{
    if (isHeb()) return $deg; else return $deg - 40;
}
?>

/* ==========================================================================
				   FONTS
   ========================================================================== */

<!--@import url(http://fonts.googleapis.com/earlyaccess/droidarabickufi.css);-->
@font-face {
    font-family: 'Alef';
    src: url('fonts/Alef-Bold.eot');
    src: url('fonts/Alef-Bold.eot?#iefix') format('embedded-opentype'),
         url('fonts/Alef-Bold.woff') format('woff'),
         url('fonts/Alef-Bold.ttf') format('truetype'),
         url('fonts/Alef-Bold.svg#alefbold') format('svg');
    font-weight: bold;
    font-style: normal;

}
@font-face {
    font-family: 'Alef';
    src: url('fonts/Alef-Regular.eot');
    src: url('fonts/Alef-Regular.eot?#iefix') format('embedded-opentype'),
         url('fonts/Alef-Regular.woff') format('woff'),
         url('fonts/Alef-Regular.ttf') format('truetype'),
         url('fonts/Alef-Regular.svg#alefregular') format('svg');
    font-weight: normal;
    font-style: normal;

}
@font-face {
    font-family: 'nextexitfotlight';
    src: url('fonts/nextexitfot-light-webfont.eot');
    src: url('fonts/nextexitfot-light-webfont.eot?#iefix') format('embedded-opentype'),
         url('fonts/nextexitfot-light-webfont.woff') format('woff'),
         url('fonts/nextexitfot-light-webfont.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;

}
@font-face {
    font-family: 'nextexitfot_regularregular';
    src: url('fonts/nextexitfot-regular-webfont.eot');
    src: url('fonts/nextexitfot-regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('fonts/nextexitfot-regular-webfont.woff') format('woff'),
         url('fonts/nextexitfot-regular-webfont.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;

}
@font-face {
    font-family: 'ezerblock_oelight';
    src: url('fonts/ezerblock_oelight-webfont.eot');
    src: url('fonts/ezerblock_oelight-webfont.eot?#iefix') format('embedded-opentype'),
         url('fonts/ezerblock_oelight-webfont.woff') format('woff'),
         url('fonts/ezerblock_oelight-webfont.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;

}
@font-face {
    font-family: 'ezerblock_oe_regularregular';
    src: url('fonts/ezerblock_oeregular.eot');
    src: url('fonts/ezerblock_oeregular.eot?#iefix') format('embedded-opentype'),
         url('fonts/ezerblock_oeregular.woff') format('woff'),
         url('fonts/ezerblock_oeregular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;

}
/* ==========================================================================
				    GENERAL
   ========================================================================== */
body {
     background-color:#7DC1DF;
     background-image:url("../img/bg_blue.png");
     background-repeat: repeat;
     background-attachment:fixed;
     font-family:Alef;
     overflow-y: scroll;
    overflow-x: hidden;
    color:#2C3A42;
}


a {
    color:#2C3A42;
    text-decoration:none;
}

a :hover{
    text-decoration:none;
    color:inherit;
}

a:visited {
    text-decoration:none;
}

h1 {
font-size: 23px;
font-family: nextexitfotlight;
font-weight: normal;
margin-right: 0px;
padding-right: 0px;
border-bottom: solid;
line-height: 20px;
display:inline-block
}

h2 {
    font-family:nextexitfotlight;
    font-size:23px;
    color:#2C3A42;
    font-weight:normal;
    margin-bottom:10px;
    line-height:18px;
}


h3 {
    color:#2C3A42;
    font-family:Alef;
    font-weight:bold;
    font-size:18px;
    margin-bottom:2px;
    margin-top:15px;
    line-height:20px;
}

h4 {
    font-family:Alef;
    font-weight:bold;
    color:#4B6371;
    font-size:14px;
    font-weight:normal;
    margin-bottom:2px;
    margin-top:2px;
}
input[type="radio"], input[type="checkbox"] {
margin-top: -2px;
margin-left: 5px;
}

.container {
padding-top:8px;
}



/* ==========================================================================
				     WHAT NOW 
   ========================================================================== */

.main_info {
    text-align:center;
    margin-top:10px;
}

#info_circle {
    text-align:center;
    float:<?=get_s_align()?>;
    width:213px;
    height:213px;
    margin-left:130px;
    padding-right:0px;
    position:absolute;
    margin-top:25px;
}

.info_btns {
    position:relative;
    list-style:none;
    float:<?=get_s_align()?>;
    z-index:55;
    margin:0 <? if (isHeb()) echo "105"; else echo "80"; ?>px;
    <? if (!isHeb()) echo "direction:rtl;"; ?>
}

.info_btns li {
     width:36px;
    height:36px;
    background-position:left; 
}

.info_btns li:hover {
    background-position:right;
    cursor:pointer;
}

#now_btn {
    background-image:url("../img/now_icon.png");   
    
    margin-top:-13px;
    
}

#temp_btn {
    background-image:url("../img/temp2.png");
    margin-<?=get_inv_s_align()?>:40px;
    margin-top:-9px;
}

#moist_btn {
    background-image:url("../img/moist.png");
    margin-<?=get_inv_s_align()?>:70px;
    margin-top:2px;   
}

#air_btn {
    background-image:url("../img/air.png");
    margin-<?=get_inv_s_align()?>:83px;
    margin-top:8px;   
}

#wind_btn {
    background-image:url("../img/wind.png");
    margin-<?=get_inv_s_align()?>:81px;
    margin-top:9px;   
}

#rain_btn {
    background-image:url("../img/rain.png");
    margin-<?=get_inv_s_align()?>:65px;
    margin-top:7px;   
}

#rad_btn {
    background-image:url("../img/radiation.png");
    margin-<?=get_inv_s_align()?>:35px;
    margin-top:-3px;   
}

#uv_btn {
    background-image:url("../img/uv.png");
    margin-<?=get_inv_s_align()?>:-2px;
    margin-top:-12px;   
}
#aq_btn {
    background-image:url("../img/dust2.png");
    margin-<?=get_inv_s_align()?>:-46px;
    margin-top:-26px;
}

#cold_line {
     position:absolute;
   width:12px;
   opacity:0.7;
   margin-top:-44px;
   <?=get_s_align()?>:540px;
    -ms-transform:rotate(45deg); 
    -moz-transform:rotate(45deg); 
    -webkit-transform:rotate(45deg);
    -o-transform:rotate(45deg);
     visibility:hidden;
}

#mood_line {
     position:absolute;
   width:12px;
   opacity:0.7;
   margin-top:-16px;
   <?=get_s_align()?>:837px;
    -ms-transform:rotate(30deg); 
    -moz-transform:rotate(30deg); 
    -webkit-transform:rotate(30deg);
    -o-transform:rotate(30deg);
     visibility:hidden;
}

#season_line {
     position:absolute;
   width:12px;
   opacity:0.7;
   margin-top:-17px;
   <?=get_s_align()?>:848px;
    -ms-transform:rotate(15deg); 
    -moz-transform:rotate(15deg); 
    -webkit-transform:rotate(15deg);
    -o-transform:rotate(15deg);
     visibility:hidden;
}

#now_line {
     position:absolute;
   width:15px;
   opacity:0.7;
   margin-top:28px;
   <?=get_s_align()?>:<?if (isHeb()) echo "426"; else echo "400";?>px;
    -ms-transform:rotate(<?=get_deg(110)?>deg); 
    -moz-transform:rotate(<?=get_deg(110)?>deg); 
    -webkit-transform:rotate(<?=get_deg(110)?>deg);
    -o-transform:rotate(<?=get_deg(110)?>deg);
     visibility:visible;
}

#temp_line {
    position:absolute;
   width:15px;
   opacity:0.7;
   margin-top:52px;
   <?=get_s_align()?>:<? if (isHeb()) echo "393"; else echo "367"; ?>px;
    -ms-transform:rotate(130deg); 
    -moz-transform:rotate(130deg); 
    -webkit-transform:rotate(130deg);
    -o-transform:rotate(130deg);
     visibility:hidden;
}

#moist_line {
    position:absolute;
   width:15px;
   opacity:0.7;
   margin-top:82px;
   <?=get_s_align()?>:<? if (isHeb()) echo "369"; else echo "344"; ?>px;
    -ms-transform:rotate(145deg); 
    -moz-transform:rotate(145deg); 
    -webkit-transform:rotate(145deg);
    -o-transform:rotate(145deg);
     visibility:hidden;
}

#air_line {
   position:absolute;
   width:15px;
   opacity:0.7;
   margin-top:120px;
   <?=get_s_align()?>:<? if (isHeb()) echo "361"; else echo "336"; ?>px;
    -ms-transform:rotate(170deg); 
    -moz-transform:rotate(170deg); 
    -webkit-transform:rotate(170deg);
    -o-transform:rotate(170deg);
     visibility:hidden;
}

#wind_line {
    position:absolute;
   width:15px;
   opacity:0.7;
   margin-top:155px;
   <?=get_s_align()?>:<? if (isHeb()) echo "362"; else echo "337"; ?>px;
    -ms-transform:rotate(185deg); 
    -moz-transform:rotate(185deg); 
    -webkit-transform:rotate(185deg);
    -o-transform:rotate(185deg);
     visibility:hidden;
}

#rain_line {
    position:absolute;
   width:15px;
   opacity:0.7;
   margin-top:190px;
   <?=get_s_align()?>:<? if (isHeb()) echo "375"; else echo "349"; ?>px;
    -ms-transform:rotate(30deg); 
    -moz-transform:rotate(30deg); 
    -webkit-transform:rotate(30deg);
    -o-transform:rotate(30deg);
     visibility:hidden;
}

#rad_line {
    position:absolute;
   width:15px;
   opacity:0.7;
   margin-top:215px;
   <?=get_s_align()?>:<? if (isHeb()) echo "398"; else echo "373"; ?>px;
    -ms-transform:rotate(50deg); 
    -moz-transform:rotate(50deg); 
    -webkit-transform:rotate(50deg);
    -o-transform:rotate(50deg);
     visibility:hidden;
}

#uv_line {
    position:absolute;
   width:15px;
   opacity:0.7;
   margin-top:235px;
   <?=get_s_align()?>:<? if (isHeb()) echo "430"; else echo "404"; ?>px;
    -ms-transform:rotate(65deg); 
    -moz-transform:rotate(65deg); 
    -webkit-transform:rotate(65deg);
    -o-transform:rotate(65deg);
     visibility:hidden;
}

#aq_line{
      position:absolute;
   width:15px;
   opacity:0.7;
   margin-top:244px;
   <?=get_s_align()?>:<? if (isHeb()) echo "467"; else echo "441"; ?>px;
   -ms-transform: rotate(85deg);
	-moz-transform: rotate(85deg);
	-webkit-transform: rotate(85deg);
	-o-transform: rotate(85deg);
   visibility:hidden;
}

#graphs_line {
    position:absolute;
   width:<? if (isHeb()) echo "318"; else echo "295"; ?>px;
   opacity:0.5;
   top:-70px;
   <?=get_s_align()?>:<? if (isHeb()) echo "100"; else echo "100"; ?>px;
    -ms-transform:rotate(<? if (isHeb()) echo "20"; else echo "160"; ?>deg); 
    -moz-transform:rotate(<? if (isHeb()) echo "20"; else echo "160"; ?>deg); 
    -webkit-transform:rotate(<? if (isHeb()) echo "20"; else echo "160"; ?>deg);
    -o-transform:rotate(<? if (isHeb()) echo "20"; else echo "160"; ?>deg);
     
}

.winddir{
background-image:url("../img/wind_direction.png");
width: 22px;
height: 22px;
background-repeat: no-repeat;
margin-top: 2px;
}
.W{
-ms-transform:rotate(90deg);
-moz-transform: rotate(90deg);
-webkit-transform: rotate(90deg);
-o-transform: rotate(90deg);
}
.WSW{
-ms-transform:rotate(66deg);
-moz-transform: rotate(66deg);
-webkit-transform: rotate(66deg);
-o-transform: rotate(66deg);
}
.SW{
-ms-transform:rotate(44deg);
-moz-transform: rotate(44deg);
-webkit-transform: rotate(44deg);
-o-transform: rotate(44deg);

}
.SWS{
-ms-transform:rotate(22deg);
-moz-transform: rotate(22deg);
-webkit-transform: rotate(22deg);
-o-transform: rotate(22deg);
}
.S{

}
.SES{
-ms-transform:rotate(336deg);
-moz-transform: rotate(336deg);
-webkit-transform: rotate(336deg);
-o-transform: rotate(336deg);
}
.SE{
-ms-transform:rotate(314deg);
-moz-transform: rotate(314deg);
-webkit-transform: rotate(314deg);
-o-transform: rotate(314deg);
}
.ESE{
-ms-transform:rotate(292deg);
-moz-transform: rotate(292deg);
-webkit-transform: rotate(292deg);
-o-transform: rotate(292deg);
}
.E{
-ms-transform:rotate(270deg);
-moz-transform: rotate(270deg);
-webkit-transform: rotate(270deg);
-o-transform: rotate(270deg);
}
.ENE{
-ms-transform:rotate(246deg);
-moz-transform: rotate(246deg);
-webkit-transform: rotate(246deg);
-o-transform: rotate(246deg);

}
.NE{
-ms-transform:rotate(224deg);
-moz-transform: rotate(224deg);
-webkit-transform: rotate(224deg);
-o-transform: rotate(224deg);

}
.NNE{
-ms-transform:rotate(202deg);
-moz-transform: rotate(202deg);
-webkit-transform: rotate(202deg);
-o-transform: rotate(202deg);

}
.N{
-ms-transform:rotate(180deg);
-moz-transform: rotate(180deg);
-webkit-transform: rotate(180deg);
-o-transform: rotate(180deg);
}
.NNW{
-ms-transform:rotate(156deg);
-moz-transform: rotate(156deg);
-webkit-transform: rotate(156deg);
-o-transform: rotate(156deg);
}
.NW{
-ms-transform:rotate(134deg);
-moz-transform: rotate(134deg);
-webkit-transform: rotate(134deg);
-o-transform: rotate(134deg);
}
.WNW{
-ms-transform:rotate(112deg);
-moz-transform: rotate(112deg);
-webkit-transform: rotate(112deg);
-o-transform: rotate(112deg);
}
.seker_btns {
    margin-top:10px;
   <? if (!isHeb()) echo "direction:rtl;"; ?>
}

.seker_btns li {
    font-family:nextexitfotlight;
    width:100px;
    border-radius:15px;
    list-style:none;
    background:rgba(255, 255, 255, 0.6);
    padding-top:3px;
    padding-bottom:2px;
    font-size:18px;
    margin-bottom:10px;
}

.seker_btns li:hover {
    background:rgba(255, 255, 255, 1);
    cursor:pointer;
    
}
.seker_btns a:hover {
    text-decoration:none;
}

#cold_btn {
    margin-<?=get_inv_s_align()?>:75px;
}

#mood_btn {
    margin-<?=get_s_align()?>:34px;
}

#season_btn {
    margin-<?=get_inv_s_align()?>:40px;
}



.clothes_text {
    font-family:nextexitfotlight;
    font-size:18px;
    text-align:right;
    position:absolute;
    right:840px;
    float:right;
    visibility:hidden;
    color:#648395;
    line-height:19px;
    margin-left:10px;
}

#clothes_line {
     visibility:hidden;
 position:absolute;
   width:17px;
   opacity:0.7;
   margin-top:50px;
   right:830px;
   border-color:#648395;
    -ms-transform:rotate(-115deg); 
    -moz-transform:rotate(-115deg); 
    -webkit-transform:rotate(-115deg);
    -o-transform:rotate(-135deg);
}

/* ==========================================================================
				    FORCAST
   ========================================================================== */


#forcast_title {
    position: absolute;
    <?=get_s_align()?>:10px;
    width: 100px;
    margin-top:73px;
    border-<?=get_inv_s_align()?>:solid;
    border-color:#829CAA;
    border-width:1px;
    padding-<?=get_s_align()?>:8px;
    height:320px;
    margin-<?=get_s_align()?>:30px;
    <? if (isHeb()) echo "direction:rtl;"; ?>
    text-align:<?=get_inv_s_align()?>;
}


.forcast_title_btns {
    border-top-<?=get_s_align()?>-radius:15px;
    border-bottom-<?=get_s_align()?>-radius:15px;
    background-color:#BFA8C6;
    color:#FFF;
    font-family:nextexitfotlight;
    height:30px;
    margin-<?=get_s_align()?>:-20px;
    margin-bottom:10px;
    font-size:23px;
    padding-<?=get_inv_s_align()?>:10px;
    display:block;
    line-height:30px;
    text-align:<?=get_inv_s_align()?>;
    opacity:0.6;
    transition:all 200ms linear 0s
}

.forcast_title_btns:hover {
    background-color:#54BEB8;
    cursor:pointer;
    margin-<?=get_s_align()?>:-40px;
    padding-<?=get_inv_s_align()?>:30px;
    text-decoration:none;
    color:#fff;
}

.for_active {
     opacity:1;
}
.forcast_title_btns.for_active:hover{
margin-<?=get_s_align()?>:-20px;
padding-<?=get_inv_s_align()?>:10px;
background-color:#BFA8C6;
}

.moon_sun {
    font-size:14px;
    float:<?=get_inv_s_align()?>
    
}

#moon_rise:hover {
    color:#DD6B96;
    cursor:pointer;
}

#moon_rise {
    
    background-repeat:no-repeat;
    background-position:right;
    text-align:right;
    margin-right:10px;
    padding-top:6px;
    
     -webkit-transition-property:color; 
    -webkit-transition-duration: 200ms, 200ms; 
    -webkit-transition-timing-function: linear, ease-in;
}
#moon_img {
    opacity:0.5;
}

#moon_rise p {
    margin-bottom:0px;
    line-height:16px;
}

#sun_rise {
    background-image:url("../img/sun.png");
    background-repeat:no-repeat;
    background-position:<?=get_s_align()?>;
    text-align:<?=get_s_align()?>;
    height:40px;
    margin-<?=get_s_align()?>:5px;
    padding-top:6px;
    padding-<?=get_s_align()?>:50px;
    margin-top:16px;
    
    -webkit-transition-property:color; 
    -webkit-transition-duration: 100ms, 100ms; 
    -webkit-transition-timing-function: linear, ease-in;
}

#sun_rise:hover {
    color:#DD6B96;
    cursor:pointer;
}

#sun_rise p {
    margin-bottom:0px;
    line-height:16px;
}

#sun_hours h3{
    font-family:nextexitfotlight;
    font-size:32px;
    float:<?=get_s_align()?>;
    margin-<?=get_s_align()?>:0px;
    width:55px;
    text-align:center;
    font-weight:normal;
}

#sun_hours p {
    padding-top:15px;
    line-height:13px;
    text-align:<?=get_s_align()?>;
}

#forcast_icons {
    margin-<?=get_s_align()?>:<? if (isHeb()) echo "105px"; else echo "99px";?>;
    margin-bottom:0px;
    text-align:<?=get_s_align()?>;
    <? if (isHeb()) echo "direction:rtl"; ?>
}

#forcast_icons li{
    width:32px;
    height:25px;
   display:inline-block;
   vertical-align:middle;
   background-position:center;
   background-repeat:no-repeat;
   margin-left:20px;
   margin-bottom:5px;
}

#morning_icon {
    background-image:url("../img/morning_icon.png");
    vertical-align:middle;
}

#noon_icon {
    background-image:url("../img/noon_icon.png");
}

#night_icon {
    background-image:url("../img/night_icon.png");
}

#forcast_main {
    margin-top:30px;
    width:580px;
    <?=get_s_align()?>:145px;
    position:absolute;
    text-align:right;
    <? if (isHeb()) echo "direction:rtl;"; ?>
     overflow:hidden;
}

.contentbox-wrapper{
    position:relative;
    <?=get_s_align()?>:0;
    width:20000px;
    height:100%;
}

.contentbox{
    width:570px;
    height:100%;
    float:<?=get_s_align()?>;
    padding:5px;
    margin:0px;
}

#what_is_forcast {
    margin-<?=get_s_align()?>:-30px;
    width:850px;
    margin-top:40px;
    text-align:<?=get_s_align()?>;
}

#what_is_forcast p {
    margin-bottom:10px;
}

#what_is_forcast .span4 {
    margin-<?=get_s_align()?>: 5px;
    width: 655px;
}

#forcast_days {

}

#forcast_hours {
    margin-top:40px;
    margin-<?=get_s_align()?>:-5px;
    margin-<?=get_inv_s_align()?>:60px;
    text-align:<?=get_s_align()?>;
}

#forcast_hours li{
    text-align:center;
    list-style:none;
    display:inline-block;
    font-family: nextexitfot_regularregular;
    font-size: 1.3em;
}


#forcast_hours ul {
   font-size:13px;
}

#forcast_hours .forcast_each {
     margin-bottom:0;
}

#forcast_hours .forcast_date {
    letter-spacing:1px;
    margin-left:5px;
}

#forcast_hours .forcast_text {
    margin-right:20px;
    width:150px;
    text-align:right;

}

#forcast_hours  .forcast_morning {
    padding:0px;
    width:30px;
    
}
#for24_hours{
width:100%;
margin:0 auto
}

#forcast_days ul{
    font-family:nextexitfotlight;
    font-size:20px;
}

#forcast_table {
    margin-<?=get_s_align()?>:10px;
}
#forcast_table ul{
    margin-right:0px
}
#forcast_days li {
    list-style:none;
    display:inline-block;
    text-align:center;
	
    
}

.forcast_each {
    float:<?=get_s_align()?>;
    clear: both;
    <? if (isHeb()) echo "direction:rtl;"; ?>
    margin-bottom:5px;
}
.extra {
    line-height:1;
}
.extra .forcast_morning, .extra .forcast_noon{
margin:0
}
.forcast_each ul li
{
vertical-align:middle;
}
.forcast_off_day{
    width:20px;
    font-size:0.7em;
    line-height:10px;
    
}
.forcast_off_day:hover{
    cursor:pointer;
}
.forcast_day {
    <? if (isHeb()) echo "font-size:40px;"; ?>
    color:#DD6B96;
    margin-right:0px;
    width:25px;
}
.forecast_ad{
margin-<?=get_s_align()?>:10px
}
.forcast_date {
    letter-spacing:1px;
    width:40px;
}

.forcast_morning {
    margin-right:3px;width:40px;direction:ltr;
}
.forcast_noon, .forcast_night
{
	width:60px;
}

.forcast_morning, .forcast_noon, .forcast_night {
     margin-left:-3px;
      margin-top:-5px;
     padding-top:5px;
    
}
.forcast_text {
    margin-right:10px;
    font-family:Alef;
    font-size:14px;
	width:200px;
	text-align:<?=get_s_align()?> !important;
}
.extra .forcast_date {
    width:20px;
}
.tashkif .forcast_day {
    color:#648395;
}

.tashkif .forcast_day p{
    font-size:12px;
    font-family:Alef;
    margin-right:-5px;
    padding-right:0px;
    line-height:10px;
    padding-bottom:0px;
    margin-bottom:-19px;
    margin-top:2px;
    
}

#forcast_days li .multiline {
    line-height:18px;
    text-align:right;
    margin-top:-6px;
    vertical-align:middle;
}

.forcast_rain {
    background-image:url("../img/wt_rain.png");
}

.forcast_snow {
    background-image:url("../img/wt_snow.png");
}

.forcast_cloudy {
    background-image:url("../img/cloudy.png");
}

.forcast_sunRain {
    background-image:url("../img/sunRain.png");
}


.forcast_sunCloud, .forcast_sunHot, .forcast_sunDust, .forcast_sunny, .forcast_moon, .forcast_rain, .forcast_sunRain, .forcast_cloudy, .forcast_snow{
     background-repeat:no-repeat;
    vertical-align:middle;
    width:50px;
    height:30px;
}

.forcast_sunCloud {
    background-image:url("../img/sunCloud.png");
}

.forcast_sunHot {
    background-image:url("../img/sunHot.png");
}

.forcast_sunDust {
    background-image:url("../img/sunDust.png");
    height:40px;
    margin-bottom:-5px;
    margin-top:-5px;
    padding-right:7px;
    margin-left:-7px;
}

.forcast_sunny{
    background-image:url("../img/sunny.png");
}

.forcast_moon{
    background-image:url("../img/forcast_moon.png");
     padding-right:2px;
    margin-left:-2px;
}
.smalllogo{
	background-image:url("../img/sun_toolbar.png");
	background-repeat:no-repeat;
	background-position:<?=get_s_align()?>;
	display: inline-block;
    height: 21px;
    width: 23px;
}
#slogan{
<? if (isHeb()) echo "direction:rtl;"; ?>
text-align:<?=get_s_align()?>;
margin-bottom:8px;
margin-<?=get_s_align()?>: 20px;
z-index:9999;
}
#addthis_icon
{
display:inline-block;
vertical-align: bottom;
margin-<?=get_s_align()?>:0.5em
}
#mainadsense {
   margin-top:50px;
   float:<?=get_inv_s_align()?>;
   width:300px;
}
#now_stuff {
    margin-top:100px;
    height:160px;
    position:absolute;
    text-align:<?=get_s_align()?>;
    <?=get_inv_s_align()?>:10px;
    font-size:14px;
    <? if (isHeb()) echo "direction:rtl"; ?>
}

#now_stuff h2 {
    margin-bottom:3px;
}


.now_stuff_btns {
    border-top-left-radius:15px;
    border-bottom-left-radius:15px;
    background-color:#BFA8C6;
    color:#FFF;
    font-family:nextexitfotlight;
    height:30px;
    margin-right:-10px;
    margin-bottom:10px;
    font-size:23px;
    padding-right:10px;
    padding-left:20px;
    line-height:30px;
    background-image:url("../img/arrow_left.png");
    background-repeat:no-repeat;
    background-position:10px;
    text-align:left;
    
    -webkit-transition: all 200ms linear;
    -moz-transition: all 200ms linear;
    -o-transition: all 200ms linear;
    transition: all 200ms linear;
    
}

.now_stuff_btns:hover {
    background-color:#54BEB8;
    cursor:pointer;
    margin-left:-20px;
}

#month_peak {
    text-align:right;
    direction:ltr;
    margin-bottom:20px;
    line-height:14px;
    margin-top:20px;
}

#month_avarage {
    margin-right:0px;
    direction:ltr;
    text-align:right;
    line-height:14px;
}

#peak_max, #peak_min, #avarage_max, #avarage_min {
    background-repeat:no-repeat;
    background-position:right;
    padding-right:25px;
    margin-right:5px;
}

#peak_max {
    background-image:url("../img/peak_max.png");  
}

#peak_min {
    background-image:url("../img/peak_min.png");
}

#avarage_max {
    background-image:url("../img/avarage_max.png");
}

#avarage_min {
    background-image:url("../img/avarage_min.png");
}



/* ==========================================================================
				WHAT MORE
   ========================================================================== */

.now_messages {
    margin-top:70px;
    line-height:1.2em
}

.white_box {
    background:rgba(255, 255, 255, 0.7);
    <? if (isHeb()) echo "direction:rtl;"; ?>
    padding-bottom:20px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    position:relative;
    color:#3D718E;
}

.speach {
   
}

.speach:after {
    content:"";
    position:absolute;
    display:block;
    top:110px;
    left: -20px;
    bottom: auto;
    border-width: 12px 20px 12px 0;
    border-style: solid;
    border-color: 
    transparent 
    #fff;
    width: 0;
    opacity:0.7;
}

.white_box h2, .white_box p {
    padding-right:20px;
    padding-left:13px;
}

.white_box h2 {
    display:table;
    border-bottom:solid;
    border-width:1px;
    border-bottom-color:#CCD7DC;
    padding-bottom:8px;
    padding-top:10px;
    padding-left:0px;
   
}

a:visited h2{
    border-bottom-color:#CCD7DC;
}

.white_box p {
    margin-bottom:5px;
    font-size:14px;
    line-height:18px;
}

.now_messages .span4 {
    width:330px;
    margin-<?=get_s_align()?>:<? if (isHeb()) echo "320px"; else echo "380px"; ?>;
}

.now_messages a .white_box {
     background:rgba(255, 255, 255, 0.5);
}

.now_messages a,  #about a{
     color:#3D718E;
}

.now_messages a h2{
     color:#3D718E;
     direction:ltr
}

.now_messages a:hover {
    color:#DD6B96;
    cursor:pointer;
}

.now_messages a .white_box:hover {
     background:rgba(255, 255, 255, 0.7);
}

.now_messages a:hover h2{
    color:#DD6B96;
    cursor:pointer;
}

.more_stuff {
    <? if (isHeb()) echo "direction:rtl;"; ?>
    margin-top:0px;
}


.more_stuff h2{
    border-bottom:solid;
    border-width:1px;
    text-align:center;
    padding-bottom:5px;
}
#about {
}

#qrcode{
width:250px
}
#newsletter {
    position:absolute;
    width:140px;
    display:inline-block;
    margin-right:30px;
    margin-top:-70px;
}

.email_form .search-query{
    border:solid;
    border-color:#829CAA;
    border-top:none;
    border-width:1px;
    border-radius:0;
    height:15px;
    line-height:11px;
    width:130px;
    padding-left:5px;
    padding-right:5px;
    font-size:12px;
    color:#829CAA;
     background:rgba(255, 255, 255, 0.6);
}

.email_form input[type="submit"] {
    background-color:#fff;
    border:none;
    font-family:Alef;
    margin-top:5px;
    line-height:14px;
    color:#829CAA;
}

.email_form input[type="submit"]:hover {
     color:#3D718E;
}

#did_you_know {
     position:absolute;
    width:140px;
    
     margin-top:50px;
     line-height:18px;
}

#did_you_know a, #about{
    text-decoration:underline;
}

#alerts{
text-align:center
}
#outside_links {
    width:130px;
    <? if (isHeb()) echo "direction:rtl;"; ?>
}

#outside_links a{
    text-decoration:underline;
    display:block;
    color:#3D718E;
}

#outside_links a:hover {
    color:#DD6B96;
}

.more_icons {
   margin-<?=get_s_align()?>: 240px;
    margin-top: 10px;
    position: absolute;
}

.more_icons li{
    list-style:none;
    display:inline-block;
    font-family:nextexitfotlight;
    font-size:18px;
    margin-right:10px;
    
}

.more_icons a{
    display:inline-block;
    text-align:center;
    background-repeat:no-repeat;
    background-position:left;
    padding-top:100px;
    margin:0 5px;
    
}

.more_icons a:hover {
    cursor:pointer;
    background-position:right;
    text-decoration:none;
    color:#3D718E;
}
#weather_israel {
    background-image:url("../img/weather_israel.png");
    width:75px;
}

#weather_hul {
    background-image:url("../img/weather_hul.png");
    width:82px;
}

#weather_movies {
    background-image:url("../img/weather_movies.png");
    width:88px;
}

#weather_songs {
    background-image:url("../img/weather_songs.png");
    width:74px;
}

#snow_poems {
    background-image:url("../img/snow_poems.png");
    width:85px;
}
#fb_like{
margin-top:10px
}
#ftr_icons {
    text-align:center;
    margin-<?=get_s_align()?>:10px;
}
#ftr_icons li{
	display:inline-block;
	list-style: none outside none;
	margin:0em ;
	line-height:22px;
}

#ftr_icons a {
    margin-right:2px;
    margin-left:2px;
    width:42px;
    height:42px;
    float:<?=get_inv_s_align()?>;
}
#ftr_icons a:hover{
background-position:right;
}
.addthis_default_style .at300m{
padding:2px;
}

#rss {
    background-image:url("../img/rss.png");
}

#twitter {
    background-image:url("../img/twitter.png");
}

#facebook {
    background-image:url("../img/facebook.png");
}

#addthis {
    background-image:url("../img/addthis.png");
}




/* ==========================================================================
				PICTURES (MAP) STUFF
   ========================================================================== */

.upload_to_map :hover {
    cursor:url("../img/cursor_upload.png"), auto;
}
#album{
    <?=get_inv_s_align()?>: 10px;
	position: absolute;
	top: 580px;
	font-size: 1.3em;
	background-color: 
	rgba(255, 255, 255, 0.5);
	border-radius: 50px;
	padding-right: 10px;
	padding-left: 10px;
	direction: rtl;
}
#album a{
	color:#2C3A42;
}
#album a:hover {
	color:#648395;
}
#pic_empty {
    position:absolute;
    width:600px;
    height:400px;
    left:300px;
}

#upload_window {
    position:absolute;
    left:300px;
    height:295px;
    width:295px;
     background:rgba(255, 255, 255, 0.8);
     border-radius:50%;
     z-index:700;
     text-align:center;
     visibility:hidden;
}

.close_icon {
    background-image:url("../img/close.png");
    background-position:left;
    height:32px;
    width:32px;
    display:inline-block;
    margin-left:10px;
}

.close_icon:hover {
    background-position:right;
}

.okay_close {
    margin-top:110px;
}

.okay_icon {
    background-image:url("../img/okay_icon.png");
    background-position:left;
    height:32px;
    width:32px;
    display:inline-block;
}

.okay_icon:hover {
    background-position:right;
}

#upload_form input[type="file"] {
    <? if (isHeb()) echo "direction:rtl;"; ?>
  margin-right:0px;
  margin-top:50px;
  width:80px;
  opacity:0;
}

#upload_btn {
    margin-top:-35px;
    background-color:#C0CE61;
    color:#fff;
    background-image:url("../img/file_icon.png");
    background-position:75px;
    padding-right:15px;
    background-repeat:no-repeat;
    width:80px;
    border-radius:5px;
    margin-left:100px;
}


#upload_form input[type="text"], #upload_form textarea {
     text-align:right;
     color:#829CAA;
     font-family:Alef;
     margin-top:15px;
     margin-bottom:0px;
}

#upload_form textarea {
    width:120px;
    height:70px;
    float:right;
    margin-right:37px;
    resize:none;
}

#pic_holder {
    position:absolute;
     height:75px;
     width:75px;
     margin-left:40px;
     margin-top:16px;
     border:dashed;
     border-width:1px;
     border-color:#829CAA;
}

#upload_text {
    position:absolute;
    color:#fff;
    line-height:20px;
    text-align:center;
    margin-top:-140px;
    width:200px;
    left:390px;
    visibility:hidden;
}

#upload_pic {
    position:absolute;
    background-image:url("../img/upload_pic.png");
    background-position:left;
    background-repeat:no-repeat;
    height:45px;
    width:46px;
    font-size:23px;
    line-height:20px;
    font-family:nextexitfotlight;
    color:#fff;
    padding-top:100px;
    text-align:center;
    left:335px;
    margin-top:260px;
    z-index:50;
}
.webcam_image
{
	float:<?echo get_s_align();?>;padding:0.5em 0.8em;margin:0 auto;width:40%
}
.image_enlarge
{
	padding:0.2em;margin:0.2em 3em;
}
#webcam_container
{
	width:100%;clear:both;text-align:<?echo get_s_align();?>;
}
#webcam_list
{
	text-align:<?echo get_s_align();?>; 
	float:<?echo get_s_align();?>;
	margin:1em;
	width:300px;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
.webcam_desc
{
	float:<?echo get_s_align();?>;width:90%;margin:0.5em;padding:0.5em;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#webcam_desc fieldset
{
	padding:0.5em
}

#upload_pic:hover {
     background-position:right;
     color:#3D718E;
}

.white_box2, .chosenreply {
    background:rgba(255, 255, 255, 0.5);
    <? if (isHeb()) echo "direction:rtl;"; ?>
    padding-bottom:20px;
    position:relative;
    -moz-box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    padding-bottom:10px;
    height:auto;
}

.white_box2 a {
    text-decoration:underline;
    color:#3D718E;
}


#live_pic p, #picoftheday p{
    margin-top:20px;  
   margin-bottom:10px;    
   height:40px;
   line-height:14px;
   margin-<?=get_s_align()?>:10px
}

.white_box2 a:hover {
    cursor:pointer;
    color:#DD6B96;
}

#pic_stuff {
     margin-top:50px;
}

#pic_frame {
    z-index:98;   
    overflow:hidden;
}

#pic_frame img {
    float:<?=get_inv_s_align()?>;
    margin-<?=get_inv_s_align()?>:10px;
    height:180px;
    width:180px;
    max-height:none;
    max-width:none;
}


#picoftheday h3, h4 , #live_pic h3 {
    text-align:<?=get_s_align()?>;
}



#pic_contentbox {}

#pic_frame .contentbox-wrapper{
    position:relative;
    padding:0;
    margin:0;
    right:0;
    width:1500px;
    height:100%;
}

#pic_frame .contentbox{
    width:200px;
    height:100%;
    float:<?=get_s_align()?>;
    padding:0;
    margin:0;
    margin-bottom:10px;

}
.user_icon_frame
{
    width:36px;
    overflow: hidden;
    margin-<?=get_s_align()?>:40px;
}
#user_icon_contentbox
{
    position:relative;
    padding:0;
    margin:0;
    right:0;
    width:828px;
    height:100%;
}
#user_icon_contentbox .contentbox {
    float: right;
    height: 100%;
    margin: 0 0 2px;
    padding: 0;
    width: 36px;
}
.icon_left, .icon_right {
    background-repeat:no-repeat;
    height:26px;
    width:13px;
	margin-<?=get_s_align()?>: 6px;
    position:absolute;
    margin-top: -30px;   
}

.icon_left {
    background-image:url("../img/pic_left.png");
    <?if (isHeb()){?>margin-right:76px;<?}?>;
    padding-left: 10px;
}

.icon_right {
    padding-right: 10px;
    background-image:url("../img/pic_right.png");
     <?if (!isHeb()){?>margin-left:76px;<?}?>
}

#icon_left:hover {
    margin-left:-40px;
    cursor:pointer;
}

#icon_right:hover {
    margin-left:320px;
    cursor:pointer;
}

#live_pic h3, #picoftheday h3 {
    padding-top:10px;
    font-family: ezerblock_oe_regularregular;
    font-weight: normal;
    padding-<?=get_s_align()?>: 5px;
}

#live_pic object {
    margin-right:10px;
    margin-top:10px;
}
#user_icon_contentbox .contentbox div{
	height:36px;
    width:36px;
	background-repeat:no-repeat;
}
.avatar {
     position:absolute;
    height:36px;
    width:36px;
    margin-right:10px;
    margin-top:15px;
	background-repeat:no-repeat;
}

.picoftheday_avatar {
    background-image:url("../img/picoftheday_avatar.png");
}

.live_avatar {
    background-image:url("../img/live_avatar.png");
}

.user_avatar1 {
    background-image:url("../img/user_icon/user_avatar1.png");
}

.user_avatar2 {
    background-image:url("../img/user_icon/user_avatar2.png");
}

.user_avatar3 {
    background-image:url("../img/user_icon/user_avatar3.png");
}

.user_avatar4 {
    background-image:url("../img/user_icon/user_avatar4.png");
}

.user_avatar5 {
    background-image:url("../img/user_icon/user_avatar5.png");
}

.user_avatar6 {
    background-image:url("../img/user_icon/user_avatar6.png");
}
.user_avatar7 {
    background-image:url("../img/user_icon/user_avatar7.png");
}

.user_avatar8 {
    background-image:url("../img/user_icon/user_avatar8.png");
}

.user_avatar9 {
    background-image:url("../img/user_icon/user_avatar9.png");
}

.user_avatar10 {
    background-image:url("../img/user_icon/user_avatar10.png");
}

.user_avatar11 {
    background-image:url("../img/user_icon/user_avatar11.png");
}

.user_avatar12 {
    background-image:url("../img/user_icon/user_avatar12.png");
}
.user_avatar13 {
    background-image:url("../img/user_icon/user_avatar13.png");
}
.user_avatar14 {
    background-image:url("../img/user_icon/user_avatar14.png");
}
.user_avatar15 {
    background-image:url("../img/user_icon/user_avatar15.png");
}
.user_avatar16 {
    background-image:url("../img/user_icon/user_avatar16.png");
}
.user_avatar17 {
    background-image:url("../img/user_icon/user_avatar17.png");
}
.user_avatar18 {
    background-image:url("../img/user_icon/user_avatar18.png");
}
.user_avatar19 {
    background-image:url("../img/user_icon/user_avatar19.png");
}
.user_avatar20 {
    background-image:url("../img/user_icon/user_avatar20.png");
}
.user_avatar21 {
    background-image:url("../img/user_icon/user_avatar21.png");
}
.user_avatar22 {
    background-image:url("../img/user_icon/user_avatar22.png");
}
.user_avatar23 {
    background-image:url("../img/user_icon/user_avatar23.png");
}
.user_avatar24 {
    background-image:url("../img/user_icon/user_avatar24.png");
}

.pic_user  p {
    margin-top:10px;
}

.pic_user img {
    margin-top:10px;
}

.pic_user h3{ 
margin-<?=get_s_align()?>:45px;
 
}
 .pic_user h4{
margin-<?=get_s_align()?>:96px;
}



#map_thumbs img {
    height:30px;
    width:30px;
    position:absolute;
    z-index:55;
    border:solid;
    border-color:#fff;
    border-width:2px;
}

#map_thumbs img:hover {
    cursor:pointer;
}

#pic_thumb1 {
    top: 400px;
    left: 520px;
}

#pic_thumb2 {
    top: 550px;
    left: 610px;
}

#pic_thumb3 {
    top:430px;
    left:500px;
}

#pic_thumb4 {
    top:450px;
    left:620px;
}

#pic_thumb5 {
    top:370px;
    left:640px;
}

/* ==========================================================================
				FORUM
   ========================================================================== */

#forum .container {
    z-index:20;
    margin-top:0px;
    min-height: 1800px
}


#forum .span3 {
    margin-left:-7px;
    width:278px;
}
#msgDetails{
       
}
#msgDetails .white_box2, #msgDetails .chosenreply{
   
    width: 49.4%;
   
}
.chatdate
{
	width:7%;float:<?echo get_inv_s_align();?>;margin:0.4em 0;
	font-style: italic;position: absolute;left:70px;top:-20px
	
}
.chatmainbody
{
	margin:0.4em;width:96%;float:<?echo get_s_align();?>;line-height:18px;
}
.chatseperator
{
 margin:0 0.2em;
 position: absolute;
 right: -1px;
}

.chatreply
{
	margin:0.4em;text-align:<?echo get_s_align();?>;float:<?echo get_s_align();?>;width:10%
}
.chatdatereply, .msgcount
{
opacity: 0.5;
margin-<?echo get_s_align();?>:8px;

}
.pic_user .msgcount
{
margin-top:0.2em
}
.pic_user .datestart{
 font-weight:normal
}
.chataftersepreply
{
 margin: 0 0.1em;
 width: 100%;
 position:relative
}
.chatnamereply
{
  margin: 0 0.1em
}
.chatbodyreply
{
	width: 85%;
        margin-<?echo get_s_align();?>:20px;
	word-wrap: break-word;
	white-space:normal;
	white-space:-moz-pre-wrap;
}
.chatbodyreply .avatar
{
    <?echo get_s_align();?>:-12px;
}

.firstreplyline .chatdatereply{
	position:relative;
	left:0;
}
.chatthreadcell
{
	float:<?echo get_s_align();?>;
	text-align:<?echo get_s_align();?>;
	width:100%;
	height:auto
}
.chatthreadcell .chatdatereply
{
position:relative;
}
#reportcontrols select
{
	width:100px
}
#middleadsense_container
{
	float:<?echo get_inv_s_align();?>;
}
#middleadsense{
height:100px;
margin-top:50px;
width:730px;
float:left;
background-color:#fff;
padding-top: 12px;
padding-left: 7px;
border-right: solid;
padding-right: 5px;
padding-bottom: 2px;
border-width: 5px;
border-color:#829CAA;
}
#plane{
	float:left;
	width:150px;
	margin-top: 50px;
}
#new_post_btn {
    background-image:url("../img/new_post.png");
    background-position:left bottom;
    background-repeat:no-repeat;
    height:51px;
    width:51px;
    font-size:23px;
    line-height:20px;
    font-family:nextexitfotlight;
    color:#fff;
    padding-bottom:50px;
    text-align:center;
    margin-right:20px;
}

#new_post_btn:hover {
    background-position:right bottom;
}
#subject_container{
    padding-top:10px;
}
#forum_rules {
    margin-right:40px;
}

#forum_rules li{
    
}
.replyname
{
	font-weight:bold;
}
#new_post, #replyInputsDiv {
    margin-top:20px;
    margin-bottom:5px;
    padding-bottom:5px;
    visibility:hidden;
    position:absolute;
}

#replyInputsDiv{
    position:relative;
    margin-top:50px;
	margin-<?=get_s_align()?>:0;
	z-index:1000;
}
#new_post:after, #replyInputsDiv:after {
    content:"";
    position:absolute;
    display:block;
    top:-20px;
    margin-<?=get_s_align()?>: 40px;
    bottom: auto;
    border-width: 20px 20px 0 0;
    border-style: solid;
    border-color: 
    transparent 
    #fff;
    width: 0;
    opacity:0.7;
}

#new_post .span7, #replyInputsDiv .span7  {
    margin-<?=get_s_align()?>:5px;
	margin-top: 20px;
}

#new_post .span2, #replyInputsDiv .span2 {
    margin-<?=get_s_align()?>:5px;
    text-align:center;
}
#new_post_container{
	margin-<?=get_s_align()?>:0;
}
#new_post p, #replyInputsDiv p{
    color:#829CAA;
    margin-top:10px;
}

#new_post textarea, #replyInputsDiv textarea{
    margin-<?=get_s_align()?>:7px;
    width:600px;
    resize:none;
    height:110px;
    font-family:Alef;
}
#msgDetails .white_box{
 background: rgba(255, 255, 255, 0.95)
}
#subject_icon {
     height:38px;
     background-repeat:no-repeat;
     width:37px;
     margin-<?=get_inv_s_align()?>:50px;
     margin-top:5px;
}

#subject_left, #subject_right {
     height:15px;
     width:10px;
     background-repeat:no-repeat;
     opacity:0.6;
}

#subject_left:hover, #subject_right:hover {
    opacity:1;
    cursor:pointer;
}

#subject_left {
     background-image:url("../img/subject_left.png");
    float: <?=get_inv_s_align()?>;
    margin-<?=get_inv_s_align()?>: -55px;
    margin-top: 15px;
}

#subject_right {
     background-image:url("../img/subject_right.png");
     margin-<?=get_s_align()?>:52px;
    margin-top: 20px;
    margin-bottom: 20px;
}

#new_post_private{
margin:2px 10px 0 10px;
float: <?=get_s_align()?>;width:120%

}
#new_post_okay, #new_post_cancel {
    background-color:#C0CE61;
    color:#fff;
    width:60px;
    border-radius:5px;
    display:inline-block;
    margin-top:5px;
    padding:5px 8px;
    float:<?=get_s_align()?>;
}

#new_post_okay:hover, #new_post_cancel:hover {
    background-color:#B1BE5A;
    cursor:pointer;
}

#new_post_user {
    background-repeat:no-repeat;
    background-position:right;
    
   height:51px;
   width:51px;
   margin-top:-81px;
   margin-bottom:30px;
   margin-right:27px;
}

.new_post_icons {
    float:left;
    width:100px;
    margin-top:-30px;
}

#new_post_link, #new_post_pic, #new_post_bold, #new_post_emoticon {
    width:22px;
    height:22px;
    display:inline-block;
    background-repeat:no-repeat;
    opacity:0.6;
}

#new_post_link:hover, #new_post_pic:hover, #new_post_bold:hover, #new_post_emoticon:hover {
    opacity:1;
}

#new_post_link {
    background-image:url("../img/new_post_link.png");
}

#new_post_pic {
    background-image:url("../img/new_post_pic.png");
}

#new_post_bold {
    background-image:url("../img/new_post_bold.png");
}

#new_post_emoticon {
    background-image:url("../img/new_post_emoticon.png");
}


#posts  {
    padding-bottom:20px;
    margin-bottom:5px;
	margin-top: 10px;
	min-height: 1200px;
}

.postusername
{
font-weight:bold;margin: 0 8px;float:<?echo get_s_align();?>;width: auto;
}
.footer {
color: #fff;
font-size: 12px;
background-image: url("../img/footer_sun.png");
background-repeat: no-repeat;
background-position: center;
height: 20px;
text-align: left;
width: 53%;
left:480px;
bottom: 10px;
position: absolute;
margin-top: 30px;
border-top: solid;
border-width: 1px;
padding-top: 5px;
}

.footer a {
color: #fff;
}
.footerinsection{
    bottom: -80px;
    left:0;
    width:100%
}

#posts img{
   max-width: 320px;
   height: auto;
   margin-right:8px;
}
#forum_grass {
    background-image:url("../img/forum_grass.png");
    background-repeat:no-repeat;
    width:2000px;
    height:120px;
    position:absolute;
    margin-top:-117px;
    left:70px;
}

#forum hr {
    margin-top:5px;
    margin-bottom:10px;
    float:<?=get_inv_s_align()?>;
    width:790px;
    margin-left:10px;
    height:1px;
    border:0;
    color:#fff;
    background-color:#fff;
}


#forum_sidebar {
    width:195px;
    position:absolute;
    margin-right:30px;
    float:right;
    margin-top:220px;
    <? if (isHeb()) echo "direction:rtl;"; ?>
    text-align:right;
}

#forum_sidebar ul {
    border-top:solid;
    border-color:#fff;
    border-width:1px;
    padding-top:10px;
    margin-top:120px;
    margin-right:0px;
    margin-left:30px;
}

#forum_sidebar li {
    list-style:none;
    color:#fff;
    font-family:nextexitfotlight;
    font-size:18px;
    letter-spacing:3px;
    line-height:24px;
}


#forum_sidebar li:hover {
    color:#DD6B96;
    cursor:pointer;
}

#forum_sidebar ul .selected {
    font-family:nextexitfot_regularregular;
    color:#3D718E;
}

#forum_sidebar h2 {
    margin-left:30px;
    margin-top:30px;
    text-align:center;
    border-bottom:solid;
    color:#fff;
    border-color:#fff;
     border-width:1px;
     padding-bottom:5px;
}

#forum_sidebar .searchForm {
    margin:0;
    margin-right:0px;
    float:right;
    margin-bottom:30px;
}

#forum_sidebar .search-query {
}

#forum_sidebar .searchForm input[type="submit"] {
    margin:0;
    margin-top:3px;
}

#forum_sidebar .searchForm input[type="submit"]:hover {
    background-color:#2C3A42;
}

#forum_filter {
    margin-right:-20px;
    width:195px;
}

.filter_icon1, .filter_icon2, .filter_icon3, .filter_icon4, .filter_icon5, .filter_icon6, .filter_icon7, .filter_icon8  {
    background-image:url("../img/filter_icons.png");
    height:37px;
    width:37px;
    float:left;
    margin-left:7px;
}

.filter_icon1 {
    background-position:-1px;
}

.filter_icon2 {
    background-position:-38px;
}

.filter_icon3 {
    background-position:-75px;
}

.filter_icon4 {
    background-position:-112px;
}

.filter_icon5 {
    background-position:-149px;
}

.filter_icon6 {
    background-position:-186px;
}

.filter_icon7 {
    background-position:-223px;
}
.filter_icon8 {
    background-position:-260px;
}


#forum .white_box2 ,#forum .chosenreply{
    padding-top:10px;
    margin-bottom:10px;
}
#forum .white_box2 div.chatfirstbody, #forum .chosenreply div.chatfirstbody{
    padding-right:10px;
    padding-left:10px;
    margin-bottom:5px;
}
#forum .white_box2 div.chataftersepreply, #forum .chosenreply div.chataftersepreply{
    padding-right:15px;
    padding-left:15px;
    margin-bottom:5px;
}

#forum h3 {
    font-size:14px;
    line-height:18px;
    margin-top:0px;
}

#forum .avatar {
    margin-top:0px;
}

.alerttime{
 font-weight: bold;
 padding:0 1em
}
.comment_btn {
    color:#648395;
    text-decoration:underline;
	background:transparent;
    background-image:url("../img/comment_plus.png");
    background-repeat:no-repeat;
    background-position:right;
    padding:5px;
    margin-right:30px;
    padding-right:18px;
	border:none;
	cursor:pointer;
}

.comment_btn:hover {
    color:#DD6B96;
    cursor:pointer;
}
.pivotpointer{clear:both;}
.post_icon1, .post_icon2, .post_icon3, .post_icon4 {
     height:51px;
    width:51px;
    background-repeat:no-repeat;
    margin-right:85px;
    display:block;
    margin-bottom:10px;
}

.post_icon1 {
    background-image:url("../img/post_icon1.png");
}

.post_icon2 {
    background-image:url("../img/post_icon2.png");
}

.post_icon3 {
    background-image:url("../img/post_icon3.png");
}

.post_icon4 {
    background-image:url("../img/post_icon4.png");
}

.post_reply {
    margin-right:10px;
    border-right:solid;
    border-width:1px;
    border-color:#829CAA;
}


.admin_avatar {
      background-image:url("../img/admin_avatar.png");
}

.admin {
    color:#D8575A;
}



#hill1 {
    position:absolute;
    top:980px;
    left:0px;
}

#hill2 {
    position:absolute;
    top:-60px;
    left:100px;
}

#hill3 {
    position:absolute;
    top:-100px;
    left:1300px;
}

#hill4 {
    position:absolute;
    top:800px;
    left:1600px;
}

#hill5 {
    position:absolute;
    top:0px;
    left:1500px;
}

#hill6 {
    position:absolute;
    top:600px;
    left:0px;
}

/* ==========================================================================
				FIXED NAVIGATION
   ========================================================================== */

#logo{
	background-image:url("../img/logo<?if (!isHeb()) echo "_sun_eng"?>.png");
	width:113px;
	height: 112px;
	position:fixed;
	background-repeat:no-repeat;
	z-index:1000;
        margin-<?echo get_s_align();?>:10px;
}
#logo a{
        width:100%;
        height:100%;
	 display: inline-block;
}
.fixed_nav {
    <? if (isHeb()) echo "direction:rtl;"; ?>
    margin-<?echo get_s_align();?>:30px;
}

.main_nav {
    position:fixed;
    text-align:center;
    padding:0;
    margin-top:25px;
    margin-<?echo get_s_align();?>:8px;
    top:200px;
    z-index:300;
}
.not_fixed_nav{
<? if (isHeb()) echo "direction:rtl;"; ?>
}
.not_fixed_nav .main_nav{
    position:absolute
}
.not_fixed_nav #logo{
    position:absolute
}
.main_nav li {
    list-style:none;
    margin-bottom:5px;
}

.now, .forum, .pics, .more {
    letter-spacing:2px;
    font-family:ezerblock_oe_regularregular;
    font-size:16px;
    color:#2C3A42;
    padding: 2px 10px;
    display:inline-block;
    
}

.active{
    border-radius:15px;
    color:#FFFFFF;
    text-decoration:none;
    background-color:#2C3A42;
    border-style:none;
}

.main_nav a:hover {
    color:#FFFFFF;
    text-decoration:none;
}

#lion {
    background-image:url("../img/lion2.png");
    width:200px;
    height:170px;
    background-position:left;
    background-repeat:no-repeat;
    position:fixed;
    top:140px;
    margin-left:19px;
    z-index:99;
}


#cloud_lion {
    top:190px;
    position:absolute;
    z-index:-1;
}

/* ==========================================================================
				    MAIN ARTICLES
   ========================================================================== */

#content {
	
	position: relative;
	line-height: 1.7;   
	
	}
	#content article {
		}                     
		#now {
			position: absolute;
			width:1020px;
			float:right;
			z-index: 13;
			}
        #forecast {
			position: absolute;
			top: 280px;
			width:1020px;
			float:right;
			z-index: 200;
			}
		#more {
			position: absolute;
			top: 720px;
			width:1020px;
			float:right;
			z-index: 13;
			}
		#pics {
			position: absolute;
			top: 1530px;
			z-index: 13;
			}
		#section {
			position: absolute;
			top: 320px;
			width:1020px;
			float:right;
			z-index: 200;
			text-align:<?=get_s_align()?>
		}
		#forum {
			position: absolute;
			top: 2450px;
			 background-color: #C0CE61;
			
			width:2000px;
			left:-500px;
			z-index:16;
			<? if (isHeb()) echo "direction:rtl"; ?>
			}


/* ==========================================================================
				    CLOUDS
   ========================================================================== */

#cover_clouds-1 {
    position:absolute;
    top: 880px;
    left: -100px;
     z-index: 103;
}

#cover_clouds-2 {
    position:absolute;
   top: 910px;
    left: 170px;
    z-index:101;
}

#cover_clouds-3 {
    position:absolute;
    top: 910px;
    right: 20px;
    float:right;
     z-index:102;
}

#cover_clouds-4 {
    position:absolute;
    top: 840px;
    right: -90px;
    float:right;
     z-index:100;
}
.cloud1, .cloud2, .cloud3, .cloud4, .cloud-big,
.cloud1-more, .cloud2-more, .cloud3-more, .cloud4-more, .cloud-big-more {
    border-radius: 100%;
    display: inline-block;
    position: absolute;
}

.cloud1:after, .cloud1:before, .cloud1-more:after,
.cloud2:after, .cloud2:before, .cloud2-more:after, .cloud2-more:before,
.cloud3:after, .cloud3:before, .cloud3-more:after, .cloud3-more:before,
.cloud4:after, .cloud4:before, .cloud4-more:after, .cloud4-more:before,
.cloud-big:after, .cloud-big:before, .cloud-big-more:after, .cloud-big-more:before {
    content: '';
    border-radius: 100%;
    position: absolute;
}

.cloud1 {
    height: 30px;
    width: 140px;
}

.cloud1:after {
   height: 35px;
    right: -5px;
    top: -12px;
    width: 40px;
}
.cloud1:before {
    height: 40px;
    left: -4px;
    top: -14px;
    width: 50px;
}

.cloud1-more {
    height: 60px;
    top: -30px;
    left:30px;
    width: 60px;
}

.cloud1-more:after {
    height: 40px;
    top: 5px;
    left:45px;
    width: 40px;
}

.cloud2 {
    height: 30px;
    width: 200px;
     
}

.cloud2:after {
    height: 40px;
    right: -7px;
    top: -14px;
    width: 80px;
}
.cloud2:before {
    height: 35px;
    left: -4px;
    top: -11px;
    width: 50px;
}

.cloud2-more {
    height: 80px;
    top: -50px;
    left:50px;
    width: 80px;
}

.cloud2-more:after {
     height: 50px;
    top: 15px;
    left:60px;
    width: 60px;
}

.cloud2-more:before {
     height: 40px;
    top: 20px;
    right:65px;
    width: 40px;
}

.cloud3 {
    height: 30px;
    width: 150px;
     
}

.cloud3:after {
    height: 35px;
    right: -5px;
    top: -12px;
    width: 40px;
}
.cloud3:before {
   height: 40px;
    left: -4px;
    top: -14px;
    width: 50px;
}

.cloud3-more {
     height: 80px;
    top: -50px;
    left:55px;
    width: 80px;
}

.cloud3-more:before {
    height: 50px;
    left: -30px;
    top: 14px;
    width: 50px;
}

.cloud4 {
    height: 30px;
    width: 180px;
     
}

.cloud4:after {
    height: 35px;
    right: -5px;
    top: -12px;
    width: 40px;
}
.cloud4:before {
    height: 45px;
    left: -7px;
    top: -22px;
    width: 50px;
}

.cloud4-more {
    height: 65px;
    top: -40px;
    left:90px;
    width: 65px;
}

.cloud4-more:before {
    height: 75px;
    left: -60px;
    top: -19px;
    width: 75px;
}


.cloud-big {
    height: 60px;
    width: 400px;
     
}

.cloud-big:after {
    height: 80px;
    right: -14px;
    top: -28px;
    width: 160px;
}
.cloud-big:before {
    height: 70px;
    left: -8px;
    top: -22px;
    width: 100px;
}

.cloud-big-more {
    height: 160px;
    top: -100px;
    left:100px;
    width: 160px;
}

.cloud-big-more:after {
     height: 100px;
    top: 30px;
    left:120px;
    width: 120px;
}

.cloud-big-more:before {
     height: 80px;
    top: 40px;
    right:130px;
    width: 80px;
}


.cloud1, .cloud2, .cloud3, .cloud4, .cloud-big
{
    background-color: #EBFBFD;
    background-image: -webkit-linear-gradient(top, #EBFBFD, #CDF5FA);
    background-image: -moz-linear-gradient(top, #EBFBFD, #CDF5FA);
    background-image: -ms-linear-gradient(top, #EBFBFD, #CDF5FA);
    background-image: -o-linear-gradient(top, #EBFBFD, #CDF5FA);
}

.cloud1:after, .cloud3:after, .cloud4:after,.cloud2:after, .cloud-big:after  {
     background-color: #EBFBFD;
    background-image: -webkit-linear-gradient(top, #EBFBFD, #D7F7FB);
    background-image: -moz-linear-gradient(top, #EBFBFD, #D7F7FB);
    background-image: -ms-linear-gradient(top, #EBFBFD, #D7F7FB);
    background-image: -o-linear-gradient(top, #EBFBFD, #D7F7FB);
}

.cloud1:before, .cloud2:before, .cloud3:before, .cloud4:before, .cloud-big:before,
.cloud1-more, .cloud2-more, .cloud3-more, .cloud4-more, .cloud-big-more,
.cloud1-more:after, .cloud2-more:after, .cloud3-more:after, .cloud4-more:after, .cloud-big-more:after {
    background-color: #EBFBFD;
    background-image: -webkit-linear-gradient(top, #fff, #D7F7FB);
    background-image: -moz-linear-gradient(top, #fff, #D7F7FB);
    background-image: -ms-linear-gradient(top, #fff, #D7F7FB);
    background-image: -o-linear-gradient(top, #fff, #D7F7FB);
}

.cloud1-more:before, .cloud2-more:before, .cloud3-more:before, .cloud4-more:before, .cloud-big-more:before {
    background-color: #EBFBFD;
    background-image: -webkit-linear-gradient(top, #fff, #E1F9FC);
    background-image: -moz-linear-gradient(top, #fff, #E1F9FC);
    background-image: -ms-linear-gradient(top, #fff, #E1F9FC);
    background-image: -o-linear-gradient(top, #fff, #E1F9FC);
}


/* midground (clouds) */
#parallax-bg2 {
	z-index: 2;
	position: fixed;
	left: 50%; /* align left edge with center of viewport */
	top: 0;
	width: 1200px;
	margin-left: -600px; /* move left by half element's width */
	}
	#bg2-1 {
		position: absolute;
		top: 82px;
		left: 1340px;
		}
	#bg2-2 {
		position: absolute;
		top: 300px;
		left: 1280px;
		}
	#bg2-3 {
		position: absolute;
		top: 246px;
                left: 182px;
		}
	#bg2-4 {
		position: absolute;
		top: 780px;
		left: -50px;
		}
	#bg2-5 {
		position: absolute;
		top: 330px;
		left: 745px;
		}
	#bg2-6 {
		position: absolute;
		top: 290px;
		left: 270px;
		}
	#bg2-7 {
		position: absolute;
		top: 130px;
		left: 90px;
		}
	#bg2-8 {
		position: absolute;
		top: 250px;
		left: 390px;
		}
	#bg2-9 {
		position: absolute;
		top: 350px;
		left: 190px;
		}
	#bg2-10 {
		position: absolute;
		top: 320px;
		left: -150px;
		}
	
	

/* background (clouds) */
#parallax-bg1 {
	z-index: 1;
	position: fixed;
	left: 50%; /* align left edge with center of viewport */
	top: 0;
	width: 1200px;
	margin-left: -600px; /* move left by half element's width */
	}
	#bg1-1 {
		position: absolute;
		top: 85px;
		left: -230px;
		}
	#bg1-2 {
		position: absolute;
		top: 500px;
		left: -220px;
		
		}
	#bg1-3 {
		position: absolute;
		top: 140px;
		left: 295px;
		}
	#bg1-4 {
		position: absolute;
		top: 180px;
		left: -200px
		}
	#bg1-5 {
		position: absolute;
		top: 220px;
		left: 710px
		}
	#bg1-6 {
		position: absolute;
		top: 190px;
		left: 110px;
		}
	#bg1-7 {
		position: absolute;
		top: 240px;
		left: 150px;
		}
	#bg1-8 {
		position: absolute;
		top: 160px;
		left: 440px;
		}
	#bg1-9 {
		position: absolute;
		top: 230px;
		left: 820px;
		}
	#bg1-10 {
		position: absolute;
		top: 320px;
		left: 1070px;
		}

	

/* ==========================================================================
				TOP BAR STUFF
   ========================================================================== */

.navbar-inner {
    background-image:none;
     font-family: ezerblock_oe_regularregular;
     font-size: 16px;
      color:#3D718E;
     background:rgba(255, 255, 255, 0.7);
     min-height:34px;
     text-align:right;
     <? if (isHeb()) echo "direction:rtl"; ?>
     padding-top:0px;
}


.navbar-inner .span6 {
    margin-<?=get_s_align()?>:0px;
}

.navbar-inner a{
color:#3D718E;
}
#registerinput{
margin-bottom:10px;
}
#user_info {
    display:inline-block;
    float:<?=get_inv_s_align()?>;
    <? if (isHeb()) echo "direction:rtl"; ?>
}
#login, #forgotpass, #register{
    padding:0.9em;
}
#user_icon, #profileform_user_icon {
    float: <?=get_s_align()?>;  
    background-repeat:no-repeat;
    background-position:right;
    min-height:36px;
    vertical-align:middle;
    display:inline-block;
    width:36px;
    margin-top:-13px;
    opacity:0.7;
}
#user_icon_dialog{
position:absolute;
top:10px;
right:10px;
}
#user_icon:hover {
   
}

#user_name {
   display:inline-block;
    padding-left:5px;
    margin-bottom:0px;
    color:#3D718E;
    padding-right:10px;
    float: <?=get_s_align()?>; 
}

.dd_arrow {
    background-image:url("../img/arrow_down.png");
    background-position:left;
    width:13px;
    height:7px;
    margin-right:5px;
    display:inline-block;
}

.dd_arrow:hover {
     background-position:right;
     cursor:pointer;
}

#top_links {
    display:inline-block;
    margin-right:13px;
    margin-bottom:3px;
}

#top_links li{
    display:inline-block;
   list-style:none;
   border-right:solid;
   border-color:#3D718F;
   border-width:1px;
   padding-left:13px;
    padding-right:13px;
    line-height:11px;
}
#top_links li ul li{
	border:none;
        line-height:16px;
}
#top_links li a {
    padding-bottom:7px;
    color:#3D718E;
}
#top_links li ul li a {
    padding-bottom:0;
    
}
.navbar .nav {
height: 30px;
}
#top_links li a:hover, #arabic:hover, #english:hover {
    text-decoration:none;
    color:#DD6B96;
    border-bottom:solid;
    border-width:3px;
    border-color:#DD6B96;
    cursor:pointer; 
}
#top_links li ul li a:hover {
	border-bottom:none;
	}
#tohomepage
{
	
}
#print
{
	background-image:url("../img/print_icon.png");
	width:38;height:38;
	display:inline-block;
    text-align:center;
    background-repeat:no-repeat;
    background-position:left;
    margin:0 5px;
	cursor:pointer;
	float:<?=get_inv_s_align()?>;
	margin-<?=get_inv_s_align()?>: 0px;
}



#print:hover {
    cursor:pointer;
    background-position:right;
    
}
.last_update {
     padding-top:3px;
     margin-right:0px;
     text-align:right;
     display:inline-block;
}
#hebrew{
    display:inline-block;
     margin-top:2px;
     font-size:14px;
      float:left;
      margin-left:20px;
      
}

#arabic {
    display:inline-block;
     margin-top:1px;
     font-size:12px;
     float:left;
     margin-left:15px;
     font-family:Droid Arabic Kufi;
     padding-bottom:7px;
     margin-bottom:-12px;
}

#english {
    display:inline-block;
     margin-top:2px;
     font-size:14px;
      float:left;
      margin-left:20px;
      padding-bottom:6px;
      margin-bottom:-12px;
}
#tempunitconversion{
    display:inline-block;
     margin-top:2px;
     margin-left:10px;
     font-size:14px;
      float:left;
}
#tempconversion{
margin:0
}
.searchForm {
   
    margin:0px;
     margin-left:15px;
    margin-top:0px;
    display:inline-block;
    float:left;
    <? if (isHeb()) echo "direction:rtl"; ?>
}

.searchForm input[type="submit"] {
    width:22px;
    height:22px;
    vertical-align:top;
    border-radius:50%;
    background-color:#FFFFFF;
    border-color:#B4C3CC;
    border-style:solid;
    border-width:1px;
    margin-right:5px;
    background-image:url("../img/search_img.png");
    background-repeat:no-repeat;
}

.searchForm input[type="submit"]:hover {
    background-position:right;
     background-color:#B4C3CC;
}

.searchForm input[type="text"] {
    padding-bottom:0px;
    padding-top:0px;
    margin-bottom:0px;
    font-size:12px;
    line-height:12px;
}

.search-query {
    border-radius:20px;
    padding:1px;
    margin-top:0px;
    width:100px;
    line-height:10px;
    border-style:solid;
    border-color:#B4C3CC;
    border-width:1px;
    color:#648395;
    padding-bottom:0px;
    margin-bottom:0px;
}



#bottom_bg {
    position:absolute;
    width:100%;
    text-align:center;
    height:100%;
   
}


#tree {
    position:absolute;
    background:url("../img/tree.png") no-repeat;
    background-position:top right;
    height:1200px;
    width:441px;
    left:930px;
    top:400px;
    z-index:8;
}

#crow {
    position:absolute;
    background:url("../img/crow.png") no-repeat;
    background-position:left;
    height:100px;
    width:100px;
    left:930px;
    top:400px;
    z-index:500;
}

#crow:hover {
     background-position:-99px;
}

#bg_backHills {
     position:absolute;
    background:url("../img/bg_backHills.png") no-repeat center top;
    top:1500px;
    height:100%;
     width: 120%;
     z-index:5;
}

#bg_map {
    position:absolute;
    top:1600px;
    left:150px;
    height:100%;
    background: url("../img/bg_map<? if (SNOW_ON_THE_GROUND == 1) echo "_snow";?>.png") no-repeat center top;
    width: 100%;
    z-index:7;
}

#bg_hills {
    position:absolute;
    top:1600px;
    left:0;
    height:100%;
    background: url("../img/bg_hills.png") no-repeat center top;
    width: 100%;
    z-index:6;
}

#bg_grass {
    position:absolute;
    background:url("../img/bg_grass.png") no-repeat center top;
    top:2000px;
    left:0;
    height:1500px;
     width: 100%;
    z-index:14;
}

#bg_grass2 {
    position:absolute;
    background:url("../img/bg_grass.png") no-repeat center top;
    top:2300px;
    height:1500px;
     width: 100%;
    z-index:15;
}

#snow {
    width:2000px;
    position:fixed;
    top:0;
    z-index:50;
}

canvas {
    display:block;
    margin:0;
    padding:0;
    position:fixed;
    z-index:10;
}

a.info
{
	position: relative;text-decoration: none;
 
}
a.info:hover
{
    background: #FFFFFF;
   	z-index: 100;
}
a.info span.info
{
    display: none;
    z-index: 9999;
}
a.info:hover span.info
{
    border: 1px dashed;
    display: block;
    font-size: 0.8em;
    <?echo get_s_align();?>: 6em;
    width: 10em;
    position: absolute;
    top: +50px;
    text-align: center;
    padding: 0.5em;
    text-decoration: none;
	background: #FFFFFF;
	color:#000000;
	
 
}

.inparamdiv
{
    font-family: nextexitfotlight;
    background:rgba(255, 255, 255, 0.6);
    text-align:center;
   -moz-border-radius: 999px;
    border-radius: 999px;
    behavior: url(PIE.htc);
    width: 215px;
    height: 215px;
    color:#2C3A42;
    font-size: 17px;
  <? if (isHeb()) echo "direction:rtl"; ?>
}
.inparamdiv a
{
    color: #2C3A42;
}
.inparamdiv table
{
    margin: 0 auto;
    width:85%;
    border-top:1px solid;
    border-color: #829CAA;
    
}
.trendstable
{
    position: absolute;
    top: 110px;
    width: 100%;    
}
.trendstitles, .trendsvalues
{
	text-align:center
}
.trendstitles .box img{
	margin-top: 10px;
}
.inparamdiv .highlows
{
    position:absolute;
    top:80px;
    border-top:1px solid;
    border-color: #829CAA;
    width: 90%;
    margin-<?=get_s_align()?>: 13px;
}
.highlows img
{
    margin-top: -3px;
}
.highlows .low {
    margin-<?=get_s_align()?>: 20px;
}
.graphslink{
	position:absolute;
	<?=get_s_align()?>: 88px;
    top: 185px;
}
.paramtitle
{
   font-size: 1em;
    padding-top: 6px;
    margin:0 auto;
    width:100px;
}
#paramsdiv
{
	padding:0;margin:0;width:100%;float:right;
	vertical-align: top;position:relative;
}
#paramstable
{
	padding:0;margin:0;width:100%;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#paramstable fieldset
{
	border:none;
}
#latesttemp{

	
 text-align:center;border-bottom:none;
 
}
#tempdiv
{
	height:100%;width:auto;
}
#temptable
{
	width:auto
}
#templabel
{
	
}

#tempdivvalue
{
	font-weight: normal;
	margin-left: 11px;
	color: #2C3A42;
	padding-top: 20px;
	font-size: 5.4em;
        direction:ltr
	
}
#valleytemp
{
    font-size: 0.35em;
}
#windy
{
          margin: 0 auto;position: absolute;font-size:0.95em;width: 100%;z-index: 0;top:1.15em
}
#windy .wind_title
{
margin:0 auto
}
#windy .wind_icon
{
margin:0 auto
}
#status
{
    position: absolute;
    top: 125px;
    width: 100%;
    color: #2C3A42;
    font-family: nextexitfotlight;
    font-size: 20px;
    line-height: 18px;
}
#status .wind_title
{
margin:0 auto
}
#status .wind_icon
{
margin:0 auto
}
#coldmeter
{
          
}
#current_feeling_link
{
	font-size:100%
}
#itfeels_windchill, #itfeels_heatidx
{
    <? if (isHeb()) echo "direction:rtl"; else echo "direction:ltr";?>;
	font-size: 15px;
        position: absolute;
        width: 100%;
        top: 2.8em;
        font-size: 1em;
        
}
#latestpressure
{
	border-bottom:none;display:none;
}
.paramvalue
{
    font-size: 3em;
    position:absolute;
    top:10px;
    width:100%;
    font-family:nextexitfotlight;
    direction:ltr
}

.paramunit
{
    font-size:0.5em;
    font-weight:normal
}
.paramtrend
{
    position:absolute;
    top:130px;
    width:70%;
    margin:0 auto
}
.trendvalue
{
    width:100%;
    

}
.trendsvalues
{
    font-weight: bold;
}
.innertrendvalue
{
    width:63%;
    line-height: 1;
    margin: 0 auto;
}
#latestwind, #latesttemp, #latesthumidity, #coldmetersurvey, #latestrain, #latestuv, #latestradiation, #latestairq
{
    display:none;
}
#coldmetersurvey
{
    overflow: hidden;
    position: relative;
}
#windvalue
{
	float:<?=get_s_align()?>;padding:0 0.5em;width:90%;
}
#windspeed
{
    float:<?=get_s_align()?>;width:60%;
}
#windtrend
{
	float:<?=get_s_align()?>;width:13%;margin:0.1em
}
#winddir
{
	float:<?=get_s_align()?>;width:10%;margin-top: 1.25em;margin-<?=get_s_align()?>:15%
}
.wind_icon
{
 background: url('../img/wind_icons2.png') no-repeat top left;
 width:40px;height:14px;
}
.no_wind
{
background-position: -120px 0px;
}
.light_wind
{
background-position: -80px 0px;
}
.moderate_wind
{
background-position: -40px 0px;
}
.high_wind
{
background-position: 0px 0px;
}
#temptrends, #humtrends, #bartrends, #windtrends, #raintrends, #radiationtrends, #uvtrends
{
border-top:none; margin:0; padding:0;
}
#rainratevalue
{
	<? if (isHeb()) echo "direction:rtl"; else echo "direction:ltr";?>
}

.colmeterq{
    width:65%;
    float:right;
    position:absolute;
    top:50px;
	line-height: 18px;
	font-size: 18px;
    right:-10px;    
    transform: rotate(50deg);
    -ms-transform: rotate(50deg); /* IE 9 */
    -webkit-transform: rotate(50deg); /* Safari and Chrome */ 
   
}
.colmetercontainer{
    top:45px;
    right:60px;    
    position:absolute;
    transform: rotate(-40deg);
    -ms-transform: rotate(-40deg); /* IE 9 */
    -webkit-transform: rotate(-40deg); /* Safari and Chrome */ 
    
}
.inparamdiv .coldmeterline{
   opacity:0.8;
   padding:0;
   margin:0;
   display:block;
   border:none;
    height: 24px;
    color:#FFFFFF;
    cursor:pointer;
    text-align:right
}
.inparamdiv .coldmeterline:hover{
   opacity:1;  
}
.colmetercontainer .color0{
    background-color:#3C708E;
}
.colmetercontainer .color1{
    background-color:#638394;
}
.colmetercontainer .color2{
    background-color:#829CAA;
}
.colmetercontainer .color3{
    background-color:#8BAE91;
}
.colmetercontainer .color4{
    background-color:#B0BD5A;
}
.colmetercontainer .color5{
    background-color:#F5C736;
}
.colmetercontainer .color6{
    background-color:#F59B36;
}
.colmetercontainer .color7{
    background-color:#FA7952;
}
.colmetercontainer .color8{
    background-color:#E6666A;
}
#pm10value
{
    height: 1200px;
    position: absolute;
    right: -390px;
    top: -178px;
    width: 999px;
}
#genderchoose
{
position:absolute;top:-20px;width:430px;z-index:500;
}
#graphmain
{
    float:<?=get_s_align()?>
}
#gp_icon{
text-align:center;
margin-<?=get_s_align()?>: 200px;
}
#section h1, #section h2, #section h3
{
    text-align:<?=get_s_align()?>;
    margin-<?=get_s_align()?>:0px;
    padding-bottom:5px;
	
}
#section h1
{
    float:<?=get_s_align()?>
}
#section input
{
    width:50px;
}
#section select
{
    width:100px;
}
#history_menu
{
	width:100%;top:-100px;position:absolute;<?=get_s_align()?>:0
}
#history_menu .inv_plain_3
{
padding:10px 4px;
}
.borderfull
{
	border:1px solid
}
.heb
{
    direction:rtl
}
.inv{
    color: #ccc;
    background: #5D7FA9;
    background-repeat: repeat-x;
    border-radius: 5px;
    border-radius: 5px;
}
.inv_plain{
    color: #ccc;
    background: #3D505E;
    border: #616F9B 3px solid;
    padding: 5px;
    margin: 0em;
}
.inv_plain_2
{
 
	background: rgba(242, 251, 252,0.8);
	color: #6A826D;
	padding: 12px;
	margin: 0em;
 
}
.inv_plain_2 a
{
    color:#5979A0;
}
inv_plain_2_zebra
{
    background: rgba(216, 247, 251, 0.4);
    color: #6A826D;
    padding: 12px;
    margin: 0em;
}
.inv_plain_3
{
background:rgba(255,255,255,0.7);
color:#2C3A42;
padding: 2px;
margin: 0em;
-moz-box-shadow: 0 1px 5px rgba(0,0,0,0.2);
box-shadow: 0 1px 5px rgba(0,0,0,0.2);
 
}
.inv_plain_3 a{
	color: #2C3A42;
}
.inv_plain_3_min
{
   background:#3C4F5D;
    color: #ccc;
    padding: 12px;
    margin: 0em;
    border-radius: 8px; 
}
.border_3
{
	border-bottom: 1px solid;
	 
}
.inv_plain_3_zebra
{
	border: none;
	background: rgba(255, 255, 255, 0.8);
	-moz-box-shadow: 0 1px 5px rgba(0,0,0,0.2);
	box-shadow: 0 1px 5px rgba(0,0,0,0.2);
   	color: #2C3A42;
	padding: 5px;
	margin: 0;
}
.inv_plain_3_zebra a
{
    color:#4C5D77;
}
.inv_plain_3_zebra:hover
{
	background: #D8F7FB;
}
.half_zebra
{
	background: #E7F9FC;
}
.base
{
            
}

.topbase
{
	font-weight: bold;
    font-size: 1.2em;
    padding: 0.5em;
	color: #D9F2F5;
	background: url() #2C3A42 fixed ;
	border: #71979D 1px solid;
    text-align: center;
	margin: 0px;
	border-radius: 5px;
 
}
.topbase a
{
	color: #F2FCFD;
}
.topbase a:hover
{
	text-decoration:none;
}

.float
{
	float:<?=get_s_align()?>;text-align:<?=get_s_align()?>;<? if (isHeb()) echo "direction:rtl"; ?>
}
.button
{
    cursor:pointer;
    padding:4px;
    width:120px;
    
}
.invfloat
{
    float:<?=get_inv_s_align()?>;
}
.big
{
    font-weight: bold;
    font-size: 1.35em
}
.clear {
	clear: both;
}
.high
{
	color: #ff0000;
        display:inline-block
}
.invhigh
{
    color: #ffffff;
    background-color: #ff0000;
    font-weight:bold;
}

.low
{
	color:#0066cc;
        direction:ltr;
        display:inline-block;
        font-weight:bold;
}

div.less
{
    color: #9f9b00
}
div.more
{
    color: #33CC00
}
.indexlow
{
    font-size: 0.8em;
    background: #669900;
    color: #000000;
	padding:3px;
}
.indexmedium
{
    font-size: 0.8em;
    background: #99ff00;
    color: #000000;
	padding:3px;
}
.indexhigh
{
    font-size: 0.8em;
    background: #ffcc00;
    color: #000000;
	padding:3px;
}
.indexextreme
{
    font-size: 0.8em;
    background: #ff0000;
    color: #000000;
	padding:3px;
}
.relative
{
position:relative
}


.sprite { background: url('images/sprite.png') no-repeat top left;  } 
.sprite.good { background-position: 0px 0px; width: 24px; height: 24px;  } 
.sprite.bad { background-position: 0px -34px; width: 24px; height: 24px;  } 
.sprite.stop1 { background-position: 0px -68px; width: 20px; height: 20px;  } 
.sprite.v { background-position: 0px -98px; width: 20px; height: 20px;  } 
.sprite.hammer { background-position: 0px -128px; width: 20px; height: 20px;  } 
.sprite.stop2 { background-position: 0px -158px; width: 20px; height: 20px;  } 
.sprite.amazed { background-position: 0px -188px; width: 20px; height: 20px;  } 
.sprite.angry { background-position: 0px -218px; width: 20px; height: 20px;  } 
.sprite.cold { background-position: 0px -248px; width: 20px; height: 20px;  } 
.sprite.confuse { background-position: 0px -278px; width: 20px; height: 20px;  } 
.sprite.curious { background-position: 0px -308px; width: 20px; height: 20px;  } 
.sprite.digging { background-position: 0px -338px; width: 20px; height: 20px;  } 
.sprite.doubt { background-position: 0px -368px; width: 20px; height: 20px;  } 
.sprite.embarrassed { background-position: 0px -398px; width: 20px; height: 20px;  } 
.sprite.gnome_face_cool { background-position: 0px -428px; width: 20px; height: 20px;  } 
.sprite.gnome_face_kiss { background-position: 0px -458px; width: 20px; height: 20px;  } 
.sprite.hell_boy { background-position: 0px -488px; width: 20px; height: 20px;  } 
.sprite.hot { background-position: 0px -518px; width: 20px; height: 20px;  } 
.sprite.pudency { background-position: 0px -548px; width: 20px; height: 20px;  } 
.sprite.sad { background-position: 0px -578px; width: 20px; height: 20px;  } 
.sprite.satisfied { background-position: 0px -608px; width: 20px; height: 20px;  } 
.sprite.smiley { background-position: 0px -638px; width: 20px; height: 20px;  } 
.sprite.tire { background-position: 0px -668px; width: 20px; height: 20px;  } 
.sprite.wink { background-position: 0px -698px; width: 20px; height: 20px;  } 
.sprite.mood_add { background-position: 0px -728px; width: 25px; height: 25px;  }  
.spriteB { background: url('images/spriteB.png') no-repeat top left;  } 
.spriteB.up { background-image: url("../img/up_icon.png");width: 9px;margin-top:3px;height: 10px; } 
.spriteB.down {background-image: url("../img/down_icon.png");width: 9px;margin-top:3px; height: 10px; } 
.spriteB.plus {  background-position: 0 -32px;background-size: 98% auto;height: 20px;width: 20px;  } 
.spriteB.adlink { background-image: url("../img/new_post_link.png")  } 
.spriteB.star { background-position: 0px -140px; width: 14px; height: 13px;  } 
.spriteB.eng { background-position: 0px -163px; width: 28px; height: 17px;  } 
.spriteB.israelflag { background-position: 0px -190px; width: 19px; height: 14px;  }
.arrow_down{color: #829CAA;font-size: 11px;}
.nav li { /* all list items */
     margin-top:0.4em;
     position: relative;
     line-height:11px;
	 float:<?=get_s_align()?>;
	 text-align:center;
	 border:none;
	 <? if (isHeb()) echo "direction:rtl"; ?>
 
}
.param li
{
	padding:0;border:none;
}
.param li a
{
	display:inline
}
#brokenhightemp, #brokenlowtemp
{
    padding-bottom:0.6em;
}
.brokendatatitle
{
    padding:0.8em 0.3em;
}
.top
{
vertical-align: top;
}
.nav .il_first
{
	border-<?=get_s_align()?>: 0px;
}
.nav li:hover 
{
	
}
.nav ul li:hover 
{
text-decoration:none;
}
.nav ul li{ border-width:1px 1px 0 0;}
 
.nav ul ul li{ border-width:1px 1px 0 1px;}
 
.nav ul ul li:last-child{border-bottom:1px solid #ccc;} 
 
.nav li ul { /* second-level lists */
   background: rgba(255, 255, 255, 0.7);
   font-family: ezerblock_oe_regularregular;
   font-size: 14px;
	display: none;
	position: absolute;
	top:  1.25em;
   <?echo get_s_align();?>: -50px;
	border-radius: 8px 0 8px 8px;
	z-index: 500;
}
.nav li ul li
{
	float:none;
	padding:0.1em 0.2em;
        margin-top:0em;
	width: 270px;
	display:block;
   	border-right: none;
	border-left: none;
    text-align: <?=get_s_align()?>;
    background: rgba(255, 255, 255, 0.7);
 
}
.nav li ul li a
{
	text-decoration:none;
	display:block;
	height:100%;
        padding:0.8em 0.5em;
    
}
.nav a:hover
{
	text-decoration:none;
}

/* non-ie browsers see this */
.nav ul li>ul, .nav ul ul li>ul{
 
}
 
.nav li:hover ul ul, 
.nav li:hover ul ul ul, 
.nav li:hover ul ul ul ul, 
.nav li:hover ul ul ul ul ul{
     display:none;
}
 
.nav li:hover ul, 
.nav ul li:hover ul, 
.nav ul ul li:hover ul, 
.nav ul ul ul li:hover ul, 
.nav ul ul ul ul li:hover ul{
     display:block;
}
 
.nav li>ul {
 
}
.nav .inv_plain_3_zebra{
    border-radius:0px;
 
}
.nav .forecasttemp
{
direction:ltr important!
}

/*
    ColorBox Core Style
    The following rules are the styles that are consistant between themes.
    Avoid changing this area to maintain compatability with future versions of ColorBox.
*/
#colorbox, #cboxOverlay, #cboxWrapper{position:absolute; top:0; left:0; z-index:9999; overflow:hidden;background: white;}
#cboxOverlay{position:fixed; width:100%; height:100%;}
#cboxMiddleLeft, #cboxBottomLeft{clear:left;}
#cboxContent{position:relative; overflow:visible;}
#cboxContent table{color:#000;font-size:13px}
#cboxLoadedContent{overflow:auto;}
#cboxLoadedContent iframe{display:block; width:100%; height:100%; border:0;}
#cboxTitle{margin:0;}
#cboxLoadingOverlay, #cboxLoadingGraphic{position:absolute; top:0; left:0; width:100%;}
#cboxPrevious, #cboxNext, #cboxClose, #cboxSlideshow{cursor:pointer;}
 
/* 
    ColorBox example user style
    The following rules are ordered and tabbed in a way that represents the
    order/nesting of the generated HTML, so that the structure easier to understand.
*/
#cboxOverlay{background:#b4c4cc;}
 

    #cboxContent{margin-top:32px;color:#000;}
        #cboxContent{padding:1px;<? if (isHeb()) echo "direction:rtl"; ?>}
        #cboxLoadingGraphic{background:url(images/loading.gif) center center no-repeat;}
        #cboxLoadingOverlay{background:#fff;}
        #cboxTitle{position:absolute; top:-22px; <?echo get_s_align();?>:1em; color:#000; <? if (isHeb()) echo "direction:rtl"; ?> }
        #cboxCurrent{position:absolute; top:-22px; right:205px; text-indent:-9999px;}
        #cboxSlideshow, #cboxPrevious, #cboxNext, #cboxClose{text-indent:-9999px; width:20px; height:20px; position:absolute; top:-20px; background:url(images/controls.png) 0 0 no-repeat;}
        #cboxPrevious{background-position:-78px 0px; <?echo get_inv_s_align();?>:3em;}
        #cboxPrevious.hover{background-position:-78px -25px;}
        #cboxNext{background-position:-50px 0px; <?echo get_inv_s_align();?>:4.2em;}
        #cboxNext.hover{background-position:-50px -25px;}
        #cboxClose{background-image: url("../img/close.png");border:none;height: 32px;width: 32px; <?=get_inv_s_align()?>:5px;}
        #cboxClose.hover{}
        .cboxSlideshow_on #cboxPrevious, .cboxSlideshow_off #cboxPrevious{right:66px;}
        .cboxSlideshow_on #cboxSlideshow{background-position:-75px -25px; right:44px;}
        .cboxSlideshow_on #cboxSlideshow.hover{background-position:-100px -25px;}
        .cboxSlideshow_off #cboxSlideshow{background-position:-100px 0px; right:44px;}
        .cboxSlideshow_off #cboxSlideshow.hover{background-position:-75px -25px;}
		#cboxContent input{width:155px}
		#cboxContent input[type="checkbox"]{width:auto}
		#colorbox{border-radius:5px}
                 a.colorbox {position:relative;}
                .colorbox span, .enlarge span{display:none; background-image:url(../images/enlarge_64.png); background-repeat:no-repeat; width:64px; height:64px; position:absolute; left:5px;}
                 a.colorbox:hover span, a.enlarge:hover span{display:block;}
		
body.mce-content-body { 
   background:#E0E7B0;
   opacity:0.9;
   color:#3D718E;
   line-height:10px;
   font-size:13px;
}
#mce_16 button, #mce_17 button, #mce_18 button, #mce_19 button{
background:#FFFFFF;
opacity: 0.9;
 text-align:center;
     -moz-border-radius: 999px;
    border-radius: 999px;
    behavior: url(PIE.htc);
	border: 1px solid;
   
}

.mce-container-body{
	background:transparent;
	border:0 none;
}
.mce-panel{
border:0 none; 
}
.mce-widget{
  border:0 none;
  background:transparent;
}
#mce_15, #mce_14, #mce_13, #mce_12 , #mce_11, #mce_10, #mce_9, #mce_8, #mce_7, #mce_6{
	background:transparent;
	border:0 none;
}
#forecastnextdays{
	padding:0em;width:100%;clear:both;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#forecasthours ul li
{
	padding:0.1em 0.3em
}

.forecasttimebox
{
width:90%;clear:both;padding-<?=get_s_align()?>:70px
}
.forecasttimebox li
{
	height:25px;color:#<?= $forground->bg['-8'] ?>;text-align:<?echo get_s_align();?>;border-top:#<?= $forground->bg['0'] ?> 1px solid;border-<?echo get_s_align();?>:none;
}
#forecast24h
{
width:100%;height:470px;
}
#waiting
{
position:absolute
}
pre
{
word-wrap: normal;
white-space:pre;
line-height: 10px;
font-size: 11px;
}

#alert_image{
   padding:0.2em;
   max-width: 315px;
   height: auto;
}
<? if (in_array("sunset", $css_comp)) { ?>
<!-- sunset -->
<?  include_once 'sunset.css';?>
<!-- / sunset -->
<? } ?>
<? if (in_array("sunrise", $css_comp)) { ?>
<!--  sunrise -->
<?  include_once 'sunrise.css';?>
<!-- / sunrise -->
<? } ?>
<? if (in_array("cloudy", $css_comp)) { ?>
<!--  cloudy -->
<?  include_once 'cloudy.css';?>
<!-- / cloudy -->
<? } ?>
<? if (in_array("dust", $css_comp)) { ?>
<!--  dust -->
<?  include_once 'dust.css';?>
<!--  /night -->
<? } //night?>
<? if (in_array("dust-night", $css_comp)) { ?>
<!--  dust-night -->
<?  include_once 'dust-night.css';?>
<!--  /dust-night -->
<? } //dust-night?>
<? if (in_array("rain", $css_comp)) { ?>
<!--  rain -->
<?  include_once 'rain.css';?>
<!--  /rain -->
<? }//rain ?>
<? if (in_array("snow", $css_comp)) { ?>
<!--  snow -->
<?  include_once 'snow.css';?>
<!--  /snow -->
<? }//snow ?>
<? if (in_array("snow_night", $css_comp)) { ?>
<!--  snow_night -->
<?  include_once 'snow_night.css';?>
<!--  /snow_night -->
<? }//snow_night ?>
<? if (in_array("mobile", $css_comp)) { ?>
<!--  mobile -->
<?  include_once 'mobile.php'."?lang=".$lang_idx;?>
<!--  /mobile -->
<? }//mobile ?>


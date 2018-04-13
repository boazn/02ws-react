<?  
    ini_set("display_errors","On");
    header("Content-type: text/css");
    
if ($_GET['debug'] == '') include "../begin_caching.php";
$lang_idx = @$_GET['lang'];
$width = @$_GET['width'];
$fullt = @$_GET['fullt'];
$cloth = @$_GET['c'];
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

?>

body{
text-align:center;
margin:0;
font-size: 13.1px;
overflow-x: hidden;
}
#date{
display: inline-block;
margin-top: 0.48em;
font-family:nextexitfotlight;
font-size:1.3em

}
h1{
margin-<?=get_inv_s_align()?>:194px;
margin-bottom:0px;
}
.inparamdiv
{
	text-align:center;
        position: relative;
        z-index:200;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#latestairq .paramvalue
{
top:0px;
}
.spacer
{
	padding:0 1em 0 1em;
	width:75%;
	clear:both;
	height:15px;
	margin:0 auto
}
#for_title
{
	clear:both;
	padding: 0 0.1em;
	float:<?echo get_s_align();?>;
	border-radius: 5px;
	border-radius: 5px
	border-radius: 5px;
}
#for_title a:hover
{
  text-decoration:none;
}
#for24_details
{
	clear:both;margin:0.6em 1em;
	width:95%;
	position: relative;
	text-align:<?echo get_s_align();?>;
	float:<?echo get_s_align();?>
}
.forecasttimebox li
{
	height:25px;color:#<?= $forground->bg['-8'] ?>;text-align:<?echo get_s_align();?>;border-top:#<?= $forground->bg['0'] ?> 1px solid;border-<?echo get_s_align();?>:none;
}
#forecast24h
{
	width:100%;height:auto;
}
#forecastnextdays
{
	padding:0em;width:100%;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#forecastnextdays table
{	
	border-spacing: 0;
	padding:0.1em 0.2em;
	width:100%;
	height:50px;
	clear:both;
	text-align:<?echo get_s_align();?>;
	border-top:0 none;
	<? if (isHeb()) echo "direction:rtl"; else echo "direction:ltr";?>
}

#forecastnextdays table a
{
    text-decoration:underline;
}
#forecastnextdays table a.info
{
    text-decoration:none;
}
.loading{
width: 75%;
position: fixed;
left: 51%;
margin-left: -37.5%;
margin-top:130px;
z-index:2000;
}
.forecasttemp
{
	text-align:center;direction:ltr;font-weight:normal;
}
#nextdays
{
        margin-top:0.6em;
        float:<?echo get_s_align();?>;
        <? if (isHeb()) echo "direction:rtl"; ?>
}
#section{
position:relative;float:none;width:auto;top:0;margin:0;
}
#coldmeter
{
          float:<?echo get_s_align();?>
}
#current_feeling_link
{
	font-size:100%
}

#loginform, #registerform, #passforgotform, #profileform 
{
    <? if (isHeb()) echo "direction:rtl"; ?>;
}
#loginform_result, #registerform_result, #passforgotform_result, #profileform_result
{
	width:8em;margin:1em
}
#loggedin, #notloggedin
{
 clear:both;margin: 0 1em;
}
#forgotpass
{
       padding:0.2em;width:auto;float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>;margin:0.2em;cursor:pointer
}
#login, .register{
    font-size: 2em;width:100%
}
#updateprofile, #signout, #myvotes
{
  padding:0.5em;margin:0.5em 0em;cursor:pointer;float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>; width: 110px;
}
#snowtable{
width:320px;
}
.chatdate
{
	width:7%;float:<?echo get_inv_s_align();?>;margin:0.4em 0;
	font-style: italic;
	
}
.chatmainbody
{
	margin:0.4em;width:91%;float:<?echo get_s_align();?>
}
.chatseperator
{
 margin:0 0.2em
}
.chatfirstbody
{
 margin:0 0.1em;
 max-width: 89%;
} 

.chatdatereply
{
margin: 0em;
font-style: italic;
opacity: 0.5;
filter:alpha(opacity=50);

top:0;
}
.chataftersepreply
{
 margin: 0 0.1em;
 width: 100%;
 position: relative;
}

.chatbodyreply
{
	width: 86%;
	word-wrap: break-word;
	white-space:normal;
	white-space:-moz-pre-wrap;
}
.firstreplyline
{
width:auto
}
#chat_entire_div
{
	clear:both;margin:0 auto;width:100%;
	<? if (isHeb()) echo "direction:rtl"; ?>;
}
#chat_title
{
	text-align:<?echo get_s_align();?>;
	clear:both;
	margin:0.2em 1em;
	padding:0.6em 0.4em;
	float:<?echo get_s_align();?>
}
#chat_filter
{
	float:<?echo get_inv_s_align();?>;
	padding:1.5em 0.9em;width:auto;
}
#inputFieldsDiv
{
	
	float:<?echo get_s_align();?>;
	clear:both;
	
}
#msgDetails
{
	clear:both;
	text-align:<?echo get_s_align();?>;
	padding:0.5em 1em 0em 1em;width:98%;
 
}
#new_post_okay, #new_post_cancel {
    background-color:#C0CE61;
    color:#fff;
    width:60px;
    border-radius:5px;
    display:inline-block;
    margin-top:20px;
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
.pivotpointer{
clear:both
}
.postusername{
margin: 0 28px 0 8px;
}
.chatbodyreply .avatar{
<?echo get_s_align();?>: 18px;
}
#messages_box{
float:<?echo get_s_align();?>;
text-align:<?echo get_s_align();?>;
width:100%;
}
#livepic_box{
margin:0 8px
}
#livepic_box h3{
margin-top:0
}
.play {
    position: absolute;
    top: 170px;
    <?echo get_inv_s_align();?>: 10px;
}
.pic_user {
padding-<?echo get_s_align();?>:1em
}
#msgDetails .white_box2{
   clear: both;
    width: 100%;
   
}
#msgDetails .white_box2 {
    padding-top:10px;
    margin-bottom:10px;
}
#msgDetails .white_box2 div.chatfirstbody{
    padding-right:10px;
    padding-left:10px;
    margin-bottom:5px;
}
#msgDetails .white_box2 div.chataftersepreply{
    padding-<?echo get_s_align();?>:25px;
    margin-bottom:5px;
}
#chat_links
{
	float:<?echo get_inv_s_align();?>;
	text-align:<?echo get_inv_s_align();?>;
        width:60%
        
 
 
}
.avatar{
     margin-<?=get_s_align()?>:-10px;
    margin-top:-15px;
}
#chat_links div
{	
	float:<?echo get_s_align();?>;
	padding:0.5em 1em
}
#chat_links a{
display:block
}
#href_dialog
{
	padding:1em;text-align:<?echo get_s_align();?>;
}
#href_dialog div
{
	text-align:<?echo get_s_align();?>;<? if (isHeb()) echo "direction:rtl"; ?>
}
#href_dialog div div
{
	width:20%
}
#href_dialog .float 
{
	margin: 1em
}
.clear {
	clear: both;
}

#main_cellphone_container
{
text-align:center;
-webkit-overflow-scrolling: touch;
margin: 0 auto;
width:320px;

}
#statusline a
{
	font-weight:normal;
}
#laundryidx{
    left: -15px;
    top: 180px;
 }
 
#windy
{
width:33%;left:9.1em;top:5em
}
#coldmeter
{
	float:none
}
#current_feeling_link a.info:hover span.info
{
    <?echo get_s_align();?>: -8em;
    top: 1.5em;
}
#laundryidx a.info:hover span.info
{
  <?  if (!isHeb()) echo "right:-10em"; else echo "left:3em"; ?>
 
}
#coldmeter a
{
	font-weight:normal;
}
#currentinfo_container
{
	float:<?echo get_s_align();?>
}
.white_box{
border-radius: 0px;
}

#statusline
{
    <? if (count($sig) > 1){?> <?}?>
    
    font-size: 1.2em;
    font-weight: normal;
    line-height: 1em;
    margin-top: -4.9em;
    padding: 0;
}
#what_is_h
{
	font-size:0.95em;
	margin-top:0.2em;
        width: 70%;
        margin: 4.5em auto 0;
        line-height:16px;
}
#msgDetails .white_box2
{
	width:88%;
}

#forum{
  top:0;
   width:100%;
   left:0;
   position:relative;

}
#shortforecast
{
	
	width:100%
	
}
#shortforecast .nav li
{
    width:21%;direction:ltr
}

.forcast_title
{
width:95px;
text-align:<?=get_s_align()?>;
}
.forcast_title_btns
{
	display:inline-block;
        font-size:20px;
        margin-bottom:0px;
}
.forcast_title_btns:hover
{
    margin-<?=get_s_align()?>:0.4em;
    padding-<?=get_inv_s_align()?>:10px;
}
a.cboxElement {
text-decoration: underline;
}

.forcast_title_btns a
{
    display:inline-block;
}
.timefh, .tsfh{
font-family:nextexitfot_regularregular;
letter-spacing: 0px;
}
#fornextdays_title, #for24h_title, #expand, #now_title
{
	margin-<?=get_s_align()?>:4px;
        padding-<?=get_s_align()?>:8px;
	
}
#fornextdays_title
{
	
}
#mobileslogan
{
	
}
#tempunitconversion
{
	float:right
}
#mobilelogo, #mobileslogan
{
    text-align: center;
    width: 68%;
    margin-top:0.8em
}
#logo{
    width: <? if (isHeb()) echo "65%"; else echo "87%";?>;
    position: relative;
    float:<?echo get_s_align();?>;
    height:36px;
    background-size: 36px;
    margin: auto <? if (isHeb()) echo "4em";?>;
    background-position: right 25px top;
    direction:<? if (isHeb()) echo "rtl"; else echo "ltr";?>;
    margin-top: 10px;
    
}
.logo_secondary{
    background-position: <?=get_s_align()?> 27px top !important;
}
#logo a{
display:inline
}
#forum hr {
width:100%;
margin-left:0;
clear:both
}

#user_info{
color:#3D718E;
padding:0.5em;
position: absolute;
z-index: 1000;
top: 1em;
width: 160px;
<?=get_inv_s_align()?>: 0.8em;
}

.inparamdiv
{
    padding:0.3em;
}
#tempdivvalue
{
    float:none;
    font-size: 5.5em;
    margin-top: 20px;
    z-index:99999;
    font-family:nextexitfot_regularregular;
}
#latestnow
{
    padding:0.5em 0.3em 0em 0.3em;
    margin: auto;
}
.inparamdiv a
{
    font-weight: normal;
}
#more_info_btn
{
    margin-top:0.8em;clear:both
}
#extendedInfo
{
margin:auto;
}
#itfeels_windchill, #itfeels_heatidx, #itfeels_thsw{
float:none;margin: 0 auto;width: 220px;top:2.3em;
}
#heatindex{
margin-top:-56px;
}
.graphslink
{
position:relative;<?=get_s_align()?>:0;top:0
}
#tohome
{
    position: relative;
    z-index: 3000;
    
}
#tohome a{
    display:inline-block;
    padding:0.8em;
}
#replyInputsDiv
{
position:absolute;
bottom:-200px;

}
#canvas{
margin-top: 50px;
z-index: -10;
height: 220px;
width:100%
}
#forecastnextdays .tsfh, #shortforecast .tsfh{
font-size:1.3em
}
#rainradar_box h2, #forum_box h2, #contact_box h2, #picday_box h2, #userpic_box h2{
margin:0;
text-align: <?=get_s_align()?>;
width: 100%;
}
#rainradar_box a.info:hover span.info, #forum_box a.info:hover span.info, #contact_box a.info:hover span.info{
box-shadow:none;background:none;
}
#rainradar_box a, #forum_box a, #contact_box a, #picday_box a, #userpic_box a{
width: 100%;display:inline-block;padding:0.5em 0em;
direction:<? if (isHeb()) echo "rtl"; else echo "ltr";?>;
}
#radar, #forum_title, #contact{
color:#000000;
}
#adunit1, #adunit2, #adunit3{
line-height:0;
clear:both;
text-align:center
}
#forecasthours ul li
{
padding: 0.1em 0.3em;
line-height: 0.2em;
}
#forecasthours ul li span
{
vertical-align:-8px;
}
#forecasthours .nav
{
    margin:0
}
#shortforecast .nav li
{
padding:0.4em 0.3em
}
#for24_hours .nav li
{
padding:0.4em 0.25em;line-height: 0.9em;
}
#for24_hours .nav li .wind_icon
{
margin-top:0.5em
}
.text a.info:hover span.info
{
<?echo get_s_align();?>: -15em;
}
.inparamdiv .highlows
{
position:relative;
border-top:0px;top:0;
}
.winddir
{
display:inline-block;
margin-<?=get_inv_s_align()?>:5px
}
@viewport
{

}
#parallax-bg1{
z-index:-100;
}
#parallax-bg2{
z-index:-101;
}
#bg1-7, #bg2-10{
left:600px;
}
#bg2-7, #bg1-7{
left:450px;
}
#thwtab{
clear:both
}
#cold_btn{
	width:<? if (!isHeb()) echo "50"; else echo "59"; ?>px;
	margin-left: 3px;
    <? if (!isHeb()) echo "margin-right:0px"; ?>
}
#cold_btn a{
color:#000;display:block;z-index: 100;
}
#season_btn{
	margin-left: 8px;
    
    <? if (!isHeb()) echo "margin-right:0px"; ?>
}
#msgDetails img{
    max-width:255px;
    height:auto;
}

.nav
{
	list-style: none;
	margin:0 auto;
        padding:0;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
.nav ul { /* all lists */
	padding: 0;
    margin:0;
    list-style: none;
    overflow:visible; 
}
.nav li { /* all list items */
	 margin:0;
     position: relative;
	 padding:0.3em;
     float:<?=get_s_align()?>;
	 border-<?=get_s_align()?>: #<?= $forground->bg['-2'] ?> 2px solid;
	 text-align:center;
	 border-<?=get_inv_s_align()?>:none;
	 <? if (isHeb()) echo "direction:rtl"; ?>
 
}

.nav li a
{
	display:block;height:100%
}


.nav li:hover 
{
	background-color:#<?= $base->bg['-1'] ?>;
	color:#<?= $base->bg['+6'] ?>;
}
.nav ul li:hover 
{
	background-color:#<?= $base->bg['+8'] ?>;
	color:#<?= $base->bg['-2'] ?>;
	text-decoration:none;
}
.nav ul li{ border-width:1px 1px 0 0;}
 

.nav li ul { /* second-level lists */
 
	display: none;
	position: absolute;
	top:  2.1em;
	<?echo get_s_align();?>: 0;
	background-color:#<?= $base->bg['-1'] ?>;
	color:#<?= $base->bg['+9'] ?>;
	border-right: #<?= $base->bg['0'] ?> 1px solid;
	border-left: #<?= $base->bg['0'] ?> 1px solid;
	border-bottom: #<?= $base->bg['0'] ?> 1px solid;
	border-radius: 8px 0 8px 8px;
	z-index: 9999;
}
.nav li ul li
{
	z-index: 60;
	float:none;
	padding:0;
	width: 270px;
	display:block;
   	border-right: none;
	border-left: none;
    text-align: <?=get_s_align()?>;
	border-bottom: #<?= $base->bg['-8'] ?> 1px dashed;
 
}
.nav li ul li a
{
	text-decoration:none;
	display:block;
	padding:0.6em 0.5em;
    border: #<?= $base->bg['+3'] ?> 0px solid;
	color:#<?= $base->bg['+9'] ?>;
}

#for_title {
    border-radius: 5px;
    clear: both;
    float: <?=get_s_align()?>;
    padding: 0 0.1em;
}
.removeadlink{
padding:1.2em;
font-weight: bold;
<? if (isHeb()) echo "direction:rtl"; ?>;
}
ul { list-style-type: none;}
.success {background:#e6efc2;color:#264409;border-color:#c6d880;}
.error, .alert {background:#fbe3e4;color:#8a1f11;border-color:#fbc2c4;}
.float
{
	float:<? echo get_s_align(); ?>;
	<? if (isHeb()) echo "direction:rtl"; ?>;
	text-align: <?=get_s_align()?>;
}
.invfloat
{
	float:<? echo get_inv_s_align(); ?>;
	<? if (isHeb()) echo "direction:rtl"; ?>;
	text-align: <?=get_inv_s_align()?>;
}
.button
{
    height: 2em;
    width: 5em;
    
    font-weight: bold;
}
td
{
	border: none;text-align:<?echo get_s_align();?>;
}
.small
{
    font-size: 0.8em
}
#latestwind .small{
    font-size: 0.4em
}
.big
{
    font-weight: bold;
    font-size: 1.35em
}
#graphnav{
    padding:0;margin:0;border:0
}
#graphnav.nav li
{
    border:0;margin:0;float:none;padding:0.4em
}
#graphmain{
    clear:both;width:100%;float:<?echo get_s_align();?>;margin:0 auto;padding:0
}
#msgDetails .chosenreply  {
width:88%
}
#user_icon{

}
#user_name{
font-size:1em;
font-weight:bold;
margin-top: 0.1em;
}
input:focus::-webkit-input-placeholder 
{
    color: transparent;
}
#forum a{
    color:#000;
}
.info_btns
{
direction: rtl;
float: none;
margin: auto auto -40px;
top: 140px;
width: 320px;
padding-right: 0;
z-index:10;
}
.forecasttimebox
{
  padding-<?=get_s_align()?>:0px;
  width: 100%;
  height:2.7em;
  clear:both;
}
.forecasttimebox .forcast_date{
text-align:center;width:6%
}
.forecasttimebox .forcast_time{
    width:17%;
    direction:ltr;
    text-align:<?=get_inv_s_align()?>;
    
}
#forcast_hours liabilities{
padding:0.3em
}
#forecasthours ul li.forcast_time{
padding:0.1em 0.5em
}
.forecasttimebox .forecasttemp{
    text-align:center;
    width:13%;
    font-family: nextexitfot_regularregular;
    font-size: 1.3em;
}
.forecasttimebox .forcast_icon{
    text-align:center;width:7%
}
#temp_btn{
    margin-right: 40px;
    margin-top: -150px;
    
}
#temp2_btn{
    margin-right: 18px;
    margin-top: -3px;
}
#moist_btn{
    margin-right: 5px;
    margin-top: 0;
}
#rain_btn{
    margin-right: 2px;
    margin-top: 2px;
}
#wind_btn{
    margin-right: 10px;
    margin-top: 2px;
}
#aq_btn{
	margin-right: 24px;
    margin-top: 2px;
}
#latesttemp, #latestrain, #latesthumidity,#latestwind, #latesttemp2, #latestairq, #latestnow  {
margin:auto;margin-top:-68px
}
#valleytemp{
font-size:0.5em;
}
#winddir{
margin-top:0.75em
}
.paramvalue{
position:relative;
top:0;
}
.trendstable
{
position:relative;
top:0;
}
.paramtrend{
top:0
}
.trendstable td{
text-align:center
}
#temp_line{
left: 37px;
margin-top: 128px;
transform: rotate(175deg);
width: 10px;
opacity: 0;
}
#moist_line{
left: 43px;
margin-top: 157px;
width: 10px;
opacity: 0;
}
.seker_btns{
margin: 0 auto;
margin-top:-30px;
width: 100px;
z-index:1200;
position:absolute;
padding-left: 0px;
<? if (!isHeb()) echo "direction:ltr"; ?>;

}
.seker_btns li{
width:84px;
}
.info_btns li{
-webkit-user-select: none; 
-moz-user-select: -moz-none; 
-ms-user-select: none; 
user-select: none; 
-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}

#rain_line{
    left: 56px;
    margin-top: 184px;
    transform: rotate(130deg);
    width: 10px;
    opacity: 0;
}
h3{
line-height:30px;
}
#season_line, #cold_line, #wind_line{
left:10px
}
#uv_line, #rad_line{
left:10px;
}
#aq_line, #air_line{
left:10px;
}
#now_line{
left:10px;visibility:hidden
}
#forcast_hours
{
margin: 0 auto;
clear:both
}
.forcast_each .spriteB.up, .forcast_each .spriteB.down {
margin:11px
}
#graph_forcast{
        height:270px;
        width:540px;
        margin:0 auto;
    }
#graphForcastContainer
{
    position:relative
}
#graph_forcastWrapper
{
    margin: 0 auto;
    width:320px;
    left: 0;
    right: 0;
    bottom: 0;
    -webkit-overflow-scrolling: touch;
    overflow-x: scroll;
    overflow-y: hidden;
}
<? if ($_GET['debug'] == '') include "../end_caching.php"; ?>
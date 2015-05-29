<?  
    ini_set("display_errors","On");
    header("Content-type: text/css");
    
 
$lang_idx = @$_GET['lang'];
$width = @$_GET['width'];
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
.inparamdiv
{
	text-align:center;
        position: relative;
        z-index:200;
	<? if (isHeb()) echo "direction:rtl"; ?>
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
#for24_given
{
	margin:0.6em 1em;
	float:<?echo get_s_align();?>
}
.forecasttimebox
{
width:90%;clear:both;
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
.forecasttemp
{
	text-align:center;direction:ltr;font-weight:bold;
}
#nextdays
{
       
	<? if (isHeb()) echo "direction:rtl"; ?>
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
#updateprofile, #signout
{
  padding:0.5em;margin:0.5em 0em;cursor:pointer;float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>; width: 110px;
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
	width: 92%;
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
	border-top:1px dashed;clear:both;margin:0 auto;width:100%;
	<? if (isHeb()) echo "direction:rtl"; ?>;
}
#chat_title
{
	text-align:<?echo get_s_align();?>;
	clear:both;
	margin:0.2em 0.6em;
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
#messages_box{
float:<?echo get_s_align();?>;
text-align:<?echo get_s_align();?>;
width:100%;
}
#livepic_box{
clear:both
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
    padding-right:15px;
    padding-left:15px;
    margin-bottom:5px;
}
#chat_links
{
	float:<?echo get_s_align();?>;
	text-align:<?echo get_s_align();?>;
        margin-<?echo get_s_align();?>:3.5em
 
 
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
text-align:center   
}
#statusline a
{
	font-weight:normal;
}
#windy
{
width:93%
}
#coldmeter
{
	float:none
}
#coldmeter a
{
	font-weight:normal;
}
#currentinfo_container
{
	
}
.white_box{

}

#statusline
{
    <? if (count($sig) > 1){?> <?}?>
    
        padding:0;
	font-weight:normal;
	font-size:1.4em;
        margin-top:-1.5em
}
#what_is_h
{
	font-size:0.95em;
	margin-top:0.2em;
        width: 70%;
        margin: 0 auto;
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
.forcast_title_btns
{
	display:inline-block;
        font-size:25px;
}
.forcast_title_btns:hover
{
	
}
.timefh, .tsfh{
font-family:nextexitfot_regularregular;
letter-spacing: 0px;
}
#fornextdays_title, #for24h_title
{
	border-radius:0;
	border-top-<?=get_inv_s_align()?>-radius:15px;
	border-bottom-<?=get_inv_s_align()?>-radius:15px;
	margin-<?=get_s_align()?>:0;
        padding-<?=get_s_align()?>:0.4em;
	
}
#fornextdays_title
{
	
}
#mobileslogan
{
	
}
#tempunitconversion
{
	float:none
}
#mobilelogo, #mobileslogan
{
    text-align: center;
    width: 85%;
    margin-top:0.8em
}
#forum hr {
width:100%;
margin-left:0;
clear:both
}

#user_info{
color:#3D718E;
padding:0.5em
}

.inparamdiv
{
    padding:0.5em;
}
#tempdivvalue
{
    float:none;
    font-size: 6em;
    margin-top: 8px;
    font-family:nextexitfot_regularregular;
}
#latestnow
{
    padding:1em 0.5em 0em 0.5em;
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
#itfeels_windchill, #itfeels_heatidx{
float:none;margin: 0 auto;width: 220px;top:2.6em;
}
.graphslink
{
position:relative;right:0;top:0
}
#tohome
{
    padding:0.8em
}
#replyInputsDiv
{
position:absolute;
bottom:-200px;

}
canvas{
margin-top: 50px;
z-index: -10;
height: 220px;
width:100%
}

#forcast_icons{
margin-<?=get_s_align()?>:<? if (isHeb()) echo "40px"; else echo "18px";?>;
padding:0
}
#forcast_icons li{
width:20px;margin-left: 15px

}
#forecastnextdays .tsfh, #shortforecast .tsfh{
font-size:1.3em
}
#radar{
color:#000000;
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
#for24_given
{
margin:0.6em 0.3em
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
    margin-left: -95px;
    <? if (!isHeb()) echo "margin-right:0px"; ?>
}
#cold_btn a{
color:#000;display:block;z-index: 100;
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
	 padding:0.4em;
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
	top:  3.3em;
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
    border:0;margin:0 0.1em
}
#graphmain{
    clear:both;width:100%;float:<?echo get_s_align();?>;margin:0 auto;padding:0
}
#msgDetails .chosenreply  {
width:88%
}
#user_icon{
margin-top:0;
}
#user_name{
float:none;
font-size:1.1em;
font-weight:bold;
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
margin: auto auto -10px;
top: 100px;
width: 320px;
padding-right: 0;
}
.forecasttimebox
{
  padding-<?=get_s_align()?>:0px;
  width: 100%;
}
.forecasttimebox .forcast_date{
text-align:center;width:6%
}
.forecasttimebox .forcast_time{
    width:13%;
    direction:ltr;
    text-align:right;
    
}
#forecasthours ul li.forcast_time{
padding:0.1em 0.5em
}
.forecasttimebox .forecasttemp{
    text-align:center;
    width:8%;
    font-family: nextexitfot_regularregular;
    font-size: 1.3em;
}
.forecasttimebox .forcast_icon{
    text-align:center;width:8%
}
.forecasttimebox .forcast_title{
    width:35%
}
#temp_btn{
margin-right: 40px;
margin-top: -90px;
}
#moist_btn{
margin-right: 18px;
margin-top: -3px;
}
#rain_btn{
    margin-right: 5px;
    margin-top: 0;
}
#latesttemp, #latestrain, #latesthumidity {
margin:auto
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
margin-bottom: -30px;
width: 100px;
z-index:200;
position:relative;
padding-left: 0px;
<? if (!isHeb()) echo "direction:ltr"; ?>;

}
.seker_btns li{
width:80px;
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
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

html {
   min-height: 100vh;
 }
body{
text-align:center;
margin:0;
font-size: <?if (isHeb()) echo "13.1"; else echo "11.5";?>px;
overflow-x: hidden;
}
#date{
display: inline-block;
margin-top: 0.5em;
font-family:nextexitfotlight;
font-size:1.3em;
}
h1{
margin-<?=get_inv_s_align()?>:194px;
margin-bottom:0px;
}
.inparamdiv
{
	text-align:center;
    position: relative;
    width: 100%;
    height: 235px;
    z-index:200;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
.inparamdiv ul{
    padding:0;
    margin-top:0
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
#forecastnextdays, #nextdays_table
{
	padding:0.1em 0.1em;;width:100%;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#forecastnextdays table, #nextdays_table table
{	
	border-spacing: 0px 8px;
	padding:0em 0.1em;
	width:100%;
	height:50px;
	clear:both;
	text-align:<?echo get_s_align();?>;
	border-top:0 none;
	<? if (isHeb()) echo "direction:rtl"; else echo "direction:ltr";?>
}
#forecastnextdays td
{
    
}
#forecastnextdays tr, #nextdays_table tr
{
    margin-top:0.2em
}
#forecastnextdays .plus, #nextdays_table .plus{
    background:#eeeeee
}

#forecastnextdays table .text, #nextdays_table .text
{
    padding: 0 0.75em 0.2em;
    line-height: 1.1em;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    background:#eeeeee;
    font-size:1.1em
}
#forecastnextdays .tsfh .icon, #nextdays_table .tsfh .icon{
    margin-top:10px;
}
#forecastnextdays .paramunit, #nextdays_table .paramunit{
    display:none;
}
#forecastnextdays .average{
    font-size:1.40em  
}
#forecastnextdays .date, #nextdays_table .date{
    font-family:nextexitfot_regularregular;
    letter-spacing: 0px;
    font-size:1.2em;
    text-align:center;
    line-height:1em;
    width: 2em;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    background:#eeeeee
}
#forecastnextdays .datetext, #nextdays_table .datetext{
    font-size:0.8em;
}
#forecastnextdays .datef, #nextdays_table .datef{
    text-align:center;line-height: 0.9em;width:2em
}
#forecastnextdays table a, #nextdays_table table a
{
    text-decoration:underline;
}
#forecastnextdays .humidity a, #nextdays_table .humidity a
{
    text-decoration:none;
    font-size:3em

}
#forecastnextdays table a.info, #nextdays_table table a.info
{
    text-decoration:none;
}
#forecastnextdays .tsfh, #nextdays_table .tsfh{
font-size:1.60em;
line-height: 0.7em;
text-align:center;
padding: 0.6em 0;
background:#eeeeee
}
#forecastnextdays .enlarge, #nextdays_table .enlarge{
    margin: 4.2em 0px;
}
#legends
{
    width: 320px;
    padding: 0 0.5em;
}
#forecastnextdays_table .icon_day, #nextdays_table .icon_day{
    background:#eeeeee;
    float:none
}
#latestalert .alerttime{
    display:inline;
    padding-<?echo get_s_align();?>: 0;
    padding-<?echo get_inv_s_align();?>: 0.3em;
    font-weight: normal;
}
#latestalert .title{
    display:inline;
    margin-top:4px;
    text-shadow:none;
    position: relative;
    font-weight: normal;
}
.title.txtindiv{
    font-weight: bold;
}
.paramtitle
{
    margin-top: -0.5em;
}
#latestalert .info .info{
    margin-top:-150px;
    margin-<?echo get_s_align();?>:-10px;
    background: rgba(238,238,238,0.9);
    width: 290px;
    
    box-shadow: none;
    color:black
}
#latestalert .info .info .title{
   
}
#latestalert #alerttxt{
    text-shadow: none;
    padding: 1em;
}
#latestalert #alertbg{
    margin: 0 -1px;
}
#startpage_con{
  
    float: <?echo get_s_align();?>;
    <? if (isHeb()) echo "direction:rtl"; ?>;
    margin-top: 40px;
    position: absolute;
    width: 30%;
    margin-<?echo get_inv_s_align();?>: 70%;
}
#forcast_days.detailed
{
    padding:0
}
#forcast_days.detailed .forcast_day, #forcast_days.detailed .forcast_date{
  width:90%;
}
#forcast_days.detailed li{
    display: grid;
    font-size:1.1em;
}
#forcast_days.detailed .forcast_morning, #forcast_days.detailed .forcast_noon, #forcast_days.detailed .forcast_night{
    margin-top: 0.3em;
    border-top: 5px solid;
    width:90%
}
#forcast_days.detailed .forcast_morning div, #forcast_days.detailed .forcast_noon div, #forcast_days.detailed .forcast_night div{
    padding: 0.2em 0;
}
#forcast_days.detailed .wind_icon{
    font-size: 1em;
    padding-top: 1em !important;
}
#forcast_days.detailed .forcast_text
{
    width:90%
}
.wind_icon{
    padding:0.6em 0;
}
#latestalert .info .info .title.txtindiv{
    color:white;
    text-align:<?echo get_s_align();?>;
    
}

#latestalert
{
    visibility:hidden;
    font-size:1.1em;
    padding:0.1em 0;font-size: 1.4em;z-index: 99999;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    background: #eeeeee;
    <? if (isHeb()) echo "direction:rtl"; ?>
}
.low{
    color:#0089cc;
}
.loading{
width: 75%;
position: fixed;
left: 51%;
margin-left: -37.5%;
margin-top:30px;
z-index:2000;
}
.forecasttemp
{
	text-align:center;direction:ltr;font-weight:normal;
}
#nextdays
{
        margin:1em 0em;
        <? if (isHeb()) echo "direction:rtl"; ?>
}
#section{
position:relative;float:none;width:auto;top:0;margin:0;
}
#coldmeter
{
          float:<?echo get_s_align();?>;top: <? if (isHeb()) echo "5.2"; else echo "6.2"; ?>em;
}
#radio_toolbar_container
{
    margin:0em 1em;width:90%;text-align: center;
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
	width:100%;margin:0.2em 1em
}
#loggedin, #notloggedin
{
 clear:both;margin: 0 0.5em;text-align: center;font-size: 1.5em;width:210px;height:200px;
}
#hello{

}
#forgotpass
{
       padding:0.2em;width:auto;float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>;margin:0.2em;cursor:pointer
}
#login, .register, .login, .register{
    
}
#profileform, #registerform
{
    padding:1.2em;
    font-size:1.4em;
    text-align:<?echo get_s_align();?>;
}
#updateprofile, #signout, #myvotes, #clicktoregister, #clicktoregister, #loginform_submit, #forgotpass, #clicktogetvotes, #clicktoupdate, #profileform_submit, #passforgotform_submit, #registerform_submit
{
  padding:0.4em;margin:0.2em 0em;cursor:pointer;float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>; width: 280px;
}
#registerinput, #profileform
{
    line-height:2.2em
}
#clicktoupdate
{
    margin-top:2em
}
#loginform input[type="text"], #profileform input[type="text"], #registerform input[type="text"], #registerinput input[type="password"], #loginform input[type="password"]
{
    height:1.5em;
    font-size: 1em;
    width:280px
}
.icon_right
{
    padding: 0 20px;
    margin-right: -50px;    
}
.icon_left
{
    margin-right: 146px;
    padding: 0 30px;    
}
.user_icon_frame
{
    margin-right: 120px;
}
#snowtable{
width:320px;
}
#radarcontrols{
     top:40px;
    z-index:999;
}
#playcontrol{
    top:220px;
    right:220px;
    position:absolute;
}
#radarimg{
    margin-<?echo get_s_align();?>:-60px;
}
#wrapper{
    width: 570px;
    margin: 0 -210px;
    clear: both;
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
    margin-<?echo get_s_align();?>: 32px;
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
    background-color: white;
	
}
body.mce-content-body
{
    background:white;
}
#msgDetails
{
	clear:both;
	text-align:<?echo get_s_align();?>;
	padding:0.5em 1em 0em 1em;width:98%;
 
}
#new_post_okay, #new_post_cancel {
    background-color:blueviolet;
    color:#fff;
    width:60px;
    border-radius:5px;
    display:inline-block;
    margin:20px;
}
#new_post_user {
    background-repeat:no-repeat;
    background-position:right;
    
   height:51px;
   width:51px;
   margin-top:-72px;
   margin-bottom:30px;
   margin-right:27px;
}
.pivotpointer{
clear:both
}
.postusername{
margin: 0 28px 0 8px;
}
.chatbodyreply .postusername{
margin: 0;
}
.chatbodyreply .msgcount{

}
.chatbodyreply .avatar{
<?echo get_s_align();?>: 6px;
}
#messages_box{
float:<?echo get_s_align();?>;
text-align:<?echo get_s_align();?>;
padding:0;
font-size: 1.2em;
width:100%;
line-height: 1.2em;
<? if (isHeb()) echo "direction:rtl"; ?>
}

#latest_picoftheday{
    
}
#latest_user_pic{
    min-height: 50px;
}
#livepic_box{
margin:0 auto;
width: 100%;
}
#livepic_box h3{
margin-top:0
}
.sticky {
  position: fixed;
  top: 0px;
  opacity:0.95;
  z-index:9999;
  background-color:#eeeeee;
}
#navbar{
    width: 100%;
    <? if (isHeb()) echo "direction:rtl"; ?>
}
.play {
    position: absolute;
    top: 310px;
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
    padding-<?echo get_s_align();?>:5px;
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
-webkit-transform: translate3d(0,0,0);
margin: 0 auto;
width:320px;

}
#startinfo_container .currentcloth
{
   position: absolute;
   margin-top: -3.2em;
}
#startinfo_container
{
    float:<?echo get_s_align();?>;
    padding: calc(9.5em - 10px) 0 8em;
    bottom:1em;
    margin:0;
    text-align:<?echo get_s_align();?>;
    width: 100%;
}
#currentinfo_container
{
    width:100%
}
#currentinfo_container .currentcloth
{
   position: absolute;
   margin-top: -1.9em;
  
}
#currentinfo_container .inparamdiv
{
    font-size: 1.6em;
}
@keyframes blink-animation {
    0% {
    transform: translate(0, 0);
    opacity:0;    
    }
    50% {
     opacity:0.3;
     transform:  translate(0, 5px);
  }
  100% {
    opacity:1;
    font-weight: bold;
    transform: translate(0, 8px);
    text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
  }
}
#arrowdown{
    
    text-align:center;
    font-size: 2.2em;
    position: absolute;
    width: 100%;
	margin-top: -0.4em;
	z-index: -10;
	display:none;
    animation: blink-animation 0.5s 0.2s ease 6 forwards;
}

@media screen and (min-device-aspect-ratio: 9/20) 
{
    #startinfo_container
    {
        padding: calc(8.4em - 10px) 0 8em;
    }
 }
 @media screen and (min-device-aspect-ratio: 9/18) 
{
    #startinfo_container
    {
        
        padding: calc(6em - 10px) 0 8em;
    }
    
}
@media screen and (min-device-aspect-ratio: 9/16) 
{
    #startinfo_container
    {
        
        padding: calc(4.1em - 10px) 0 8em;
    }
    
}
@media screen and (min-device-aspect-ratio: 3/5) 
{
    #startinfo_container
    {
        padding: calc(3.8em - 10px) 0 8em;
    }
    
}
@media screen and (min-device-aspect-ratio: 3/4) 
{
    #startinfo_container
    {
        padding: calc(2.8em - 10px) 0 8em;
    }
   
}
#startinfo_container #laundryidx, #startinfo_container #heatindex
{
    display:none
}
#startinfo_container .invhigh
{
    background-color: transparent;
    color:black;
    vertical-align: super;
    font-size: 0.55em;
    display:inline
}
#statusline a
{
	font-weight:normal;
}
#laundryidx{
    left: -12px;
    top: 31px; 
}
 .forcast_each{
     padding-top:1.2em;
     margin-bottom: 0px;
 }

#windy
{
width:33%;left:9.5em;top:3em
} 
.open-close-button{
  width: 1.4em;
  height: 1.4em;
  margin: -0.6em -0.6em;
}  
#windystart
{
    position: absolute;
    <?echo get_s_align();?>: 5.5em;
    
}
#morning, #noon, #night
{
    width:2.9em
}

#plus
{
    width:1.2em
}
#coldmeter
{
	float:none
}
#noon, #night{
    text-align:center;
}

#coldmetertitle:hover span.info
{
    <?echo get_s_align();?>: -20px;
    top: -100px;
    width:250px;
    
}
#asterisk:hover span.info
{
    <?echo get_s_align();?>: -4.5em;
    top: -3.5em;
    width:250px;
    
}
.cloth a.info:hover span.info
{
    <?echo get_s_align();?>:-3.5em;
    top: -3.5em;
    width:2em;
}
#morning a.info:hover span.info
{
    <?echo get_s_align();?>: 0em;
    top: 1.5em;
    width:2em;
}
#noon a.info:hover span.info
{
    <?echo get_s_align();?>: -1em;
    top: 2em;
    width:2em;
}
#night a.info:hover span.info
{
    <?echo get_s_align();?>: -2em;
    top: 1.5em;
    width:4em;
}
#current_feeling_link a.info:hover span.info
{
    <?echo get_s_align();?>: -6em;
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
#coldmeter span.info{
    width:100px;right:0;left:0

}
#currentinfo_container
{
	float:<?echo get_s_align();?>
}
.white_box{
border-radius: 0px;
}

#statusline, #statuslinestart
{
    <? if ($sig && count($sig) > 1){?> <?}?>
    
    font-size: <?  if (!isHeb()) echo "1"; else echo "1.2"; ?>em ;
    font-weight: normal;
    line-height: 1em;
    margin-top: <?  if (!isHeb()) echo "-5.6"; else echo "-5.1"; ?>em;
    padding: 0;
    color:#ffffff;
}
#statuslinestart
{
    margin-top:-0.5em;
    padding:0 30px;
    font-size: 1.5em;
}
#what_is_h, #what_is_h_start
{
	font-size:1.1em;
	margin-top:0.2em;
    padding:1em;
    width: 70%;
    margin: 1em auto 0;
    line-height:16px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    background: #eeeeee;
}
#what_is_h_start
{
    margin: 0 30px;
    width:100%;
    z-index:9;
    font-size: 1.5em;
    line-height: 0.8em;
    
}
#what_is_h .rainpercent{
    margin: -24em 11.5em;
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
   background:white

}
#shortforecast
{
	
	width:100%
	
}
#forcast_hours ul, #forcast_hours_table ul{
    padding: 0 0.4em;
}
#shortforecast .tsfh
{
    font-size: 1.40em;
}
#shortforecast .nav li
{
    width:21%;direction:ltr
}
.timefh{
    width:3em
}
.nav .timefh, .nav .wind, .nav .forcast_icon{
    width: 14%;
}
.forcast_title
{
width:90px;
text-align:<?=get_s_align()?>;
}
.forcast_title_btns
{
	display:inline-block;
    width:24%;
    padding-<?=get_inv_s_align()?>:1px;
    text-align:center;
    padding-top:5px;
    height: 40px;
    float:<?=get_s_align()?>;
        font-size:1.4em;
        margin-bottom:0px;
        font-weight: bold;
        background-color:rgba(0,0,0,0);
        margin-<?=get_s_align()?>:0
}
.forcast_title_btns:hover
{
    margin-<?=get_s_align()?>:0;
    padding-<?=get_inv_s_align()?>:1px;
    background-color:rgba(0,0,0,0);
}
.forcast_title_btns.for_active:hover
{
    padding-<?=get_inv_s_align()?>:1px;
    margin-<?=get_s_align()?>:0;
}
a.cboxElement {
text-decoration: underline;
}

.forcast_title_btns a
{
    display:inline-block;
    color:#000000;
    width:100%
}
.forcast_title_btns.for_active:hover{
    background-color:rgba(0,0,0,0);
}
.for_active
{
    border-bottom: 4px black solid;
    border-bottom-right-radius: 0px;
}
.timefh, .tsfh{
font-family:nextexitfot_regularregular;
letter-spacing: 0px;
}
.fornextdays_title, .for24h_title, .alerts_title, .now_title
{
	margin:0;
     
	
}
.info_btns li.no{
    background-position-x: 6px;
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
    height:40px;
    background-size: 38px;
    margin: 10px <? if (isHeb()) echo "4em";?> 10px;
    background-position: right <? if (isHeb()) echo "38px"; else echo "54px";?> top;
    direction:rtl;
    z-index:0
    
}
.logostart{
    margin-<?echo get_s_align();?>:0 !important
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
.icon_left, .icon_right{
    margin-top: -28px;
    width: 50px;
}
#user_info{
color:#3D718E;
padding:0.5em;
position: absolute;
z-index: 1000;
top: 0.5em;
width: 160px;
<?=get_s_align()?>: 6.5em;

}

.inparamdiv
{
    padding:0.1em;
    background: rgba(255,255,255,0.0);
}
#tempdivvalue, #tempdivvaluestart
{
    float:none;
    font-size: 3.4em;
    margin-top: 30px;
    z-index:99999;
    direction:ltr;
    margin-left:0;
    
   
}
#activities_yes_con, #activities_no_con{
    margin: 0px 0px;
    display: contents;
}
#activities_yes li, #activities_no li{
    width: 26px;
    height: 26px;
    margin:4px
}
#activities_yes, #activities_no{
   width:750px
}

#cm_dislike
{
    <?=get_inv_s_align()?>: 1em;
    top: <? if (isHeb()) echo "6.2"; else echo "7";?>em;
}
#cm_like
{
    <?=get_inv_s_align()?>:3.2em;
    top: <? if (isHeb()) echo "6.2"; else echo "7";?>em;
}
#tempdivvaluestart
{
    margin-top: 20px;
    margin-<?=get_s_align()?>:0.4em
}
.shade{
    <? if (isHeb()) echo "margin: 4.5em 0 0 0.8em;"; else echo "margin: 4.5em 0 0 0.6em;";?>; 
}
#latestnow
{
    padding:0.5em 0.3em 0em 0em;
    margin: auto;
    font-size: 1.3em;
}

#more_info_btn
{
    margin-top:0.8em;clear:both
}
#extendedInfo
{
margin:auto;
}
#itfeels {
    margin:0;top:4.5em;background: none;  width: 40%;font-size: 28px;text-align: center;padding: 0 10px;
}
#itfeels_windchill, #itfeels_heatidx, #itfeels_thsw{
top:0;position:relative; background: none;margin:auto
}
#heatindex{
margin-top:1em;width: 150px;
}
.graphslink
{
top:215px;
width:100%;
<?=get_s_align()?>:0
}
#tohome
{
    position: relative;
    z-index: 3000;
    
}
#tohome a{
    display: inline-block;
padding: 0.1em 0.3em;
font-size: 2.5em;
line-height: 1em;
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
width:320px
}


.humidity{
    font-size:0.8em
}
#nextdays_table .humidity{
    display:none
}
#forcast_hours li, #forcast_hours_table li{
    font-size:1.1em
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
#for24_hours .nav li,#for24_hours_s .nav li, #forcast_hours_table .nav li
{
line-height: 0.9em;
color:#000;
}
#for24_hours .nav li .wind_icon, #forcast_hours_table .nav li .wind_icon, #nextdays_table .wind_icon
{
margin-top:0.5em;
padding: 0.8em 0 0;
}
.wind_icon .small{ font-size:0.6em}
.light_wind{
    background-position: -80px 0px;
}
.moderate_wind{
    background-position: -40px 0px;
}
#for24_hours .forcast_title, #forcast_hours_table .forcast_title {
    padding-top:0.7em;
    padding-bottom:0;
}
#for24_hours .timefh, #forcast_hours_table .timefh{
    padding:0.5em 0.6em 0 0;
    direction:ltr
}
#forcast_hours_table{
    margin:0
}
#forcast_hours_table .open-close-button{
    margin:0.2em -0.6em
}
.text a.info:hover span.info
{
<?echo get_s_align();?>: -15em;
}
.inparamdiv .highlows
{
    width:100%;
border-top:0px;top:95px;margin:0
}
#latestwindow .highlows
{
    top:40px;
}
#latestairq .highlows{
    top:0
}
#latestradiation .paramtrend
{
    top: 4.8em;
}
#latestradiation .highlows
{
    top: 3.8em;width:100%
}
#latestairq .trendstable{
    top:7em
}
.dusttitle{
    font-size:0.9em
}

#aqvalues{
    margin-top: -0.3em;
    position: absolute
}
#sigweather{
    position: absolute;
    top: 220px;
    text-align: right;
    width: 290px;
    left: 10px;
    opacity: 1;
    z-index: 9999;
    background: rgba(238,238,238,0.9);
    border-radius: 15px;
    padding-bottom:10px;
    padding-right:10px
}
#xClose{
    display:block;
}
#sigweather li{
    line-height: 30px;
}
#what_is_h .invhigh{
    display:inline-block;
    font-size: 0.75em;
    vertical-align: text-top;
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
#bg1-7, #bg1-5, #bg1-6{
left:745px;
}
#bg2-9{
    left: 100px
}
#bg1-7{
left:450px;
}
#bg1-8{
    top: 200px;
    left: 640px;
}
#bg2-7{
    left:700px;
    top:130px;
}
#bg1-3{
    top: 130px;
    left: 335px;
}
#bg2-4{
    top: 120px;
    left: 540px;
}
#bg1-4{
    left:45px;
}
#bg1-6{
    left:240px;
}
#bg2-10{
    left: 675px;
    top: 130px;
}
#thwtab{
clear:both
}
#webcam_btn a, #cold_btn a{
display:block;z-index: 100;padding-top: 7px;width: 30px;
    margin: auto;
    
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
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    -webkit-tap-highlight-color: transparent;
    border-radius: 5px;
    clear: both;
    float: <?=get_s_align()?>;
    padding: 0;
    width:100%;
    background-color: #eeeeee;
}
#startupdiv, #register_suggest{
    top: 0; padding:55px 10px;left: 0;z-index:999999; position: absolute;background-color: #FFFFFF;
    <? if (isHeb()) echo "direction:rtl"; ?>;
    
}
.removeadlink{
padding:0.5em 1.5em;
font-weight: bold;
<? if (isHeb()) echo "direction:rtl"; ?>;
}
.removeadlink img {
    vertical-align: middle;
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
    margin:0.5em 0;
    font-weight: bold;
}
td
{
	border: none;
}
.small
{
    font-size: 0.8em
}
#latestwind .small, #aqvalues .small{
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
    border:0;margin:0;float:none;padding:0.5em;text-align: <?echo get_s_align();?>;
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
margin: 0 auto;
width: 555px;
padding-right: 0;
z-index:10;
}
#info_btns_wrapper
{
overflow-x: scroll;
width: 320px;
direction:rtl;
}
.forecasttimebox
{
  padding-<?=get_s_align()?>:0px;
  width: 100%;
  height:2.7em;
  clear:both;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    background: #eeeeee;    
    margin-bottom: 0.2em;
    padding: 0.2em;
}
.forecasttimebox .forcast_date{
text-align:center;width:6%
}
.forecasttimebox .forcast_time{
    width:17%;
    direction:ltr;
    text-align:<?=get_inv_s_align()?>;
    font-size: 1.1em;
    padding-top: 0.4em;
    
}
#messages_box .box_text, #messages_box h2{
    padding:0 18px
}
#messages_box #alertbg{
    margin: 0 -25px;
    margin-top:-60px;
}
#messages_box .inv_plain_2{
    padding:5px
}
#forcast_hours liabilities{
padding:0.3em
}
.google-auto-placed {
width:320px !important;
height:50px !important;
text-align:center !important;
margin: 0 auto !important;
}
#forecasthours ul li.forcast_time{
padding:0.1em 0.5em
}
.forecasttimebox .forecasttemp .paramunit{
    font-size:0.6em;
}
.forecasttimebox .forecasttemp{
    text-align:center;
    width:15%;
    font-family: nextexitfot_regularregular;
    font-size: 1.3em;
}
.forecasttemp .number{
    font-size:1em
}
.forecasttimebox .forcast_icon{
    text-align:center;width:7%
}
#now_btn{
    margin:4px;
    position: relative;
}
#temp_btn{
    margin:4px;
    position: relative;
    
}
#temp2_btn{
    margin:4px;
    position: relative;
}
#temp3_btn{
    margin:4px;
    position: relative;
}
#moist_btn{
    margin:4px;   
    position: relative;
}
#rain_btn{
    margin:4px;
    position: relative;
}
#wind_btn{
    margin:4px;
    position: relative;
}
#uv_btn{
	margin: 4px;
    position: relative;
}
#aq_btn{
	margin:4px;
    position: relative;
}
#rad_btn{
    margin:4px;
    position: relative;
}
#window_btn{
    margin:4px;
    position: relative;
}
#webcam_btn, #cold_btn{
    
    background-repeat: no-repeat;
    opacity: 0.5;
    border-radius: 18px;
    background-position: 6px;
    background-color: #eeeeee;
    line-height: 0.8em;
    font-size: 1.05em;
    font-family: nextexitfotlight;
    font-weight:bold;
    margin:4px;
}
#webcam_btn{
    background:url("../img/urban.png") 8px no-repeat;
    background-size: 60%;
    background-color: #eeeeee;
}
#more_stations_btn{
    margin:4px;
    position: relative;
}
#cold_btn{
    width:36px;
    margin:4px;
    position: relative;
    
}
#cold_btn:hover{
    opacity: 1;
}
#runwalk_btn{
    margin:4px;
    position: relative;
}


#latestwebcam{
    overflow: hidden;
    padding: 0em 0.1em 0em 0.1em;
    margin-bottom:0.6em;
    border-radius:0
}
#latesttemp3 .graphslink{
    top:9.5em;
    <?=get_s_align()?>:0;
    width: 100%;
}
#latestrunwalk .exp
{
    position:absolute;margin-top: 30px;
}
#latestrain .paramtrend
{
    top: 105px;
}
#latestrain .highlows
{
    top: 86px;
    width:100%
}
#latestrain .trendstable
{
    top: 6.3em;
    
}
#section input
{
    width: 60px;
}
.comment_btn
{
    font-size: 1.1em;
}
#valleytemp{
font-size:0.5em;
}
#winddir{
margin-top:0.75em
}
.paramvalue{
top:30px;
}
.paramvalue .valley
{
    margin-top: -35px;
    font-size: 0.5em;
}
.param.valley
{
    margin-left: -5.5em;
}
.trendstable
{
top:120px;
}
.paramtrend{
top:180px
}
.trendstable td{
text-align:center
}
.trendstitles, .trendsvalues{
    line-height: 0.6em;
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
margin: 10px 0px;
top: 325px;
width: 50px;
z-index:1200;
position:absolute;
padding-left: 10px;
<? if (!isHeb()) echo "direction:ltr"; ?>;

}
.seker_btns li{
width:84px;
background: rgba(255,255,255,0.4);

}

.info_btns li{
-webkit-user-select: none; 
-moz-user-select: -moz-none; 
-ms-user-select: none; 
user-select: none; 
float:<?=get_s_align()?>   
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
margin:5px 27px 11px 11px
}
.rainpercent{
    margin: -5.1em 1.5em;
    position:absolute;
}
#0{
    margin: 0.3em;
}
#graph_forcast{
        height:160px;
        margin: 5px 0 0 0;
        
    }
#graphForcastContainer
{
    position:relative
}
.inparamdiv#chartjs-tooltip
{
    top:25px;
    font-size:1.7em
}
#chartjs-tooltip .rainpercent{
    margin: 0 90px;
}
#for24_hours
{
    margin-top:10px;
}
#graph_forcastWrapper
{
    
    text-align: justify;
    width:320px;
    -webkit-overflow-scrolling: touch;
    -webkit-transform: translateZ(0px);
    -webkit-transform: translate3d(0,0,0);
    -webkit-perspective: 1000;
    overflow-x: scroll;
    overflow-y: hidden;
    <? if (isHeb()) echo "direction:rtl"; ?>
}
.detailed #activities_yes .span-value:before, .detailed #activities_no .span-value:before, .detailed #bottombar .span-value:before{
    
    left: 41%;
    top: 190px;
}
.detailed #activities_yes .span-value:after, .detailed #activities_no .span-value:after, .detailed #bottombar .span-value:after{
    
    left: 40%;
    top: 170px;
}
#legends li{
    font-size: 1.2em;
}
.dotstyle ul {
	position: relative;
	display: inline-block;
	margin: 0;
	padding: 0;
	list-style: none;
	cursor: default;
}

.dotstyle li {
	position: relative;
	display: block;
	float: left;
	margin: 0 6px;
	width: 8px;
	height: 8px;
	cursor: pointer;
}

.dotstyle li a {
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	outline: none;
	border-radius: 50%;
	background-color: #fff;
	background-color: rgba(255,255,255,0.3);
	text-indent: -999em;
	cursor: pointer; /* make the text accessible to screen readers */
	position: absolute;
}
/* Fill up */
.dotstyle-fillup li a {
	overflow: hidden;
	background-color: rgba(0,0,0,0);
	box-shadow: inset 0 0 0 2px rgba(255,255,255,1);
	transition: background 0.3s;
}

.dotstyle-fillup li a::after {
	content: '';
	position: absolute;
	bottom: 0;
	height: 0;
	left: 0;
	width: 100%;
	background-color: #fff;
	box-shadow: 0 0 1px #fff;
	transition: height 0.3s;
}

.dotstyle-fillup li a:hover,
.dotstyle-fillup li a:focus {
	background-color: rgba(0,0,0,0.2);
}

.dotstyle-fillup li.current a::after {
	height: 100%;
}
<? if ($_GET['debug'] == '') include "../end_caching.php"; ?>
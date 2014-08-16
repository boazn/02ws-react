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
#main_cellphone_container div.chatmobile
{
	padding:0;
}
#main_cellphone_container
{
text-align:center   
}
#statusline a
{
	font-weight:normal;
}
#main_cellphone_container div.chatmobile div
{
	
}
#main_cellphone_container #chat_entire_div
{
	padding:0;
}
#windy
{
    float:none;margin:0
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
	width:98%;
	margin:0 auto;
}
#currenttemp_container
{
	margin:0 auto;
	text-align: center;
}
#currenttemp
{
	font-size:6em;
	font-family: nextexitfotlight;
}
#statusline
{
    <? if (count($sig) > 1){?> <?}?>
    
        padding:0;
	font-weight:normal;
	font-size:1.2em;
        margin-top:-1.2em
}
#what_is_h
{
	font-size:0.95em;
	margin-top:0.2em;
        width: 80%;
        margin: 0 auto;
}
#msgDetails .white_box2
{
	width:88%;
}
#slogan
{
	display:inline-block;
}
#forum{
   top:1390px;
   width:<?=$width?>;
   left:0;

}
#shortforecast
{
	
	width:100%
	
}
#shortforecast .nav li
{
    width:21%
}
.forcast_title_btns
{
	display:inline-block;
}
.forcast_title_btns:hover
{
	
}
#fornextdays_title, #for24h_title
{
	border-radius:0;
	border-top-<?=get_inv_s_align()?>-radius:15px;
	border-bottom-<?=get_inv_s_align()?>-radius:15px;
	margin-<?=get_s_align()?>:0;
	
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
    width: 65%;
    margin-top:0.8em
}
#forum hr {
width:<?=$width?>;
margin-left:0;
}
#msgDetails .chosenreply{
width:88%
}
#user_info{
color:#3D718E
}
.forecasttimebox
{
  padding-<?=get_s_align()?>:0px;
  width: 100%;
}
.inparamdiv
{
    padding:0.7em;
}
#tempdivvalue
{
    float:none;
}
#latestnow
{
    padding:2.5em 1em 0 1.2em;
    margin: auto;
}
.inparamdiv a
{
    font-weight: normal;
}
#more_info_btn
{
    clear:both
}
#extendedInfo
{
margin:auto;
}
#itfeels_windchill, #itfeels_heatidx{
float:none;width: 65%;top: inherit;
}
.graphslink
{
position:inherit;
}
#tohome
{
    padding:0.2em
}
#replyInputsDiv
{
position:absolute;
bottom:-250px
}
canvas{
margin-top: 70px;
z-index: 0;
}
.spriteB.down{
background-position: 0px;
}
#forcast_icons{
margin-<?=get_s_align()?>:12px
}
#forcast_icons li{
width:20px
}
#radarTab{
width:8em
}
#windy .wind_title
{
margin:0 auto
}
#windy .wind_icon
{
margin:0 auto
}
#forecasthours ul li span
{
vertical-align:-8px;
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

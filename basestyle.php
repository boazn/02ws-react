<?  
	 header("Content-type: text/css");
    include "include.php"; 
    include_once("csscolor.php");
	$forground = new CSS_Color(@$_GET['forground_color']);
	$base = new CSS_Color(@$_GET['base_color']);
	$lang_idx = @$_GET['lang'];
?>
body
{
    font-size: 13.1px;
	position: relative;
	margin: 0;
	padding: 0;
	
	color: #<?= $forground->bg['-7'] ?>;
    font-family: Alef, verdana, arial, serif
}
em
{
	font-size: 1em;
	font-weight: bold;
}
input, select , textarea, #search_box input
{
	border: 1px solid;
	padding:1px;
	background: #<?= $forground->bg['+7'] ?>;
}
ul { list-style-type: none;}
a
{
    font-weight: bold;
    color: #<?= $forground->bg['-8'] ?>;
    text-decoration: none;
}
a:hover
{
	text-decoration: underline;
}
a.hlink
{
	display:block;
	background: none transparent scroll repeat 0% 0%
}
tr.smalltbl
{
    font-size: 0.85em;
    text-align: center
}
table
{
    font-size: 1em;
	border: 0;
}
.success {background:#e6efc2;color:#264409;border-color:#c6d880;}
.error, .alert {background:#fbe3e4;color:#8a1f11;border-color:#fbc2c4;}
.manager
{
	font-size: 1.1em;
	color: #ffcc00;
}
.inv
{
	color: #<?= $forground->bg['+6'] ?>;
	background: #<?= $forground->bg['-1'] ?>;
	background-repeat: repeat-x;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}
.inv a
{
	color: #<?= $base->bg['+9'] ?>;
}
.inv span.info
{
	color: #<?= $forground->bg['0'] ?>;
}
.inv_plain
{
	color: #<?= $forground->bg['+3'] ?>;
	background: #<?= $forground->bg['-6'] ?>;
	border: #<?= $forground->bg['-2'] ?> 3px solid;
	padding: 5px;
	margin: 0em;
}
.inv_plain a
{
	color: #<?= $forground->bg['+5'] ?> !important;
}
.inv_plain a.hlink
{
	display:block;
	color: #<?= $base->bg['+2'] ?>;
    background: none transparent scroll repeat 0% 0%
}
.inv_plain span.info
{
	color: #<?= $forground->bg['-5'] ?>;
}
.inv_plain_2
{
 
	background: #<?= $forground->bg['+1'] ?>;
	color: #<?= $forground->bg['-8'] ?>;
	padding: 2px;
	margin: 0em;
 
}
 
.inv_plain_2_zebra
{
	background: #<?= $forground->bg['+3'] ?>;
	color: #<?= $forground->bg['-8'] ?>;
	padding: 0px;
	margin: 0em;
	border-radius: 8px;
	-webkit-border-radius: 8px;
	border-radius: 8px;
 
}
.inv_plain_2_zebra:hover
{
	background: #<?= $forground->bg['+8'] ?>;
}
.inv_plain_3_minus
{
	background:#<?= $forground->bg['+2'] ?>;
	color: #<?= $forground->bg['-9'] ?>;
	padding: 2px;
	margin: 0em;
 
}
.inv_plain_3_minus:hover
{
	background: #<?= $forground->bg['+8'] ?>;
}
.inv_plain_3
{
	background: #<?= $forground->bg['+4'] ?>;
	color: #<?= $forground->bg['-9'] ?>;
	padding: 2px;
	margin: 0em;
	-webkit-border-radius: 8px;
	border-radius: 8px;
 
}
.border_3
{
	border-bottom: #<?= $forground->bg['-1'] ?> 1px solid;
	 
}
.inv_plain_3_zebra
{
    border: 1px solid #<?= $forground->bg['+2'] ?>; 	
    background: #<?= $forground->bg['+6'] ?>;
	color: #<?= $forground->bg['-9'] ?>;
	padding: 0px;
	margin: 0.1em 0;
	-webkit-border-radius: 8px;
	border-radius: 8px;
        
}
.inv_plain_3_zebra:hover
{
	background: #<?= $forground->bg['+8'] ?>;
}
.half_zebra
{
	background: #<?= $forground->bg['+5'] ?>;
}
.base
{
	background: #<?= $base->bg['-2'] ?>;
	color: #<?= $base->bg['+9'] ?>;
	border: 1px solid #<?= $base->bg['-3'] ?>;
        text-align: center;
	padding: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}

.topbase
{
	font-weight: bold;
    font-size: 1.2em;
    padding: 0.5em;
	color: #<?= $base->bg['+9'] ?>;
	background: url() #<?= $base->bg['-1'] ?> fixed ;
	border: #<?= $base->bg['-3'] ?> 1px solid;
    text-align: center;
	margin: 0px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
 
}
.topbase a
{
	color: #<?= $base->bg['+10'] ?>;
}
.topbase a:hover
{
	text-decoration:none;
}
.grad
{
	background: #<?= $forground->bg['+4'] ?>;
	color: #<?= $forground->bg['-6'] ?>;
	background-image: url(buttongradient.php?bg2=<?= $forground->bg['-6'] ?>&bg=<?= $forground->bg['+10'] ?>&width=1&height=50);
	padding: 3px;
	margin: 0em;
	background-repeat: repeat-x;
	-webkit-border-radius: 15px;
	border-radius: 15px;
 
}
.grad a
{
	color: #<?= $base->bg['-8'] ?>;
}
.invgrad
{
	background: #<?= $base->bg['-3'] ?>;
	color: #<?= $base->bg['+8'] ?>;
	padding: 3px;
	margin: 0em;
	background-repeat: repeat-x;
	-webkit-border-radius: 10px;
	border-radius: 10px;
}
.invgrad a
{
	color: #<?= $base->bg['-9'] ?>;
}
.grad_header
{
	background: #<?= $base->bg['+3'] ?>; 
	width:760px;
	height:10px;
	background-repeat: repeat-x;
 
}
.glow
{
	line-height: 14px;
}
.glow:before {
  display: block;
  margin: 0 0 -2.12em 0.15em;
  padding: 0;
  color: #666666; 
}
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

.box
{
	border-right: #<?= $base->bg['-2'] ?> 1px solid;
	border-left: #<?= $base->bg['-2'] ?> 1px solid;
	border-bottom: #<?= $base->bg['-2'] ?> 1px solid;
	text-align:center;
	margin: 0;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
.nobottom
{
	border-right: #<?= $base->bg['-2'] ?> 1px solid;
	border-left: #<?= $base->bg['-2'] ?> 1px solid;
	border-top: #<?= $base->bg['-2'] ?> 1px solid;
	border-bottom: 0px;
}
.notopbottom
{
	border-right: #<?= $base->bg['-2'] ?> 1px solid;
	border-left: #<?= $base->bg['-2'] ?> 1px solid;
	border-top: 0px;
	border-bottom: 0px;
}
.button
{
	border-right:#<?= $base->bg['-2'] ?> 1px solid;
    border-top:#<?= $base->bg['-2'] ?> 1px solid;
    border-left:#<?= $base->bg['-2'] ?> 1px solid;
    border-bottom:#<?= $base->bg['-2'] ?> 1px solid;
    height: 2em;
	width: 5em;
    background:#<?= $base->bg['+2'] ?>;
    color:#<?= $forground->bg['-3'] ?>;
    font-weight: bold;
}
td
{
	border: none;text-align:<?echo get_s_align();?>;
}
th
{
	border-right: black 1px;
    background-position: 0% 0%;
    font-weight: bold;
    font-size: 1.1em;
    background-attachment: scroll;
    background-repeat: repeat;
    height: 25px;
    text-align: center
}
tr.smalltbl:hover
{
    background-color: #<?= $base->bg['-2'] ?>
}
tr.tbl:hover
{
    background-color: #<?= $base->bg['-2'] ?>
}
 
td.smalltbl
{
    font-size: 0.85em;
    text-align: center
}
tr.space
{
    height: 5px
}
.hr
{
	height:5px;
	border: none;
	background-color:transparent;
}
a.info
{
	position: relative;text-decoration: none;
 
}
a.info:hover
{
    background: transparent;
   	z-index: 100;
}
a.info span.info
{
    display: none
}
a.info:hover span.info
{
    background-color: #<?= $base->bg['+7'] ?>;
	color:#<?= $base->bg['-1'] ?>;
    border: #<?= $base->bg['+5'] ?> 1px dashed;
    display: block;
    font-size: 1.1em;
    <? echo get_s_align(); ?>: -3em;
    width: 13em;
    position: absolute;
    top: +50px;
    text-align: center;
	z-index: 9999;
	padding: 0.5em;
	text-decoration: none;
	<? if (isHeb()) echo "direction:rtl"; ?>
 
}
a.info:hover span table
{
	text-align: center;
	font-weight: bold
}
img
{
    border: 0px;
}
 
form
{
	margin-bottom: 0;
	z-index: 0;
}
 
.border1
{
    border-bottom: #<?= $base->bg['-7'] ?> 4px solid
}
.borderfull
{
	border:1px solid
}
.raincontaniner
{
    background-color: #<?= $base->bg['+3'] ?>;
	border: #<?= $forground->bg['+3'] ?> 1px solid;
    padding: 1px;
    display: inline;
    float: left;
    margin: 1px;
    color: #<?= $forground->bg['-3'] ?>;
    text-decoration: none
}
.ltr
{
direction:ltr
}
.small
{
    font-size: 0.8em
}
.verysmall
{
    font-size: 0.7em
}

@font-face { font-family: "brakim";
			src: url(http://www.02ws.com/fonts/ActionManShaded.eot); /* IE */
			 src: local("brakim"), url(http://www.02ws.com/fonts/ActionManShaded.ttf) format("truetype"); /* non-IE */}
@font-face { font-family: "barakkis2";
			 src: local("barakkis2"), url(http://www.02ws.com/fonts/barakkis2.ttf) format("truetype"); /* non-IE */}
@font-face {
    font-family: 'Alef';
    src: url('fonts/Alef-bold.eot');
    src: url('fonts/Alef-bold.eot?#iefix') format('embedded-opentype'),
         url('fonts/Alef-bold.woff') format('woff'),
         url('fonts/Alef-bold.ttf') format('truetype'),
         url('fonts/Alef-bold.svg#alefbold') format('svg');
    font-weight: bold;
    font-style: normal;

}
@font-face {
    font-family: 'Alef';
    src: url('fonts/Alef-regular.eot');
    src: url('fonts/Alef-regular.eot?#iefix') format('embedded-opentype'),
         url('fonts/Alef-regular.woff') format('woff'),
         url('fonts/Alef-regular.ttf') format('truetype'),
         url('fonts/Alef-regular.svg#alefregular') format('svg');
    font-weight: normal;
    font-style: normal;

}
 
.big
{
    font-weight: bold;
    font-size: 1.35em
}
.slogan
{
    font-weight: normal;
    font-size: 1.6em;
		
 
}
.logo
{
	padding: 0.1em;
 
    font-size: 3.8em;
 
	font-family: Arial;
}

#slogan
{
  font-weight: bold;
  float:<? echo get_s_align(); ?>;
  margin:0 0.5em;
  color: #<?= $base->bg['0'] ?>;

}
.high
{
	color: #ff0000;
}
div.high
{
    color: #ffffff;
    background-color: #ff0000;
}
.low
{
	color:#0066cc;
}
div.low
{
    color: #ffffff;
	background-color:#0066cc;
}
.less
{
    color: #9f9b00
}
.more
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
div.sigweather
{
	width:100%;
	margin:0;
	padding:0.1em 0em 0.1em 0em;
}
ul.list
{
	margin:0em 1em;
	padding:0em 0.5em;
    text-align:<? echo get_s_align(); ?>
}
ul.list li
{
	padding:1em 0.8em;
	margin:0.1em 0;
	clear:both;
    width:96%;
    float:<? echo get_s_align(); ?>
}
ul.squized li
{
	padding:0.3em;
}

#changelang
{
	float:<?=get_inv_s_align()?>;margin: 0.3em 1em
}
#menu a:hover
{
	display:block;height:100%;color:#<?= $base->bg['-10'] ?>;text-decoration:none;
}
.nav .il_category
{
	width:7.5em
}
.nav .il_image
{
   float:<?=get_inv_s_align()?>;padding: 0.9em 0.8em 0.5em;
   border-radius: 8px 8px 0 0;
   -webkit-border-radius: 8px 8px 0 0;
   border:none
}
.nav
{
	list-style: none;
	margin:0 1em;padding:0;
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
.param li
{
	padding:0;border:none;
}
.nav li a
{
	display:block;height:100%
}
.param li a
{
	display:inline
}
.nav .il_first
{
	border-<?=get_s_align()?>: 0px;
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
 
.nav ul ul li{ border-width:1px 1px 0 1px;}
 
.nav ul ul li:last-child{border-bottom:1px solid #ccc;} 
 
.nav li ul { /* second-level lists */
 
	display: none;
	position: absolute;
	top:  2.5em;
	<?echo get_s_align();?>: 0;
	background-color:#<?= $base->bg['-1'] ?>;
	color:#<?= $base->bg['+9'] ?>;
	border-right: #<?= $base->bg['0'] ?> 1px solid;
	border-left: #<?= $base->bg['0'] ?> 1px solid;
	border-bottom: #<?= $base->bg['0'] ?> 1px solid;
	border-radius: 8px 0 8px 8px;
	-webkit-border-radius: 8px 0 8px 8px;
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
#graphnav{
    padding:0;margin:0;border:0
}
#graphnav.nav li
{
    border:0;margin:0 0.1em
}
#menu , #history_menu
{
	clear:both;display:block;height:40px;margin:0 auto;padding: 0;
	text-align: <?=get_s_align()?>;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
 

#history_menu a
{
	display:inline ;
}
#graphmain{
    clear:both;width:100%;float:<?echo get_s_align();?>;margin:0 auto;padding:0
}
 
#change_style
{
	border:none; padding:0.6em 0.5em
}
#search_box
{
	border:none;float:<?=get_inv_s_align()?>;<? if (isHeb()) echo "direction:rtl"; ?>
}
#headerwrapper
{
	width:100%;
	margin:0 auto;
}
#header
{
	position: relative;  
	height:150px;
	margin:0 auto;
	padding: 0;
	clear: both;
	border-radius: 15px;
	-webkit-border-radius: 15px;
	border-radius: 15px;
	border: 0;
	text-align:<? if (isHeb()) echo "right"; else echo "left" ;?>
}
 
#header .background
{
   width:100%;
   height:150px;
   background: url() 0% 80% no-repeat;
   filter: alpha(opacity=40);
   filter: progid:DXImageTransform.Microsoft.Alpha(opacity=40);
   opacity:0.4;
   -moz-opacity: 0.40; 
   zoom: 1;
   position: absolute;  /* position on top of the background div*/
   left: 0; 
   top: 0
 
}
#header .background *
{
   visibility: hidden;  /* hide the faded text*/
}
#header .foreground
{
   width:100%;
   position: relative;  
}
#header a:hover
{
	text-decoration: underline;
}
#moon
{
	border:0;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#moon div
{
	padding: 0em 0.7em;
}
#sun div
{
	padding: 0em 0.7em;
}
#moonriseset
{
	text-align:center;float:<?=get_s_align()?>;margin:0 0.5em
}
#moonriseset div
{
	float:<?=get_s_align()?>;display:inline-block;padding:0.1em
}
#moonimage
{
	float:<?=get_s_align()?>;margin:0 0 0.5em 0
}
 
#website_title
{
	width:96%;height:88px;float:<?=get_s_align()?>;padding:0.5em 1.5em 1em;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#website_title a:hover
{
    text-decoration: none;
}
#website_title .nav
{
	margin: 1.5em 0px;
}
#top_table
{
	clear:both;padding:0;margin:0 auto;text-align:center;z-index: 1000;
}
 
#radarTab, #satelliteLink
{

    margin: 0.2em 0;
    width: 5.5em;
    float:<?=get_s_align()?>
}
#statusline
{
	color:#<?= $forground->bg['-8'] ?>;
	padding:0.4em 0;font-weight: bold;
    border-radius: 8px;
    -webkit-border-radius: 8px;
	width:auto;cursor:pointer
}
.inparamdiv
{
	width:100%;
	text-align:center;
	padding:0.5em 0 0.5em 0;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
.paramtitle
{
	padding:0em 0em 0.2em 0em;
}
#paramsdiv
{
	padding:0;margin:0;width:100%;float:<?=get_s_align()?>;
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
#latesttemp
{
	
 text-align:center;width:170px;border-bottom:none;
 
}
#tempdiv
{
	height:100%;float:<?=get_s_align()?>;width:auto;padding: 0.2em 1em;
}
#temptable
{
	width:auto
}
#templabel
{
	padding:0.2em 0.2em 2px 0.2em;float:<?=get_s_align()?>;
}
#templabel span.info
{
	<?=get_inv_s_align()?>:-6em
}
#tempdivvalue
{
	float:<?=get_s_align()?>;
	padding:0em 0.1em;
	margin:0;
	
}
#tempdivvalue span span.info
{
	left:0em;z-index:9999;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#latesthumidity span span.info
{
	left:-9em;
}
#latestpressure
{
	width:160px;border-bottom:none;
}
#latestpressure span.info
{
	width:16em;left:-7em;<? if (isHeb()) echo "direction:rtl"; ?>
}
#pressure_value
{
	
}
#latestwind
{
	padding:0.2em 0;width:155px;border-bottom:none;
}
#latestrain
{
	width:140px;border-bottom:none;
}
#latestuv, #latestradiation
{
	width:145px;border-bottom:none;
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
#windvalue
{
	float:left;padding:0 0.5em;margin: 0 auto;width:90%;direction:ltr
}
#windspeed
{
	float:left;width:60%;padding:0.4em 0 0 0
}
#windtrend
{
	float:left;width:13%;margin:0.1em
}
#winddir
{
	float:left;width:25%
}
#windtrend span.info
{
	left:-9em
}
#temptrends, #humtrends, #bartrends, #windtrends, #raintrends, #radiationtrends, #uvtrends
{
border-top:none; margin:0; padding:0;
}
#rainratevalue
{
	<? if (isHeb()) echo "direction:rtl"; else echo "direction:ltr";?>
}
#rainratevalue span.info
{
	
}
#closetrends
{
width:20px;
position:absolute;<?echo get_s_align();?>:-25px;top:70px
}
#trends tr.trendsvalues
{
	height:3em;text-align:center
}
#trends tr.trendsvalues td
{
 text-align:center
}
#trends tr.trendstitles
{
	height:1em;border:1px;text-align:center
}
#trends table
{
	width:100%
}
#error_update
{
	width:100%;margin:0 auto
}
#imagedisplay
{
	float:left;padding:1em 1em 0 1em
}
.report
{
	padding:1em
}
#reportdiv pre
{
font-size:0.85em;
}
#iframemain
{
}
#footerads
{
	margin:0 1.2em;
}
#footerads ul.list
{
	padding:0;margin:0.1em 0.2em
}
#footerads ul.list  li
{
	padding:1.2em 0.5em;margin:0.1em 0;
	<? if (isHeb()) echo "direction:rtl"; ?>;
}

#sigweather_list ul.list  li
{
	padding:0.3em 0.5em;margin:0.1em 0;
}

#tohomepage
{
	text-align:center;margin:0 auto;padding:0;width:32%;float:<?echo get_s_align();?>
}
#home
{
	width: 98%;
	padding:7em 0;
	margin:0 auto;float:<?echo get_s_align();?>
 
}
#googlemainads
{
	float:<?echo get_s_align();?>;padding:1.5em 0.5em;margin:0 8em;
}
#footergooglead
{
	padding: 1em 0.9em 0;width:330px;height:340px
}
#footermysmenu
{
	width:320px;height:340px
}
#footerlinksmenu
{
	width:320px;height:340px
}
#wrapperfooter
{
	width:100%;
}
#footermenu
{
	clear:both;position:relative;z-index:10;border-top:#<?= $forground->bg['+7'] ?> 1px solid;margin:0 auto;width:80%
}
#footermenu ul.list  li 
{
	padding:0.2em;margin:0;
	<? if (isHeb()) echo "direction:rtl"; ?>;
}
#footermenu ul.list  li a, #footerads ul.list  li a
{
	
}
.unitfootermenu
{
	float:<?echo get_s_align();?>;width:30.5%;margin:0 auto;height:340px;padding: 1em 0.3em 0px
}
#nowfootermenu
{
	width:29%;
}
#generalfootermenu
{
	float:<?echo get_s_align();?>;margin:0 auto;width:320px;height:340px
}
#myfootermenu
{
	float:<?echo get_s_align();?>;width:100%;margin:0 auto;
}
#webringdesc
{
	float:<?echo get_s_align();?>;padding:0.1em 1.2em;
}
#webringdesc div
{
	width:100%;text-align:center;border:none;padding:0.1em 1.2em
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#webringdesc div 
{
	<? if (isHeb()) echo "text-align:right"; ?>
}
.spacer
{
	padding:0 1em 0 1em;
	width:75%;
	clear:both;
	height:15px;
	margin:0 auto
}
.container pre
{
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#for_title
{
	clear:both;
	padding: 0 0.1em;
	float:<?echo get_s_align();?>;
	border-radius: 5px;
	-webkit-border-radius: 5px
	border-radius: 5px;
}
#for_title a:hover
{
  text-decoration:none;
}
#for_title_title
{
	float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>
}
#for_title_links
{
	text-align:<?echo get_s_align();?>;
}
#forecastnextdays_title, #forecast24h_title
{
	padding: 0.2em 0.6em;margin-<?echo get_inv_s_align();?>:0.2em;margin-bottom:0;border-bottom:0 none;border-radius:8px 8px 0 0;
}
.title_selected
{
	pointer-events:none;
}
.title_not_selected
{
	opacity:0.3;
	filter: alpha(opacity=30);
}
.title_not_selected:hover
{
	opacity:1;
	filter: alpha(opacity=100);
}
#sigweather_slider
{
	/*background-image: url(buttongradient.php?bg2=<?= $forground->bg['+1'] ?>&bg=<?= $forground->bg['+6'] ?>&width=1&height=300);*/
	clear:both;
	width:100%;
	margin:0 auto;
	position:relative;
	padding:0.2em 0em;
	text-align:<?echo get_s_align();?>;
	<? if (isHeb()) echo "direction:rtl"; ?>
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
	width:100%;height:470px;
}
#forecastnextdays
{
	padding:0em;width:100%;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#forecastnextdays table
{	
	/*background-image: url(buttongradient.php?bg2=<?= $forground->bg['+1'] ?>&bg=<?= $forground->bg['+6'] ?>&width=1&height=400);*/
	border-spacing: 0;
	padding:0.1em 0.2em;
	width:100%;
	height:50px;
	clear:both;
	text-align:<?echo get_s_align();?>;
	border-top:0 none;
	<? if (isHeb()) echo "direction:rtl"; else echo "direction:ltr";?>
}
#forecastnextdays table tr:hover
{
	background: #<?= $forground->bg['+10'] ?>;
}
#forecastnextdays table td.low, #forecastnextdays table td.high
{
	padding:0 0.2em;
	text-align:center;
}
.forecastdate
{
	text-align:<?echo get_s_align();?>
}
.forecasttemp
{
	text-align:center;direction:ltr;font-weight:bold;
}
.forecastdesc
{
	padding:0 0.4em 0 0.4em;
}
.forecastdesc a
{
	border-bottom: 1px dotted #<?= $forground->bg['-5'] ?>;
}
.forecastdesc a:hover 
{
     border-bottom: none;
}
#hourtempforecast
{
	clear:both;float:<?echo get_s_align();?>;margin:0.2em 1em 0.3em;<? if (isHeb()) echo "direction:rtl"; ?>
}
#forecasthours ul li
{
	padding:0.1em 0.3em
}
#timeSwithcer
{
	font-size: 10px;
}
#googleadforecast
{
	float:<?echo get_s_align();?>;padding:1.2em 0.2em 0em 0.2em;width:100px
}
#nextdays
{
	/*background-image: url(buttongradient.php?bg2=<?= $forground->bg['+1'] ?>&bg=<?= $forground->bg['+7'] ?>&width=1&height=400);*/
	text-align:<?echo get_s_align();?>;
	float:<?echo get_s_align();?>;
	clear:both;
	margin:0 auto;
	padding:0em 1em ;width:97%;
 
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#mainCol
{
	padding:0.5em 0em;
	margin:0 auto;
	width:100%;
	border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
}
#main_table
{
	position:relative;clear:both;
	padding:0;margin:0 auto;
	text-align:center;
	z-index:10;
}
#waiting
{
 
	width:180px;
	position: absolute;
	top:300px;
	left:280px;
	padding:3em;
	text-align:center;
	z-index:1000
}
 
#forecast
{
	clear:both;
	width:68%;
	float:<?echo get_s_align();?>;
	padding:0;
	text-align:<?echo get_s_align();?>
}
#side_bar
{
	width:32%;
}
#hometable_ad
{
	margin:0;padding:0.5em 2em;clear:both;
	<? if (isHeb()) echo "direction:rtl"; ?>
}

#sigweather
{
	width:35%;
	margin:0 auto;
	padding:0em;
	<? if (isHeb()) echo "direction:rtl"; ?>;
	float:<?echo get_inv_s_align();?>
 
}
#sigweather_cycle
{
	width:100%;
	height:220px;
	padding:0;margin:0;
	float:<?echo get_s_align();?>;
}
#sigweather_cycle div
{
	padding:0;
}
#sigweather_cycle div.sigweather
{
	border: #<?= $forground->bg['-1'] ?> 0px solid;
}
#sigweather_cycle img.main_img
{
	margin:0;
	vertical-align: bottom;
	width:100%;
	height:220px;
}

#slider
{
	float:<?echo get_s_align();?>;
	width:81.5%;
	border:#<?= $forground->bg['0'] ?> 1px solid;
	border-top-<?=get_inv_s_align()?>-radius:5px;
    border-bottom-<?=get_inv_s_align()?>-radius:5px;
   position: relative;
   border-<?echo get_s_align();?>:none;
 
}
#sliderspacer
{
	float:<?echo get_s_align();?>;width:2%
}
#sliderselector
{
	float:<?echo get_s_align();?>;
	margin:0em;
	padding:0;
	<?echo get_s_align();?>:2%;
	z-index:10;
	top:0px;
	width:15%;
	position:relative;
	height:220px;
	border:#<?= $forground->bg['0'] ?> 1px solid;
	border-top-<?=get_s_align()?>-radius:5px;
    border-bottom-<?=get_s_align()?>-radius:5px;
	border-<?echo get_inv_s_align();?>:none;
}
#sliderselector li
{
	float: <?echo get_s_align();?>;
	width:100%;
	height:20%;
	text-align: <?=get_s_align()?>;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#sliderselector li div
{
	height:100%;
}
#sliderselector a:hover
{
	background: #<?= $forground->bg['+9'] ?>;
	opacity:1;
	filter: alpha(opacity=100);
	text-decoration:none;
}
#sliderselector a
{
	display:block;
	background:#<?= $forground->bg['+9'] ?>;
	color: #<?= $forground->bg['-10'] ?>;
	background-image: url(buttongradient.php?bg2=<?= $forground->bg['+3'] ?>&bg=<?= $forground->bg['+10'] ?>&width=1&height=60);
	opacity:0.25;
	filter: alpha(opacity=25);
	height: 100%;
	font-size: 1.1em;
    padding:0em 0.5em;
    border-top-<?=get_s_align()?>-radius:5px;
    border-bottom-<?=get_s_align()?>-radius:5px;
}
#sliderselector a.activeSlide
{
	background:#<?= $forground->bg['+9'] ?>;
	color: #<?= $forground->bg['-10'] ?>;
	background-image: url(buttongradient.php?bg2=<?= $forground->bg['+3'] ?>&bg=<?= $forground->bg['+10'] ?>&width=1&height=60);
	opacity:1;
	filter: alpha(opacity=100);
   	text-decoration: none;
	border:0;
}
#sliderselectoroverlay
{
	opacity: 0.3;filter:alpha(opacity=30);background-color: #fff;height:13%;<?echo get_inv_s_align();?>:0;z-index: 1000;padding:0;position:absolute;top:100%;width:100%
}
#slider_ad
{
	margin-<?echo get_s_align();?>:0.5em;margin-top: 4.5em;
	
}
#webcam_list
{
	width:100%;
	height:70px;
}
#sigweather_list
{
	margin: 0.5em 0px 0.5em;
	padding:0.2em 1em;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#sigweather_list a
{
	font-weight:normal
}
#sigweather_list ul
{
	/*background-image: url(buttongradient.php?bg2=<?= $forground->bg['+2'] ?>&bg=<?= $forground->bg['+7'] ?>&width=1&height=400);*/
	float:<?echo get_s_align();?>;margin: 0px 0px 1em 0em;
	width:46%
}
#sigweather_list li
{
	margin:0.1em 0;
}
div.background
{
	border:none;
	position: relative;
	width:100%;
	height:100%
}
div.background img
{
	margin:0;
	vertical-align: bottom;
 
}
 
div.title
{
  position: absolute;
  width: 80%;
  top: 80%;
  height: 20%;
  color: #fff;
  text-align: <?=get_s_align()?>;
}
div.titlemoreinfo
{
  position: absolute;
  width: 48%;
  top: 90%;
  color: #fff;
  text-align: <?=get_inv_s_align()?>;
}
img.arrow
{
	width:15px;
	height:15px;
}
div.title #extrainfo img.arrow, #sigweather_list li img.arrow
{
	width:23px;
	height:23px;
}
#extrainfo
{
	font-size:1em;
}
div.title a
{
	color: #<?=$forground->bg['+8']?>;
	padding:0 1em 0 1em;
	display:block;
	font-size:1.2em;
	text-shadow:0 0 0.2em #<?=$forground->bg['-9']?>, 0 0 0.2em #<?=$forground->bg['-9']?>, 0 0 0.2em #<?=$forground->bg['-9']?>;
	filter: glow(color=black,strength=5);
}
div.overlay {
  background-color: #<?= $forground->bg['+9'] ?>;
  position: absolute;
  width: 80%;
  height: 20%;
  top: 80%;
  opacity: 0.15;
  filter:alpha(opacity=15);
  border-top-<?=get_inv_s_align()?>-radius:5px;
  border-bottom-<?=get_inv_s_align()?>-radius:5px;
}
#mobileredirect
{
	margin:0 auto;padding:1em 0;text-align:<?=get_inv_s_align()?>;<? if (isHeb()) echo "direction:rtl"; ?>
}
#rainaudio{
  position: absolute;
  width: 35%;
  height: 60%;
  top: 20%;<?=get_inv_s_align()?>:0%;z-index:100;
}
div.belowb
{
	display:block;
	clear:both;
	width:auto;
	padding:0.3em 1em 0.075em 1em;
	margin:0em 0.5em 0em 0.5em;
}
div.moreinfo
{
	display:block;
	clear:both;
	width:auto;
	padding:0 1.8em 0 1.8em;
	margin:0.3em 1.5em 0.7em 1.5em;
}
#airqtitle
{
	padding:0.5em 0
}
#airqdisplayed
{
	padding:0.5em;font-weight:bold;
}
#airqli
{
 
}
#dustitle
{
 
}
#dustdisplayed
{
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#headerdatatoggler
{
	height:100%;
	padding:0em;
	margin:1.1em 0.1em;
	text-align:<?=get_s_align()?>;
	float:<?=get_s_align()?>;
	<? if (isHeb()) echo "direction:rtl"; ?>
}
#tempunitconversion
{
	margin:0em 0em 0em 0em;
	float:<?echo get_inv_s_align();?>;
}
#windstatus, #tempdiv_moreinfo, #rainstatus
{
	text-align:<?echo get_s_align();?>;float:<?echo get_s_align();?>;padding:0.5em 0.05em
}
#windy
{
          float:<?echo get_s_align();?>;width:auto;margin:0 0.2em
}
#coldmeter
{
          float:<?echo get_s_align();?>
}
#current_feeling_link
{
	font-size:100%
}
#itfeels_windchill, #itfeels_heatidx
{
	float:<?echo get_s_align();?>;margin: 0 0.2em
}
#tempdiv_moreinfo
{
}
#latesthumidity
{
	width:140px;border-bottom:none;
}
#latesthumidity .inparamdiv
{
	<? if (isHeb()) echo "direction:rtl";?>
}
.tempvalue
{
    font-weight: bold;
    font-size: 1.65em;direction:ltr
}
#tempdivvalue a:hover
{
text-decoration:none
}
#laundryidx{
    position: absolute;
    margin-top: -120px;
    margin-right: 120px;
}
#whatelse
{
	border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	padding:0 0.5em;
	<? if (isHeb()) echo "direction:rtl"; ?>;
        text-align:<?echo get_s_align();?>
}
.side-toolbar
{
	top: 450px;
    <? if (isHeb()) echo "direction:rtl"; ?>;
    position: fixed;
	z-index:0;
	padding:0.2em;
	width:120px;
	<?echo get_s_align();?>:0;
	text-align:<?echo get_s_align();?>;

	
}
#first
{
	display: block
}
#second, #third, #forth, #fifth, #sixst, #seventh
{
	display:none
}
 #second div#messagescorner
{
	padding:1em 2em;
}
#extra_notice
{
	width:30%
}
 
#relatedgraphs
{
	padding:0.5em 0.2em;
	margin:0em 2em;	
}
#additionalgraphs
{
	margin:0.5em 0 0 0;
}
#moregraphs
{
	padding:0em 0.2em;
	margin:0em 5.5em;	
}
#relatedgraphs li, #moregraphs li
{
	list-style-type: circle;
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
#notloggedin div
{
	
}
.loading
{
    margin:1.5em
}
#hello, #nice_name
{
 margin: 1em
}
.chatmobile
{
  
}
#creatnewmsg 
{
	padding:0.5em;width:10.5em;float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>;margin:0.5em 0em;cursor:pointer
}
#login, .register, #forgotpass
{
       padding:0.2em;width:auto;float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>;margin:0.2em;cursor:pointer
}
#updateprofile, #signout
{
  padding:0.5em;margin:0.5em 0em;cursor:pointer;float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>; width: 110px;
}
.chatthreadcell
{
	clear:both;
	float:<?echo get_s_align();?>;
	text-align:<?echo get_s_align();?>;
	width:100%;
	height:auto
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
.chatreply
{
	margin:0.4em;text-align:<?echo get_s_align();?>;float:<?echo get_s_align();?>;width:10%
}
.chatdatereply
{
margin: 0em;
font-style: italic;
opacity: 0.5;
filter:alpha(opacity=50);
position:absolute;
<?echo get_s_align();?>:120px;
top:0;
}
.chataftersepreply
{
 margin: 0 0.1em;
 width: 100%;
 position: relative;
}
.chatnamereply
{
  margin: 0 0.1em
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
#chatcontainer
{
	width:100%;clear:both;margin:0;padding:0 0.5em 0 0.5em;
	float:<?echo get_s_align();?>
}
#chat_entire_div
{
	border-top:1px dashed;clear:both;margin:0 auto;padding:1em 0;width:100%;
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
#chat_title a
{
 
}
#chat_explain
{
	float:<?echo get_s_align();?>;
	width:80%;
	text-align:<?echo get_s_align();?>;
	padding:1em;
}
#chat_filter
{
	float:<?echo get_inv_s_align();?>;
	padding:1.5em 0.9em;width:auto;
}
#chat_search
{
	float:<?echo get_s_align();?>;
	padding:0.5em 1.8em 0em 1.8em
}
#inputFieldsDiv
{
	width:99%;
	float:<?echo get_s_align();?>;
	clear:both;
	padding:1em 0.5em 0 0
}
#msgDetails
{
	clear:both;
	text-align:<?echo get_s_align();?>;
	padding:0.5em 1em 0em 1em;width:97%;float:<?echo get_s_align();?>;
 
}
#msgDetails a
{
	text-decoration: underline;
}
#msgDetails div:hover
{
	background-color:#<?= $forground->bg['+1'] ?>;color:#<?= $forground->bg['-6'] ?>;
}
#msgDetails div div input[type="button"]
{
	padding:5px 18px 5px 5px;
	
}
#new_post_btn {
    background-image: url("../img/new_post.png");
    background-position: left bottom;
    background-repeat: no-repeat;
    color: #FFFFFF;
    font-family: nextexitfotlight;
    font-size: 23px;
    height: 51px;
    line-height: 20px;
    margin-right: 20px;
    padding-bottom: 50px;
    text-align: center;
    width: 51px;
}
#new_post_btn:hover {
    background-position:right bottom;
}
#new_post, #replyInputsDiv {
    margin-top:20px;
    margin-bottom:5px;
    padding-bottom:5px;
    visibility:hidden;
    
}

#replyInputsDiv{
    position:relative;
    margin-top:50px;
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

#subject_icon {
     height:38px;
     background-repeat:no-repeat;
     width:37px;
     margin-<?=get_inv_s_align()?>:50px;
     margin-top:30px;
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
    margin-top: 40px;
}

#subject_right {
     background-image:url("../img/subject_right.png");
     margin-<?=get_s_align()?>:52px;
    margin-top: 50px;
    margin-bottom: 20px;
}


#new_post_okay, #new_post_cancel {
    background-color:#C0CE61;
    color:#fff;
    width:60px;
    border-radius:5px;
    display:inline-block;
    margin-top:20px;
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
.span9 
{
width:770px;
}
.white_box {
    background:rgba(255, 255, 255, 0.7);
    <? if (isHeb()) echo "direction:rtl;"; ?>
    padding-bottom:20px;
    -webkit-border-radius: 5px;
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
.spriteB.up { background-position: 0px 0px; width: 12px; height: 18px;  } 
.spriteB.down { background-position: 0px -28px; width: 12px; height: 18px;  } 
.spriteB.plus {  background-position: 0 -32px;background-size: 98% auto;height: 20px;width: 20px;  } 
.spriteB.adlink { background-position: 0px -98px; width: 32px; height: 32px;  } 
.spriteB.star { background-position: 0px -140px; width: 14px; height: 13px;  } 
.spriteB.eng { background-position: 0px -163px; width: 28px; height: 17px;  } 
.spriteB.israelflag { background-position: 0px -190px; width: 19px; height: 14px;  }  
.white_box2 {
    background:rgba(255, 255, 255, 0.5);
    <? if (isHeb()) echo "direction:rtl;"; ?>
    padding-bottom:20px;
    position:relative;
    -webkit-box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    -moz-box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    padding-bottom:10px;
    height:auto;
}
.pivotpointer{
clear:both
}
.white_box2 p {
    padding-right:13px;
    padding-left:16px;
    margin-bottom:5px;
    font-size:14px;
    line-height:18px;
}

.white_box2 a {
    text-decoration:underline;
    color:#3D718E;
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
#chat_name
{
        clear:both;
	float:<?echo get_s_align();?>;
	padding:0.5em 1em 0em 0.5em
}
#chat_body 
{
	float:<?echo get_s_align();?>;
	padding:0.2em 1em 1em ;width:75%
}
#chat_mood
{
	width:35px;
	float:<?echo get_s_align();?>;
	
}
#moods_dialog .moodbox
{
	margin:1em;
}
#chat_href_plugin
{
	float:<?echo get_s_align();?>;
	
}
#chat_italic
{
	float:<?echo get_s_align();?>;
	padding:0em 0.5em;
}
#chat_button
{
	float:<?echo get_s_align();?>;
	padding:0.1em 0.8em
}
#chat_button input[type="button"]
{
	padding:0.8em 0.5em;
	font-weight: bold;
}
#chat_links
{
	float:<?echo get_s_align();?>;
	text-align:<?echo get_s_align();?>;width:99%;
 
 
}
#chat_links div
{	
	float:<?echo get_s_align();?>;
	padding:0.5em 1em
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
.top {
	top: 0;
	left: 0;
}
.bottom {
	bottom: 0;
    left: 0;
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
/*
    ColorBox Core Style
    The following rules are the styles that are consistant between themes.
    Avoid changing this area to maintain compatability with future versions of ColorBox.
*/
#colorbox, #cboxOverlay, #cboxWrapper{position:absolute; top:0; left:0; z-index:9999; overflow:hidden;background: white;}
#cboxOverlay{position:fixed; width:100%; height:100%;}
#cboxMiddleLeft, #cboxBottomLeft{clear:left;}
#cboxContent{position:relative; overflow:visible;}
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
#cboxOverlay{background:#fff;}
 
#colorbox{}
    #cboxContent{margin-top:32px;}
        #cboxContent{padding:1px;}
        #cboxLoadingGraphic{background:url(images/loading.gif) center center no-repeat;}
        #cboxLoadingOverlay{background:#eee;}
        #cboxTitle{position:absolute; top:-22px; <?echo get_s_align();?>:1em; color:#000; <? if (isHeb()) echo "direction:rtl"; ?> }
        #cboxCurrent{position:absolute; top:-22px; right:205px; text-indent:-9999px;}
        #cboxSlideshow, #cboxPrevious, #cboxNext, #cboxClose{text-indent:-9999px; width:20px; height:20px; position:absolute; top:-20px; background:url(images/controls.png) 0 0 no-repeat;}
        #cboxPrevious{background-position:-78px 0px; <?echo get_inv_s_align();?>:3em;}
        #cboxPrevious.hover{background-position:-78px -25px;}
        #cboxNext{background-position:-50px 0px; <?echo get_inv_s_align();?>:4.2em;}
        #cboxNext.hover{background-position:-50px -25px;}
        #cboxClose{background: url('images/sprite.png') no-repeat top left;background-position: 0 -52px;background-size: 100% auto;height: 20px;width: 20px;}
        #cboxClose.hover{}
        .cboxSlideshow_on #cboxPrevious, .cboxSlideshow_off #cboxPrevious{right:66px;}
        .cboxSlideshow_on #cboxSlideshow{background-position:-75px -25px; right:44px;}
        .cboxSlideshow_on #cboxSlideshow.hover{background-position:-100px -25px;}
        .cboxSlideshow_off #cboxSlideshow{background-position:-100px 0px; right:44px;}
        .cboxSlideshow_off #cboxSlideshow.hover{background-position:-75px -25px;}


.twtr-bd{
text-align:right
}

#coldmeter a{
display:inline-block
}
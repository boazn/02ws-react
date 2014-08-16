<?php
add_action ( 'get_footer', 'qbx_lightbox_create');//, [priority], [accepted_args] );
wp_enqueue_script('jquery');
function qbx_lightbox_create()
{	$page_option=get_option('xyz_qbx_page_option');	
	if($page_option==3)
	{
		return false;
	}
	echo qbx_lightbox_display();
}
function qbx_lightbox_display()
{
	$html=get_option('xyz_qbx_html');	
	$width=get_option('xyz_qbx_width');
	$height=get_option('xyz_qbx_height');
	$delay=get_option('xyz_qbx_delay');
	$page_count=get_option('xyz_qbx_page_count');
	if($page_count==0) $page_count=1;
	$mode=get_option('xyz_qbx_mode');
	$repeat_interval=get_option('xyz_qbx_repeat_interval');
	$repeat_interval_timing=get_option('xyz_qbx_repeat_interval_timing');
	if($repeat_interval_timing==1)
	{
		$repeat_interval=$repeat_interval*60;
	}
$z_index=get_option('xyz_qbx_z_index');
$corner_radius=get_option('xyz_qbx_corner_radius');
$height_dim=get_option('xyz_qbx_height_dim');
$width_dim=get_option('xyz_qbx_width_dim');
$border_color=get_option('xyz_qbx_border_color');
$bg_color=get_option('xyz_qbx_bg_color');
$border_width=get_option('xyz_qbx_border_width');
$iframe_option=get_option('xyz_qbx_iframe');
 $position_option=get_option("xyz_qbx_display_position");
 $qbx_title=get_option("xyz_qbx_title");
 $qbx_title_color=get_option("xyz_qbx_title_color");
$qbx_font=get_option("xyz_qbx_font");
$position_predefined=get_option('xyz_qbx_position_predefined');
	$ttlen=strlen($qbx_title);
	$ttlnarray="";
	for($i=0;$i<$ttlen;$i++)
	{
	$ttlnarray=$ttlnarray.$qbx_title[$i]."<br>";
}
global $wpdb;

ob_flush();
ob_start();
	?>
	<style type="text/css">
.qbx_content {
display: none;
position: fixed;
_position: fixed;
width: <?php echo $width; echo $width_dim;?>;
height: <?php echo $height; echo $height_dim;?>;
padding: 0;
margin:0;
border: <?php echo $border_width; ?>px solid <?php echo $border_color;?>;
background-color: <?php echo $bg_color;?>;
z-index:<?php echo $z_index+1;?>;
overflow: hidden;
border-radius:<?php echo $corner_radius;?>px
}
.qbx_iframe{
width:100%;
height:100%;
border:0;
}
.qbx_trig
{
display: block;
		position: fixed;
		cursor:pointer;
		background-color: <?php echo $border_color;?>;
		font-size:<?php echo $qbx_font;?>px;
		padding:5px 10px;
		z-index:<?php echo $z_index;?>;
		float: right;
		color: <?php echo $qbx_title_color?>;		
}
</style>
<div id="qbx_light" class="qbx_content"><?php if(!isset($_COOKIE['_xyz_qbx_until'])) {?>

<!-- <div width="100%" height="20px" style="text-align:right;padding:0px;margin:0px;"><a href = "javascript:void(0)" onclick = "javascript:qbx_hide_lightbox()">CLOSE</a></div> -->
<?php if($iframe_option==1) { ?><iframe  src="<?php echo  plugins_url();?>/lightbox-pop/iframe.php?type=qbx" class="qbx_iframe" scrolling="no"></iframe><?php }else{  
echo do_shortcode($html);}
}?>
</div>
<?php  if(!isset($_COOKIE['_xyz_qbx_until'])) {?><div id="qbx_trig_div" class="qbx_trig" ><?php if($position_option==0 || $position_option==3) {echo $qbx_title;} else { echo $ttlnarray;} ?></div><?php }?>
<script type="text/javascript">
var hadjust;
var wiadjust;
var slidestart=<?php echo $position_option;?>;
var def_disp=<?php echo $position_predefined;?>;
var qbxwid=<?php echo $width; ?>;
var qbxwiddim="<?php echo $width_dim;?>";
var qbxhe=<?php echo $height; ?>;
var qbxhedim="<?php echo $height_dim;?>";
var qbxbordwidth=<?php echo $border_width;?>;
var screenheight=jQuery(window).height(); 
var screenwidth=jQuery(window).width(); 
var  widtr=document.getElementById('qbx_trig_div').offsetWidth;
var hetr=document.getElementById('qbx_trig_div').offsetHeight;
if(qbxhedim=="%")
{
	var hadnjust=(screenheight*qbxhe)/100;
	qbxhe=hadnjust-(2*qbxbordwidth);
	 document.getElementById("qbx_light").style.height=qbxhe+'px';
	 qbxhedim="px";
}
if(qbxwiddim=="%")
{
	var wiadnjust=(screenwidth*qbxwid)/100;
	qbxwid=wiadnjust-(2*qbxbordwidth);
		document.getElementById("qbx_light").style.width=qbxwid+'px';
		qbxwiddim="px";
}
if(qbxhedim=="px")
{
hadjust=(screenheight-qbxhe)/2;
}
else
{
	hadjust=(100-qbxhe)/2;
}
if(qbxwiddim=="px")
{		
wiadjust=(screenwidth-qbxwid)/2;
}
else
{
	wiadjust=(100-qbxwid)/2;
}
	if(slidestart==0)
	{
		document.getElementById('qbx_trig_div').style.top='0px';
if(def_disp==1)
{
var calcu=((qbxwid-widtr)/2)+qbxbordwidth;
document.getElementById('qbx_trig_div').style.left=calcu+'px';
	document.getElementById("qbx_light").style.top="0px";
	document.getElementById("qbx_light").style.left="0px";	
}
if(def_disp==8)
{
var calcu=((screenwidth-widtr)/2)+qbxbordwidth;
document.getElementById('qbx_trig_div').style.left=calcu+'px';
document.getElementById("qbx_light").style.top="0px";
document.getElementById("qbx_light").style.left=wiadjust+qbxwiddim;
}
if(def_disp==7)
{	var calcu=((qbxwid-widtr)/2)+qbxbordwidth;	
	document.getElementById('qbx_trig_div').style.right=calcu+'px';	
	document.getElementById("qbx_light").style.top="0px";
	document.getElementById("qbx_light").style.right="0px";	
}
	}
if(slidestart==1)
{	
	document.getElementById('qbx_trig_div').style.left='0px';
	if(def_disp==1)
	{
	var calcu=((qbxhe-hetr)/2)+qbxbordwidth;
	document.getElementById('qbx_trig_div').style.top=calcu+'px';	
		document.getElementById("qbx_light").style.top="0px";
		document.getElementById("qbx_light").style.left="0px";	
	}
	if(def_disp==2)
	{
	var calcu=((screenheight-hetr)/2)+qbxbordwidth;
	document.getElementById('qbx_trig_div').style.top=calcu+'px';
		document.getElementById("qbx_light").style.top=hadjust+qbxhedim;
		document.getElementById("qbx_light").style.left="0px";
	}
	if(def_disp==3)
	{	
		var calcu=((qbxhe-hetr)/2)+qbxbordwidth;	
		document.getElementById('qbx_trig_div').style.bottom=calcu+'px';	
			document.getElementById("qbx_light").style.bottom="0px";
			document.getElementById("qbx_light").style.left="0px";	
	}		
}
if(slidestart==2)
{
	document.getElementById('qbx_trig_div').style.right='0px';
	if(def_disp==7)
	{
	var calcu=((qbxhe-hetr)/2)+qbxbordwidth;
	document.getElementById('qbx_trig_div').style.top=calcu+'px';	
		document.getElementById("qbx_light").style.top="0px";
		document.getElementById("qbx_light").style.right="0px";	

	}
	if(def_disp==6)
	{
	var calcu=((screenheight-hetr)/2)+qbxbordwidth;
	document.getElementById('qbx_trig_div').style.top=calcu+'px';
		document.getElementById("qbx_light").style.top=hadjust+qbxhedim;
		document.getElementById("qbx_light").style.right="0px";
	}
	if(def_disp==5)
	{
			var calcu=((qbxhe-hetr)/2)+qbxbordwidth;
		document.getElementById('qbx_trig_div').style.bottom=calcu+'px';
			document.getElementById("qbx_light").style.bottom="0px";
			document.getElementById("qbx_light").style.right="0px";	
	}		
}
if(slidestart==3)
{
	document.getElementById('qbx_trig_div').style.bottom='0px';
	if(def_disp==3)
	{
	var calcu=((qbxwid-widtr)/2)+qbxbordwidth;
	document.getElementById('qbx_trig_div').style.left=calcu+'px';
		document.getElementById("qbx_light").style.bottom="0px";
		document.getElementById("qbx_light").style.left="0px";
	}
	if(def_disp==4)
	{
	var calcu=((screenwidth-widtr)/2)+qbxbordwidth;
	document.getElementById('qbx_trig_div').style.left=calcu+'px';
	document.getElementById("qbx_light").style.bottom="0px";
	document.getElementById("qbx_light").style.left=wiadjust+qbxwiddim;	
	}
	if(def_disp==5)
	{		
		var calcu=((qbxwid-widtr)/2)+qbxbordwidth;		
		document.getElementById('qbx_trig_div').style.right=calcu+'px';		
		document.getElementById("qbx_light").style.bottom="0px";
		document.getElementById("qbx_light").style.right="0px";		
}
}
	var xyz_qbx_rendered=false;
var xyz_qbx_tracking_cookie_name="_xyz_qbx_until";
var xyz_qbx_pc_cookie_name="_xyz_qbx_pc";
var xyz_qbx_tracking_cookie_val=xyz_qbx_get_cookie(xyz_qbx_tracking_cookie_name);
var xyz_qbx_pc_cookie_val=xyz_qbx_get_cookie(xyz_qbx_pc_cookie_name);
var xyz_qbx_today = new Date();
if(xyz_qbx_pc_cookie_val==null)
xyz_qbx_pc_cookie_val = 1;
else
xyz_qbx_pc_cookie_val = (xyz_qbx_pc_cookie_val % <?php echo $page_count;?> ) +1;
expires_date = new Date( xyz_qbx_today.getTime() + (24 * 60 * 60 * 1000) );
document.cookie = xyz_qbx_pc_cookie_name + "=" + xyz_qbx_pc_cookie_val + ";expires=" + expires_date.toGMTString() + ";path=/";
function xyz_qbx_get_cookie( name )
{
var start = document.cookie.indexOf( name + "=" );
//alert(document.cookie);
var len = start + name.length + 1;
if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) )
{
return null;
}
if ( start == -1 ) return null;
var end = document.cookie.indexOf( ";", len );
if ( end == -1 ) end = document.cookie.length;
return unescape( document.cookie.substring( len, end ) );
}
function qbx_hide_lightbox()
{
document.getElementById("qbx_light").style.display="none";

	var widtr=document.getElementById('qbx_trig_div').offsetWidth;
	var hetr=document.getElementById('qbx_trig_div').offsetHeight;
	
if(slidestart==0)
{
	document.getElementById('qbx_trig_div').style.top='0px';

}
if(slidestart==1)
{
	document.getElementById('qbx_trig_div').style.left='0px';	
}
if(slidestart==2)
{	
	document.getElementById('qbx_trig_div').style.right='0px';		
}
if(slidestart==3)
{
	document.getElementById('qbx_trig_div').style.bottom='0px';
}
xyz_qbx_rendered=false;	
}
function qbx_show_lightbox()
{
//alert(qbx_tracking_cookie_val);
	def_disp=<?php echo $position_predefined;?>;	
if(xyz_qbx_tracking_cookie_val==1)
return;
if( "<?php echo $mode;?>" == "page_count_only"  || "<?php echo $mode;?>" == "both" )
{
if(xyz_qbx_pc_cookie_val != <?php echo $page_count;?>)
return;
}
document.getElementById("qbx_light").style.display="block";
var widtr=document.getElementById('qbx_trig_div').offsetWidth;
var hetr=document.getElementById('qbx_trig_div').offsetHeight;	
qbxwidtos=qbxwid+(2*qbxbordwidth);	
qbxhetos=qbxhe+(2*qbxbordwidth);	
if(slidestart==0)
{
if(def_disp==1)
{
var calcut=qbxhetos;
document.getElementById('qbx_trig_div').style.top=calcut+'px';
}
if(def_disp==8)
{
var calcut=qbxhetos;
document.getElementById('qbx_trig_div').style.top=calcut+'px';
}
if(def_disp==7)
{
var calcut=qbxhetos;
document.getElementById('qbx_trig_div').style.top=calcut+'px';
}
}
if(slidestart==1)
{
if(def_disp==1)
{
	var calcut=qbxwidtos;	
	document.getElementById('qbx_trig_div').style.left=calcut+'px';			
}
if(def_disp==2)
{
	var calcut=qbxwidtos;
	document.getElementById('qbx_trig_div').style.left=calcut+'px';
}
if(def_disp==3)
{	
var calcut=qbxwidtos;
document.getElementById('qbx_trig_div').style.left=calcut+'px';		
}	
}
if(slidestart==2)
{
if(def_disp==7)
{
var calcut=qbxwidtos;
document.getElementById('qbx_trig_div').style.right=calcut+'px';
}
if(def_disp==6)
{
var calcut=qbxwidtos;
document.getElementById('qbx_trig_div').style.right=calcut+'px';
}
if(def_disp==5)
{
	var calcut=qbxwidtos;
	var calcul=((qbxhetos-hetr)/2);
	document.getElementById('qbx_trig_div').style.right=calcut+'px';
	document.getElementById('qbx_trig_div').style.bottom=calcul+'px';	
}	
}
if(slidestart==3)
{	
if(def_disp==3)
{	var calcul=qbxhetos;		
	document.getElementById('qbx_trig_div').style.bottom=calcul+'px';
}
if(def_disp==4)
{
var calcul=qbxhetos;
	document.getElementById('qbx_trig_div').style.bottom=calcul+'px';
}
if(def_disp==5)
{
	var calcul=qbxhetos;	
	document.getElementById('qbx_trig_div').style.bottom=calcul+'px';	
}
}
//expires_date = new Date( xyz_qbx_today.getTime() + (24 * 60 * 60 * 1000) );
//alert(xyz_qbx_today.toGMTString());
	expires_date = new Date(xyz_qbx_today.getTime() + (<?php echo $repeat_interval;?> * 60 * 1000));
document.cookie = xyz_qbx_tracking_cookie_name + "=1;expires=" + expires_date.toGMTString() + ";path=/";
xyz_qbx_rendered=true;
}
function triggerback()
{	
	qbx_hide_lightbox()	;
}
function trigg()
{	
if("<?php echo $mode;?>" == "page_count_only")
qbx_show_lightbox();
else
setTimeout("qbx_show_lightbox()",<?php echo $delay*1000;?>);
}
trigelement='#qbx_trig_div';		
jQuery(trigelement).click(function () {
if(xyz_qbx_rendered==false )
{	
trigg();
}
else
{
	triggerback();
}		
	});
</script>
<?php 
$lbc=ob_get_contents();
ob_clean();
return  $lbc;
}
?>
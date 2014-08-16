<style>
	a.xyz_lbx_link:hover{text-decoration:underline;} 
	.xyz_lbx_link{text-decoration:none;} 
</style>

<?php 
if($_POST && isset($_POST['xyz_credit_link']))
{
	$xyz_tinymce=$_POST['xyz_tinymce'];
	$xyz_credit_link=$_POST['xyz_credit_link'];
	update_option('xyz_tinymce', $xyz_tinymce);
	update_option('xyz_credit_link', $xyz_credit_link);
	?>
<div class="system_notice_area_style1" id="system_notice_area">
	Settings updated successfully. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
	<?php 
}?>

<div style="width: 98%">

<div id="lightbox-pop-premium">

<div style="float: left;padding: 0 5px">
<h2 style="vertical-align: middle;"><a target="_blank" href="http://xyzscripts.com/wordpress-plugins/lightbox-pop/features">Fully Featured Lightbox Pop Premium</a> 
 - Just 29 USD 
</h2>
</div>
<div style="float: left;padding: 5px">
<a target="_blank" href="http://xyzscripts.com/members/product/purchase/XYZWPLB"><img src="<?php  echo plugins_url("lightbox-pop/images/orange_buynow.png"); ?>"></a>
</div>

 </div>
 
    <div style="clear:both"></div>

<?php 

if(get_option('xyz_credit_link')=="0"){
	?>
<div style="float:left;background-color: #FFECB3;border-radius:5px;padding: 0px 5px;border: 1px solid #E0AB1B" id="xyz_backlink_div">
	
	Please do a favour by enabling backlink to our site. <a id="xyz_lbx_backlink" style="cursor: pointer;" >Okay, Enable</a>.
<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#xyz_lbx_backlink').click(function() {
	
jQuery.ajax
	({
	type: "POST",
	url: "<?php echo plugins_url('lightbox-pop/admin/ajax-backlink.php') ?>",
	data: 'enable=1',
	cache: false,
	success: function(html)
	{	
		jQuery("#xyz_backlink_div").html('Thank you for enabling backlink !');
		jQuery("#xyz_backlink_div").css('background-color', '#D8E8DA');
		jQuery("#xyz_backlink_div").css('border', '1px solid #0F801C');
		
		jQuery("select[id=xyz_lbx_credit_link] option[value=lbx]").attr("selected", true);
		if(window.rcheck)
		{
			document.location.reload();
		}
	}
	});

});
});
</script>
</div>
	<?php 
}



?>

<style type="text/css">
    #lightbox-pop-premium
    {
    border: 1px solid #FCC328;
    margin-bottom: 20px;
    margin-top: 20px;
    background-color: #FFF6D6;
    height: 50px;
    padding: 5px;
    }
    

</style>

 
<div style="margin-top: 10px">
<table style="float:right; ">
<tr>
<td  style="float:right;">
	<a title="Please help us to keep this plugin free forever by donating a dollar"   class="xyz_lbx_link" style="margin-left:8px;"  target="_blank" href="http://xyzscripts.com/donate/1">Donate</a>
</td>
<td style="float:right;">
	<a class="xyz_lbx_link" style="margin-left:8px;" target="_blank" href="http://kb.xyzscripts.com/category/lightbox-pop">FAQ</a>
</td>
<td style="float:right;">
	<a class="xyz_lbx_link" style="margin-left:8px;" target="_blank" href="http://docs.xyzscripts.com/category/lightbox-pop/">Docs</a>
</td>
<td style="float:right;">
	<a class="xyz_lbx_link" style="margin-left:8px;" target="_blank" href="http://xyzscripts.com/wordpress-plugins/lightbox-pop/details">About</a>
</td>
<td style="float:right;">
	<a class="xyz_lbx_link" target="_blank" href="http://xyzscripts.com">XYZScripts</a>
</td>

</tr>
</table>
</div>

</div>

<div style="clear: both"></div>
<?php 
  $origin = ((empty($_SERVER['HTTPS'])?"http://":"https://").$_SERVER['HTTP_HOST']); 
	$returnURL = ($origin . $_SERVER['REQUEST_URI']);
?>
<div class="wrap">
    <?php if ($this->update) { ?>
            <form id="updateurl_form" name="updateurl_form" method="post" action="<?php echo $this->cashie_url; ?>/api/users/save_urls">
						<input type="hidden" name="cart"  value="<?php echo get_permalink($this->option_values['url_cart']); ?>" /> 
            <input type="hidden" name="checkout" value="<?php echo get_permalink($this->option_values['url_checkout']); ?>" />  
            <input type="hidden" name="success" value="<?php echo get_permalink($this->option_values['url_success']); ?>" />
            <input type="hidden" name="failure"  value="<?php echo get_permalink($this->option_values['url_failure']); ?>" />
            <input type="hidden" name="catalog"  value="<?php echo get_permalink($this->option_values['url_catalog']); ?>" /> 
            <input type="hidden" name="details"  value="<?php echo get_permalink($this->option_values['url_details_dynamic']); ?>" />  
            <input type="hidden" name="static_details"  value='<?php echo json_encode($this->option_values['static_details']); ?>' />  
            <input type="hidden" name="returnURL"  value="<?php echo $returnURL."&update=1"; ?>" />          
				</form>   
        <script type="text/javascript">
				  document.updateurl_form.submit();
				</script>
				<?php } // end if ($this->update) ?>
        <?php if ($_GET['update']==1) { ?>
      	<div id="notify-update"><span>Your pages have been regenerated.</span></div>
      <?php } ?>
    
    
   <iframe src="<?php echo $this->cashie_url; ?>/account/profile?<?php echo $this->cashie_url_vars; ?>&origin=<?php echo urlencode($origin); ?>&returnURL=<?php echo urlencode($returnURL); ?>&plugin_version=<?php echo cashie_get_version(); ?>" width="930" height="1150" frameborder="0"></iframe>
   
<br />
	<p class="contentarea">Cashie has created the following pages in your site: <a href="<?php echo get_permalink($this->option_values['url_catalog']); ?>" target="_blank">Product Catalog</a>, <?php if (!empty($this->option_values['url_details_dynamic'])) { ?><a href="<?php echo get_permalink($this->option_values['url_details_dynamic']); ?>" target="_blank">Product Details</a>, <?php } else { ?>Product Detail Pages, <?php } ?><a href="<?php echo get_permalink($this->option_values['url_cart']); ?>" target="_blank">Shopping Cart</a>, <a href="<?php echo get_permalink($this->option_values['url_checkout']); ?>" target="_blank">Checkout</a>, <a href="<?php echo get_permalink($this->option_values['url_success']); ?>" target="_blank">Order Success</a>, <a href="<?php echo get_permalink($this->option_values['url_failure']); ?>" target="_blank">Order Failure</a>. To ensure that our online store functions properly, you should not delete these pages or modify their URLs. If you need Cashie Commerce to recreate these pages, click the "Recreate Pages" button below.
   <br />
   <form id="pages_form" name="pages_form" method="post" action="">
						<input type="hidden" name="create_pages"  value="true" />
						<input type="hidden" name="update"  value="true" />           
					<div class="buttons"><a class="button-small" onclick="javascript:confirmPages();" alt="Recreate your Checkout and Shopping Cart pages if something is not working or you deleted one of the pages." title="Recreate your Checkout and Shopping Cart pages if something is not working or you deleted one of the pages.">Recreate Pages</a></div>           
				</form>
   </p>

</div> <!-- End of wrap -->
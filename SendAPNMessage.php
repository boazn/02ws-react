

<div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
<div id="SendSpecialResult"></div>
<div class="inv_plain_3" style="margin:0 auto;padding:0.5em;width:300px;text-align:right">
	<strong>Your message</strong><br/>
        <textarea id="message0" name="message0" cols="3   0" rows="4"  value="<? echo $message; ?>" style="text-align:left;font-size: 1em;width:290px"><? echo $message; ?></textarea><br/>
        title<input id="title0" name="title0" size="18"  value="" style="width:220px;"  /><br />
</div>
<div class="inv_plain_3" style="margin:0 auto;padding:0.5em;width:300px;text-align:right">
	<strong>כאן כתוב את הודעתך</strong><br/>
        <textarea id="message1" name="message1" cols="3   0" rows="4" value="<? echo $message; ?>" style="direction:rtl;font-size: 1em;width:290px"><? echo $message; ?></textarea><br/>
        title<input id="title1" name="title1" size="18"  value="" style="width:220px;direction:rtl"  /><br />
	picture url<input id="picture_url" name="picture_url1" size="20"  value="" style="width:220px;text-align:left"  /><br />
	external url<input id="embedded_url" name="embedded_url1" size="20"  value="" style="width:220px;text-align:left"  />
		
</div>


<div class="inv_plain_3" style="margin:0 auto;clear:both;text-align:center;padding:1em;width:25%">
	<input type="submit" id="SendButton" name="SendButton" value="Go" onClick="javascript:SendSpecial();" style="font-size: 1.2em;width:90%"/>
	
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
<script type="text/javascript">
    
         function SendSpecial()
        {
                $.ajax({
          type: "POST",
          url: "SendAPNService.php",
          data: { title1: $("#title1").val(), picture_url: $("#picture_url").val(), embedded_url: $("#embedded_url1").val(), message1: $("#message1").val() ,
                title0: $("#title0").val(),message0: $("#message0").val()},
            beforeSend: function(){$(".loading").show();}
        }).done(function( result  ) {

             $(".loading").hide();

             $("#SendSpecialResult").text(result);
             //$("#SendButton").hide();


        });
        }
</script>
    
   
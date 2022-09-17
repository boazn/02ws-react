<Style>
	body{ 
		background:white; 
	}
</style>


<div id="messages_box" class="">
    <h2><? echo $MESSAGES[$lang_idx];?></h2>
    <p class="box_text" style="font-size: 1.2em;padding:0.5em">
		<? var_dump($LATEST_ALERT);?>
		title=<?echo $LATEST_ALERT_TITLE[$lang_idx];?>
		body=<?echo $LATEST_ALERT_BODY[$lang_idx];?>
		
		cut=<?echo $LATEST_ALERT_BODY_CUT[$lang_idx];?>
		passedts = <?echo $latestalert_passedts;?>
    </p>
	<div id="adunit3" class="adunit" style="display:none">
        
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- Large Mobile Banner 1 -->
	<ins class="adsbygoogle"
		 style="display:inline-block;width:320px;height:100px"
		 data-ad-client="ca-pub-2706630587106567"
		 data-ad-slot="3647675909"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	</div>
     <p id="personal_message">
     
     </p>
</div>



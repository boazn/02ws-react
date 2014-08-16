

<?
	ini_set("display_errors","On");
?>


	<h1><? echo($YESTERDAY[$lang_idx]);?> <? echo $yestsametime->get_date();?></h1> 
	<div style="margin:1em;float:<?=get_s_align()?>">
		<script type="text/javascript"><!--
		google_ad_client = "pub-2706630587106567";
		/* 336x280, created 9/12/10 */
		google_ad_slot = "7039677402";
		google_ad_width = 336;
		google_ad_height = 280;
		google_color_border = ["<?= $forground->bg['+4'] ?>"];
		google_color_bg = ["<?= $forground->bg['+4'] ?>"];
		google_color_link = ["<?= $forground->bg['-9'] ?>"];
		google_color_url = ["<?= $forground->bg['-9'] ?>"];
		google_color_text = ["<?= $forground->bg['-9'] ?>"];

		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</div>
	<div <? if (isHeb()) echo "dir=\"rtl\" ";?> style="margin:1em;float:<?=get_s_align()?>">
		<div class="high big" style="height:30%">
			<? echo($MAX[$lang_idx]);?> <? echo($TEMP[$lang_idx]);?>: <? echo "[".$yest->get_hightemp_time()."] "; ?> <?echo $yest->get_hightemp(),$current->get_tempunit();?>
		</div>
		<div class="low big" style="height:30%">
			<? echo($MIN[$lang_idx]);?> <? echo($TEMP[$lang_idx]);?>: <? echo "[".$yest->get_lowtemp_time()."] "; ?> <?echo $yest->get_lowtemp(),$current->get_tempunit();?><br />
		</div>
		<div class="big inv_plain_2" style="height:30%">
		<? echo $RAIN[$lang_idx].": ".$yest->get_rain()." ".$RAIN_UNIT[$lang_idx];?>
		</div>
	</div>
	






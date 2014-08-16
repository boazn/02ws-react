

<div>
   <script type="text/javascript"><!--
	google_ad_client = "pub-2706630587106567";
	/* 300x250, created 10/20/10 */
	google_ad_slot = "2164253176";
	google_ad_width = 300;
	google_ad_height = 250;
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
<div style="margin:5.5em 0">
				
				<ul class="list">	
				<li class="<?=getAlternateClass()?>"><a class="hlink" href="http://www.wunderground.com/stationmaps/gmap.asp?zip=00000&amp;wmo=40184" title="nearby stations תחנות בסביבה" rel='external' >
						<?  echo $WEATHER_NEARBY[$lang_idx]; ?></a>
				</li>
				<li class="<?=getAlternateClass()?>"><a href="JWSBanner.html" class="hlink"><? echo $BANNER_FLASH_VIEW[$lang_idx];?></a></li>
				<li class="<?=getAlternateClass()?>"><? echo $GENDER_NOTICE[$lang_idx]." <em id=\"gendertype\"></em>.<br />".$GENDER_NOTICE2[$lang_idx]; ?></li>
				<? if ($licount < 9) { ?>
				<li class="<?=getAlternateClass()?>"><a href="<? echo get_query_edited_url($url_cur, 'section', 'allTimeRecords.php');?>" class="hlink" title="<?=$RECORDS[$lang_idx];?>"><? echo $RECORDS_LINK[$lang_idx];?></a></li>
				<? } ?>
				</ul>
</div>

  	
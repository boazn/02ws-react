<?
Function getLyrics($location, $song)
{
	$lyrics_full_page = get_file_string($location);
	return $forecast_full_page;
	$start = strpos($lyrics_full_page, $song);
	$end = strpos($lyrics_full_page, "<div id=\"right\">");
	$lyricsDiv = substr ( $lyrics_full_page, $start + strlen($song), $end - ($start + strlen($song)));
	//$tok = getTokFromFile($location);
	//getNextWordWith($tok, $song);
	//getNextWord($tok, 6);// Dep.From NORM OF January
	return "<pre><div id=\"".$song."\" style=\"display:none\">".$lyricsDiv."</div></pre>";
}
?>
<h2><? echo $SONGS[$lang_idx];?></h2>
<Script type="text/javascript" language="Javascript" SRC="ajax.js">
</Script>
<p class="inv_plain_3" style="padding:0.5em;<? if (isHeb()) echo "direction:rtl;text-align:right"; ?>">
<? if (isHeb()) { ?> 
	שירים ומזג-אוויר הולכים מעולה ביחד.
	והכי טוב שירים שמדברים  ונושמים את זה.<br/>
	הנה כמה דוגמאות לשירים ש כאלה שגם אני אוהב.
	<? } else { ?>
	Music and weather is well connected. Here are some songs (that I like) that speeks and breathe the weather.
	<? }?>
</p>
<div class="float" style="padding:0.5em">
		<h2 class="inv_plain_3_zebra" style="padding:0.5em"><a href="http://www.lyricstime.com/doors-riders-on-the-storm-lyrics.html" class="colorbox"	rel="external" >Riders on the storm - The doors <?=get_arrow()?></a></h2>
		<iframe width="480" height="270" src="https://www.youtube.com/embed/lS-af9Q-zvQ" frameborder="0" allowfullscreen></iframe>

		
		
		
		<h2 class="inv_plain_3_zebra" style="padding:0.5em"><a href="http://www.sing365.com/music/lyric.nsf/Blind-lyrics-Deep-Purple/68779657DF2260464825695E00045317" class="colorbox" rel="external">Deep Purple - Blind <?=get_arrow()?></a></h2>
		<iframe width="480" height="295" src="http://www.youtube.com/embed/ibtj2oLND4U" frameborder="0" allowfullscreen></iframe>
		
		
		
		
	</div>
	<div class="float" style="padding:0.5em">
		<h2 class="inv_plain_3_zebra" style="padding:0.5em"><a href="http://www.lyricstime.com/crowded-house-weather-with-you-lyrics.html" class="colorbox" rel="external">Weather With You - Crowded House </a><?=get_arrow()?></h2>
		<iframe width="480" height="295" src="http://www.youtube.com/embed/ag8XcMG1EX4" frameborder="0" allowfullscreen></iframe>

		<h2 class="inv_plain_3_zebra" style="padding:0.5em"><a href="http://www.lyricstime.com/zeppelin-led-the-rain-song-lyrics.html" class="colorbox" rel="external">The Rain Song - Led Zeppelin </a><?=get_arrow()?></h2>
		<object width="480" height="295"><param name="movie" value="http://www.youtube.com/v/2cqO1uL0DCk&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/2cqO1uL0DCk&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="295"></embed></object>
			<div id="lyricsDiv" style="border:1px dashed"></div>
			
			
	</div>
<div class="clear" >
	<script type="text/javascript"><!--
			google_ad_client = "pub-2706630587106567";
			google_ad_width = 728;
			google_ad_height = 90;
			google_ad_format = "728x90_as";
			google_ad_type = "text";
			google_ad_channel ="";
			google_color_border = ["<?= $forground->bg['+4'] ?>"];
			google_color_bg = ["<?= $forground->bg['+4'] ?>"];
			google_color_link = ["<?= $forground->bg['-9'] ?>"];
			google_color_url = ["<?= $forground->bg['-9'] ?>"];
			google_color_text = ["<?= $forground->bg['-9'] ?>"];

			//--></script>
			<script type="text/javascript"
			  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
</div>
<div class="float" style="padding:0.5em">
	<h2 class="inv_plain_3_zebra" style="padding:0.5em"><a href="http://www.leoslyrics.com/listlyrics.php?id=97151" class="colorbox" >Sometimes It Snows In April - Prince <?=get_arrow()?></a></h2>
	<iframe width="480" height="270" src="https://www.youtube.com/embed/uGzXiK8_KU8" frameborder="0" allowfullscreen></iframe>
</div>	
<div class="float" style="padding:0.5em">
	<h2 class="inv_plain_3_zebra" style="padding:0.5em"><a href="http://www.lyricstime.com/eurythmics-here-comes-the-rain-again-lyrics.html" class="colorbox" rel="external">Here Comes The Rain Again - Eurythmics  <?=get_arrow()?></a></h2>
	<object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/uy115Hbm9DU&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/uy115Hbm9DU&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>
</div>
<div class="float" style="padding:0.5em">
	<h2 class="inv_plain_3_zebra" style="padding:0.5em"><a href="http://www.lyricstime.com/bob-marley-sun-is-shining-lyrics.html" class="colorbox" rel="external">Sun Is Shining - Bob Marley <?=get_arrow()?></a></h2>
		<iframe width="480" height="270" src="https://www.youtube.com/embed/UOoHTcuORcY" frameborder="0" allowfullscreen></iframe>
			
</div>
 <div class="float" style="padding:0.5em">
    <iframe width="560" height="315" src="//www.youtube.com/embed/FscIgtDJFXg" frameborder="0" allowfullscreen></iframe>
</div>
<div class="float" style="padding:0.5em">
<iframe width="420" height="315" src="//www.youtube.com/embed/znaQ9BHBcgM" frameborder="0" allowfullscreen></iframe>
</div>

<script>
	function fillSong(str)
	{
		var SongDetails = document.getElementById('lyricsDiv');
		 if (SongDetails.firstChild) {
		   SongDetails.removeChild(SongDetails.firstChild);
		 }
		 newDiv = document.createElement("div");
		 newDiv.innerHTML = str;
		 //forecastDetails.appendChild(newDiv); 
		 SongDetails.innerHTML = str;
	}
	function getLyrics(location, startPos,  div_id)
	{	
		fillSong('<img src="images/loading.gif" alt="loading" />', div_id);
		var ajax = new Ajax();
		ajax.setMimeType('text/xml');
		ajax.doGet('songs/getLyrics.php?lang=<?=$lang_idx?>&location=' + location + '&startPos=' + startPos, fillSong);
		
	}
	
</script>
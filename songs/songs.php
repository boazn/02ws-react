<?
Function getLyrics($location, $song)
{
	$lyrics_full_page = get_file_string($location);
	//echo $forecast_full_page;
	$start = strpos($lyrics_full_page, $song);
	$end = strpos($lyrics_full_page, "<div id=\"right\">");
	$lyricsDiv = substr ( $lyrics_full_page, $start + strlen($song), $end - ($start + strlen($song)));
	//$tok = getTokFromFile($location);
	//getNextWordWith($tok, $song);
	//getNextWord($tok, 6);// Dep.From NORM OF January
	return "<pre><div id=\"".$song."\" style=\"display:none\">".$lyricsDiv."</div></pre>";
}
?>
<center>
<h2><? echo $SONGS[$lang_idx];?></h2>


</center>
<table>
<tr>
<td colspan="2" class="inv_plain_2" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
<? if (isHeb()) { ?> 
	שירים ומזג-אוויר הולכים מעולה ביחד.
	והכי טוב שירים שמדברים  ונושמים את זה.
	הנה כמה דוגמאות לשירים ש כאלה שגם אני אוהב.
	<? } else { ?>
	Music and weather is well connected. Here are some songs (that I like) that speeks and breathe the weather.
	<? }?>
</td>
</tr>
<tr>
	<td valign="top">
		<h4><a href="#" class="hlink" onclick="toggle('doors-riders-on-the-storm-lyrics.html')">Riders on the storm - The doors >></a></h4>
		<? echo getLyrics("http://www.lyricstime.com/doors-riders-on-the-storm-lyrics.html", "doors-riders-on-the-storm-lyrics.html");?>
		<h4><a href="http://www.leoslyrics.com/listlyrics.php?id=97151" target="_blank" class="hlink">Sometimes It Snows In April - Prince >></a></h4>
		<h4><a href="#" class="hlink" onclick="toggle('bob-marley-sun-is-shining-lyrics.html')">Sun Is Shining - Bob Marley >></a></h4>
		<? echo getLyrics("http://www.lyricstime.com/bob-marley-sun-is-shining-lyrics.html", "bob-marley-sun-is-shining-lyrics.html");?>
		<h4><a href="#" class="hlink" onclick="toggle('crowded-house-weather-with-you-lyrics.html')">Crowded House - "Weather With You" >></a></h4>
		<? echo getLyrics("http://www.lyricstime.com/crowded-house-weather-with-you-lyrics.html", "crowded-house-weather-with-you-lyrics.html");?>
		<h4><a href="#" class="hlink" onclick="toggle('eurythmics-here-comes-the-rain-again-lyrics.html')">Eurythmics  - "Here Comes The Rain Again lyrics" >></a></h4>
		<? echo getLyrics("http://www.lyricstime.com/eurythmics-here-comes-the-rain-again-lyrics.html", "eurythmics-here-comes-the-rain-again-lyrics.html");?>
	</td>
	<td valign="top">
			<script type="text/javascript"><!--
			google_ad_client = "pub-2706630587106567";
			google_alternate_color = "C2CEDC";
			google_ad_width = 300;
			google_ad_height = 250;
			google_ad_format = "300x250_as";
			google_ad_type = "text";
			google_ad_channel ="4740654689";
			google_color_border = ["FEFEFE"];
			google_color_bg = ["FEFEFE"];
			google_color_link = ["265C99"];
			google_color_url = ["265C99"];
			google_color_text = ["265C99"];
			//--></script>
			<script type="text/javascript"
			  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
	</td>
</tr>
</table>
 

<? 
$datafile="songs.dat";
include ("counter.php");
?>
<script>
	function fillSong(str, div_id)
	{
		var SongDetails = document.getElementById(div_id);
		 if (SongDetails.firstChild) {
		   SongDetails.removeChild(SongDetails.firstChild);
		 }
		 newDiv = document.createElement("div");
		 newDiv.innerHTML = str;
		 //forecastDetails.appendChild(newDiv); 
		 SongDetails.innerHTML = str;
	}
	function getLyrics(location, div_id)
	{	
		fillForecast('...Loading<br/><img src="images/loading.gif" alt="loading" />', div_id);
		var ajax = new Ajax();
		ajax.setMimeType('text/xml');
		ajax.doGet('songs/getLyrics.php?lang=<?=$lang_idx?>&location=' + location, fillSong);
		
	}
	
</script>
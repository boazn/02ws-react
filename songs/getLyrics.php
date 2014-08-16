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
echo getLyrics($_REQUEST['location'],$_REQUEST['startPos']);
?>
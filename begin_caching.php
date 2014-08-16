<?php

  include_once ("ini.php");
  // Settings
  $cachedir = 'cache'; // Directory to cache files in (keep outside web root)
  $cachetime = 900; // Seconds to cache files for
  $cacheext = 'cache'; // Extension to give cached files (usually cache, htm, txt)
  ini_set("display_errors","On"); 
  // Ignore List
  $ignore_list = array(
	'reports',
	'survey',
	'chat.php',
	'search.php',
    'browsedate.php',
	'RainSeasons.php',
	'getForecast.php',
	'getWeather.php',
	'SendEmailForm.php',
	'pic_movie_archive.php',
	'SendFeedback.php',
	'WindSpeedHistory',
	'updateForecast',
	'RainHistory'
  );

  // Script
  $path =  "/".basename($_SERVER['SCRIPT_NAME'])."#".$_SERVER['QUERY_STRING'];
  $page = 'http://' . $_SERVER['HTTP_HOST'] .basename($_SERVER['SCRIPT_NAME']).serialize($_GET).serialize($_POST); 
  
  $cachefile = $cachedir.$path.'.'.$cacheext; // Cache file to either load or create

  //echo "<b>$cachefile</b>";
  $ignore_page = false;
  for ($i = 0; $i < count($ignore_list); $i++) {
    $ignore_page = (strpos($page, $ignore_list[$i]) !== false) ? true : $ignore_page;
  }

  $cachefile_created = ((file_exists($cachefile)) and ($ignore_page === false)) ? filemtime($cachefile) : 0;
  @clearstatcache();

  //echo "<br><b>$cachefile_created</b>";
  // Show file from cache if still valid
  if ((time() - $cachetime < $cachefile_created) 
	 &&($cachefile_created > @filemtime($fulldatatotake))){
	//echo "<br>from cache";
	if ($is_image)
		header("Content-type: image/png");
	else if ($is_xml)
		header("Content-type: text/xml");
	
	//if (!stristr("section",  $_SERVER['QUERY_STRING'])){
	//	header("Location: ".$cachefile);
	//	exit();
	//}
    
	ob_start('ob_gzhandler');
    readfile($cachefile);
    ob_end_flush();
    exit();

  }

  // If we're still here, we need to generate a cache file

  ob_start();

?>
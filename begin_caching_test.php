<?php
  include_once ("ini.php");
  // Settings
  $cachedir = 'cache/'; // Directory to cache files in (keep outside web root)
  $cachetime = 900; // Seconds to cache files for
  $cacheext = 'cache'; // Extension to give cached files (usually cache, htm, txt)

  // Ignore List
  $ignore_list = array(
    'browsedate.php',
	'RainSeasons.php',
	'getForecast.php',
	'getWeather.php',
	'SendEmailForm.php',
	'WindSpeedHistory',
	'RainHistory'
  );

  // Script
  $page = $_SERVER['REQUEST_URI']; 
  
  $cachefile = $cachedir.$page.'.'.$cacheext; // Cache file to either load or create
  echo $cachefile;
  $ignore_page = false;
  for ($i = 0; $i < count($ignore_list); $i++) {
    $ignore_page = (strpos($page, $ignore_list[$i]) !== false) ? true : $ignore_page;
  }

  $cachefile_created = ((@file_exists($cachefile)) and ($ignore_page === false)) ? @filemtime($cachefile) : 0;
  @clearstatcache();

  // Show file from cache if still valid
  if ((time() - $cachetime < $cachefile_created) 
	 &&($cachefile_created > @filemtime(FILE_XML_FULLDATA))){
	if ($is_image)
		header("Content-type: image/png");
	else if ($is_xml)
		header("Content-type: text/xml");
    ob_start('ob_gzhandler');
    @readfile($cachefile);
    ob_end_flush();
    exit();

  }

  // If we're still here, we need to generate a cache file

  ob_start();

?>
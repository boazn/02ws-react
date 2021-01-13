<?php

  include_once ("ini.php");
  $mem = new Memcached();
  $mem->addServer('localhost', 11211);
  // Settings
  $cachedir = 'cache'; // Directory to cache files in (keep outside web root)
  $cachetime = 300; // Seconds to cache files for
  $cacheext = 'cache'; // Extension to give cached files (usually cache, htm, txt)
  //ini_set("display_errors","On"); 
  // Ignore List
  $ignore_list = array(
	'reports',
        'mainstory',
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
  $res_list = array(
      'main.php',
      'footer',
      'mobile.php'
      
  );
  // Script
  $path =  "/".basename($_SERVER['SCRIPT_NAME'])."#".$_SERVER['QUERY_STRING'];
  $page = 'https://' . $_SERVER['HTTP_HOST'] .basename($_SERVER['SCRIPT_NAME']).serialize($_GET).serialize($_POST); 
  
  $cachefile = $cachedir.$path.'.'.$cacheext; // Cache file to either load or create

  //echo "<b>$cachefile</b>";
  $ignore_page = false;
  for ($i = 0; $i < count($ignore_list); $i++) {
    $ignore_page = (strpos($page, $ignore_list[$i]) !== false) ? true : $ignore_page;
  }
  $res_page = false;
  for ($i = 0; $i < count($res_list); $i++) {
    $res_page = (strpos($page, $res_list[$i]) !== false) ? true : $res_page;
  }
  if (strlen($path) > 60)
      $ignore_page = true;
  if (FILE_CACHE == "APC"){
   $cachefile_created = $mem->get($path."_created");
   if ($res_page){
    $newfile_time = $mem->get($path."_new");
    if (!$newfile_time)
      $mem->set($path."_new", time(), time() + 300);
   }
  }
   else
   $cachefile_created = ((file_exists($cachefile)) and ($ignore_page === false)) ? filemtime($cachefile) : 0;
  //@clearstatcache();

  //echo "<br><b>$cachefile_created</b>";
  // Show file from cache if still valid
  if ((($res_page)&&($newfile_time < $cachefile_created))||
       ((!$res_page)&&(time() - $cachetime < $cachefile_created) 
	 &&($cachefile_created > @filemtime($fulldatatotake)))){
	
	if ($is_image)
		header("Content-type: image/png");
	else if ($is_xml)
		header("Content-type: text/xml");
	
	//if (!stristr("section",  $_SERVER['QUERY_STRING'])){
	//	header("Location: ".$cachefile);
	//	exit();
	//}
        //if ($res_page)
        //    logger "/* cached: cachefile_created=".$cachefile_created." time=".time()."*/";
        if (extension_loaded('zlib')){ ob_end_clean(); ob_start('ob_gzhandler');}
	
    
    if (FILE_CACHE == "APC")
        echo $mem->get($path);
    else
        readfile($cachefile);
    //echo "/*from cache*/";
    ob_end_flush();
    exit();

  }

  // If we're still here, we need to generate a cache file

  ob_start();

?>
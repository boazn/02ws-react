<?  
    ini_set("display_errors","On");
    header("Content-type: application/json");
include "../begin_caching.php";
include ('../ini.php');
$lang_idx = @$_GET['lang'];
$css_comp = explode (",",$_GET['type']);
function isHeb()
{
	global $lang_idx;
	return ($lang_idx == 1);
}
function get_s_align(){
    if (isHeb()) 
            return "right";
    else
            return "left";
}
function get_inv_s_align(){
        if (isHeb()) 
                return "left";
        else
                return "right";
}
function get_deg ($deg)
{
    if (isHeb()) return $deg; else return $deg - 30;
}
?>
{
  "short_name": "<?=$LOGO[$lang_idx]?>",
  "name": "<?=$WEBSITE_TITLE[$lang_idx]?>",
  "icons": [
    {
      "src": "/img/logo.png",
      "type": "image/png",
      "sizes": "113x112"
    },
    {
      "src": "/img/logo_rain_black.png",
      "type": "image/png",
      "sizes": "126x111"
    },
    {
      "src": "/img/logo.svg",
      "type": "image/svg",
      "sizes": "567x567"
    }

  ],
  "start_url": "/",
  "background_color": "#03bfff",
  "display": "standalone",
  "dir":"<?if (isHeb()) echo "rtl"; else echo "ltr";?>",
  "lang":"<?if (isHeb()) echo "rtl"; else echo "en-US";?>",
  "scope": "/",
  "theme_color": "#3367D6",
  "shortcuts": [
    {
      "name": "How's weather today?",
      "short_name": "Today",
      "description": "View weather information for today",
      "url": "/",
      "icons": [{ "src": "/img/logo.svg", "sizes": "567x567" }]
    },
    {
      "name": "How's weather tomorrow?",
      "short_name": "Tomorrow",
      "description": "View weather information for tomorrow",
      "url": "/",
      "icons": [{ "src": "/img/logo.svg", "sizes": "567x567" }]
    }
  ],
  "description": "<?=$SLOGAN[$lang_idx]?>",
  "screenshots": [
    {
      "src": "../02ws_short.png",
      "type": "image/png",
      "sizes": "1100x624"
    },
    {
      "src": "/images/webCameraB.jpg",
      "type": "image/jpg",
      "sizes": "2592x1944"
    },
    {
      "src": "/images/webCamera.jpg",
      "type": "image/jpg",
      "sizes": "1920x1080"
    }
  ]
}
<? if ($_GET['debug'] == '') include "../end_caching.php"; ?>
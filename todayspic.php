<?
function ShowOneRSS($url) {
    global $rss;
    if ($rs = $rss->get($url)) {
		    echo '<pre>';
				print_r($rs);
				echo '</pre>';
            echo "\n";
            foreach ($rs['items'] as $item) {
                echo "\t<a href=\"$item[link]\" title=\"$item[title]\">$item[title]</a>".$item['media:content']."\n";
				
            }
            if ($rs['items_count'] <= 0) { echo "<li>Sorry, no items found in the RSS file :-(</li>"; }
            echo "\n";
    }
    else {
        echo "Sorry: It's not possible to reach RSS file $url\n<br />";
        // you will probably hide this message in a live version
    }
}

// ===============================================================================

// include lastRSS
include "./lastRSS.php";

$url="https://picasaweb.google.com/data/feed/base/user/115726297130259560708/albumid/5684503653462263217?alt=rss&kind=photo&authkey=Gv1sRgCKXYkOm53oDh8gE&hl=en_US";

// Create lastRSS object
$rss = new lastRSS;

// Set cache dir and cache time limit (5 seconds)
// (don't forget to chmod cahce dir to 777 to allow writing)
$rss->cache_dir = './cache';
$rss->cache_time = 1200;


   ShowOneRSS($url);

?> 
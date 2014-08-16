<?php
/**
 * Project:   WU GRAPHS
 * Module:    wxwugraphs.php 
 * Copyright: (C) 2010 Radomir Luza
 * Email: luzar(a-t)post(d-o-t)cz
 * WeatherWeb: http://pocasi.hovnet.cz 
 */
################################################################################
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 3
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>. 
################################################################################

require_once("wxwugraphs/settings.php");
require_once("wxwugraphs/common.php");

if (isset($SITE['lang'])    ) { $scLang = strtolower($SITE['lang']); }
if (isset($_SESSION['lang'])) { $scLang = strtolower($_SESSION['lang']); }
if (isset($_REQUEST['lang'])) { $scLang = strtolower($_REQUEST['lang']); }

SetCookie ("cookie_lang", $scLang, time()+3600*24*365, "/"); // 365 days

require_once('./wxwugraphs/WUG-settings.php');

$TITLE= $SITE['organ'] . " - ".$Tgraphs;
$showGizmo = true;  // set to false to exclude the gizmo

//$SITE['charset'] = 'UTF-8';
include("top.php");
//echo '<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />';


if ($incTabsStyle) {
  echo '<link type="text/css" href="'.$tabsStyleFile.'" rel="stylesheet" />';
}

if ($loadJQuery) {
  echo '<script type="text/javascript" src="'.$jQueryFile.'"></script>';
  echo '<script type="text/javascript" src="./wxwugraphs/js/jq-core-widget-tabs.min.js"></script>';
}
?>
  
<?php

$JSalertOut = isset($JSalert) ? 'alert('.$JSalert.');' : '';

echo '
<script type="text/javascript">
	      $(function() {
          $("#WU-MDswitch").tabs({
            cookie: {
              expires: 30,
              path: "'.$_SERVER["PHP_SELF"].'"
            },
            spinner: \''.$Tloading.'\',
            cache: true
          }); 
        });       
</script>

<script type="text/javascript">
// auto height
$("WUG-foot").ready(function() {
  var mcheight = document.getElementById("main-copy").offsetHeight;
  document.getElementById("WUG-tabbed").style.height = mcheight + "px";
});

// Some reports as JS alerts
'.$JSalertOut.'
</script>	    
';
?>
<style type="text/css">
.WUG-subtab .ui-tabs-panel {padding:0px;}
#WUGcInfo {
font: 8pt Tahoma,Verdana,Arial,sans-serif;
/*border-top:1px solid #bbb;*/
}
.c-lside a {
font-weight: normal !important;
text-decoration: underline !important;  
color: #bbb !important;
}
.c-rside a {
color: #75A3D1 !important;
}
#main-copy {
font-size: 9pt;
<?php
echo 'background-color:'.$pgBGC.';
color:'.$wugfontColor.';
';
?> 
}
.ui-tabs-panel {
<?php echo 'background-color:'.$pgBGC.';'; ?>
}
</style>
</head>
<body>
<script src="./wxwugraphs/js/wz_tooltip.js" type="text/javascript"></script>
<?php

include("header.php");
include("menubar.php");

// convert all non 1-byte characters to htmlentities
function utf8tohtml($utf8, $encodeTags=false) {
    $result = '';
    for ($i = 0; $i < strlen($utf8); $i++) {
        $char = $utf8[$i];
        $ascii = ord($char);
        if ($ascii < 128) {
            // one-byte character
            $result .= ($encodeTags) ? htmlentities($char) : $char;
        } else if ($ascii < 192) {
            // non-utf8 character or not a start byte
        } else if ($ascii < 224) {
            // two-byte character
            //$result .= htmlentities(substr($utf8, $i, 2), ENT_QUOTES, 'UTF-8');
            $ascii1 = ord($utf8[$i+1]);
            $unicode = (15 & $ascii) * 64 +
                       (63 & $ascii1);
            $result .= "&#$unicode;";
            $i++;
        } else if ($ascii < 240) {
            // three-byte character
            $ascii1 = ord($utf8[$i+1]);
            $ascii2 = ord($utf8[$i+2]);
            $unicode = (15 & $ascii) * 4096 +
                       (63 & $ascii1) * 64 +
                       (63 & $ascii2);
            $result .= "&#$unicode;";
            $i += 2;
        } else if ($ascii < 248) {
            // four-byte character
            $ascii1 = ord($utf8[$i+1]);
            $ascii2 = ord($utf8[$i+2]);
            $ascii3 = ord($utf8[$i+3]);
            $unicode = (15 & $ascii) * 262144 +
                       (63 & $ascii1) * 4096 +
                       (63 & $ascii2) * 64 +
                       (63 & $ascii3);
            $result .= "&#$unicode;";
            $i += 3;
        }
    }
    return $result;
}

$hourTab = '<li><a href="./wxwugraphs/WUG-tabsh.php?lang='.$scLang.'"><span>'.utf8tohtml($Thourly).'</span></a></li>';
$hrTab = $hGraphs ? $hourTab : '';

echo 
'
<div id="main-copy">
  <table id="WUG-tabbed" style="width:100%;">
    <tr><td style="vertical-align:top;"> 
    <h1>'.$Tgraphs.'</h1>     
    <br />

    <noscript>
    <div style="color:red; text-align:center;"><b>'.$Tnojs.'</b></div>
    </noscript>
       
    <div id="WU-MDswitch" style="position:relative;">
';


if ($langSwitch) {
  $thLang = $_GET['lang'] ? $_GET['lang'] : $_COOKIE['cookie_lang'];
  echo '<div id="lang-switch" style="text-align: right; /*margin-top: 0px; float: right*/ position:absolute; right:0; top:0px;">
  <form name="languages" action="#" style="font-size: 14px;">
  Language: <select name="langSelect" onchange="location.href=\''.$_SERVER["PHP_SELF"].'?lang=\'+document.languages.langSelect.value;">';
  include ('./wxwugraphs/languages/langlist.php');
  foreach ($langList as $key => $val) {
    $selectedL = $thLang == $key ? ' selected' : '';
    echo '<option value="'.$key.'"'.$selectedL.'>'.utf8tohtml($val).'</option>';
  }
  echo '</select>
  </form>
  </div>';
}
echo '      <ul style="/*height:25px;*/">
        '.$hrTab.'
        <li><a href="./wxwugraphs/WUG-tabsd.php?lang='.$scLang.'"><span>'.utf8tohtml($Tdaily).'</span></a></li>
        <li><a href="./wxwugraphs/WUG-tabsm.php?lang='.$scLang.'"><span>'.utf8tohtml($Tmonthly).'</span></a></li>
        <li><a href="./wxwugraphs/WUG-tabsy.php?lang='.$scLang.'"><span>'.utf8tohtml($Tyearly).'</span></a></li>  		
     </ul>
    </div>
    </td></tr>
    <tr><td style="vertical-align:bottom;"><div id="WUG-foot">
';
require_once('./wxwugraphs/WUG-ver.php');
echo 
'
    </div></td></tr>
  </table>
</div><!-- end main-copy -->
';

echo $errWUGlang;

include("footer.php");
?>
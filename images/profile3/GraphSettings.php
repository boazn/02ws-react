<?php
function utf8_strrev($str){
   preg_match_all('/./us', $str, $ar);
   return join('',array_reverse($ar[0]));
}
############################################################################
# A Project of TNET Services, Inc.
############################################################################
#
#   Project:    Cumulus Project 
#   Package:    Cumulus Weather JpGraph Graphs
#   Module:     GraphSettings.php
#   Version:    3.1 - October 26th, 2008
#   Purpose:    Settings file for Graphs
#   Authors:    Kevin W. Reed <programs@tnet.com>
#               TNET Services, Inc.
#   Copyright:  (c) 1992-2008 Copyright TNET Services, Inc.
#
#   License:    
#
#   This program is free software; you can redistribute it and/or
#   modify it under the terms of the GNU General Public License
#   as published by the Free Software Foundation; either version 2
#   of the License, or (at your option) any later version.
#   
#   This program is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU General Public License for more details.
#   
#   You should have received a copy of the GNU General Public License
#   along with this program; if not, write to the Free Software
#   Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, 
#   USA.
#
############################################################################
#   HISTORY
############################################################################
#
#   1.0     Released Oct 10th, 2008
#           Initial Release
#
#   1.2     Released Oct 12th, 2008
#           Added Debugging Ability
#           Added CLI Capabilities
#           Added Info Display to Graphs
#
#	2.0		Internal Version
#
#	3.0		Released Oct 19th, 2008
#			Modifications to match 1.8.2 Beta which extended
#			The number of fields in realtime.txt includes
#			rebuild of data field access routines.
#
#	3.1		Released Oct 26th, 2008
#			Minor clean up of source code (Removal of duplicate code
#			from indiviual graphs), correction of rain graph which
#			now includes monthly rain
#
############################################################################
#   This document uses Tab 4 Settings
############################################################################
$SITE   = array();
############################################################################
# CONFIGURATION INFORMATION
############################################################################
include_once("../../lang.php");
$height = 300;
if ($width == 0)
    $width = 550;
$lang_idx = $_GET['lang'];
if ($lang_idx == "")
	$lang_idx = 1;
$SITE['version']        = "3.1";
$SITE['hloc']           = "../../";
$SITE['jpgraphloc']     = "../../jpgraph/";
$SITE['datafile']       = "realtime.log";
$SITE['sitename']       = "02ws.com ".utf8_strrev("ירושמיים");
$SITE['bgncolor']       = "#EFEFEF";
$SITE['txtcolor']       = "#22464F";
$SITE['tz']             = "US/Arizona";
#---------------------------------------------------------------------------
$SITE['infopass']       = "";
$SITE['debugpass']      = "";
$SITE['datapass']       = "sce";
$SITE['viewpass']       = "sce";
$SITE['debug']          = 0;        # Adjustable via debug
$SITE['info']           = 1;        # Adjustable via info
#---------------------------------------------------------------------------
// Current field names (matches tag fields) used
$SITE['cvalues'] = array(
	"date","time","temp","hum","dew","wspeed","wgust","avgbearing","rrate",
	"rfall","press","wdir","beaufort","windunit","tempunit","pressunit","rainunit",
	"windrun","presstrend","rmonth","ryear","rfallY","intemp","inhum","wchill",
	"temptrendval","tempTH","TtempTH","tempTL","TtempTL",
	"windTM","TwindTM","wgustTM","TwgustTM",
	"pressTH","TpressTH","pressTL","TpressTL",
	"version","build","rmaxgust","heatindex","humidex");
$SITE['humidexval'] = array(
	"0" => array("0","29","Little or no discomfort"),
	"1" => array("30","34","Noticeable discomfort"),
	"2" => array("35","39","Evident discomfort"),
	"3" => array("40","44","Intense discomfort; avoid exertion"),
	"4" => array("45","0", "Dangerous discomfort"),
	"5" => array("54","0", "Heat stroke probable") );
$SITE['beufort'] = array("Calm","Light Air","Light Breeze","Gentle Breeze",
	"Moderate Breeze", "Fresh Breeze", "Strong Breeze", "Near Gale",
	"Gale", "Strong Gale", "Storm", "Violent Storm","Hurricane");	
$SITE['compass'] = array(0 => 'N', 45 => 'NE', 90 =>'E', 135 => 'SE', 180 => 'S', 
        225 => 'SW', 270 => 'W', 315 => 'NW', 360 => 'N');	
############################################################################

############################################################################
# Reference: Cumulus Format of realtime.txt file
############################################################################
#   Field       Pos     Example     Description
#   date        0       18/10/08    date (always dd/mm/yy)
#   time        1       16:03:45    time (always hh:mm:ss)
#   temp        2       8.4         outside temperature
#   hum         3       84          relative humidity
#   dew         4       5.8         dewpoint
#   wspeed      5       24.2        wind speed (average)
#   wgust       6       33.0        wind speed (gust)
#   avgbearing  7       261         wind bearing
#   rrate       8       0.0         current rain rate
#   rfall       9       1.0         rain today
#   press       10      999.7       barometer
#   wdir        11      W           wind direction
#   beaufort    12      6           wind speed (beaufort)
#   windunit    13      mph         wind units
#   tempunit    14      C           temperature units
#   pressunit   15      mb          pressure units
#   rainunit    16      mm          rain units
#   windrun     17      146.6       wind run (today)
#   pressrend   18      +0.1        pressure trend value
#   rmonth      19      85.2        monthly rain
#   ryear       20      588.4       yearly rain
#   rfallY      21      11.6        yesterday's rainfall
#   intemp      22      20.3        inside temperature
#   inhum       23      57          inside humidity
#   wchll       24      3.6         wind chill
#   temptrendval 25     -0.7        temperature trend value
#   tempTH      26      10.9        today's high temp
#   TtempTH     27      12:00       time of today's high temp (hh:mm)
#   tempTL      28      7.8         today's low temp
#   TtempTL     29      14:41       time of today's low temp (hh:mm)
#   windTM      30      37.4        today's high wind speed (average)
#   TwindTM     31      14:38       time of today's hi wind (avg) (hh:mm)
#   wgustTM     32      44.0        today's high wind gust
#   TwgustTM    33      14:28       time of today's high wind gust (hh:mm)
#   pressTH     34      999.8       today's high pressure
#   TpressTH    35      16:01       time of today's high pressure (hh:mm)
#   pressTL     36      998.4       today's low pressure
#   TpressTL    37      12:06       time of today's low pressure (hh:mm)
#   version     38      1.8.2       Cumulus version
#   build       39      459         Cumulus build no
#   rmaxgust    40      1.6         Recent Max Gust
#   heatindex   41      76.2        Heat Index
#   humidex     42      24.9        Humidex Index
############################################################################

# What Mode are we running in:  returns cli if in CLI mode
$SITE['mode']           = php_sapi_name();
$SITE['passed']         = array();
if ($SITE['mode'] == "cli" ) {
    for( $i = 1; $i < $argc ; $i ++ ) {
        $SITE['passed'][] = $argv[$i];
    }
}
############################################################################
# Includes for JpGraph
############################################################################
include ($SITE['jpgraphloc'] . "jpgraph.php");
include ($SITE['jpgraphloc'] . "jpgraph_line.php");
include ($SITE['jpgraphloc'] . "jpgraph_bar.php");
include ($SITE['jpgraphloc'] . "jpgraph_radar.php");
include ($SITE['jpgraphloc'] . "jpgraph_canvas.php");
include ($SITE['jpgraphloc'] . "jpgraph_scatter.php");
############################################################################
# COMMON FUNCTIONS
############################################################################

// sets the time string to 12 hour format including am or pm

function timeto12($inval) {
    $ckval = intval($inval);
    $wm = "am";
    if($ckval == 12) {
        $wm = "pm";
    }
    if($ckval > 12 ) {
        $ckval -= 12;
        $wm="pm";
    }
    return($ckval . $wm);
}

// Checks to see if level was passed as an argument

function check_level() {
    global $SITE;

    $doit = 0;
    if ($SITE['mode'] == "cli" ) {
        $val = get_cli_passed("level");
        list($what,$with) = split("=",$val);
        if ($what == "level" ) {
            $doit = 1;
            $val = intval($with);
        }
    } 
                
    if ( isset($_GET['level']) ) {
        $val = intval($_GET['level']);
        $doit = 1;
    }
    
    if ($doit) {
        
        if ($val > 3 ) {
            $val = 0;
        }
        
        if ($val == 1 ) {
            $SITE['hrs'] = 24;
            $SITE['tick']= 4;
        }
        
        if ($val == 2 ) {
            $SITE['hrs'] = 72;
            $SITE['tick']= 6;
        }   
        if ($val == 3 ) {
            $SITE['hrs'] = 168;
            $SITE['tick']= 8;
        }   
    }
}

// Checks to see if freq was passed as an argument

function check_freq () {
    global $SITE;
    
    $doit = 0;
    if ($SITE['mode'] == "cli" ) {
        $val = get_cli_passed("freq");
        list($what,$with) = split("=",$val);
        if ($what == "freq" ) {
            $doit = 1;
            $val = intval($with);
        }
    } 
        
    if ( isset($_GET['freq']) ) {
        $val = intval($_GET['freq']);
        $doit = 1;
    }   
    
    if ($doit) {
        if ($val > 3 ) {
            $val = 0;
        }
        
        if ($val == 1 ) {
            $SITE['freq'] = 1;
            $SITE['hrs'] = $SITE['hrs'] * 2;
            $SITE['tick'] = $SITE['tick'] * 2;
        }
        
        if ($val == 2 ) {
            $SITE['freq'] = 2;
            $SITE['hrs'] = $SITE['hrs'] * 4;
            $SITE['tick'] = $SITE['tick'] * 4;
        }
		
		if ($val == 3 ) {
            $SITE['freq'] = 3;
            $SITE['hrs'] = $SITE['hrs'] * 4;
            $SITE['tick'] = $SITE['tick'] * 10;
        }
    }   
}

// Checks to see if freq was passed as an argument

function check_info () {
    global $SITE;
    
    $doit = 0;
    if ($SITE['mode'] == "cli" ) {
        $val = get_cli_passed("info");
        list($what,$with) = split("=",$val);
        if ($what == "info" && $with == $SITE['infopass']) {
            $doit = 1;
        }
    }    
    
    if ( isset($_GET['info']) && $_GET['info'] == $SITE['infopass'] ) {
        $doit = 1;

    }   
    
    if ($doit) {
        $SITE['info'] = ( $SITE['info'] == 0 ) ? 1 : 0;     
    }
}

// Sets the servers idea of timezone

function set_tz ($TZ){
    if (phpversion() >= "5.1.0") {
        date_default_timezone_set($TZ);
    } else {
        putenv("TZ=" . $TZ);
    }
}

function check_debug() {
    global $SITE;
    
    if ($SITE['mode'] == "cli" ) {
        $val = get_cli_passed("debug");
        list($what,$with) = split("=",$val);
        if ($what == "debug" && $with == $SITE['debugpass']) {
            $SITE['debug'] = 1;
        }
    }    
    
    if ( isset($_GET['debug']) && $_GET['debug'] == $SITE['debugpass'] ) {
        $SITE['debug'] = 1;
    }
    
    if ($SITE['debug']) {
        debug_out("DEBUG TURNED ON");
        debug_out("Script is running in: " . $SITE['mode'] . " mode");
        debug_out("Server Path: " . $_SERVER['DOCUMENT_ROOT']);
        debug_out("Request URI: " . $_SERVER['REQUEST_URI']);
        debug_out("Server Name: http://" . $_SERVER['SERVER_NAME']);
        debug_out("PHP Self: " . $_SERVER['PHP_SELF']);
        debug_out("Path is set to: " . getcwd());
        debug_out("JpGraph is set to: " . $SITE['jpgraphloc']);
    }
}

function check_dataview () {
    global $SITE;
    
    if ($SITE['mode'] == "cli" ) {
        $val = get_cli_passed("dataview");
        list($what,$with) = split("=",$val);
        if ($what == "dataview" && $with == $SITE['datapass']) {
            $filenameReal = __FILE__;
            readfile($filenameReal);
            exit;
        }
    }
        
    if ( isset($_GET['dataview']) && $_GET['dataview'] == $SITE['datapass'] ) {
        $filenameReal = __FILE__;
        $download_size = filesize($filenameReal);
        header('Pragma: public');
        header('Cache-Control: private');
        header('Cache-Control: no-cache, must-revalidate');
        header("Content-type: text/plain");
        header("Accept-Ranges: bytes");
        header("Content-Length: $download_size");
        header('Connection: close');
        readfile($filenameReal);
        exit;
    }
}

// Function obtains the passed variable to the script
// when used in CLI mode.

function get_cli_passed($variable) {
    global $SITE;
    
    foreach ( $SITE['passed'] as $value) {
        list($code,$val) = split("=",$value);
        if ( strtolower($code) == $variable) {
            return($code . "=" . $val);
        }
    }
}

function debug_out($mesg){
    global $SITE;
    
    if ($SITE['debug']) {
        echo "DEBUG> " . $mesg ;
        if ($SITE['mode'] == "cli") {
            echo "\n";
        } else {
            echo "<br/>";
        }
    }
}

function debug_out_pre($mode) {
    global $SITE;
    
    if ($SITE['debug'] && $SITE['mode'] != "cli") {
        echo ($mode == 1 ) ? "<pre>" : "</pre>";
    }
}

function ret_value($lookup) {
	global $SITE, $DATA;
	
	$rtn = array_search  ( $lookup  , $SITE['cvalues'] );
	
	if ($rtn !== FALSE) {
		return( $DATA[$rtn] );
	} else {
		return("-");
	}
}

function freq_check($min) {
	global $SITE, $DATA;

    $getit = 0;
    if ($SITE['freq'] == 0) {
        if ($min == "00" ) {
            $getit = 1;
            debug_out("Matched Freq 0");              
        }
    }
    
    if ($SITE['freq'] == 1) {
        if ($min == "00" || 
        	$min == "30") {
            $getit =1;
            debug_out("Matched Freq 1");              
        }
    }

    if ($SITE['freq'] == 2) {
        if ($min == "00" || 
        	$min == "30" ||
        	$min == "15" || 
        	$min == "45" ) {
            $getit = 1;
            debug_out("Matched Freq 2");               
        }
    }
	if ($SITE['freq'] == 3) {
        if ($min == "00" || 
        	$min == "06" ||
        	$min == "12" || 
			$min == "18" || 
        	$min == "24" ||
        	$min == "30" ||
			$min == "36" || 
        	$min == "42" ||
        	$min == "48" ||
        	$min == "54" ) {
            $getit = 1;
            debug_out("Matched Freq 3");               
        }
	}
	return($getit);
}
	   
############################################################################
# END OF SCRIPT
############################################################################
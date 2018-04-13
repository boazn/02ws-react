<?php

function time_callback($aLabel) { 
    
	if (Date('H', $aLabel) == 0)
		return "\n".Date('j/n', $aLabel);
	return Date('H', $aLabel);
		
} 
$datedelimiter = "-";
$key_split = "/ +/";
if ($_GET['datasource'] != "")
{
	$key_split = "/,/";
	$datedelimiter = "/";
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
include_once("../../include.php");
$height = 300;
if ($width == 0)
    $width = 550;
$lang_idx = $_GET['lang'];
if ($lang_idx == "")
	$lang_idx = 1;
$SITE['version']        = "3.1";
$SITE['hloc']           = "../../";
$SITE['jpgraphloc']     = "../../jpgraph/";
$SITE['datafile']       = "reports/".$_GET['datasource'];
$SITE['sitename']       = "02ws.co.il ".utf8_strrev("ירושמיים");
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
$SITE['cvalues'] = array("date", "time", "temp","temp2","temp3","hum","windspd","winddir","thw","thw2","HeatIndex", "uv", "solarradiation", "pm10", "pm25", "Dew", "Rain" ,"Bar", "RainRate");
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
$resultarichive = db_init("select date, time, temp,temp2,temp3,hum,windspd,winddir,thw,thw2,HeatIdx, uv, solarradiation, pm10, pm25, Dew, Rain, Bar, RainRate from  `archivelatest` order by ID Desc", "");
$rawdata = array();
while ($line = $resultarichive["result"]->fetch_array(MYSQLI_ASSOC)) {
    array_push($rawdata, $line);
}
############################################################################

############################################################################
# Reference: Format of LatestArchive.csv file
############################################################################
#   Field               Pos     Example     Description
#   ReceiverRecID        0       1
#   ChannelIndex         1       1
#   RecDateTime          2		 21/12/2015 17:40:00	
#   TempOut				 3       536          
#   HiTempOut            4       536        
#   LowTempOut           5       536        
#   HumOut			     6       78         
#   DewPoint			 7       536         
#   HeatIndex			 8       536        
#   IntervalIndex        9       0       
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
include( $SITE['jpgraphloc'] . "jpgraph_date.php" );
include ($SITE['jpgraphloc'] . "jpgraph_bar.php");
include ($SITE['jpgraphloc'] . "jpgraph_radar.php");
include ($SITE['jpgraphloc'] . "jpgraph_canvas.php");
include ($SITE['jpgraphloc'] . "jpgraph_scatter.php");
include ($SITE['jpgraphloc'] . "jpgraph_utils.inc.php");
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
		if ($val == 4 ) {
            $SITE['hrs'] = 720;
            $SITE['tick']= 10;
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
            $SITE['hrs'] = $SITE['hrs'] * 6;
            $SITE['tick'] = $SITE['tick'] * 6;
        }
		
		if ($val == 3 ) {
            $SITE['freq'] = 3;
            $SITE['hrs'] = $SITE['hrs'] * 10;
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
	return( $DATA[$lookup] );
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
        	$min == "10" ||
			$min == "20" ||
			$min == "30" ||
        	$min == "40" || 
        	$min == "50" ) {
            $getit = 1;
            debug_out("Matched Freq 2");               
        }
    }
	if ($SITE['freq'] == 3) {
        if ($min == "00" || 
        	$min == "05" ||
        	$min == "10" || 
			$min == "15" || 
        	$min == "20" ||
        	$min == "25" ||
			$min == "30" || 
        	$min == "35" ||
			$min == "40" ||
			$min == "45" || 
        	$min == "50" ||
        	$min == "55" ) {
            $getit = 1;
            debug_out("Matched Freq 3");               
        }
	}
	return($getit);
}
	   
############################################################################
# END OF SCRIPT
############################################################################
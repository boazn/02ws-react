<?php
############################################################################
# A Project of TNET Services, Inc.
############################################################################
#
#   Project:    Cumulus Project 
#   Package:    Cumulus Weather Logging
#   Module:     realtimelog.php
#   Version:    2.0 - October 17th, 2008
#   Purpose:    This script should be called from cron or some type of
#               scheduling system once a minute to extract out the
#               contents of the current realtime.txt file and store
#               it in a logfile.
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
#   1.0     Released October 10th, 2008
#           Initial Release
#
#   2.0     Released October 17th, 2008
#           This version works with N lengthed output from the realtime.txt
#           file so that if it is expanded, it simply starts logging the
#           expanded variables.
#
############################################################################
#   This document uses Tab 4 Settings
############################################################################
$DATA   = array();
$SITE   = array();
check_sourceview();
############################################################################
# CONFIGURATION INFORMATION
############################################################################
# NOTES
#
# The home should point to your webservers home directory.
#
# The datafile MUST exist and MUST be chmod 0666 to work as the webserver
# Needs to have permission to write to this file.
#
# The source should point to the realtime.txt file that you are uploading
# to your server.  You should be uploading this at least once a minute
#
# This script should be called via cron or similar scheduler. It must be
# called using PHP CLI... so that it can collect the data properly.
#
# A sample cron entry would look like:
#
# * * * * * php /path_to_your_webroot/realtimelog.php > /dev/null 2>&1
#
# You may need to chmod the realtimelog.php script to 0755.
#
############################################################################
include('include.php');
include_once("start.php");
include_once("requiredDBTasks.php");
include_once "sigweathercalc.php";
$SITE['version']        = "2.0";
$SITE['home']           = "/home/boazn/public/02ws.com/public";
$SITE['datafile']       = "realtimembmysql.txt";
$SITE['source']         = "realtime.txt";
#---------------------------------------------------------------------------
$SITE['debug']          = 0;
############################################################################
check_debug();
ini_set("display_errors","On");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
$array_pm = @array_map('str_getcsv', @file("getAveragePM10.txt"));
$pm10 = $array_pm[0][0];
$pm25 = $array_pm[0][2];


// Change directory to home so that we know where we are

if ($SITE['debug']) {
    echo "Current directory is: " . getcwd() . " <br/>\n";
    echo "Changing directory to: " . $SITE['home'] . " <br/>\n";
}

if ($SITE['home'] != "YOU MUST SET THIS") {
    chdir($SITE['home']);
} else {
    echo "You have not set the home directory<br/>";
    exit;
}

if ($SITE['debug']) {
    echo "Current directory is: " . getcwd() . " <br/>\n";
}

$fp = fopen( $SITE['datafile'] , 'w+' );
if ($fp) {
    
    // Collect all the fields into the variable $info
    $info = "Call SaveArchiveDaily (";     # Empty info field
    $first = 1;     # Flag for first variable
	$last_key = end(array_keys($_GET));
    foreach($_GET as $key => $value)
    {
       echo '<br />Key = ' . $key . ' ';
       echo 'Value= ' . $value;
       $info .= "'".$value."', ";
	   
    }
	$info .= $pm10.", ".$pm25.", ".$seasonTillNow->get_raindiffav();
    $info .= ")\n";
    if (fileIsNew())
	{
		// If debug, display what we ended up with
		
		if ($SITE['debug']) {
			echo "Saving Data as: " . $info . "<br/>\n";
		}    
		
		// Write the data
		echo "<br />".$info;
		fwrite($fp, $info . "\n" ) ;
		fclose($fp);
		
	}
	else
	{
			// If debug, display what we ended up with
		
		if ($SITE['debug']) {
			echo "Data file is not new <br/>\n";
		} 
                // Write the data
		echo "<br />".$info;
		fwrite($fp, $info . "\n" ) ;
		fclose($fp);
		
	}
} else {
    
    // Opps... we had an error opening the file
    
    if ($SITE['debug']) {
        echo "UNABLE TO SAVE DATA - CHECK PERMISSIONS <br/>\n";
    }   
    echo "Unable to open file<br/>";
}
logger($info);
db_init($info, "");

if ($SITE['debug']) {
    echo "COMPLETE<br/>\n";
}   
// We are done
exit;

function fileIsNew()
{
	global $SITE;
	if (@filemtime($SITE['source']) > @filemtime($SITE['datafile']))
		return true;
	else
		return false;
}

function check_debug () {
    global $SITE;
    
    if ( isset($_GET['debug']) ) {
        $SITE['debug'] = 1;
        echo "DEBUG MODE ON<br/>\n";
    }
}

function check_sourceview () {
    global $SITE;
    
    if ( isset($_GET['view']) && $_GET['view'] == 'sce' ) {
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
############################################################################
#   END OF MODULE
############################################################################
<?php
############################################################################
# A Project of TNET Services, Inc.
############################################################################
#                     E X P E R I M E N T A L   C O D E
############################################################################
#   Project:    Cumulus Project 
#   Package:    StandAlone
#   Module:     rotate_realtime.php
#   Version:    0.1 - 2012-05-20
#   Authors:    Kevin W. Reed <weather@tnet.weather.com>
#               TNET Services, Inc.
#   Copyright:  (c) 1992-2012 Copyright TNET Services, Inc.
# 
#   Purpose:
#       Reads the current realtime.log file and Finds all the months 
#       data in it. Then it creates archives of the Non-current months 
#       data, and ends up rewriting the realtime.log with only the 
#       current months data.
#
#       Supports both CLI and Web execution.
#
#       Note: that it also creates a backup file of the realtime.log
#       before changes were made. realtime.bak in the archive dir.
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
# WARNING: NOT USING CENTRAL CONFIG FILE
############################################################################
# Load Config file for common settings and functions
############################################################################
//error_reporting(E_ALL);
//ini_set('display_errors', True);
############################################################################
$SITE = array(); $Start = getTime();
$SITE['program']        =   'rotate_realtime.php';
$site['version']        =   '0.1 - 2012-05-20';
############################################################################
# DEFINE YOUR ENVIRONMENT HERE
############################################################################
$SITE['timezone']       =   'Asia/Jerusalem';
$SITE['realtime_log']   =   '/home/boazn/public/02ws.com/public/realtime.log';
$SITE['archive_dir']    =   '/home/boazn/public/02ws.com/public/archives/';
$SITE['codeval']        =   intval('SET_ME_PLEASE');

############################################################################
# SHOULD NOT NEED TO CHANGE ANYTHING BELOW HERE.
############################################################################
date_default_timezone_set($SITE['timezone']);
// What mode are we running in?
$SITE['mode']           = php_sapi_name();
// Variable to hold passed data if in CLI mode
$SITE['passed']         = array();
if ($SITE['mode'] == "cli" ) {
    $SITE['LF'] = chr(10);
    for( $i = 1; $i < $argc ; $i ++ ) {
        $SITE['passed'][] = $argv[$i];
    }
} else {
    $SITE['LF'] = "<br/>".chr(10);
}

$current_month = date('Y-m');
$found_dates = array();
$LF = $SITE['LF'];

// SECURITY CHECK! ... We don't want anyone just running this
// from the web... so we will look for a passed code value
// However, if we are running in CLI mode, they can't be doing that
// so we will ignore it.

if ($SITE['mode'] != "cli" ) {
    if( !isset($_GET['code'] ) ) {
        echo "You are not authorized to use this script<br/>";
        exit;
    }
    if( intval($_GET['code']) != $SITE['codeval'] ) {
        echo "You are not authorized to use this script<br/>";
        exit;
    }
}

############################################################################
# LETS GET STARTED...
############################################################################
echo "We are running in [" . $SITE['mode'] . "] mode" . $LF . $LF;
echo "Current Month = " . $current_month . $LF;

// read the log to see what we have
$raw = file($SITE['realtime_log']);

$total_records = count($raw) -1;
if ($total_records < 50) {
    echo "Only " . $total_records . 
        " records found... not really enough to mess with" . $LF;
    exit;
}

// Now obtain what dates are in the logfile
foreach($raw as $k => $v) {
    $fdate = substr($v,0,7);
    $found_dates = date_match($fdate,$found_dates);
}
asort($found_dates);

// Display what we found
echo $LF . "Dates Found in Data File:" . $LF ;
foreach($found_dates as $key => $v) {
    echo "Found Date: " . $v;
    if ($v == $current_month) {
        echo " - Current Month Will Keep";
    }
    echo $LF;
}
echo $LF;

// Create a backup file of the data first
$filename = $SITE['archive_dir'] . "realtimelog.bak";
echo "Saving Backup to " . $filename .  $LF;
$fp = fopen($filename, "w");
if ($fp) {
    foreach($raw as $kk => $vv) {
        if ( substr($vv,0,7) == $v ) {
            fwrite($fp,$vv);    
        }
    }
    fclose($fp);
} else {
    echo "ERROR: Unaable to Open [". $filename . "]" . $LF;
}

// Now Write out archives of older data and rewrite the
// current log file with only this current months data
foreach($found_dates as $key => $v) {
    if($v == $current_month) {
        echo "Saving realtimel.log with current month info" . $LF;
        $filename = $SITE['realtime_log'];
    } else {
        echo "Saving Archive " . $SITE['archive_dir'] . $v . ".log" . $LF;
        $filename = $SITE['archive_dir'] . $v . ".log";
    }   
    $fp = fopen($filename, "w");
    if ($fp) {
        foreach($raw as $kk => $vv) {
            if ( substr($vv,0,7) == $v ) {
                fwrite($fp,$vv);    
            }
        }
        fclose($fp);
    } else {
        echo "ERROR: Unaable to Open [". $filename . "]" . $LF;
    }
}

// We be done... get the time and tell how long this took.
$End = getTime();
echo $LF . "Completed - Time taken = " .
    number_format(($End - $Start),2)." secs" . $LF;

############################################################################
# FUNCTIONS
############################################################################

function date_match($ckdate, $found_dates) {
    
    if ( array_search( $ckdate, $found_dates) === FALSE) {
        $found_dates[] = $ckdate;
    }
    return($found_dates);
}

function getTime() {
    $a = explode (' ',microtime());
    return(double) $a[0] + $a[1];
}

############################################################################
# END OF MODULE
############################################################################
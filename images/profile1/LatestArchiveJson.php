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
ini_set("display_errors","On");
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
$limit = empty($_GET['limit']) ? 10000 : $_GET['limit'];

$resultarichive = db_init("select date, time, temp,temp2,temp3,hum,windspd,winddir,thw,thw2,HeatIdx, uv, solarradiation, pm10, pm25, Dew, Rain, Bar, RainRate from  `archivelatest` order by ID Desc limit 0,".$limit, "");
$temp = array();
$temp2 = array();
$temp3 = array();
$windspd = array();
$winddir = array();
$thw = array();
$thw2 = array();
$HeatIdx = array();
$uv = array();
$solarradiation = array();
$pm10 = array();
$pm25 = array();
$Dew = array();
$Rain = array();
$Bar = array();
$RainRate = array();
while ($line = $resultarichive["result"]->fetch_array(MYSQLI_ASSOC)) {
    array_push($temp, array('x' => $line["date"]." ".$line["time"], 'y' => $line["temp"]));
    array_push($temp2, array('x' => $line["date"]." ".$line["time"], 'y' => $line["temp2"]));
    array_push($temp3, array('x' => $line["date"]." ".$line["time"], 'y' => $line["temp3"]));
    array_push($windspd, array('x' => $line["date"]." ".$line["time"], 'y' => $line["windspd"]));
    array_push($winddir, array('x' => $line["date"]." ".$line["time"], 'y' => $line["winddir"]));
    array_push($HeatIdx, array('x' => $line["date"]." ".$line["time"], 'y' => $line["HeatIdx"]));
    array_push($uv, array('x' => $line["date"]." ".$line["time"], 'y' => $line["uv"]));
    array_push($solarradiation, array('x' => $line["date"]." ".$line["time"], 'y' => $line["solarradiation"]));
    array_push($pm10, array('x' => $line["date"]." ".$line["time"], 'y' => $line["pm10"]));
    array_push($pm25, array('x' => $line["date"]." ".$line["time"], 'y' => $line["pm25"]));
    array_push($Dew, array('x' => $line["date"]." ".$line["time"], 'y' => $line["Dew"]));
    array_push($Rain, array('x' => $line["date"]." ".$line["time"], 'y' => $line["Rain"]));
    array_push($Bar, array('x' => $line["date"]." ".$line["time"], 'y' => $line["Bar"]));
    array_push($RainRate, array('x' => $line["date"]." ".$line["time"], 'y' => $line["RainRate"]));
}
$rawdata = array();
array_push($rawdata, array('id' => 'temp', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $temp));
array_push($rawdata, array('id' => 'temp2', 'color' =>  'hsl(227, 70%, 50%)', 'data' => $temp2));
/*array_push($rawdata, array('id' => 'temp3', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $temp3));
array_push($rawdata, array('id' => 'windspd', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $windspd));
array_push($rawdata, array('id' => 'winddir', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $winddir));
array_push($rawdata, array('id' => 'HeatIdx', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $HeatIdx));
array_push($rawdata, array('id' => 'uv', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $uv));
array_push($rawdata, array('id' => 'solarradiation', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $solarradiation));
array_push($rawdata, array('id' => 'pm10', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $pm10));
array_push($rawdata, array('id' => 'pm25', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $pm25));
array_push($rawdata, array('id' => 'Dew', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $Dew));
array_push($rawdata, array('id' => 'Rain', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $Rain));
array_push($rawdata, array('id' => 'Bar', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $Bar));
array_push($rawdata, array('id' => 'RainRate', 'color' =>  'hsl(247, 70%, 50%)', 'data' => $RainRate));*/
$json_pretty = json_encode($rawdata);
echo  $json_pretty;
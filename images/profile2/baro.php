<?php
#############################################################################
# A Project of TNET Services, Inc.
############################################################################
#
#   Project:    Cumulus Project 
#   Package:    Cumulus Weather JpGraph Graphs
#   Module:     baro.php
#   Purpose:    Baro Graph Script
#   Version:    3.1 - October 26th, 2008
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
#   1.2.1   Released Oct 14th, 2008
#           Modifications for JpGraph for old Pos() calls and
#           unsupported SetAntiAliasing()
#
#	2.0		Internal Version
#
#	3.0		Released Oct 19th, 2008
#			Modifications to match 1.8.2 Beta which extended
#			The number of fields in realtime.txt includes
#			rebuild of data field access routines.
#
############################################################################
#   This document uses Tab 4 Settings
############################################################################
$DATA   = array();
$width = $_GET['w'];
if ($_GET['datasource'] != "")
	require_once("GraphSettings02ws.php");
	else
	require_once("GraphSettings.php");
global  $SITE;
############################################################################
$SITE['hrs']            = 72;       # Adjustable via level
$SITE['tick']           = 4;        # Adjustable via level
$SITE['freq']           = 2;        # Adjustable via freq
############################################################################
# Check for passed variables
############################################################################
check_debug();      # Checks to see if Debug requested
check_level();      # Checks to see if level was passed to the script
check_freq();       # Checks to see if freq was passed to the script
check_info();       # Checks to see if info was passed
check_sourceview(); # Checks to see if Source View Was passed to the script
check_dataview();   # Checks to see if Data View Was passed to the script
set_tz( $SITE['tz'] );
############################################################################

// Load Contents of Realtime.log file

debug_out("obtaining data from: " . $SITE['hloc'] . $SITE['datafile']);

$rawdata = array_reverse( file($SITE['hloc'] . $SITE['datafile']));

debug_out("Obtained " . count($rawdata));
debug_out("Want to obtain " . $SITE['hrs']);

$wanted = $SITE['hrs'];
$got = 0;

$x = array();
$y1 = array();
$y2 = array();

debug_out("Starting Array Sweep");

foreach($rawdata as $key) {
    if ($got < $wanted) {
    	
    	$DATA = preg_split($key_split, $key);
		
		debug_out("date=".ret_value("date"));
		$timeA = explode(':',ret_value("time"));
		
        if (freq_check($timeA[1])) {
            debug_out("Storing data");
            debug_out("Xaxis = " . $timeA[0].":".$timeA[1]);
            debug_out("Yaxis = " . ret_value("dew") );
           $dateArray = explode($datedelimiter,$DATA[0]);
			if ($_GET['datasource'] != "")
			{
				$dateday = $dateArray[0];
				$datemon = $dateArray[1];
				$dateyear = $dateArray[2];
			}
			else
			{
				$dateday = $dateArray[2];
				$datemon = $dateArray[1];
				$dateyear = $dateArray[0]-2000;
			}
			$ts = mktime($timeA[0], $timeA[1], 0, $datemon , $dateday, $dateyear+2000);
            debug_out("ts = ".$ts);
			debug_out("date = ".Date('H:i j/m', $ts));
            $rx[] =  $ts;
            $ry1[] =  ret_value("press");
            $ry2[] = ret_value("wspeed");
 
            $SITE['tempunit'] 	= "&#xb0;" . ret_value("tempunit");
            $SITE['pressunit'] 	= ret_value("pressunit");
            $SITE['rainunit'] 	= ret_value("rainunit");
            $SITE['windunit']	= ret_value("windunit");
	        $got++;
        }
    }
}
debug_out("Collected " . count($rx) . " records.");
debug_out("TempUnit = " . $SITE['tempunit'] );
debug_out("PressUnit = " . $SITE['pressunit'] );
debug_out("RainUnit = " . $SITE['rainunit'] );
debug_out("WindUnit = " . $SITE['windunit'] );
debug_out("Completed Array Sweep. Reversing Data");
   
$x = array_reverse($rx);
$y1 = array_reverse($ry1);
$y2 = array_reverse($ry2);

debug_out("Output of Xaxis Array");
debug_out_pre(1);
if ($SITE['debug']) {
    print_r($x);
}
debug_out_pre(0);

debug_out("Output of Y1axis Array");
debug_out_pre(1);
if ($SITE['debug']) {
    print_r($y1);
}
debug_out_pre(0);   

debug_out("Starting Graph Creation");

$graph = new Graph($width,$height);  
$graph->SetScale("datlin");
$graph->SetY2Scale("lin");
$graph->SetMarginColor($SITE['bgncolor']);
$graph->SetFrame(true,'#CDCABB',4);
$graph->img->SetMargin(49,40,10,55);

// Create the two linear plot
$lineplot=new LinePlot($y1, $x);
$lineplot2=new LinePlot($y2, $x);
// Set the colors for the plots
$lineplot->SetColor("blue");
$lineplot->SetWeight(2);
$lineplot->SetFillColor("lightblue@0.5");
$lineplot2->SetColor("lightgray");
$lineplot2->SetFillColor("lightgray@0.5");
$lineplot2->SetWeight(2);
// Add the plot to the graph
$graph->Add($lineplot);
$graph->AddY2($lineplot2);

// titles
$graph->title->SetFont(FF_ARIAL,FS_BOLD,8);
$graph->title->Set($SITE['sitename']);
$graph->title->SetColor("azure4");
$graph->title->SetPos(0.003,0.54,"left","top");

//x-axis

$graph->xaxis->SetColor($SITE['txtcolor']);
$graph->xaxis->SetLabelFormatCallback('time_callback');
$graph->xaxis->scale->SetTimeAlign(HOURADJ_1);
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,7);
$graph->xaxis->scale->ticks->Set(60*60, 30*60);
$graph->xgrid->Show();

//y-axis
$graph->yaxis->SetColor($SITE['txtcolor']);
$graph->yaxis->scale->SetGrace(10);
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,6);
$graph->yaxis->HideTicks(true,true);
$graph->yaxis->SetLabelFormat('%01.0f ' . "mb");

// Print Wording on graphic

$ws = $lang_idx == 1 ? utf8_strrev($WIND_SPEED[$lang_idx]." - ".$KNOTS[$lang_idx]) : $WIND_SPEED[$lang_idx]." - ".$KNOTS[$lang_idx];
$txtaa=new Text($ws);
$txtaa->SetFont(FF_ARIAL, FS_BOLD,15);
$txtaa->SetPos($width - 76,$height - 210,'center');
$txtaa->SetColor("black");
$graph->AddText($txtaa);

$chart_title = $BAR[$lang_idx]."/".$WIND_SPEED[$lang_idx];
if ($lang_idx == 1) $chart_title = utf8_strrev($chart_title);

$txt1=new Text($chart_title);
$txt1->SetFont( FF_ARIAL, FS_BOLD,29);
$txt1->ParagraphAlign('left');
$txt1->SetPos(0.11,0.93,"left","center");
$txt1->SetColor("azure4@0.6");
$graph->AddText($txt1);

$txt3=new Text(date("M j Y",time()));
$txt3->SetFont(FF_VERDANA, FS_BOLD,8);
$txt3->SetPos(0.8,0.015,"left","top");
$txt3->SetColor("azure4");
$graph->AddText($txt3);

// If Info is on, then display
// Chart Hours and Sample on graph

if ($SITE['info']) {
    $chrs = $SITE['hrs'];
    if ($SITE['freq'] == 0) {
        $fq = "Once an Hour";
    }
    if ($SITE['freq'] == 1) {
        $chrs = $chrs / 2;
        $fq = "Twice an Hour";
    }
    if ($SITE['freq'] == 2) {
        $chrs = $chrs /4;
        $fq = "4x an Hour";
    }
	if ($SITE['freq'] == 3) {
        $chrs = $chrs /4;
        $fq = "10x an Hour";
    }
    
    $txt4=new Text($chrs . " hr Chart");
    $txt4->SetFont(FF_VERDANA, FS_BOLD,6);
    $txt4->SetPos($width - 50,$height - 31,'center');
    $txt4->SetColor("azure4");
    $graph->AddText($txt4);
    
    
    $txt5=new Text($fq);
    $txt5->SetFont(FF_VERDANA, FS_BOLD,6);
    $txt5->SetPos($width - 50,$height - 22,'center');
    $txt5->SetColor("azure4");
    $graph->AddText($txt5);
}

// Display the graph
if (! $SITE['debug']) {
    $graph->Stroke();
} else {
    debug_out("Graph Creation complete.  Graph output suppresed due to debug");
}

exit;

############################################################################
# SourceView Function
############################################################################

function check_sourceview () {
    global $SITE;
    
    if ($SITE['mode'] == "cli" ) {
        $val = get_cli_passed("view");
        list($what,$with) = split("=",$val);
        if ($what == "view" && $with == $SITE['viewpass']) {
            $filenameReal = __FILE__;
            readfile($filenameReal);
            exit;
        }
    }
    
    if ( isset($_GET['view']) && $_GET['view'] == $SITE['viewpass'] ) {
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
# END OF SCRIPT
############################################################################

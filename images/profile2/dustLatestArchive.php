<?php
############################################################################
# A Project of TNET Services, Inc.
############################################################################
#
#   Project:    Cumulus Project 
#   Package:    Cumulus Weather JpGraph Graphs
#   Module:     temp.php
#   Purpose:    Temp Graph Script
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
#	2.0		Released Oct 18th, 2008
#			Modifications to match 1.8.2 Beta which extended
#			The number of fields in realtime.txt
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
	require_once("GraphSettingsLatestArchive.php");
	else
	require_once("GraphSettings.php");
	
global  $SITE;

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
$SITE['hrs']            = 4320;       # Adjustable via level
$SITE['tick']           = 1;        # Adjustable via level
$SITE['freq']           = 1;        # Adjustable via freq
############################################################################

// Load Contents of Realtime.log file
debug_out("obtaining data from: " . $resultarichive);


debug_out("Obtained " . count($rawdata));
debug_out("Want to obtain " . $SITE['hrs']);

$wanted = $SITE['hrs'];
$got = 0;

$x = array();
$y1 = array();
$y2 = array();
$maxval = 0;

debug_out("Starting Array Sweep");

foreach($rawdata as $key) {
        debug_out($key." ");
       $got++;
     if ($got <= $wanted && $got > 1) {
    	
    	$DATA = $key;
        
        debug_out("Storing data");
        //print_r($DATA);
        $current_date = ret_value("date");
        $pm10 = ret_value("pm10");
        $pm25 = ret_value("pm25");
        debug_out("Xaxis = " . $current_date);
        debug_out("Y1axis = " . $temp );
        debug_out("Y2axis = " . $hum );
        $dateRec = $current_date." ".ret_value("time");
        $datetime = DateTime::createFromFormat ("Y-m-d H:i:s", $dateRec);

        debug_out("datetime = " . $datetime->format('H:i j/m/y') );
        $ts = $datetime->getTimestamp();
        debug_out("ts = ".$ts);
        debug_out("date = ".Date('H:i j/m/y', $ts));
        $rx[] =  $ts;
        $ry1[] =  $pm10;
        $ry2[] = $pm25;

        $SITE['tempunit'] 	= "&#xb0;" . "C";
        $SITE['pressunit'] 	= "mb";
        $SITE['rainunit'] 	= "mm";
        $SITE['windunit']	= "kts";
        
        if ($got == 2){
           $least_date_title = $datetime->format('H:i j/m/y');
        }
        if ($got == $wanted){
            $date_title  = $datetime->format('H:i j/m/y')." - ".$least_date_title;
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

debug_out("Output of Y2axis Array");
debug_out_pre(1);
if ($SITE['debug']) {
    print_r($y2);
}
debug_out_pre(0); 

debug_out("Starting Graph Creation");
$graph = new Graph($width,$height);    
$graph->SetScale("datlin");
$graph->SetMarginColor($SITE['bgncolor']);
$graph->SetFrame(true,'#CDCABB',4);
$graph->img->SetMargin(45,40,20,55);

// Create the two linear plot
$lineplot=new LinePlot($y1, $x);
$lineplot2=new LinePlot($y2, $x);
// Set the colors for the plots
$lineplot->SetColor("green");
$lineplot->SetWeight(4);
$lineplot->SetFillColor("lightgreen@0.5");
$lineplot2->SetColor("darkgreen");
$lineplot2->SetFillColor("darkgreen@0.5");
$lineplot2->SetWeight(2);

// Add the plot to the graph
$graph->Add($lineplot);
$graph->Add($lineplot2);
$lineplot2->SetWeight(2);

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
$graph->yaxis->SetLabelFormat('%d ' );
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,7);
//$graph->yaxis->scale->SetGrace(5);
$graph->yaxis->HideTicks(false,false); 

// Print Wording on graphic

$txt2=new Text("cumulus");
$txt2->SetFont(FF_VERDANA, FS_BOLD,35);
$txt2->ParagraphAlign('left');
$txt2->SetPos(0.003,0.54,"left","center");
$txt2->SetColor("azure4@0.85");
$txt2->SetAngle(90);
$graph->AddText($txt2);

$chart_title = $DUST[$lang_idx];
if ($lang_idx == 1) $chart_title = utf8_strrev($chart_title);
$txt1=new Text($chart_title);
$txt1->SetFont(FF_ARIAL, FS_BOLD,29);
$txt1->ParagraphAlign('left');
$txt1->SetPos(0.11,0.93,"left","center");
$txt1->SetColor("azure4@0.6");
$graph->AddText($txt1);

$txt3=new Text(date("j/m/Y",time()));
$txt3->SetFont(FF_VERDANA, FS_BOLD,8);
$txt3->SetPos(0.8,0.015,"left","top");
$txt3->SetColor("azure4");
$graph->AddText($txt3);


$txtaa=new Text($chrs . "PM2.5");
$txtaa->SetFont(FF_VERDANA, FS_BOLD,12);
$txtaa->SetPos($width - 26,$height - 80,'center');
$txtaa->SetColor("darkgreen");
$graph->AddText($txtaa);


$txtab=new Text($chrs . "PM10");
$txtab->SetFont(FF_ARIAL, FS_BOLD,12);
$txtab->SetPos($width - 26,$height - 210,'center');
$txtab->SetColor("green");
$graph->AddText($txtab);

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
        $chrs = $chrs /6;
        $fq = "6x an Hour";
    }
	 if ($SITE['freq'] == 3) {
        $chrs = $chrs /10;
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
        
    if ( isset($_GET['view']) && $_GET['view'] == 'sce1' ) {
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
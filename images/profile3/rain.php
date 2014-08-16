<?php
############################################################################
# A Project of TNET Services, Inc.
############################################################################
#
#   Project:    Cumulus Project 
#   Package:    Cumulus Weather JpGraph Graphs
#   Module:     rain.php
#   Purpose:    Rain Graph Script
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
#   1.1     Released Oct 11h, 2008
#           Changed format of rain amounts to %0.1f
#
#   1.2     Released Oct 12th, 2008
#           Added Debugging Ability
#           Added CLI Capabilities
#           Added Info Display to Graphs
#           Added No Rain Text Message if there is no rain recorded.
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
#   Reference: Cumulus Format of realtime.txt file
############################################################################
$DATA   = array();
require_once("GraphSettings.php");
global  $SITE;
############################################################################
$SITE['hrs']            = 24;       # Adjustable via level
$SITE['tick']           = 2;        # Adjustable via level
$SITE['freq']           = 0;        # Adjustable via freq
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
$maxval = 0;

debug_out("Starting Array Sweep");

foreach($rawdata as $key) {
    if ($got < $wanted) {
    	
    	$DATA = preg_split('/ +/', $key);
        $timeA = explode(':',ret_value("time"));
        if (freq_check($timeA[1])) {
            debug_out("Storing data");
            debug_out("Xaxis = " . timeto12(substr(ret_value("time"),0,2)));
            debug_out("Y1axis = " . ret_value("rfall") );
            debug_out("Y2axis = " . ret_value("rmonth") );
            
            debug_out("data[0] = '".$DATA[0]."'");
            debug_out("data[1] = ".$DATA[1]);
            $dateArray = explode('-',$DATA[0]);
            $dateday = $dateArray[2];
            $datemon = $dateArray[1];
            debug_out("day = ".$dateday."/".$datemon);
            $rx[] = $timeA[0]."\n".$dateday."/\n".$datemon;
            $ry1[] = ret_value("rfall");
            $ry2[] = ret_value("rmonth");
 
            $SITE['tempunit'] 	= "&#xb0;" . ret_value("tempunit");
            $SITE['pressunit'] 	= ret_value("pressunit");
            $SITE['rainunit'] 	= ret_value("rainunit");
            $SITE['windunit']	= ret_value("windunit");
            
            if (ret_value("rfall") > $maxval ) {
                debug_out("Set MaxVal = " . ret_value("rfall"));
                $maxval = ret_value("rfall");
            }
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

debug_out("Output of Y2axis Array");
debug_out_pre(1);
if ($SITE['debug']) {
    print_r($y2);
}
debug_out_pre(0); 

debug_out("Starting Graph Creation");

$graph = new Graph($width,$height,"auto",30);    
$graph->SetScale("textlin");
$graph->SetY2Scale("lin");
$graph->SetMarginColor($SITE['bgncolor']);
$graph->SetFrame(true,'#CDCABB',4);
$graph->img->SetMargin(45,45,20,55);

// Create the two linear plot
$lineplot=new LinePlot($y1);
$lineplot2=new LinePlot($y2);

// Add the plot to the graph
$graph->Add($lineplot);
$graph->AddY2($lineplot2);
$lineplot2->SetWeight(2);

// titles
$graph->title->SetFont(FF_ARIAL,FS_BOLD,8);
$graph->title->Set($SITE['sitename']);
$graph->title->SetColor("azure4");
$graph->title->SetPos(0.003,0.54,"left","top");

//x-axis
$graph->xaxis->SetColor($SITE['txtcolor']);
$graph->xaxis->SetTickLabels($x);
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,6);
$graph->xaxis->SetTextLabelInterval($SITE['tick']);
$graph->xaxis->HideTicks(true,true); 
$graph->xaxis->SetPos("min"); 
$graph->xgrid->Show(true);

//y-axis
$graph->yaxis->SetColor($SITE['txtcolor']);
$graph->yaxis->SetLabelFormat('%01.0f ' . $SITE['rainunit']);
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,6);
//$graph->yscale->SetAutoMax(20);
$graph->yscale->SetAutoMin(0);
$graph->yaxis->scale->SetGrace(10);
$graph->yaxis->HideTicks(true,true); 

//y2-axis
$graph->y2axis->scale->ticks->Set(20);
$graph->y2axis->SetColor($SITE['txtcolor']);
$graph->y2axis->SetLabelFormat('%01.0f ' . $SITE['rainunit']);
$graph->y2scale->SetAutoMin(0);
$graph->y2axis->SetFont(FF_VERDANA,FS_NORMAL,6);
$graph->y2axis->HideTicks(true,true); 
$graph->y2grid->Show(true);

// Set the colors for the plots
$lineplot->SetColor("blue");
$lineplot->SetWeight(2);
$lineplot->SetFillColor("blue@0.5");
$lineplot2->SetColor("lightblue");
$lineplot2->SetFillColor("lightblue@0.5");
$lineplot2->SetWeight(2);


$chart_title = $RAIN[$lang_idx];
$txt1=new Text($lang_idx = 1 ? utf8_strrev($RAIN[$lang_idx]):$RAIN[$lang_idx]);
$txt1->SetFont( FF_ARIAL, FS_BOLD,29);
$txt1->ParagraphAlign('left');
$txt1->SetPos(0.11,0.92,"left","center");
$txt1->SetColor("azure4@0.6");
$graph->AddText($txt1);

// Print Wording on graphic

$txt2=new Text("cumulus");
$txt2->SetFont(FF_VERDANA, FS_BOLD,35);
$txt2->ParagraphAlign('left');
$txt2->SetPos(0.003,0.54,"left","center");
$txt2->SetColor("azure4@0.85");
$txt2->SetAngle(90);
$graph->AddText($txt2);
 
$txt3=new Text(date("M j Y",time()));
$txt3->SetFont(FF_VERDANA, FS_BOLD,8);
$txt3->SetPos(0.8,0.015,"left","top");
$txt3->SetColor("azure4");
$graph->AddText($txt3);

$lang_idx = $_GET['lang'];
if ($lang_idx == "")
	$lang_idx = 1;
// Place small monthly under right index
$monthly = $lang_idx == 1 ? utf8_strrev($MONTHLY[$lang_idx]) : $MONTHLY[$lang_idx];
$txtaa=new Text($chrs . $monthly);
$txtaa->SetFont(FF_ARIAL, FS_BOLD,10);
$txtaa->SetPos($width - 26,$height - 46,'center');
$txtaa->SetColor("lightblue");
$graph->AddText($txtaa);

// Place small daily under right index
$daily = $lang_idx == 1 ? utf8_strrev($DAILY_RAIN[$lang_idx]) : $DAILY_RAIN[$lang_idx];
$txtab=new Text($chrs . $daily);
$txtab->SetFont(FF_ARIAL, FS_BOLD,9);
$txtab->SetPos(40,$height - 42,'center');
$txtab->SetColor("blue");
$graph->AddText($txtab);

if ($maxval == 0 ) {
    debug_out("Output NO RAIN REPORTED");
    $txtn=new Text("NO RECENT RAIN");
    $txtn->SetFont(FF_VERDANA, FS_BOLD,18);
    $txtn->SetPos(0.5,0.4,"center","center");
    $txtn->SetColor("azure4@0.4");
    $graph->AddText($txtn);
}

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
    
    $txt4=new Text($chrs . " hr Chart");
    $txt4->SetFont(FF_ARIAL, FS_BOLD,6);
    $txt4->SetPos($width - 50,$height - 31,'center');
    $txt4->SetColor("azure4");
    $graph->AddText($txt4);
    
    
    $txt5=new Text($fq);
    $txt5->SetFont(FF_ARIAL, FS_BOLD,6);
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

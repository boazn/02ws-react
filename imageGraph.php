<?php
include_once ("include.php");
include ("jpgraph/jpgraph.php");
include ("jpgraph/jpgraph_bar.php");
//var_dump($GLOBALS);
//$rainarray = $_SESSION['rainarray'];
//$rainarray = $GLOBALS['rainarray'];

$rainarray = explode(" ", $_GET['rainarray']);
$timearray = explode(" ", $_GET['timearray']);

//var_dump($rainarray);
$datay = array_values($rainarray);
$datax = array_values($timearray);
// Create the graph. These two calls are always required
$graph = new Graph(920,400,"auto");    
$graph->SetScale("textlin");

// Add a drop shadow
//$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(35,30,10,60);
$graph->SetMarginColor("#304a5c");

// Create a bar pot
$bplot = new BarPlot($datay);

// Adjust fill color
$bplot->SetFillColor('navy');

// Setup values
$bplot->value->Show();
$bplot->value->SetFormat('%0.1f');
$bplot->value->SetAngle(90);
$bplot->value->SetFont(FF_FONT1,FS_NORMAL);
$bplot->SetValuePos('center');
//$bplot->SetShadow();
// Make the bar a little bit wider
//$bplot->SetWidth(0.7);

$bplot->SetLegend("mm");
$graph->legend->Pos(0.2, 0.5, "left", "center");
$graph->legend->SetFont(FF_FONT2,FS_NORMAL);

$bplot->SetFillGradient("navy","lightsteelblue",GRAD_HOR);
$bplot->SetWidth(1.0);
// Set color for the frame of each bar
$bplot->SetColor("navy");

$graph->Add($bplot);

// Setup the titles
$graph->title->Set($_GET['title']);
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->title->SetColor("white","white");

$graph->yaxis->title->Set($_GET['Ytitle']);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor("white","white");
$graph->yaxis->SetLabelAlign('center','top');
$graph->yaxis->scale->SetGrace(5);
$graph->yaxis->SetWeight(2);
$graph->ygrid->Show(true,true);
$graph->ygrid->SetFill(true,'#6699CC@0.5','#16435D@0.5');

$graph->xaxis->title->Set($_GET['Xtitle']);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor("white","white");
$graph->xaxis->SetColor("lightblue","white");
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAlign('center','top');
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetLabelSide(SIDE_DOWN);
$graph->xaxis->scale->SetGrace(10);
$graph->xaxis->HideTicks();
$graph->xaxis->SetTextLabelInterval(5);

$graph->SetAxisStyle(AXSTYLE_SIMPLE);
// Display the graph
$graph->Stroke();
?>
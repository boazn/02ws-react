<?php
include_once ("include.php");
include_once ("lang.php");
include ("jpgraph/jpgraph.php");
include ("jpgraph/jpgraph_bar.php");
$lang_idx = $_GET['lang_idx'];
$query = urldecode($_GET['query']);
$total =  $_GET['total'];
$width = $_GET['width'];
$query = str_replace ( "\'", "'", $query);
//echo $query;
//var_dump($GLOBALS);
//$rainarray = $_SESSION['rainarray'];
//$rainarray = $GLOBALS['rainarray'];
		

 		$result = db_init($query, "");
  
		$cpt=0;
 		while($row = mysqli_fetch_array($result["result"], MYSQLI_ASSOC))
		{	      
					 if ($lang_idx != 1) $value[]=get_name($row["field_name"]);
					 else
						$value[]=utf8_strrev(get_name($row["field_name"]));
    					$target[]=$row['count( * )']/$total*100;
			    		$cpt++;
		}
				
    $graph = new Graph($width,400,"auto");    
$graph->SetScale("textlin");
//var_dump($value);
//var_dump($target);
// Add a drop shadow
//$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(15,15,15,140);
$graph->SetMarginColor("#6387B3");

// Create a bar pot
$bplot = new BarPlot($target);

// Adjust fill color
$bplot->SetFillColor('#527094');

// Setup values
$bplot->value->Show();
$bplot->value->SetFormat('%d');
$bplot->value->SetAngle(0);
$bplot->value->SetFont(FF_ARIAL,FS_BOLD, 20);
$bplot->value->SetColor("#527094");
//$bplot->SetShadow();
// Make the bar a little bit wider
//$bplot->SetWidth(0.7);

$bplot->SetLegend("%");
$graph->legend->Pos(0.1, 0.12, "left", "center");
$graph->legend->SetFont(FF_ARIAL,FS_BOLD);

$bplot->SetFillGradient("#527094","white",GRAD_HOR);
$bplot->SetWidth(1.0);
// Set color for the frame of each bar
$bplot->SetColor("#527094");

$graph->Add($bplot);

// Setup the titles
$title=urldecode($_GET['title']);
if (($lang_idx == 1)&&(!stristr($title,"C"))) { $title=utf8_strrev($title);}
$graph->title->Set($title);
$graph->title->SetFont(FF_ARIAL,FS_BOLD, 16);
$graph->title->SetColor("white","white");

$graph->yaxis->title->Set("%");
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD, 20);
$graph->yaxis->SetColor("white","white");
$graph->yaxis->SetLabelAlign('center','top');
$graph->yaxis->scale->SetGrace(10);
$graph->ygrid->SetFill(true,'#E7F9FC@0.5','#CDD2DD@0.5');

$graph->xaxis->title->Set($_GET['Xtitle']);
$graph->xaxis->title->SetColor("white","white");
$graph->xaxis->SetFont(FF_ARIAL,FS_BOLD, 10);
$graph->xaxis->SetColor("lightblue","white");
$graph->xaxis->SetTickLabels($value);
$graph->xaxis->SetLabelAlign('center','top');
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->scale->SetGrace(10);
$graph->xaxis->HideTicks();
//$graph->SetAxisStyle(AXSTYLE_BOXOUT);
// Display the graph
$graph->Stroke();
?>
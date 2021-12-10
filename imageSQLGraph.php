<?php
include_once ("include.php");
include_once ("lang.php");
include ("jpgraph/jpgraph.php");
include ("jpgraph/jpgraph_bar.php");
$lang_idx = $_GET['lang_idx'];
$query = urldecode($_GET['query']);
$total =  $_GET['total'];
$width = $_GET['width'];
$email = $_REQUEST['email'];
//$query = str_replace ( "\'", "'", $query);
//echo $query;
//var_dump($GLOBALS);
//$rainarray = $_SESSION['rainarray'];
//$rainarray = $GLOBALS['rainarray'];
if ($_REQUEST['survey_id'] == 2)
{
	$query = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <=".$_REQUEST['temp_to']." AND temp >=".$_REQUEST['temp_from']." GROUP BY sf.field_name order by sf.field_id";
	$query_m = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <=".$_REQUEST['temp_to']." AND temp >=".$_REQUEST['temp_from']." AND gender = 'm' GROUP BY sf.field_name order by sf.field_id";
	$query_f = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <=".$_REQUEST['temp_to']." AND temp >=".$_REQUEST['temp_from']." AND gender = 'f' GROUP BY sf.field_name order by sf.field_id";
	$my_query_m = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <=".$_REQUEST['temp_to']." AND temp >=".$_REQUEST['temp_from']." AND gender = 'm' AND email='{$email}' GROUP BY sf.field_name order by sf.field_id";
	$my_query_f = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <=".$_REQUEST['temp_to']." AND temp >=".$_REQUEST['temp_from']." AND gender = 'f' AND email='{$email}' GROUP BY sf.field_name order by sf.field_id";
  $query = "call GetColdMeterFieldId({$_REQUEST['temp_from']}, {$_REQUEST['temp_to']}, '{$_REQUEST['g']}', '{$email}');";
}
else{
	$query = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id GROUP BY sf.field_name";
$query_m = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'm' GROUP BY sf.field_name";
$query_f = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'f' GROUP BY sf.field_name";
$my_query_m = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'm' AND email='{$email}' GROUP BY sf.field_name";
		$my_query_f = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'f' AND email='{$email}' GROUP BY sf.field_name";
	
		}
		if  ($_REQUEST['g'] == 'm'){
			$query = $query_m;
			if (!empty($_REQUEST['email']))
			$query = $my_query_m;
		}
		
		else if ($_REQUEST['g'] == 'f'){
			$query = $query_f;
			if (!empty($_REQUEST['email']))
			$query = $my_query_f;
		}

	


	
	
	
	//echo $query;


 		$result = db_init($query, "");
  
		$cpt=0;
 		while($row = mysqli_fetch_array($result["result"], MYSQLI_ASSOC))
		{	      
					 if ($lang_idx != 1) $value[]=get_name($row["field_name"]);
					 else
						$value[]=utf8_strrev(get_name($row["field_name"]));
    					$target[]=round($row['count( * )']/$total*100);
			    		$cpt++;
		}
				
    $graph = new Graph($width,400,"auto");    
$graph->SetScale("textlin");
//var_dump($value);
//var_dump($target);
// Add a drop shadow
//$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(25,25,25,145);
$graph->SetMarginColor("#ffffff");

// Create a bar pot
$bplot = new BarPlot($target);

// Adjust fill color
$bplot->SetFillColor('#527094');

// Setup values
$bplot->value->Show();
$bplot->value->SetFormat('%d%%');
$bplot->value->SetAngle(0);
$bplot->value->SetFont(FF_ARIAL,FS_BOLD, 9);
$bplot->value->SetColor("#527094");
//$bplot->SetShadow();
// Make the bar a little bit wider
//$bplot->SetWidth(0.7);

//$bplot->SetLegend("%");
//$graph->legend->Pos(0.02, 0.035, "left", "center");
//$graph->legend->SetFont(FF_ARIAL,FS_BOLD);

$bplot->SetFillGradient("#9eaec3","white",GRAD_HOR);
$bplot->SetWidth(0.9);
// Set color for the frame of each bar
$bplot->SetColor("#9eaec3");

$graph->Add($bplot);

// Setup the titles
$title=urldecode($_GET['title']);
if (($lang_idx == 1)&&(!stristr($title,"C"))) { $title=utf8_strrev($title);}
$graph->title->Set($title);
$graph->title->SetFont(FF_ARIAL,FS_BOLD, 13);
$graph->title->SetColor("black","black");
		
$graph->yaxis->title->Set("%");
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD, 13);
$graph->yaxis->SetColor("black","black");
$graph->yaxis->SetLabelAlign('center','top');
$graph->yaxis->scale->SetGrace(10);
$graph->ygrid->SetFill(true,'#FFFFFF@0.5','#FFFFFF@0.5');

$graph->xaxis->title->Set($_GET['Xtitle']);
$graph->xaxis->title->SetColor("black","black");
$graph->xaxis->SetFont(FF_ARIAL,FS_BOLD, 11);
$graph->xaxis->SetColor("black","black");
$graph->xaxis->SetTickLabels($value);
$graph->xaxis->SetLabelAlign('center','top');
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->scale->SetGrace(10);
$graph->xaxis->HideTicks();
//$graph->SetAxisStyle(AXSTYLE_BOXOUT);
// Display the graph
$graph->Stroke();
?>
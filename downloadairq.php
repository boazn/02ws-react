<?php
require('phpQuery.php');
$url="http://www.svivaaqm.net/DynamicTable.aspx?G_ID=14";
$local_file_path = "/home/boazn/public/02ws.com/public/cache/airq.html";
$output_airq_file_path = "/home/boazn/public/02ws.com/public/getAveragePM10.txt";
$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
$file = fopen($local_file_path,"w");
@fwrite ($file, $result);
@fclose ($file);
/***************** getAveragePM10 ***************/
$doc = phpQuery::newDocumentHTML(file_get_contents($local_file_path));
// 8 is the td of PM10
$bar_ilan = $doc["#C1WebGrid1 > tr:eq(2) > td:eq(8) > div"]->text();
$safra =  $doc["#C1WebGrid1 > tr:eq(4) > td:eq(8) > div"]->text();
$efrata =  $doc["#C1WebGrid1 > tr:eq(5) > td:eq(8) > div"]->text();
$even_ami = $doc["#C1WebGrid1 > tr:eq(6) > td:eq(8) > div"]->text();
$merkazit = $doc["#C1WebGrid1 > tr:eq(8) > td:eq(8) > div"]->text();
$stations = array($bar_ilan, $efrata, $even_ami, $merkazit);
$averagedPM10 = array_sum($stations)/count($stations);
$file = fopen($output_airq_file_path,"w");
@fwrite ($file, $averagedPM10);
@fclose ($file);
echo $averagedPM10;
?>

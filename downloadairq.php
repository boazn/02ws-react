<?php
require('phpQuery.php');
// Function to calculate standard deviation (uses sd_square)    
function sd($array) {
    // square root of sum of squares devided by N-1
    $sd = sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );
    return round($sd);
}
function cleanGarbageStations(&$array){
    if (count($array) < 2)
        return;
    if ($array[0] <= 0)
        echo "<br/>cleanGarbageStations: first=".$array[0]." --> removed ".array_shift($array);
     elseif ($array[count($array)-1] > 3 * $array[count($array)-2])
        echo "<br/>cleanGarbageStations: last=".$array[count($array)-1]." before last=".$array[count($array)-2]." --> removed ".array_pop($array);
     elseif (standard_deviation($array) > round(array_sum($array)/count($array)))
         echo "<br/>cleanGarbageStations: SD too high. last=".$array[count($array)-1]." before last=".$array[count($array)-2]." --> removed ".array_pop($array);
    
}
 function standard_deviation($aValues)
{
    $fMean = array_sum($aValues) / count($aValues);
    //print_r($fMean);
    $fVariance = 0.0;
    foreach ($aValues as $i)
    {
        $fVariance += pow($i - $fMean, 2);

    }       
    $size = count($aValues) - 1;
    $sd = (float) sqrt($fVariance)/sqrt($size);
    return round($sd);
}
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
$efrata =  $doc["#C1WebGrid1 > tr:eq(2) > td:eq(8) > div"]->text();
$bar_ilan = $doc["#C1WebGrid1 > tr:eq(3) > td:eq(8) > div"]->text();
$safra =  $doc["#C1WebGrid1 > tr:eq(9) > td:eq(8) > div"]->text();
$atarot = $doc["#C1WebGrid1 > tr:eq(10) > td:eq(8) > div"]->text();
$merkazit = $doc["#C1WebGrid1 > tr:eq(12) > td:eq(8) > div"]->text();


$stations = array(intval($efrata), intval($safra));
sort ($stations);
echo "pm10 before:";
print_r($stations);
cleanGarbageStations($stations);
$averagedPM10 = round(array_sum($stations)/count($stations));
$sdPM10 = standard_deviation($stations); 
echo "<br />";
print_r($stations);


$efrata =  $doc["#C1WebGrid1 > tr:eq(2) > td:eq(9) > div"]->text();
$bar_ilan = $doc["#C1WebGrid1 > tr:eq(3) > td:eq(9) > div"]->text();
$road1 = $doc["#C1WebGrid1 > tr:eq(8) > td:eq(9) > div"]->text();
$jerusalem16 = $doc["#C1WebGrid1 > tr:eq(11) > td:eq(9) > div"]->text();
$nayedet_merkazit = $doc["#C1WebGrid1 > tr:eq(12) > td:eq(9) > div"]->text();

$stations = array(intval($bar_ilan), intval($efrata), intval($nayedet_merkazit), intval($road1), intval($jerusalem16));
sort($stations);
echo "<br/>pm25 before:";
print_r($stations);
cleanGarbageStations($stations);
$averagedPM25 = round(array_sum($stations)/count($stations));
$sdPM25 = standard_deviation($stations);
echo "<br />";
print_r($stations);

$file = fopen($output_airq_file_path,"w");
@fwrite ($file, $averagedPM10.",".number_format($sdPM10, 1, '.', '').",".$averagedPM25.",".number_format($sdPM25, 1, '.', ''));
@fclose ($file);
echo "<br />".$averagedPM10.",".$sdPM10.",".$averagedPM25.",".$sdPM25;

?>

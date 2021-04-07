<pre>
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
     if (($array[count($array)-1] > 3 * $array[count($array)-2])&&(count($array) > 1))
        echo "<br/>cleanGarbageStations: last=".$array[count($array)-1]." before last=".$array[count($array)-2]." --> removed ".array_pop($array);
     if (standard_deviation($array) > round(array_sum($array)/count($array)))
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
$url="https://www.svivaaqm.net/dynamicTabulars/TabularReportTable?id=14";
$local_file_path = "/home/boazn/public/02ws.com/public/cache/airq2.txt";
$output_airq_file_path = "/home/boazn/public/02ws.com/public/getAveragePM10.txt";
$agent= 'Mozilla/4.0';

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
//echo  $result;
$file = fopen($local_file_path,"w");
fwrite ($file, $result);
fclose ($file);
/***************** getAveragePM10 ***************/
$doc = json_decode(file_get_contents($local_file_path), true);
//$doc_converted = $doc["TabularList"];
$doc_converted = str_replace('\"', '"', $doc["TabularList"]);

$stations_array =  json_decode($doc_converted);
print_r($stations_array);
//echo $stations_array[0]->shortName." ".$stations_array[0]->monitors[0]["name"]." ".$stations_array[0]->monitors[0]["value"];

// 8 is the td of PM10
$efrata =  $stations_array[1]->monitors[7]->value;
//$bar_ilan = $stations_array[1]["shortName"];
$safra =  $stations_array[2]->monitors[5]->value;
//$atarot = $stations_array[3]["shortName"];
//$merkazit = $stations_array[4]["shortName"];


$stations = array(intval($efrata), intval($safra));
sort ($stations);
echo "pm10 before:";
print_r($stations);
cleanGarbageStations($stations);
$averagedPM10 = round(array_sum($stations)/count($stations));
$sdPM10 = standard_deviation($stations); 
echo "<br />";
echo "pm10 after:";
print_r($stations);
echo "<br />";

$bar_ilan = $stations_array[0]->monitors[4]->value;
$efrata =  $stations_array[1]->monitors[8]->value;
$merkazit = $stations_array[3]->monitors[3]->value;
$nayedet_merkazit = $stations_array[4]->monitors[0]->value;
$dvora = $stations_array[6]->monitors[3]->value;

$stations = array(intval($efrata), intval($nayedet_merkazit), intval($merkazit), intval($dvora));
sort($stations);
echo "<br/>pm25 before:";
print_r($stations);
cleanGarbageStations($stations);
$averagedPM25 = round(array_sum($stations)/count($stations));
$sdPM25 = standard_deviation($stations);
echo "<br/>pm25 after:";
print_r($stations);

$file = fopen($output_airq_file_path,"w");
fwrite ($file, $averagedPM10.",".number_format($sdPM10, 1, '.', '').",".$averagedPM25.",".number_format($sdPM25, 1, '.', ''));
@fclose ($file);
echo "<br /><br />".$averagedPM10.",".$sdPM10.",".$averagedPM25.",".$sdPM25;

?>
</pre>
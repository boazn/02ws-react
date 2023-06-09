<pre>
<?php
ini_set('error_reporting', E_ERROR | E_PARSE);
require('phpQuery.php');
$local_file_path = "/home/boazn/public/02ws.com/public/cache/airq2.txt";
$output_airq_file_path = "/home/boazn/public/02ws.com/public/getAveragePM10.txt";
// Function to calculate standard deviation (uses sd_square) 
function connectToMANA ($station_id)
{
    
$auth = "555C14B9-C7E4-4AA2-9F01-0CA4B419CC35";
$auth2 = "Qm9hel9ZOk5uSlkyUzNi";
$envidatasource = "MANA";
$user = "Boaz_Y";
$pass = "NnJY2S3b";
$url="https://air-api.sviva.gov.il/v1/envista/stations?envi-data-source=".$envidatasource .
"&User".$user.
"&Password".$pass;
$url="https://air-api.sviva.gov.il/v1/envista/stations?envi-data-source=".$envidatasource .
"&User".$user.
"&Password".$pass;
$url="https://air-api.sviva.gov.il/v1/envista/stations/36/data/latest?envi-data-source=".$envidatasource .
"&User".$user.
"&Password".$pass;
$url="https://air-api.sviva.gov.il/v1/envista/stations/".$station_id."/data/latest?envi-data-source=".$envidatasource .
"&User".$user.
"&Password".$pass;
$data ='{"User":"'.$user.'","Password":"'.$pass.'", "envi-data-source":"'.$envidatasource.'"}';
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_USERAGENT => $agent,
    CURLOPT_VERBOSE => true,
    //CURLOPT_POSTFIELDS => $data,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERPWD => $user.":".$pass,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_CIPHER_LIST => "TLSv1.2",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
     CURLOPT_HTTPHEADER => [
        "accept-encoding: gzip, deflate, br",
        "Content-Type: application/json",
         "Authorization: Basic  ".$auth2
    ],
]);
$result=curl_exec($ch);
$apiMANA = json_decode($result);
//print_r($apiMANA);
if(curl_errno($ch)){
    print_r("<br/><br/>Error:".curl_error($ch));
}
//$stations_array =  $apiMANA ;
//echo "stations_array=".$stations_array;
//print_r($stations_array);
//print_r($stations_array[2]);
//print_r($stations_array[10]);
//echo "<br/>".$stations_array[2]->shortName." ".$stations_array[2]->monitors[7]->name." ".$stations_array[2]->monitors[7]->value;

//echo "<br/>".$stations_array[10]->shortName." ".$stations_array[10]->monitors[7]->name." ".$stations_array[10]->monitors[7]->value;
$file = fopen($local_file_path,"w");
fwrite ($file, $result);
fclose ($file);
echo "<br/>ID:".$apiMANA->stationId." ".$apiMANA->data[0]->channels[3]->name." ".$apiMANA->data[0]->channels[3]->value;
return $apiMANA;
}
function connectToWL () {
    /****************************************
Example showing API Signature calculation
for an API call to the /v2/current/{station-id}
API endpoint
****************************************/

/*
Here is the list of parameters we will use for this example.
*/
$parameters = array(
    "api-key" => "dgtkonlpbchqemr0lv9vxrbyddacgtq4",
    "api-secret" => "lmvgqnccvsy63jtdsejlzlkgqxxpbjnb",
    "station-id" => "18595", // this is an example station ID, you need to replace it with your real station ID which you can retrieve by making a call to the /stations API endpoint
    "t" => time()
  );
  
  /*
  Now we will compute the API Signature.
  The signature process uses HMAC SHA-256 hashing and we will
  use the API Secret as the hash secret key. That means that
  right before we calculate the API Signature we will need to
  remove the API Secret from the list of parameters given to
  the hashing algorithm.
  */
  
  /*
  First we need to sort the paramters in ASCII order by the key.
  The parameter names are all in US English so basic ASCII sorting is
  safe.
  */
  ksort($parameters);
  
  /*
  Let's take a moment to print out all parameters for debugging
  and educational purposes.
  */
  foreach ($parameters as $key => $value) {
    echo "Parameter name: \"$key\" has value \"$value\"\n";
  }
  
  /*
  Save and remove the API Secret from the set of parameters.
  */
  $apiSecret = $parameters["api-secret"];
  unset($parameters["api-secret"]);
  
  /*
  Iterate over the remaining sorted parameters and concatenate
  the parameter names and values into a single string.
  */
  $data = "";
  foreach ($parameters as $key => $value) {
    $data = $data . $key . $value;
  }
  
  /*
  Let's print out the data we are going to hash.
  */
  echo "Data string to hash is: \"$data\"\n";
  
  /*
  Calculate the HMAC SHA-256 hash that will be used as the API Signature.
  */
  $apiSignature = hash_hmac("sha256", $data, $apiSecret);
  
  /*
  Let's see what the final API Signature looks like.
  */
  echo "API Signature is: \"$apiSignature\"\n";
  
  /*
  Now that the API Signature is calculated let's see what the final
  v2 API URL would look like for this scenario.
  */
  $url = "https://api.weatherlink.com/v2/current/" . $parameters["station-id"] . 
  "?api-key=" . $parameters["api-key"] . 
  "&api-signature=" . $apiSignature . 
  "&t=" . $parameters["t"];
  echo "v2 API ".$url. "\n";
    return $url;
}

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
     if ($array[0] <= 0)
        echo "<br/>cleanGarbageStations: first=".$array[0]." --> removed ".array_shift($array);
     if (($array[count($array)-1] > 3 * $array[count($array)-2])&&(count($array) > 1))
        echo "<br/>cleanGarbageStations: last=".$array[count($array)-1]." before last=".$array[count($array)-2]." --> removed ".array_pop($array);
     if (standard_deviation($array) > round(array_sum($array)/count($array)))
         echo "<br/>cleanGarbageStations: SD too high. last=".$array[count($array)-1]." before last=".$array[count($array)-2]." --> removed ".array_pop($array);
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
$agent= 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:98.0) Gecko/20100101 Firefox/98.0';
$urlWL = connectToWL();
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
curl_setopt_array($ch, [
    CURLOPT_URL => $urlWL,
    CURLOPT_USERAGENT => $agent,
    CURLOPT_VERBOSE => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 50,
    CURLOPT_SSL_CIPHER_LIST => "TLSv1.2",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_HTTPHEADER => [
        "accept-encoding: gzip, deflate, br",
        "content-type: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8"
    ],
]);
$resultWL=file_get_contents($urlWL, false);
$docWL = json_decode($resultWL);
print_r($docWL);
//print_r($docWL->sensors[1]->data[0]);
$pm2p5_02ws = round($docWL->sensors[1]->data[0]->pm_2p5);
$pm1_02ws = round($docWL->sensors[1]->data[0]->pm_1);
$pm10_02ws = round($docWL->sensors[1]->data[0]->pm_10);
$thsw = "";
echo ("pm10_02ws:".$pm10_02ws);
echo ("<br/>pm2p5_02ws:".$pm2p5_02ws);
echo ("<br/>pm1_02ws:".$pm1_02ws);
echo ("<br/>thsw:".$thsw);


/***************** getAveragePM10 ***************/
$apiMANA = connectToMANA(13);
$efrata_pm10 =  $apiMANA->data[0]->channels[7]->value;
$efrata_pm25 =  $apiMANA->data[0]->channels[8]->value;
$apiMANA = connectToMANA(36);
$safra_pm10 =  $apiMANA->data[0]->channels[6]->value;
$apiMANA = connectToMANA(458);//dvora PM2.5 channel 3
$dvora_pm25 = $apiMANA->data[0]->channels[3]->value;
$apiMANA = connectToMANA(509);//malchei PM2.5 channel 4
$malchei_pm25 = $apiMANA->data[0]->channels[3]->value;
$apiMANA = connectToMANA(547);//kvish16 PM2.5 channel 3 PM10 channel 4
$kvish16_pm25 = $apiMANA->data[0]->channels[3]->value;
$kvish16_pm10 = $apiMANA->data[0]->channels[4]->value;
$apiMANA = connectToMANA(5);//bar_ilan PM2.5 PM25 channel 4
$bar_ilan_pm25 = $apiMANA->data[0]->channels[4]->value;
$apiMANA = connectToMANA(549);//kvish16_zemach PM2.5 channel 3 
$kvish16_zemach_pm25 = $apiMANA->data[0]->channels[3]->value;
$apiMANA = connectToMANA(193);//romema PM2.5 channel 3 
$romema_pm25 = $apiMANA->data[0]->channels[3]->value;
//$bar_ilan = $stations_array[1]["shortName"];
//$safra =  $stations_array[10]->monitors[7]->value;
//$atarot = $stations_array[3]["shortName"];
//$merkazit = $stations_array[4]["shortName"];


$stations = array(intval($efrata_pm10), intval($safra_pm10), intval($kvish16_pm10));
sort ($stations);
echo "<br/>pm10 before:";
print_r($stations);
cleanGarbageStations($stations);
$averagedPM10 = round(array_sum($stations)/count($stations));
$sdPM10 = standard_deviation($stations); 
echo "<br />";
echo "pm10 after:";
print_r($stations);
echo "<br />";

/********************** PM2.5 *****************************/

$stations = array(intval($efrata_pm25), intval($dvora_pm25), intval($malchei_pm25), intval($kvish16_pm25), intval($bar_ilan_pm25), intval($kvish16_zemach_pm25), intval($romema_pm25));
sort($stations);
echo "<br/>pm25 before:";
print_r($stations);
cleanGarbageStations($stations);
$averagedPM25 = round(array_sum($stations)/count($stations));
$sdPM25 = standard_deviation($stations);
echo "<br/>pm25 after:";
print_r($stations);
if ($averagedPM10 == 0)
    $averagedPM10 = $pm10_02ws;
if ($averagedPM25 == 0)
    $averagedPM25 = $pm2p5_02ws;    
$file = fopen($output_airq_file_path,"w");
fwrite ($file, $averagedPM10.",".number_format($sdPM10, 1, '.', '').",".$averagedPM25.",".number_format($sdPM25, 1, '.', ''));
@fclose ($file);
echo "<br /><br />".$averagedPM10.",".$sdPM10.",".$averagedPM25.",".$sdPM25;

?>
</pre>
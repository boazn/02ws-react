<?
function getWUData($Station_ID, $city){
    $context_options = [
        "http" => [
            "method" => "GET"
        ]
    ];
    $DATA = json_decode(file_get_contents("https://api.weather.com/v2/pws/observations/current?stationId=".$Station_ID."&format=json&units=m&apiKey=9f10f962050d4cf690f962050d7cf65c", false, stream_context_create($context_options)));
    //var_dump($DATA);
    return "<a href=\"https://www.wunderground.com/dashboard/pws/".$Station_ID."\" target=_blank ><div class=\"foreach\"><span class=\"city\">".$city."</span>: <span title=\"".$DATA->observations[0]->obsTimeLocal."\" class=\"number value\">".$DATA->observations[0]->metric->temp."</span>°/<span class=\"number value\">".$DATA->observations[0]->humidity."</span>%</div></a>";
}
function getIMSData($Station_ID, $city){
    $context_options = [
        "http" => [
            "method" => "GET",
            "header" => "Authorization: ApiToken 6d2dd889-3fcf-4987-986f-e4679d4b2400"
        ]
    ];
    $staiondata = json_decode(file_get_contents("https://api.ims.gov.il/v1/envista/stations/".$Station_ID."/data/latest", false, stream_context_create($context_options)));
    //var_dump($staiondata);
    return    "<div class=\"foreach\"><span class=\"city\">".$city."</span> <span title=\"".$staiondata->data[0]->datetime."\" class=\"number value\">".$staiondata->data[0]->channels[6]->value."</span>°/<span class=\"number value\">".$staiondata->data[0]->channels[7]->value."</span>% <span title=\"".$staiondata->stationId."\">(שמט)</span> </div>";
}

function getAllIMSData(){
    $context_options = [
        "http" => [
            "method" => "GET",
            "header" => "Authorization: ApiToken 6d2dd889-3fcf-4987-986f-e4679d4b2400"
        ]
    ];
    $res = "";
    $stations = json_decode(file_get_contents("https://api.ims.gov.il/v1/envista/stations", false, stream_context_create($context_options)));
    foreach ($stations as $station){
        $res = $res."<br/>$station->stationId: $station->name ($station->shortName)";
        //print_r($station);
        
    }
    return $res;
}

$wu_station_id = $_POST['wu_station_id'];
$ims_station_id = $_POST['ims_station_id'];
$StationType = $_POST['StationType'];
$city = $_POST['city'];
if ($ims_station_id == "ALL")
    echo getAllIMSData();
else if ($StationType == "IMS")
    echo getIMSData($ims_station_id, $city);
else if ($StationType == "WU")
    echo getWUData($wu_station_id, $city);


    
?>
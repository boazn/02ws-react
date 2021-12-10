<?
header('Content-type: text/html; charset=utf-8');
session_start();
/*foreach ($_SESSION as $key=>$value)
{
    $session .= " ".$key.":".$value;
}
foreach ($_COOKIE as $key=>$value)
{
    $cookie .= " ".$key.":".$value;
}*/
include_once($_SERVER['DOCUMENT_ROOT']."/include.php");
include_once("start.php");
include_once("requiredDBTasks.php");
$forecastHour = $mem->get('forecasthour');
$nextSigForecast = array();
$pgender = $_COOKIE['gender'];
$personal_coldmeter = $_COOKIE[PERSONAL_COLD_METER];
$coldmeter_size = $_REQUEST['coldmetersize'];
$cloth_type = $_REQUEST['cloth_type'];
$is_jason = $_REQUEST['json'];
$is_mobile = $_REQUEST['m'];
if ($coldmeter_size =="")
    $coldmeter_size = 17;
if ($current->get_temp() == "")
    exit;
$temp_to_cold_meter = $_REQUEST['temp'];
if (empty($temp_to_cold_meter))
    $temp_to_cold_meter = $current->get_temp_to_coldmeter();
$temp_from = $temp_to_cold_meter - 0.5;
$temp_to = $temp_to_cold_meter + 0.5;
$temp_from2 = $current->get_temp2_to_coldmeter() - 0.5;
$temp_to2 = $current->get_temp2_to_coldmeter() + 0.5;


$row_verdict = array();$row_comment = array();
$row_verdict_sun = array();
$is_personal = "";
//logger("coldmeter_service:".$personal_coldmeter." ".$_SESSION['loggedin']." ".$_SESSION['email']." ".$temp_from." ".$temp_to);
if (($personal_coldmeter == 1)&&($_SESSION['loggedin'] == "true")){
    $query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, {$temp_from2}, {$temp_to2}, '{$pgender}', '{$_SESSION['email']}');";
    //logger( $query_verdict);
    db_init("", "");
    $result = mysqli_query($link, $query_verdict) ;
    $idxShadow = 0;$idxSun = 0;$idx = 0;
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $idx = $idx + 1;
        if (($line["type"]) == "1")
            $idxShadow += 1;
        else
            $idxSun += 1;
        if ((($line["type"]) == "1")) array_push($row_verdict, array("field_name" => $line["field_name"], "count" => $line["count( * )"], "shadoworsun" => $line["type"], "value" => $line["value"]));
        if ((($line["type"]) == "2")) array_push($row_verdict_sun, array("field_name" => $line["field_name"], "count" => $line["count( * )"], "shadoworsun" => $line["type"], "value" => $line["value"]));
    }
    $feeling_verdict = $row_verdict[0]["field_name"];
    $value_verdict = $row_verdict[0]["value"];
    $feeling_verdict_sun = $row_verdict_sun[0]["field_name"];
    $value_verdict_sun = $row_verdict_sun[0]["value"];
    if ($row_verdict[0]["count"] > 0)
        $is_personal = $is_jason ? "1" : " style=\"font-style: italic\" ";
}
if (empty($is_personal)){
    if (!$mem->get($pgender.$temp_from."to".$temp_to)){
       
       $query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, {$temp_from2}, {$temp_to2}, '{$pgender}', null);";
       $lastcomments = "call GetLastComments({$temp_from}, {$temp_to});";
       
       //echo $query_verdict;
       db_init("", "");
       $result = mysqli_query($link, $query_verdict) ;
       $idxShadow = 0;$idxSun = 0;$idx = 0;
       while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
           $idx = $idx + 1;
           if (($line["type"]) == "1")
            $idxShadow += 1;
           else
            $idxSun += 1;
            if ((($line["type"]) == "1")) array_push($row_verdict, array("field_name" => $line["field_name"], "count" => $line["count( * )"], "shadoworsun" => $line["type"], "value" => $line["value"]));
           if ((($line["type"]) == "2")) array_push($row_verdict_sun, array("field_name" => $line["field_name"], "count" => $line["count( * )"], "shadoworsun" => $line["type"], "value" => $line["value"]));
       }
        $resultcomments = db_init($lastcomments, "");
        $commentidx = 1;
        while ($line = mysqli_fetch_array($resultcomments["result"], MYSQLI_ASSOC)) {
            array_push($row_comment, array("comment" => $line["comments"], "gender" => $line["gender"], "temp" => $line["temp"], "update_time" => $line["update_time"]));
            $commentidx = $commentidx + 1;
        }
       $feeling_verdict = $row_verdict[0]["field_name"];
       $value_verdict = $row_verdict[0]["value"];
       //logger("calling GetColdMeter ".$temp_from." ".$temp_to." ".$temp_from2." ".$temp_to2." ".$pgender." ->".$feeling_verdict);
       $feeling_verdict_sun = $row_verdict_sun[0]["field_name"];
       $value_verdict_sun = $row_verdict_sun[0]["value"];
       $mem->set($pgender.$temp_from."to".$temp_to, $row_verdict[0]["field_name"], time() + 300);
       $mem->set($pgender.$temp_from."to".$temp_to."value", $row_verdict[0]["value"], time() + 300);
       $mem->set($pgender.$temp_from."to".$temp_to."verdict", $row_verdict, time() +  300);
       $mem->set($temp_from."to".$temp_to."comments", $row_comment, time() + 300);
       $mem->set($pgender.$temp_from."to_sun".$temp_to, $row_verdict_sun[0]["field_name"], time() + 300);
       $mem->set($pgender.$temp_from."to_sun".$temp_to."verdict", $row_verdict_sun, time() +  300);
      
   }
   else{
       $row_verdict = $mem->get($pgender.$temp_from."to".$temp_to."verdict");
       $feeling_verdict = $mem->get($pgender.$temp_from."to".$temp_to);
       $value_verdict = $mem->get($pgender.$temp_from."to".$temp_to."value");
       $row_verdict_sun = $mem->get($pgender.$temp_from."to_sun".$temp_to."verdict");
       $feeling_verdict_sun = $mem->get($pgender.$temp_from."to_sun".$temp_to);
   }
}
$current_feeling = get_name($feeling_verdict);
$current_feeling_sun = get_name($feeling_verdict_sun);
//if ($current_feeling === $VVCOLD[$lang_idx])
//logger("coldmeter: ".$current_feeling.": ".$feeling_verdict." ".$_SESSION['email']);
 $cloth_name = getClothName($current_feeling, $cloth_type);
 $cloth_name_sun = getClothName($current_feeling_sun, $cloth_type);
 $arCloth_name =  explode('_', $cloth_name);
 $prefCloth_name = $arCloth_name[0];
 if ($current->get_solarradiation() > 220){
    $shade = $SHADE[$lang_idx];
    $sun = $SUN[$lang_idx];
 }
	
$current_feeling = "<a href=\"javascript:void(0)\" class=\"info currentcloth\" ><span class=\"info\">".getClothTitle($cloth_name, $temp_to_cold_meter)."</span><img src=\"images/clothes/".$cloth_name."\" width=\"".$coldmeter_size*1.21."\" height=\"".$coldmeter_size."\" style=\"vertical-align: middle\" /></a><a class=\"info\" id=\"coldmetertitle\" href=\"javascript:void(0)\" ".$is_personal."><span class=\"info\" style=\"cursor: default;\" onclick=\"redirect('".BASE_URL.(($is_mobile==1)? "\/small\/" : "")."?section=survey.php&amp;survey_id=2&amp;lang=".$lang_idx."&amp;email=".$_SESSION['email']."')\">".$COLD_METER[$lang_idx]."</span>".$current_feeling."</a>".checkAsterisk($row_verdict, $is_jason)." ".$shade;    
$json_res = "{\"coldmeter\":";
$json_res .= "{";
    $json_res .= "\"clothtitle\":\"".getClothTitle($cloth_name, $temp_to_cold_meter)."\"";
    $json_res .= ",";
    $json_res .= "\"cloth_name\":"."\"".$cloth_name." \"";
    $json_res .= ",";
    $json_res .= "\"personal\":"."\"".$is_personal."\"";
    $json_res .= ",";
    $json_res .= "\"current_feeling\":\"".get_name($feeling_verdict)."\"";
    $json_res .= ",";
    $json_res .= "\"current_code\":\"".$feeling_verdict."\"";
    $json_res .= ",";
    $json_res .= "\"current_value\":\"".$value_verdict."\"";
    $json_res .= ",";
    $json_res .= "\"asterisk\":\"".checkAsterisk($row_verdict, $is_jason)." ".$shade."\"";
$json_res .= "}";
if (!empty($current->get_temp2_to_coldmeter())){
    $json_res .= ",\"coldmeter_sun\":";
    $json_res .= "{";
        $json_res .= "\"clothtitle\":\"".getClothTitle($cloth_name_sun, $current->get_temp2_to_coldmeter())."\"";
        $json_res .= ",";
        $json_res .= "\"cloth_name\":"."\"".$cloth_name_sun." \"";
        $json_res .= ",";
        $json_res .= "\"current_feeling\":\"".get_name($feeling_verdict_sun)."\"";
        $json_res .= ",";
        $json_res .= "\"current_code\":\"".$feeling_verdict_sun."\"";
        $json_res .= ",";
        $json_res .= "\"current_value\":\"".$value_verdict_sun."\"";
        $json_res .= ",";
        $json_res .= "\"asterisk\":\"".checkAsterisk($row_verdict_sun, $is_jason)." ".$sun."\"";
    $json_res .= "}";
}
$current_heat_index = get_heat_index($current->get_temp(), $current->get_hum());
 
if ($current_heat_index != "")
	$current_feeling = $current_feeling."<div id=\"heatindex\">".$current_heat_index."</div>";



$laundry_con = array();
$laundry_con = get_laundry_index();
$json_res .= ",\"laundryidx\":";
$json_res .= "{";
    $json_res .= "\"laundry_con_img\":"."\"".$laundry_con[0]." \"";
    $json_res .= ",";
    $json_res .= "\"laundry_con_title\":"."\"".$laundry_con[1]." \"";
    $json_res .= ",";
    $json_res .= "\"laundry_con_limit\":"."\"".$laundry_con[2]." \"";
$json_res .= "}"; 
$json_res .= "}"; 
if ($is_jason == 1)
{
    echo $json_res;
    //echo "<pre>".var_dump($row_verdict)."</pre>";
   // echo $current->get_temp2_to_coldmeter()." "."<pre>".var_dump($row_verdict_sun)."</pre>";
}else{
    echo $current_feeling;
    echo "<div id=\"laundryidx\"><a href=\"javascript:void(0)\" class=\"info\" ><img src=\"images/laundry/".$laundry_con[0].".svg\" width=\"36\" height=\"36\" alt=\"laundry\" title=\"".$laundry_con[1]."\" /><span class=\"info\">".$laundry_con[1]." (".($laundry_con[2] != "" ?  $REMOVE_LAUNDRY[$lang_idx]." ".$IN[$lang_idx]." ".$laundry_con[2]." ".$HOURS[$lang_idx]: "").")</span></a><div><strong>".$laundry_con[2]."</strong></div></div>";    

}
?>
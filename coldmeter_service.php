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

include_once("include.php");
include_once("start.php");
include_once("requiredDBTasks.php");
$forecastHour = $mem->get('forecasthour');
$nextSigForecast = array();
$pgender = $_COOKIE['gender'];
$personal_coldmeter = $_COOKIE[PERSONAL_COLD_METER];
$coldmeter_size = $_REQUEST['coldmetersize'];
$is_jason = $_REQUEST['jason'];
$is_mobile = $_REQUEST['m'];
if ($coldmeter_size =="")
    $coldmeter_size = 17;
if ($current->get_temp() == "")
    exit;
$temp_to_cold_meter = $current->get_temp_to_coldmeter();
$temp_from = $temp_to_cold_meter - 0.5;
$temp_to = $temp_to_cold_meter + 0.5;
$temp_from2 = $current->get_temp2_to_coldmeter() - 0.5;
$temp_to2 = $current->get_temp2_to_coldmeter() + 0.5;
$row_verdict = array();$row_comment = array();
$is_personal = "";
//logger("coldmeter_service:".$personal_coldmeter." ".$_SESSION['loggedin']." ".$_SESSION['email']." ".$temp_from." ".$temp_to);
if (($personal_coldmeter == 1)&&($_SESSION['loggedin'] == "true")){
    $query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, {$temp_from2}, {$temp_to2}, '{$pgender}', '{$_SESSION['email']}');";
    //logger( $query_verdict);
    db_init("", "");
    $result = mysqli_query($link, $query_verdict) ;
    $idx = 1;
    
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if ($idx <= 2) array_push($row_verdict, array("field_name" => $line["field_name"], "count" => $line["count( * )"]));
        $idx = $idx + 1;
    }
    $feeling_verdict = $row_verdict[0]["field_name"];
    if ($row_verdict[0]["count"] > 0)
        $is_personal = " style=\"font-style: italic\" ";
}
if (empty($is_personal)){
    if (!$mem->get($pgender.$temp_from."to".$temp_to)){
       //logger("calling GetColdMeter ".$temp_from." ".$temp_to." ".$pgender);
       $query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, {$temp_from2}, {$temp_to2}, '{$pgender}', null);";
       $lastcomments = "call GetLastComments({$temp_from}, {$temp_to});";
       //echo $query_verdict;
       db_init("", "");
       $result = mysqli_query($link, $query_verdict) ;
       $idx = 1;
       while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
           if ($idx <= 2) array_push($row_verdict, array("field_name" => $line["field_name"], "count" => $line["count( * )"]));
           $idx = $idx + 1;
       }
        $resultcomments = db_init($lastcomments, "");
        $commentidx = 1;
        while ($line = mysqli_fetch_array($resultcomments["result"], MYSQLI_ASSOC)) {
            array_push($row_comment, array("comment" => $line["comments"], "gender" => $line["gender"], "temp" => $line["temp"], "update_time" => $line["update_time"]));
            $commentidx = $commentidx + 1;
        }
       $feeling_verdict = $row_verdict[0]["field_name"];
       $mem->set($pgender.$temp_from."to".$temp_to, $row_verdict[0]["field_name"], time() + 300);
       $mem->set($pgender.$temp_from."to".$temp_to."verdict", $row_verdict, time() +  300);
       $mem->set($temp_from."to".$temp_to."comments", $row_comment, time() + 300);
   }
   else{
       $row_verdict = $mem->get($pgender.$temp_from."to".$temp_to."verdict");
       $feeling_verdict = $mem->get($pgender.$temp_from."to".$temp_to);
   }
}
$current_feeling = get_name($feeling_verdict);
//if ($current_feeling === $VVCOLD[$lang_idx])
//logger("coldmeter: ".$current_feeling.": ".$feeling_verdict." ".$_SESSION['email']);
 $cloth_name = getClothName($current_feeling);
 $arCloth_name =  explode('_', $cloth_name);
 $prefCloth_name = $arCloth_name[0];
 if ($current->get_solarradiation() > 220)
	$shade = $SHADE[$lang_idx];
$current_feeling = "<a href=\"javascript:void(0)\" class=\"info currentcloth\" ><span class=\"info\">".getClothTitle($cloth_name, $current->get_temp_to_coldmeter())."</span><img src=\"images/clothes/".$cloth_name."\" width=\"".$coldmeter_size*1.21."\" height=\"".$coldmeter_size."\" style=\"vertical-align: middle\" /></a><a class=\"info\" id=\"coldmetertitle\" href=\"javascript:void(0)\" ".$is_personal."><span class=\"info\" style=\"cursor: default;\" onclick=\"redirect('".BASE_URL.(($is_mobile==1)? "\/small\/" : "")."?section=survey.php&amp;survey_id=2&amp;lang=".$lang_idx."&amp;email=".$_SESSION['email']."')\">".$HOTORCOLD_T[$lang_idx]." - ".$COLD_METER[$lang_idx]."</span>".$current_feeling."</a>".checkAsterisk($row_verdict)." ".$shade;    
$json_res = "{\"coldmeter\":";
$json_res .= "{";
    $json_res .= "\"clothtitle\":\"".getClothTitle($cloth_name, $current->get_temp_to_coldmeter())."\"";
    $json_res .= ",";
    $json_res .= "\"cloth_name\":"."\"".$cloth_name." \"";
    $json_res .= ",";
    $json_res .= "\"current_feeling\":\"".get_name($feeling_verdict)."\"";
    $json_res .= ",";
    $json_res .= "\"asterisk\":\"".checkAsterisk($row_verdict)." ".$shade."\"";
$json_res .= "}";
  
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
}else{
    echo $current_feeling;
    echo "<div id=\"laundryidx\"><a href=\"javascript:void(0)\" class=\"info\" ><img src=\"images/laundry/".$laundry_con[0].".svg\" width=\"36\" height=\"36\" alt=\"laundry\" title=\"".$laundry_con[1]."\" /><span class=\"info\">".$laundry_con[1]." (".($laundry_con[2] != "" ?  $REMOVE_LAUNDRY[$lang_idx]." ".$IN[$lang_idx]." ".$laundry_con[2]." ".$HOURS[$lang_idx]: "").")</span></a><div><strong>".$laundry_con[2]."</strong></div></div>";    

}
?>
<?
define("MANAGER_NAME","bn");
define("ICONS_PATH","images/icons/day");
define("CLOTHES_PATH","images/clothes");
ini_set("display_errors","On");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
?>
<style>
    #section input
    {
        width:20px;
    }
    .contentbox
    {
        float:none
    }
    .contentbox-wrapper
    {
        width:40%
    }
    #what_is_forcast
    {
        width:650px
    }
    #forcast_title
    {
        right:50px
    }
    #forcast_hours
    {
        direction:rtl
    }
    .cell{
        float:right;padding:0.3em 0.3em 0 0.3em
    }
    .invcell{
        float:left;padding:5px 0.8em
    }
    .shrinked{
        padding:0.3em 0.2em 0em 0.2em
    }
    .cellspace{
        padding:0.3em 0.5em 0 0.5em
    }
    textarea{
        width:390px;
        height:35px;
    }
    textarea.floated{
        width:390px;
        height:35px;
    }
    .btnsstart, .tempstart{clear:both;}
    @media only screen and (min-width: 1000px) {
        textarea{
            width:650px;
            height:12px;
        }
        textarea.floated{
            width:380px;
        
        }
        .btnsstart, .tempstart{clear:none;}
        .cell{
            padding:1em
        }
    }
    
    input{border:0}
</style>
<div class="">
<div class=""   id="forDetails">
<?

function get_Fromdir($path){    
	$dirToOpen = $path;    
	$items = array();    
	if ($handle = opendir($dirToOpen)) {      
            while (false !== ($file = readdir($handle))) {       
                    if ($file != "." && $file != "..") {          
                            $items[] = $file;      
                    }   
            }	   

            $array_lowercase = array_map('strtolower', $items);
            array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $items);
            return $items;    	
	}	
}
function refreshCssFile($url, $local_file_path){
   
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
}

function translateText($text, $target_lang){
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://nlp-translation.p.rapidapi.com/v1/translate",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "text=".$text."&from=en&to=".$target_lang, // ar fr ru
        CURLOPT_HTTPHEADER => [
            "accept-encoding: application/gzip",
            "content-type: application/x-www-form-urlencoded",
            "x-rapidapi-host: nlp-translation.p.rapidapi.com",
            "x-rapidapi-key: c09c5dfa87msh532b42e84065a8fp175c90jsnd908da654439"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        $result_tr = json_decode($response);
        //var_dump($result_tr);
        echo $result_tr->translated_text->$target_lang;
        return $result_tr->translated_text->$target_lang;
    }
}
function updateForecastMessage ($lang, $desc, $active)
{
    $now = date('Y-m-d G:i:s', strtotime("-1 hours 0 minutes", time()));
    //$now = getLocalTime(time());
    $desc = nl2br($desc);
    $query = "UPDATE `content_sections` SET Description='{$desc}' , active={$active} WHERE (lang=$lang) and (type='forecast')";
    //echo $query;
    $result = db_init($query, "");
    // Free resultset 
    @mysqli_free_result($result);
		
	
}
function insertNewMessage ($day, $day_name, $date, $temp_low, $temp_morning_cloth, $temp_high, $temp_high_cloth, $temp_night, $temp_night_cloth, $temp_day, $humMorning, $humDay, $humNight, $windMorning, $windDay, $windNight, $lang0, $lang1, $active, $icon, $iconmorning, $iconnight)
{
	global $mem;	
    $now = date('Y-m-d G:i:s', strtotime("-1 hours 0 minutes", time()));
    //$now = getLocalTime(time());
    $lang0 = nl2br($lang0);
    $lang1 = nl2br($lang1);
    $query = "INSERT INTO forecast_days (day, day_name, date, TempLow, TempLowCloth, TempHigh, TempHighCloth, TempNight, TempNightCloth, humMorning, humDay, humNight, windMorning, windDay, windNight, lang0, lang1, active, icon, iconmorning, iconnight) VALUES('{$day}', '{$day_name}', '{$date}', '{$temp_low}', '{$temp_morning_cloth}', '{$temp_high}', '{$temp_high_cloth}', '{$temp_night}', '{$temp_night_cloth}', '{$humMorning}', '{$humDay}', '{$humNight}', '{$windMorning}', '{$windDay}', '{$windNight}', '{$lang0}', '{$lang1}', '{$active}', '{$icon}', '{$iconmorning}', '{$iconnight}');";
    //echo $query;

     $result = db_init($query, "");
     if   ($result["error"] != ""){
        $active = 0;
        $day = $day + 1;
        $query = "INSERT INTO forecast_days (day, day_name, date, TempLow, TempLowCloth, TempHigh, TempHighCloth, TempNight, TempNightCloth, humMorning, humDay, humNight, windMorning, windDay, windNight, lang0, lang1, active, icon) VALUES('{$day}', '{$day_name}', '{$date}', '{$temp_low}', '{$temp_morning_cloth}', '{$temp_high}', '{$temp_high_cloth}', '{$temp_night}', '{$temp_night_cloth}', '{$humMorning}', '{$humDay}', '{$humNight}', '{$windMorning}', '{$windDay}', '{$windNight}', '{$lang0}', '{$lang1}', '0', '{$icon}');";
        $result = db_init($query, "");
        
    }
    $query = "SELECT max(idx) idx FROM `forecast_days`";
    $result = db_init($query, "");
    while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
    $idx = $line['idx'];
    }
    // Free resultset 
    @mysqli_free_result($result);
    if ($active == 1){
        $forecastDaysDB = $mem->get('forecastDaysDB');
        $forecastDaysDB[$idx] = array('likes' => array(), 
                                      'dislikes' => array(), 
                                      'lang0' => urlencode($lang0), 
                                      'lang1' => urlencode($lang1),
                                      //'lang2' => translateText(urlencode($lang0), 'ru'),
                                      //'lang3' => translateText(urlencode($lang0), 'fr'),
                                      //'lang4' => translateText(urlencode($lang0), 'ar'),
                                      'TempLow' => $temp_low, 
                                      'TempHigh' => $temp_high, 
                                      'date' => $date, 
                                      'day_name' => $day_name, 
                                      'icon' => $icon, 
                                      'iconmorning' => $iconmorning, 
                                      'iconnight' => $iconnight, 
                                      'TempNight' => $temp_night, 
                                      'TempLowCloth' => $temp_morning_cloth, 
                                      'TempNightCloth' => $temp_night_cloth, 
                                      'TempHighCloth' => $temp_high_cloth, 
                                      'humMorning'=>$humMorning, 
                                      'humDay'=>$humDay, 
                                      'humNight'=>$humNight,
                                      'windMorning'=>$windMorning, 
                                      'windDay'=>$windDay, 
                                      'windNight'=>$windNight
                                    );
        //var_dump($forecastDaysDB);
        
        $mem->set('forecastDaysDB',$forecastDaysDB);
        apc_store('forecastDaysDB',$forecastDaysDB);	
    }

}
function updateForecastDay ($idx, $day_name, $date, $temp_low, $temp_morning_cloth, $temp_high, $temp_high_cloth, $temp_night, $temp_night_cloth, $temp_day, $humMorning, $humDay, $humNight, $windMorning, $windDay, $windNight, $lang0, $lang1, $active, $icon, $iconmorning, $iconnight)
{
    global $mem;
    $now = date('Y-m-d G:i:s', strtotime("-1 hours 0 minutes", time()));
    //$now = getLocalTime(time());
    $lang0 = nl2br($lang0);
    $lang0 = str_replace("'", "`", $lang0);
    $lang0 = str_replace("\"", "``", $lang0);
    $lang1 = nl2br($lang1);
    $lang1 = str_replace("'", "`", $lang1);
    $lang1 = str_replace("\"", "``", $lang1);
    $query = "UPDATE forecast_days SET TempLow='{$temp_low}', TempHigh='{$temp_high}', TempLowCloth='{$temp_morning_cloth}', TempHighCloth='{$temp_high_cloth}', TempNight='{$temp_night}', TempNightCloth='{$temp_night_cloth}', TempDay='{$temp_day}', humMorning='{$humMorning}', humDay='{$humDay}', humNight='{$humNight}', windMorning='{$windMorning}', windDay='{$windDay}', windNight='{$windNight}', lang0='{$lang0}', lang1='{$lang1}' , active={$active}, icon='{$icon}', iconmorning='{$iconmorning}', iconnight='{$iconnight}', date='{$date}', day_name='{$day_name}'  WHERE (idx=$idx)";

    //echo $query;
    $result = db_init($query, "");
    // Free resultset 
    @mysqli_free_result($result);
    if ($active == 1){
        
        $forecastDaysDB = $mem->get('forecastDaysDB');
        $forecastDaysDB[$idx]['day_name'] = $day_name;
        $forecastDaysDB[$idx]['date'] = $date;
        $forecastDaysDB[$idx]['TempLow'] = $temp_low;
        $forecastDaysDB[$idx]['TempLowCloth'] = $temp_morning_cloth;
        $forecastDaysDB[$idx]['TempHigh'] = $temp_high;
        $forecastDaysDB[$idx]['TempHighCloth'] = $temp_high_cloth;
        $forecastDaysDB[$idx]['TempNight'] = $temp_night;
        $forecastDaysDB[$idx]['TempNightCloth'] = $temp_night_cloth;
        $forecastDaysDB[$idx]['TempDay'] = $temp_day;
        $forecastDaysDB[$idx]['humMorning'] = $humMorning;
        $forecastDaysDB[$idx]['humDay'] = $humDay;
        $forecastDaysDB[$idx]['humNight'] = $humNight;
        $forecastDaysDB[$idx]['windMorning'] = $windMorning;
        $forecastDaysDB[$idx]['windDay'] = $windDay;
        $forecastDaysDB[$idx]['windNight'] = $windNight;
        $forecastDaysDB[$idx]['lang0'] = $lang0;
        $forecastDaysDB[$idx]['lang1'] = $lang1;
        //$forecastDaysDB[$idx]['lang2'] = translateText(urlencode($lang0), 'ru');
        //$forecastDaysDB[$idx]['lang3'] = translateText(urlencode($lang0), 'fr');
        //$forecastDaysDB[$idx]['lang4'] = translateText(urlencode($lang0), 'ar');
        $forecastDaysDB[$idx]['active'] = $active;
        $forecastDaysDB[$idx]['icon'] = $icon;
        $forecastDaysDB[$idx]['iconmorning'] = $iconmorning;
        $forecastDaysDB[$idx]['iconnight'] = $iconnight;
        if (is_null($forecastDaysDB[$idx]['likes']))
            $forecastDaysDB[$idx]['likes'] = array();
        if (is_null($forecastDaysDB[$idx]['dislikes']))
            $forecastDaysDB[$idx]['dislikes'] = array();
        
        $mem->set('forecastDaysDB',$forecastDaysDB);
        apc_store('forecastDaysDB',$forecastDaysDB);	
    }
	
}

function updateMessageFromMessages ($description, $active, $type, $lang, $href, $img_src, $title, $append)
{
    global $forecastHour, $mem;
    $description = nl2br($description);
    $description = str_replace("'", "`", $description);
    $now = replaceDays(date('G:i D '));
     //$now = getLocalTime(time());
    $res = db_init("SELECT * FROM  `content_sections` WHERE (TYPE =  'forecast') and (lang=?)", $lang);
    while ($line = mysqli_fetch_array($res["result"], MYSQLI_ASSOC) ){
        $descriptionforecast = $line["Description"];
    }
    $res = db_init("SELECT * FROM  `content_sections` WHERE (TYPE =  'LAlert') and (lang=?)", $lang);
    while ($line = mysqli_fetch_array($res["result"], MYSQLI_ASSOC) ){
        $latestalert = $line["Description"];
    }
    $description_appended = $latestalert."\n</br>".$descriptionforecast;
    
    //echo "append=".$append;
    if ($append==1){
        $query = "UPDATE `content_sections` SET Description='{$description_appended}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}', updatedTime=SYSDATE()  WHERE (type='forecast') and (lang=$lang)";
        $mem->set('descriptionforecast'.$lang, $description_appended);
        $res = db_init($query, "" );
        //echo $query;
        $description = "<div class=\"alerttime\">".$now."</div><div class=\"title\">".$description."</div>";
        $query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}', updatedTime=SYSDATE()  WHERE (type='$type') and (lang=$lang)";
        $mem->set('latestalert'.$lang, $description);
        $mem->set('latestalerttime'.$lang, time());
        $res = db_init($query, "" );
        
        
    }
    else{
        if ($lang < 0)
        $query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}', updatedTime=SYSDATE()  WHERE (type='$type')";
        else
        $query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}', updatedTime=SYSDATE()  WHERE (type='$type') and (lang=$lang)";
        if ($type == 'LAlert'){
            $mem->set('latestalert'.$lang, $description);
            $mem->set('latestalerttime'.$lang, time());
            echo "updateLAlert".$lang."=".date('Y-m-d G:i D', $mem->get('latestalerttime'.$lang));
        }   
        else if ($type == 'forecast'){
            $mem->set('descriptionforecast'.$lang, $description);
            $mem->set('descriptionforecasttime'.$lang, time());
            echo "updateforecast".$lang."=".date('Y-m-d G:i D', $mem->get('descriptionforecasttime'.$lang));
        }
           
        $res = db_init($query, "" );
        
    }
    
        
     // echo $query;
    
    // Free resultset 
    @mysqli_free_result($result);
   	
}
function updateMainStory ($description, $lang, $href, $img_src, $title)
{
    global $link, $mem;
    $description = nl2br($description);
    $now = date('Y-m-d G:i:s');
    //$now = getLocalTime(time());
    $query = "SELECT  max(Idx) idx FROM `mainstory`  where (lang=?) ";
    $result = db_init($query, $lang);
    $description = str_replace ("'", "`", $description);
    $row = @mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
    $idx = $row["idx"];
    if ($lang>=0)
            $query = "UPDATE `mainstory` SET Description='{$description}', active=1, href='{$href}', img_src='{$img_src}', Title='{$title}',updatedTime='{$now}'  WHERE (Idx={$idx}) and (lang=$lang)";
    else
            $query = "UPDATE `mainstory` SET Description='{$description}', active=1, href='{$href}', img_src='{$img_src}', Title='{$title}',updatedTime='{$now}'  WHERE (Idx={$idx})";
    //echo $query;
    $result = mysqli_query($link, $query);
    // Free resultset 
    @mysqli_free_result($result);
    $MainStory = new ContentSection();
    $MainStory->set_description($description);
    $MainStory->set_img_src($img_src);
    $MainStory->set_href($href);
    $MainStory->set_Title($title);
    $mem->set('mainstory'.$lang, $MainStory);
	
}
function insertMainStory ($description, $lang, $href, $img_src, $title)
{
    global $mem;
    $description = nl2br($description);
    $now = date('Y-m-d G:i:s');
    $query = "call InsertNewStory('{$description}', '{$href}', '{$img_src}', '{$title}', {$lang})";
    //echo $query;
    $result = db_init($query , "");
    // Free resultset 
    @mysqli_free_result($result);
    $MainStory = new ContentSection();
    $MainStory->set_description($description);
    $MainStory->set_img_src($img_src);
    $MainStory->set_href($href);
    $MainStory->set_Title($title);
    $mem->set('mainstory'.$lang, $MainStory);
	
}

function deleteMessage ($idx)
{
    global $mem;
    $result = db_init("DELETE FROM forecast_days WHERE (idx=?)", $idx);
    // Free resultset 
    
    @mysqli_free_result($result);
    
    $forecastDaysDB = $mem->get('forecastDaysDB');
    unset($forecastDaysDB[$idx]);
    
    $mem->set('forecastDaysDB',$forecastDaysDB);	
}

function getUpdatedForecast()
{
    $station_code = TAF_STATION; // OJAM OJAI LLBG BIRK
    $shift_forecast_time = 0;
    $taf_file = "cache/".$station_code.".txt"; 
    $taf_contents = @file_get_contents($taf_file);
    return $taf_contents;
}

// Connecting, selecting database
include_once("include.php"); 
include_once("lang.php");
$mem = new Memcached();
$mem->addServer('localhost', 11211);
$icons = get_Fromdir(ICONS_PATH);
$clothes = get_Fromdir(CLOTHES_PATH);
$empty = $post = array();
foreach ($_POST as $varname => $varvalue) {
   if (empty($varvalue)) {
       $empty[$varname] = $varvalue;
   } else {
       $post[$varname] = $varvalue;
   }
}
if (empty($empty)) {
   //print "None of the POSTed values are empty, posted:\n";
   //var_dump($post);
} else {
   //$result .= "We have " . count($empty) . " empty values\n";
   //$result .= "Posted:\n"; var_dump($post);
   //$result .= "Empty:\n";  var_dump($empty);
   
}
if ($_POST['command'] == "like")
    updateForecastDayLikes($_POST['idx']);
else if ($_POST['command'] == "dislike")
    updateForecastDayDislikes($_POST['idx']);
else if ((trim($_POST['command']) == "D") && ($_POST['idx'] != ""))
{
	deleteMessage($_POST['idx']);
}
else if ((trim($_POST['command']) == "U"))
{
	if ($_POST['idx'] != "")
        updateForecastDay ($_POST['idx'], 
                           $_POST['day_name'], 
                           $_POST['date'], 
                           $_POST['templow'], 
                           $_POST['temp_morning_cloth'], 
                           $_POST['temphigh'],  
                           $_POST['temphigh_cloth'], 
                           $_POST['tempnight'], 
                           $_POST['tempnight_cloth'], 
                           $_POST['tempday'], 
                           $_POST['humMorning'], 
                           $_POST['humDay'], 
                           $_POST['humNight'],
                           $_POST['windMorning'], 
                            $_POST['windDay'], 
                            $_POST['windNight'],  
                           $_POST['lang0'],  
                           urldecode($_POST['lang1']), 
                           $_POST['active'], 
                           $_POST['day_icon'], 
                           $_POST['morning_icon'], 
                           $_POST['night_icon']);
     else
		updateMessageFromMessages (html_entity_decode(urldecode($_POST['description'])), $_POST['active'], $_POST['type'], $_POST['lang'],urldecode($_POST['href']) ,urldecode($_POST['img_src']),urldecode($_POST['title']), 0);
}
else if ((trim($_POST['type']) == "LAlert"))
{
    updateMessageFromMessages (html_entity_decode(urldecode($_POST['description'])), $_POST['active'], $_POST['type'], $_POST['lang'],urldecode($_POST['href']) ,urldecode($_POST['img_src']),urldecode($_POST['title']), 1);
}
else if ($_POST['idx'] != "")
{
            insertNewMessage($_POST['idx'], 
                            $_POST['day_name'], 
                        $_POST['date'], 
                        $_POST['templow'], 
                        $_POST['temp_morning_cloth'],   
                        $_POST['temphigh'],   
                        $_POST['temphigh_cloth'], 
                        $_POST['tempnight'],  
                        $_POST['tempnight_cloth'], 
                        $_POST['tempday'], 
                        $_POST['humMorning'], 
                        $_POST['humDay'], 
                        $_POST['humNight'],
                        $_POST['windMorning'], 
                        $_POST['windDay'], 
                        $_POST['windNight'],  
                        $_POST['lang0'],  
                        urldecode($_POST['lang1']), 
                        $_POST['active'], 
                        $_POST['day_icon'],
                        $_POST['morning_icon'],
                        $_POST['night_icon']);
}
else if ((trim($_POST['command']) == "ISTORY"))
{
	insertMainStory(html_entity_decode(urldecode($_POST['description'])), $_POST['lang'],urldecode($_POST['href']) ,urldecode($_POST['img_src']),urldecode($_POST['title']));
}
else if ((trim($_POST['command']) == "USTORY"))
{
	updateMainStory(html_entity_decode(urldecode($_POST['description'])), $_POST['lang'],urldecode($_POST['href']) ,urldecode($_POST['img_src']),urldecode($_POST['title']));
}
else
echo $_POST['command'];

 if (($_POST['type'] == "taf")||($_GET['reload'] == "1")){
        $toDelete = $mem->getAllKeys();
        $toStore = array();
        //echo "\nkeys in cache\n-------------<br/>";
        $regex = '_new';
        foreach ($toDelete AS $key => $value) {
        
            if(preg_match('/'.$regex.'/', $value)) {
                //echo $value ." ". $mem->get($value)."<br/>";
                $mem->set($value, time());
            }
            
            //$mem->delete($value);
        }
        echo "\nkeys in cache renewed";
        //echo "-------------<br/>";
        //var_dump($forecastHour);
        //var_dump($sigforecastHour);
        //$mem->set($toStore);
        //var_dump($mem->delete($toDelete));
        $forecastlib_origin = "updateForecast.php";
        //$_REQUEST['debug'] = 3;    
        include_once ("start.php");
        $mem->delete('taf');
        //$_REQUEST['debug'] = 3;    
        include_once ("requiredDBTasks.php");
        include_once ("sigweathercalc.php");
        $mem->set('max_time', $_POST['max_time']);
        $mem->set('MULTIPLE_FACTOR', $_POST['multiple_factor']);
        $_REQUEST['MAX_TIME'] = $_POST['max_time'];
        $_REQUEST['MULTIPLE_FACTOR'] = $_POST['multiple_factor']; //how quickly temp rise 0.9 - 1.2
        include("forecastlib.php");
        $local_file_path = "/home/boazn/public/02ws.com/public/css/mobile0.css";
        if (is_writable($local_file_path))
            refreshCssFile("https://www.02ws.co.il/css/mobile.php?lang=0", $local_file_path);
        else
            echo $local_file_path." is not writable";
        $local_file_path = "/home/boazn/public/02ws.com/public/css/mobile1.css";
        if (is_writable($local_file_path))
            refreshCssFile("https://www.02ws.co.il/css/mobile.php?lang=1", $local_file_path);
        else
            echo $local_file_path." is not writable";
        $local_file_path = "/home/boazn/public/02ws.com/public/css/main1.css";
        if (is_writable($local_file_path))
            refreshCssFile("https://www.02ws.co.il/css/main.php?lang=1", $local_file_path);
        else
            echo $local_file_path." is not writable";
        $local_file_path = "/home/boazn/public/02ws.com/public/css/main0.css";
        if (is_writable($local_file_path))
            refreshCssFile("https://www.02ws.co.il/css/main.php?lang=0", $local_file_path);
        else
            echo $local_file_path." is not writable";
        
       
        
}
?>

<?
$langp = 0;
$result = db_init("SELECT * FROM content_sections WHERE (TYPE='taf') and (lang=?)", $langp);
while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
?>
<div  class="invcell <? if ($line["active"]==1) echo "inv_plain_3_zebra";?>" class="cell" id="taf">
    <div style="position:absolute;top:3em;left: 450px;">
        <input type="checkbox" id="reloadf" name="reloadf"  value="<?=$_POST["reloadf"]?>" <? if ($_POST["reloadf"] == 1) echo "checked=\"checked\""; ?> />reloadF from DB
    </div>
	<div class="cell">
        <input id="max_time" name="max_time" size="2"  value="<?=$mem->get('max_time')?>"  onclick="empty(this, '<?=$NAME[$lang_idx]?>');" style="width:40px;font-size:2em"/>
	</div>
	<div class="cell">
        <input id="MULTIPLE_FACTOR" name="MULTIPLE_FACTOR" size="3"  value="<?=$mem->get('MULTIPLE_FACTOR')?>"  onclick="empty(this, '<?=$NAME[$lang_idx]?>');" style="width:50px;font-size:2em"/>
	</div>
	<div class="cell" >
		
		<input type="checkbox" id="activetaf" name="active<?=$line["day"]?>"  value="<?=$line["active"]?>" <? if ($line["active"] == 1) echo "checked=\"checked\""; ?> />
		
	</div>
	<div class="cell">
		<span >taf</span>	 
		<input id="langtaf" name="lang<?=$line["lang"]?>" size="1"  value="-1" style="width:0"  />
		
	</div>
	
	<div class="cell">
		
		<!-- <input id="commandtaf" name="command<?=$line["lang"]?>" size="1" value="<?=$_POST['command']?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /> -->
		<img src="images/check.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'U', 'taf')" style="cursor:pointer" />
	</div>
	<div class="cell">
		
		<textarea id="descriptiontaf" name="Description<?=$line["lang"]?>" rows="4" style="width:280px;font-size: 1.1em;  min-height: 50px;text-align:left;margin:0" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /><? if ($line["active"] == 0) echo getUpdatedForecast(); else echo preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]);?></textarea>
		
	</div>
	<div class="cell">
    <span id="datetaf"><?=$mem->get('datetaf')?></span><br /><span id="timetaf"><?=$mem->get('timetaf')?>:00</span>
    </div>
    
    
	
	<!-- <div class="cell">
		<input type="checkbox" id="taf" value=""  onclick="disableOthers(this)" />
	</div> -->

	
</div>
    
<?
if ($line["active"]==1)
    $mem->set('taf', preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]));
else {
    $mem->delete('taf');
}
} ?>



<?

$query = "SELECT d.active, d.idx, d.lang0, d.lang1, d.TempLow, d.TempLowCloth, d.TempHigh, d.date, d.day_name, d.icon, d.iconmorning, d.iconnight, d.TempNight, d.TempNightCloth, d.TempHighCloth, d.humMorning, d.humDay, d.humNight, d.windMorning, d.windDay, d.windNight, a.likes, a.dislikes From forecast_days d left join forecast_days_archive a on d.idx = a.idx ORDER BY d.idx";
if(!$stmt->prepare($query))
{
    print "Failed to prepare statement\n";
}
$stmt->execute();
$results = $stmt->get_result();

$lines = 0;

$forecastDaysDB = $mem->get('forecastDaysDB');

while ($line = $results->fetch_array(MYSQLI_ASSOC)) {
	$lines++;
	$linesInColumn++;
	$col = 0;
	$timestamp_date = strtotime($line["date_chat"]);
        if ($line["active"] == "1")
         {
            //array_push($forecastDaysDB, array('liked' => array(), 'disliked' => array(), 'lang0' => urlencode($line["lang0"]), 'lang1' => urlencode($line["lang1"]),  'TempLow' => $line["TempLow"], 'TempHigh' => $line["TempHigh"], 'date' => $line["date"], 'day_name' => $line["day_name"], 'icon' => $line["icon"], 'TempNight' => $line["TempNight"], 'TempNightCloth' => $line["TempNightCloth"], 'TempHighCloth' => $line["TempHighCloth"]));
            if ($_POST['reloadf'] == 1){
                $forecastDaysDB[$line["idx"]] = array('likes' => array(), 
                                                      'dislikes' => array(), 
                                                      'lang0' => urlencode($line["lang0"]), 
                                                      'lang1' => urlencode($line["lang1"]),  
                                                      'TempLow' => $line["TempLow"], 
                                                      'TempHigh' => $line["TempHigh"], 
                                                      'date' => $line["date"], 
                                                      'day_name' => $line["day_name"], 
                                                      'icon' => $line["icon"], 
                                                      'iconmorning' => $line["iconmorning"], 
                                                      'iconnight' => $line["iconnight"], 
                                                      'TempNight' => $line["TempNight"], 
                                                      'TempNightCloth' => $line["TempNightCloth"], 
                                                      'TempLowCloth' => $line["TempLowCloth"], 
                                                      'TempHighCloth' => $line["TempHighCloth"],
                                                      'windMorning'=>$line["windMorning"], 
                                                      'windDay'=>$line["windDay"], 
                                                      'windNight'=>$line["windNight"], 
                                                      'humMorning'=>$line["humMorning"], 
                                                      'humDay'=>$line["humDay"], 
                                                      'humNight'=>$line["humNight"]);
                for ($i = 0;$i < $line["likes"];$i++)
                {
                    array_push($forecastDaysDB[$line["idx"]]["likes"], $i);
                }
                for ($i = 0;$i < $line["dislikes"];$i++)
                {
                    array_push($forecastDaysDB[$line["idx"]]["dislikes"], $i);
                }
            }
         }		
	?>

<div  class="<? if ($line["active"]==1) echo "inv_plain_3_zebra";?> small invcell" style="clear:both;margin-bottom:0.5em" id="<?=$line["idx"]?>">
    <div class="cell cellspace ">
    &nbsp;&nbsp;&nbsp;&nbsp;
        </div>
	<div class="cell">
	<img src="images/x.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'D', 'forecastd')" style="cursor:pointer" />
    </div>
    <div class="cell cellspace ">
    &nbsp;&nbsp;&nbsp;&nbsp;
        </div>
	<div class="cell">
			<a href="javascript: void(0)" onclick="additalic(getSelText(), 'lang1<?=$line["idx"]?>')"><img src="images/italic.png" title="italic" width="16" height="16" /></a>
    </div>
    <div class="cell cellspace ">
    &nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="cell">		
			<img src="images/plus.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, '', 'forecastd')" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/check.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'U', 'forecastd')" style="cursor:pointer" />
			
    </div>
    <div class="cell cellspace ">
    &nbsp;&nbsp;&nbsp;&nbsp;
        </div>
	<div class="cell shrinked">
		<input type="checkbox" id="active<?=$line["idx"]?>" name="active<?=$line["idx"]?>" value="<?=$line["active"]?>"  onclick="empty(this, '<?=$BODY[$lang_idx]?>');" <? if ($line["active"] == 1) echo "checked=\"checked\""; ?>  />
	</div>
        <div class="cell shrinked">
			 
		<input id="idx<?=$line["idx"]?>" name="idx<?=$line["idx"]?>" size="1"  value="<?=$line["idx"]?>"  onclick="empty(this, '<?=$NAME[$lang_idx]?>');" style="width:0px" />
		
	</div>
    
	<div class="cell" >
		<select size="1" id="day_name<?=$line["idx"]?>"  style="margin:0;width:60px;text-align:<?if (isHeb()) echo "right"; else echo "left";?>" name="day_name<?=$line["idx"]?>">  
			<option	 value="Sun" <? if ($line["day_name"]=="Sun") echo "selected"; ?>>Sun</option>
			<option	 value="Mon" <? if ($line["day_name"]=="Mon") echo "selected"; ?>>Mon</option>
			<option	 value="Tue" <? if ($line["day_name"]=="Tue") echo "selected"; ?>>Tue</option>
			<option	 value="Wed" <? if ($line["day_name"]=="Wed") echo "selected"; ?>>Wed</option>
			<option	 value="Thu" <? if ($line["day_name"]=="Thu") echo "selected"; ?>>Thu</option>
			<option	 value="Fri" <? if ($line["day_name"]=="Fri") echo "selected"; ?>>Fri</option>
			<option	 value="Sat" <? if ($line["day_name"]=="Sat") echo "selected"; ?>>Sat</option>
		</select>
		
		
    </div>
    
	<div class="cell shrinked">
			<input id="date<?=$line["idx"]?>" name="date<?=$line["idx"]?>" size="3"  value="<?=$line["date"]?>"  onclick="empty(this, '<?=$NAME[$lang_idx]?>');" style="width:40px"/>
	</div>
    
	<div  class="cell tempstart">
    <input id="templow<?=$line["idx"]?>" name="templow<?=$line["idx"]?>" size="1"  value="<?=$line["TempLow"]?>" style="width:20px;background-color:#33CCFF" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" />
		
	</div>
    <div class="cell shrinked">
		<input id="humMorning<?=$line["idx"]?>" name="humMorning<?=$line["idx"]?>" size="1"  value="<?=$line["humMorning"]?>" style="width:20px;background-color:#DDA0DD" />
	</div>
    <div class="cell shrinked">
		<input id="windMorning<?=$line["idx"]?>" name="windMorning<?=$line["idx"]?>" size="1"  value="<?=$line["windMorning"]?>" style="width:20px;background-color:#DDA000" />
	</div>
    <div class="cell">
		<a class="templow" title="temp_morning_cloth<?=$line["idx"]?>" href="javascript:void(0)" id="temp_morning_cloth<?=$line["idx"]?>"><img src="<? echo CLOTHES_PATH."/".$line["TempLowCloth"];?>" width="25px" height="25px" id="temp_morning_cloth<?=$line["idx"]?>_img" alt="<?=$line["TempLowCloth"]?>" /></a>
	</div>
    
    <div class="cell shrinked">
		<a class="icon_forecast" title="morning_icon<?=$line["idx"]?>" href="javascript:void(0)" id="morning_icon<?=$line["idx"]?>"><img src="images/icons/day/<?=$line["iconmorning"]?>" width="30px"  height="30px" id="morning_icon<?=$line["idx"]?>_img" /></a>
    </div>
    <div class="cell cellspace ">
    &nbsp;&nbsp;&nbsp;&nbsp;
        </div>
	<div class="cell ">
			<input id="temphigh<?=$line["idx"]?>" name="temphigh<?=$line["day"]?>" size="1"  value="<?=$line["TempHigh"]?>" style="width:20px;background-color:#FF3300" onclick="empty(this, '<?=$NAME[$lang_idx]?>');" />
	</div>
        <div class="cell shrinked">
		<input id="humDay<?=$line["idx"]?>" name="humDay<?=$line["idx"]?>" size="1"  value="<?=$line["humDay"]?>" style="width:20px;background-color:#DDA0DD" />
	</div>
    <div class="cell shrinked">
		<input id="windDay<?=$line["idx"]?>" name="windDay<?=$line["idx"]?>" size="1"  value="<?=$line["windDay"]?>" style="width:20px;background-color:#DDA000" />
	</div>
	<div class="cell">
		<a class="temphigh" title="temphigh_cloth<?=$line["idx"]?>" href="javascript:void(0)" id="temphigh_cloth<?=$line["idx"]?>"><img src="<? echo CLOTHES_PATH."/".$line["TempHighCloth"];?>" width="25px" height="25px" id="temphigh_cloth<?=$line["idx"]?>_img" alt="<?=$line["TempHighCloth"]?>" /></a>
	</div>
    <div class="cell shrinked">
		<a class="icon_forecast" title="day_icon<?=$line["idx"]?>" href="javascript:void(0)" id="day_icon<?=$line["idx"]?>"><img src="images/icons/day/<?=$line["icon"]?>" width="30px"  height="30px" id="day_icon<?=$line["idx"]?>_img" /></a>
    </div>
    <div class="cell cellspace ">
    &nbsp;&nbsp;&nbsp;&nbsp;
        </div>
	<div class="cell ">
		<input id="tempnight<?=$line["idx"]?>" name="tempnight<?=$line["idx"]?>" size="1"  value="<?=$line["TempNight"]?>" style="width:20px;background-color:#33CCFF;" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" />
	</div>
        <div class="cell shrinked">
		<input id="humNight<?=$line["idx"]?>" name="humNight<?=$line["idx"]?>" size="1"  value="<?=$line["humNight"]?>" style="width:20px;background-color:#DDA0DD" />
	</div>
    <div class="cell shrinked">
		<input id="windNight<?=$line["idx"]?>" name="windNight<?=$line["idx"]?>" size="1"  value="<?=$line["windNight"]?>" style="width:20px;background-color:#DDA000" />
	</div>
	<div class="cell shrinked">
			<a class="tempnight" title="tempnight_cloth<?=$line["idx"]?>" href="javascript:void(0)" id="tempnight_cloth<?=$line["idx"]?>"><img src="<?echo CLOTHES_PATH."/".$line["TempNightCloth"];?>" width="25px" height="25px" id="tempnight_cloth<?=$line["idx"]?>_img" alt="<?=$line["TempNightCloth"]?>" /></a>
	</div>
    <div class="cell shrinked">
		<a class="icon_forecast" title="night_icon<?=$line["idx"]?>" href="javascript:void(0)" id="night_icon<?=$line["idx"]?>"><img src="images/icons/day/<?=$line["iconnight"]?>" width="30px"  height="30px" id="night_icon<?=$line["idx"]?>_img" /></a>
    </div>
    
    
       
	
        
        
       
	
    <div style="clear:both" class="cell shrinked">
			
            <textarea id="lang1<?=$line["idx"]?>" name="lang1<?=$line["idx"]?>" size="80" rows="1"  value="<?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["lang1"]), ENT_QUOTES, "UTF-8")?>" style="font: bold 12px/14px Helvetiva, Arial, sans-serif;  max-height: 215px;text-align:right;direction:rtl;margin:0" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" ><?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["lang1"]), ENT_QUOTES, "UTF-8")?></textarea>
        </div>
		<div id="day_href_plugin<?=$line["idx"]?>" class="cell">
			<a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15"  /></a>
    </div>
         <div style="clear:both" class="cell shrinked">
        <textarea id="lang0<?=$line["idx"]?>" name="lang0<?=$line["idx"]?>" size="40" rows="1"  value="<?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["lang0"]), ENT_QUOTES, "UTF-8")?>" style="font: bold 12px/14px Helvetiva, Arial, sans-serif; width:340px; max-height: 215px;text-align:left;margin:0" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" ><?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["lang0"]), ENT_QUOTES, "UTF-8")?></textarea>
        <span style="font-size:2.1em"><?//=$forecastDaysDB[$line["idx"]]['lang2']?></span>
	</div>
	<div id="day_href_plugin<?=$line["idx"]?>" class="cell" >
			<a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15"  /></a>
	</div>
	
        
        
</div>
<?
}
if ($_POST['reloadf'] == 1)
    $mem->set('forecastDaysDB',$forecastDaysDB);
//var_dump($forecastDaysDB);
?>
<?
$query = "SELECT * FROM  `content_sections` WHERE TYPE =  'LAlert'";
$result = mysqli_query($link, $query);
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
?>
<div  class="invcell <? if ($line["active"]==1) echo "inv_plain_3_zebra";?>" style="float:left" id="LAlert<?=$line["lang"]?>">
	
	<div class="cell">
		
		<input type="checkbox" id="activeLAlert<?=$line["lang"]?>" name="active<?=$line["day"]?>" value="<?=$line["active"]?>" <? if ($line["active"] == 1) echo "checked=\"checked\""; ?> />
		
	</div>
    <div class="cell" style="width:80px">
		<span><?=date('Y-m-d G:i D ', $mem->get('latestalerttime'.$line["lang"]))?></span>
		
	</div>
	<div class="cell" style="visibility:hidden;width:0">
		<span >forecast<?=$line["lang"]?></span>	 
		<input id="langLAlert<?=$line["lang"]?>" name="lang<?=$line["lang"]?>" size="1"  value="<?=$line["lang"]?>" readonly="readonly" style="width:0" />
		
	</div>
	<div class="cell" >
		
		<textarea id="descriptionLAlert<?=$line["lang"]?>" class="floated" name="Description<?=$line["lang"]?>" rows="1" value="<?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES , "UTF-8")?>" style="font: bold 12px/14px Helvetiva, Arial, sans-serif;  height: 50px;text-align:<?if ($line["lang"] == 1) echo "right"; else echo "left";?>;direction:<?if ($line["lang"] == 1) echo "rtl";?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" ><?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8")?></textarea>
		
	</div>
    
	<div id="forecast_href_plugin" class="float cell">
			<a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15"  /></a>
	</div>
	<div class="cell">
			<a href="javascript: void(0)" onclick="additalic(getSelText(), 'latestalert<?=$line["lang"]?>')"><img src="images/italic.png" title="italic" width="16" height="16" /></a>
	</div>
	<div class="cell btnsstart" style="width:20px">
		
		<!-- <input id="commandforecast<?=$line["lang"]?>" name="command<?=$line["lang"]?>" size="1" value="<?=$_POST['command']?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /> -->
		
        <img src="images/plus.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, '', 'LAlert')" style="cursor:pointer" />&nbsp;&nbsp;
        <img src="images/check.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'U', 'LAlert')" style="cursor:pointer" />
	</div>
		
	<!-- <div class="cell">
		<input type="checkbox" id="forecast<?=$line["lang"]?>" value=""  onclick="disableOthers(this)" />
	</div> -->
</div>
<?
//apc_store('latestalert'.$line["lang"], $line["Description"]);
//apc_store('latestalerttime'.$line["lang"], strtotime($line["updatedTime"]));
} ?>
<?
$query = "SELECT * FROM  `content_sections` WHERE TYPE =  'forecast'";
$result = mysqli_query($link, $query);
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
?>
<div  class="<? if ($line["active"]==1) echo "inv_plain_3_zebra";?> invcell" style="float:left" id="forecast<?=$line["lang"]?>">
	
	<div class="cell">
		
		<input type="checkbox" id="activeforecast<?=$line["lang"]?>" name="active<?=$line["day"]?>" value="<?=$line["active"]?>" <? if ($line["active"] == 1) echo "checked=\"checked\""; ?> />
		
	</div>
    <div class="cell" style="width:80px">
		<span><?=date('Y-m-d G:i D ', $mem->get('descriptionforecasttime'.$line["lang"]))?></span>
		
	</div>
	<div class="cell" style="visibility:hidden;width:0">
		<span >forecast<?=$line["lang"]?></span>	 
		<input id="langforecast<?=$line["lang"]?>" name="lang<?=$line["lang"]?>" size="1"  value="<?=$line["lang"]?>" readonly="readonly" style="width:0" />
		
	</div>
	<div class="cell">
		
		<textarea id="descriptionforecast<?=$line["lang"]?>" class="floated" name="Description<?=$line["lang"]?>" rows="1" value="<?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES , "UTF-8")?>" style="font: bold 12px/14px Helvetiva, Arial, sans-serif;  height: 50px;text-align:<?if ($line["lang"] == 1) echo "right"; else echo "left";?>;direction:<?if ($line["lang"] == 1) echo "rtl";?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" ><?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8")?></textarea>
		
	</div>
    
	<div id="forecast_href_plugin" class="float btnsstart" style="padding:0.3em 0.3em 0em 0.3em">
			<a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15"  /></a>
	</div>
	<div class="cell">
			<a href="javascript: void(0)" onclick="additalic(getSelText(), 'descriptionforecast<?=$line["lang"]?>')"><img src="images/italic.png" title="italic" width="16" height="16" /></a>
	</div>
	<div class="cell btnsstart">
		
		<!-- <input id="commandforecast<?=$line["lang"]?>" name="command<?=$line["lang"]?>" size="1" value="<?=$_POST['command']?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /> -->
		<img src="images/check.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'U', 'forecast')" style="cursor:pointer" />
	</div>
		
	<!-- <div class="cell">
		<input type="checkbox" id="forecast<?=$line["lang"]?>" value=""  onclick="disableOthers(this)" />
	</div> -->
</div>
<?
//apc_store('descriptionforecast'.$line["lang"], $line["Description"]);
//apc_store('descriptionforecasttime'.$line["lang"], strtotime($line["updatedTime"]));
} ?>

<?

$query = "call GetCurrentStory";
$result = mysqli_query($link, $query) or die("Error mysqli_query: ".mysqli_error($link));
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
?>
<div  class="<? if ($line["active"]==1) echo "inv_plain_3_zebra";?> invcell" style="float:left" id="CurrStory<?=$line["lang"]?>">
	
	<div style="float:<?echo get_s_align();?>;padding:1em 0.3em 0em 0.3em">
		
		<input id="activeCurrStory<?=$line["lang"]?>" name="active<?=$line["active"]?>" size="1"  type="checkbox" value="<?=$line["active"]?>" style="text-align:<?if ($line["lang"] == 1) echo "right"; else "left";?>"   <? if ($line["active"] == 1) echo "checked=\"checked\""; ?> /><br /><br />link<br />img<br />Idx
		
	</div>
	<div class="cell">
		<input id="idxCurrStory<?=$line["lang"]?>" name="idx<?=$line["lang"]?>" size="2" style="width:50px" value="<?=$line["Idx"]?>"  /><span >CurrStory<?=$line["lang"]?></span><br />	 
		<input id="langCurrStory<?=$line["lang"]?>" name="lang<?=$line["lang"]?>" size="1"  value="<?=$line["lang"]?>"  readonly="width:80px;readonly" style="width:8px" /><br />
		<input id="titleCurrStory<?=$line["lang"]?>" name="title<?=$line["lang"]?>" size="18" value="<?=$line["Title"]?>" style="width:80px;text-align:<?if ($line["lang"] == 1) echo "right;direction:rtl"; else "left";?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /><br />
		<input id="hrefCurrStory<?=$line["lang"]?>" name="href<?=$line["lang"]?>" size="18"  value="<?=$line["href"]?>" style="width:80px;text-align:left" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /><br />
		<input id="imgCurrStory<?=$line["lang"]?>" name="img<?=$line["lang"]?>" size="18"  value="<?=$line["img_src"]?>" style="width:80px;text-align:left" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /><br />
		
	</div>
	
	
	<div class="cell">
		
		<textarea id="descriptionCurrStory<?=$line["lang"]?>" class="floated" name="Description<?=$line["lang"]?>" size="100"  value="<?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8")?>" style="height:200px;font: bold 12px/14px Helvetiva, Arial, sans-serif;  max-height: 120px;text-align:<?if ($line["lang"] == 1) echo "right"; else echo "left";?>;direction:<?if ($line["lang"] == 1) echo "rtl";?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" ><?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8")?></textarea>
		
	</div>
	
	
			
	
	
	
    <div class="cell btnsstart" style="width:20px">
        <div class="cell" id="currstory_href_plugin" class="float btnsstart">
                <a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15"  /></a>
        </div>
        <div class="cell">
            <a href="javascript: void(0)" onclick="additalic(getSelText(), 'descriptionCurrStory<?=$line["lang"]?>')"><img src="images/italic.png" title="italic" width="16" height="16" /></a>
        </div>
		<!-- <input id="commandCurrStory<?=$line["lang"]?>" name="command<?=$line["lang"]?>" size="1" value="<?=$_POST['command']?>" style="text-align:<?if ($line["lang"] == 1) echo "right"; else "left";?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /> -->
		<img src="images/plus.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'ISTORY', 'mainstory')" style="cursor:pointer" />
		<img src="images/check.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'USTORY',  'mainstory')" style="cursor:pointer" />
	</div>
	<!-- <div class="cell">
		<input type="checkbox" id="CurrStory<?=$line["lang"]?>" value=""  onclick="disableOthers(this)" />
	</div> -->
	
	
</div>
<?
$mem->set('CurrentStory'.$line["lang"], htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8"));
} ?>
</div>
<div style="width:85%;float:<?echo get_s_align();?>;padding:0">
<?include "forecastPrime.php";?>
</div>
<!-- <div style="clear:both;float:<?echo get_s_align();?>;padding:0.3em 1em 0em 0em">
		<input type="button" name="SendButton" value="<? if (isHeb()) echo "שליחה"; else echo "Send"; ?>" class="tbl" onclick="getUFService()"/>
</div> -->
<!-- This contains the hidden content for inline calls -->
	<div style='display:none'>
		<div id='href_dialog' >
		<div id="link_title_div">
			<div><?=$LINK_TITLE[$lang_idx]?> </div>
			<input id="linktitle" name="linktitle" size="50" maxlength="50" value=""  />
			
		</div>
		<div id="link_href_div">
			<div><?=$LINK[$lang_idx]?> </div>
			<input id="linkhref" name="linkhref" size="50" maxlength="500" value=""  />
			
		</div>
		<div class="spacer">&nbsp;</div>
		<div class="spacer">&nbsp;</div>
		<div class="float">
			<input type="button" name="SendButton" value="<? if (isHeb()) echo "שליחה"; else echo "Send"; ?>" class="inv_plain_3" onclick="addlinkToDayForecast()"/>
		</div>
		<div class="float">
            <input type="button" name="SendButton" value="<? if (isHeb()) echo "ביטול"; else echo "Cancel"; ?>" class="inv_plain_3" onclick="closeLinktoMessage()"/>
        </div>
		</div>
	</div>
<div style='display:none'>
<div id='icons_dialog' >
<? $forcast_icons = array(); $forcast_icons = getfilesFromdir(ICONS_PATH); foreach ($forcast_icons as $icon)
	{ ?>
<div class="float">
	<img align="middle" src="<?=$icon[1]?>" width="50px" height="50px" onclick="addForecastIconToMessage(this)" style="cursor:pointer" alt="<?=$icon[1]?>" />
</div>
<? }?>
</div>
</div>

<div style='display:none'>
<div id='clothes_dialog' style='background-color:#eeeeee;height:150px'>
<? $clothes = array(); $clothes = getfilesFromdir(CLOTHES_PATH); foreach ($clothes as $cloth)
	{ ?>
<div class="float">
	<img align="middle" src="<?=$cloth[1]?>" width="50px" height="50px" onclick="addClothIconToMessage(this)" style="cursor:pointer" alt="<?=$cloth[1]?>" />
</div>
<? }?>
</div>


<?
// Free resultset 
$stmt->close();
@mysqli_free_result($result);
//var_dump($_POST);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script language="javascript">
 //<!--
  
 function additalic(strSelected, id)
 {
	//alert( strSelected);
	var body = document.getElementById(id);
	var locSelection = body.value.indexOf(strSelected);
	if (strSelected != '')
		body.value  = body.value.substr(0, locSelection) + '<em>' + strSelected + '</em>' + body.value.substr(locSelection + strSelected.length, body.value.length);
	else
		body.value = body.value + '<em>' + '</em>';
 }
 function addbold(strSelected, id)
 {
	 //alert( strSelected);
	var body = document.getElementById(id);
	var locSelection = body.value.indexOf(strSelected);
	if (strSelected != '')
		body.value  = body.value.substr(0, locSelection) + '<strong>' + strSelected + '</strong>' + body.value.substr(locSelection + strSelected.length, body.value.length);
	else
		body.value = body.value + '<strong>' + '</strong>';
 }

function getSelectionStart(o) {
 if (o.createTextRange) {
var r = document.selection.createRange().duplicate()
 r.moveEnd('character', o.value.length)
 if (r.text == '') return o.value.length
 return o.value.lastIndexOf(r.text)
 } else return o.selectionStart
}

function getSelectionEnd(o) {
 if (o.createTextRange) {
 var r = document.selection.createRange().duplicate()
 r.moveStart('character', -o.value.length)
 return r.text.length
 } else return o.selectionEnd
}
	
 function getSelText()
{
	var body = document.getElementById('body');
    var t = body.value, s = getSelectionStart(body), e = getSelectionEnd(body);
	if (s == 0 && e == 0) 
	{
		// get selection from outside
		var txt = '';
		if (window.getSelection)
		{
			txt = window.getSelection();
				 }
		else if (document.getSelection)
		{
			txt = document.getSelection();
				}
		else if (document.selection)
		{
			txt = document.selection.createRange().text;
				}

		return txt;
	}
	else
	return t.substring(s, e).replace(/ /g, '\xa0') || '\xa0';

}
 function empty (txtBox, startvalue)
 {
	if (txtBox.value == startvalue)
		txtBox.value = '';

 }
 function disableOthers(checkbox)
 {
	/*var currentIdx = checkbox.value;
	var idxs = document.getElementsByTagName("input"); 
	for (var i = 0; i < idxs.length; i++) { 
		if (idxs[i].type=="checkbox")  
			if (idxs[i].value != currentIdx) {
				if (checkbox.checked)
					idxs[i].disabled = true;
				else
					idxs[i].disabled = false;
			}
	}*/
 }
function check(checkbox)
{
	var check = document.getElementById(checkbox);
	if (!check.checked)
		check.checked = true;
	else
		check.checked = false;
}
function toggleClass(innerDiv)
{
	if (innerDiv.className == "inv_plain")
	{
		innerDiv.className = innerDiv.getAttribute('oldClass');
		
	}
		else	
	{
		innerDiv.setAttribute ('oldClass', innerDiv.className);
		innerDiv.className = "inv_plain";
		
	}

}
function fillForecast(str)
{
	var forecastDetails = document.getElementById('section');
	 if (forecastDetails.firstChild) {
	   forecastDetails.removeChild(forecastDetails.firstChild);
	 }
	 newDiv = document.createElement("div");
	 newDiv.innerHTML = str;
	 //forecastDetails.appendChild(newDiv); 
	 forecastDetails.innerHTML = str;
        $(".icon_forecast").colorbox({width:"35%", inline:true, href:"#icons_dialog"});
        $(".templow").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});
        $(".temphigh").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});
        $(".tempnight").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});
        $(".href").colorbox({width:"35%", inline:true, href:"#href_dialog"});
        $.getScript( "footerScripts250320.php?lang=<?=$lang_idx?>&temp_unit=<?if (empty($_GET['tempunit'])) echo "°c"; else echo $_GET['tempunit'];?>");
        
}

function getOneUFService(dayToSave, command, type)
{
	//alert (dayToSave);
	var active;
        var reload;
        if(document.getElementById('reloadf').checked)
            reload = 1;
        else
            reload = 0;
	if (document.getElementById('active'+dayToSave).checked)
		active = 1;
	else
		active = 0;
	if (!document.getElementById('description'+dayToSave))
    {
            //alert('day');
            var idx = document.getElementById('idx'+dayToSave).value;
            var day;
            var date = document.getElementById('date'+dayToSave).value;
            var day_name = document.getElementById('day_name'+dayToSave).value;
            var full_day_icon = $("#" + 'day_icon' + dayToSave).children().attr("src");
            var full_morning_icon = $("#" + 'morning_icon' + dayToSave).children().attr("src");
            var full_night_icon = $("#" + 'night_icon' + dayToSave).children().attr("src");
            var day_icon = full_day_icon.substr(full_day_icon.lastIndexOf("/")+1);
            var morning_icon = full_morning_icon.substr(full_morning_icon.lastIndexOf("/")+1);
            var night_icon = full_night_icon.substr(full_night_icon.lastIndexOf("/")+1);
            var humMorning = document.getElementById('humMorning'+dayToSave).value;
            var humDay = document.getElementById('humDay'+dayToSave).value;
            var humNight = document.getElementById('humNight'+dayToSave).value;
            var windMorning = document.getElementById('windMorning'+dayToSave).value;
            var windDay = document.getElementById('windDay'+dayToSave).value;
            var windNight = document.getElementById('windNight'+dayToSave).value;
            var temp_low = document.getElementById('templow'+dayToSave).value;
            var temp_high = document.getElementById('temphigh'+dayToSave).value;
            var full_temp_high_cloth = $("#" + 'temphigh_cloth' + dayToSave).children().attr("src");
            var full_temp_morning_cloth = $("#" + 'temp_morning_cloth' + dayToSave).children().attr("src");
            var temp_high_cloth = full_temp_high_cloth.substr(full_temp_high_cloth.lastIndexOf("/")+1);

            var temp_night = document.getElementById('tempnight'+dayToSave).value;
            var full_temp_night_cloth = $("#" + 'tempnight_cloth' + dayToSave).children().attr("src");
            var temp_night_cloth = full_temp_night_cloth.substr(full_temp_night_cloth.lastIndexOf("/")+1); 
            var temp_morning_cloth = full_temp_morning_cloth.substr(full_temp_morning_cloth.lastIndexOf("/")+1); 

            //var temp_day = document.getElementById('tempday'+dayToSave).value;
            var lang1 = document.getElementById('lang1'+dayToSave).value;
            var lang0 = document.getElementById('lang0'+dayToSave).value;
            var postData = "reload=" + reload + "&idx=" + idx + "&command=" + command + "&day=" + day + "&windMorning=" + windMorning + "&windDay=" + windDay + "&windNight=" + windNight + "&humMorning=" + humMorning + "&humDay=" + humDay + "&humNight=" + humNight + "&templow=" + temp_low + "&temphigh=" + temp_high + "&temp_morning_cloth=" + temp_morning_cloth + "&temphigh_cloth=" + temp_high_cloth + "&tempnight=" + temp_night + "&tempnight_cloth=" + temp_night_cloth + "&lang1=" + escape(encodeURI(lang1)) + "&lang0=" + lang0 + "&active=" + active + "&day_name=" + day_name + "&date=" + date +  "&day_icon=" + day_icon +  "&morning_icon=" + morning_icon +  "&night_icon=" + night_icon;
    }
    else
    {
            //alert('message');

            var description = document.getElementById('description'+dayToSave).value;
            var lang = document.getElementById('lang'+dayToSave).value;
            var img_src = document.getElementById('img'+dayToSave);
            var max_time = document.getElementById('max_time').value;
            var multiple_factor = document.getElementById('MULTIPLE_FACTOR').value;
            if (img_src)
            {
                    img_src = img_src.value;	
            }
            var href = document.getElementById('href'+dayToSave);
            if (href)
            {
                    href = href.value;	
            }
            var title = document.getElementById('title'+dayToSave);
            if (title)
            {
                    title = title.value;
            }
            
            var postData = "reload=" + reload + "&command=" + command + "&lang=" + lang + "&description=" + escape(encodeURI(description)) + "&title=" + escape(encodeURI(title)) + "&active=" + active + "&type=" + type + "&max_time=" + max_time + "&multiple_factor=" + multiple_factor + "&img_src=" + escape(encodeURI(img_src)) + "&href=" + escape(encodeURI(href));
    }
    
    
    var ajax = new Ajax();
    ajax.method = 'POST';
    ajax.setMimeType('text/html');
    ajax.postData = postData;
    ajax.setHandlerBoth(fillForecast);
    fillForecast('<img src="images/loading.gif" alt="loading" />');
    ajax.url = 'updateForecast.php';
    ajax.doReq();
    
                
}
function updateLikes(idx, command)
{
   $.ajax({
        type: "POST",
        url: "forecastlikes_service.php",
        data: {idx:idx,command:command},
   }).done(function(str){if (command == "like")  fillLikes(str);
                            else fillDislikes(str)});
}
function fillDislikes(jsonstr)
{
    var jsonD = JSON.parse( jsonstr  );
    $("#divlikes" + jsonD.dislikes[0].idx + " .dislikes").html(jsonD.dislikes[0].count);
}
function fillLikes(jsonstr)
{
    var jsonL = JSON.parse( jsonstr  );
    $("#divlikes" + jsonL.likes[0].idx + " .likes").html(jsonL.likes[0].count);
}
function getUFService()
{	
	var idx = "";
	var dayToSave = new Array();
	var idxs = document.getElementsByTagName("input"); 
	for (var i = 0; i < idxs.length; i++) { 
		if (idxs[i].type=="checkbox")  
			if (idxs[i].checked) { 
				idx = idxs[i].value; 
				dayToSave.push(idxs[i].parentNode.parentNode.id);
				//alert (idxs[i].parentNode.parentNode.id);
   			}
	}
	if (dayToSave.length  == 0)
		return false;
	
	for (var i = 0; i < dayToSave.length; i++) {
		//alert('update ' + dayToSave[i]);
		var command = document.getElementById('command'+dayToSave[i]).value;
		getOneUFService(dayToSave[i], command,'');
	}
	
}
function onLoad()
{
	fillForecast('<img src="images/loading.gif" alt="loading" />');
	var ajax = new Ajax();
	ajax.method = 'POST';
	ajax.setMimeType('text/html');
	ajax.setHandlerBoth(fillForecast);
	ajax.postData = "lang=" + "<?=$lang_idx?>" + "&limit=" + "<?=$limitLines?>" + "&update=<?=$_GET['update']?>";
	ajax.url = 'chat_service.php';
	ajax.doReq();
}

function addlinkToDayForecast()
	{
		var currentId = "#"+$.colorbox.element().parent().prev().children("textarea").attr('id');
		
		$(currentId).val($(currentId).val() + " <a href=" + $("#linkhref").val() + " target=_blank>" + $("#linktitle").val() + "</a> ");
		$("#cboxClose").click();
        
        
		$(currentId).focus();
		
	}
	function closeLinktoMessage()
    {
	                
	        $("#cboxClose").click();
            
            
	        	        
    }

	function addForecastIconToMessage(img)
	{
		//alert ($("#cboxTitle").html());
		//$("#chat_mood").html("<input type=\"hidden\" value=\"" + img.src + "\" name=\"mood_img\" />");
		$("#" + $("#cboxTitle").html()).html("<img src=\"" + img.src + "\" width=\"40px\" id=\"" + $("#cboxTitle").html() + "_img\" alt=\"" + "\" />");
		$("#cboxClose").click();
       
       
	
	}
	function addClothIconToMessage(img)
	{
		//alert ($("#cboxTitle").html());
		//$("#chat_mood").html("<input type=\"hidden\" value=\"" + img.src + "\" name=\"mood_img\" />");
		$("#" + $("#cboxTitle").html()).html("<img src=\"" + img.src + "\" width=\"40px\" id=\"" + $("#cboxTitle").html() + "_img\" alt=\"" + "\" />");
		$("#cboxClose").click();
        
        
	
	}
	function addbr(currentbr)
	{
		var currentId = "#"+$("#"+currentbr).parent().find("textarea").attr('id');
		//alert (currentId);
		$(currentId).val($(currentId).val() + " <br/> ");
		$("#cboxClose").click();
        
        
		$(currentId).focus();
	}

function htmlentities (string, quote_style) {
    // Convert all applicable characters to HTML entities  
    // 
    // version: 1102.614
    // discuss at: http://phpjs.org/functions/htmlentities    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: nobbler
    // +    tweaked by: Jack
    // +   bugfixed by: Onno Marsman    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Ratheous
    // -    depends on: get_html_translation_table
    // *     example 1: htmlentities('Kevin & van Zonneveld');    // *     returns 1: 'Kevin &amp; van Zonneveld'
    // *     example 2: htmlentities("foo'bar","ENT_QUOTES");
    // *     returns 2: 'foo&#039;bar'
    var hash_map = {},
        symbol = '',        tmp_str = '',
        entity = '';
    tmp_str = string.toString();
 
    if (false === (hash_map = this.get_html_translation_table('HTML_ENTITIES', quote_style))) {        return false;
    }
    hash_map["'"] = '&#039;';
    for (symbol in hash_map) {
        entity = hash_map[symbol];        tmp_str = tmp_str.split(symbol).join(entity);
    }
 
    return tmp_str;
}	
 //-->
 </script>


</div>
</div>
					
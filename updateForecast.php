<?
define("MANAGER_NAME","bn");
define("ICONS_PATH","images/icons/day");
define("CLOTHES_PATH","images/clothes");
ini_set("display_errors","On");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
?>
<div style="position:absolute;left:-480px;width:1780px;">
<div style="width:54%;clear:both;margin:0;padding:0m;text-align:right;float:right"  id="forDetails">
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

function insertNewMessage ($day, $day_name, $date, $temp_low, $temp_high, $temp_high_cloth, $temp_night, $temp_night_cloth, $temp_day, $lang0, $lang1, $active, $icon)
{
		
		$now = date('Y-m-d G:i:s', strtotime("-1 hours 0 minutes", time()));
		//$now = getLocalTime(time());
		$lang0 = nl2br($lang0);
		$lang1 = nl2br($lang1);
		$query = "INSERT INTO forecast_days (day, day_name, date, TempLow, TempHigh, TempHighCloth, TempNight, TempNightCloth, lang0, lang1, active, icon) VALUES('{$day}', '{$day_name}', '{$date}', '{$temp_low}', '{$temp_high}', '{$temp_high_cloth}', '{$temp_night}', '{$temp_night_cloth}', '{$lang0}', '{$lang1}', '{$active}', '{$icon}');";
		//echo $query;
		$result = db_init($query);
		// Free resultset 
		@mysqli_free_result($result);
		
	//}
}

function updateForecastMessage ($lang, $desc, $active)
{
		$now = date('Y-m-d G:i:s', strtotime("-1 hours 0 minutes", time()));
		//$now = getLocalTime(time());
		$desc = nl2br($desc);
		$query = "UPDATE `content_sections` SET Description='{$desc}' , active={$active} WHERE (lang=$lang) and (type='forecast')";
		//echo $query;
		$result = db_init($query);
		// Free resultset 
		@mysqli_free_result($result);
		
	//}
}

function updateForecastDay ($day, $day_name, $date, $temp_low, $temp_high, $temp_high_cloth, $temp_night, $temp_night_cloth, $temp_day, $lang0, $lang1, $active, $icon)
{
		$now = date('Y-m-d G:i:s', strtotime("-1 hours 0 minutes", time()));
		//$now = getLocalTime(time());
		$lang0 = nl2br($lang0);
		$lang1 = nl2br($lang1);
		$query = "UPDATE forecast_days SET TempLow='{$temp_low}', TempHigh='{$temp_high}',  TempHighCloth='{$temp_high_cloth}', TempNight='{$temp_night}', TempNightCloth='{$temp_night_cloth}', TempDay='{$temp_day}', lang0='{$lang0}', lang1='{$lang1}' , active={$active}, icon='{$icon}', date='{$date}', day_name='{$day_name}'  WHERE (day=$day)";
		
		//echo $query;
		$result = db_init($query);
		// Free resultset 
		@mysqli_free_result($result);
		
	
}

function updateMessageFromMessages ($description, $active, $type, $lang, $href, $img_src, $title)
{
		$description = nl2br($description);
		$now = date('Y-m-d G:i:s');
		//$now = getLocalTime(time());
		if ($lang>=0)
			$query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}',updatedTime='{$now}'  WHERE (type='$type') and (lang=$lang)";
		else
			$query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}',updatedTime='{$now}'  WHERE (type='$type')";
		//echo $query;
		$result = db_init($query );
		// Free resultset 
		@mysqli_free_result($result);
	
}
function updateMainStory ($description, $lang, $href, $img_src, $title)
{
		global $link;
		$description = nl2br($description);
		$now = date('Y-m-d G:i:s');
		//$now = getLocalTime(time());
		$query = "SELECT  max(Idx) idx FROM `mainstory`  where (lang=?) ";
		$result = db_init($query, $lang);
		$description = str_replace ("'", "`", $description);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
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
                apc_store('mainstory'.$lang, $MainStory);
	
}
function insertMainStory ($description, $lang, $href, $img_src, $title)
{
		$description = nl2br($description);
		$now = date('Y-m-d G:i:s');
		$query = "call InsertNewStory('{$description}', '{$href}', '{$img_src}', '{$title}', {$lang})";
		//echo $query;
		$result = db_init($query );
		// Free resultset 
		@mysqli_free_result($result);
                $MainStory = new ContentSection();
                $MainStory->set_description($description);
                $MainStory->set_img_src($img_src);
                $MainStory->set_href($href);
                $MainStory->set_Title($title);
                apc_store('mainstory'.$lang, $MainStory);
	
}

function deleteMessage ($day)
{
		$result = db_init("DELETE FROM forecast_days WHERE (day=?)", $day);
		// Free resultset 
		@mysqli_free_result($result);
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

$icons = get_Fromdir(ICONS_PATH);
$clothes = get_Fromdir(CLOTHES_PATH);
if ((trim($_POST['command']) == "D") && ($_POST['day'] != ""))
{
	deleteMessage($_POST['day']);
}
else if ((trim($_POST['command']) == "U"))
{
	if ($_POST['day'] != "")
		updateForecastDay ($_POST['day'], $_POST['day_name'], $_POST['date'], $_POST['templow'], $_POST['temphigh'],  $_POST['temphigh_cloth'], $_POST['tempnight'], $_POST['tempnight_cloth'], $_POST['tempday'], $_POST['lang0'],  urldecode($_POST['lang1']), $_POST['active'], $_POST['day_icon']);
	else if ($_POST['description'] != "")
		updateMessageFromMessages (html_entity_decode(urldecode($_POST['description'])), $_POST['active'], $_POST['type'], $_POST['lang'],urldecode($_POST['href']) ,urldecode($_POST['img_src']),urldecode($_POST['title']));
}
else if ($_POST['day'] != "")
{
	insertNewMessage($_POST['day'], $_POST['day_name'], $_POST['date'], $_POST['templow'], $_POST['temphigh'],   $_POST['temphigh_cloth'], $_POST['tempnight'],  $_POST['tempnight_cloth'], $_POST['tempday'], $_POST['lang0'],  urldecode($_POST['lang1']), $_POST['active'], $_POST['day_icon']);
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
?>

<?
$langp = 0;
$link = new mysqli(MYSQL_IP, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
$link->query("SET NAMES utf8;");
$query = "SELECT * FROM content_sections WHERE TYPE =  'taf' and lang=?";
$stmt = $link->stmt_init();
if(!$stmt->prepare($query))
{
    print "Failed to prepare statement\n";
}
$stmt->bind_param('d' , $langp);
$stmt->execute();
$result = $stmt->get_result();

while ($line = $result->fetch_array(MYSQL_ASSOC)) {
?>
<div  class="<? if ($line["active"]==1) echo "inv_plain_3_zebra";?>" style="width:100%;float:<?echo get_s_align();?>;clear:both;padding:0.2em" id="taf">
	
	<div style="float:<?echo get_s_align();?>;padding:0.5em" >
		
		<input type="checkbox" id="activetaf" name="active<?=$line["day"]?>"  value="<?=$line["active"]?>" <? if ($line["active"] == 1) echo "checked=\"checked\""; ?> />
		
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em">
		<span >taf</span>	 
		<input id="langtaf" name="lang<?=$line["lang"]?>" size="1"  value="-1" style="width:0"  />
		
	</div>
	
	
	<div style="float:<?echo get_s_align();?>;padding:0.5em">
		
		<textarea id="descriptiontaf" name="Description<?=$line["lang"]?>" rows="1" style="font: 10px/12px Helvetiva, Arial, sans-serif;  max-height: 215px;width: 650px;text-align:left" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /><? if ($line["active"] == 0) echo getUpdatedForecast(); else echo preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]);?></textarea>
		
	</div>
	
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		
		<!-- <input id="commandtaf" name="command<?=$line["lang"]?>" size="1" value="<?=$_POST['command']?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /> -->
		<img src="images/check.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'U')" style="cursor:pointer" />
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.3em 0em 0.3em">
			<a href="javascript: void(0)" onclick="additalic(getSelText(), 'descriptiontaf')"><img src="images/italic.png" title="italic" width="16" height="16" /></a>
	</div>
	
	<!-- <div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		<input type="checkbox" id="taf" value=""  onclick="disableOthers(this)" />
	</div> -->

	
</div>
    
<?
if ($line["active"]==1)
    apc_store('taf', preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]));
else {
    apc_delete('taf');
}
} ?>



<?

$query = "SELECT * From forecast_days ORDER BY day";
if(!$stmt->prepare($query))
{
    print "Failed to prepare statement\n";
}
$stmt->execute();
$results = $stmt->get_result();

$lines = 0;
$forecastDaysDB = array();
while ($line = $results->fetch_array(MYSQLI_ASSOC)) {
	$lines++;
	$linesInColumn++;
	$col = 0;
	$timestamp_date = strtotime($line["date_chat"]);
        if ($line["active"] == "1")
         {
            array_push($forecastDaysDB, array('lang0' => urlencode($line["lang0"]), 'lang1' => urlencode($line["lang1"]),  'TempLow' => $line["TempLow"], 'TempHigh' => $line["TempHigh"], 'date' => $line["date"], 'day_name' => $line["day_name"], 'icon' => $line["icon"], 'TempNight' => $line["TempNight"], 'TempNightCloth' => $line["TempNightCloth"], 'TempHighCloth' => $line["TempHighCloth"]));
         }		
	?>

<div  class="<? if ($line["active"]==1) echo "inv_plain_3_zebra";?> small" style="width:100%;float:<?echo get_s_align();?>;clear:both;padding:0.5em" id="<?=$line["day"]?>">
	
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.2em 0em 0.2em">
		<input type="checkbox" id="active<?=$line["day"]?>" name="active<?=$line["day"]?>" value="<?=$line["active"]?>"  onclick="empty(this, '<?=$BODY[$lang_idx]?>');" <? if ($line["active"] == 1) echo "checked=\"checked\""; ?>  />
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.2em 0em 0.2em">
			 
		<input id="day<?=$line["day"]?>" name="day<?=$line["day"]?>" size="1"  value="<?=$line["day"]?>"  onclick="empty(this, '<?=$NAME[$lang_idx]?>');" style="width:25px" />
		
	</div>
	
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em;">
		<select size="1" id="day_name<?=$line["day"]?>"  style="width:60px;text-align:<?if (isHeb()) echo "right"; else echo "left";?>" name="day_name<?=$line["day"]?>">  
			<option	 value="Sun" <? if ($line["day_name"]=="Sun") echo "selected"; ?>>Sun</option>
			<option	 value="Mon" <? if ($line["day_name"]=="Mon") echo "selected"; ?>>Mon</option>
			<option	 value="Tue" <? if ($line["day_name"]=="Tue") echo "selected"; ?>>Tue</option>
			<option	 value="Wed" <? if ($line["day_name"]=="Wed") echo "selected"; ?>>Wed</option>
			<option	 value="Thu" <? if ($line["day_name"]=="Thu") echo "selected"; ?>>Thu</option>
			<option	 value="Fri" <? if ($line["day_name"]=="Fri") echo "selected"; ?>>Fri</option>
			<option	 value="Sat" <? if ($line["day_name"]=="Sat") echo "selected"; ?>>Sat</option>
		</select>
		
		
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.2em 0em 0.2em">
			<input id="date<?=$line["day"]?>" name="date<?=$line["day"]?>" size="3"  value="<?=$line["date"]?>"  onclick="empty(this, '<?=$NAME[$lang_idx]?>');" style="width:40px"/>
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.2em 0em 0.2em">
		<a class="icon_forecast" title="day_icon<?=$line["day"]?>" href="javascript:void(0)" id="day_icon<?=$line["day"]?>"><img src="images/icons/day/<?=$line["icon"]?>" width="50px"  height="30px" id="day_icon<?=$line["day"]?>_img" /></a>
	</div>
	
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.2em 0em 0.2em">
			
		<textarea id="lang1<?=$line["day"]?>" name="lang1<?=$line["day"]?>" size="80" rows="1"  value="<?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["lang1"]), ENT_QUOTES, "UTF-8")?>" style="font: bold 12px/14px Helvetiva, Arial, sans-serif;  max-height: 215px;width:500px;text-align:right;direction:rtl" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" ><?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["lang1"]), ENT_QUOTES, "UTF-8")?></textarea>
	</div>
	<div id="day_href_plugin<?=$line["day"]?>" class="float" style="padding:0.5em 0.2em 0em 0.2em">
			<a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15"  /></a>
			
			<img src="images/plus.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, '')" style="cursor:pointer" />
			<img src="images/check.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'U')" style="cursor:pointer" />
			<img src="images/x.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'D')" style="cursor:pointer" />
	</div>
	
	


	<div style="clear:both;float:<?echo get_s_align();?>;padding:0.5em 0.2em 0em 0.2em">
		
		<input id="templow<?=$line["day"]?>" name="templow<?=$line["day"]?>" size="1"  value="<?=$line["TempLow"]?>" style="width:30px;background-color:#33CCFF" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" />
		
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 1.5em 0em 0.2em">
			<input id="temphigh<?=$line["day"]?>" name="temphigh<?=$line["day"]?>" size="1"  value="<?=$line["TempHigh"]?>" style="width:30px;background-color:#FF3300" onclick="empty(this, '<?=$NAME[$lang_idx]?>');" />
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0em">
		<a class="temphigh" title="temphigh_cloth<?=$line["day"]?>" href="javascript:void(0)" id="temphigh_cloth<?=$line["day"]?>"><img src="<? echo CLOTHES_PATH."/".$line["TempHighCloth"];?>" width="40px" height="25px" id="temphigh_cloth<?=$line["day"]?>_img" alt="<?=$line["TempHighCloth"]?>" /></a>
		
		
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 1.5em 0em 0.2em">
		<input id="tempnight<?=$line["day"]?>" name="tempnight<?=$line["day"]?>" size="1"  value="<?=$line["TempNight"]?>" style="width:30px;background-color:#33CCFF;" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" />
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.2em 0em 0.2em">
			<a class="tempnight" title="tempnight_cloth<?=$line["day"]?>" href="javascript:void(0)" id="tempnight_cloth<?=$line["day"]?>"><img src="<?echo CLOTHES_PATH."/".$line["TempNightCloth"];?>" width="40px" height="25px" id="tempnight_cloth<?=$line["day"]?>_img" alt="<?=$line["TempNightCloth"]?>" /></a>
		
	
		
	</div>
		
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.2em 0em 0.2em">
		<textarea id="lang0<?=$line["day"]?>" name="lang0<?=$line["day"]?>" size="80" rows="1"  value="<?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["lang0"]), ENT_QUOTES, "UTF-8")?>" style="font: bold 12px/14px Helvetiva, Arial, sans-serif;  max-height: 215px;width:500px;text-align:left" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" ><?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["lang0"]), ENT_QUOTES, "UTF-8")?></textarea>
	</div>
	<div id="day_href_plugin<?=$line["day"]?>" class="float" style="padding:0.5em 0.2em 0em 0.2em">
			<a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15"  /></a>
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.3em 0em 0.3em">
			<a href="javascript: void(0)" onclick="additalic(getSelText(), 'lang1<?=$line["day"]?>')"><img src="images/italic.png" title="italic" width="16" height="16" /></a>
	</div>
	
	
</div>
<?
}
apc_store('forecastDaysDB',$forecastDaysDB);
?>
<?
$query = "SELECT * FROM  `content_sections` WHERE TYPE =  'forecast'";
$result = mysqli_query($link, $query);
while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
?>
<div  class="<? if ($line["active"]==1) echo "inv_plain_3_zebra";?>" style="width:100%;float:<?echo get_s_align();?>;clear:both;padding:0.2em 0.5em 0.2em 0.5em" id="forecast<?=$line["lang"]?>">
	
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		
		<input type="checkbox" id="activeforecast<?=$line["lang"]?>" name="active<?=$line["day"]?>" value="<?=$line["active"]?>" <? if ($line["active"] == 1) echo "checked=\"checked\""; ?> />
		
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em;visibility:hidden">
		<span >forecast<?=$line["lang"]?></span>	 
		<input id="langforecast<?=$line["lang"]?>" name="lang<?=$line["lang"]?>" size="1"  value="<?=$line["lang"]?>" readonly="readonly" style="width:0" />
		
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		
		<textarea id="descriptionforecast<?=$line["lang"]?>" name="Description<?=$line["lang"]?>" rows="1" value="<?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES , "UTF-8")?>" style="font: bold 12px/14px Helvetiva, Arial, sans-serif;  height: 50px;width: 600px;text-align:<?if ($line["lang"] == 1) echo "right"; else echo "left";?>;direction:<?if ($line["lang"] == 1) echo "rtl";?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" ><?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8")?></textarea>
		
	</div>
	<div id="forecast_href_plugin" class="float" style="padding:0.5em 0.5em 0em 0.5em">
			<a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15"  /></a>
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.3em 0em 0.3em">
			<a href="javascript: void(0)" onclick="additalic(getSelText(), 'descriptionforecast<?=$line["lang"]?>')"><img src="images/italic.png" title="italic" width="16" height="16" /></a>
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		
		<!-- <input id="commandforecast<?=$line["lang"]?>" name="command<?=$line["lang"]?>" size="1" value="<?=$_POST['command']?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /> -->
		<img src="images/check.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'U')" style="cursor:pointer" />
	</div>
		
	<!-- <div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		<input type="checkbox" id="forecast<?=$line["lang"]?>" value=""  onclick="disableOthers(this)" />
	</div> -->
</div>
<?
apc_store('descriptionforecast'.$line["lang"], htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8"));
apc_store('descriptionforecasttime'.$line["lang"], $line["updatedTime"]);
} ?>

<?

$query = "call GetCurrentStory";
$result = mysqli_query($link, $query) or die("Error mysqli_query: ".mysqli_error($link));
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
?>
<div  class="<? if ($line["active"]==1) echo "inv_plain_3_zebra";?>" style="width:100%;float:<?echo get_s_align();?>;clear:both;padding:0.2em 0.5em 0.2em 0.5em" id="CurrStory<?=$line["lang"]?>">
	
	<div style="float:<?echo get_s_align();?>;padding:1em 0.5em 0em 0.5em">
		
		<input id="activeCurrStory<?=$line["lang"]?>" name="active<?=$line["active"]?>" size="1"  type="checkbox" value="<?=$line["active"]?>" style="text-align:<?if ($line["lang"] == 1) echo "right"; else "left";?>"   <? if ($line["active"] == 1) echo "checked=\"checked\""; ?> /><br /><br />link<br />img<br />Idx
		
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		<span >CurrStory<?=$line["lang"]?></span>	 
		<input id="langCurrStory<?=$line["lang"]?>" name="lang<?=$line["lang"]?>" size="1"  value="<?=$line["lang"]?>"  readonly="readonly" style="width:100px" /><br />
		<input id="titleCurrStory<?=$line["lang"]?>" name="title<?=$line["lang"]?>" size="18" value="<?=$line["Title"]?>" style="width:100px;text-align:<?if ($line["lang"] == 1) echo "right"; else "left";?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /><br />
		<input id="hrefCurrStory<?=$line["lang"]?>" name="href<?=$line["lang"]?>" size="18"  value="<?=$line["href"]?>" style="width:100px;text-align:left" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /><br />
		<input id="imgCurrStory<?=$line["lang"]?>" name="img<?=$line["lang"]?>" size="18"  value="<?=$line["img_src"]?>" style="width:100px;text-align:left" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /><br />
		<input id="idxCurrStory<?=$line["lang"]?>" name="idx<?=$line["lang"]?>" size="2" style="width:100px" value="<?=$line["Idx"]?>"  />
	</div>
	
	
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		
		<textarea id="descriptionCurrStory<?=$line["lang"]?>" name="Description<?=$line["lang"]?>" size="100"  value="<?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8")?>" style="height:200px;font: bold 12px/14px Helvetiva, Arial, sans-serif;  max-height: 120px;width: 500px;text-align:<?if ($line["lang"] == 1) echo "right"; else echo "left";?>;direction:<?if ($line["lang"] == 1) echo "rtl";?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" ><?=htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8")?></textarea>
		
	</div>
	<div id="currstory_href_plugin" class="float" style="padding:0.5em 0.5em 0em 0.5em">
			<a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15"  /></a>
	</div>
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.3em 0em 0.3em">
			<a href="javascript: void(0)" onclick="additalic(getSelText(), 'descriptionCurrStory<?=$line["lang"]?>')"><img src="images/italic.png" title="italic" width="16" height="16" /></a>
	</div>
	
	
	<div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		
		<!-- <input id="commandCurrStory<?=$line["lang"]?>" name="command<?=$line["lang"]?>" size="1" value="<?=$_POST['command']?>" style="text-align:<?if ($line["lang"] == 1) echo "right"; else "left";?>" onclick="empty(this, '<?=$BODY[$lang_idx]?>');" /> -->
		<img src="images/plus.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'ISTORY')" style="cursor:pointer" />
		<img src="images/check.png" width="16px" onclick="getOneUFService(this.parentNode.parentNode.id, 'USTORY')" style="cursor:pointer" />
	</div>
	<!-- <div style="float:<?echo get_s_align();?>;padding:0.5em 0.5em 0em 0.5em">
		<input type="checkbox" id="CurrStory<?=$line["lang"]?>" value=""  onclick="disableOthers(this)" />
	</div> -->
	
	
</div>
<?
apc_store('CurrentStory'.$line["lang"], htmlentities (preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $line["Description"]), ENT_QUOTES, "UTF-8"));
} ?>
</div>
<div style="width:46%;float:<?echo get_s_align();?>;padding:0">
<?include "forecast.php";?>
</div>
<!-- <div style="clear:both;float:<?echo get_s_align();?>;padding:0.5em 1em 0em 0em">
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
			<input type="button" name="SendButton" value="<? if (isHeb()) echo "שליחה"; else echo "Send"; ?>" class="inv_plain_3" onclick="addlinkToMessage()"/>
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
<div id='clothes_dialog' >
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
@mysql_free_result($result);
//var_dump($_POST);
?>


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
        $(".temphigh").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});
        $(".tempnight").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});
        $(".href").colorbox({width:"35%", inline:true, href:"#href_dialog"});
}

function getOneUFService(dayToSave, command)
{
	//alert (dayToSave);
	var active;
	if (document.getElementById('active'+dayToSave).checked)
		active = 1;
	else
		active = 0;
	if (!document.getElementById('description'+dayToSave))
		{
			//alert('day');
			var day = document.getElementById('day'+dayToSave).value;
			var date = document.getElementById('date'+dayToSave).value;
			var day_name = document.getElementById('day_name'+dayToSave).value;
                        var full_day_icon = $("#" + 'day_icon' + dayToSave).children().attr("src");
			var day_icon = full_day_icon.substr(full_day_icon.lastIndexOf("/")+1);
                        
			var temp_low = document.getElementById('templow'+dayToSave).value;
			var temp_high = document.getElementById('temphigh'+dayToSave).value;
			var full_temp_high_cloth = $("#" + 'temphigh_cloth' + dayToSave).children().attr("src");
                        var temp_high_cloth = full_temp_high_cloth.substr(full_temp_high_cloth.lastIndexOf("/")+1);

			var temp_night = document.getElementById('tempnight'+dayToSave).value;
			var full_temp_night_cloth = $("#" + 'tempnight_cloth' + dayToSave).children().attr("src");
                        var temp_night_cloth = full_temp_night_cloth.substr(full_temp_night_cloth.lastIndexOf("/")+1); 

			//var temp_day = document.getElementById('tempday'+dayToSave).value;
			var lang1 = document.getElementById('lang1'+dayToSave).value;
			var lang0 = document.getElementById('lang0'+dayToSave).value;
			var postData = "command=" + command + "&day=" + day + "&templow=" + temp_low + "&temphigh=" + temp_high + "&temphigh_cloth=" + temp_high_cloth + "&tempnight=" + temp_night + "&tempnight_cloth=" + temp_night_cloth + "&lang1=" + escape(encodeURI(lang1)) + "&lang0=" + lang0 + "&active=" + active + "&day_name=" + day_name + "&date=" + date +  "&day_icon=" + day_icon;
		}
		else
		{
			//alert('message');
				
			var description = document.getElementById('description'+dayToSave).value;
			var lang = document.getElementById('lang'+dayToSave).value;
			var img_src = document.getElementById('img'+dayToSave);
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
			var type = dayToSave;
			type = type.replace(lang, "");
			var postData = "command=" + command + "&lang=" + lang + "&description=" + escape(encodeURI(description)) + "&title=" + escape(encodeURI(title)) + "&active=" + active + "&type=" + type + "&img_src=" + escape(encodeURI(img_src)) + "&href=" + escape(encodeURI(href));
		}
		
		fillForecast('<img src="images/loading.gif" alt="loading" />');
		var ajax = new Ajax();
		ajax.method = 'POST';
		ajax.setMimeType('text/html');
		ajax.postData = postData;
		ajax.setHandlerBoth(fillForecast);
		ajax.url = 'updateForecast.php';
		ajax.doReq();
                
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
		getOneUFService(dayToSave[i], command);
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

function addlinkToMessage()
	{
		var currentId = "#"+$.colorbox.element().parent().prev().children("textarea").attr('id');
		
		$(currentId).val($(currentId).val() + " <a href=\"" + $("#linkhref").val() + "\" rel=\"external\">" + $("#linktitle").val() + "</a> ");
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
					
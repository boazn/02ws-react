<?
define("MANAGER_NAME","bn");
define("ICONS_PATH","images/icons/day");
define("CLOTHES_PATH","images/clothes");
ini_set("display_errors","On");
ini_set('error_reporting', E_ERROR | E_PARSE);
include_once("ini.php"); 
include_once("include.php"); 
include_once("lang.php");
define ("PIC_PREFIX_PATH", "images/");

class DB_Functions {
 
    private $db;
 
    public function storeAd($active, $guid, $command, $img_url, $href, $w, $h, $date_start, $date_end, $daily_or_global, $session_or_pageviews, $rotation_or_fixed, $max_count, $location) {
        // insert user into database
        global $link;
       
        
        //$result = db_init("call SaveDailyAdCount ('$name', '$email', '$apn_regid', $lang, $active, $active_shortterm, $active_tips, $dailyforecast, $active_dust, $active_uv, $active_dry)", "");
        //$query = "call SaveGCMUser ('$name', '$email', '$gcm_regid', $lang, $active, $active_rain_etc, $active_tips, $active_dust, $active_uv,  $active_dry, $approved, '$billingtoken', '$billingDate', $dailyforecast, '$oldregid', 1)";
        // check for successful store
       
       
   
    }
    public function getAdDaily() {
        global $link;
        echo "<table id=\"table_counts\">";
        echo "<tr class=\"row\">";
                echo "<th>Date</th>";
                echo "<th>GUID</th>";
                echo "<th>URL</th>";
                echo "<th>Count</th>";
                
           echo "</tr>";      
        $result = db_init("SELECT * FROM `AdsReport` ORDER BY `Id` DESC", "");
        
        while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
           echo "<tr class=\"row\">";
                echo "<td>".$line["CountDate"]."</td>";
                echo "<td>".$line["GUID"]."</td>";
                echo "<td>".$line["img_url"]."</td>";
                echo "<td>".$line["count"]."</td>";
                
           echo "</tr>";
        }
        echo "</table>";

    }
    public function storeAdDaily($guid, $count, $img_url) {
        // insert user into database
        global $link;
       
        
        $result = db_init("call SaveDailyAdCount ('$guid', '$count', SYSDATE(), '$img_url')", "");
        //$query = "call SaveGCMUser ('$name', '$email', '$gcm_regid', $lang, $active, $active_rain_etc, $active_tips, $active_dust, $active_uv,  $active_dry, $approved, '$billingtoken', '$billingDate', $dailyforecast, '$oldregid', 1)";
        // check for successful store
       
       echo "<br/>done saving count for ".$guid." ".$img_url;
      
   
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storePic($name,  $base64) {
        // insert user into database
        global $link;
		
			$file_path = PIC_PREFIX_PATH.$name;
     
            if ($base64 == 1){
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST["pic"]));
                file_put_contents($file_path, $data);
            }
            else
            {
            $info = pathinfo($_FILES['imagefile']['name']);
            $ext = $info['extension']; // get the extension of the file
            $name = $info['basename'];
            $saveto = $file_path;
            move_uploaded_file($_FILES['imagefile']['tmp_name'], $saveto);
            $imagetype = strtolower(explode(".", $name)[1]);
            if ($imagetype == "jpg")
            {
                header('Content-type: image/jpeg');
                $image = imagecreatefromjpeg($saveto);
            }
            else if ($imagetype == "png")
            {
                header('Content-type: image/png');
                $image = imagecreatefrompng($saveto);
            }
            else if ($imagetype == "gif"){
                header('Content-type: image/gif');
                $image = imagecreatefromgif($saveto);
            }
            
            
            // Calculate new dimensions
            $old_width      = imagesx($image);
            $old_height     = imagesy($image);
           
            // Destroy resources
            imagedestroy($image);
            
            $typeok = TRUE;
            $result = "https://".$_SERVER["HTTP_HOST"]."/".$saveto;         
           }
                
				
			//$result = db_init("call SaveUserPic ('$name', '$comment', '$user', '$picname', '$x', '$y')");
            //$rs = db_init("INSERT INTO `PicOfTheDay` (name, comment0, comment1, uploadedAt, x, y, picname) VALUES('$name', '$comment0', '$comment1',SYSDATE(), '$x', '$y', '$name');", "");
			// check for successful store
			// get user details
            $id = $link->insert_id; // last inserted id
            return $old_height;
       
   
    }
 
  
 
}
$mem = new Memcached();
$mem->addServer('localhost', 11211);
$icons = get_Fromdir($_SERVER['DOCUMENT_ROOT']."/".ICONS_PATH);
$clothes = get_Fromdir($_SERVER['DOCUMENT_ROOT']."/".CLOTHES_PATH);
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
function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
function updateCounts($idx, $guid){
    global $mem;
    $Ads = $mem->get('Ads');
    $Ads[$idx]['count'] = intval($Ads[$idx]['count']) + 1;
    $mem->set('Ads', $Ads);
    $json_str = json_encode($Ads[$idx]);
    echo $json_str;
    exit;
}
function saveDailyCounts(){
    $db = new DB_Functions();
    global $mem;
    $Ads = $mem->get('Ads');
    foreach ($Ads as $key => &$ad) 	{
        $db->storeAdDaily($ad['guid'], $ad['count'], $ad['img_url']);
    }
}
function clearCounts(){
    global $mem;
    $Ads = $mem->get('Ads');
    foreach ($Ads as $key => &$ad) 	{
        if ($ad['daily_or_global'] == 'daily')
            $ad['count'] = 0;
    }
    
    $mem->set('Ads', $Ads);
    echo "clearCounts done";
    exit;
}
function updateAds ($active, $idx, $command, $img_url, $href, $w, $h, $date_start, $date_end, $daily_or_global, $session_or_pageviews, $rotation_or_fixed, $max_count, $location )
{   
    global $mem, $AD_LINK, $lang_idx;
    //echo "<br/>".$active." idx=".$idx." ".$command." ".$img_url." ".$href." ".$w." ".$h;
    $Ads = $mem->get('Ads');
    if ($command == "D"){
        echo "<br/>removing index ".$idx."<br/>";
        unset($Ads[$idx]);
    }
    else if ($command == "I"){
        //$idx = count($Ads);
        //array_push($Ads, array('img_url' => $img_url, 'href' => $href, 'w' => $w, 'h' => $h ));
        $Ads[$idx]['img_url'] = $img_url;
        $Ads[$idx]['href'] = $href;
        $Ads[$idx]['w'] = $w;
        $Ads[$idx]['h'] = $h;
        $Ads[$idx]['guid'] =  GUID();
        $Ads[$idx]['count'] =  0;
        $Ads[$idx]['start'] = strtotime($date_start);
        $Ads[$idx]['end'] = strtotime($date_end);
        $Ads[$idx]['daily_or_global'] = $daily_or_global;
        $Ads[$idx]['session_or_pageviews'] = $session_or_pageviews;
        $Ads[$idx]['max_count'] = $max_count;
        $Ads[$idx]['location'] = $location;
    }
    else if ($active == "true")
    {
        $Ads[$idx]['img_url'] = $img_url;
        $Ads[$idx]['href'] = $href;
        $Ads[$idx]['w'] = $w;
        $Ads[$idx]['h'] = $h;
        $Ads[$idx]['start'] = strtotime($date_start);
        $Ads[$idx]['end'] = strtotime($date_end);
        $Ads[$idx]['daily_or_global'] = $daily_or_global;
        $Ads[$idx]['session_or_pageviews'] = $session_or_pageviews;
        $Ads[$idx]['max_count'] = $max_count;
        $Ads[$idx]['location'] = $location;
    }
    else{
        unset($Ads[$idx]);
    }
    $mem->set('Ads', $Ads);
    $db = new DB_Functions();
    $db->storeAd($active, $_REQUEST['guid'], $command, $img_url, $href, $w, $h, $date_start, $date_end, $daily_or_global, $session_or_pageviews, $rotation_or_fixed, $max_count, $location);
     
     foreach ($Ads as $key => &$ad) 	{?>
     <style>
 .ads_container{
    width:320px;
    margin-bottom:60px;
    text-align: left;
    margin: 0 auto;
 }
 @media only screen and (min-width: 1000px) {
    .ads_container{
        width:620px
    }
    
 }
</style>
    <div id="ads_container<?=$idx?>" class="ads_container inv_plain_3_zebra invcell" style="margin-top:40px;" >
    <div class="cell">
    <div class="cell">index <input id="index<?=$key?>" name="index<?=$key?>" size="5"  value="<?=$key?>" style="width:20px;"  /></div>
    <div class="cell">guid <span id="guid<?=$key?>" name="guid<?=$key?>"  style="width:20px;"  ><?=$ad['guid']?></span><div>
    <div class="cell">link </div><div class="cell"><input id="hrefads<?=$key?>" name="hrefads" size="18"  value="<?=$ad['href']?>" style="width:320px;"  /></div>
    <div class="cell">img_url </div><div class="cell"><input id="imgads<?=$key?>" name="imgads" size="18"  value="<?=$ad['img_url']?>" style="width:320px;"  /><img src="<?=$ad['img_url']?>" width="320" alt="pic" />
    <div class="cell">width <div class="cell"><input id="imgwidth<?=$key?>" name="imgwidth" size="18"  value="<?=$ad['w']?>" style="width:50px;"  />
        <div class="cell">height </div><div class="cell"><input id="imgheight<?=$key?>" name="imgheight" size="18"  value="<?=$ad['h']?>" style="width:50px;"  /></div></div></div>
    </div>
    
    <div class="cell">start </div><div class="cell"><input id="start<?=$key?>" name="start" size="18"  value="<?=date('Y-m-d', $ad['start'])?>" style="width:120px;"  /></div>
    <div class="cell">end </div><div class="cell"><input id="end<?=$key?>" name="end" size="18"  value="<?=date('Y-m-d', $ad['end'])?>" style="width:120px;"  /></div>
    <div class="cell">max count </div><div class="cell"><input id="max_count<?=$key?>" name="max_count" size="18"  value="<?=$ad['max_count']?>" style="width:120px;"  /></div>
    <div class="cell"></div><div class="cell"><input id="session_or_pageviews<?=$key?>" name="session_or_pageviews" size="18"  value="<?=$ad['session_or_pageviews']?>" style="width:120px;"  /></div> 
    <div class="cell"></div><div class="cell"><input id="daily_or_global<?=$key?>" name="daily_or_global" size="18"  value="<?=$ad['daily_or_global']?>" style="width:120px;"  /></div>
    <div class="cell"></div><div class="cell"><input id="rotation_or_fixed<?=$key?>" name="rotation_or_fixed" size="18"  value="<?=$ad['rotation_or_fixed']?>" style="width:120px;"  /></div>  
    <div class="cell"></div><div class="cell"><input id="location<?=$key?>" name="location" size="18"  value="<?=$ad['location']?>" style="width:120px;"  /></div>  
     </div>
     <div class="cell shrinked">
            active
            <input type="checkbox" id="adsactive<?=$key?>" name="adsactive" value="" checked="checked" />
            
        </div>
        
        <!--<div class="cell btnsstart" ><img src="images/plus.png" width="18px" onclick="getAdsService(<?=$key?>, 'I', 'ads')" style="cursor:pointer" /></div>-->
        <div class="cell btnsstart" ><img src="images/check.png" width="18px" onclick="getAdsService(<?=$key?>, 'U',  'ads')" style="cursor:pointer" /></div>
        <div class="cell btnsstart" ><img src="images/x.png" width="18px" onclick="getAdsService(<?=$key?>, 'D', 'ads')" style="cursor:pointer" /></div>
            
            
        </div>
    
    <?}//print_r($Ads);
        
       echo "<pre> updated ";
       var_dump($Ads);
       echo "</pre>";

}

if ((trim($_REQUEST['type']) == "ads"))
{
    $db = new DB_Functions();
    
    $height = $db->storePic($_REQUEST['picname'], 0);
    $file_path = "https://".$_SERVER["HTTP_HOST"]."/".PIC_PREFIX_PATH.$_REQUEST['picname'];
    // echo "height=".$height." ".$file_path." start=".$_REQUEST['dateStart']." end=".$_REQUEST['dateEnd'];
    updateAds (1, 
                $_REQUEST['idx'], 
                "I", 
                PIC_PREFIX_PATH.$_REQUEST['picname'], 
                urldecode($_REQUEST['href']), 
                320, 
                $height, 
                $_REQUEST['dateStart'], 
                $_REQUEST['dateEnd'], 
                $_REQUEST['daily_or_global'] , 
                $_REQUEST['session_or_pageviews'], 
                $_REQUEST['rotation_or_fixed'], 
                $_REQUEST['max_count'], 
                $_REQUEST['location']);
    echo "------------------ done --------------------------";
}
else if ((trim($_REQUEST['type']) == "updateads"))
{
    updateAds ($_REQUEST['active'], 
               $_REQUEST['idx'], 
               $_REQUEST['command'], 
               ($_REQUEST['img_url']), 
               urldecode($_REQUEST['href']), 
               $_REQUEST['w'], 
               $_REQUEST['h'], 
               $_REQUEST['start'], 
               $_REQUEST['end'], 
               $_REQUEST['daily_or_global'], 
               $_REQUEST['session_or_pageviews'], 
               $_REQUEST['rotation_or_fixed'], 
               $_REQUEST['max_count'], 
               $_REQUEST['location']);
}
else if ((trim($_REQUEST['type']) == "updatecounts"))
{
    updateCounts ($_REQUEST['idx'], $_REQUEST['guid']);
}
else if ((trim($_REQUEST['type']) == "savecounts"))
{
    saveDailyCounts ();
}
else if ((trim($_REQUEST['type']) == "clearcounts"))
{
    clearCounts();
}
else {
?>
<style>
 .ads_container{
    width:320px;
    margin-bottom:60px;
    text-align: left;
    margin: 0 auto;
 }
 .float {
    text-align: left;
 }
 #upload_container{
    width:320px;
    text-align: left;
    margin: 0 auto;
 }
 #picname, #link{
    width:320px
 }
 .cell{
    margin:2px
 }
 .btnsstart{
        margin:20px
    }
 @media only screen and (min-width: 1000px) {
    .ads_container{
        width:620px
    }
    #upload_container{
        width:620px
    }
    .btnsstart{
        margin:10px
    }
 }
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<div id="logo"></div>
<div id="spacer1" style="clear:both;height: 20px;">&nbsp;</div>
<div id="upload_container" >
<form method="post" action="small.php?section=ads.php" enctype="multipart/form-data">
<input type='file' onchange="readURL(this);" accept="image/*" name="imagefile" id="imagefile"   size="120"  style="float:left;width:150px"/><br />
<img id="localimg" src="#" alt="your image" width="300"/><br />
<div class="cell"><input  name="picname" id="picname" size="30"  style="width:320px" wrap="soft" placeholder="pic name" /></div><br />
<div class="cell"><input  name="link" id="link" size="30"   style="width:320px" wrap="soft" placeholder="link" /></div><br />
<div class="cell">index </div>
<div class="cell"><input  name="idx" id="idx" size="30"  value="0" style="width:20px" wrap="soft" />
                  <input type="text" id="dateStart" style="width:120px" placeholder="Date Start">
                  <input type="text" id="dateEnd" style="width:120px" placeholder="Date End"><br/><br/>
                  <select size="1" name="location<?=$key?>" id="location<?=$key?>">
                    <option value="" >location</option>
                    <option value="first" <? echo ($ad['location'] == 'first') ? 'selected' : ''; ?>>first</option>
                    <option value="popup" <? echo ($ad['location'] == 'popup') ? 'selected' : ''; ?>>popup</option>
                    <option value="other" <? echo ($ad['location'] == 'other') ? 'selected' : ''; ?>>other</option>
                 </select>
                  <select size="1" name="session_or_pageviews" id="session_or_pageviews" style="width:150px">
                    <option value="" >pageviews/session</option>
                    <option value="session" >session</option>
                    <option value="pageviews" >pageviews</option>
                  </select>
                  <select size="1" name="daily_or_global" id="daily_or_global">
                        <option value="" >daily/global</option>
                        <option value="daily">daily</option>
                        <option value="global" >global</option>
                 </select>
                  <select size="1" name="rotation_or_fixed" id="rotation_or_fixed">
                        <option value="" >rotation/fixed</option>
                        <option value="rotation">rotation</option>
                        <option value="fixed" >fixed</option>
                </select>
                </div><br />
<input type='button' class="button" name='upload_btn' value='upload' onclick="javascript:postToServer();" style="width:150px" size="60"/>
</form>
<progress></progress> 
<div id="result"></div>
</div>
<?$Ads = $mem->get('Ads');?>
<? foreach ($Ads as $key => &$ad) 	{?>
<div id="ads_container<?=$idx?>" class="ads_container inv_plain_3_zebra invcell" style="margin-top:40px;" >
<div class="cell">
<div class="cell  ">index <input id="index<?=$key?>" name="index<?=$key?>" size="5"  value="<?=$key?>" style="width:20px;"  /><div class="cell ">guid <span id="guid<?=$key?>" name="index<?=$key?>"  style="width:20px;"  ><?=$ad['guid']?></span><div></div>

<div class="cell">link </div><div class="cell"><input id="hrefads<?=$key?>" name="hrefads" size="18"  value="<?=$ad['href']?>" style="width:420px;"  /></div>
<div class="cell">img_url </div><div class="cell"><input id="imgads<?=$key?>" name="imgads" size="18"  value="<?=$ad['img_url']?>" style="width:320px;"  /><img src="<?=$ad['img_url']?>" width="320" alt="pic" />
<div class="cell float">width <br/><input id="imgwidth<?=$key?>" name="imgwidth" size="18"  value="<?=$ad['w']?>" style="width:50px;"  /></div>
 <div class="cell float">height <br/><div class="cell float"><input id="imgheight<?=$key?>" name="imgheight" size="18"  value="<?=$ad['h']?>" style="width:50px;"  /></div></div>

<div class="cell">start </div><div class="cell"><input id="start<?=$key?>" name="start" size="18"  value="<?=date('Y-m-d', $ad['start'])?>" style="width:120px;"  /><span><? echo " passed? ".((time() > $ad['start']) ? 'true' : 'false');  ?></span></div>
<div class="cell">end </div><div class="cell"><input id="end<?=$key?>" name="end" size="18"  value="<?=date('Y-m-d', $ad['end'])?>" style="width:120px;"  /><span><? echo " passed? ".((time() > $ad['end']) ? 'true' : 'false');  ?></span></div>
<div class="cell">count </div><div class="cell"><input id="count<?=$key?>" name="count" size="18"  value="<?=$ad['count']?>" style="width:120px;" readonly /></div>
<div class="cell">max count </div><div class="cell"><input id="max_count<?=$key?>" name="max_count" size="18"  value="<?=$ad['max_count']?>" style="width:120px;"  /></div>

<div class="cell ">
    <select size="1" name="location<?=$key?>" id="location<?=$key?>">
        <option value="" >location</option>
        <option value="first" <? echo ($ad['location'] == 'first') ? 'selected' : ''; ?>>first</option>
        <option value="popup" <? echo ($ad['location'] == 'popup') ? 'selected' : ''; ?>>popup</option>
        <option value="other" <? echo ($ad['location'] == 'other') ? 'selected' : ''; ?>>other</option>
    </select>
    <select size="1" name="session_or_pageviews<?=$key?>" id="session_or_pageviews<?=$key?>">
            <option value="" >pageviews/session</option>
            <option value="session" <? echo ($ad['session_or_pageviews'] == 'session') ? 'selected' : ''; ?>>session</option>
            <option value="pageviews" <? echo ($ad['session_or_pageviews'] == 'pageviews') ? 'selected' : ''; ?>>pageviews</option>
    </select> 
    <select size="1" name="daily_or_global<?=$key?>" id="daily_or_global<?=$key?>">
            <option value="" >daily/global</option>
            <option value="daily" <? echo ($ad['daily_or_global'] == 'daily') ? 'selected' : ''; ?>>daily</option>
            <option value="global" <? echo ($ad['daily_or_global'] == 'global') ? 'selected' : ''; ?>>global</option>
    </select>
    <select size="1" name="rotation_or_fixed<?=$key?>" id="rotation_or_fixed<?=$key?>">
            <option value="" >rotation/fixed</option>
            <option value="daily" <? echo ($ad['rotation_or_fixed'] == 'rotation') ? 'selected' : ''; ?>>rotation</option>
            <option value="fixed" <? echo ($ad['rotation_or_fixed'] == 'fixed') ? 'selected' : ''; ?>>fixed</option>
    </select></div>
    
    </div>

</div>
 <div class="cell shrinked">
		active
		<input type="checkbox" id="adsactive<?=$key?>" name="adsactive" value="" checked="checked" />
		
	</div>
    
    <!--<div class="cell btnsstart" ><img src="images/plus.png" width="18px" onclick="getAdsService(<?=$key?>, 'I', 'ads')" style="cursor:pointer" /></div>-->
    <div class="cell btnsstart" ><img src="images/check.png" width="18px" onclick="getAdsService(<?=$key?>, 'U',  'ads')" style="cursor:pointer" /></div>
    <div class="cell btnsstart" ><img src="images/x.png" width="18px" onclick="getAdsService(<?=$key?>, 'D', 'ads')" style="cursor:pointer" /></div>
        
		
	</div>

<?}//print_r($Ads);   
      /* echo "<pre> updated ";
       var_dump($Ads);
       echo "</pre>";*/?>
<?}?>		
</div>
<?  $db = new DB_Functions(); $db->getAdDaily(); ?>
<script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    function getAdsService(adToSave, command, type)
{
	//alert ($("#index"+adToSave).val());
	var active; 
       
	
    if (type == "ads")
    {
        var postData = "oldidx=" + adToSave 
                      + "&idx=" + $("#index"+adToSave).val() 
                      + "&command=" + command 
                      + "&type=updateads&w=" + $("#imgwidth"+adToSave).val() 
                      + "&h=" + $("#imgheight"+adToSave).val() 
                      + "&img_url=" + $("#imgads"+adToSave).val() 
                      + "&start=" + $("#start"+adToSave).val() 
                      + "&end=" + $("#end"+adToSave).val() 
                      + "&daily_or_global=" + $("#daily_or_global"+adToSave).val() 
                      + "&session_or_pageviews=" + $("#session_or_pageviews"+adToSave).val()
                      + "&rotation_or_fixed=" + $("#rotation_or_fixed"+adToSave).val() 
                      + "&location=" + $("#location"+adToSave).val()  
                      + "&href=" + $("#hrefads"+adToSave).val() 
                      + "&max_count=" + $("#max_count"+adToSave).val() 
                      + "&active=" + $("#adsactive"+adToSave).prop("checked");
    }
    
    
    
    var ajax = new Ajax();
    ajax.method = 'POST';
    ajax.setMimeType('text/html');
    ajax.postData = postData;
    ajax.setHandlerBoth(fillResult);
    fillResult('<img src="images/loading.gif" alt="loading" />');
    ajax.url = '<?=BASE_URL?>/ads.php';
    ajax.doReq();
    
                
}
function fillResult(result){
    var forecastDetails = document.getElementById('section');
	 if (forecastDetails.firstChild) {
	   forecastDetails.removeChild(forecastDetails.firstChild);
	 }
	 newDiv = document.createElement("div");
	 newDiv.innerHTML = result;
	 //forecastDetails.appendChild(newDiv); 
	 forecastDetails.innerHTML = result;
     $('progress').hide();
}
function postToServer(){
    var fd = new FormData();    
    fd.append( 'imagefile', $('#imagefile')[0].files[0] );
    fd.append( 'picname', $('#picname').val() );
    fd.append( 'idx', $('#idx').val() );
    fd.append( 'guid', $('#guid').val() );
    fd.append( 'href', $('#link').val() );
    fd.append( 'dateStart', $('#dateStart').val() );
    fd.append( 'dateEnd', $('#dateEnd').val() );
    fd.append( 'session_or_pageviews', $('#session_or_pageviews').val() );
    fd.append( 'location', $('#location').val() );
    fd.append( 'daily_or_global', $('#daily_or_global').val() );
    fd.append( 'rotation_or_fixed', $('#rotation_or_fixed').val() );
    fd.append( 'max_count', 5000 );
    fd.append( 'type', 'ads' );
    $('progress').show();
    $.ajax({
        // Your server script to process the upload
        url: '<?=BASE_URL?>/ads.php',
        type: 'POST',

        // Form data
        data: fd,

        // Tell jQuery not to process data or worry about content-type
        // You *must* include these options!
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('progress').hide();
            $('#result').html(data);
            var copyText = document.getElementById("result");
            copyText.select();
            document.execCommand("copy");
        },
        error: function (error) {
            $('progress').hide();
            alert("error: " + error.status+ ' '+error.responseText);
        },
        // Custom XMLHttpRequest
        xhr: function() {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                // For handling the progress of the upload
                myXhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        $('progress').attr({
                            value: e.loaded,
                            max: e.total,
                        });
                    }
                } , false);
            }
            return myXhr;
        }
    });
}
 function initGeolocation() {
 if (navigator && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            console.log('Geolocation is not supported');
        }
}
 
function errorCallback() {}
 
function successCallback(position) {
        alert(position.coords.latitude + ',' + position.coords.longitude);
    }
function validateForm(){
    var image = document.getElementById("imagefile").value;
    var comment1 = document.getElementById("comment1").value;
    var comment0 = document.getElementById("comment0").value;
    if (comment1 =='')
    {
        return false;
    }
    else 
    {
        return true;
    } 
    return true;
}
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#localimg')
                    .attr('src', e.target.result)
                    .width(300)
                    .show()
                    ;
                $('#picname').val(input.files[0].name);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }    


function fillPage(str)
{
	var forecastDetails = document.getElementById('section');
	
	 forecastDetails.innerHTML = str;
	 //forecastDetails.appendChild(newDiv); 
	
}

jQuery.noConflict()(function ($) {
$('document').ready(function() {
//    initGeolocation();
    

    $('progress').hide();
    $('.adunit').hide();
    $('.nav').hide();
    $('#localimg').hide();
    $( "#dateStart" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#dateEnd" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
});
</script>

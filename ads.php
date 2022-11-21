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
            header('Content-type: image/jpeg');
            $image = imagecreatefromjpeg($saveto);
            
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
function updateAds ($active, $idx, $command, $img_url, $href, $w, $h)
{   
    global $mem;
    //echo "<br/>".$active." ".$idx." ".$command." ".$img_url." ".$href." ".$w." ".$h;
    $Ads = $mem->get('Ads');
    if ($command == "I"){
        $idx = count($Ads);
        array_push($Ads, array('img_url' => $img_url, 'href' => $href, 'w' => $w, 'h' => $h ));
    }
    else if ($active == "true")
    {
        $Ads[$idx]['img_url'] = $img_url;
        $Ads[$idx]['href'] = $href;
        $Ads[$idx]['w'] = $w;
        $Ads[$idx]['h'] = $h;
    }
    else{
        unset($Ads[$idx]);
    }
    $mem->set('Ads', $Ads);
    echo "<pre> updated ";
    var_dump($Ads);
    echo "</pre>";
      

}

if ((trim($_REQUEST['type']) == "ads"))
{
    $db = new DB_Functions();
    
    $height = $db->storePic($_REQUEST['picname'], 0);
    $file_path = "https://".$_SERVER["HTTP_HOST"]."/".PIC_PREFIX_PATH.$_REQUEST['picname'];
    echo "height=".$height." ".$file_path;
    $Ads = $mem->get('Ads');
    updateAds (1, count($Ads), "I", PIC_PREFIX_PATH.$_REQUEST['picname'], urldecode($_REQUEST['href']), 320, $height);
}
else if ((trim($_REQUEST['type']) == "updateads"))
{
    updateAds ($_REQUEST['active'], $_REQUEST['idx'], $_REQUEST['command'], ($_REQUEST['img_url']), urldecode($_REQUEST['href']), $_REQUEST['w'], $_REQUEST['h']);
}
else {
?>
<style>
 #ads_container{
    width:320px;
    margin-bottom:200px;
    text-align: left;
 }
 #upload_container{
    width:320px;
    text-align: left;
 }
 #picname, #link{
    width:320px
 }
 @media only screen and (min-width: 1000px) {
    #ads_container{
        width:620px
    }
    #upload_container{
        width:620px
    }
 }
</style>
<div id="logo"></div>
<div id="spacer1" style="clear:both;height: 20px;">&nbsp;</div>
<div id="upload_container" >
<form method="post" action="small.php?section=ads.php" enctype="multipart/form-data">
<input type='file' onchange="readURL(this);" accept="image/*" name="imagefile" id="imagefile"   size="120"  style="float:left;width:150px"/><br />
<img id="localimg" src="#" alt="your image" width="300"/><br />
<div class="cell">pic name </div>
<div class="cell"><input  name="picname" id="picname" size="30"  style="width:320px" wrap="soft" /></div><br />
<div class="cell">link </div>
<div class="cell"><input  name="link" id="link" size="30"   style="width:320px" wrap="soft" /></div><br />
<input type='button' class="button" name='upload_btn' value='upload' onclick="javascript:postToServer();" style="width:150px" size="60"/>
</form>
<progress></progress> 
<div id="result"></div>
</div>
<?$Ads = $mem->get('Ads');?>
<? $idx = 0; foreach ($Ads as $ad) { ?>
<div id="ads_container" class="inv_plain_3_zebra invcell" style="margin-top:40px;" id="ads">
<div class="cell">
<div class="cell">idx </div><div class="cell"><input id="ad_idx<?=$idx?>" name="ad_idx" size="18"  value="<?=$idx?>" style="width:80px;text-align:left"  /></div><br />
<div class="cell">href </div><div class="cell"><input id="hrefads<?=$idx?>" name="hrefads" size="18"  value="<?=$ad['href']?>" style="width:320px;text-align:left"  /></div><br />
<div class="cell">img_url </div><div class="cell"><input id="imgads<?=$idx?>" name="imgads" size="18"  value="<?=$ad['img_url']?>" style="width:320px;text-align:left"  /></div><br />
<div class="cell">width </div><div class="cell"><input id="imgwidth<?=$idx?>" name="imgwidth" size="18"  value="<?=$ad['w']?>" style="width:80px;text-align:left"  /></div><br />
<div class="cell">height </div><div class="cell"><input id="imgheight<?=$idx?>" name="imgheight" size="18"  value="<?=$ad['h']?>" style="width:80px;text-align:left"  /></div><br />
 </div>
 <div class="cell shrinked">
		active
		<input type="checkbox" id="adsactive<?=$idx?>" name="adsactive" value="" checked="checked" />
		
	</div>
    <div class="cell btnsstart" >
        <div class="cell" id="currstory_href_plugin" class="float btnsstart">
                <a class="href" title="<?=$AD_LINK[$lang_idx]?>" href="#" ><img src="images/adlink.png" width="20" height="15" /></a>
        </div>
        <img src="images/plus.png" width="18px" onclick="getAdsService(<?=$idx?>, 'I', 'ads')" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="images/check.png" width="18px" onclick="getAdsService(<?=$idx?>, 'U',  'ads')" style="cursor:pointer" />
	</div>
</div>
<?$idx++;}//print_r($Ads);?>
<?}?>		

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script>
    function getAdsService(adToSave, command, type)
{
	//alert (dayToSave);
	var active;
       
	
    if (type == "ads")
    {
        var postData = "idx=" + $("#ad_idx"+adToSave).val() + "&command=" + command + "&type=updateads&w=" + $("#imgwidth"+adToSave).val() + "&h=" + $("#imgheight"+adToSave).val() + "&img_url=" + $("#imgads"+adToSave).val() + "&href=" + $("#hrefads"+adToSave).val() + "&active=" + $("#adsactive"+adToSave).prop("checked");
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
    fd.append( 'href', $('#link').val() );
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
            alert(error.status+ ' '+error.responseText);
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
$('document').ready(function() {
//    initGeolocation();
    $('progress').hide();
    $('.adunit').hide();
    $('.nav').hide();
    $('#localimg').hide();
    });
</script>

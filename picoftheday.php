
<?
ini_set("display_errors","On");
//require_once 'picasaproxy.php';

echo "<h1>".$PIC_OF_THE_DAY[$lang_idx]."</h1><div class=\"clear\" ></div>";
///////////////////////////////////////////////////////////
$result = db_init("SELECT * FROM PicOfTheDay order by uploadedAt DESC","");
$pic_number = 0;
while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
        $picaname = "images/picOfTheDay/".$line["picname"];
        ?>
        
       <div class="white_box2 float pic_cell" style="" id="<?=$line["idx"]?>">
                <?  echo $line["uploadedAt"]; ?><br/>
                <a href="<?=$picaname?>" title="" class="colorbox">
                        <img src="phpThumb.php?src=<? echo $picaname ?>&amp;w=290" width="290px" title="<?=$picaname?>" />
                </a><br />
                <? if (isHeb()) echo $line["comment1"]; else echo $line["comment0"]; ?>
        </div>
        
        
        <? 
        $pic_number++;
}
?>

<!--
<div class="inv_plain_3_zebra invfloat">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2706630587106567";
/* PicOfTheDay Large */
google_ad_slot = "6408845094";
google_ad_width = 336;
google_ad_height = 280;
//-->
<!--
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<div class="clear"><br /></div>-->
<?
//print_r($photoEntry);
       
//$albumFeedar = (array)$albumFeed;
//$albumFeedrv = array_reverse($albumFeedar);
//$albumFeedrv = (object)$albumFeedrv;
//var_dump($albumFeedar);
/*for ($i = count($albumFeed) - 2; $i > count($albumFeed) - 50; $i--){
                $contentUrl = "";
                $thumbnailUrl = "";
                $photoEntry = $albumFeed[$i];
                if ($photoEntry->getMediaGroup()->getContent() != null) {
                  $mediaContentArray = $photoEntry->getMediaGroup()->getContent();
                  $contentUrl = $mediaContentArray[0]->getUrl();
                  $caption = $photoEntry->summary->text;
                  
                }
                if ($photoEntry->getExifTags() != null) {
                            $dateTakents = $photoEntry->getExifTags()->getTime()->text;
                             $dateTaken = getLocalTime($dateTakents/1000);
                }
        
                if ($photoEntry->getMediaGroup()->getThumbnail() != null) {
                  $mediaThumbnailArray = $photoEntry->getMediaGroup()->getThumbnail();
                  $thumbnailUrl = $mediaThumbnailArray[1]->getUrl();
                  $contentUrl = str_replace("s144", "s1152", $thumbnailUrl);
                }
        
                echo "<div class='white_box2 float pic_cell'><a href='".$contentUrl."' title='" . $caption ."' target=_system><img src='".$thumbnailUrl."' alt='" . $photoEntry->title->text ."' title='" . $albumName ."' /></a><br />".$caption."<br />".replaceDays($dateTaken)."</div>"; 
}
*/
?>



<h1>
    <?=$USERS_PICS[$lang_idx]?>
</h1>
<style>
    .piccomment{
        float:<?echo get_s_align();?>;padding-top:8px;width:150px;line-height: 1em;
    }
    .picdiv{
        float:<?echo get_s_align();?>;padding:2px
    }
</style>
<div>
 <?
$result = db_init("SELECT * FROM UserPicture where approved=1 order by uploadedAt DESC","");
$pic_number = 0;
while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
        $picaname = "images/userpic/".$line["picname"];
        if ($pic_number % 1 == 0)
            echo "<div class=\"clear\" ></div>";
        ?>
        <div class="piccomment">
            <?=$line["comment"]." <br/>".$line["name"]."<br/>".replaceDays(getLocalTime(filemtime($picaname)))?>
        </div>
        <div class="picdiv">
                 <a href="<?=$picaname?>" title="<?echo getLocalTime(filemtime($picaname));?>" class="colorbox">
                        <img src="phpThumb.php?src=<?=$picaname?>&amp;w=200" width="200px" title="<?echo getLocalTime(filemtime($picaname));?>" />

                </a>
        </div>
        
<?$pic_number++;}?>
</div>

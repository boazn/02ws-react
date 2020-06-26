

<h1>
    <?=$USERS_PICS[$lang_idx]?>
</h1>

<div>
 <?
$result = db_init("SELECT * FROM UserPicture where approved=1 order by uploadedAt DESC LIMIT 60","");
$pic_number = 0;
while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
        $picaname = "images/userpic/".$line["picname"];
        if ($pic_number % 1 == 0)
            echo "<div class=\"float\" ></div>";
        ?>
        
        <div class="white_box2 float pic_cell">
                <?  echo $line["uploadedAt"]; ?><br/>
                 <a href="<?=$picaname?>" title="<?echo getLocalTime(filemtime($picaname));?>" class="colorbox">
                        <img src="phpThumb.php?src=<?=$picaname?>&amp;w=200" width="200px" title="<?echo getLocalTime(filemtime($picaname));?>" />

                </a>
        
        <div class="piccomment">
            <?=$line["comment"]." <br/>".$line["name"]."<br/>".replaceDays(getLocalTime(filemtime($picaname)))?>
        </div>
        </div>
        
<?$pic_number++;}?>
</div>

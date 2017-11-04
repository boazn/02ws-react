<?
$SNOW_EXP = array ("<em>Snow</em> is a type of precipitation that generated around ice nucleus, aggregates and resulting with original full ice droplet. Than, consisting of a multitude of snowflakes", " <em>:שלג</em> צורות התעבות מוצקות יכולות להופיע באויר עולה הן כתוצאה מהקיפאון של חלקיקים נוזליים והן ע''י התעבות ישירה של אדי המים למצב מוצק. פתית שלג הוא מיצבור של גבישי קרח שהושטחו יחד כתוצאה משכבה דקיקה של מים על הגבישים הבודדים. שלג כבד מופיע בד''כ בטמפרטורות לא מאד נמוכות, מאחר ואוויר קר מאד מכיל מעט מאד לחות. ");
$SLEET_EXP = array ("<em>Sleet</em> is freezing rain and it shows as paricles of ice. Sleet is usually tiny clear ice pellets that bounce when they hit the ground.", "<em> הסליט </em> הוא גשם קפוא או קפוא למחצה והופעתו היא בצורת חלקיקים של קרח צלול. בד''כ מקפץ על הקרקע.<br /> תהליך מעורב של גשם גראופל ושלג העוברים בשכבה מתחת לקפאון מחוץ לענן וקופאים בדרך");
$GRAUPEL_EXP = array ("<em>Grapuel</em> is hail particles as millimeter-scale cones of low-density ice. This is because the air is trapped between the constituent ice grains of the particles", "<em>הגראופל</em> הוא חלקיק קרח אשר מכיל מעט אוויר בתוכו.נמרח על השמשה. <br/ > קפיאה של טיפונות מים מקוררות ביתר על גבי גביש קרח<br /> תלכיד של קרח הנוצר כתוצאה מהתנגשות בין גבישי קרח לטיפונות מים מקוררים ביתר הקופאות על הגבישים.");
$SNOW_ARCHIVE = array ("<h2>Snow Archive</h2>From the archive of newspapers from 19th century till today.", "<h2>ארכיון נתונים על שלג</h2>נאסף ע''י ציטוטים בארכיון של עיתונות יהודית מהמאה ה-19 ועד היום<br/>נאסף ע''י יאיר פרידמן");
?>
<h1>
	<? echo $SNOW_JER[$lang_idx]; ?>
</h1>

<div class="float" style="padding:0.5em 1em 0 4em;height:100%;width:48%" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
	<div class="float" style="text-align:<?echo get_s_align();?>;width:100%;height:115px" class="inv_plain_2">
		<div style="float:<?echo get_s_align();?>;width:120px;padding:0.5em">
			<a href="/images/SnowFlake.jpg" class="colorbox" title="real snow flake">
				<img src="phpThumb.php?src=images/SnowFlake.jpg&amp;w=120" width="120px" alt="Snow flake at the microscope" />
			</a>
		</div>
		<? echo $SNOW_EXP[$lang_idx]; ?>
				
	</div>
	<div class="float" style="text-align:<?echo get_s_align();?>;width:100%;height:115px" class="inv_plain_2">
		<div style="float:<?echo get_s_align();?>;width:120px;padding:0.5em">
			<a href="images/sleet.jpg" class="colorbox" title="Sleet סליט">
				<img src="phpThumb.php?src=images/sleet.jpg&amp;w=120" width="120px" alt="Sleet on a chair" />
			</a>
		</div>
		<? echo $SLEET_EXP[$lang_idx]; ?>
		
	</div>
	<div class="float" style="text-align:<?echo get_s_align();?>;width:100%;height:115px" class="inv_plain_2">
		<div style="float:<?echo get_s_align();?>;width:120px;padding:0.5em">
			<a href="http://media.komonews.com/images/120226_graupel.jpg" class="colorbox" title="Graupel גראופל">
				<img src="http://media.komonews.com/images/120226_graupel.jpg" width="120px" />
			</a>
		</div>
		<? echo $GRAUPEL_EXP[$lang_idx]; ?>
	</div>
</div>
<div class="float inv_plain_3 float">
	<script type="text/javascript"><!--
	google_ad_client = "pub-2706630587106567";
	/* 336x280, created 9/12/10 */
	google_ad_slot = "3629005592";
	google_ad_width = 336;
	google_ad_height = 280;
	google_color_border = ["<?= $forground->bg['+4'] ?>"];
	google_color_bg = ["<?= $forground->bg['+4'] ?>"];
	google_color_link = ["<?= $forground->bg['-9'] ?>"];
	google_color_url = ["<?= $forground->bg['-9'] ?>"];
	google_color_text = ["<?= $forground->bg['-9'] ?>"];

	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div>



<div class="float clear">
<? echo $SNOW_ARCHIVE[$lang_idx]; ?><br />
<div class="inv float" style="padding:1em;margin:1em" cellpadding="4" cellspacing="0">
    <div class="inv inv_plain float big" style="padding:2em 0 0.1em;height:3em;width:80px;text-align:center"><? echo $WINTER[$lang_idx];?></div>
    <div class="inv inv_plain float big" style="padding:2em 0 0.1em;height:3em;width:100px;text-align:center"><? echo $DAY[$lang_idx];?></div>
    <div class="inv inv_plain float big" style="padding:2em 0 0.1em;height:3em;width:40px;text-align:center"><? echo $DAYS[$lang_idx];?></div>
    <div class="inv inv_plain float big" style="padding:2em 0 0.1em;height:3em;width:50px;text-align:center"><? echo $FROM[$lang_idx];?><br/> (<? echo $SNOW_UNIT[$lang_idx];?>)</div>
    <div class="inv inv_plain float big" style="padding:2em 0 0.1em;height:3em;width:50px;text-align:center"><? echo $TO[$lang_idx];?><br/> (<? echo $SNOW_UNIT[$lang_idx];?>)</div>
    <div class="inv inv_plain float big" style="padding:2em 0 0.1em;height:3em;width:220px;text-align:center"><? echo $COMMENTS[$lang_idx];?></div>
    <div class="inv inv_plain float big" style="padding:2em 0 0.1em;height:3em;width:140px;text-align:center"><? echo $SOURCE[$lang_idx];?></div>
    <div class="inv inv_plain float big" style="padding:2em 0 0.1em;height:3em;width:180px;text-align:center"><? echo $SNOW_PICTURES[$lang_idx];?></div>
    

	<?
	$query = "SELECT s.`SnowDate`, `StormDays`, `DepthMax`,`DepthMin`,`Comments1`,`Source1`,`Comments0`,`Source0`,`WinterBeginningYear`, `MediaUrl` FROM `Snow` s
left outer join SnowMedia sm on s.`SnowDate` = sm.`SnowDate`  order by `SnowDate` DESC";
    $result = db_init($query);

    /* Printing results in HTML */
    
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
		$col_num = 0;
		
		
		 if ($line['SnowDate'] != $previousDate)	{
			 
			 $winterEndingYear = $line['WinterBeginningYear']+1;
			 $snowdate = new DateTime($line['SnowDate'], new DateTimeZone('Asia/Jerusalem'));
			 print "\t\t<div class=\"float inv_plain_3 borderfull\" style=\"clear:both;height:4em;width:80px;text-align:center\">".$line['WinterBeginningYear']."-".$winterEndingYear."</div>\n";
			 print "\t\t<div class=\"float inv_plain_3 borderfull\" style=\"height:4em;width:100px;text-align:center\">".replaceDays(date_format($snowdate, " D "))."<br />".date_format($snowdate, "j/m/Y")."</div>\n";
			 print "\t\t<div class=\"float inv_plain_3 borderfull\" style=\"height:4em;width:40px;text-align:center\" >".$line['StormDays']."</div>\n";                 
			 print "\t\t<div class=\"float inv_plain_3 borderfull\" style=\"height:4em;width:50px;text-align:center\"><strong>".$line['DepthMin']."</strong></div>\n";
			 print "\t\t<div class=\" float inv_plain_3 borderfull\" style=\"height:4em;width:50px;text-align:center\"><strong>".$line['DepthMax']."</strong></div>\n";
			 $commentsColName = "Comments".$lang_idx;
			 $sourceColName = "Source".$lang_idx;
			 print "\t\t<div class=\"float inv_plain_3 borderfull\" style=\"height:4em;width:220px;text-align:center\">".$line[$commentsColName]."</div>\n";
			 print "\t\t<div class=\"float inv_plain_3 borderfull\" style=\"height:4em;width:140px;text-align:center\">".$line[$sourceColName]."</div>\n";
			 
		}
		else{
			
			
		}
		
		if ($line['MediaUrl'] != ""){
			$imgSrc = "spgm-1.3.2/gal/Snow2003/_thb_Tayelet.JPG";
			if (stristr(strtolower($line['MediaUrl']), "jpg"))
				$imgSrc = $line['MediaUrl'];
			print "\t\t<div class=\"float\" style=\"padding:0.2em\"><a title=\"".$line['SnowDate']."\" href=\"".$line['MediaUrl']."\" rel=\"external\" class=\"colorbox\"><img src=\"phpThumb.php?src=". $imgSrc."&amp;w=40\" width=\"40px\" /> </a></div>\n";
		}
		else print "<div class=\"float\" style=\"height:4em;width:180px;text-align:center\"><a href=\"".get_query_edited_url($url_cur, 'section', 'SendEmailForm.php')."\">".$SEND_PICTURES[$lang_idx]."</a></div>";
		$previousDate = $line['SnowDate'];
        foreach ($line as $col_value) {
		    $col_num++;
		}
			
				
     }
        
    
	?>
<div style="clear:both"></div>
</div>
<div class="inv float">
<table class="inv float" style="padding:1em;margin:1em" cellpadding="4" cellspacing="2">
<tr class="inv big">
    <td><? echo $WINTER[$lang_idx];?></td>
    
    <td><? echo $DAYS[$lang_idx];?></td>
    
</tr>
<?
   $query = "SELECT SUM(`StormDays`) snowdays ,  `WinterBeginningYear` FROM  `Snow` GROUP BY  `WinterBeginningYear` ORDER BY SUM(`StormDays`) DESC LIMIT 0 , 15";
    $result = mysqli_query($link, $query) or die("Query failed");
    
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$col_num = 0;
		print "\t<tr class=\"inv_plain_3\">\n";
		 
		 $winterEndingYear = $line['WinterBeginningYear']+1;
		 print "\t\t<td class=\"inv_plain\" style=\"height:2em\" width=\"90px\"><strong>".$line['WinterBeginningYear']."-".$winterEndingYear."</strong></td>\n";
		 print "\t\t<td class=\"\" style=\"height:2em\" width=\"100px\"><strong>".$line['snowdays']."</strong></td>\n";

        	foreach ($line as $col_value) {
		    $col_num++;
		}
			
	print "\t</tr>\n";			
        }
    
        
?>
</table>
</div>
<div class="inv float">
<table class="inv float" style="padding:1em;margin:1em" cellpadding="4" cellspacing="2">
<tr class="inv big">
    <td><? echo $WINTER[$lang_idx];?></td>
    
    <td><? echo $SNOW_UNIT[$lang_idx];?></td>
    
</tr>
<?
    
    $query = "SELECT SUM(  `DepthMax` ) snowamount,  `WinterBeginningYear` FROM  `Snow` GROUP BY  `WinterBeginningYear` ORDER BY SUM(  `DepthMax` ) DESC LIMIT 0 , 15";
    $result = mysqli_query($link, $query) or die("Query failed");
    
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$col_num = 0;
		print "\t<tr class=\"inv_plain_3\">\n";
		 
		 $winterEndingYear = $line['WinterBeginningYear']+1;
		 print "\t\t<td class=\"inv_plain\" style=\"height:2em\" width=\"90px\"><strong>".$line['WinterBeginningYear']."-".$winterEndingYear."</strong></td>\n";
		 print "\t\t<td class=\"\" style=\"height:2em\" width=\"100px\"><strong>".$line['snowamount']."</strong></td>\n";

        	foreach ($line as $col_value) {
		    $col_num++;
		}
			
	print "\t</tr>\n";			
        }
?>
</table>
</div>

<?
@mysqli_free_result($result);
?>
<div class="inv float big" style="padding:1em;width:25%">
חסרים אימותים ל-5 סופות שלג בשנים 72-74.<br />
<a href="<? echo get_query_edited_url($url_cur, 'section', 'SendEmailForm.php');?>" title="<?=$MANAGER[$lang_idx]?>">
 אשמח לקבל הערות ותוספות כמו תמונות  לארכיון השלג כאן...
</a>
<br />
<a href="<? echo get_query_edited_url($url_cur, 'section', 'SendEmailForm.php');?>" title="<?=$MANAGER[$lang_idx]?>">
I would be happy to get more info for this archive
</a>
</div>
<div  style="padding:1em;" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
    <div  class="inv float big" style="padding:1em;">
		
		<a href="https://docs.google.com/present/edit?id=0AZRuefvBe4zMZGRucm56c2hfMTBkZGhxZ3BncQ" target="blank">תרגיל על שלג</a>

	</div>
</div>
<div class="spacer">&nbsp;</div>
<div style="clear:both;width:100%">
<object width="---" height="---"><param name="-----" value="--ESFSECEV-------------------------------------"></param><param name="--ESFSECEV-----" value="----"></param><param name="--ESFSECEV-------" value="------"></param><embed src="http://www.youtube.com/v/x1ItQpEzyOk&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>
<object width="---" height="---"><param name="-----" value="--ESFSECEV-------------------------------------"></param><param name="--ESFSECEV-----" value="----"></param><param name="--ESFSECEV-------" value="------"></param><embed src="http://www.youtube.com/v/2s0HMXUp1Cw&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>
</div>
<video width="640"  height="360" src="Snow31012008.avi"  controls autobuffer>
31/01/2008
 </video>
</div>



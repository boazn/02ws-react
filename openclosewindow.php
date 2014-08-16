

<?
	ini_set("display_errors","On");
	$PIVOT_DESC = array ("Assuming idealistic inside temperature of: ", "המטרה של הדף הזה היא למזג את הבית כך שייתקרב כמה שיותר לתחושה הנוחה ביותר לנו. <br/>זה כמובן אינדיבידואלי, לכן צריך לעשות כמה הנחות. ההנחה היא שהטמפרטורה האידיאלית בבית היא: ");
?>


	<h1><? echo $YOU_BETTER[$lang_idx]." <span>";$res = isOpenOrClose();
						 echo $res;
						 echo " </span>".$THE_WINDOW[$lang_idx];?></h1> 
	<? if ($res == $CLOSE[$lang_idx]) $img_src_openclose = "closed_window.jpg"; else $img_src_openclose = "opened_window.jpg"; ?>
	<div class="float inv_plain_3" style="width:100%">
	<div class="float">
		<img src="images/<?=$img_src_openclose; ?>" /> 
	</div>
	<div <? if (isHeb()) echo "dir=\"rtl\" ";?> style="margin:1em;" class="inv_plain_2 slogan float">
		<? echo $INSIDE[$lang_idx].": ".$current->get_intemp()." <br/ > ".$OUTSIDE[$lang_idx].": ".$current->get_temp();?>
	</div>
	<div <? if (isHeb()) echo "dir=\"rtl\" ";?> style="margin:1em;width:50%" class="inv_plain_3_zebra big float">
		<? echo $PIVOT_DESC[$lang_idx]." ".$PIVOT_TEMP."<? echo $current->get_tempunit(); ?>"; ?>
	</div>
	</div>

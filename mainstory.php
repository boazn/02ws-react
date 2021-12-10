<? include_once("requiredDBTasks.php"); 

    $img_title = $MainStory->get_title();
    $box_img_src = $MainStory->get_img_src();
    $div_title = $MainStory->get_title();
    $href = $MainStory->get_href();//"&lang=".$lang_idx;
    $box_title = $MainStory->get_title();
    $box_description =  $MainStory->get_description();

	
    
    
	 
?>
<div class="inv_plain_3" style="width:90%;float:<?echo get_s_align();?>;margin:0.4%;padding:1.5em 0.5em 1.5em 0.5em;" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
	<div class="float" style="padding:0.5em 1.3em 0.1em 1.3em;margin:0em 0.8em 0em 0.8em">
	<a href="<?=$href?>" rel='external'>
	<?
	 echo "<img src=\"$box_img_src\" title=\"".$img_title."\" id=\"mainpic\" alt=\"".$img_title."\" width=\"300px\" />";
	?>
	</a>
	</div>
	<div class="float" <? echo get_align(); ?> <? if (isHeb()) echo "dir=\"rtl\""; ?> >
			<h1 title="<? echo $div_title; ?>" id="picture_title" <? echo get_align(); ?> style="padding:0.5em 1.3em 0.1em 1.3em;margin:0em 0.8em 0em 0.8em"  class="big">
				<a href="<?=$href?>" rel='external'>
					<? echo($box_title);?>
				</a>
			</h1>
			<div  style="padding:0em 2em 0.1em 2em;margin:0em 0.8em 0em 0.8em" class="big">
				 <? echo $box_description;?>
			</div>
			
	</div>
	
</div>
<div class="clear">&nbsp;</div>
<div>
	<?
	
	$resultStories = db_init("select ms.lang, ms.Idx, ms.Title, ms.href, ms.Description, ms.img_src, ms.active, ms.updatedTime from mainstory ms where ms.lang = ? order by updatedTime desc limit 1,10", $lang_idx);

	while ($line = mysqli_fetch_array($resultStories["result"], MYSQLI_ASSOC)) {
		?>
		<div class="inv_plain_3 float" style="width:90%;margin:1em 0;padding:1em">
		<div class="invfloat" style="margin:1em">
			<img src="<?=$line["img_src"]?>" width="300" height="" alt="<?=$line["Title"]?>" />
		</div>
		<h1><?=$line["Title"]?></h1><br/>
		<label style="margin:2em"><?=$line["updatedTime"]?></label>
		
		<div  style="padding:0em 2em 0.1em 2em;margin:0em 0.8em 0em 0.8em" class="float">
			<?=$line["Description"]?>
		</div>
        <a href="<?=$line["href"]?>" rel='external' class="float">
		<?=$MORE_INFO[$lang_idx]?>
		</a>
 	
	</div>
   <? }
?>
</div>
<div style="clear:both">
	<a href="https://www.animalshop.co.il/page/%D7%97%D7%A0%D7%95%D7%AA-%D7%97%D7%99%D7%95%D7%AA-%D7%91%D7%99%D7%A8%D7%95%D7%A9%D7%9C%D7%99%D7%9D" target=_blank>Animal shop - חנות חיות בירושלים</a>
</div>
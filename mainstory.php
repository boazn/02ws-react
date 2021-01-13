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
			<div title="<? echo $div_title; ?>" id="picture_title" <? echo get_align(); ?> style="padding:0.5em 1.3em 0.1em 1.3em;margin:0em 0.8em 0em 0.8em"  class="big">
				<a href="<?=$href?>" rel='external'>
					<? echo($box_title);?>
				</a>
			</div>
			<div  style="padding:0em 2em 0.1em 2em;margin:0em 0.8em 0em 0.8em">
				 <? echo $box_description;?>
			</div>
			
	</div>
	
</div>
<div style="clear:both">
	<a href="https://www.animalshop.co.il/page/%D7%97%D7%A0%D7%95%D7%AA-%D7%97%D7%99%D7%95%D7%AA-%D7%91%D7%99%D7%A8%D7%95%D7%A9%D7%9C%D7%99%D7%9D" target=_blank>Animal shop - חנות חיות בירושלים</a>
</div>
<div>
	<?
	include_once("include.php"); 
    include_once("start.php");
	$resultStories = db_init("SELECT * FROM `AlertsArchive` WHERE lang= ? order by Id Desc ", $lang_idx);

	while ($line = mysqli_fetch_array($resultStories["result"], MYSQLI_ASSOC)) {
		?>
		<div class="inv_plain_3 float" style="width:90%;margin:1em 0;padding:1em">
		<div class="invfloat" style="margin:1em">
			
		</div>
		<h1><?=$line["Title"]?></h1><br/>
		<label style="margin:2em"><?=$line["updatedTime"]?></label>
		
		<div  style="padding:0em 2em 0.1em 2em;margin:0em 0.8em 0em 0.8em" class="float">
			<?=$line["Description"]?>
		</div>
		<div class=" invfloat" style="padding:2em">
           
		</div>
 	
	</div>
   <? }
?>
</div>
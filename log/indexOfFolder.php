<?
		ini_set("display_errors","On");	
		function getfilesFromdir($path){
			$dirToOpen = $path;    
			$files = array();    
			if ($handle = opendir($dirToOpen)) {      
			   while (false !== ($file=readdir($handle)))
			   {
				  if (substr($file,0,1)!=".")
					 $files[]=array(filemtime($path."".$file),$path."".$file);   #2-D array
			   }
			   closedir($handle);
			   if ($files)
			   {
				  rsort($files); #sorts by filemtime
			   }
			}
			return $files;
		}
		function getLocalTime ($time)
		{
			return date("j/m/y H:i", strtotime("-0 hours -3 minutes", $time));
		}
		$latestPics = array();
		$path_to_files = sprintf("images/pics_%s%02d/day%02d", strtolower(date("M")), substr($year, 2) , $day);
		//echo $path_to_files;
		$latestPics = getfilesFromdir("./");
		foreach ($latestPics as $lpic)
		{
	?>
			<div style="float:left;padding:2px;border:1px solid"  <?if ($_GET['section']==="{$lpic[1]}") echo "class=\"trans75\""; else echo "class=\"trans25\" onmouseover=\"this.className='trans75'\" onmouseout=\"this.className='trans25'\"";?>>
				<a href="<?=$lpic[1]?>">
					<!-- <img src="<? echo $lpic[1]; ?>.jpg" width="70px" /> -->
					<?echo getLocalTime($lpic[0]);?>
				</a>
			</div>
	<?
		}
	?>
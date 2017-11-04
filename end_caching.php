<?php
  include "PHPWee/phpwee.php";
  // Now the script has run, generate a new cache file
  if (!$ignore_page)
  {
          if (FILE_CACHE == "APC"){
              apc_store($path."_created", time());
			  if ($res_page)
			  {
				if (strpos($path, 'footer') !== false)
					$output = ob_get_contents();
				else 
					$output = ob_get_contents();
			  }
			  else
				$output = ob_get_contents();
			  apc_store($path, $output);
          }
          else{
            $fp = @fopen($cachefile, 'w');
             // save the contents of output buffer to the file
            @fwrite($fp, ob_get_contents());
            @fclose($fp);
          }
          
  }
  ob_end_flush();
?>
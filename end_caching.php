<?php
  include "PHPWee/phpwee.php";
  // Now the script has run, generate a new cache file
  if (!$ignore_page)
  {
          if (FILE_CACHE == "APC"){
              $mem->set($path."_created", time(), time() + 300);
			  if ($res_page)
			  {
				if (strpos($path, 'footer') !== false)
					$output = ob_get_contents();
				else 
					$output = ob_get_contents();
			  }
			  else
				$output = ob_get_contents();
			  $mem->set($path, $output);
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
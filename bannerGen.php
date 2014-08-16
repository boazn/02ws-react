<? function bannerGen($text, 
					  $image, 
					  $height, 
					  $width, 
					  $R, 
					  $G, 
					  $B, 
					  $size, 
					  $pathToSave)
{
	include_once("include.php"); 
	$string = $text;
	if (isset($image))
		$im = imagecreatefrompng("images/{$image}");
	 else
		$im = imagecreate($width,$height);
	$bg2 = imagecolorallocate($im, 0, 0, 0);
	imagecolortransparent ($im, $bg2);
	
	if (!isset($image))
	{
		$bg = imagecolorallocate($im, $R, $G, $B);
		ImageRectangleWithRoundedCorners($im, 0, 0, $width, $height, 0, $bg);
	}
	if (isset($string))
		ImageStringWrap($im, $size, $string);
	header("Content-type: image/png");
	if (isset($pathToSave))
		imagepng($im, $pathToSave);
	imagepng($im);
	imagedestroy($im);
	
}

function bannerWrite($text, 
					  $image, 
					  $height, 
					  $width, 
					  $R, 
					  $G, 
					  $B, 
					  $size, 
					  $pathToSave)
{
	include_once("include.php"); 
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$string = $text;
	if (isset($image))
		$im = imagecreatefrompng("images/{$image}");
	 else
		$im = imagecreate($width,$height);
	$bg2 = imagecolorallocate($im, 0, 0, 0);
	imagecolortransparent ($im, $bg2);
		
	if (!isset($image))
	{
		$bg = imagecolorallocate($im, $R, $G, $B);
		ImageRectangleWithRoundedCorners($im, 0, 0, $width, $height, 0, $bg);
	}
	if (isset($string))
		ImageStringWrap($im, $size, $string);
	
	if (isset($pathToSave))
		imagepng($im, $pathToSave);
	
	imagedestroy($im);
	
}

function ImageStringWrap($image, $Text_Size, $text)
{

  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  // Set the enviroment variable for GD
  putenv('GDFONTPATH=' . realpath('.'));
  // Name the font to be used (note the lack of the .ttf extension)
  $fontPath = 'fonts/ArialBold.ttf';

  ///////////////////////////////////////////////////////

  $fontwidth = ImageFontWidth($Text_Size);
  //$fontwidth = ImageFontWidthByFilename($fontPath);
  $fontheight = ImageFontHeight($Text_Size);
  $string_sum = "";
  for ($i=0 ; $i < count($text) ; $i++)
  {
	 $string_sum .= $text[$i]['txt'];
  }
  $words = str_word_count($string_sum);
  
  $vspace=5;
  $y=((imagesy($image)-($fontheight*$words)-($words*$vspace))/5);
  $y=30;
  if (count($text) > 0)
  {
		  for ($i=0 ; $i < count($text) ; $i++)
		  {
			  
		   
		   $ColorArray = array();
		   $ColorArray = hexrgb($text[$i]['color']);
		   $forR = $ColorArray['red'];
		   $forG = $ColorArray['green'];
		   $forB = $ColorArray['blue'];
		   $textcolor = imagecolorallocate($image, $forR, $forG, $forB);
		   $st = $text[$i]['txt'];
		   $fw = $fontwidth;
		  //if (IsHebrew($st))
		   
		   $x=((imagesx($image)-($fw * strlen($st)))/2);
		   //ImageString($image,$Text_Size,$x,$y+20,$st,$textcolor);
		   ImageTTFText ($image, $text[$i]['size'], 0, $x, $y+$text[$i]['size'], $textcolor, $fontPath , $st); 
		   $y+=($text[$i]['size']+$vspace);
		  }
  }

 
}
function ImageFontWidthByFilename($filename)
{
	   $handle = @fopen($font_locations[$i],"r");
	   $c_wid = @fread($handle,11);
	   @fclose($handle);
	   return(ord($c_wid{8})+ord($c_wid{9})+ord($c_wid{10})+ord($c_wid{11}));
}
function isUTF8($str) {
   if ($str === mb_convert_encoding(mb_convert_encoding($str, "UTF-32", "UTF-8"), "UTF-8", "UTF-32")) {
	   return true;
   } else {
	   return false;
   }
}
Function IsHebrew($string) {
	If(ereg("[׳-׳×]",$string,$regs)) {
			return true;
	}Else{
			return false;
	}
}
function hexrgb ($hexstr)
{
  $int = hexdec($hexstr);

  return array("red" => 0xFF & ($int >> 0x10),
               "green" => 0xFF & ($int >> 0x8),
               "blue" => 0xFF & $int);
}
?>
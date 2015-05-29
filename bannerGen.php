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
/***********************************************************************/
//image functions
/***********************************************************************/

function ImageRectangleWithRoundedCorners(&$im, $x1, $y1, $x2, $y2, $radius, $color) {
	// draw rectangle without corners
	imagefilledrectangle($im, $x1+$radius, $y1, $x2-$radius, $y2, $color);
	imagefilledrectangle($im, $x1, $y1+$radius, $x2, $y2-$radius, $color);
	// draw circled corners
	imagefilledellipse($im, $x1+$radius, $y1+$radius, $radius*2, $radius*2, $color);
	imagefilledellipse($im, $x2-$radius, $y1+$radius, $radius*2, $radius*2, $color);
	imagefilledellipse($im, $x1+$radius, $y2-$radius, $radius*2, $radius*2, $color);
	imagefilledellipse($im, $x2-$radius, $y2-$radius, $radius*2, $radius*2, $color);
	
}

function ImageRectangleGradientRoundedCorners(&$im, $x1, $y1, $x2, $y2, $radius, $f_c,$s_c) {
	imagecolorgradient($im,$x1, $y1, $x2, $y2 ,$f_c,$s_c);
	//imagecolorgradient($im, $x1+$radius, $y1, $x2-$radius, $y2, $f_c, $s_c);
	//imagecolorgradient($im, $x1, $y1+$radius, $x2, $y2-$radius, $f_c, $s_c);
}

function drawRating($rating) {
   $image = imagecreate(102,10);
   $back = ImageColorAllocate($image,255,255,255);
   $border = ImageColorAllocate($image,0,0,0);
   $red = ImageColorAllocate($image,255,60,75);
   $fill = ImageColorAllocate($image,44,81,150);
   ImageFilledRectangle($image,0,0,101,9,$back);
   ImageFilledRectangle($image,1,1,$rating,9,$fill);
   ImageRectangle($image,0,0,101,9,$border);
   imagePNG($image);
   imagedestroy($image);
}

function imagecolorgradient($img,$x1,$y1,$x2,$y2,$f_c,$s_c){

   sscanf($f_c, "%2x%2x%2x", $red, $green, $blue);
   $f_c = array($red,$green,$blue);
  
   sscanf($s_c, "%2x%2x%2x", $red, $green, $blue);
   $s_c = array($red,$green,$blue);

   if($y2>$y1) $y=$y2-$y1;
   else $y=$y1-$y2;
  
   if($f_c[0]>$s_c[0]) $r_range=$f_c[0]-$s_c[0];
   else $r_range=$s_c[0]-$f_c[0];
   if($f_c[1]>$s_c[1]) $g_range=$f_c[1]-$s_c[1];
   else $g_range=$s_c[1]-$f_c[1];
   if($f_c[2]>$s_c[2]) $b_range=$f_c[2]-$s_c[2];
   else $b_range=$s_c[2]-$f_c[2];
   $r_px=$r_range/$y;
   $g_px=$g_range/$y;
   $b_px=$b_range/$y;
   $r=$f_c[0];
   $g=$f_c[1];
   $b=$f_c[2];

   for($i=0;$i<=$y;$i++){
       $col=imagecolorallocate($img,round($r),round($g),round($b));
       imageline($img,$x1,$y1+$i,$x2,$y1+$i,$col);
       if($f_c[0]<$s_c[0]) $r+=$r_px;
       else $r-=$r_px;
       if($f_c[1]<$s_c[1]) $g+=$g_px;
       else $g-=$g_px;
       if($f_c[2]<$s_c[2]) $b+=$b_px;
       else $b-=$b_px;
   }
   return $img;
}
?>
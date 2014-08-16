<? 
$im = ImageCreate (150, 100)
    or die ("Cannot create a new GD image.");
$background_color = ImageColorAllocate ($im, 255, 255, 255);
$text_color = ImageColorAllocate ($im, 233, 14, 91);
ImageString ($im, 1, 5, 5,  "A Simple Text String", $text_color);
header ("Content-type: image/png");
ImagePNG ($im);
$im = imagecreatetruecolor (300, 200);
$black = imagecolorallocate ($im, 0, 0, 0);
$white = imagecolorallocate ($im, 255, 255, 255);

imagefilledrectangle($im,0,0,399,99,$white);
imagerectangle($im,20,20,250,190,$black);

header ("Content-type: image/png");
imagepng ($im);
?>
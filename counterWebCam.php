<?php 
$datafile="webcamdata.dat";                 //filename for counter datafile
$counterstyle = "image";                  //enter text for text,image for images, or invisible for none 
$textcountlength = 4;                     //length of counter in digits if using text option          
$font = "Arial, Helvetica, sans-serif";   //font face style if using text counter
$fontsize = "5";                          //font size if using text counter
$fontcolour = "#999999";                  //font colour use html colour codes
$imagedirectory = "images/smooth/";              //directory or http location to images NOTE: use trailing slash
$imagesext = ".gif";                      //file extension for images e.g. .gif .jpg .png              
$initialvalue = 1;

//MAIN CODE//

if (!file_exists($datafile)) {
   $file = fopen($datafile,"w+");
   fwrite ($file,$initialvalue);
   fclose ($file);
  }
else  { 

   $file = fopen($datafile,"r+"); 
   $hitcount = fread($file,filesize($datafile));
   fclose ($file);

 };



$hitcount++;

$file = fopen($datafile,"w+"); 
fwrite ($file,$hitcount);


if ($counterstyle != "invisible") {

if ($counterstyle == "text")  {

   echo "<font face=\"$font\" size=\"$fontsize\" color=\"$fontcolour\">"
   .sprintf("%0"."$textcountlength"."d",$hitcount)."</font>";
  }
else  {

   $longstr = strlen($hitcount);
   for ($x=0; $x < $longstr; $x++)  {

$image = substr($hitcount,$x,1);

echo "<IMG src=\"$imagedirectory$image$imagesext\" border=\"0\" ALT=\"$image\" height=15>";

       }
  }
}

 ?>


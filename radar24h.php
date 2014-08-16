<html>

  <head>

    <title>

      daily pic loop

    </title>

	<script type="text/javascript" src="sprintf2.js"></script>

	<script language="javascript" type="text/javascript">

	//============================================================

//                >> jsImagePlayer 1.0 <<

//            for Netscape3.0+, September 1996

//============================================================

//                  by (c)BASTaRT 1996

//             Praha, Czech Republic, Europe

//

// feel free to copy and use as long as the credits are given

//          by having this header in the code

//

//          contact: xholecko@sgi.felk.cvut.cz

//          http://sgi.felk.cvut.cz/~xholecko

//

//============================================================

// Thanx to Karel & Martin for beta testing and suggestions!

//============================================================

//

//     modified by D. Watson and A. Earnhart (CIRA/CSU), 7/30/97

//     and Greg Thompson (NCAR/RAP) May 07, 2000

//

//============================================================

//=== global variables ====

theImages = new Array();      //holds the images

imageNum = new Array();       //keeps track of which images to omit from loop

//********* SET UP THESE VARIABLES - MUST BE CORRECT!!!*********************

var numOfPics = 20;

modImages = new Array();

for (i = 0; i < numOfPics ; i++)

{

	var imagepath = sprintf("http://www.ims.gov.il/Ims/Pages/RadarImage.aspx?Row=%02d&TotalImages=%02d&LangID=1&Location=", i, numOfPics);
	modImages[i] = imagepath;

}
<?
	
	$radarpics = getLastFilesFromDir("images/radar", 20);
	$radarpics = array_reverse($radarpics);
	$archradar = 0;
	foreach ($radarpics as $rpic)
	{
		?>
			var imagepath = "<?=$rpic[1]?>";
		<?
		echo "modImages[".$archradar."] = imagepath;";
		$archradar = $archradar + 1;
	}
	
?>

first_image = 1;

last_image = numOfPics;

 

//**************************************************************************

 

//=== THE CODE STARTS HERE - no need to change anything below ===



normal_delay = 1000;

delay = normal_delay;         //delay between frames in 1/100 seconds

delay_step = 150;

delay_max = 6000;

delay_min = 50;

dwell_multipler = 3;

dwell_step = 1;

end_dwell_multipler   = dwell_multipler;

start_dwell_multipler = 1;      // originally: dwell_multipler;

current_image = first_image;     //number of the current image

timeID = null;

status = 0;                      // 0-stopped, 1-playing

play_mode = 0;                   // 0-normal, 1-loop, 2-sweep

size_valid = 0;

 

//===> Make sure the first image number is not bigger than the last image number

if (first_image > last_image)

{

   var help = last_image;

   last_image = first_image;

   first_image = help;

}





//==============================================================

//== All previous statements are performed as the page loads. ==

//== The following functions are also defined at this time.   ==

//==============================================================

 

//===> Stop the animation

function stop()

{

   //== cancel animation (timeID holds the expression which calls the fwd or bkwd function) ==

   if (status == 1)

      clearTimeout (timeID);

   status = 0;
   document.getElementById("run_title").style.display = "block";

}

 

 

//===> Display animation in fwd direction in either loop or sweep mode

function animate_fwd()

{

   removeCurrentIdx();

   current_image++;                      //increment image number

   

   //== check if current image has exceeded loop bound ==

   if (current_image > last_image) {

      if (play_mode == 1) {              //fwd loop mode - skip to first image

         current_image = first_image;

      }

      if (play_mode == 2) {              //sweep mode - change directions (go bkwd)

         current_image = last_image;

         animate_rev();

         return;

      }

   }

 

   //== check to ensure that current image has not been deselected from the loop ==

   //== if it has, then find the next image that hasn't been ==

   while (imageNum[current_image-first_image] == false) {

         current_image++;

         if (current_image > last_image) {

            if (play_mode == 1)

               current_image = first_image;

            if (play_mode == 2) {

               current_image = last_image;

               animate_rev();

               return;

            }

         }

   }

	displayCurrentIdx();

   document.images['animation'].src = theImages[current_image-first_image].src;   //display image onto screen

   document.control_form.frame_nr.value = current_image;                //display image number

    var loading = document.getElementById("waiting");

	document.images['animation'].onload = imageDownloaded;

	if (!theImages[current_image-first_image].complete)

	{

		loading.style.display = "";

	}

	else

	{

		loading.style.display = "none";

	}

   delay_time = delay;

   if ( current_image == first_image) delay_time = start_dwell_multipler*delay;

   if (current_image == last_image)   delay_time = end_dwell_multipler*delay;

 

   //== call "animate_fwd()" again after a set time (delay_time) has elapsed ==

   timeID = setTimeout("animate_fwd()", delay_time);

}

 

 

//===> Display animation in reverse direction

function animate_rev()

{

   removeCurrentIdx();

   current_image--;                      //decrement image number

 

   //== check if image number is before lower loop bound ==

   if (current_image < first_image) {

     if (play_mode == 1) {               //rev loop mode - skip to last image

        current_image = last_image;

     }

     if (play_mode == 2) {

        current_image = first_image;     //sweep mode - change directions (go fwd)

        animate_fwd();

        return;

     }

   }

 

   //== check to ensure that current image has not been deselected from the loop ==

   //== if it has, then find the next image that hasn't been ==

   while (imageNum[current_image-first_image] == false) {

         current_image--;

         if (current_image < first_image) {

            if (play_mode == 1)

               current_image = last_image;

            if (play_mode == 2) {

               current_image = first_image;

               animate_fwd();

               return;

            }

         }

   }

   displayCurrentIdx();

   document.images['animation'].src = theImages[current_image-first_image].src;   //display image onto screen

   document.control_form.frame_nr.value = current_image;                //display image number



   delay_time = delay;

   if ( current_image == first_image) delay_time = start_dwell_multipler*delay;

   if (current_image == last_image)   delay_time = end_dwell_multipler*delay;

 

   //== call "animate_rev()" again after a set amount of time (delay_time) has elapsed ==

   timeID = setTimeout("animate_rev()", delay_time);

}

 

 

//===> Changes playing speed by adding to or substracting from the delay between frames

function change_speed(dv)

{

   delay+=dv;

   //== check to ensure max and min delay constraints have not been crossed ==

   if(delay > delay_max) delay = delay_max;

   if(delay < delay_min) delay = delay_min;
   document.getElementById("speedinterval").innerText = Math.round(1000/delay*100)/100;

}

 

//===> functions that changed the dwell rates.

function change_end_dwell(dv) {

   end_dwell_multipler+=dv;

   if ( end_dwell_multipler < 1 ) end_dwell_multipler = 0;

   }

 

function change_start_dwell(dv) {

   start_dwell_multipler+=dv;

   if ( start_dwell_multipler < 1 ) start_dwell_multipler = 0;

   }

 

//===> Increment to next image

function incrementimage(number)

{

   stop();

	--current_image;

	removeCurrentIdx();

	++current_image;

   //== if image is last in loop, increment to first image ==

   if (number > last_image) number = first_image;

 

   //== check to ensure that image has not been deselected from loop ==

   while (imageNum[number-first_image] == false) {

         number++;

         if (number > last_image) number = first_image;

   }

   current_image = number;

   displayCurrentIdx();

   document.images['animation'].src = theImages[current_image-first_image].src;   //display image

   document.control_form.frame_nr.value = current_image;                //display image number

}

 

//===> Decrement to next image

function decrementimage(number)

{

   stop();

	++current_image;

	removeCurrentIdx();

	--current_image;

   //== if image is first in loop, decrement to last image ==

   if (number < first_image) number = last_image;

 

   //== check to ensure that image has not been deselected from loop ==

   while (imageNum[number-first_image] == false) {

         number--;

         if (number < first_image) number = last_image;

   }

   

   current_image = number;

   displayCurrentIdx();

   document.images['animation'].src = theImages[current_image-first_image].src;   //display image

   document.control_form.frame_nr.value = current_image;                //display image number

}

 

//===> "Play forward"

function fwd()

{

   stop();

   status = 1;

   play_mode = 1;

   animate_fwd();
	document.getElementById("run_title").style.display = "none";
}

 

//===> "Play reverse"

function rev()

{

   stop();

   status = 1;

   play_mode = 1;

   animate_rev();

}



//===> "play sweep"

function sweep() {

   stop();

   status = 1;

   play_mode = 2;

   animate_fwd();

   }

 

//===> Change play mode (normal, loop, swing)

function change_mode(mode)

{

   play_mode = mode;

}

 

//===> Load and initialize everything once page is downloaded (called from 'onLoad' in <BODY>)

function launch()

{

  

   for (var i = first_image + 1; i <= last_image; i++)

   {

      theImages[i-first_image] = new Image();

      theImages[i-first_image].src = modImages[i-first_image];

      imageNum[i-first_image] = true;

      

   }

   for (var i = first_image + 1; i <= last_image; i++)

   {

	  document.images['animation'].src = theImages[i-first_image].src;

      document.control_form.frame_nr.value = i;
   }

   // this needs to be done to set the right mode when the page is manually reloaded

   change_mode (1);

   fwd();
   document.getElementById("speedinterval").innerText = Math.round(1000/delay*100)/100;
   

}

 

//===> Check selection status of image in animation loop

function checkImage(status,i)

{

   if (status == true)

      imageNum[i] = false;

   else imageNum[i] = true;

}

 

//==> Empty function - used to deal with image buttons rather than HTML buttons

function func()

{

}

 

//===> Sets up interface - this is the one function called from the HTML body

function animation()

{

  count = first_image;

}



function startup()

{

	

	//===> downloadStatus

	var downloadStatus = document.getElementById("downloadStatus");

	// clear

	for (i = 0; i < numOfPics ; i++)

	{

		 if (downloadStatus.firstChild) {

			   downloadStatus.removeChild(downloadStatus.firstChild);

		 }

	}

	//build

	for (i = 1; i <= numOfPics ; i++)

	{

		 newDiv = document.createElement("div");

		 newDiv.id = "dwnStatus" + (i);

		 newDiv.style.width = "100px";

		 newDiv.style.height = "18px";

		 newDiv.innerHTML = "<a href=\"javascript:void(0)\" style=\"display:block\" onclick=\"displayImageIdx(" + (i) +")\">" + (i) + "</a>";

		 newDiv.className = "inv";
	     //var newLink = document.createElement('a');
		 //var href = document.createAttribute('href');
		 //newLink.setAttribute(href,'javascript:void(0)');
		 //newLink.onclick = "displayImageIdx(" + i + ")";
		 //newLink.innerText = i + 1;
		 //newDiv.appendChild(newLink);
		 //var oc = document.createAttribute('onclick');
		 //newDiv.setAttribute(oc,"displayImageIdx(" + (i + 1) + ")");
		 
		 downloadStatus.appendChild(newDiv); 

	}



	//===> Preload the first image (while page is downloading)

	   theImages[0] = new Image();

	   theImages[0].src = modImages[0];

	   imageNum[0] = true;

}

 

 function imageDownloaded()

 {

	 var imagedownloaded = document.getElementById('imagedownloaded');

	  imagedownloaded.innerHTML = current_image;

	   var dwnStatus_id = 'dwnStatus' + current_image;

	  var dwnStatus = document.getElementById(dwnStatus_id);

	  //dwnStatus.style.backgroundColor = 'green';

	  //dwnStatus.style.borderLeft = '5px solid';

	  dwnStatus.className = "inv_plain_3_zebra";

 }

 function displayCurrentIdx()

 {
	  for (i=0;i<numOfPics;i++ )
	  {
		  var imageid = 'dwnStatus' + i;
		  var imagediv = document.getElementById(imageid);
		  if (imagediv)
		  {
				imagediv.style.borderLeft = '';
		  }
		  
	  }
	  var dwnStatus_id = 'dwnStatus' + current_image;

	  var dwnStatus = document.getElementById(dwnStatus_id);

	  dwnStatus.style.borderLeft = '5px solid';

 }

 function removeCurrentIdx()

 {

	  var dwnStatus_id = 'dwnStatus' + current_image;

	  var dwnStatus = document.getElementById(dwnStatus_id);

	  dwnStatus.style.borderLeft = '';

 }
 function displayImageIdx(idx)
 {
	  document.images['animation'].src = theImages[idx - 1].src;
	  document.control_form.frame_nr.value = idx;
	  current_image = idx;
	  displayCurrentIdx();

 }

// -->

</script>

</head>

  <body onload="startup">


<div style="width:100%;float:<?echo get_s_align();?>" class="inv_plain_3">
<h1><?=$RAIN_RADAR[$lang_idx]?></h1>
<div style="width:140px;float:<?echo get_s_align();?>;padding:0.2em 0 0 0;z-index:50" class="inv_plain_3">
<div style="width:140px;float:<?echo get_s_align();?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>>                        


<br/>
<a href="javascript: func()" onclick="incrementimage(++current_image)">
	<img src="images/forward.png" alt="forward קדימה"/>
</a>
&nbsp;&nbsp;
<a  href="javascript: func()" onclick="stop()">
	<img src="images/stop.png" alt="stop עצור" width="20px"/>
</a>
&nbsp;&nbsp;
<a href="javascript: func()" onclick="decrementimage(--current_image)">
	<img src="images/backward.png" alt="backward אחורה"/>
</a>
<div id="imagedownloaded_wrapper" style="">
	<div id="imagedownloaded" style="display:inline">
	</div>
</div>
 <div id="run_title" style="display:none" class="inv_plain_3_zebra">
 <a href="javascript: func()" onclick="change_mode(1);fwd()">
	<? if (isHeb()) echo "הרצה"; else echo "Play"; ?>
</a><?=get_arrow()?><?=get_arrow()?>
</div>
<div style="margin:0 0.5em" class="inv_plain_3_zebra">
<a href="javascript: func()" onclick="change_speed(delay_step)">
	<? if (isHeb()) echo "לאט יותר"; else echo "slower"; ?>
</a><?=get_arrow()?>
</div>
<div style="margin:0 0.5em" class="inv_plain_3_zebra">
<a href="javascript: func()" onclick="change_speed(-delay_step)">
	<? if (isHeb()) echo "מהר יותר"; else echo "faster"; ?>
</a><?=get_arrow()?>
</div>
</div>
<div style="clear:both;<? if (isHeb()) echo "direction:rtl"; ?>"><span id="speedinterval"></span><? if (isHeb()) echo " פריים לשנייה "; else echo " frame per sec"; ?></div>
<br/>
<div style="margin:0.5em;width:120px;float:<?echo get_s_align();?>;z-index:2;" id="downloadStatus">

</div>
</div>
<div style="width:520px;float:<?echo get_s_align();?>;z-index:0" id="radarimg" class="inv_plain_3">

 <img name="animation" id="noBaseGraph" src="http://www.ims.gov.il/Ims/Pages/RadarImage.aspx?Row=19&TotalImages=20&LangID=1&Location=" width="512px" height="512px" alt="IMS radar" style="z-index:0"/>

 <div id="locdiv" style="position:relative;margin:0;padding:0;top:-235px;left:292px;width:8px;height:8px;z-index:100;background-color:red" >

 </div>
 <div style="margin:0.5em">
	<img src="images/radar_scale_eng.jpg" alt="scale of rain rate" />
</div>
</div>
<div style="float:<?echo get_s_align();?>;z-index:0" id="radarad">
<script type="text/javascript"><!--
google_ad_client = "pub-2706630587106567";
/* 160x600, created 9/24/10 */
google_ad_slot = "1823672538";
google_ad_width = 160;
google_ad_height = 600;
google_color_border = ["<?= $forground->bg['+4'] ?>"];
google_color_bg = ["<?= $forground->bg['+4'] ?>"];
google_color_link = ["<?= $forground->bg['-9'] ?>"];
google_color_url = ["<?= $forground->bg['-9'] ?>"];
google_color_text = ["<?= $forground->bg['-9'] ?>"];

//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

</div>
</div>
<div style="width:120px;left:480px;top:100px;position:absolute;z-index:2" class="inv">

	

	<form method="post" name="control_form">

	Pic #:          

	<input type="text" name="frame_nr" value='' size="1" onfocus="this.select()" onchange="go2image(this.value)"></input>

	                       

	</form>

	

</div>



</body>

<script language="javascript" type="text/javascript">

	startup();

	launch();

	var disableLoopHeader = true;

	//show('locdiv', 'noBaseGraph', 'radarimg',+182, +105);

</script>

</html>


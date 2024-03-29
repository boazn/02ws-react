
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
	<script type="text/javascript" src="/sprintf2.js?foo=222"></script>

	<script language="javascript" type="text/javascript">
   function checkImageExists(imageSrc, good, bad) {
      var img = new Image();
      img.onload = good; 
      img.onerror = bad;
      img.src = imageSrc;
   }
   function getLatestImgTime(min_sub){
      var coeff = 1000 * 60 * 10;
      
      var date = new Date();  //or use any other date
      var rounded = new Date(Math.round(date.getTime() / coeff) * coeff);
      var found = false;
      rounded.setTime(rounded.getTime() - min_sub*60*1000);
      var imagepath = sprintf("https://ims.gov.il/sites/default/files/ims_data/map_images/IMSRadar4GIS/IMSRadar4GIS_%04d%02d%02d%02d%02d_0.png", rounded.getFullYear(), ("0" + (rounded.getMonth() + 1)).slice(-2), rounded.getDate(), rounded.getHours(), rounded.getMinutes());
      //var imagepath = sprintf("https://ims.gov.il/sites/default/files/ims_data/map_images/radar/radar_%04d%02d%02d%02d%02d.gif", rounded.getFullYear(), ("0" + (rounded.getMonth() + 1)).slice(-2), rounded.getDate(), rounded.getHours(), rounded.getMinutes());
      //console.log(imagepath);
      checkImageExists(imagepath,
      function(){ 
         //alert(imagepath);
         console.log(imagepath + " found");
         found = true;
         buildImageArray(rounded);
      }, 
      function(){ 
         
         if (numSearched > 8){
            console.log("img not found. passed threshold");
            rounded = null;
            found = false;
         }
            
      else{
         min_sub = min_sub + 5;//default = 5
         numSearched = numSearched + 1;
         console.log(imagepath + " not found. Searching -" + min_sub);
         getLatestImgTime(min_sub);
      } 
      });
      
      
         
      /*if (imageExists(imagepath))
         return rounded;
      else{
         numSearched = numSearched + 1
         min_sub = min_sub + 5;
         console.log("img not found. Searching " + min_sub);
         if (numSearched > 20)
            return false;
         else
            return getLatestImgTime(min_sub);
      }*/
     
   }
   
      
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
<? if ($_GET['pics'] == "") $numOfPics = 10 ; else $numOfPics = $_GET['pics'];  ?>
var numOfPics = <?=$numOfPics?>;
var numSearched = 0;
modImages = new Array();
timeImages = new Array();
year = <?=$year?>;
month =  <?=$month?>;
day =  <?=$day?>;
first_image = 1;

      last_image = numOfPics;

      

      //**************************************************************************

      

      //=== THE CODE STARTS HERE - no need to change anything below ===



      normal_delay = 500;

      delay = normal_delay;         //delay between frames in 1/100 seconds

      delay_step = 150;

      delay_max = 6000;

      delay_min = 50;

      dwell_multipler = 4;

      dwell_step = 1;

      end_dwell_multipler   = 1;

      start_dwell_multipler = dwell_multipler;      // originally: dwell_multipler;

      current_image = first_image;     //number of the current image

      timeID = null;

      status = 0;                      // 0-stopped, 1-playing

      play_mode = 2;                   // 0-normal, 1-loop, 2-sweep

      size_valid = 0;

      

      //===> Make sure the first image number is not bigger than the last image number

      if (first_image > last_image)

      {

         var help = last_image;

         last_image = first_image;

         first_image = help;

      }
      getLatestImgTime(10);
      setInterval(getLatestImgTime, 60*1000, 10);

function buildImageArray(rounded){
   for (i = 0; i < numOfPics ; i++)

      {
         var imagepath = sprintf("https://ims.gov.il/sites/default/files/ims_data/map_images/IMSRadar4GIS/IMSRadar4GIS_%04d%02d%02d%02d%02d_0.png", rounded.getFullYear(), ("0" + (rounded.getMonth() + 1)).slice(-2), rounded.getDate(), rounded.getHours(), rounded.getMinutes());
         //var imagepath = sprintf("https://ims.gov.il/sites/default/files/ims_data/map_images/radar/radar_%04d%02d%02d%02d%02d.gif", rounded.getFullYear(), ("0" + (rounded.getMonth() + 1)).slice(-2), rounded.getDate(), rounded.getHours(), rounded.getMinutes());
         modImages[i] = imagepath;
         timeImages[i] = new Date(rounded);
         if (i == 0){

            theImages[0] = new Image();
      	   theImages[0].src = imagepath;
	         imageNum[0] = true;
            document.images['animation'].src = imagepath;
            toggle('play');
         }
            
         console.log("putting: " + imagepath);
         rounded.setMinutes( rounded.getMinutes() - 5 ); // default = 5

      }
      <?php
         
      /*	$radarpics = getLastFilesFromDir("images/radar", $numOfPics);
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
      */	
      ?>

      
}


function stop()

{

   //== cancel animation (timeID holds the expression which calls the fwd or bkwd function) ==

   //if (status == 1)

      clearTimeout (timeID);

   status = 0;
   toggle('play');

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
   $("#frametime").html(sprintf("%02d:%02d",timeImages[current_image-first_image].getHours(),timeImages[current_image-first_image].getMinutes()));
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

   //timeID = setTimeout("animate_fwd()", delay_time);

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
   $("#frametime").html(sprintf("%02d:%02d",timeImages[current_image-first_image].getHours(),timeImages[current_image-first_image].getMinutes()));
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
   $("#frametime").html(sprintf("%02d:%02d",timeImages[current_image-first_image].getHours(),timeImages[current_image-first_image].getMinutes()));
   document.control_form.frame_nr.value = current_image;                //display image number

}

 

//===> Decrement to next image

function decrementimage(number)

{

   
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
   $("#frametime").html(sprintf("%02d:%02d",timeImages[current_image-first_image].getHours(),timeImages[current_image-first_image].getMinutes()));
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

   change_mode (2);

   rev();
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
function changeNumOfPics (pics)
{
	//alert (inprofile);
	toggle('waiting');
	document.getElementById('hiddenPics').value=pics;
	var loc = "<? echo get_url();?>";
	loc = loc.replace(/pics=\d+/g, "pics=" + pics);
        if (loc.indexOf("pics") < 0)
            loc = loc + "&pics=" + pics;
	top.location.href=loc;
	//document.profileChanger.action=loc;
	//document.profileChanger.submit();
	
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

		 newDiv.style.width = "50px";

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

	   //theImages[0] = new Image();

	   //theImages[0].src = modImages[0];

	   //imageNum[0] = true;

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
           timeID = setTimeout("animate_fwd()", delay_time);
 }

 function toggle(id)
 {
   
if(document.getElementById(id))
{if(document.getElementById(id).style.display=='none')
{$('#'+id).show("slow");}
else
$('#'+ id).hide("slow");}
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
     $("#frametime").html(sprintf("%02d:%02d",timeImages[idx - 1].getHours(),timeImages[idx - 1].getMinutes()));
	  document.control_form.frame_nr.value = idx;
	  current_image = idx;
	  displayCurrentIdx();

 }
function imgError(image) {
    image.onerror = "";
    image.src = "";
    var img = new Image();
    img.src = image.src;
    return true;
}
// -->

</script>

</head>

  <body onload="startup">


<div id="wrapper">


<div id="waiting" class="topbase" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="display:none;">
<? if (isHeb()) echo "טוען..."; else echo "Loading...";?>&nbsp;
<img src="images/loading.gif" alt="loading" width="32" height="32"/>
</div>

<div  id="imsradar" class="float" >
<!--<div class="il_map">
   <div id="leaflet_map" class="leaflet-container leaflet-touch leaflet-retina leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom" tabindex="0" style="height: 430px; position: relative; outline: none;">
      <div class="leaflet-pane leaflet-map-pane" style="transform: translate3d(-157px, 0px, 0px);">
      <div class="leaflet-pane leaflet-tile-pane"><div class="leaflet-layer " style="z-index: 1; opacity: 1;">
      <div class="leaflet-tile-container leaflet-zoom-animated" style="z-index: 18; transform: translate3d(0px, 0px, 0px) scale(1);">
      <img alt="" role="presentation" src="img/152/103.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(151px, -6px, 0px); opacity: 1;">
      <img alt="" role="presentation" src="img/152/104.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(151px, 250px, 0px); opacity: 1;">
     
   </div>
  </div>
  </div>
  <div class="leaflet-pane leaflet-shadow-pane"></div>
  <div class="leaflet-pane leaflet-overlay-pane">
   <img class="leaflet-image-layer leaflet-zoom-animated" src="/sites/default/files/ims_data/map_images/IMSRadar4GIS/IMSRadar4GIS_202301031350_0.png" alt="" style="z-index: 1; opacity: 0.7; transform: translate3d(-172px, -333px, 0px); width: 1034px; height: 1126px;"></div>
   <div class="leaflet-pane leaflet-marker-pane"></div>
   <div class="leaflet-pane leaflet-tooltip-pane"></div>
   <div class="leaflet-pane leaflet-popup-pane"></div>
   <div class="leaflet-proxy leaflet-zoom-animated" style="transform: translate3d(39057.5px, 26589px, 0px) scale(128);">
   </div></div>
   <div class="leaflet-control-container">
      <div class="leaflet-top leaflet-left">
         <div class="leaflet-control-zoom leaflet-bar leaflet-control">
            <a class="leaflet-control-zoom-in" href="#" title="Zoom in" role="button" aria-label="Zoom in">+</a>
            <a class="leaflet-control-zoom-out" href="#" title="Zoom out" role="button" aria-label="Zoom out">−</a>
         </div>
      <div class="leaflet-bar easy-button-container leaflet-control">
         <button class="easy-button-button leaflet-bar-part leaflet-interactive unnamed-state-active" type="button" title="Center">
            <span class="button-state state-unnamed-state unnamed-state-active">
               <span class="fas fa-crosshairs"></span>
            </span>
         </button>
      </div>
   </div>
   <div class="leaflet-top leaflet-right"></div>
   <div class="leaflet-bottom leaflet-left"></div>
   <div class="leaflet-bottom leaflet-right">
      <div class="leaflet-control-attribution leaflet-control"><a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> | Map data © Survey of Israel</div>
   </div>
   </div>
</div>
  
   <link rel="stylesheet" href="css/leaflet.css">
   <script src="js/leaflet.js"></script>
   <script src="js/leaflet.wms.js"></script>
   <link rel="stylesheet" href="css/easy-button.css">
   <script src="js/easy-button.js"></script>
</div>-->
<div style="display:none;margin:0.5em;width:60px;float:<?echo get_s_align();?>;z-index:2;<?echo get_s_align();?>:-110px;top:370px;position:absolute" id="downloadStatus"></div>
<div id="radarimg" >
<div id="radarcontrols" >                        
<a href="javascript: func()" onclick="launch();toggle('play');toggle('fasterslowercontrols');" id="playcontrol">
	<img id="play" width="60" height="60" src="images/play.png" alt="start התחל" style="display:none;"/>
</a>
<br/><!--
<a href="javascript: func()" onclick="incrementimage(++current_image)">
	<img src="images/forward.png" alt="forward קדימה"/>
</a>
&nbsp;&nbsp;
-->

<!--
&nbsp;&nbsp;
<a href="javascript: func()" onclick="decrementimage(--current_image)">
	<img src="images/backward.png" alt="backward אחורה"/>
</a>-->

<div id="imagedownloaded_wrapper" style="">
	<div id="imagedownloaded" style="display:inline">
	</div>
</div>
 <div id="run_title" style="display:none" class="inv_plain_3">
 <a href="javascript: func()" onclick="change_mode(2);fwd()">
	<? if (isHeb()) echo "הרצה"; else echo "Play"; ?>
</a><?=get_arrow()?><?=get_arrow()?>
</div>

<!--<div id="fasterslowercontrols" style="display:none;width:550px">
<a  href="javascript: func()" onclick="stop();toggle('play');">
	<img src="images/stop.png" alt="stop עצור" width="20px"/>
</a>
<div style="margin:0 0.5em;padding: 0.7em;display:inline" class="inv_plain_3 big">
<a href="javascript: func()" onclick="change_speed(delay_step)">
	<? if (isHeb()) echo "לאט יותר"; else echo "slower"; ?>
</a>
</div>
<div style="margin:0 0.5em;padding: 0.7em;display:inline" class="inv_plain_3 big">
<a href="javascript: func()" onclick="change_speed(-delay_step)" >
	<? if (isHeb()) echo "מהר יותר"; else echo "faster"; ?>
</a>
</div>
<div id="speedintervalwrapper" class="inv_plain_2 big" style="display:inline;<? if (isHeb()) echo "direction:rtl"; ?>"><span id="speedinterval"></span><? if (isHeb()) echo " פריים לשנייה "; else echo " frame per sec"; ?></div>
<div class="float" style="display:inline">
<form method="post" name="profileChanger" action="" style="background:transparent;" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
				
				<select size="1" id="profile" name="profile" class="inv_plain_2" onchange="changeNumOfPics(this.options[this.selectedIndex].value)" <? if (isHeb()) echo "dir=\"rtl\""; ?>> 
						<option	<? if ($_REQUEST['pics'] == "10") echo " selected ";?> value="10">10 <?=$PICS[$lang_idx];?></option>
						<option	<? if ($_REQUEST['pics'] == "15") echo " selected ";?> value="15">15 <?=$PICS[$lang_idx];?></option>
						<option	<? if ($_REQUEST['pics'] == "20") echo " selected ";?> value="20">20 <?=$PICS[$lang_idx];?></option>
						
				</select>
    <input type="hidden" name="myPHPvar" id="hiddenPics" value="" />
    </form>
</div>
</div>-->
</div>
 <div id="frametime" class="number big" style="position:absolute;margin:250px 180px"></div>
 <img name="animation" id="noBaseGraph" onerror="imgError(this);" src="" width="520px" height="520px" alt="IMS radar" style="z-index:0"/>
 
 
 <div style="margin:0.5em">
	<? echo $SOURCE[$lang_idx].": ".$IMS[$lang_idx];?>
</div>
</div><!-- id="wrapper" -->
</div>
<div id="geshemspace" class="float" >
<iframe src="https://geshem.space/" width="420px" height="640px" scrolling="auto" id="iframegeshem" class="base" allowtransparency="true" marginHeight="0" marginWidth="0" frameborder="0" ></iframe>
   
 </div>
 <div id="rainviewer" class="float" >
 <iframe src="https://www.rainviewer.com/map.html?loc=32.147,33.7281,7&oFa=0&oC=0&oU=0&oCS=1&oF=0&oAP=0&rmt=4&c=1&o=83&lm=0&th=0&sm=1&sn=1" width="420px" frameborder="0" style="border:0;height:63vh;" allowfullscreen></iframe>
   </div>
<div style="clear:both;z-index:0;<?if  (stristr($_SERVER['SCRIPT_NAME'], 'small')) echo "clear:both";?>" id="radarad">
<div id="adunit2">
<div data-onpage=true 
      data-adpath="/339474670,22847485332/02WS/Mobile_320x320">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2706630587106567"
     crossorigin="anonymous"></script>
<!-- 160x600, created 9/24/10 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:320px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="1823672538"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
 </div>
</div>
</div>
</div>
<div style="display:none;width:120px;right: -100px;top: 780px;position:absolute;z-index:2">

	

	<form method="post" name="control_form">

	Pic #:          

	<input type="text" name="frame_nr" value='' size="1" onfocus="this.select()" onchange="go2image(this.value)"></input>

	                       

	</form>

	

</div>
<div style="clear:both"></div>

<div class="float">
<h2 style="padding:1em"><?=$ARCHIVE[$lang_idx]?></h2>
<div style="padding:1em"><?=$BY_DATE[$lang_idx]?></div>
<?
		$latestRadarDays = getfilesFromdir($_SERVER['DOCUMENT_ROOT']."/images/radar/gif");
		$archradar = 0;
		foreach ($latestRadarDays as $lradar)
		{
            if (stristr($lradar[1], "dailyradar")) 
         {$archradar = $archradar + 1;
            $lradar[1] = str_replace($_SERVER['DOCUMENT_ROOT'], '',$lradar[1]);
			?>
			
			<div style="float:<?echo get_s_align();?>;padding:0.5em" class="inv_plain_3_zebra">
				<a href="<?=$lradar[1]?>" title="<?echo getLocalTime($lradar[0]);?>" class="colorbox">
					<?echo replaceDays(getLocalDay($lradar[0]));?> 					
				</a>
			</div>
			<?
			}
			
		}
	?>	

</div>
<script language="javascript" type="text/javascript">
        //document.images['animation'].src = "http://www.ims.gov.il/Ims/Pages/RadarImage.aspx?Row=19&TotalImages=20&LangID=1&Location=";
	startup();
	//launch();

	var disableLoopHeader = true;

	//show('locdiv', 'noBaseGraph', 'radarimg',+182, +105);
        
        
</script>




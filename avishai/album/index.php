<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" lang="he">
<head>
	<title>אבישי הדסי</title>
	<meta name="description" content="אבישי הדסי" />
	<meta name="keywords" content="אבישי הדסי"/>
	<meta name="author" content="בועז נחמיה" />
	<link rel="Stylesheet" href="style.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
</head>
 <body>
<h1>אבישי בתמונות</h1>

<p id="intro">
  אלבום תמונות של אבישי 

</p>




<div class="album">

  <h2>משפחה</h2>

	<a href="http://02ws.co.il/avishai/images/avishai with ori.jpg">

    <img src="http://02ws.co.il/avishai/images/avishai with ori_t.jpg" alt="אבישי עם אורי" />

  </a>
  <a href="http://02ws.co.il/avishai/avishai/images/wedding.jpg">

    <img src="http://02ws.co.il/avishai/images/wedding_t.jpg" alt="חתונה" />

  </a>

  <a href="http://02ws.co.il/avishai/images/tammys wedding.jpg">

    <img src="http://02ws.co.il/avishai/images/tammys wedding_t.jpg" alt="חתונה של תמי" />

  </a>

  <a href="http://02ws.co.il/avishai/images/wedding pics.jpg">

    <img src="http://02ws.co.il/avishai/images/wedding pics_t.jpg" alt="תמונות  - חתונה" />

  </a>

  

</div>

<div class="album">

  <h2>ילדות</h2>

<a href="http://02ws.co.il/avishai/images/soldier.jpg">

    <img src="http://02ws.co.il/avishai/images/soldier_t.jpg" alt="חייל" />

  </a>

  <a href="http://02ws.co.il/avishai/images/baby.jpg">

    <img src="http://02ws.co.il/avishai/images/baby_t.jpg" alt="אבישי התינוק" />

  </a>

  <a href="http://02ws.co.il/avishai/images/childhood.jpg">

    <img src="http://02ws.co.il/avishai/images/childhood_t.jpg" alt="ילדות" />

  </a>

  <a href="http://02ws.co.il/avishai/images/childhood 2.jpg">

    <img src="http://02ws.co.il/avishai/images/childhood 2_t.jpg" alt="ילדות " />

  </a>

   <a href="http://02ws.co.il/avishai/images/basketball.jpg">

    <img src="http://02ws.co.il/avishai/images/basketball_t.jpg" alt="כדורסל" />

  </a>

   <a href="http://02ws.co.il/avishai/images/abroad.jpg">

    <img src="http://02ws.co.il/avishai/images/abroad_t.jpg" alt="טיול לחול" />

  </a>

   
</div>

<div class="album">

  <h2>מסמכים</h2>

  
 <a href="http://02ws.co.il/avishai/images/viena.jpg">

    <img src="http://02ws.co.il/avishai/images/viena_t.jpg" alt="וינה" />

  </a>
  
  <a href="http://02ws.co.il/avishai/images/C.Vhttp://avishai.02ws.comjpg">

    <img src="http://02ws.co.il/avishai/images/C.V._t.jpg" alt="C.V" />

  </a>

   <a href="http://02ws.co.il/avishai/images/Father.jpg">

    <img src="http://02ws.co.il/avishai/images/Father_t.jpg" alt="אבא" />

  </a>

  <a href="http://02ws.co.il/avishai/images/Micheal.jpg">

    <img src="http://02ws.co.il/avishai/images/Micheal_t.jpg" alt="מכתב  ממיכאל" />

  </a>

  <a href="http://02ws.co.il/avishai/images/song.jpg">

    <img src="http://02ws.co.il/avishai/images/song_t.jpg" alt="שיר" />

  </a>


</div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script>
 <script type="text/javascript" src="https://malsup.github.io/min/jquery.cycle.all.min.js"></script> 
 <script type="text/javascript" src="js/jquery.lightbox-0.5.pack.js"></script> 
 <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" /> 
    
<script type="text/javascript">
<!--
	$(document).ready( function() {
  // Dynamically add nav buttons as these are not needed in non-JS browsers
 /* var prevNext = '<div id="album-nav" style=\"width:600px;margin:0 auto\"><button ' +
                   'class="prev">&laquo; Previous' +
                   '</button><button class="next">' +
                   'Next &raquo;</button></div>';
  $(prevNext).insertAfter('.album:last');
  // Add a wrapper around all .albums and hook jquery.cycle onto this
  $('.album').wrapAll('<div id="photo-albums" style=\"width:600px;margin:0 auto\"></div>');
  $('#photo-albums').cycle({
    fx:     'turnDown',
    speed:  500,
    timeout: 0,
    next:   '.next',
    prev:   '.prev'
  });
  // Remove the intro on first click -- just for the fun of it
  $('.prev,.next').click(function () {
    $('#intro:visible').slideToggle();
  });*/
  // Add lightbox to images
  $('.album a').lightBox();
});

//-->
</script>
</body>
</html>
/* PARALLAX SCROLLING EXPERIMENT
   Author: Jonathan Nicol (f6design.com)
   Tutorial from: http://f6design.com/journal/2011/08/06/build-a-parallax-scrolling-website-interface-with-jquery-and-css/
   
   + changes and some other functions
*****************************************************************/


$(document).ready(function() {
	isClicked = false;
	hasStopped = false;
	isLionLimit = false;
	isSidebarLimit = false;
	
	
	redrawDotNav();
	
		/* Scroll event handler */
    $(window).bind('scroll',function(e){
	
    	parallaxScroll();
	if ( !isClicked ) {
		redrawDotNav();
	}
    });
    
	/* Next/prev and primary nav btn click handlers */
	$('a.now').click(function(){
	    $('.main_nav a').removeClass('active');
	    $('.main_nav a.now').addClass('active');
	    isClicked = true;
    	$('html, body').animate({
    		scrollTop:0
    	}, 1000, function() {
	    	parallaxScroll(); // Callback is required for iOS
		});
    	return false;
	});
    $('a.more').click(function(){
	$('.main_nav a').removeClass('active');
	$('.main_nav a.more').addClass('active');
	 isClicked = true;
    	$('html, body').animate({
    		scrollTop:$('#more').offset().top
    	}, 1000, function() {
	    	parallaxScroll(); // Callback is required for iOS
		});
    	return false;
    });
    $('a.pics').click(function(){
	$('.main_nav a').removeClass('active');
	$('.main_nav a.pics').addClass('active');
	 isClicked = true;
    	$('html, body').animate({
    		scrollTop:$('#pics').offset().top
    	}, 1000, function() {
	    	parallaxScroll(); // Callback is required for iOS
		});
    	return false;
    });
	$('a.forum').click(function(){
	    $('.main_nav a').removeClass('active');
	    $('.main_nav a.forum').addClass('active');
	     isClicked = true;
    	$('html, body').animate({
    		scrollTop:$('#forum').offset().top -100
    	}, 1000, function() {
	    	parallaxScroll(); // Callback is required for iOS
		});
    	return false;
    });
    
    /* Show/hide dot lav labels on hover */
    $('.main_nav a').hover(
    	function () {
			$(this).prev('h1').show();
		},
		function () {
			$(this).prev('h1').hide();
		}
    );
    
});

/* Scroll the background layers */
function parallaxScroll(){
	
	var scrolled = $(window).scrollTop();
	$('#forcast_title').css('margin-right',(30-(scrolled))+'px');
	$('#forcast_title').css('opacity',(1-(scrolled*0.005)));
	
	
	if (scrolled >= $('#more').offset().top) {
		//alert("ss");
		$('#newsletter').css('margin-right',(30-(scrolled-$('#more').offset().top))+'px');
		$('#newsletter').css('opacity',(1-((scrolled-$('#more').offset().top)*0.005)));
		$('#outside_links').css('margin-right',(60-(scrolled-$('#more').offset().top))+'px');
		$('#outside_links').css('opacity',(1-((scrolled-$('#more').offset().top)*0.005)));
		$('#did_you_know').css('margin-right',(900+(scrolled-$('#more').offset().top))+'px');
		$('#did_you_know').css('opacity',(1-((scrolled-$('#more').offset().top)*0.005)));
	} else {
		$('#newsletter').css('margin-right',30 +"px");
		$('#newsletter').css('opacity',1);
		$('#outside_links').css('margin-right',60 +"px");
		$('#outside_links').css('opacity',1);
		$('#did_you_know').css('margin-right',900+'px');
		$('#did_you_know').css('opacity',1);
	}
	
	
	
	//$('#newsletter').css('opacity',(1-(scrolled*0.005)));
	
	
	//$('#outside_links').css('opacity',(1-(scrolled*0.005)));
	
	$('#parallax-bg1').css('top',(0-(scrolled*.25))+'px');
	$('#parallax-bg2').css('top',(0-(scrolled*.5))+'px');
	$('#parallax-bg3').css('top',(0-(scrolled*.75))+'px');
	
	$('#bg_backHills').css('top',(2350-(scrolled*0.4))+'px');
	$('#bg_map').css('top',(2700-(scrolled*0.6))+'px');
	$('#bg_hills').css('top',(2700-(scrolled*0.6))+'px');
	$('#bg_grass').css('top',(3450-(scrolled*0.8))+'px');
	$('#forum_bg').css('top',(3750-(scrolled*0.8))+'px');
	//$('#forum').css('top',(4050-(scrolled*1))+'px');
	$('#tree').css('top',(2920-(scrolled*1.5))+'px');
	$('#crow').css('top',(2920-(scrolled*1.5))+'px');
	
	$('#cover_clouds-1').css('left',(-(scrolled*2))+'px');
	$('#cover_clouds-2').css('left',(300-(scrolled*1.5))+'px');
	$('#cover_clouds-3').css('right',(-(scrolled*1.5))+'px');
	$('#cover_clouds-4').css('right',(-200-(scrolled*2))+'px');
	
}

/* Set navigation dots to an active state as the user scrolls */
function redrawDotNav(){
	var section1Top =  0;
	// The top of each section is offset by half the distance to the previous section.
	var section2Top =  $('#more').offset().top - (($('#pics').offset().top - $('#more').offset().top) / 2);
	var section3Top =  $('#pics').offset().top - (($('#forum').offset().top - $('#pics').offset().top) / 2);
	var section4Top =  $('#forum').offset().top - (($(document).height() - $('#forum').offset().top) / 2);;
	$('.main_nav a').removeClass('active');
	if($(document).scrollTop() >= section1Top && $(document).scrollTop() < section2Top){
		$('.main_nav a.now').addClass('active');
	} else if ($(document).scrollTop() >= section2Top && $(document).scrollTop() < section3Top){
		$('.main_nav a.more').addClass('active');
	} else if ($(document).scrollTop() >= section3Top && $(document).scrollTop() < section4Top){
		$('.main_nav a.pics').addClass('active');
	} else if ($(document).scrollTop() >= section4Top){
		$('.main_nav a.forum').addClass('active');
	}
	
}


$(window).scroll(function()
{
            isLionLimit = false;
		if ($(document).scrollTop() <  $('#forum').offset().top-180) {
			$('#forum_sidebar').css('position','absolute');
			$('#forum_sidebar').css('margin-top',180 +"px");
			$('#canvas').css('display','block');
			isSidebarLimit = false;
		} else if (!isSidebarLimit) {
			$('#canvas').css('display','none');
			isSidebarLimit = true;
			$('#forum_sidebar').css('position','fixed');
			$('#forum_sidebar').css('top','140px');
			
		}
		
		// lion will fall and keep being fixed
		if ( $(document).scrollTop() < 1575) {
			$('#lion').css('background-position',("-200px"));
			$('#lion').css('position','fixed');
			$('#lion').css('top','140px');
			isLionLimit = false;
			
		} else if (!isLionLimit){
			isLionLimit = true;
			$('#lion').css('position','absolute');
			$('#lion').css('top',(1575 + 140) + "px");
		}
	
   checkScroll();
   hasStopped = false;
});



function checkScroll() {        
    var timer;
    $(window).bind('scroll',function () {
        clearTimeout(timer);
        timer = setTimeout( refresh , 150 );
    });
    var refresh = function () { 
	isClicked = false;
	
	if (!hasStopped) {
		// make lion sit again
		//alert($(document).scrollTop());
		$('#lion').css('background-position',("left"));
		// move cloud with lion
		if ( $(document).scrollTop() < 1575) {
			$('#cloud_lion').animate({top:190 + $(document).scrollTop()}, 200, "swing");
		}
		hasStopped = true;
	}
	
    };
}

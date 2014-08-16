$(document).ready(function() {
   anim1Timer = setTimeout( anim1 , 5000);
});

function anim1() {
	//alert($('#lion').css('background-position'));
	if ($('#lion').css('background-position') == "0% 50%") {
		$('#lion').css('background-position',("-400px"));
		anim2Timer = setTimeout( anim2 , 200);
	} else {
		anim1Timer = setTimeout( anim1 , 5000);
	}
}

function anim2() {
	$('#lion').css('background-position',("-600px"));
	clearTimeout(anim1Timer);
	stopAnimTimer = setTimeout( stopAnim , 200);
}

function stopAnim() {
    $('#lion').css('background-position',("left"));
	clearTimeout(anim2Timer);
	 anim1Timer = setTimeout( anim1 , 5000);
}
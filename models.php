<script language="JavaScript" type="text/javascript">
function changeModel (inmodel)
{
	//alert (inmodel);
	toggle('waiting');
	var loc = "<? echo get_url();?>";
	loc = loc.replace(/model=\S{3,7}&/g, "model=" + inmodel + "&");
	//alert (loc);
	top.location.href=loc;
	
	
}
</script>
<center>
<div id="modelbar" class="tbl" style="width:<?= $site_width ?>;height:28px;">
<?
   ///////////////////////////////////////////////////////
// models links
///////////////////////////////////////////////////////
function getModelLink($level, $model)
{
	global $hour, $year, $month, $day, $hoursForecast;
	
	if ($hour<=19)	
			$iniHour = 0;  
		else	
			$iniHour = 12; 

	
	if (($level == '')||($level == 1000)) {
		$model_link = sprintf ("http://vortex.plymouth.edu/cgi-bin/gen_grbcalc.cgi?re=europe&id=&zoom=.6&ge=640x480&mo=%s&le=500&va=hght&in=60&pl=cf&ft=h%02d&cu=latest&overlay=yes&mo=%s&le=sfc&va=slp&in=5&pl=ln&ft=h%02d&cu=latest", $model,  $hoursForecast, $model,  $hoursForecast);
		$model_link = sprintf("http://weather.uwyo.edu/cgi-bin/model?REGION=EUR&MODEL=ukmet&TIME=%d%02d%02d%02d&F1=pmsl&F2=none&C1=pmsl&C2=hght&VEC=brbk&LEVEL=500&FCST=%03d", $year, $month, $day, $iniHour, $hoursForecast);
		$model_link = sprintf("http://vortex.plymouth.edu/cgi-bin/gen_grbcalc.cgi?re=meast&id=&zoom=.15&ti=0&ge=1280x775&mo=%s&le=500&va=hght&in=60&pl=cf&ft=h%02d&cu=latest&overlay=yes&mo=%s&le=sfc&va=slp&in=5&pl=ln&ft=h%02d&cu=latest", $model, $hoursForecast, $model, $hoursForecast);
		//if ((($hoursForecast % 12 == 6) || (($hoursForecast > 72)&&($hoursForecast % 24 == 12))) && ($model == "ukmet"))
		//	$model_link = sprintf("http://www.3bmeteo.com/mappe_gif/UKMWORD_%02d/GH+T%03d_EUROPA_%d", $iniHour, $level , $hoursForecast);
		if (($model == "ukmet") && ($hoursForecast > 72))
			$model_link = sprintf("http://www.wetterzentrale.de/pics/Rukm%d1.gif", $hoursForecast);
		if ($hoursForecast == 999)
		{
			if ($model == "ecmwf")
				$model_link = "http://weather.unisys.com/ecmwf/restrict/ecmwf_500p_6panel_eur.gif";
			else
				$model_link = "http://weather.unisys.com/gfsx/9panel/gfsx_500p_9panel_eur.gif";
		}

	}
	else if ($level == 'Prec')
	{
		
		$model_link = sprintf("http://vortex.plymouth.edu/cgi-bin/gen_grb-comp.cgi?re=meast&mo=%s&va=csfcpr&ft=h%02d&cu=latest&ge=800x630&ti=UTC&id=&zoom=.6", $model, $hoursForecast);
		if ($model == "ukmet")
		{
			if (($hoursForecast > 72)||($hoursForecast == 66)||($hoursForecast == 54))
				$model_link = sprintf("http://www.3bmeteo.com/mappe_gif/UKMWORD_%02d/prec6h_EUROPA_%d", $iniHour,  $hoursForecast);
			else if($hoursForecast % 12 == 6)
				$model_link = sprintf("http://www.wetterzentrale.de/pics/Rukm%d3.gif", $hoursForecast);
		}
		//else if ($model == "ecmwf")	
		//	$model_link = sprintf("http://www.3bmeteo.com/mappe_gif/ECMWORD_%02d/RH_COMP_PREC_MED_%d", $iniHour, $hoursForecast);			
		//else if ($hoursForecast % 12 == 6) // GFS
		//	$model_link = sprintf("http://91.121.93.17/pics/Rtavn%d4.png", $hoursForecast);
	}
	else if ($level == '850rh') 
	{
		if ((($hoursForecast > 72)||($hoursForecast == 66)||($hoursForecast == 54)) && ($model == "ukmet"))
			$model_link = sprintf("http://www.3bmeteo.com/mappe_gif/UKMWORD_%02d/RH850_EUROPA_%d", $iniHour,  $hoursForecast);
		else
		$model_link = sprintf("http://vortex.plymouth.edu/cgi-bin/gen_grbcalc.cgi?re=meast&id=&zoom=.15&ti=0&ge=1280x1024&mo=%s&le=850&va=rhum&in=5&pl=cf&ft=h%02d&cu=latest&overlay=yes&mo=%s&le=850&va=wbrb&in=5&pl=ln&ft=h%02d&cu=latest", $model,  $hoursForecast, $model,  $hoursForecast);
	}
	else if ($level == '500rh') 
	{
		if ((($hoursForecast > 72)||($hoursForecast = 66)||($hoursForecast == 54)) && ($model == "ukmet"))
			$model_link = sprintf("http://www.3bmeteo.com/mappe_gif/UKMWORD_%02d/RH500_EUROPA_%d", $iniHour,  $hoursForecast);
		else
		$model_link = sprintf("http://vortex.plymouth.edu/cgi-bin/gen_grbcalc.cgi?re=meast&id=&zoom=.15&ti=0&ge=1280x1024&mo=%s&le=500&va=rhum&in=5&pl=cf&ft=h%02d&cu=latest&overlay=yes&mo=%s&le=500&va=wbrb&in=5&pl=ln&ft=h%02d&cu=latest", $model, $hoursForecast, $model, $hoursForecast);
	}
	else if (($level == 850) || ($level == 200) || ($level == 300)) 
	{   // temp + wind
		$model_link = sprintf("http://weather.uwyo.edu/cgi-bin/model?REGION=EUR&MODEL=%s&TIME=%d%02d%02d%02d&F1=tmpc&F2=p06i&C1=tmpc&C2=relh&VEC=brbk&LEVEL=850&FCST=%03d", $model, $year, $month, $day, $iniHour, $hoursForecast);
		$model_link = sprintf("http://vortex.plymouth.edu/cgi-bin/gen_grbcalc.cgi?re=meast&id=&zoom=.15&ti=0&ge=1280x1024&mo=%s&le=%d&va=temp&in=1&pl=cf&ft=h%02d&cu=latest&overlay=yes&mo=%s&le=%d&va=wbrb&in=5&pl=ln&ft=h%02d&cu=latest", $model, $level, $hoursForecast, $model, $level, $hoursForecast);
		if ((($hoursForecast > 72)||($hoursForecast == 66)||($hoursForecast == 54)) && ($model == "ukmet"))
		{
			$model_link = sprintf("http://www.3bmeteo.com/mappe_gif/UKMWORD_%02d/GH+T%03d_EUROPA_%d", $iniHour, $level , $hoursForecast);
			if ($level == 300)
				$model_link = sprintf("http://www.3bmeteo.com/mappe_gif/UKMWORD_%02d/W%03d_EUROPA_%d", $iniHour, $level , $hoursForecast);	
		}
			
		if ($hoursForecast == 999)
		{
			
			if ($model == "ecmwf")
				$model_link = sprintf("http://weather.unisys.com/ecmwf/restrict/ecmwf_%d_6panel_eur.gif", $level);
			else
				$model_link = sprintf("http://weather.unisys.com/gfsx/9panel/gfsx_%d_9panel_eur.gif", $level);
		}
	}
	else if ($level == "comp")
	{
		$model_link = sprintf("http://vortex.plymouth.edu/cgi-bin/gen_grb-comp2.cgi?re=meast&mo=%s&va=c4pp&ft=h%02d&cu=latest&ge=1024x806&id=&zoom=.15", $model ,$hoursForecast);
	}
	else { // temp + humidity
		if ((($hoursForecast == 66)||($hoursForecast == 54) || ($hoursForecast > 72)) && ($model == "ukmet"))
			$model_link = sprintf("http://www.3bmeteo.com/mappe_gif/UKMWORD_%02d/GH+T%03d_EUROPA_%d", $iniHour, $level, $hoursForecast);
		else
		$model_link = sprintf("http://vortex.plymouth.edu/cgi-bin/gen_grbcalc.cgi?re=meast&id=&zoom=.15&ti=0&ge=1280x1024&mo=%s&le=%d&va=temp&in=1&pl=cf&ft=h%02d&cu=latest&overlay=yes&mo=%s&le=%d&va=rhum&in=10&pl=ln&ft=h%02d&cu=latest", $model, $level, $hoursForecast, $model, $level, $hoursForecast);
	}
	
	
  return ($model_link);
}
   $model = $_GET['model'];
	if ($model == "")
		$model = "ukmet";
	
   $model_l = "?section=models.php&amp;model=".$model."&amp;hours=%d&amp;lang=".$lang_idx;
   //var_dump ($GLOBALS);
?>
<ul class="nav" id="modelsnav" style="z-index: 0;width:100%">
	<? $model_c = sprintf($model_l, 12); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==12) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">12</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 18); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==18) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">18</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 24); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==24) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">24</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 30); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==30) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">30</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 36); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==36) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">36</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 42); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==42) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">42</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 48); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==48) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">48</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 54); $model_c = str_replace (" ", "", $model_c);?>
	 <li <?if ($hoursForecast==54) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">54</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li> 
	<? $model_c = sprintf($model_l, 60); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==60) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">60</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 66); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==66) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">66</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li> 
	<? $model_c = sprintf($model_l, 72); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==72) echo" class=\"inv_plain_3\"";?>><a href="<? echo sprintf ($model_l, 72);?>">72</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 84); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==84) echo" class=\"inv_plain_3\"";?>><a href="<? echo sprintf ($model_l, 84);?>">84</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 96); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==96) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">96</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 108); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==108) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">108</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 120); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==120) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">120</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=200";?>">200mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 132); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==132) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">132</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 144); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==144) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">144</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=comp";?>">Composite</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 156); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==156) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">156</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 168); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==168) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">168</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=Prec";?>">Prec</a></li>
		</ul>
	</li>
	<? $model_c = sprintf($model_l, 999); $model_c = str_replace (" ", "", $model_c);?>
	<li <?if ($hoursForecast==999) echo" class=\"inv_plain_3\"";?>><a href="<? echo $model_c;?>">Panel</a>
		<ul>
			<li><a href="<? echo $model_c."&amp;level=850";?>">850mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=850rh";?>">850mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=700";?>">700mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500";?>">500mb</a></li>
			<li><a href="<? echo $model_c."&amp;level=500rh";?>">500mb RH</a></li>
			<li><a href="<? echo $model_c."&amp;level=300";?>">300mb</a></li>
		</ul>
	</li>
	<li><select size="1" id="modelSwithcer"  onchange="changeModel(this.options[this.selectedIndex].value)">  
			<option	 value="ukmet" <? if ($_GET['model'] == "ukmet") echo "selected"; ?>>Bracknel</option>
			<option	 value="ecmwf" <? if ($_GET['model'] == "ecmwf") echo "selected"; ?>>Ecmwf</option>
			<option	 value="avn_glo" <? if ($_GET['model'] == "avn_glo") echo "selected"; ?>>GFS</option>
		</select>
	</li>
</ul>
</div>
</center>
<?
if ((stristr($model,"avn")) || (stristr($model,"gfs")))
{ if ($hoursForecast > 72)
	$model = "gfs_mrnh";
  else
	$model = "gfs_avn_glo"; //avn_glo //avn_nh //gfs_avn_nh
}
$url = getModelLink($_GET['level'], $model ) ;
//echo $url;
if ((stristr($url, "plymouth")) || (stristr($url, "3bmeteo")))
{
        
	$strModels = get_file_string($url);
	$start = strpos($strModels, "<img");
	$strModels = substr ($strModels, $start);
	$strModels = str_replace ( "..", "http://vortex.plymouth.edu", $strModels);
	echo $strModels;
}
else 
	echo "<img src=\"".$url."\" alt=\"02ws models\" />";
	
?>
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
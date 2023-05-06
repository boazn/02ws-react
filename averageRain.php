<style>
    #rainsummery td
    {
		line-height: 1em;
        padding: 0.5em;
    }
</style>
<table id="mouseover" width="100%" <? if (isHeb()) echo "dir=\"rtl\""; ?>> 

	<tr>

		<td colspan="4" class="base big"><h2><? echo($PRECIPITATION[$lang_idx]." - ".$DIFF_FROM[$lang_idx]);?> <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=averages" ><? echo($NORMAL[$lang_idx]);?></a></h2>

	</td>
	</tr>
	<tr>
	<td class="box">
	<table width="100%" id="rainsummery">
	<tr>

		<td width="180px">&nbsp;</td>

		<td  title="accumulation in mm" class="inv_plain_3"><? echo($RAIN[$lang_idx]);?> (<?=$RAIN_UNIT[$lang_idx]?>)</td>

		<td  title="number of rainy days" class="inv_plain_3"><? echo($RAINY_DAYS[$lang_idx]);?></td>

		

	</tr> 

	

	<tr class="inv_plain_3_zebra" >
		<td width="180px" title="" class="" <? echo get_inv_align();?> >
			<? echo($TILL_NOW[$lang_idx]);?>
		</td>
		<td dir="ltr" title="<? echo($RAIN[$lang_idx]);?>">
			<a href="#" class="number">
			<? echo $seasonTillNow->get_rain2();?>
			</a>
		</td>
		<td dir="ltr" title="<? echo($RAINY_DAYS[$lang_idx]);?>">
		<a href="#" class="number" >
			<? echo $seasonTillNow->get_rainydays(); ?>
		</a>
		</td>
	</tr>
	<tr class="inv_plain_3_zebra" >
		<td  width="180px" title="" class="" <? echo get_inv_align();?> >
			<? echo($AVERAGE[$lang_idx]." ".$TILL_NOW[$lang_idx]);?>
		</td>
		<td dir="ltr" class="number" title="<? echo($RAIN[$lang_idx]);?>">
                        
			<? echo $averageTillNow->get_rain();?>
			
		</td>
		<td dir="ltr" title="<? echo($RAINY_DAYS[$lang_idx]);?>">
		<a href="#" >
			
		</a>
		</td>
	</tr>

	<tr class="inv_plain_3_zebra">

		<td width="180px" title="compared to its decade accumulation from the season start (1/9)" <? echo get_inv_align();?> >
			<? //echo($DIFF_FROM[$lang_idx]." ".$TILL_NOW[$lang_idx]." ".$AVERAGE[$lang_idx]);?>
		</td>

		<td dir="ltr" title="<? echo $TILL_NOW[$lang_idx].": ".$seasonTillNow->get_rain()." <--> ".$NORMAL[$lang_idx]." ".$TILL_NOW[$lang_idx].": ".$averageTillNow->get_rain();?>" >
			
			<div  <? if ($seasonTillNow->get_raindiffav() > 0) echo "class=\"more number\">+"; else echo " class=\"less number\">"; echo round($seasonTillNow->get_raindiffav())."&nbsp;(".$seasonTillNow->get_rainperc()."%)";?>
			</div>
			
		</td>

		<td >
			
		</td>

	</tr>
	<tr height="2px" class="inv">
		<td title="" ></td>
		<td dir="ltr"></td>
		<td dir="ltr"></td>
	</tr>
	<tr class="inv_plain_3" >

		<td width="180px" title="" class="" <? echo get_inv_align();?> >
			<? echo $AVERAGE[$lang_idx]." ".$WHOLE_SEASON[$lang_idx];?>
		</td>

		<td dir="ltr" title="<? echo($RAIN[$lang_idx]);?>">
			<a href="#" class="number">
			<? echo $wholeSeason->get_rain();?>
			
			</strong>
		</td>

		<td dir="ltr" class="number" title="<? echo($RAINY_DAYS[$lang_idx]);?>">
			
			<? echo $wholeSeason->get_rainydays();?>
			
			
		</td>

	</tr>


	<tr  class="inv_plain_3">

		<td width="180px" title="" class="" <? echo get_inv_align();?> >
			<? echo $TILL_NOW[$lang_idx]." ".$DIFF_FROM[$lang_idx]." ".$AVERAGE[$lang_idx]." ".$WHOLE_SEASON[$lang_idx];?>
		</td>

		<td dir="ltr" title="<? echo $TILL_NOW[$lang_idx].": ".$seasonTillNow->get_rain()." <--> ".$WHOLE_SEASON[$lang_idx]." ".$NORMAL[$lang_idx].": ".$wholeSeason->get_rain();?>" >
			
			<div  <? if ($wholeSeason->get_raindiffav() >0) echo "class=\"more number\">+"; else echo " class=\"less number\">";echo round($wholeSeason->get_raindiffav())."&nbsp;(".$wholeSeason->get_rainperc()."%)"; ?>
			</div>
			
		</td>

		<td dir="ltr" title="<? echo $TILL_NOW[$lang_idx].": ".$seasonTillNow->get_rainydays()." <--> ".$WHOLE_SEASON[$lang_idx]." ".$NORMAL[$lang_idx].": ".$wholeSeason->get_rainydays();?>" >
			
			<div  <? if ($wholeSeason->get_rainydaysdiffav() >0) echo "class=\"more number\">+"; else echo " class=\"less number\">";echo $wholeSeason->get_rainydaysdiffav();?>
			</div>
			
		</td>

	</tr>
	<tr height="2px" class="inv">
		<td ></td>
		<td ></td>
		<td ></td>
	</tr>
	<tr class="inv_plain_2" >
		<td width="180px" title="" class="" <? echo get_inv_align();?> >
			<? echo $monthInWord." ".$year;?>
		</td>
		<td dir="ltr">
			<a href="#" class="number" title="<? echo($RAIN[$lang_idx]);?>">
			<? echo $thisMonth->get_rain();?>
			</a>
		</td>
		<td dir="ltr" title="<? echo($RAINY_DAYS[$lang_idx]);?>">
			<a href="#" class="number" >
			<? echo $thisMonth->get_rainydays();?>
			</a>
		</td>
	</tr>
	<tr class="inv_plain_2" >
		<td width="180px" title="" class="" <? echo get_inv_align();?> >
			<? echo $monthInWord." ".$AVERAGE[$lang_idx];?>
		</td>
		<td dir="ltr">
			<a href="#" class="number" >
			<? echo $monthAverge->get_rain();?>
			</a>
		</td>
		<td dir="ltr" title="<? echo($RAINY_DAYS[$lang_idx]);?>">
			<a href="#" class="number" >
			<? echo $monthAverge->get_rainydays();?>
			</a>
		</td>
	</tr>
	<tr class="inv_plain_2">
		<td width="180px" title="">
			<? //echo $monthInWord." ".$year." ".$DIFF_FROM[$lang_idx]." ".$monthInWord." ".$AVERAGE[$lang_idx];
			?>
		</td>
		<td dir="ltr" title="<? echo $monthInWord." ".$year.": ".$thisMonth->get_rain()." <--> ".$NORMAL[$lang_idx].": ".$monthAverge->get_rain();?>" >
			<? if (!$error_db) {?>
			
			<div  <? if ($thisMonth->get_raindiffav() > 0) echo "class=\"more number\">+"; else echo "class=\"less number\">"; echo round($thisMonth->get_raindiffav())."&nbsp;(".$thisMonth->get_rainperc()."%)";?>
			</div>
			
			<? } ?>
		</td>
		<td dir="ltr" title="<? echo $monthInWord." ".$year.": ".$thisMonth->get_rainydays()." <--> ".$NORMAL[$lang_idx].": ".$monthAverge->get_rainydays();?>" >
			<? if (!$error_db) {?>
			
			<div  <? if ($thisMonth->get_rainydaysdiffav() > 0) echo "class=\"more number\">+"; else echo "class=\"less number\">"; echo $thisMonth->get_rainydaysdiffav();?>
			</div>
			
			<? } ?>
		</td>
	</tr>
	</table>
	</td>
	</tr>
</table>

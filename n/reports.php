			
				<?
				$MINOFMAX = array("The minimum of Max Temp", "טמפרטורת המקסימום הכי נמוכה");
				$MAXOFMIN = array("The maximum of Min Temp", "טמפרטורת המינימום הכי גבוהה");
				$MINOFMIN = array("The minimum of Min Temp", "טמפרטורת המינימום הכי נמוכה");
				$MAXOFMAX = array("The maximum of Max Temp", "טמפרטורת המקסימום הכי גבוהה");
				$MAXHUM = array("The maximum of humidity", "הלחות הגבוהה ביותר");
				$MINHUM = array("The minimum of humidity", "הלחות הנמוכה ביותר");
				$MAXDEW = array("The maximum of dew point", "נקודת הטל הגבוהה ביותר");
				$MAXRAIN = array("The most rainy day", "היום הגשום ביותר");
				$MAXRAINMONTH = array("The most rainy month", "החודש הגשום ביותר");
				$MINRAINMONTH = array("The most dry month", "החודש השחון ביותר");
                                $MINTEMPMONTH = array("The most hot month", "החודש החם ביותר");
                                $MAXTEMPMONTH = array("The most cold month", "החודש הקר ביותר");
				$CTRL  = array("to choose multiple years or/and months use the ctrl key", "לבחירת כמה שנים או כמה חודשים יש להשתמש ב-מקש קונטרול  . אם לא תבחר שנה - יחושב עבור כל השנים. אם לא יבחר חודש - יחושב עבור כל החודשים");
				$current_year = 2012;
				$min_year = 1909;
				

				function isMonthSubmited($value_month){
					global $_POST;
					if (!isset($_POST['months']))
						$_POST['months'] = array();
					if (in_array($value_month, $_POST['months']))
							return true;
						return false;
				}
				function isYearSubmited($value_year){
					global $_POST;
					if (!isset($_POST['years']))
						$_POST['years'] = array();
					if (in_array($value_year, $_POST['years']))
						return true;
					
					return false;
				}

				
				?>
				<h1><?=$REPORTS[$lang_idx]?></h1>
				<form method="post" name="date" action="#archive">
				<div style="float:<?echo get_s_align();?>;width:60%">
				<div id="reportcontrols" class="inv_plain_3_min"  style="padding:1em;float:<?echo get_s_align();?>">
				
				<select name="months[]" size="12" multiple>
				<option value='01' <?if (isMonthSubmited("01")) echo "selected";?>><?=getMonthName(1)?></option>
				<option value='02' <?if (isMonthSubmited("02")) echo "selected";?>><?=getMonthName(2)?></option>
				<option value='03' <?if (isMonthSubmited("03")) echo "selected";?>><?=getMonthName(3)?></option>
				<option value='04' <?if (isMonthSubmited("04")) echo "selected";?>><?=getMonthName(4)?></option>
				<option value='05' <?if (isMonthSubmited("05")) echo "selected";?>><?=getMonthName(5)?></option>
				<option value='06' <?if (isMonthSubmited("06")) echo "selected";?>><?=getMonthName(6)?></option>
				<option value='07' <?if (isMonthSubmited("07")) echo "selected";?>><?=getMonthName(7)?></option>
				<option value='08' <?if (isMonthSubmited("08")) echo "selected";?>><?=getMonthName(8)?></option>
				<option value='09' <?if (isMonthSubmited("09")) echo "selected";?>><?=getMonthName(9)?></option>
				<option value='10' <?if (isMonthSubmited("10")) echo "selected";?>><?=getMonthName(10)?></option>
				<option value='11' <?if (isMonthSubmited("11")) echo "selected";?>><?=getMonthName(11)?></option>
				<option value='12' <?if (isMonthSubmited("12")) echo "selected";?>><?=getMonthName(12)?></option>
				</select>
				<select name="years[]" size="30" multiple>
				<?
				 for ($i_year = $current_year;$i_year >= $min_year ;$i_year--) 
				 {
					 echo  "<option value='".$i_year."' ";
					 if (isYearSubmited($i_year)) echo "selected";
					 echo ">".$i_year."</option>\n";
				 }
				?>
				</select>&nbsp;
				</div>
				<div style="float:<?echo get_s_align();?>;width:60%">
					<div class="inv_plain" style="width:200px;padding:1em;float:<?echo get_s_align();?>" >
					<?=$CTRL[$lang_idx]?>
					</div>
					
					<div class="inv_plain_3_min" style="clear:both;padding:1em;text-align:<?echo get_s_align();?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>> 
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="minofmax" name="report" <? if ((!isset($_POST['SendButton'])) || ($_POST['report'] == "minofmax")) echo "checked";?> /><?=$MINOFMAX[$lang_idx]?> (1964+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxofmax" name="report" <? if ($_POST['report'] == "maxofmax") echo "checked"; ?>/><?=$MAXOFMAX[$lang_idx]?> (1964+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxofmin" name="report" <? if ($_POST['report'] == "maxofmin") echo "checked"; ?>/><?=$MAXOFMIN[$lang_idx]?> (1964+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="minofmin" name="report" <? if ($_POST['report'] == "minofmin") echo "checked"; ?>/><?=$MINOFMIN[$lang_idx]?> (1964+)<br />
                                                <input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxtempmonth" name="report" <? if ($_POST['report'] == "maxtempmonth") echo "checked"; ?>/><?=$MAXTEMPMONTH[$lang_idx]?> (1964+)<br />
                                                <input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="mintempmonth" name="report" <? if ($_POST['report'] == "mintempmonth") echo "checked"; ?>/><?=$MINTEMPMONTH[$lang_idx]?> (1964+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxhum" name="report" <? if ($_POST['report'] == "maxhum") echo "checked"; ?>/><?=$MAXHUM[$lang_idx]?> (2002+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="minhum" name="report" <? if ($_POST['report'] == "minhum") echo "checked"; ?>/><?=$MINHUM[$lang_idx]?> (2002+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxdew" name="report" <? if ($_POST['report'] == "maxdew") echo "checked"; ?>/><?=$MAXDEW[$lang_idx]?> (2002+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxrain" name="report" <? if ($_POST['report'] == "maxrain") echo "checked"; ?>/><?=$MAXRAIN[$lang_idx]?> (1909+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxrainmonth" name="report" <? if ($_POST['report'] == "maxrainmonth") echo "checked"; ?>/><?=$MAXRAINMONTH[$lang_idx]?> (1909+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="minrainmonth" name="report" <? if ($_POST['report'] == "minrainmonth") echo "checked"; ?>/><?=$MINRAINMONTH[$lang_idx]?> (1909+)<br />
					</div>
					<div class="inv_plain_3_min" style="clear:both;padding:1em;width:auto" >
						<input type="submit" name="submit" value="<? echo $SHOW[$lang_idx];?>" style="width:150px;margin:0 3em 0 1em">
					</div>
					<div>
					<table>
						<tr class="topbase">
							<td>Source</td>
							<td>Year</td>
							<td>Date</td>
						</tr>
						<tr class="inv_plain_3_min">
							<td>my station</td>
							<td>2005+</td>
							<td>yyyy-mm-dd</td>
						</tr>
						<tr class="inv_plain_3">
							<td>Jerusalem centeral (Generali)</td>
							<td>1950-2004</td>
							<td>yyyy-mm-dd</td>
						</tr>
						<tr class="inv_plain_3_min">
							<td>Jerusalem - old city</td>
							<td>1948-1949</td>
							<td>yyyy-mm-dd</td>
						</tr>
						<tr class="inv_plain_3">
							<td>Jerusalem - Saint Anne</td>
							<td>1907-1948</td>
							<td>yyyy-mm-dd</td>
						</tr>
					</table>
					</div>
				</div>
				</form>
				</div>
				<div style="float:<?echo get_s_align();?>;width:35%">
				<?
				if (isset( $_POST['submit']))
				{
					getReport($min_year, $current_year, $_POST['report']);
				}
				?>

				</div>
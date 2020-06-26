                                <?
$current_year = 2020;
$tablestobeSearched = array();
$where_clause_archivemin = array();
$where_clause_archive = array();
 function pushTables($min_year,$current_year, $monthMode, $param)
 {
	global $tablestobeSearched;
	global $where_clause_archivemin; 
	global $where_clause_archive;
        global $tableToSearch;
        $params_in_my_station = array("Hum", "Dew");
        if (in_array($param, $params_in_my_station))
            $startingYearFromMyStation = 2002;
        else
            $startingYearFromMyStation = $current_year;
        
	if (count($_POST['years']) > 0){
		foreach ($_POST['years'] as $yearToSearch)
		{
			if (count($_POST['months']) > 0)
			{
				foreach ($_POST['months'] as $monthToSearch)
				{
					
					if ($tableToSearch != "archive")
					{
						array_push ($where_clause_archivemin, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) <0) ", $yearToSearch , $monthToSearch , getNextMonthYear($monthToSearch, $yearToSearch) , getNextMonth($monthToSearch)));
						if (!in_array("archivemin", $tablestobeSearched)) 
							array_push ($tablestobeSearched, "archivemin");
					}
					else 
					{
						array_push ($where_clause_archive, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) <0) ", $yearToSearch , $monthToSearch , getNextMonthYear($monthToSearch, $yearToSearch) , getNextMonth($monthToSearch)));
						if (!in_array("archive", $tablestobeSearched))
						 array_push ($tablestobeSearched, "archive");
					}
				}
			}
			else //no month selected
			{
				
				if ($tableToSearch != "archive")
				{
					if ($monthMode)
					{
						for ($monthToSearch = 1;$monthToSearch <= 12 ;$monthToSearch++) { 
							array_push ($where_clause_archivemin, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) <0) ", $yearToSearch , $monthToSearch , getNextMonthYear($monthToSearch, $yearToSearch) , getNextMonth($monthToSearch)));
						}
					}
					else
						array_push ($where_clause_archivemin, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-01-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-01-01' ) ) <0) ", $yearToSearch , $yearToSearch + 1));
					if (!in_array("archivemin", $tablestobeSearched))
						array_push ($tablestobeSearched, "archivemin");
				}
				else
				{
					if ($monthMode)
					{
						for ($monthToSearch = 1;$monthToSearch <= 12 ;$monthToSearch++) { 
							array_push ($where_clause_archive, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) <0) ", $yearToSearch , $monthToSearch , getNextMonthYear($monthToSearch, $yearToSearch) , getNextMonth($monthToSearch)));
						}
					}
					else
						array_push ($where_clause_archive, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-01-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-01-01' ) ) <0) ", $yearToSearch , $yearToSearch + 1));
					//if (!in_array("archive", $tablestobeSearched))
					//	 array_push ($tablestobeSearched, "archive");
					
				}
			}
		}
	}
	else // no year selected
        {
                if ((!in_array("archivemin", $tablestobeSearched))&&((!in_array($param, $params_in_my_station))))
                {
                        array_push ($tablestobeSearched, "archivemin");
                }
                if ((!in_array("archive", $tablestobeSearched))&&((in_array($param, $params_in_my_station))))
                      array_push ($tablestobeSearched, "archive");
                if (count($_POST['months']) > 0)
                 {
                    foreach ($_POST['months'] as $monthToSearch)
                    {
                            for ($yearToSearch = $min_year;$yearToSearch < $startingYearFromMyStation ;$yearToSearch++) { 
                                    array_push ($where_clause_archivemin, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) <0) ", $yearToSearch , $monthToSearch , getNextMonthYear($monthToSearch, $yearToSearch) , getNextMonth($monthToSearch)));
                            }

                             for ($yearToSearch = $startingYearFromMyStation ;$yearToSearch <= $current_year ;$yearToSearch++) {
                                    array_push ($where_clause_archive, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) <0) ", $yearToSearch , $monthToSearch , getNextMonthYear($monthToSearch, $yearToSearch) , getNextMonth($monthToSearch)));
                            }

                    }
                }
                else {// no year selected and no month selected
            
                    if ($monthMode)
			{
                            for ($monthToSearch = 1;$monthToSearch <= 12 ;$monthToSearch++) { 
                                for ($yearToSearch = $min_year;$yearToSearch < $startingYearFromMyStation ;$yearToSearch++) { 
                                               array_push ($where_clause_archivemin, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) <0) ", $yearToSearch , $monthToSearch , getNextMonthYear($monthToSearch, $yearToSearch) , getNextMonth($monthToSearch)));
                                 }

                               for ($yearToSearch = $startingYearFromMyStation ;$yearToSearch <= $current_year ;$yearToSearch++) {
                                      array_push ($where_clause_archive, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) <0) ", $yearToSearch , $monthToSearch , getNextMonthYear($monthToSearch, $yearToSearch) , getNextMonth($monthToSearch)));
                               }
                            }
                       }   
                    else {
                        for ($yearToSearch = $min_year;$yearToSearch < $startingYearFromMyStation ;$yearToSearch++) { 
                         array_push ($where_clause_archive, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-01-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-01-01' ) ) <0) ", $yearToSearch , $yearToSearch + 1));
                        }
                        for ($yearToSearch = $startingYearFromMyStation ;$yearToSearch <= $current_year ;$yearToSearch++) {
                         array_push ($where_clause_archive, sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-01-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-01-01' ) ) <0) ", $yearToSearch , $yearToSearch + 1));
                        }
                    }
                }
        }
	return $where_clause_archivemin;
		
} 

function getReport($min_year,$current_year, $report)
{
	global $tablestobeSearched;
	global $where_clause_archivemin; 
	global $where_clause_archive;
	$orderbydate = false;
	$monthMode = false;
	if ($report == "minofmax")
	{
		$maxOrMin = "MAX";
		$param = "HiTemp";
		$AscOrDesc = "ASC";
		$unit = "&#176;C";
	}
	else if ($report == "maxofmin")
	{
		$maxOrMin = "MIN";
		$param = "LowTemp";
		$AscOrDesc = "DESC";
		$unit = "&#176;C";
	}
	else if ($report == "minofmin")
	{
		$maxOrMin = "MIN";
		$param = "LowTemp";
		$AscOrDesc = "ASC";
		$unit = "&#176;C";
	}
	else if ($report == "maxofmax")
	{
		$maxOrMin = "MAX";
		$param = "HiTemp";
		$AscOrDesc = "DESC";
		$unit = "&#176;C";
	}
	else if ($report == "maxhum")
	{
		$maxOrMin = "MAX";
		$param = "Hum";
		$AscOrDesc = "DESC";
		$unit = "%";
                $tableToSearch="archive";
	}
	else if ($report == "minhum")
	{
		$maxOrMin = "MIN";
		$param = "Hum";
		$AscOrDesc = "ASC";
		$unit = "%";
                $tableToSearch="archive";
	}
	else if ($report == "maxdew")
	{
		$maxOrMin = "MAX";
		$param = "Dew";
		$AscOrDesc = "Desc";
		$unit = "&#176;C";
                $tableToSearch="archive";
	}
	else if ($report == "mindew")
	{
		$maxOrMin = "MIN";
		$param = "Dew";
		$AscOrDesc = "ASC";
		$unit = "&#176;C";
        $tableToSearch="archive";
	}
	else if ($report == "maxrain")
	{
		$maxOrMin = "SUM";
		$param = "Rain";
		$AscOrDesc = "Desc";
		$unit = "mm";
	}
	else if ($report == "firstrain")
	{
		$orderbydate = true;
		$maxOrMin = "";
		$param = "Rain";
		$AscOrDesc = "Asc";
		$unit = "mm";
	}
	else if ($report == "lastrain")
	{
		$orderbydate = true;
		$maxOrMin = "";
		$param = "Rain";
		$AscOrDesc = "Desc";
		$unit = "mm";
	}
	else if ($report == "maxrainmonth")
	{
			$monthMode = true;
			$maxOrMin = "SUM";
			$param = "Rain";
			$AscOrDesc = "Desc";
			$unit = "mm";
	}
	else if ($report == "minrainmonth")
	{
			$monthMode = true;
			$maxOrMin = "SUM";
			$param = "Rain";
			$AscOrDesc = "Asc";
			$unit = "mm";
	}
        /*
         * SELECT AVG( LowTemp+HiTemp)/2 AVGLowTemp , DATE_FORMAT(`Date`, '%Y-%m') month FROM `archivemin` where `LowTemp` IS NOT NULL AND ( ( DATEDIFF( `Date` , DATE( '2002-07-01' ) ) >=0 AND DATEDIFF( `Date` , DATE( '2002-08-01' ) ) <0) )
         */
        else if ($report == "maxtempmonth")
	{
			$monthMode = true;
			$complex = "(LowTemp+HiTemp)/2";
			$maxOrMin = "AVG";
			$param = "HiTemp";
			$AscOrDesc = "Asc";
			$unit = "&#176;C";
	}
        else if ($report == "mintempmonth")
	{
			$monthMode = true;
			$complex = "(LowTemp+HiTemp)/2";
			$maxOrMin = "AVG";
			$param = "LowTemp";
			$AscOrDesc = "Desc";
			$unit = "&#176;C";
	}

	pushTables($min_year,$current_year, $monthMode, $param);

	global $link;
	db_init("", "");
	if ($complex == "") 
            { $complex = $param;};
	if ($monthMode)
	{
			$query_total = "SELECT ".$maxOrMin.$param." ,  month FROM (";
		
		for ($i = 0;$tablestobeSearched[$i]!=null ;$i++) {
			$table = $tablestobeSearched[$i];
			
			if ($table == "archivemin")
			{
				
				for ($j = 0;$where_clause_archivemin[$j]!=null ;$j++) {
					$query_total .= " SELECT ".$maxOrMin."(  ".$complex." ) ".$maxOrMin.$param." ,  DATE_FORMAT(`Date`, '%Y-%m') month FROM  `".$table."` where `".$param."` IS NOT NULL  ";
					if ($param == "Rain")
						$query_total .= " and Rain > 0 ";
					if (trim($where_clause_archivemin[$j]) != ""){
                                            $query_total .= " AND ( ";
                                            $query_total .= $where_clause_archivemin[$j];
                                            $query_total .= " ) ";
                                        }
					if ($j < count($where_clause_archivemin) - 1)
						$query_total .= " UNION ALL ";
				}
				
			}
			else
			{	
				for ($j = 0;$where_clause_archive[$j]!=null ;$j++) {
					$query_total .= " SELECT ".$maxOrMin."(  ".$complex." ) ".$maxOrMin.$param." ,  DATE_FORMAT(`Date`, '%Y-%m') month FROM  `".$table."` where `".$param."` IS NOT NULL  ";
					if ($param == "Rain")
						$query_total .= " and Rain > 0 ";
					$query_total .= " AND ( ";
					$query_total .= $where_clause_archive[$j];
					$query_total .= " ) ";
					if ($j < count($where_clause_archive) - 1)
						$query_total .= " UNION ALL ";
				}
				
			}
			if ($i < count($tablestobeSearched) - 1)
				$query_total .= " UNION ALL ";
		}
		
		$query_total .= ") ar where month is not null ";
		if ($orderbydate)
		$query_total .= "  ORDER BY MONTH(Date),DAY(DATE) ".$AscOrDesc." LIMIT 0 , 30";
		else
		$query_total .= "  ORDER BY ".$maxOrMin.$param." ".$AscOrDesc." LIMIT 0 , 30";
	}
	else
	{
		$query_total = "SELECT ".$maxOrMin."(  ".$param." ) ,  `Date` FROM (";
		
		for ($i = 0;$tablestobeSearched[$i]!=null ;$i++) {
			$table = $tablestobeSearched[$i];
			//echo " <br/>".$table." <br/>";
			$query_total .= "SELECT  ".$param." ,  `Date` FROM  `".$table."` where ".$param." IS NOT NULL  ";
			if ($param == "Rain")
						$query_total .= " and Rain > 0 ";
			if ($table == "archivemin")
			{
                            if (count($where_clause_archivemin) > 0){
				$query_total .= " AND ( ";
				for ($j = 0;$where_clause_archivemin[$j]!=null ;$j++) {
					$query_total .= $where_clause_archivemin[$j];
					if ($j < count($where_clause_archivemin) - 1)
						$query_total .= " OR ";
				}
				$query_total .= " ) ";
                            }
			}
			else
			{
				$query_total .= " AND ( ";
				for ($j = 0;$where_clause_archive[$j]!=null ;$j++) {
					$query_total .= $where_clause_archive[$j];
					if ($j < count($where_clause_archive) - 1)
						$query_total .= " OR ";
				}
				$query_total .= " ) ";
			}
			if ($i < count($tablestobeSearched) - 1)
				$query_total .= " UNION ALL ";
		}
		
		$query_total .= ") ar ";
		if ($orderbydate)
		$query_total .= "  GROUP BY  YEAR(Date) order by MONTH(Date),DAY(DATE) ".$AscOrDesc." LIMIT 0 , 30";
		else
		$query_total .= "  GROUP BY  `Date` ORDER BY ".$maxOrMin."(  ".$param." ) ".$AscOrDesc." LIMIT 0 , 30";
		}
	//echo $query_total;
	
	$result = mysqli_query($link, $query_total);
	echo "<table align=\"center\">";
	echo "<tr class=\"base\"><td style=\"text-align:center\">".$unit."</td><td style=\"text-align:center\">yyyy-mm-dd</td></tr>";
	while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$lines++;
		$col = 0;
		print "\t<tr align=\"center\" class=\"base\">\n";
		foreach ($line as $col_value) {
			print "\t\t<td";
			if ($col < 2)
					print " class=\"topbase\"";
			print " title=\"\"";
			if ($col == 0)
				print ">".round($col_value, 1)."</td>\n";
			else
			{
				print " >";
				print "<form method=\"post\" action=\"".get_query_edited_url($url_cur, 'section', 'browsedate.php')."\">";
                                print "<input type=\"submit\" value=\"$col_value\" name=\"submitdate\" style=\"cursor:pointer;width:120px\" />";
                                if  (stristr($col_value, "/"))
                                {
                                      $current_date = explode('/', $col_value, 3);//dd/mm/yy
                                       $current_year = 2000 + $current_date[2];
                                       print "<input type=\"hidden\" name=\"browseyear\" 	value=\"$current_year\">";
				       print "<input type=\"hidden\" name=\"browsemonth\" 	value=\"$current_date[1]\">";
				       print "<input type=\"hidden\" name=\"browseday\" 	value=\"$current_date[0]\">";
                                }
                                else
                                      
                                
                                {
				   $current_date = explode('-', $col_value, 3);//yyyy-mm-dd
                                   print "<input type=\"hidden\" name=\"browseyear\" 	value=\"$current_date[0]\">";
				   print "<input type=\"hidden\" name=\"browsemonth\" 	value=\"$current_date[1]\">";
				   print "<input type=\"hidden\" name=\"browseday\" 	value=\"$current_date[2]\">";
                                }
                                
				

				print "</form>";
				print "</td>\n";
			}
			$col++;
		}
		print "\t</tr>\n";
	}
	echo "</table>";
	@mysqli_free_result($result);
        @mysqli_close($link);
}
                                ?>
				<?
				$MINOFMAX = array("The minimum of Max Temp", "טמפרטורת המקסימום הכי נמוכה");
				$MAXOFMIN = array("The maximum of Min Temp", "טמפרטורת המינימום הכי גבוהה");
				$MINOFMIN = array("The minimum of Min Temp", "טמפרטורת המינימום הכי נמוכה");
				$MAXOFMAX = array("The maximum of Max Temp", "טמפרטורת המקסימום הכי גבוהה");
				$MAXHUM = array("The maximum of humidity", "הלחות הגבוהה ביותר");
				$MINHUM = array("The minimum of humidity", "הלחות הנמוכה ביותר");
				$MAXDEW = array("The maximum of dew point", "נקודת הטל הגבוהה ביותר");
				$MINDEW = array("The maximum of dew point", "נקודת הטל הנמוכה ביותר");
				$MAXRAIN = array("The most rainy day", "היום הגשום ביותר");
				$LASTRAIN = array("The last rainy day", "היום הגשום המאוחר ביותר");
				$FIRSTRAIN = array("The first rainy day", "היום הגשום המוקדם ביותר");
				$MAXRAINMONTH = array("The most rainy month", "החודש הגשום ביותר");
				$MINRAINMONTH = array("The most dry month", "החודש השחון ביותר");
                                $MINTEMPMONTH = array("The most hot month", "החודש החם ביותר");
                                $MAXTEMPMONTH = array("The most cold month", "החודש הקר ביותר");
				$CTRL  = array("to choose multiple years or/and months use the ctrl key", "לבחירת כמה שנים או כמה חודשים יש להשתמש ב-מקש קונטרול  . אם לא תבחר שנה - יחושב עבור כל השנים. אם לא יבחר חודש - יחושב עבור כל החודשים");
				
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
				<div style="clear:both;float:<?echo get_s_align();?>;width:60%">
				<div id="reportcontrols" class="inv_plain_3"  style="padding:1em;float:<?echo get_s_align();?>;width:36%">
				<div class="float">
				<select name="years[]" size="30" multiple>
				<?
				 for ($i_year = $current_year;$i_year >= $min_year ;$i_year--) 
				 {
					 echo  "<option value='".$i_year."' ";
					 if (isYearSubmited($i_year)) echo "selected";
					 echo ">".$i_year."</option>\n";
				 }
				?>
				</select></div>
                                <div class="float">
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
                                </div>
                                <div class="inv_plain_3" style="width:90px;padding:1em;float:<?echo get_s_align();?>" >
					<?=$CTRL[$lang_idx]?>
				</div>
				</div>
				<div style="float:<?echo get_s_align();?>;width:59%">
									
					<div class="inv_plain_3" style="clear:both;padding:1em;text-align:<?echo get_s_align();?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>> 
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="minofmax" name="report" <? if ((!isset($_POST['SendButton'])) || ($_POST['report'] == "minofmax")) echo "checked";?> /><?=$MINOFMAX[$lang_idx]?> (1950+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxofmax" name="report" <? if ($_POST['report'] == "maxofmax") echo "checked"; ?>/><?=$MAXOFMAX[$lang_idx]?> (1950+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxofmin" name="report" <? if ($_POST['report'] == "maxofmin") echo "checked"; ?>/><?=$MAXOFMIN[$lang_idx]?> (1950+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="minofmin" name="report" <? if ($_POST['report'] == "minofmin") echo "checked"; ?>/><?=$MINOFMIN[$lang_idx]?> (1950+)<br />
                                                <input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxtempmonth" name="report" <? if ($_POST['report'] == "maxtempmonth") echo "checked"; ?>/><?=$MAXTEMPMONTH[$lang_idx]?> (1950+)<br />
                                                <input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="mintempmonth" name="report" <? if ($_POST['report'] == "mintempmonth") echo "checked"; ?>/><?=$MINTEMPMONTH[$lang_idx]?> (1950+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxhum" name="report" <? if ($_POST['report'] == "maxhum") echo "checked"; ?>/><?=$MAXHUM[$lang_idx]?> (2002+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="minhum" name="report" <? if ($_POST['report'] == "minhum") echo "checked"; ?>/><?=$MINHUM[$lang_idx]?> (2002+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxdew" name="report" <? if ($_POST['report'] == "maxdew") echo "checked"; ?>/><?=$MAXDEW[$lang_idx]?> (2002+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="mindew" name="report" <? if ($_POST['report'] == "mindew") echo "checked"; ?>/><?=$MINDEW[$lang_idx]?> (2002+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxrain" name="report" <? if ($_POST['report'] == "maxrain") echo "checked"; ?>/><?=$MAXRAIN[$lang_idx]?> (1909+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="firstrain" name="report" <? if ($_POST['report'] == "firstrain") echo "checked"; ?>/><?=$FIRSTRAIN[$lang_idx]?> (1909+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="lastrain" name="report" <? if ($_POST['report'] == "lastrain") echo "checked"; ?>/><?=$LASTRAIN[$lang_idx]?> (1909+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="maxrainmonth" name="report" <? if ($_POST['report'] == "maxrainmonth") echo "checked"; ?>/><?=$MAXRAINMONTH[$lang_idx]?> (1909+)<br />
						<input <? if (isHeb()) echo "dir=\"rtl\""; ?> type="radio" value="minrainmonth" name="report" <? if ($_POST['report'] == "minrainmonth") echo "checked"; ?>/><?=$MINRAINMONTH[$lang_idx]?> (1909+)<br />
					</div>
					<div class="inv_plain_3" style="clear:both;padding:1em;width:auto" >
						<input type="submit" name="submit" value="<? echo $SHOW[$lang_idx];?>" style="width:150px;margin:0 3em 0 1em">
					</div>
					<div>
					<table style="text-align:center;border-spacing:0.2em;border:1px #fff hashed">
						<tr class="topbase">
							<td>Source</td>
							<td>Year</td>
							<td>Date</td>
						</tr>
						<tr class="inv_plain_3">
							<td>my station</td>
							<td>2005+</td>
							<td>yyyy-mm-dd</td>
						</tr>
						<tr class="inv_plain_3">
							<td>Jerusalem centeral (Generali)</td>
							<td>1950-<?=$current_year?></td>
							<td>yyyy-mm-dd</td>
						</tr>
						<tr class="inv_plain_3">
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
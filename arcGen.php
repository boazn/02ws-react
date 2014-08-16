<?
include ("include.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE );
//error_reporting(E_ERROR | E_PARSE);
 $month=$_REQUEST['m'];
 $year=$_REQUEST['y'];
$sourcefile=sprintf("reports/%d%02d.txt", $year, $month) ;
define("ITEMS","37");
$arYear = $year;
$arMonth = $month;
$arc_tok = getTokFromFile($sourcefile);

$first_date = getNextWordWith($arc_tok, "/");
$counter = 1;
$current = $first_date;

while ($arc_tok)
{	
	if (($counter % ITEMS != 16)
		&&($counter % ITEMS != 20)
		&&($counter % ITEMS != 21)
		&&($counter % ITEMS != 22)
		&&($counter % ITEMS != 23)
		&&($counter % ITEMS != 24)
		&&($counter % ITEMS != 25)
		&&($counter % ITEMS != 30)
		&&($counter % ITEMS != 31)
		&&($counter % ITEMS != 32)
		&&($counter % ITEMS != 33)
		&&($counter % ITEMS != 34))// remove In dew & In Heat
	{
		if (($counter % ITEMS == 1)&&($counter != 1))
			echo ");<br/>";
		if (stristr($current, "/"))
			echo ("insert into `archive`  ( `Date` , `Time` , `Temp` , `HiTemp` , `LowTemp` , `Hum` , `Dew` , `WindSpd` , `WindDir` , `WindRun` , `HiSpeed` , `HiDir` , `WindChill` , `HeatIdx` , `THW` , `Bar` , `Rain` , `RainRate` , `HeatDD` , `CoolDD` , `InTemp` , `InHum` , `WindSamp` , `WindTx` , `ISSReception` ) VALUES (");

		// wrong data adjustment
		if ($first_date == $current)
			$current = ltrim(substr($current, 4));
		else if (stristr($current, "/"))
			$current = ltrim(substr($current, 3));
		
				
		echo "'".$current."'";
		if ($counter % ITEMS != 0)
			echo " ,";
	}	
		$current = getNextWord($arc_tok, 1);
		$counter = $counter + 1;
		//echo " ".$counter." ";
	
}
echo ");<br/>";
?>
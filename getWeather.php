<table>
<tr>
<td>
<form method="post">
	<input type="submit" name="submit" value="Show">
	Weather at<br>
	<SELECT NAME="locations[]" size="8" multiple>
	<? include "getWeather_list.php"?>  
	</SELECT> 
	 	
</form>
</td>
<td>

<?

$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : "getWeatherReport";
$locations = isset($_REQUEST['locations']) ? $_REQUEST['locations'] : "";

if (isset( $_POST['ICAOinput']))
{
	$locations = array($_POST['ICAOinput']);
}
//var_dump($locations);

require_once('nusoap/lib/nusoap.php');

if (isset($locations))
	foreach ($locations as $location){
		$client = new soapclient('http://live.capescience.com/wsdl/GlobalWeather.wsdl', true,'', '','', '');

		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		}

		$param = array($location);
		$result = $client->call($method, $param);
		// Check for a fault
		if ($client->fault) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		} else {
			// Check for errors
			$err = $client->getError();
			if ($err) {
				// Display the error
				echo '<h2>Error</h2><pre>' . $err . '</pre>';
			} else {
				// Display the result
				//echo '<h2>Result</h2><pre>';
				if (is_array($result)){
					extract_Weather($result);
				}
				else
				print_r($result);
				//echo '</pre>';
			}
		}
	}
//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
//echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>
</td>
</tr>
</table>

<?

require_once('../lib/nusoap.php');
$client = new soapclient('http://www.scottnichol.com/samples/hellowsdl2.php?wsdl', true,
						$proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
?>
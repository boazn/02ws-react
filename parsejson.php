<?
include ("ini.php");
$string = file_get_contents(JSON_FILE_PATH);
$json_a = json_decode($string, true);
echo ($json_a['jws']['yest']['morningtemp']);
echo ($json_a['jws']['yest']['noontemp']);
echo ($json_a['jws']['yest']['nighttemp']);
?>

<?php
ini_set("display_errors","On");
require('phpQuery.php');
$local_file_path = "/home/boazn/public/02ws.com/public/cache/airq.html";
$doc = phpQuery::newDocumentHTML(file_get_contents($local_file_path));
// 8 is the td of PM10
$bar_ilan = $doc["#C1WebGrid1 > tr:eq(2) > td:eq(8) > div"]->text();
$safra =  $doc["#C1WebGrid1 > tr:eq(5) > td:eq(8) > div"]->text();
$efrata =  $doc["#C1WebGrid1 > tr:eq(6) > td:eq(8) > div"]->text();
$even_ami = $doc["#C1WebGrid1 > tr:eq(7) > td:eq(8) > div"]->text();
$merkazit = $doc["#C1WebGrid1 > tr:eq(9) > td:eq(8) > div"]->text();
$stations = array($bar_ilan, $safra, $efrata, $even_ami);
print(array_sum($stations)/count($stations));
?>

<html>
<head>
<title> What is new</title>
</head>
<body background="images/clouds1.gif">
<table border=2><tr><td>
<?
$txtfile = file_get_contents("whatsnew.txt");
$patterns[0] = "/\t/";
$patterns[1] = "/\n/";
$patterns[2] = "/fox/";

$replacements[0] = "</td><td>";
$replacements[1] = "</tr><tr><td>";
$replacements[2] = "slow";

$txtfile = preg_replace($patterns, $replacements, $txtfile);

$ptag = "<span class=toptbl>$0</span>";
$tofind = "([0-3][0-9].[0-1][0-9].[1-2][0-9][0-9][0-9])";
$htmlfile  = preg_replace($tofind, $ptag, $txtfile);
echo $htmlfile;
?>
</td></tr>
</table>
</body>
</html>

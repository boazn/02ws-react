<?
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" lang="he">
<head>
	<title>אבישי הדסי</title>
	<meta name="description" content="אבישי הדסי" />
	<meta name="keywords" content="אבישי הדסי"/>
	<meta name="author" content="בועז נחמיה" />
	<link rel="Stylesheet" href="style.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
</head>
 <body>
<h1>Avishai Hadassi אבישי הדסי</h1>
<h4>1971 - 2007</h4>
<div style="width:60%;margin:0 auto">
<div class="divheader"><a href="spgm/index.php">לגלריה</a></div>
<div class="divheader"><a href="?p=album/index.php">לתמונות שלו</a></div>
<div class="divheader">ביוגרפיה</div>
<div class="divheader">דברים שכתב</div>
<div class="divheader"><a href="?p=Stories.php">סיפורים עליו</a></div>
<div class="divheader"><a href="?p=Recommendations.php">תעודות והמלצות</a></div>
<div class="divheader"><a href="?p=Books.php">ספרים שאהב</a></div>
<div class="divheader"><a href="?p=Music.php">מוזיקה שאהב</a></div>
<div class="divheader"><a href="?p=Movies.php">סרטים שאהב</a></div>
<div class="divheader">סרט לזכרו</div>
<div class="divheader"><a href="?p=eulogy.php">הספדים</a></div>
<div class="divheader"><a href="?p=TenYears.php">עשר שנים לזכרו</a></div>
<div class="divheader"><a href="?p=AviChai.php">בית אבי חי</a></div>
<div class="divheader"><a href="?p=SendEmailForm.php">להוסיף לאתר</a></div>
</div>
<div style="clear:both">
<?
if (isset($_GET['p']))
{
	include ($_GET['p']);
}
else
echo
"<img src=\"images/titlepic.jpg\" />";

?>
</div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-647172-1";
urchinTracker();
</script>
</body>
</html>
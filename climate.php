
<? 
$CLIMATE_DESC = array("Figure 1 shows the amount of sunshine received at 69 weather stations around the earth on the x-axis and the amount of precipitation in millimeters per year on the vertical axis. A vertical line at 3250 hours of annual sunshine and a horizontal line at 300 millimeters of annual rainfall divide the chart into quadrants. Notice that two stations in Jerusalem fall alone in the upper right-hand quadrant of this diagram with a large amount of sunshine and a moderate amount of rain occur. The only other station which approaches these ideal conditions is Flagstaff, Arizona, which is at a considerably higher, cooler elevation than Jerusalem. ", "לירושלים יש אקלים ייחודי שבו היא נהנית ממספר אדיר של שעות שמש, אבל עם לא מעט משקעים יחסית. בגרף שלמעלה אנחנו רואים את מיקומה של ירושלים יחסית ל67 ערים אחרות בעולם. נתונים אידיאלים שכאלה קיימים במעט מקומות בעולם. אזור אחד כזה הוא החלק הצפוני של אריזונה בארה''ב הגבוה מי-ם.	");
$CLIMATE_SUN = array("", "בואו נדבר על השמש הירושלמית.
היא יותר דומיננטית מגוש-דן וחיפה. למה?
1. יש 3470 שעות שמש בשנה. כ-170 שעות יותר מהמקומות המוזכרים, כלומר 18-19 יותר ימי שמש בשנה!
2. בגלל הגובה של העיר משתזפים-נשרפים מהר יותר מגוש-דן.
בטח לא מה שחשבתם.")
?>
<h1><?=$CLIMATE_TITLE[$lang_idx]?></h1>
<div class="inv_plain_3 float" style="padding:1em;width:90%">
<div class="inv_plain_3 float" style="padding:1em;width:30%">
<img src="images/imp-320small.gif" width="300" height="365" />
</div>
<div  class="inv_plain_3_zebra float" style="margin:2em;padding:2em;width:30%">
<?=$CLIMATE_DESC[$lang_idx]?>
</div>
<div class="inv_plain_3_zebra float" style="margin:2em;padding:2em;width:30%">
<?=$CLIMATE_SUN[$lang_idx]?>
</div>
<div class="inv_plain_3_zebra float">
source: <a href="http://www.icr.org/article/jerusalems-unique-climate/" rel="external">icr</a>
</div>
</div>
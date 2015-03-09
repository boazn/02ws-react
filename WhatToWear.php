<? header('Content-type: text/html; charset=utf-8');include_once("include.php"); include_once("start.php");?>
<!DOCTYPE html> 
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\""; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/main.php<?echo "?lang=".$lang_idx;?>" rel="stylesheet" type="text/css" /> 
<title><? echo $LOGO[$lang_idx];?></title>
<style>
   <?
if (stristr($_SERVER['HTTP_REFERER'], "small") ){
        ?>
   body{
       font-size:1.25em;
   }
<?}?>
    table tr td{
        padding:0.5em
    }
    table th td {
        font-weight: bold;
        font-size: 1.1em;
        text-align:center;
    }
</style>
</head>
<body <? if (isHeb()) echo "style=\"direction:rtl\""; ?>>

<h1 style="clear:both;direction: rtl; "> 	
איך מתמודדים עם הטמפרטורה הזאת?
</h1>
<?

if (stristr($_SERVER['HTTP_REFERER'], "small") ){
        ?>
    <div id="tohome" class="invfloat topbase"><a href="<? echo "small.php?lang=".$lang_idx;?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
	<? echo $HOME_PAGE[$lang_idx];?>
	</a>
</div>
    <?
    }
?>
<table  style="clear:both;direction: rtl; ">
<th >

<td class="inv_plain_2">
גברים
</td>
<td class="inv_plain_2">
נשים
</td>
</th>
<tr class="inv_plain_3_zebra">
    
        <td>
<a name="tshirt"></a>
<img align="absmiddle" src="images/icons/day/Hot.png" width="65px" height="65px" />
<img align="absmiddle" src="images/clothes/tshirt_n2.png" width="50px" height="50px" />
חום של טישירט<br />
חום של לבוש קצר<br />
חם מאוד<br />
חם בטירוף<br />

*למרות הסקאלה, כשחם אז חם. אין צורך ללבוש משהו עבה יותר ב"חום של טישרט".
</td>
        <td >
בדים: קלים ואווריריים.<br />
נעליים: סנדלים וכפכפים.<br />
בגדים קצרים ובדים לא קשיחים (חם נורא עם ג'ינס למשל).<br />
כובע, קרם הגנה ומשקפי שמש (גאונים בשמש).<br />
</td>
        <td>
בדים: קלים ואווריריים. <br />
נעליים: סנדלים וכפכפים.<br />
זו ה-עונה לחצאיות ולשמלות! (הערה: גם לסקוטים)<br />
כובע, קרם הגנה ומשקפי שמש (גאונים בשמש).<br />
</td>
</tr>
<tr class="inv_plain_3_zebra">
        <td>



<img align="absmiddle" src="images/icons/day/clear.png" width="65px" height="65px" />
קיץ בבית


</td>

        <td colspan="2">
בקירות: אין כמו לפתוח חלונות לרוח קרירה ירושלמית. אבל זכרו שבני האדם הם לא היחידים שנהנים להתקרר במבנים הירושלמים, ולכן אם אין רשת זה בעייתי.<br />
בחשמל: מזגנים ומאווררים.<br />
מים: מצרך קריטי לעונה (תקוו שהשתמשתם הרבה במטריה בסעיף למעלה). חשוב לשתות אותו רבות, אבל גם ספלאש לפנים ולשיער מקרר את כל הגוף.<br />
בשינה: תפסיקו לישון עם פוך בקיץ עם מזגן על 17 מעלות. זה מגוחך ופוגע בסביבה. תישנו עם סדין דק, זה אחלה.<br />

</td>
</tr>  
<tr class="inv_plain_3_zebra">
        <td>

<a name="longsleeves"></a>
<img align="absmiddle" src="images/clothes/longsleeves_n2.png" width="50px" height="50px"/>
לא חם ולא קר
	
</td>
        <td colspan="2">
בימים כאלו לרוב די נעים, אבל צריך לזכור שזה עדיין ירושלים ושלרוב קריר בבוקר ובערב.<br />
בדים: לא עבים ולא דקים מדי.<br />
נעליים: סגורות (סניקרס, בובה וכו') <br />
פלג גוף עליון: שכבה אחת נוספת לבוקר ולערב.<br />
</td>
</tr>
<tr class="inv_plain_3_zebra">
        <td>
<a name="coatrain"></a>
<img align="absmiddle" src="images/icons/day/rain.gif" width="65px" height="65px" />
<img align="absmiddle" src="images/clothes/coatrain_n2.png" width="50px" height="50px" />
גשם
	
</td>
        <td colspan="2">	
מעיל גשם, מטריה (עדיף לא מתקפלת בגלל הרוחות הכועסות של העיר), ונעליים עמידות בגשם.

</td>
</tr>
<tr class="inv_plain_3_zebra">
        <td>
<a name="coat"></a>
<img align="absmiddle" src="images/clothes/coat_n2.png" width="50px" height="50px" />
קור של שלג<br />
קור כלבים<br />
קור של מעיל<br />
*כמובן שהסקאלה באה לידי ביטוי בכמות השכבות, ואיכות החום שלהם.<br />
</td>
<td>	
בדים: עבים ומחממים.<br />
גרביים: מחממים. <br />
נעליים: גבוהות או סגורות הרמטיות.<br />
פלג גוף תחתון: מכנסיים לא מבד דק, תוספת גטקס בימים קשים.<br />
פלג גוף עליון: 2-3 שכבות (למשל חולצה ארוכה וסוודר. בימים קשים שני סוודרים). מעיל עבה מעל הכול, כי במקומות סגורים חם. <br />
תוספות מיוחדות: כובע צמר (הכי חשוב זה הראש!), צעיף וכמובן כפפות.<br />
</td>
<td>
בדים: עבים ומחממים.<br />
גרביים: איכות, כמות וגובה.<br />
נעליים: מגפיים, אלא מה.<br />
פלג גוף תחתון: שילוב שכבות (גרביונים דקים מתחת לכל שכבה).<br />
פלג גוף עליון: כדאי להרבות בשכבות (אבל לא להגזים כי אז פשוט מזיעים). בכל מקרה עדיף שכבה אחת עליונה מחממת מאוד, מכיוון שכשנכנסים למקום סגור אז חם. <br />
תוספות מיוחדות: כובע צמר (הכי חשוב זה הראש!), צעיף, מחממי אוזניים וכמובן כפפות.<br />
</td>
</tr>

<tr class="inv_plain_3_zebra">
<td>
    <img align="absmiddle" src="images/icons/day/TS2.gif" width="65px" height="65px" />
חורף בבית
</td>
        <td colspan="2">
בקירות: מוודאים שהחלונות סגורים, גם וילונות יעזרו. <br />
בחשמל: תנור נייד מחמם בקלות חדר שלם (תיזהרו מחסימת מקור החום, תנור ספירלות ותנורים קטנים. שריפה גם מחממת אבל זה לא הרעיון). <br />
הסקה: היא אמנם דבר נהדר אבל היא עולה משמעותית יותר כסף. <br />
מים: מקלחות חמות מונעות הצטננויות, ותה חם פותר הכול.<br />
בשינה: שמיכת פוך זה מאוד מומלץ, אבל גם שילוב של כמה שמיכות יכולות לשמור על אפקט החימום. עדיף להימנע מגריבת גרביים בשינה כדי לאוורר את כפות הרגליים, ובבוקר להיכנס לנעלי הבית.<br />
</td>
        
</tr>

<tr class="inv_plain_3_zebra">
<td>
<img align="absmiddle" src="images/icons/day/snowshow2.png" width="50px" height="50px" />
שלג

</td>
        <td colspan="2">	
הנעליים הכמעט יחידות ששורדות בשלג זה מגפי גומי. כל השאר ייחדרו. מאידך אפשר להישאר בבית בשלג. סתם. 
</td>
</tr>
    
    
</table>
כתבה: מיכל לופז
</body>
</html>
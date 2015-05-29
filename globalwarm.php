<h2>Global Warming for Jerusalem</h2> 
<h2>התחממות גלובלית עבור ירושלים</h2>
<center>
<table summary="" class="inv_plain_2" border="5">
<tr><td></td><td class="topinv_plain_2">Anomaly (<? echo $current->get_tempunit(); ?>) אנומליה</td></tr>

<?

	$result = db_init("SELECT * FROM globalwarming ORDER BY year ASC");
	while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		print "\t<tr align=\"center\">\n";
		if ($line['year'] !== $year)
			print "\t\t<td><a href=\"".$_SERVER['SCRIPT_NAME']."?section=reports/{$line['year']}.txt\">";
		else
			print "\t\t<td><a href=\"".$_SERVER['SCRIPT_NAME']."?section=".FILE_THIS_YEAR."\">";
		print $line['year'];
		print "</a></td>\n";
		print "<td>".$line['anomaly']."</td>";
		print "\t</tr>\n";
	}
	
	print "\t<tr><td class=topinv_plain_2>$AVERAGE[$lang_idx]</td>\n";
	
	$query = "SELECT avg(anomaly) FROM globalwarming";
	$result = mysqli_query($link, $query) or die("Query failed");
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = $row['avg(anomaly)'];
	//$num = number_format($row['avg(anomaly)'], 1, '.', '');
	print "<td class=topbase>$num</td>\n";
	print "\t</tr>\n";
	/* Free resultset */
	mysqli_free_result($result);

	/* Closing connection */
	mysqli_close($link);

	
?>
Source: My Station 
</table>
</center>
 <? if (isHeb()) { ?>
	<div id="exp" class="inv_plain_2 container"  style="padding:1em;direction:rtl;text-align:right">התחממות גלובלית מתבטאת בקיצוניות. למשל, בכמות ימי גשם מועטה, אבל עם כמות גשם נכבדת. אין עדיין אינדיקציה שזה מה שבאמת קורה. פרטים בהמשך הדף.<br />
	עדיין לא ברור אם ההתחממות המתרחשת היא חלק ממחזוריות כדור הארץ על פני ההיסטוריה או מעשה ידי אדם.<br />
	הטבלה הנ"ל עושה ממוצע של הסטיות מהממוצע (אנומליה) עבור הטמפרטורה הנמדדת על פני היממה.</div>
	<div class="inv_plain_3_zebra container" style="padding:1em;direction:rtl;text-align:right">
<div class="big">		ההשפעות העיקריות של תופעת ההתחממות הגלובלית על ישראל:</div>
מזג אוויר קיצוני – בשנים האחרונות אנו עדים לאירועים אקלימיים חריגים שאירעו בישראל, ביניהם:<br/>
אין לקשור כל אירוע להתחממות הגלובלית, מאחר והיו בעבר אירועים קיצוניים<br/>
2013 - אחרי שלג קיצוני בדצמבר -  חודשי חורף יבשים באופן חסר-תקדים<br/>
2010 - שנה חמה מאד<br/>
2006-2002 - ההסתברות לימים חמים מאוד בירושלים (מעל 35 מעלות) עלתה פי שלושה<br/>
2006-2004 - חודש מרץ היה יבש מאוד, עד כדי 10% מהממוצע הרב-שנתי.<br/>
2000 - השלג הכבד ביותר שירד בנגב<br/>
2000 - חודש יולי החם ביותר (בירושלים נרשמו עד 41 מעלות).<br/>
1998 - הקיץ החם ביותר שנמדד בישראל<br/>
מחקרים מראים שעלייה של 30 ס"מ בפני הים התיכון תגרום להצפה של 60 מטר באזורי מישורהחוף.<br/>
<em>עלייה של פני הים –</em><br/>
צמצום המשקעים והגידול באידוי שנגרמים בשל ההתחממות הגלובלית עלולים לגרום להידלדלות של<br/>
. כ 25%- ממאגרי המים ולצמצם את היצע המים ב 60%- עד לשנת 2100<br/>
<em>התייבשות מקורות מים –</em><br/>
צמצום המשקעים, עליית פני הים והגידול באידוי יביאו להמלחה ניכרת ולפגיעה באיכות המים<br/>
המתוקים באקוויפר החוף וההר.<br/>
<em>פגיעה באיכות המים –</em><br/>
ישראל מהווה תפר בין אקלים ים-תיכוני לבין קלים מדברי שבו כמות המשקעים יורדת מ 300- מ"מ<br/>
לשנה ורמת האידוי גבוהה. כל התחממות קלה בטמפרטורות עלולה להרחיב את קו-המדבור<br/>
ולהעלות את הנגב צפונה.<br/>
<em>מדבור ופגיעה בחקלאות –</em><br/>
בעלי חיים משמשים אינדיקציה לשינויי אקלים, מאחר והם ממחישים את הפגיעה שיש למזג האוויר<br/>
על מרחב המחיה שלהם. מחקרים מצאו כי עלייה של 1.5 מעלות בטמפרטורה של אגן הים התיכון<br/>
תגרום לנדידה של בעלי חיים ולשינוי מרחבי המחייה שלהם בטווחים של 300 עד 500 ק"מ צפונה<br/>
ו- 300 עד 600 מטר בגובה.<br/>
	</div>

	<div class="inv_plain_2 container" style="padding:1em;direction:rtl;text-align:right">
<div class="big" >		השינוי מתחיל בך!</div>
כל אדם 'תורם' לפליטה של כ- 10 טון פחמן דו-חמצני בשנה<br/>
רוצה לעשות משהו כדי לעזור בעצירת תהליך ההתחממות הגלובלי?<br/>
10 פעולות פשוטות – שכל אחד יכול לעשות!<br/>
<em>החליפו את אמצעי התאורה</em><br/>
הפעולה הפשוטה של החלפת נורת להט אחת רגילה בבית או במשרד בנורת פלורוסנט,<br/>
תפחית 70 ק"ג פחמן דו-חמצני בשנה.<br/>
<em>שומרים על תקינות הרכב ונהיגה נכונה</em><br/>
הקפדה על תחזוקה נכונה ולחץ אוויר תקין בצמיגים, יביאו לשיפור צריכת הדלק של רכבך ב 3%- . האצות מיותרות<br/>
והזנקת הרכב במהירות ממצב עצירה, מגבירים את כמות המזהמים הנפלטים ועלולים להביא להכפלת תצרוכת<br/>
הדלק. נהגו במהירות קבועה. כל ליטר בנזין שנחסך, מונע פליטה של 2.5 ק"ג פחמן דו-חמצני לאטמוספירה.<br/>
<em>נוהגים פחות</em><br/>
על ידי צמצום הנסיעה ברכב הפרטי - הליכה, רכיבה באופניים, תיאום הסעות עם שכנים וחברים ונסיעה בתחבורה<br/>
ציבורית, ניתן לחסוך כ 0.3- ק"ג פחמן דו-חמצני לכל 1 ק"מ!<br/>
<em>משתמשים בפחות מים חמים</em><br/>
חימום המים צורך אנרגיה רבה. כל שעה של הפעלת דוד חשמלי מביאה לפליטה של 2 ק"ג פחמן דו-חמצני. התקנה<br/>
של "חסכמים" תפחית 160 ק"ג פחמן דו-חמצני בשנה. ייעול מערכת המים שלך על ידי התקנת "סלמנדר", תפחית<br/>
460 ק"ג פחמן דו-חמצני בשנה. כביסה במים פושרים או קרים תפחית 230 ק"ג פחמן דו-חמצני בשנה.<br/>
<em>ממחזרים יותר</em><br/>
מיחזור של מחצית מכמות הפסולת שלך תביא להפחתה של 1 טון פחמן דו-חמצני בשנה!<br/>
מצמצמים שימוש במוצרים בעלי אריזות רבות<br/>
הפחתה של 10% בלבד מכמות השקיות והעטיפות תפחית כחצי טון פחמן דו-חמצני בשנה.<br/>
<em>מכוונים את התרמוסטט במזגן</em><br/>
החלפת מזגן ישן שנרכש לפני 10 שנים ויותר במזגן חדש, תפחית 400 ק"ג פחמן דו-חמצני בשנה.<br/>
כיוון התרמוסטט: שינוי של 2 מעלות בחורף ו 2- מעלות בקיץ יחסוך כ 1- פחמן דו-חמצני בשנה.<br/>
<em>חוסכים באנרגיה בבית</em><br/>
נגנים, מערכות שמע ומחשבים, יביא לחיסכון של ,DVD , כיבוי מכשירי חשמל שאינם בשימוש – טלוויזיה<br/>
אלפי טון של פחמן דו-חמצני בשנה.<br/>
כל הפעלה של מייבש כביסה פולטת 3 ק"ג פחמן דו-חמצני: נצלו את האנרגיה הטבעית של השמש - ייבשו כביסה<br/>
על חבל. כל הפעלה של המדיח גורמת לפליטה של 2 ק"ג פחמן דו-חמצני: הפעילו את המדיח רק כשהוא מלא.<br/>
<em>נוטעים עץ</em><br/>
נטיעת עצים חשובה ומסייעת במניעת ההתחממות הגלובלית, עץ בודד סופח 1 טון פחמן דו-חמצני במשך כל חייו!<br/>
	</div>
	<div class="spacer">&nbsp;</div>

	
	<div class="inv_plain_3_zebra container" style="padding:1em;direction:rtl;text-align:right">
	<img src="images/yearly_temp.jpg" alt="טמפרטורה שנתית בירושלים על פני ההיסטוריה" /><br/>
	טמפרטורה שנתית בירושלים על פני ההיסטוריה
	<br/>
	גם לאחר הוספת התצפיות החמימות יחסית מהשנים האחרונות, מגמת השתנות הטמפרטורה בירושלים
אינה מובהקת לחלוטין - רק 2.7% מהוריבליות של פיזור הנקודות בגרף מוסברת ע"י חלוף הזמן.
המשמעות היא שיש סיכוי טוב שהקשר בין הטמפ' לחלוף הזמן הוא אקראי והפיך.
	</div>
	<div class="spacer">&nbsp;</div>

	
	<div class="inv_plain_2 container" style="padding:1em;direction:rtl;text-align:right">
	<img src="images/march_rain.jpg" alt="גשמי חודש מרץ על פני ההיסטוריה" /><br/>
	גשמי חודש מרץ על פני ההיסטוריה
	<br/>
	בין 2004 ל 2006 - היו אומנם שלושה חודשי מרץ
יבשים ברציפות ובצפון הארץ הסתיימו כבר 5 חודשי מרץ
45
רצופים יבשים מהממוצע. זהו אכן אירוע די חריג, אבל האם חסר תקדים? מתברר שרחוק מכך
בין מרץ 1923 ל 1937- אירעו 15 חודשי מרץ יבשים מהממוצע ברצף! לא בחבל מסוים אלא ברוב המוחלט של התחנות בארץ ובתחנות מסוימות רצף זה אף החל עוד 3 שנים קודם ונמשך כ 18 - שנים ברציפות</div>
<div class="spacer">&nbsp;</div>
<div class="inv_plain_3_zebra container" style="padding:1em;direction:rtl;text-align:right">
	<table>
		<tr>
			<td></td>
			<td>שכיחות ימים <br>גשומים מ 50- מ"מ</td>
			<td>שכיחות ימים <br>גשומים מ 100- מ"מ</td>
			<td>כמות משקעים שנתית ממוצעת</td>
		</tr>
		<tr class="inv_plain_3_minus">
			<td>סנט אן<br> 1909/9-1947/8 </td>
			<td align="center">58</td>
			<td align="center">5</td>
			<td align="center">507</td>
		</tr>
		<tr class="inv_plain_3">
			<td>ירושלים מרכז <br> 1968/9-2007</td>
			<td align="center">61</td>
			<td align="center">2</td>
			<td align="center">551</td>
		</tr>
	</table>
	השוואה זו
מלמדת כי על אף שהעשורים האחרונים גשומים יותר מהעשורים בראשית המאה 20 - שכיחות ימי הגשם הכבדים
לא השתנתה מהותית
</div>
<div class="spacer">&nbsp;</div>
<div class="container">
	<a href="<? echo get_query_edited_url(get_url(), 'section', 'RainSeasons.php');?>">150 <? echo $RAIN_SEASONS[$lang_idx]; ?></a>
</div>
<div>
	קרדיט: נועם חלפון
	<a href="http://ims.huji.ac.il/Meterologia_BeIsrael_08-08.pdf">http://ims.huji.ac.il/Meterologia_BeIsrael_08-08.pdf</a>

</div>
	<? } else { ?>
	<div id="expEng" class="inv_plain_2" <? echo get_align(); ?> >
		Global warming can be expressed by small amount of raint days with the same amount of rain. 
	</div>
<? } ?>





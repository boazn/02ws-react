<?
$ABOUT_ME = array("I have built this site from my own interest in weather and in nature. I wanted to deliver accurate on-line weather data to the net and to display the data in a more convenient way that I have at home. I have worked as a weather forecaster in the past and loved it, nowdays I work in the computer industry. The station is accurate and can be bought from the US ($500).", "ענן שגדל אל מול העניים  לעמוד ענקי של שלושה קילומטרים . הפלא  שנקרא גשם ,שלצערי לא נראה במחוזותינו יותר מדי. והשלג המופלא, הקצפת שבכל הסיפור. אלה  תמיד  ריתקו אותי - מאז שאני זוכר את עצמי  (שזה  די הרבה זמן). את האתר הקמתי ביולי-2002  מתוך רצון לשתף מידע ולהציג אותו בצורה אינטואיטיבית מצד אחד ומעמיקה מצד שני.<br /> השורשים נטעו בילדות והבשילו לתואר במדעי האטמוספירה. <br />  עבדתי בעברי כחזאי בשירות המטאורולוגי. כיום אני מחלק את זמני בין האתר לעיסוק השני שלי. <br /> תמונות של התחנה אפשר למצוא באלבום. את התחנה אפשר לרכוש באינטרנט  ב-500 דולר . הנתונים מועברים ישירות מהתחנה והתחזית מיוצרת על-ידי תוך שימוש באנליזה של מפות סינופטיות המיוצרות על-ידי מודלים נומריים.");

?>
        <h1><? echo $CONTACT_INFO[$lang_idx];?></h1>
		<table <? if (isHeb()) echo "dir=\"rtl\""; ?>>
		<tr>
			<td width="55%" style="padding:1em" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
		        <div class="inv_plain_3_zebra float" style="padding:1em">
				<? echo $ABOUT_ME[$lang_idx];?>
				</div>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/0kjAhi4tAfU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<iframe width="560" height="315" src="https://www.youtube.com/embed/nDJAuCwoKOs" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<div class="inv_plain_3_zebra float" style="padding:1em;width:80%">
			    <div class="float" style="width:50%">
			    <em>Email: <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=SendEmailForm&amp;lang=<?=$lang_idx?>" ><?echo $CONTACT_ME[$lang_idx];?></a></em><br/>
				
				<? if ($lang_idx == $EN) {?><em>Nayot, Jerusalem , Israel</em><?} ?>  <? if ($lang_idx == $HEB) {?><em>ניות, ירושלים, ישראל</em><?} ?>
			    <br/>
				<a href="cv-compro.doc">my CV</a>
				</div>
				<div class="float" style="width:50%">
				<a href="http://www.nrg.co.il/online/1/ART2/048/868.html" target="_blank"><? if ($lang_idx == $EN) {?><?} else {?> מן העתונות<?}?></a><?=get_arrow()?><br />
				<a href="http://www.haaretz.co.il/news/weather/1.1642873" target="_blank"><? if ($lang_idx == $EN) {?><?} else {?>מן העתונות 2<?}?></a><?=get_arrow()?><br />
                                <a href="http://issuu.com/pi-haaton/docs/186issuu" target="_blank"><? if ($lang_idx == $EN) {?><?} else {?>מן העתונות 3<?}?></a><?=get_arrow()?><br />
                                <a href="http://www.nrg.co.il/online/55/ART2/663/767.html?hp=55&cat=323&loc=7" target="_blank"><? if ($lang_idx == $EN) {?><?} else {?>מן העתונות 4<?}?></a><?=get_arrow()?><br />
                                <a href="<? echo get_query_edited_url($url_cur, 'section', 'faq');?>"  title="<?=$FAQ[$lang_idx]?>"><? echo $FAQ[$lang_idx];?></a><?=get_arrow()?>
				</div>
			</td>
			<td width="24%" valign="top" style="padding:1em">
				<img src="images/BoazMika.jpg" />
				<br/>
				<? if ($lang_idx == $EN) {?>Boaz Nechemia and the heiress<?} else {?> בועז נחמיה והיורשת<?}?>
				<br/><br/>
				<img src="images/BoazEyal.jpg" />
				<br/>
				<? if ($lang_idx == $EN) {?>another heiress<?} else {?> ועוד יורש<?}?>
				
			</td>
			<td <? if (isHeb()) echo "dir=\"rtl\""; ?> valign="top" style="padding:1em">
				<img src="images/james.jpg" width="180px" height="120px">
				<br/>
				<span><? if ($lang_idx == $HEB) {?> וזה שגורם לניתוקים באתר, אבל הוא מת, ...<?} else {?> and the one that acount for the dissconections of the site, but he is dead<?}?></span>
				<br/>
                                <img src="images/venice.jpg" width="180px" height="120px">
				<br/>
				<span><? if ($lang_idx == $HEB) {?> וכלבת ירושמיים שאחראית לתמונות בשעות מוזרות...<?} else {?> and the one that acount for the pictures taken in odd hours <?}?></span>
				<br/>
                                <br/>
				<a href="spgm-1.3.2/index.php?spgmGal=GivaatCanada&spgmFilters=t" title="pictures תמונות" class="box">
				<img src="https://www.02ws.co.il/images/rain_gauge_1.jpg" alt="rain_gauge" /><img src="https://www.02ws.co.il/images/mountain_station.jpg" alt="mountain station"/><img src="https://www.02ws.co.il/images/station_snow.jpg" alt="rain_gauge_snow"/>
				</a>
				<br/>
				<a href="spgm-1.3.2/index.php?spgmGal=GivaatCanada&spgmFilters=t" title="pictures תמונות" class="box">
				<? if ($lang_idx == $EN) {?>and the station<?} else {?>
				והתחנה בכבודה ועצמה:<br/>
				תחנה אלחוטית על הגג עם סנסורים של: 
טמפרטורה, לחות, קרינה , יו וי, גשם ומאוורר שמערבל את האוויר.
תחנת הר, תחנת עמק ותחנת כביש.
מחשב ששואב את הנתונים ממקום האכסון ומשדר אותם לאתר כל דקה.


				<?}?>
				</a>
			</td>
		</tr>
		</table>
		<hr/>
		<h2><? echo $LOCATION[$lang_idx];?></h2>
		<a href="images/Nayot.jpg"  title="<? echo $LOCATION[$lang_idx];?>" class="colorbox">
		    <span></span>
                    <img src="images/Nayot.jpg" width="500px"/>
		</a>
		
		<hr/>
		
		<p>
		על גבי הכדור הייתי פחות או יותר במקומות המסומנים<br/>
                <div style="width:1024px; position: relative;float:<?=get_s_align();?>">
					<iframe src="https://www.mytravelmap.xyz/u/gg115726297130259560708?5" scrolling="auto" id="iframemain" class="base" allowtransparency="true" marginHeight="0" marginWidth="0" width="1024" height="1600" frameborder="0" ></iframe> 
                </div>
		
		</p>
		



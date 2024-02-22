import Btn from './Button';
import decodeUriComponent from 'decode-uri-component';
const About = (props) => {
    const customStyles = {
          margin:'0 auto',
          width:'80%',
          textAlign:'center',
          direction:'rtl'
        
      };
    return (
        <div id="container" style={customStyles}>

                 <h1>אודות</h1>
                
                        <div className="white_box float">
                        ענן שגדל אל מול העניים  לעמוד ענקי של שלושה קילומטרים . הפלא  שנקרא גשם ,שלצערי לא נראה במחוזותינו יותר מדי. והשלג המופלא, הקצפת שבכל הסיפור. אלה  תמיד  ריתקו אותי - מאז שאני זוכר את עצמי  (שזה  די הרבה זמן). את האתר הקמתי ביולי-2002  מתוך רצון לשתף מידע ולהציג אותו בצורה אינטואיטיבית מצד אחד ומעמיקה מצד שני.<br/> השורשים נטעו בילדות והבשילו לתואר במדעי האטמוספירה. <br/>  עבדתי בעברי כחזאי בשירות המטאורולוגי. כיום אני מחלק את זמני בין האתר לעיסוק השני שלי. <br/> תמונות של התחנה אפשר למצוא באלבום. את התחנה אפשר לרכוש באינטרנט  ב-500 דולר . הנתונים מועברים ישירות מהתחנה והתחזית מיוצרת על-ידי תוך שימוש באנליזה של מפות סינופטיות המיוצרות על-ידי מודלים נומריים.			
                        </div>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/0kjAhi4tAfU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/nDJAuCwoKOs" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                        <div className="white_box float" >
                        <div className=" white_box float">
                        <em>Email: <a href="/station.php?section=SendEmailForm&amp;lang=1">צרו קשר</a></em><br/>
                        
                        <em>ניות, ירושלים, ישראל</em>			    <br/>
                        <a href="cv-compro.doc">my CV</a>
                        </div>
                        <div className="white_box float">
                        <a href="http://www.nrg.co.il/online/1/ART2/048/868.html" target="_blank"> מן העתונות</a><span className="big">&nbsp;››</span><br/>
                        <a href="http://www.haaretz.co.il/news/weather/1.1642873" target="_blank">מן העתונות 2</a><span className="big">&nbsp;››</span><br/>
                                        <a href="http://issuu.com/pi-haaton/docs/186issuu" target="_blank">מן העתונות 3</a><span className="big">&nbsp;››</span><br/>
                                        <a href="http://www.nrg.co.il/online/55/ART2/663/767.html?hp=55&amp;cat=323&amp;loc=7" target="_blank">מן העתונות 4</a><span className="big">&nbsp;››</span><br/>
                                        <a href="?section=faq&amp;lang=1" title="שאלות ותשובות">שאלות ותשובות</a><span className="big">&nbsp;››</span>				</div>
                    </div>
                    
                        <img src="https://www.02ws.co.il/images/BoazMika.jpg"  width="200" alt=""/>
                        <br/>
                        בועז נחמיה והיורשת				<br/><br/>
                        <img src="https://www.02ws.co.il/images/BoazEyal.jpg" width="200" alt=""/>
                        <br/>
                        ועוד יורש				
                        <br/><br/>
                        <img src="https://www.02ws.co.il/images/james.jpg" width="200" alt=""/>
                        <br/>
                        <span> וזה שגורם לניתוקים באתר, אבל הוא מת, ...</span>
                        <br/><br/>
                                        <img src="https://www.02ws.co.il/images/venice.jpg" width="200" alt=""/>
                        <br/>
                        <span> וכלבת ירושמיים שאחראית לתמונות בשעות מוזרות...</span>
                        <br/><br/>
                                        <br/>
                        <a href="https://www.02ws.co.il/spgm-1.3.2/index.php?spgmGal=GivaatCanada&amp;spgmFilters=t" title="pictures תמונות" className="box">
                        <img src="https://www.02ws.co.il/images/rain_gauge_1.jpg" alt="rain_gauge" width="200"/>
                        <img src="https://www.02ws.co.il/images/mountain_station.jpg" alt="mountain station" width="200" />
                        <img src="https://www.02ws.co.il/images/station_snow.jpg" alt="rain_gauge_snow" width="200" />
                        </a>
                        <br/>
                        <div className="white_box float">
                        <a href="https://www.02ws.co.il/spgm-1.3.2/index.php?spgmGal=GivaatCanada&amp;spgmFilters=t" title="pictures תמונות" className="box">
                                        והתחנה בכבודה ועצמה:<br/>
                        תחנה אלחוטית על הגג עם סנסורים של: 
        טמפרטורה, לחות, קרינה , יו וי, גשם ומאוורר שמערבל את האוויר.
        תחנת הר, תחנת עמק ותחנת כביש.
        מחשב ששואב את הנתונים ממקום האכסון ומשדר אותם לאתר כל דקה.


                                        </a>
                        </div>
                <h2>מיקום</h2>
                <a href="images/Nayot.jpg" title="מיקום" className="colorbox cboxElement">
                    <span></span>
                            <img src="https://www.02ws.co.il/images/Nayot.jpg" width="500px" />
                </a>
                
                
                <p>
                על גבי הכדור הייתי פחות או יותר במקומות המסומנים<br/>
                        </p><div >
                            <iframe src="https://www.mytravelmap.xyz/u/gg115726297130259560708?5" scrolling="auto" id="iframemain" className="base" allowtransparency="true" marginheight="0" marginwidth="0" width="1024" height="1600" frameborder="0"></iframe> 
                        </div>
                
        </div>

		
		



        
    );
}

export default About; 
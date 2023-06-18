import Button from 'react-bootstrap/Button';

const ForecastDay = (props) => {
    return (
        <ul className={"white_box box_text " + (props.lang === 1? 'rtl' : '')}>
        <li class="forcast_off_day">
            <Button className="btn-link" onclick="toggle('yesterday_line');">
                <img src="images/yesterday.png" width="14" height="14" title="יום אחרון" alt="" />
            </Button>
            </li>
            <li class="forcast_day">{props.day_name1}</li>
            <li class="forcast_date">{props.date}</li>
            <li class="expand_plus">
            <div id="0" class="open-close-button" index="0"></div>
            </li>
            <li class="forcast_morning">
                <div class="line">
                    <div class="number">
                        {props.TempLow}</div><div class="cloth extra0"> 
                        <a href="WhatToWear.php#jacket" rel="external" class="info cboxElement">
                            <span class="info">ג'קט או פליז, שתי שכבות מתחת וגם גרביונים</span>
                            <img style={{'vertical-align': 'middle'}} src={`https://www.02ws.co.il/${props.TempLowCloth}`} width="35" height="30" title="ג'קט או פליז, שתי שכבות מתחת וגם גרביונים" alt="ג'קט או פליז, שתי שכבות מתחת וגם גרביונים" />
                        </a>
                    </div>
                </div>
                
                <div class="icon extra0" id="morning_icon0">
                    <img src={`https://www.02ws.co.il/${props.morning_icon}`} width="28" height="28" alt="https://www.02ws.co.il/images/icons/day/n4_cloud_5_sun_3.svg" />
                </div>
                <div class="icon extra0">
                    <div class="wind_icon light_wind" title="רוח קלה - מרענן בשמש, מקרר בצל ובלילה">
                    </div>
                </div>
            </li>
            <li class="forcast_noon">
                <div class="line">
                    <div class="number">
                    {props.TempHigh}</div><div class="cloth extra0">
                        <a href="WhatToWear.php#tshirt" rel="external" class="info cboxElement">
                            <span class="info">טישרט</span>
                            <img style={{'vertical-align': 'middle'}} src={`https://www.02ws.co.il/${props.TempHighCloth}`} width="35" height="30" title="טישרט" alt="טישרט" />
                        </a>
                    </div>
                </div>
                
                <div class="icon extra0" id="day_icon0"><img src={`https://www.02ws.co.il/${props.icon}`} width="28" height="28" alt="images/icons/day/n4_cloud_5_sun_3.svg" /></div>                                       
                <div class="icon extra0"><div class="wind_icon moderate_wind" title="רוח ערה - מורגש, יכול להפריע במצבים מסוימים, אבל העורבים לא עוזבים את צמרות העצים"></div><div></div></div>
            </li>
            <li class="forcast_night">
                <div class="line">
                    <div class="number">
                    {props.TempNight}</div><div class="cloth extra0">
                        <a href="WhatToWear.php#jacket" rel="external" class="info cboxElement">
                            <span class="info">ג'קט או פליז, שכבה אחת מתחת</span>
                            <img style={{'vertical-align': 'middle'}} src={`https://www.02ws.co.il/${props.TempNightCloth}`} width="35" height="30" title="ג'קט או פליז, שכבה אחת מתחת" alt="ג'קט או פליז, שכבה אחת מתחת" />
                        </a>
                    </div>
                </div>  
                
                <div class="icon extra0" id="night_icon0"><img src={`https://www.02ws.co.il/${props.night_icon}`} width="28" height="28" alt="https://www.02ws.co.il/images/icons/day/n4_moon.svg" /></div>
                <div class="icon extra0"><div class="wind_icon light_wind" title="רוח קלה - מרענן בשמש, מקרר בצל ובלילה"></div><div></div></div>
            </li>
            <li class="icon_day"><div class="spriteB up" title="במגמת עליה"></div>                      
              <a href="legend.php" rel="external" class="cboxElement">
                 <img src={`https://www.02ws.co.il/${props.icon}`} width="45" height="45" alt="9/5" />
                
             </a>
            </li>
            <li class="forcast_text">
                
                {props.lang1}                                                                                    <div id="divlikes2584" class="likedislike">		
                                        <Button className="btn-secondary" onclick="updateLikes(event, this.parentNode.parentNode.parentNode.parentNode.id, 'like');"><img src="https://www.02ws.co.il/images/like_white.png" width="15px" height="15px" alt="אהבתי" style={{'cursor':'pointer'}} /></Button>
                                        <span class="likes">31</span>&nbsp;
                                        <Button className="btn-secondary" onclick="updateLikes(event, this.parentNode.parentNode.parentNode.parentNode.id, 'dislike');"><img src="https://www.02ws.co.il/images/dislike_white.png" width="15px" height="15px" alt="לא אהבתי" style={{'cursor':'pointer'}} /></Button>
                                        <span class="dislikes">7</span>
                                </div>
                                                                                    
                                </li>
        </ul>
    );
}

export default ForecastDay; 
import Button from 'react-bootstrap/Button';

const ForecastDay = (props) => {
    const toggleDay = () => {
       
      };
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
                            <span class="info">{eval(`props.TempLowClothTitle${props.lang}`)}</span>
                            <img style={{'vertical-align': 'middle'}} src={`https://www.02ws.co.il/${props.TempLowCloth}`} width="35" height="30" alt={eval(`props.TempLowClothTitle${props.lang}`)} />
                        </a>
                    </div>
                </div>
                
                <div class="icon extra" id="morning_icon">
                    <img src={`https://www.02ws.co.il/${props.morning_icon}`} width="28" height="28" alt="https://www.02ws.co.il/images/icons/day/n4_cloud_5_sun_3.svg" />
                </div>
                <div class="icon extra">
                    <div class="wind_icon light_wind" title="">
                    </div>
                </div>
            </li>
            <li class="forcast_noon">
                <div class="line">
                    <div class="number">
                    {props.TempHigh}</div><div class="cloth extra">
                        <a href="WhatToWear.php#tshirt" rel="external" class="info cboxElement">
                            <span class="info">{eval(`props.TempHighClothTitle${props.lang}`)}</span>
                            <img style={{'vertical-align': 'middle'}} src={`https://www.02ws.co.il/${props.TempHighCloth}`} width="35" height="30"  alt={eval(`props.TempHighClothTitle${props.lang}`)} />
                        </a>
                    </div>
                </div>
                
                <div class="icon extra" id="day_icon0"><img src={`https://www.02ws.co.il/${props.icon}`} width="28" height="28" alt="images/icons/day/n4_cloud_5_sun_3.svg" /></div>                                       
                <div class="icon extra"><div class="wind_icon moderate_wind"></div><div></div></div>
            </li>
            <li class="forcast_night">
                <div class="line">
                    <div class="number">
                    {props.TempNight}</div><div class="cloth extra">
                        <a href="WhatToWear.php#jacket" rel="external" class="info cboxElement">
                            <span class="info">{eval(`props.TempNightClothTitle${props.lang}`)}</span>
                            <img style={{'vertical-align': 'middle'}} src={`https://www.02ws.co.il/${props.TempNightCloth}`} width="35" height="30"  alt={eval(`props.TempNightClothTitle${props.lang}`)} />
                        </a>
                    </div>
                </div>  
                
                <div class="icon extra" id="night_icon0"><img src={`https://www.02ws.co.il/${props.night_icon}`} width="28" height="28" alt="https://www.02ws.co.il/images/icons/day/n4_moon.svg" /></div>
                <div class="icon extra"><div class="wind_icon light_wind" ></div><div></div></div>
            </li>
            <li class="icon_day"><div class="spriteB up" title="במגמת עליה"></div>                      
              <a href="legend.php" rel="external" class="cboxElement">
                 <img src={`https://www.02ws.co.il/${props.icon}`} width="45" height="45" alt="9/5" />
                
             </a>
            </li>
            <li class="forcast_text">
            <div dangerouslySetInnerHTML={{__html: props.lang1}}></div>
                                                                                <div id="divlikes2584" class="likedislike">		
                    <Button className="btn-secondary" onclick="updateLikes(event, this.parentNode.parentNode.parentNode.parentNode.id, 'like');"><img src="https://www.02ws.co.il/images/like_white.png" width="15px" height="15px" alt="אהבתי" style={{'cursor':'pointer'}} /></Button>
                    <span class="likes">31</span>&nbsp;
                    <Button className="btn-secondary" onclick="updateLikes(event, this.parentNode.parentNode.parentNode.parentNode.id, 'dislike');"><img src="https://www.02ws.co.il/images/dislike_white.png" width="15px" height="15px" alt="לא אהבתי" style={{'cursor':'pointer'}} /></Button>
                    <span class="dislikes">7</span>
            </div>
                                                                                    
            </li>
            <li>
                <Button btnOnClick={() => toggleDay()} btnTitleText={"עוד"} />
            </li>
        </ul>
    );
}

export default ForecastDay; 
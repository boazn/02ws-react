import Btn from './Button';
import React, { useState } from 'react';

import { Heart } from "react-bootstrap-icons";
import { ArrowDown } from 'react-bootstrap-icons';
const ForecastDay = (props) => {
    const toggleDay = () => {
       alert('day expends');
      };
    const prevDay = () => {
    alert('prev day expends');
    };

    const useToggle = (initialState) => {
        const [toggleValue, setToggleValue] = useState(initialState);
    
        const toggler = () => { setToggleValue(!toggleValue) };
        return [toggleValue, toggler]
      };
      const [toggle, setToggle] = useToggle();
    return (
        <ul className={"white_box box_text " + (props.lang === 1? 'rtl' : '')}>
            <li className="forcast_off_day">
            {props.a_key == 0 ? <Btn className="btn-link" btnOnClick={() => prevDay()} btnTitleText={"קודם"} img="ArrowUp">
                <img src="images/yesterday.png" width="14" height="14" title="יום אחרון" alt=""  />
            </Btn> : ''}
            </li>
            <li className="forcast_day">{props.day_name1} </li>
            <li className="forcast_date">{props.date}</li>
            <li className="expand_plus">
            <div id="0" className="open-close-button" index="0"></div>
            </li>
            <li className="forcast_morning">
                <div className="line">
                    <div className="number">
                        {props.TempLow}</div><div className="cloth extra0"> 
                        <a href="WhatToWear.php#jacket" rel="external" className="info cboxElement">
                            <span className="info">{eval(`props.TempLowClothTitle${props.lang}`)}</span>
                            <img style={{'verticalAlign': 'middle'}} src={`https://www.02ws.co.il/${props.TempLowCloth}`} width="35" height="30" alt={eval(`props.TempLowClothTitle${props.lang}`)} />
                        </a>
                    </div>
                </div>
                {toggle && (
                <>
                <div className="extra">
               {props.humMorning}%
                </div>
                <div className="extra">
                {props.dustMorning}µg/m3   
                </div>
                </>
                
                )}
                {toggle && ( <div className="icon extra" id="morning_icon">
                    <img src={`https://www.02ws.co.il/${props.morning_icon}`} width="28" height="28" alt="https://www.02ws.co.il/images/icons/day/n4_cloud_5_sun_3.svg" />
                </div>)}
                <div className="icon extra">
                {toggle && ( <div className={`wind_icon ${props.windMorning}`} title="">
                    </div>)}
                </div>
            </li>
            <li className="forcast_noon">
                <div className="line">
                    <div className="number">
                    {props.TempHigh}</div><div className="cloth extra">
                        <a href="WhatToWear.php#tshirt" rel="external" className="info cboxElement">
                            <span className="info">{eval(`props.TempHighClothTitle${props.lang}`)}</span>
                            <img style={{'verticalAlign': 'middle'}} src={`https://www.02ws.co.il/${props.TempHighCloth}`} width="35" height="30"  alt={eval(`props.TempHighClothTitle${props.lang}`)} />
                        </a>
                    </div>
                </div>
                
                {toggle && (
                <>
                <div className="extra">
               {props.humDay}%
                </div>
                <div className="extra">
                {props.dustDay}µg/m3   
                </div>
                </>
                
                )}
                {toggle && (<div className="icon extra" id="day_icon0"><img src={`https://www.02ws.co.il/${props.icon}`} width="28" height="28" alt="images/icons/day/n4_cloud_5_sun_3.svg" /></div>)}                                       
                <div className="icon extra">
                {toggle && (<div className={`wind_icon ${props.windDay}`}></div>)}
                <div>
                </div>
                </div>
            </li>
            <li className="forcast_night">
                <div className="line">
                    <div className="number">
                    {props.TempNight}</div><div className="cloth extra">
                        <a href="WhatToWear.php#jacket" rel="external" className="info cboxElement">
                            <span className="info">{eval(`props.TempNightClothTitle${props.lang}`)}</span>
                            <img style={{'verticalAlign': 'middle'}} src={`https://www.02ws.co.il/${props.TempNightCloth}`} width="35" height="30"  alt={eval(`props.TempNightClothTitle${props.lang}`)} />
                        </a>
                    </div>
                </div>  
                {toggle && (
                <>
                <div className="extra">
               {props.humNight}%
                </div>
                <div className="extra">
                {props.dustNight}µg/m3   
                </div>
                </>
                
                )}
                {toggle && (<div className="icon extra" id="night_icon0"><img src={`https://www.02ws.co.il/${props.night_icon}`} width="28" height="28" alt="https://www.02ws.co.il/images/icons/day/n4_moon.svg" /></div>)}
                <div className="icon extra">
                {toggle && (  <div className={`wind_icon ${props.windNight}`} ></div> )}
                    <div></div></div>
            </li>
            <li className="icon_day"><div className="spriteB up" title="במגמת עליה"></div>                      
              <a href="legend.php" rel="external" className="cboxElement">
                 <img src={`https://www.02ws.co.il/${props.icon}`} width="45" height="45" alt="9/5" />
                
             </a>
            </li>
            <li className="forcast_text">
             <div dangerouslySetInnerHTML={{__html: props.lang1}}></div>
                                                                                <div id="divlikes2584" className="likedislike">		
                    <Btn className="btn-secondary" onclick="updateLikes(event, this.parentNode.parentNode.parentNode.parentNode.id, 'like');"><img src="https://www.02ws.co.il/images/like_white.png" width="15px" height="15px" alt="אהבתי" style={{'cursor':'pointer'}} /></Btn>
                    <span className="likes">31</span>&nbsp;
                    <Btn className="btn-secondary" onclick="updateLikes(event, this.parentNode.parentNode.parentNode.parentNode.id, 'dislike');"><img src="https://www.02ws.co.il/images/dislike_white.png" width="15px" height="15px" alt="לא אהבתי" style={{'cursor':'pointer'}} /></Btn>
                    <span className="dislikes">7</span>
            </div>
                                                                                    
            </li>
            <li className="more">
                <Btn btnOnClick={() => setToggle()} btnTitleText={"עוד"} img="ArrowDown">
                    
                </Btn>
                
            </li>
        </ul>
    );
}

export default ForecastDay; 
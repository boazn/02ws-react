import Btn from './Button';
import React, { useState } from 'react';
import { useTranslation } from 'react-i18next';
import {updateLikesCall} from '../helpers/Utils';
const ForecastDay = (props) => {
    const prevDay = () => {
        setTogglePrev(!togglePrev);
    
    };
    const { t } = useTranslation();
    const useToggle = (initialState) => {
        const [toggleValue, setToggleValue] = useState(initialState);
    
        const toggler = () => { setToggleValue(!toggleValue) };
        return [toggleValue, toggler]
      };
      const updateLikes = async (id, likedislike) => {
        const res_vote = await updateLikesCall(id, likedislike);
        if (likedislike === "like"){
            console.log('updateLikesCall: likes=' + res_vote.likes[0].count);
        }
        else {
            console.log('updateLikesCall: dislikes=' + res_vote.dislikes[0].count);
        }
                
      }
      const [toggle, setToggle] = useToggle();
      const [togglePrev, setTogglePrev] = useToggle();
    
    if (props.yest === undefined)
      return "loading...";
    return (
        <>
        
        {props.a_key === 0 && togglePrev 
            ? 
            <ul className={"white_box box_text " + (props.lang === 1? 'rtl' : '')}>
                <li className="forcast_day"> </li>
                <li className="forcast_date">{props.yest.date}</li>
                <li className="forcast_morning">{props.yest.lowtemp}°</li>
                <li className="forcast_noon">{props.yest.noontemp}°</li>
                <li className="forcast_night">{props.yest.nighttemp}°</li>
                <li className="forcast_text"></li>
            </ul>
            : ''}


        <ul className={"white_box box_text " + (props.lang === 1? 'rtl' : '')}>
            
            {props.a_key == 0 ? <li className="forcast_off_day"><Btn className="btn-link" btnOnClick={() => prevDay()} btnTitleText={"קודם"} img="ArrowUp">
                <img src="images/yesterday.png" width="14" height="14" title="יום אחרון" alt=""  />
            </Btn></li> : ''}
            
            <li className="forcast_day">{eval(`props.day_name${props.lang}`)} </li>
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
                {toggle && ( <div className={`wind_icon ${props.windMorning}`} title="">{props.windMorningSpd}kmh
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
                {toggle && (<div className={`wind_icon ${props.windDay}`}> {props.windDaySpd}kmh</div>)}
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
                {toggle && (  <div className={`wind_icon ${props.windNight}`} >{props.windNightSpd}kmh</div> )}
                    <div></div></div>
            </li>
            <li className="icon_day"><div className="spriteB up" title="במגמת עליה"></div>                      
              <a href="legend.php" rel="external" className="cboxElement">
                 <img src={`https://www.02ws.co.il/${props.icon}`} width="45" height="45" alt="9/5" />
                
             </a>
            </li>
            <li className="forcast_text">
             <div dangerouslySetInnerHTML={{__html: eval(`props.lang${props.lang}`)}}></div>
             <div id={`divlikes${props.id}`} className="likedislike">		
                    <Btn className="btn-secondary" img="HandThumbsUp" btnOnClick={() => updateLikes(props.id, 'like')} onclick="updateLikes(event, this.parentNode.parentNode.parentNode.parentNode.id, 'like');"></Btn>
                    <span className="likes"></span>&nbsp;
                    <Btn className="btn-secondary" img="HandThumbsDown" btnOnClick={() => updateLikes(props.id, 'dislike')} onclick="updateLikes(event, this.parentNode.parentNode.parentNode.parentNode.id, 'dislike');"></Btn>
                    <span className="dislikes"></span>
            </div>
                                                                                    
            </li>
            <li className="more">
                <Btn btnOnClick={() => setToggle()}  img={toggle ? "ArrowUp" : "ArrowDown" }>
                    
                </Btn>
                
            </li>
        </ul>
        </>
    );
}

export default ForecastDay; 
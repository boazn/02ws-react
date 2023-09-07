
import { useTranslation } from 'react-i18next';
import ColdMeter  from './ColdMeter';
import { Link } from "react-router-dom";
import { useState, useContext } from "react";
const LatestNow = (props) => {
    const { t } = useTranslation();
    const [isShadow, setIsShadowShown] = useState(true);
    const [isSun, setIsSunShown] = useState(false);
    const [feelslike, setFeelslike] = useState(props.feelslike.avg);
    const showShadow = () =>{
        setIsShadowShown(true);
        setIsSunShown(false);
        setFeelslike(props.feelslike.avg);
    }
    const showSun = () =>{
        setIsShadowShown(false);
        setIsSunShown(true);
        setFeelslike(props.current.thsw);
    }
    if (props.current === undefined)
        return "loading...";
    return (
          <div id="latestnow" className={"white_box " + (props.lang === 1? 'rtl' : '')}>
            {eval(`props.current.date${props.lang}`)}<br/>
                <div id="innernow">
                {props.current.issun === 'true' ?
                    <ul id="sunshade_controls">
                            <li>
                                <Link onClick={() => showShadow()} className={isShadow ? "selected" : ""}>{t("SHADE")}</Link>
                            </li>
                            <li>
                                <Link onClick={() => showSun()} className={isSun ? "selected" : ""}>{t("IN_THE_SUN")}</Link>
                            </li>
                      </ul> : ''}
                <div  title="" className="mx-auto parambox white_box float">
                <div  id="windy">   
                    <div dangerouslySetInnerHTML={{__html: props.windstatus.lang1}}></div>
                </div>
                <Link to={`/Now`}  >{props.current.temp}°</Link>
                </div>
                <div className="" id="itfeels">
                {t("IT_FEELS")} <br/>{feelslike}°
             </div>
            
                <div className="rainpercent">
             {(props.current.rainchance > 0 ? props.current.rainchance + "%": '')}
                </div>
                </div>
              
                <div id="coldmeterwrapper" className="float">
                <ColdMeter  lang={props.lang} shadowtemp={props.feelslike.avg} suntemp={props.current.thsw} issun={props.current.issun} showShadow={isShadow} showSun={isSun}/>
                </div>
        </div>      
        
    );
}

export default LatestNow; 
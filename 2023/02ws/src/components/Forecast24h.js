import ForecastHour from './ForecastHour';
import {  Link } from "react-router-dom";
import { useState, useContext } from "react";
import { useTranslation } from 'react-i18next';
const Forecast24h = (props) => {
    const { t } = useTranslation();
    const [isTemp, setIsTempShown] = useState(true);
    const [isHumidity, setIsHumidityShown] = useState(false);
    const [isCloth, setIsClothShown] = useState(true);
    const [isRainrate, setIsRainrateShown] = useState(false);
    const showTemp = () =>{
        setIsTempShown(true);
        setIsHumidityShown(false);
        setIsClothShown(false);
        setIsRainrateShown(false);
    }
    const ShowHumidity = () =>{
        setIsTempShown(false);
        setIsHumidityShown(true);
        setIsClothShown(false);
        setIsRainrateShown(false);
    }
    const ShowCloth = () =>{
        setIsTempShown(false);
        setIsHumidityShown(false);
        setIsClothShown(true);
        setIsRainrateShown(false);
    }
    const ShowRainrate = () =>{
        setIsTempShown(false);
        setIsHumidityShown(false);
        setIsClothShown(false);
        setIsRainrateShown(true);
    }
    return (
        <div id="graph_container">
            <div id="controls">
                    <ul id="controls_ul">
                            <li>
                                <Link onClick={() => showTemp()} >{t("TEMP")}</Link>
                            </li>
                            <li>
                                <Link  onClick={() => ShowHumidity()} >{t("HUMIDITY")}</Link>
                            </li>
                            <li>
                                <Link onClick={() => ShowCloth()} >{t("CLOTH")}</Link>
                            </li>
                            <li>
                                <Link onClick={() => ShowRainrate()} >{t("RAIN_RATE")}</Link>
                            </li>
                    </ul>
            </div>     			
            <div id="graph_forcast"  className={"metric-chart h-bar-chart " + (props.lang === 1? 'rtl' : '')}>
            
            <ul id="forcast_hours" className="for24_graph_ng x-axis-bar-list count-10">
            {props.hours.map((hour, i) => {
                return <ForecastHour key={i} {...hour} lang={props.lang} isTemp={isTemp} isHumidity={isHumidity} isCloth={isCloth} isRainrate={isRainrate} ></ForecastHour>;
            })}
            </ul>
            </div>

        </div>

        
    );
}

export default Forecast24h; 
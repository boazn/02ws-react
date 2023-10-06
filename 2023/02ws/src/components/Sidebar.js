
import { Link } from "react-router-dom";
import { useState, useContext } from "react";
import '../css/navbar.css';
import { useTranslation } from 'react-i18next';
import {ConfigContext} from "../helpers/ConfigContext";

import Btn from './Button';

const lngs = [
    { code: "0", native: "English" },
    { code: "1", native: "עברית" }
];
function Sidebar() {
    function do_something(){
      //  alert('do something');
    }
    const { t, i18n } = useTranslation();

    const configs = useContext(ConfigContext);
    var langcode = configs.lang;

    const handleTrans = (code) => {
        i18n.changeLanguage(code);
        langcode = code;
        configs.lang = code;
        setConfig(configs);
      };
    const [isOpen, setIsOpen] = useState(false);
    const [isForecastOpen, setIsForecastOpen] = useState(false);
    const [iswhatelseOpen, setIswhatelseOpen] = useState(false);
    const [isWhatHappendOpen, setIsWhatHappendOpen] = useState(false);
    const [configData, setConfig] = useState(true);
  
    function handleToggle(){
        setIsOpen(!isOpen);
    }
    const toggleForecastOpen = () =>{
        setIsForecastOpen(!isForecastOpen);
    }
    const toggleIswhatelseOpen = () =>{
        setIswhatelseOpen(!iswhatelseOpen);
    }
    const toggleIsWhatHappendOpen = () =>{
        setIsWhatHappendOpen(!isWhatHappendOpen);
    }
    return (
        <div id="sidebar" className={(langcode === 1)? 'rtl' : ''}>
                        
            <nav className={`${isOpen ? 'open': ''}`}>
            <ul className={`links ${isOpen ? 'open': ''}`}>
                <li>
                     <div id="trans_btns">
                        {lngs.map((lng, i) => {
                        const { code, native } = lng;
                        return <Btn key={i} btnOnClick={() => handleTrans(code)} btnTitleText={native}></Btn>;
                    })}
                    </div>
                </li>
                <li>
                <a href={`/`}>דף ראשי</a>
                </li>
                <li>
                <a href={`/Now/2`}>Current first</a>
                </li>
                <li>
                    <Link to={`/App1`} onClick={() => do_something()} >Current </Link>
                </li>
                <li>
                    <Link to={`/App2`} onClick={() => do_something()} >24H first</Link>
                </li>
                <li>
                    <Link to={`/App3`} onClick={() => do_something()} >Nextdays first</Link>
                </li>
                <li>
                    <Link to={`/About`} onClick={() => do_something()} >{t("CONTACT_INFO")}</Link>
                </li>
                <li>
                    <Link to={`/Contact`} onClick={() => do_something()} >{t("CONTACT_ME")}</Link>
                </li>
                <li>
                    <Link  onClick={() => toggleForecastOpen()} >{t("FORECAST")} >></Link>
                    {isForecastOpen &&
                    <ul id="forecast">
                        <li>
                            <Link to={`/ForecastAbroad`} onClick={() => do_something()} >{t("WORLD")}</Link>
                        </li>
                        <li>
                            <Link to={`/ForecastIsrael`} onClick={() => do_something()} >{t("ISRAEL")}</Link>
                        </li>
                        <li>
                            <Link to={`/ForecastJob`} onClick={() => do_something()} >{t("FORECASTER_JOB")}</Link>
                        </li>
                    </ul>
                    }
                </li>
                <li>
                    <Link  onClick={() => toggleIswhatelseOpen()} >{t("WHAT_ELSE")} >></Link>
                    {iswhatelseOpen &&
                    <ul id="whatelse">
                    <li>
                    <Link to={`/Radar`} onClick={() => do_something()} >{t("RAIN_RADAR")}</Link>
                    </li>
                    <li>
                        <Link to={`/Satellite`} onClick={() => do_something()} >{t("SATELLITE")}</Link>
                    </li>
                    <li>
                        <Link to={`/GlobalWarming`} onClick={() => do_something()} >{t("GLOBAL_WARMING")}</Link>
                    </li>
                    <li>
                    <Link to={`/Runningtreks`} onClick={() => do_something()} >{t("RUNNING_TREKS")}</Link>
                    </li>
                    <li>
                        <Link to={`/Rain`} onClick={() => do_something()} >{t("RAIN")}</Link>
                    </li>
                    <li>
                         <Link to={`/Radiosonde`} onClick={() => do_something()} >{t("RADIOSONDE")}</Link>
                    </li>
                    </ul>
                    }
                </li>
                <li>
                    <Link  onClick={() => toggleIsWhatHappendOpen()} >{t("WHAT_HAPPEND")} >></Link>
                    {isWhatHappendOpen &&
                    <ul id="whathappend">
                        <li>
                            <Link to={`/Average`} onClick={() => do_something()} >{t("AVERAGE")}</Link>
                        </li>
                        <li>
                            <Link to={`/Last2days`} onClick={() => do_something()} >{t("LAST_DAY")}</Link>
                        </li>
                        <li>
                            <Link to={`/LastWeek`} onClick={() => do_something()} >{t("LAST_WEEK")}</Link>
                        </li>
                        <li>
                            <Link to={`/ThisMonth`} onClick={() => do_something()} >8/23 {t("MONTH")}</Link>
                        </li>
                        <li>
                            <Link to={`/ChooseMonthYear`} onClick={() => do_something()} >{t("CHOOSE")}</Link>
                        </li>
                        <li>
                            <Link to={`/LastMonth`} onClick={() => do_something()} >{t("LAST_MONTH")}</Link>
                        </li>
                        <li>
                            <Link to={`/Records`} onClick={() => do_something()} >{t("RECORDS")}</Link>
                        </li>
                        <li>
                            <Link to={`/RainSeasons`} onClick={() => do_something()} >{t("RAIN_SEASONS")}</Link>
                        </li>
                        <li>
                            <Link to={`/LoveHateForecasts`} onClick={() => do_something()} >{t("LIKED_FORECAST")}</Link>
                        </li>
                        <li>
                            <Link to={`/Reports`} onClick={() => do_something()} >{t("REPORTS")}</Link>
                        </li>
                        <li>
                            <Link to={`/Archive`} onClick={() => do_something()} >{t("ARCHIVE")}</Link>
                        </li>
                        <li>
                            <Link to={`/Snow`} onClick={() => do_something()} >{t("SNOW")}</Link>
                        </li>
                        <li>
                            <Link to={`/Climate`} onClick={() => do_something()} >{t("CLIMATE")}</Link>
                        </li>
                        <li>
                            <Link to={`/BestSeason`} onClick={() => do_something()} >{t("FSEASON_T")}</Link>
                        </li>
                    </ul>
                    }   
                </li>
               <li>
                    <Link to={`/Faq`} onClick={() => do_something()} >{t("FAQ")}</Link>
                </li>
                <li>
                    <Link to={`/Tips`} onClick={() => do_something()} >{t("TIPS")}</Link>
                </li>
               
                
                <li>
                    <Link to={`/AppExternal/1`} onClick={() => do_something()} >External</Link>
                </li>
                <li>
                    <Link to={`/AppExternal/2`} onClick={() => do_something()} >External2</Link>
                </li>
                
            </ul>
            
            <div className={`menu ${isOpen ? 'open': ''}`} onClick={handleToggle}>
               <div className="hamburger"></div>
            </div>
            </nav>
        </div>
    )
}
export default Sidebar;

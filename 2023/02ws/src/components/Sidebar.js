
import { Outlet, Link } from "react-router-dom";
import { useState } from "react";
import '../css/navbar.css';
import { useTranslation } from 'react-i18next';
import Btn from './Button';

const lngs = [
    { code: "en", native: "English" },
    { code: "he", native: "Hebrew" }
];
function Sidebar() {
    function do_something(){
      //  alert('do something');
    }
    const { t, i18n } = useTranslation();
    var langcode = 1;
    const handleTrans = (code) => {
        i18n.changeLanguage(code);
        langcode = code;
      };
    const [isOpen, setIsOpen] = useState(false);
  
    function handleToggle(){
        setIsOpen(!isOpen);
    }
    return (
        <div id="sidebar">
                        
            <nav>
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
                    <Link to={`/About`} onClick={() => do_something()} >About</Link>
                </li>
                <li>
                    <Link to={`/ForecastAbroad`} onClick={() => do_something()} >ForecastAbroad</Link>
                </li>
                <li>
                    <Link to={`/ForecastIsrael`} onClick={() => do_something()} >ForecastIsrael</Link>
                </li>
                <li>
                    <Link to={`/ForecastJob`} onClick={() => do_something()} >ForecastJob</Link>
                </li>
                <li>
                    <Link to={`/Radar`} onClick={() => do_something()} >Radar</Link>
                </li>
                <li>
                    <Link to={`/Satellite`} onClick={() => do_something()} >Satellite</Link>
                </li>
                <li>
                    <Link to={`/Rain`} onClick={() => do_something()} >Rain</Link>
                </li>
                <li>
                    <Link to={`/Runningtreks`} onClick={() => do_something()} >Runningtreks</Link>
                </li>
                <li>
                    <Link to={`/GlobalWarming`} onClick={() => do_something()} >GlobalWarming</Link>
                </li>
                <li>
                    <Link to={`/Average`} onClick={() => do_something()} >Average</Link>
                </li>
                <li>
                    <Link to={`/Last2days`} onClick={() => do_something()} >Last2days</Link>
                </li>
                <li>
                    <Link to={`/LastWeek`} onClick={() => do_something()} >LastWeek</Link>
                </li>
                <li>
                    <Link to={`/ThisMonth`} onClick={() => do_something()} >ThisMonth</Link>
                </li>
                <li>
                    <Link to={`/ChooseMonthYear`} onClick={() => do_something()} >ChooseMonthYear</Link>
                </li>
                <li>
                    <Link to={`/LastMonth`} onClick={() => do_something()} >LastMonth</Link>
                </li>
                <li>
                    <Link to={`/Records`} onClick={() => do_something()} >Records</Link>
                </li>
                <li>
                    <Link to={`/RainSeasons`} onClick={() => do_something()} >RainSeasons</Link>
                </li>
                <li>
                    <Link to={`/LoveHateForecasts`} onClick={() => do_something()} >LoveHateForecasts</Link>
                </li>
                <li>
                    <Link to={`/Reports`} onClick={() => do_something()} >Reports</Link>
                </li>
                <li>
                    <Link to={`/Archive`} onClick={() => do_something()} >Archive</Link>
                </li>
                <li>
                    <Link to={`/Snow`} onClick={() => do_something()} >Snow</Link>
                </li>
                <li>
                    <Link to={`/Climate`} onClick={() => do_something()} >Climate</Link>
                </li>
                <li>
                    <Link to={`/BestSeason`} onClick={() => do_something()} >BestSeason</Link>
                </li>
                <li>
                    <Link to={`/Faq`} onClick={() => do_something()} >Faq</Link>
                </li>
                <li>
                    <Link to={`/Tips`} onClick={() => do_something()} >Tips</Link>
                </li>
                <li>
                    <Link to={`/Contact`} onClick={() => do_something()} >Contact</Link>
                </li>
                <li>
                    <Link to={`/Radiosonde`} onClick={() => do_something()} >Radiosonde</Link>
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

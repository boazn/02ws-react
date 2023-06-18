import logo from '../logo.svg';
import '../App.css';
import { useTranslation } from 'react-i18next';
import Btn from './Button';
import Now from './Now';
import Forecast24h from './Forecast24h';
import NextDays from './NextDays';
import Notifications from './Notifications';
import Ad from './Ad';
import ColdMeter  from './ColdMeter';
import { React } from 'react';
import navValues from '../helpers/navValues';
import Statuses from './Statuses';
import classNames from "classnames";
import PicOfTheDay from './PicOfTheDay';
import UserPics from './UserPics';
import Activities from './Activities';
import { Outlet, Link } from "react-router-dom";

const lngs = [
  { code: "en", native: "English" },
  { code: "he", native: "Hebrew" }
];


function App3({json, cssClasses}) {
  
  const { t, i18n } = useTranslation();
  var langcode = 1;
  const handleTrans = (code) => {
    i18n.changeLanguage(code);
    langcode = code;
  };
  
  if (json.length === 0){ 
    return <div>loading...</div>
  }
  const nextDays = json.jws.forecastDays;
  const nextHours = json.jws.forecastHours;
  const current = json.jws.current;
  const messages = json.jws.Messages;
  const statuses = json.jws.states.sigweather;
  const states = json.jws.states;
  const picoftheday = json.jws.LatestPicOfTheDay;
  const userpics = json.jws.LatestUserPic;
  const currentrecommendations = json.jws.current.recommendations;
    return (
      <>
      <div className={"container-fluid App " + cssClasses}>
      <header className={"App-header row mb-2 " + (langcode === 1? 'rtl' : '')}>
        <div className="col-6 ">
        <h4><img src={logo} className="App-logo" alt="logo" />  {t("welcome")}{t("site")}</h4>
            {lngs.map((lng, i) => {
            const { code, native } = lng;
            return <Btn btnOnClick={() => handleTrans(code)} btnTitleText={native}></Btn>;
          })}
        </div>
       </header>
       <div className={"row "  + (langcode === 1? 'rtl' : '')}>
       <div className="col-6 mt-2"><NextDays days={nextDays} lang={langcode} className={cssClasses}/></div>
       <div className="col "><Notifications notifications={messages} lang={langcode} className={cssClasses}/></div>
       <div className="col "><Ad /></div>
       </div> 
       <div className={"row "  + (langcode === 1? 'rtl' : '')}>
       <div className="col mx-auto mt-2"><Now current={current} lang={langcode} className={cssClasses} /></div>
       <div className="col "><ColdMeter  lang={langcode}/></div>
       <div className="col "><Statuses statuses={statuses} lang={langcode} className={cssClasses}/></div>
       <div className="col "><Activities activities={currentrecommendations} lang={langcode} /></div>
       <div className="col mt-2"><Forecast24h hours={nextHours} lang={langcode} className={cssClasses} /></div>
        </div>
       <div className="row">
       <div className="col "><PicOfTheDay pic={picoftheday} lang={langcode} /></div>
       <div className="col "><UserPics userPics={userpics} lang={langcode} /></div>
       </div>
     </div>
     </>
    );
  
}

export default App3;

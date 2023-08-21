import logo from '../logo.svg';
import '../App.css';
import { useTranslation } from 'react-i18next';
import Forecast24h from './Forecast24h';
import NextDays from './NextDays';
import Notifications from './Notifications';
import Ad from './Ad';
import { React, useContext } from 'react';
import Statuses from './Statuses';
import PicOfTheDay from './PicOfTheDay';
import UserPics from './UserPics';
import Activities from './Activities';
import { Outlet, Link } from "react-router-dom";
import LatestNow from './LatestNow';
import {useCurrentUser} from "../helpers/UserContext";
import {ConfigContext} from "../helpers/ConfigContext";
import TempGraph from './TempGraph';

function App1({json, cssClasses, activities_json}) {
  
  const { t, i18n } = useTranslation();
  const { currentUser, fetchCurrentUser } = useCurrentUser();
  const configs = useContext(ConfigContext);
  var langcode = configs.lang;
  if (json.length === 0){ 
    return <div>loading...</div>
  }
  
  const nextDays = json.jws.forecastDays;
  const nextHours = json.jws.forecastHours;
  const current = json.jws.current;
  const feelslike = json.jws.feelslike;
  const messages = json.jws.Messages;
  const statuses = json.jws.states.sigweather;
  const states = json.jws.states;
  const yest = json.jws.yest;
  const windstatus = json.jws.windstatus;
  const picoftheday = json.jws.LatestPicOfTheDay;
  const userpics = json.jws.LatestUserPic;
  const currentrecommendations = json.jws.current.recommendations;
  
  return (
    <>
    
    <div className={"clouds container-fluid App " + cssClasses}>
      
      <header className={"App-header row mb-2 " + (langcode === 1? 'rtl' : '')}>
        <div className="col-12 ">
        <div><img src={logo} className="App-logo" alt="logo" />  {t("SLOGAN")} - {t("WEBSITE_TITLE")} 
        
        </div>
        </div>
       </header>
       
      
       <div className={"row "  + (langcode === 1? 'rtl' : '')}>
       <div className="clouds-3"></div>
       <div className="col-xs-4 col-md-4 col-lg-4 blue_transp_box "><LatestNow current={current} feelslike={feelslike} windstatus={windstatus} lang={langcode} className={cssClasses} /></div>
       <div className="col-xs-4 col-md-4 col-lg-4  ">
        <Statuses statuses={statuses} lang={langcode} className={cssClasses}/>
       <Activities activities_json={activities_json} activities={currentrecommendations} lang={langcode} />
       </div>
       <div className="col-xs-4 col-md-4 col-lg-4 "><Ad /></div>  
       </div>
       
       <div className={"row "  + (langcode === 1? 'rtl' : '')}>
       <div className="col-xs-4 col-lg-8 mx-auto mt-12">
          <Forecast24h hours={nextHours} lang={langcode} className={cssClasses} />
        </div>
        <div className="col-xs-4 col-lg-4"><Ad /></div>
       </div>
       <div className={"row "  + (langcode === 1? 'rtl' : '')}>
       
       </div>
       <div className={"row "  + (langcode === 1? 'rtl' : '')}>
       <div className="col-xs-4 col-lg-8 mt-2"><NextDays days={nextDays} lang={langcode} className={cssClasses} yest={yest}/></div>
       <div className="col-xs-4 col-lg-4 "><Notifications notifications={messages} lang={langcode} className={cssClasses}/></div>
       
       </div> 
       <div className="row">
       <div className="graph col-xs-4 col-lg-4 ">
       <TempGraph className={cssClasses} lang={langcode}/>
       </div>
       <div className="graph col-xs-4 col-lg-4 ">
       <TempGraph className={cssClasses} lang={langcode}/>
       </div>
       <div className="graph col-xs-4 col-lg-4 ">
       <TempGraph className={cssClasses} lang={langcode}/>
       </div>    
       </div>
       <div className="row">
       <div className="col-xs-4 col-lg-4 "><PicOfTheDay pic={picoftheday} lang={langcode} /></div>
       <div className="col-xs-4 col-lg-4 "><Ad /></div>
       <div className="col-xs-4 col-lg-4 "><UserPics userPics={userpics} lang={langcode} /></div>
       </div>
     </div>
     </>
    )
  
}

export default App1;

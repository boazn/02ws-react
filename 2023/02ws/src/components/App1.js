import logo from '../logo.svg';
import '../App.css';
import { useTranslation } from 'react-i18next';
import Forecast24h from './Forecast24h';
import NextDays from './NextDays';
import Notifications from './Notifications';
import Ad from './Ad';
import { React, useContext, useState } from 'react';
import Statuses from './Statuses';
import PicOfTheDay from './PicOfTheDay';
import UserPics from './UserPics';
import Activities from './Activities';
import AdsInternal from './AdsInternal';
import LatestNow from './LatestNow';
import {useCurrentUser} from "../helpers/UserContext";
import {ConfigContext} from "../helpers/ConfigContext";
import TempGraph from './TempGraph';
import Btn from './Button';
import ReactModal  from 'react-modal';
import CurrentStory from './CurrentStory';
import ThisMonthClimate from './ThisMonthClimate';

function App1({json, cssClasses, activities_json}) {
  
  const { t, i18n } = useTranslation();
  const { currentUser, fetchCurrentUser } = useCurrentUser();
  const [isOpen, setPopupIsOpen] = useState(false);
  const [currentTitle, setCurrentTitle] = useState(false);
  const configData = useContext(ConfigContext);
  var langcode = configData.lang;
  if (json.length === 0){ 
    return <div>loading...</div>
  }
  const setIsOpen = ({isOpen}) => {
        
    setPopupIsOpen(isOpen);
  } 
 
 const saveConfigData = () => {
  configData.layout = "current";
  localStorage.setItem('configData', JSON.stringify(configData));
  console.log ('saved' + JSON.stringify(configData));
  setCurrentTitle('saved' + JSON.stringify(configData));
  setPopupIsOpen(true);
 }

   const nextDays = json.jws.forecastDays;
  const nextHours = json.jws.forecastHours;
  const ads = json.jws.Ads;
  const current = json.jws.current;
  const feelslike = json.jws.feelslike;
  const messages = json.jws.Messages;
  const statuses = json.jws.states.sigweather;
  const thisMonth = json.jws.thisMonth;
  const yest = json.jws.yest;
  const windstatus = json.jws.windstatus;
  const picoftheday = json.jws.LatestPicOfTheDay;
  const userpics = json.jws.LatestUserPic;
  const currentrecommendations = json.jws.current.recommendations;
  
  return (
    <>
    
    <div className={"clouds container-fluid App " + cssClasses}>
      
      <header className={"App-header row mb-2 " + (langcode === 1? 'rtl' : '')}>
      <div className="row ">
        
          <div className="col-12 ">
          <div><img src={logo} className="App-logo" alt="logo" />  {t("SLOGAN")} - {t("WEBSITE_TITLE")} 
        
          </div>
          </div>
          
      </div>
      <div className="row ">
      <div className="col-4 ">
             <Btn btnOnClick={() => saveConfigData()} btnTitleText="לשמור כדף פתיחה" img="ArrowDown">
                      
               </Btn>
        </div>
        <div className="col-4 ">
        {eval(`current.date${langcode}`)}
        </div>
        <div className="col-4 ">

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
      <div className="col-xs-8 col-lg-8">
        <div className="col mt-12">
          <Forecast24h hours={nextHours} lang={langcode} className={cssClasses} />
        </div>
        <div className="col mt-12">
            <NextDays days={nextDays} lang={langcode} className={cssClasses} yest={yest} activities_json={activities_json}/>
            <ThisMonthClimate ThisMonth={thisMonth} lang={langcode} />
        </div>
      </div>
      <div className="col-xs-4 col-lg-4">
        <Notifications notifications={messages} lang={langcode} className={cssClasses}/>
        <Forecast24h hours={nextHours} lang={langcode} className={cssClasses} vertical={true} />
      </div>
      
       </div>
       
       <div className="row">
       <div className="graph col-xs-4 col-lg-3 ">
       <CurrentStory lang={langcode} />
      </div>
       <div className="graph col-xs-4 col-lg-3 ">
       <TempGraph className={cssClasses} lang={langcode} limit={1000} params={'temp,temp2,temp3'}/>
       </div>
       <div className="graph col-xs-4 col-lg-3 ">
       <AdsInternal ads={ads} />
       </div>
       <div className="graph col-xs-4 col-lg-3 ">
       <Ad/>
       </div>    
       </div>
       <div className="row">
       <div className="col-xs-4 col-lg-4 "><PicOfTheDay pic={picoftheday} lang={langcode} /></div>
       <div className="col-xs-4 col-lg-4 "><Ad /></div>
       <div className="col-xs-4 col-lg-4 "><UserPics userPics={userpics} lang={langcode} /></div>
       </div>
     </div>
     <ReactModal
        
        isOpen={isOpen}
        contentLabel="Example Modal"
        
        onRequestClose={() => setIsOpen(false)}

      >
         <Btn btnOnClick={() => setIsOpen(false)} btnTitleText={""}  img={"X"}>
                
        </Btn>
        {currentTitle}
        
         <br/><br/><br/>
         <Btn btnOnClick={() => setIsOpen(false)} btnTitleText={"Ok"} >
                
        </Btn>
      </ReactModal>
     </>
    )
  
}

export default App1;

import logo from '../logo.svg';
import '../App.css';
import { useTranslation } from 'react-i18next';
import Btn from './Button';
import Ad from './Ad';
import { React } from 'react';
import External from './Extrenal';

const lngs = [
  { code: "en", native: "English" },
  { code: "he", native: "Hebrew" }
];


function AppExternal({json, cssClasses, src}) {
  
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
       <div className="col-12 col-sm-9 bg-light p-3 border"><External src={src} width="1920" height="800" className={cssClasses}/></div>
       </div> 
       
     </div>
     </>
    );
  
}

export default AppExternal;

import logo from '../logo.svg';
import '../App.css';
import { useTranslation } from 'react-i18next';
import { React, useContext } from 'react';
import External from './Extrenal';
import {useCurrentUser} from "../helpers/UserContext";
import {ConfigContext} from "../helpers/ConfigContext";
import Btn from './Button';



function AppExternal({json, cssClasses, src}) {
  
  const { t, i18n } = useTranslation();
  const { currentUser, fetchCurrentUser } = useCurrentUser();
  const configData = useContext(ConfigContext);
  var langcode = configData.lang;
  if (json.length === 0){ 
    return <div>loading...</div>
  }
  
 const saveConfigData = () => {
  configData.layout = "NextDays";
  localStorage.setItem('configData', JSON.stringify(configData));
  console.log ('saved' + JSON.stringify(configData));
 }
  if (json.length === 0){ 
    return <div>loading...</div>
  }
    return (
      <>
      <div className={"container-fluid App " + cssClasses}>
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

        </div>
        <div className="col-4 ">

        </div>
      </div>
      
       </header>
       <div className={"row "  + (langcode === 1? 'rtl' : '')}>
       <div className="col-12 col-sm-9 bg-light p-3 border"><External src={src} width="800" height="1000" className={cssClasses}/></div>
       </div> 
       
     </div>
     </>
    );
  
}

export default AppExternal;

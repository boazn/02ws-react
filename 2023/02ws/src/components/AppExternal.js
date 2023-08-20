import logo from '../logo.svg';
import '../App.css';
import { useTranslation } from 'react-i18next';
import { React } from 'react';
import External from './Extrenal';



function AppExternal({json, cssClasses, src}) {
  
  const { t, i18n } = useTranslation();
  var langcode = 1;
  
  if (json.length === 0){ 
    return <div>loading...</div>
  }
    return (
      <>
      <div className={"container-fluid App " + cssClasses}>
      <header className={"App-header row mb-2 " + (langcode === 1? 'rtl' : '')}>
        <div className="col-12 ">
        <h4><img src={logo} className="App-logo" alt="logo" />  {t("welcome")}{t("site")}</h4>
           
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

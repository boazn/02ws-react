import './App.css';
import { React, useEffect, useState, useRef, useContext } from 'react';
import navValues from './helpers/navValues';
import classnames from "classnames";
import { CurrentUserProvider } from './helpers/UserContext';
import App1 from './components/App1';
import App2 from './components/App2';
import App3 from './components/App3';
import Now from './components/Now';
import AppExternal from './components/AppExternal';
import {getMainData} from './helpers/Utils';
import {getActivitiesData} from './helpers/Utils';
import Sidebar from './components/Sidebar';
import configJson from "./02wsconfig.json";
import ConfigContext from "./helpers/ConfigContext";
import ExternalContext from "./helpers/ExternalContext";
import TempGraph from './components/TempGraph';

function App({layout, src}) {
  
  const [isLoading, setIsLoading] = useState(true);
  const [configData, setConfig] = useState(true);
  const [json, setJson] = useState([]);
  const [activities, setActivities] = useState(false);
  const [current, setCurrent] = useState([]);
  const [states, setStates] = useState([]);
  const [nav, setNav] = useState(navValues.home);
  const counter = useRef(0);
  var target = useContext(ExternalContext);
  
   useEffect(() =>{
      const fetchJson = async () => {
      const json = await getMainData();
      const activities = await getActivitiesData();
      const current = json.jws.current;
      const states = json.jws.states;
      setJson(json);
      setCurrent(current);
      setStates(states);
      setNav(isRoot ? layout : configData.layout);
      setActivities({activities});
      importConfigData();
      counter.current++;
      setIsLoading(false);
      
      
    };
   fetchJson();
    const timer = setInterval(() => {
      fetchJson();
    }, 60000);
  }, [])

 const importConfigData = () => {
   
  var configs = localStorage.getItem('configData');
  if (configs === null)
     configs = configJson;
  else
    configs = JSON.parse(configs);
  //alert(configs);
  setConfig(configs);
 }


  const cssClasses = classnames ({
    snow: (states.issnowing  === 'true'),
    rain: (states.israining  === 'true'),
    night: (current.islight  === 'false'),
    dust: (current.isdusty === 'true'),
    windy: (current.iswindy === 'true'),
    sunset: (current.issunset === 'true'),
    sunrise: (current.issunrise === 'true'),
    cloudy: (current.cloudiness > 6),
    partlycloudy: (current.cloudiness > 2 && current.cloudiness < 6),
    fewclouds: (current.cloudiness > 0 && current.cloudiness <= 2),

  
  });

  function isRoot() {
    return true;
  }
 
 
  
    

 if ((nav === 'current') || (nav === '')){
  return (
    isLoading ?
    <div className="splash"><img src="https://www.02ws.co.il/img/logo.png" width="200" alt="logo" className="rounded mx-auto d-block img-fluid" ></img></div>  :
    <ConfigContext.Provider value={configData}>
    <CurrentUserProvider>
      <Sidebar />
     <App1 json={json} cssClasses={cssClasses} activities_json={activities} />
     </CurrentUserProvider>
     </ConfigContext.Provider>
    
    
 )} else  if (nav === 'forecast24') {
    return (
      isLoading ?
      <div className="splash"><img src="https://www.02ws.co.il/img/logo.png" width="200" alt="logo" className="rounded mx-auto d-block img-fluid" ></img></div>  :
      <ConfigContext.Provider value={configData}>
      <CurrentUserProvider>
        <Sidebar />
        <App2 json={json} cssClasses={cssClasses}  activities_json={activities} />
      </CurrentUserProvider>
      </ConfigContext.Provider> 
      
   )}  else  if (nav === 'NextDays'){
    return (
      isLoading ?
      <div className="splash"><img src="https://www.02ws.co.il/img/logo.png" width="200" alt="logo" className="rounded mx-auto d-block img-fluid" ></img></div>  :
      <ConfigContext.Provider value={configData}>
      <CurrentUserProvider>
        <Sidebar />
        <App3 json={json} cssClasses={cssClasses}  activities_json={activities}/>
        </CurrentUserProvider> 
        </ConfigContext.Provider>
      
    )}  else  if (nav === 'External') {
    return (
      isLoading ?
      <div className="splash"><img src="https://www.02ws.co.il/img/logo.png" width="200" alt="logo" className="rounded mx-auto d-block img-fluid" ></img></div>  :
      <ExternalContext.Provider value={target}>
      <ConfigContext.Provider value={configData}>
      <CurrentUserProvider>
        <Sidebar />
        <AppExternal src={src} json={json} cssClasses={cssClasses}  activities_json={activities}/>
        </CurrentUserProvider>
        </ConfigContext.Provider>
        </ExternalContext.Provider>
      
    )} else  if (nav === 'now') {
      return (
        isLoading ?
        <div className="splash"><img src="https://www.02ws.co.il/img/logo.png" width="200" alt="logo" className="rounded mx-auto d-block img-fluid" ></img></div>  :
        <ConfigContext.Provider value={configData}>
        <CurrentUserProvider>
          <Sidebar />
          <Now current={json.jws.current} cssClasses={cssClasses}  activities_json={activities} />
          <div className="graph col-xs-12 col-lg-12 ">
          <TempGraph className={cssClasses} lang={configData.lang} limit={1000} params={'temp,temp2,temp3'} />
          </div>
        </CurrentUserProvider>
        </ConfigContext.Provider> 
        
     )};
  
}

export default App;


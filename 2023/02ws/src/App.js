import './App.css';
import { React, useEffect, useState, useRef } from 'react';
import navValues from './helpers/navValues';
import classnames from "classnames";
import { CurrentUserProvider } from './helpers/UserContext';
import App1 from './components/App1';
import App2 from './components/App2';
import App3 from './components/App3';
import AppExternal from './components/AppExternal';
import {getMainData} from './helpers/Utils';
import {getActivitiesData} from './helpers/Utils';
import Sidebar from './components/Sidebar';
import configData from "./02wsconfig.json";
import ConfigProvider from "./helpers/ConfigContext";

function App({layout, src}) {
  
  const [isLoading, setIsLoading] = useState(true);
  const [app_layout, setLayout] = useState([]);
  const [json, setJson] = useState([]);
  const [activities, setActivities] = useState(false);
  const [current, setCurrent] = useState([]);
  const [states, setStates] = useState([]);
  const [nav, setNav] = useState(navValues.home);
  const counter = useRef(0);
  
  

   useEffect(() =>{
      const fetchJson = async () => {
      const json = await getMainData();
      const activities = await getActivitiesData();
      const current = json.jws.current;
      const states = json.jws.states;
      setJson(json);
      setCurrent(current);
      setStates(states);
      setNav(nav);
      setLayout({layout});
      setActivities({activities});
      counter.current++;
      setIsLoading(false);
    };
   fetchJson();
    const timer = setInterval(() => {
      fetchJson();
    }, 60000);
  }, [])


  const cssClasses = classnames ({
    snow: (states.issnowing  === 'true'),
    rain: (states.israining  === 'true'),
    night: (current.issun  === 'false'),
    dust: (current.isdusty === 'true'),
    windy: (current.iswindy === 'true'),
    sunset: (current.issunset === 'true'),
    sunrise: (current.issunrise === 'true'),
    cloudy: (current.cloudiness > 6),
    partlycloudy: (current.cloudiness > 2 && current.cloudiness < 6),
    fewclouds: (current.cloudiness > 0 && current.cloudiness <= 2),

  
  });
   
 if ((layout === 'current') || (layout === '')){
  return (
    isLoading ?
    <div><img src="https://www.02ws.co.il/img/logo.png" width="200" alt="logo" className="rounded mx-auto d-block img-fluid" ></img></div>  :
    <ConfigProvider configJson={configData}>
    <CurrentUserProvider>
      <Sidebar />
     <App1 json={json} cssClasses={cssClasses} activities_json={activities} />
     </CurrentUserProvider>
     </ConfigProvider>
    
    
 )} else  if (layout === 'forecast24') {
    return (
      isLoading ?
      <div><img src="https://www.02ws.co.il/img/logo.png" width="200" alt="logo" className="rounded mx-auto d-block img-fluid" ></img></div>  :
      <ConfigProvider configJson={configData}>
      <CurrentUserProvider>
        <Sidebar />
        <App2 json={json} cssClasses={cssClasses}  activities_json={activities} />
      </CurrentUserProvider>
      </ConfigProvider> 
      
   )}  else  if (layout === 'NextDays'){
    return (
      isLoading ?
      <div><img src="https://www.02ws.co.il/img/logo.png" width="200" alt="logo" className="rounded mx-auto d-block img-fluid" ></img></div>  :
      <ConfigProvider configJson={configData}>
      <CurrentUserProvider>
        <Sidebar />
        <App3 json={json} cssClasses={cssClasses}  activities_json={activities}/>
        </CurrentUserProvider> 
        </ConfigProvider>
      
    )}  else  if (layout === 'External') {
    return (
      isLoading ?
      <div><img src="https://www.02ws.co.il/img/logo.png" width="200" alt="logo" className="rounded mx-auto d-block img-fluid" ></img></div>  :
      <ConfigProvider configJson={configData}>
      <CurrentUserProvider>
        <Sidebar />
        <AppExternal src={src} json={json} cssClasses={cssClasses}  activities_json={activities}/>
        </CurrentUserProvider>
        </ConfigProvider>
      
    )};
  
}

export default App;


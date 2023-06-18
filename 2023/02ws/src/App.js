import './App.css';
import { React, useEffect, useState, useRef } from 'react';
import navValues from './helpers/navValues';
import classNames from "classnames";
import App1 from './components/App1';
import App2 from './components/App2';
import App3 from './components/App3';
import AppExternal from './components/AppExternal';
import {getMainData} from './helpers/Utils';
import Sidebar from './components/Sidebar';


function App({layout, src}) {
  
  const [app_layout, setLayout] = useState([]);
  const [json, setJson] = useState([]);
  const [current, setCurrent] = useState([]);
  const [states, setStates] = useState([]);
  const [nav, setNav] = useState(navValues.home);
  const counter = useRef(0);
  
   useEffect(() =>{
      const fetchJson = async () => {
      const json = await getMainData();
      const current = json.jws.current;
      const states = json.jws.states;
      setJson(json);
      setCurrent(current);
      setStates(states);
      setNav(nav);
      setLayout({layout});
      counter.current++;
      
    };
   fetchJson();
    const timer = setInterval(() => {
      fetchJson();
    }, 60000);
  }, [])


  const cssClasses = classNames ({
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
    <>
      <Sidebar />
     <App1 json={json} cssClasses={cssClasses} />
    </>
    
 )} else  if (layout === 'forecast24') {
    return (
      <>
        <Sidebar />
        <App2 json={json} cssClasses={cssClasses} />
      </>
      
   )}  else  if (layout === 'NextDays'){
    return (
      <>
        <Sidebar />
        <App3 json={json} cssClasses={cssClasses} />
      </>
      
    )}  else  if (layout === 'External') {
    return (
      <>
        <Sidebar />
        <AppExternal src={src} json={json} cssClasses={cssClasses} />
      </>
      
    )};
  
}

export default App;


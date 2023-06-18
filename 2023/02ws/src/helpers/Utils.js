
import { React, useEffect, useState, useRef, classNames } from 'react';

function Utils(){
   const [app_layout, setLayout] = useState([]);
  const [json, setJson] = useState([]);
  const [current, setCurrent] = useState([]);
  const [states, setStates] = useState([]);
  const counter = useRef(0);
    useEffect(() =>{
        var opts = {
          headers: {
           
          }
        }
        const fetchJson = async () => {
          
          const response = await fetch("https://www.02ws.co.il/02wsjson.txt", opts);
          const json = await response.json();
          const current = json.jws.current;;
          const states = json.jws.states;
          setJson(json);
          setCurrent(current);
          setStates(states);
          setLayout("current");
          counter.current++;
          
        };
       fetchJson();
      }, [])
   
}


export async function loader({ params }) {
    const json = await getMainData();
    return { json };
  }

  export async function getCssClasses() {
    const json = await getMainData();
    const current = json.jws.current;;
    const states = json.jws.states;
       
    const cssClasses = classNames ({
    snow: (states.issnowing  === 'true'),
    rain: (states.israining  === 'true'),
    night: (current.issun  === 'false'),
    dust: (current.isdusty === 'true'),
    windy: (current.iswindy === 'true'),
    sunset: (current.issunset === 'true'),
    sunrise: (current.issunrise === 'true')
  
  });
  return cssClasses;
  }


export async function getMainData() {
    const fetchJson = async () => {
        var opts = {
            headers: {
             
            }
          }
        const response = await fetch("https://www.02ws.co.il/02wsjson.txt", opts);
        const json = await response.json();
        return json;
        
      };
      let result = fetchJson();
     return result;
  }


export default Utils;

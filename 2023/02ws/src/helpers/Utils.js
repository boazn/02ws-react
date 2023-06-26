
import {   useRef} from 'react';
import classnames from "classnames";

function Utils(){
  
  const counter = useRef(0);
    
   
}


export async function loader({ params }) {
    const json = await getMainData();
    return { json };
  }

  export async function getCssClasses() {
    const json = await getMainData();
    const current = json.jws.current;;
    const states = json.jws.states;
       
    const cssClasses = classnames ({
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

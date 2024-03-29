
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

  
export async function getActivitiesData() {
  const fetchJson = async () => {
      var opts = {
          headers: {
           
          }
        }
      const response = await fetch("https://www.02ws.co.il/activities.json", opts);
      const json = await response.json();
      return json;
      
    };
    let result = fetchJson();
   return result;
}
export async function getParamsData() {
  const fetchJson = async () => {
      var opts = {
          headers: {
           
          }
        }
      const response = await fetch("https://www.02ws.co.il/parameters.json", opts);
      const json = await response.json();
      return json;
      
    };
    let result = fetchJson();
   return result;
}
export async function getStories() {
  const fetchJson = async () => {
      var opts = {
          headers: {
           
          }
        }
      const response = await fetch("https://www.02ws.co.il/stories.json", opts);
      const json = await response.json();
      return json;
      
    };
    let result = fetchJson();
   return result;
}
export async function getLatestMaxMinTemp() {
  const fetchJson = async () => {
      var opts = {
          headers: {
           
          }
        }
      const response = await fetch("https://www.02ws.co.il/getLatestMaxMinTemp.php", opts);
      const json = await response.json();
      return json;
      
    };
    let result = fetchJson();
   return result;
}
export async function getLatestDailyRain() {
  const fetchJson = async () => {
      var opts = {
          headers: {
           
          }
        }
      const response = await fetch("https://www.02ws.co.il/getLatestDailyRain.php", opts);
      const json = await response.json();
      return json;
      
    };
    let result = fetchJson();
   return result;
}
export async function GetLatestYearsRainForToday() {
  const fetchJson = async () => {
      var opts = {
          headers: {
           
          }
        }
      const response = await fetch("https://www.02ws.co.il/GetLatestYearsRainForToday.php", opts);
      const json = await response.json();
      return json;
      
    };
    let result = fetchJson();
   return result;
}
export async function updateLikesCall(idx, command) {
  const fetchJson = async () => {
    var opts = {
       
        
      }
    const response = await fetch("https://www.02ws.co.il/forecastlikes_service.php?idx=" + idx + "&command=" + command , opts);
    const json = await response.json();
    return json;
    
  };
  let result = fetchJson();
  return result;

}

export async function voteLike(cm_value, gender) {
  const fetchJson = async () => {
      var opts = {
         //mode: 'no-cors',
          headers: {
           
          }
        }
      const response = await fetch("https://www.02ws.co.il/survey.php?SendSurveyButton=1&json_res=1&survey="+cm_value + "&survey_id=2&gender=" + gender , opts);
      const json = await response.json();
      return json;
      
    };
    let result = fetchJson();
   return result;
}

export async function getLatestArchiveData(limit, params, lang) {
  const fetchJson = async () => {
      var opts = {
         //mode: 'no-cors',
          headers: {
           
          }
        }
      const response = await fetch("https://www.02ws.co.il/images/profile1/LatestArchiveJson.php?limit=" + limit + "&params=" + params + "&lang=" + lang , opts);
      const json = await response.json();
      return json;
      
    };
    let result = fetchJson();
   return result;
}

export default Utils;

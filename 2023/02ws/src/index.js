import React from 'react';
import ReactDOM from 'react-dom/client';
import {
  createBrowserRouter,
  RouterProvider,
} from "react-router-dom";
import './index.css';
import App from './App';
import About from './components/About';
import ErrorPage from './pages/error-page';
import reportWebVitals from './reportWebVitals';
import 'bootstrap/dist/css/bootstrap.css';
import './i18n';


const app_layout =  [ "current", "forecast24", "NextDays", "External", "now"];

const router = createBrowserRouter([
      {
        path: "/",
        element: <App layout={app_layout[0]}  />,
        errorElement: <ErrorPage />,
      },
      {
        path: "Now/:nowId",
        element: <App layout="now"/>,
        errorElement: <ErrorPage />,
      },
      {
        path: "Now",
        element: <App layout="now"/>,
        errorElement: <ErrorPage />,
      },
      {
        path: "App1",
        element: <App layout="current" />,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "App2",
        element: <App layout="forecast24"/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "App3",
        element: <App layout="NextDays"/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "AppExternal/:linkID",
        element: <App src="https://www.02ws.co.il/small/?section=graph.php&graph=temp.php&profile=1&lang=1&tempunit=&fullt=&s=&c=" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "AppDynExternal",
        element: <App layout={app_layout[3]} />,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "ForecastAbroad",
        element: <App src="https://www.02ws.co.il/small/?section=forecast/getForecast&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "ForecastIsrael",
        element: <App src="https://www.02ws.co.il/small/?section=forecast/getForecast&region=isr&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "ForecastJob",
        element: <App src="https://www.02ws.co.il/small/?section=ForecasterJob&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Radar",
        element: <App src="https://www.02ws.co.il/small/?section=radar&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Satellite",
        element: <App src="https://www.02ws.co.il/small/?section=graph.php&graph=temp.php&profile=1&lang=1&tempunit=&fullt=&s=&c=" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Rain",
        element: <App src="https://www.02ws.co.il/small/?section=graph&graph=rain.php&profile=1&lang=1&style=" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Runningtreks",
        element: <App src="https://www.02ws.co.il/runningtreks.php?lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "GlobalWarming",
        element: <App src="https://www.02ws.co.il/small/?section=globalwarm&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Average",
        element: <App src="https://www.02ws.co.il/small/?section=averages&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Last2days",
        element: <App src="https://www.02ws.co.il/small/?section=reports/downld02.txt&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "LastWeek",
        element: <App src="https://www.02ws.co.il/small/?section=reports/downld08.txt&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "ThisMonth",
        element: <App src="https://www.02ws.co.il/small/?section=reports/NOAAMO.TXT&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "ChooseMonthYear",
        element: <App src="https://www.02ws.co.il/small/?section=graph.php&graph=temp.php&profile=1&lang=1&tempunit=&fullt=&s=&c=" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "LastMonth",
        element: <App src="https://www.02ws.co.il/small/?section=chooseMonthYear&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Records",
        element: <App src="https://www.02ws.co.il/small/?section=allTimeRecords&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "RainSeasons",
        element: <App src="https://www.02ws.co.il/small/?section=RainSeasons&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "LoveHateForecasts",
        element: <App src="https://www.02ws.co.il/small/?section=forecastDays&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Reports",
        element: <App src="https://www.02ws.co.il/small/?section=reports&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Archive",
        element: <App src="https://www.02ws.co.il/small/?section=browsedate&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Snow",
        element: <App src="https://www.02ws.co.il/small/?section=snow&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Climate",
        element: <App src="https://www.02ws.co.il/small/?section=climate&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "BestSeason",
        element: <App src="https://www.02ws.co.il/small/?section=survey&lang=1&survey_id=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Faq",
        element: <App src="https://www.02ws.co.il/small/?section=faq&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },  
      {
        path: "Tips",
        element: <App src="https://www.02ws.co.il/small/?section=tips&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "About",
        element: <About/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Contact",
        element: <App src="https://www.02ws.co.il/small/?section=SendFeedback&lang=1" layout="External"/>,
        errorElement: <ErrorPage />,
        
      },
      {
        path: "Radiosonde",
        element: <App src="https://www.02ws.co.il/small/?section=radiosonde&lang=1" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        
      }
   
  
   
]);

ReactDOM.createRoot(document.getElementById("root")).render(
 
  <React.StrictMode>
    <RouterProvider router={router} />
  </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();

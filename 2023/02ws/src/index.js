import React from 'react';
import ReactDOM from 'react-dom/client';
import {
  createBrowserRouter,
  RouterProvider,
} from "react-router-dom";
import './index.css';
import App from './App';
import App1 from './components/App1';
import App2 from './components/App3';
import App3 from './components/App3';
import AppExternal from './components/AppExternal';
import Sidebar from './components/Sidebar';
import Now from './components/Now';
import ErrorPage from './pages/error-page';
import reportWebVitals from './reportWebVitals';
import 'bootstrap/dist/css/bootstrap.css';
import './i18n';
import {loader as jsonLoader} from './helpers/Utils';


const app_layout =  [ "current", "forecast24", "NextDays", "External"];

const router = createBrowserRouter([
  {
    path: "/",
    element: <App layout={app_layout[0]} />,
    errorElement: <ErrorPage />,
  },
      {
        path: "Now/:nowId",
        element: <App layout={app_layout[0]}/>,
        errorElement: <ErrorPage />,
      },
      {
        path: "App1",
        element: <App layout="NextDays"/>,
        errorElement: <ErrorPage />,
        loader: jsonLoader,
      },
      {
        path: "App2",
        element: <App layout={app_layout[1]}/>,
        errorElement: <ErrorPage />,
        loader: jsonLoader,
      },
      {
        path: "App3",
        element: <App layout={app_layout[2]}/>,
        errorElement: <ErrorPage />,
        loader: jsonLoader,
      },
      {
        path: "AppExternal/:linkID",
        element: <App src="https://www.02ws.co.il/small/?section=graph.php&graph=temp.php&profile=1&lang=1&tempunit=&fullt=&s=&c=" layout={app_layout[3]}/>,
        errorElement: <ErrorPage />,
        loader: jsonLoader,
      },
   
  
   
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


import { useTranslation } from 'react-i18next';
import {  useEffect, useState } from 'react';
import {getParamsData} from '../helpers/Utils';
import ReactModal  from 'react-modal';
import { useContext } from 'react';
import {ConfigContext} from "../helpers/ConfigContext";
const Now = (props) => {
    
    const [isOpen, setPopupIsOpen] = useState(false);
    const [params_json, setParams] = useState(false);
    const [currentParam, setCurrentParam] = useState(false);
    const [currentTitle, setCurrentTitle] = useState(false);
    const configData = useContext(ConfigContext);
    const { t } = useTranslation();
    const customStyles = {
        content: {
          width:'400px',
          top: '50%',
          left: '50%',
           direction: (configData.lang === 1) ? 'rtl' : '',
          right: 'auto',
          bottom: 'auto',
          marginRight: '-50%',
          transform: 'translate(-50%, -50%)',
        },
      };

      const setIsOpen = ({isOpen}) => {
        
        setPopupIsOpen(isOpen);
      }
      function getParamTitle(activity, lang, prm_json){
        var j;
        if (prm_json.jws === undefined)
            return;
        for (j = 0; j< prm_json.jws.Parameters.length; j++){
            if (prm_json.jws.Parameters[j].name === activity){
                if (lang === 0) {
                    return prm_json.jws.Parameters[j].title0;
                }
                else {
                    return prm_json.jws.Parameters[j].title1;
                }
            }

        }
    }
    function getParamDesc(activity, lang, prm_json){
        var j;
        if (prm_json.jws === undefined)
            return;
        for (j = 0; j< prm_json.jws.Parameters.length; j++){
            if (prm_json.jws.Parameters[j].name === activity){
                if (lang === 0){ 
                     return prm_json.jws.Parameters[j].lang0;
                    }
                    else {
                     return prm_json.jws.Parameters[j].lang1;
                    }
            }

        }
       
     }
    const openDetails = (param) => {
        setCurrentTitle(getParamTitle(param, configData.lang, params_json));
        setCurrentParam(getParamDesc(param, configData.lang, params_json));
        setPopupIsOpen(true);
    }

    function fliterParam(div){
        if (props.all === true){
            return '';
        }
        var params = configData.params;
        if (params.includes(div)){
            return '';
        }  else {
            return 'none';
        }
           
    }
  
    useEffect(() =>{
        const fetchJson = async () => {
        const params = await getParamsData();
        setParams(params);
       
      };
     fetchJson();
      const timer = setInterval(() => {
        fetchJson();
      }, 60000);
    }, [])
    if (props.current === undefined)
        return "loading...";
    return (
          <div id="now" className={"blue_transp_box " + (configData.lang === 1? 'rtl' : '')}>
            
            <div id="tempdivvalue" title="" className="mx-auto">
                {props.current.date1}<br/>
                <div id="temp" title="" className={`mx-auto parambox white_box ${fliterParam('temp')}`} onClick={() => openDetails('ValleyTemp')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/temp2.png" width="72px" height="30px" alt={t("TEMP")} /></div>
                {t("TEMP")} {props.current.temp}°
                </div>
                <div id="temp2" title="" className={`mx-auto parambox white_box ${fliterParam('temp2')}`}  onClick={() => openDetails('Temp')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/temp2.png" width="72px" height="30px" alt={t("TEMP")} /></div>
                {t("TEMP")} {props.current.temp2}°
                </div>
                <div id="temp3" title="" className={`mx-auto parambox white_box ${fliterParam('temp3')}`}  onClick={() => openDetails('RoadTemp')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/temp2.png" width="72px" height="30px" alt={t("TEMP")} /></div>
                {t("TEMP")} {props.current.temp3}°
                </div>
                <div id="hum" title="" className={`mx-auto parambox white_box ${fliterParam('hum')}`}  onClick={() => openDetails('Humidity')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/moist.png" width="72px" height="30px" alt={t("HUMIDITY")} /></div>
                {t("HUMIDITY")} {props.current.hum}%
                </div>
                <div id="windspd" title="" className={`mx-auto parambox white_box ${fliterParam('windspd')}`}  onClick={() => openDetails('Wind')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/wind.png" width="72px" height="30px" alt={t("WIND")} /></div>
                {t("WIND")} {props.current.windspd}k/h {props.current.winddir}
                </div>
                <div id="dew" title="" className={`mx-auto parambox white_box ${fliterParam('dew')}`}  onClick={() => openDetails('DewPoint')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/dewp.png" width="36px" height="30px" alt={t("DEW")} /></div>
                {t("DEW")} {props.current.dew}°
                </div>
                <div id="rain"  title="" className={`mx-auto parambox white_box ${fliterParam('rain')}`}  onClick={() => openDetails('RainChance')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/rain.png" width="72px" height="30px" alt={t("RAIN")} /></div>
                {t("RAIN")} {props.current.rain}mm    
                </div>
                <div id="rad" title="" className={`mx-auto parambox white_box ${fliterParam('rad')}`}  onClick={() => openDetails('Radiation')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/radiation.png" width="72px" height="30px" alt={t("RADIATION")} /></div>
                {t("RADIATION")} {props.current.rad}W/m2    
                </div>
                <div id="uv" title="" className={`mx-auto parambox white_box ${fliterParam('uv')}`}  onClick={() => openDetails('UV')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/uv.png" width="72px" height="30px" alt={t("UV")} /></div>
                {t("UV")} {props.current.uv}
                </div>
                <div id="pm10" title="" className={`mx-auto parambox white_box ${fliterParam('pm10')}`}  onClick={() => openDetails('Dust')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/dust2.png" width="72px" height="30px" alt={t("DUSTPM10")} /></div>
                {t("DUSTPM10")} {props.current.pm10} µg/m3<br/>
                {t("DUSTPM25")} {props.current.pm25} µg/m3
                </div>
                <div id="pressure" title="" className={`mx-auto parambox white_box ${fliterParam('pressure')}`}  onClick={() => openDetails('AirPressure')}>
                <div className="imgbox"><img src="https://www.02ws.co.il/img/temp2.png" width="72px" height="30px" alt={t("BAR")} /></div>
                {t("BAR")} {props.current.pressure} mb
                </div>
                
            </div>
            <div className="" id="itfeels">
     
            </div>
            <div  id="windy">   

            </div>
            <div className="rainpercent">

            </div>
            <ReactModal
            isOpen={isOpen}
            contentLabel="Example Modal"
            style={customStyles}
            onRequestClose={() => setIsOpen(false)}

        >
            <h3>{currentTitle}</h3>
             <div dangerouslySetInnerHTML={{__html: currentParam}}></div>
        </ReactModal>
        </div>
        
    );
}

export default Now; 
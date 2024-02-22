import { useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';
import ReactModal  from 'react-modal';
import { voteLike } from '../helpers/Utils';
import { useContext } from 'react';
import {ConfigContext} from "../helpers/ConfigContext";
import Btn from './Button';
const ColdMeter = (props) => {
  var resultCMVote;
  const { t } = useTranslation();
  const configData = useContext(ConfigContext);
  const callVoteLike = async () => {
    var gender = localStorage.getItem('gender');
    const json = await voteLike(cm_value, gender);
    console.log (json.result.message);
    setCMResult(json.result.message);
    return json.result.message;
 }
  const Vote_cm_like = (cm_value) => {
    console.log(cm_value);
    console.assert(cm_value!="");
    if (cm_value === "")
        return;
    let _data = {
        SendSurveyButton: 1,
        json_res: 1,
        survey: cm_value, 
        survey_id:2
    }
    callVoteLike();
    setIsCMResultOpen(true);
    
  };
  const vote_cm_dislike = () => {
    //alert('vote_cm_dislike');
    setPopupIsOpen(true);
  };
  const [output, setColdMeter] = useState([]);
  const [output_sun, setColdMeterSun] = useState([]);
  const [clothColdMeter, setClothColdMeter] = useState([]);
  const [clothColdMeterSun, setClothColdMeterSun] = useState([]);
  const [coldTitle, setColdTitle] = useState([]);
  const [coldTitleSun, setColdTitleSun] = useState([]);
  const [heatindex, setHeatIndex] = useState([]);
  const [isOpen, setPopupIsOpen] = useState(false);
  const [isCMResultOpen, setIsCMResultOpen] = useState(false);
  const [cm_value, setCMvalue] = useState(false);
  const [cm_value_result, setCMResult] = useState(false);
  const [cm_value_sun, setCMSunvalue] = useState(false);
  const customStyles = {
    content: {
      top: '50%',
      left: '50%',
      right: 'auto',
      direction: (configData.lang === 1) ? 'rtl' : '',
      bottom: 'auto',
      marginRight: '-50%',
      transform: 'translate(-50%, -50%)',
    },
  };
  const setIsOpen = ({isOpen}) => {
    setPopupIsOpen(isOpen);
  }
    useEffect(() =>{
        var opts = {
          headers: {
           
          }
        }
        const fetchJson = async () => {
          
          const response = await fetch(`https://www.02ws.co.il/coldmeter_service.php?lang=${props.lang}&json=1&cloth_type=e`, opts);
          const json = await response.json();
          const clothtitle = json.coldmeter.clothtitle;
          const clothimage = json.coldmeter.cloth_name;
          const asterisk = json.coldmeter.asterisk;
          const coldmeter_title = json.coldmeter.current_feeling;
          const clothtitle_sun = json.coldmeter_sun.clothtitle;
          const clothimage_sun = json.coldmeter_sun.cloth_name;
          const asterisk_sun = json.coldmeter_sun.asterisk;
          const coldmeter_title_sun = json.coldmeter_sun.current_feeling;
          const heatindex = json.coldmeter.heatindex;
          const cm_value = json.coldmeter.current_value;
          const cm_value_sun = json.coldmeter_sun.current_value;
          
          const output = `${clothtitle} ${coldmeter_title} ${asterisk}`;
          const output_sun = `${clothtitle_sun} ${coldmeter_title_sun} ${asterisk_sun}`;
          setColdMeter(output);
          setColdMeterSun(output_sun);
          setClothColdMeter(clothimage);
          setClothColdMeterSun(clothimage_sun);
          setColdTitle(coldmeter_title);
          setColdTitleSun(coldmeter_title_sun);
          setHeatIndex(heatindex);
          console.log ("setCMvalue:" + cm_value);
          setCMvalue(cm_value);
          console.log ("setCMSunvalue:" + cm_value_sun);
          setCMSunvalue(cm_value_sun);
        };
       fetchJson();

        const timer = setInterval(() => {
          fetchJson();
        }, 60000);
      }, [])
    
    return (
      
        <div  id="coldmeter" className="white_transp_box">
        <div id="heatindex">
            {heatindex}
        </div>
        <div id="itfeels_title"></div>
        <div id="shadow_sun_wrapper">
        {(props.showShadow) ?          
        <div className="shade" >
        
        <div className="inlineGrid">
        <a href="WhatToWear.php#tshirt" className="info"> 
        <span id="current_feeling_link">
            <img src={`https://www.02ws.co.il/images/clothes/${clothColdMeter}`} height="80" alt="cold meter"  /><br/>{coldTitle}<br/>
        </span>
        <span className="info">{output}</span>
        </a>
        <div className="cm_dislike"> <img onClick={() => vote_cm_dislike()} src="https://www.02ws.co.il/images/icons/cm_dislike.svg" width="50" height="50" alt="" /></div>
        <div className="cm_like"><img onClick={() => Vote_cm_like(cm_value)} src="https://www.02ws.co.il/images/icons/cm_like.svg" width="50" height="50" alt="" /></div>
        <div id="cm_shadow_result" ><div id="cm_shadow_result_msg"></div></div>
        
        </div> 
        
        </div> : ''
        }
         {(props.issun === 'true')&&(props.showSun) ? 
          <div className="sun" >
          
          <div className="inlineGrid">
          <a href="WhatToWear.php#tshirt" className="info">  
          <span id="current_feeling_link">
            <img src={`https://www.02ws.co.il/images/clothes/${clothColdMeterSun}`} height="80" alt="cold meter"  /><br/>{coldTitleSun}<br/>
          </span>
          <span className="info">{output_sun}</span>
          </a>
          <div className="cm_dislike"> <img onClick={() => vote_cm_dislike()} src="https://www.02ws.co.il/images/icons/cm_dislike.svg" width="50" height="50" alt="" /></div>
          <div className="cm_like"><img onClick={() => Vote_cm_like(cm_value_sun)} src="https://www.02ws.co.il/images/icons/cm_like.svg" width="50" height="50" alt="" /></div>
          <div id="cm_sun_result" ><div id="cm_sun_result_msg"></div></div>
          </div>
          </div> : ''
        }
        </div>
        
        
        <ReactModal
        className=""
        isOpen={isOpen}
        contentLabel="Example Modal"
        style={customStyles}
        onRequestClose={() => setIsOpen(false)}
      >
         <Btn btnOnClick={() => setIsOpen(false)} btnTitleText={""}  img={"X"}>
                 
          </Btn>
         <iframe src="https://www.02ws.co.il/small/?section=survey.php&amp;survey_id=2&amp;"  sandbox='allow-scripts allow-modal allow-forms allow-same-origin' scrolling="no" loading='eager' title="iframePopup" ></iframe>
      </ReactModal>

      <ReactModal
        className=""
        isOpen={isCMResultOpen}
        ariaHideApp={false}
        contentLabel="מדד הקור"
        style={customStyles}
        onRequestClose={() => setIsCMResultOpen(false)}
      >
        <Btn btnOnClick={() => setIsCMResultOpen(false)} btnTitleText={""}  img={"X"}>
                 
                 </Btn>
        <h4>הצבעה למדד הקור</h4>
         {cm_value_result}
      </ReactModal>
       
         
        </div>
        
    );
}

export default ColdMeter; 
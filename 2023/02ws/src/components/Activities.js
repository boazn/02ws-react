import ReactModal  from 'react-modal';
import { useState } from 'react';
import { useContext } from 'react';
import {ConfigContext} from "../helpers/ConfigContext";
import { useTranslation } from 'react-i18next';
import Btn from './Button';
const Activities = (props) => {
    const [isOpen, setPopupIsOpen] = useState(false);
    const [currentActivity, setCurrentActivity] = useState(false);
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
    

    function getActivityTitle(activity, lang, act_json, good, not_good){
        var j;
        if (act_json.jws === undefined)
            return;
        var pref = (activity.value == 1) ? good : not_good;
        for (j = 0; j< act_json.jws.Activities.length; j++){
            if (act_json.jws.Activities[j].name === activity.activity){
                if (lang === 0) {
                    return  pref + act_json.jws.Activities[j].title0;
                }
                else {
                    return pref + act_json.jws.Activities[j].title1;
                }
            }

        }
    }
    function getActivityDesc(activity, lang, act_json){
        var j;
        if (act_json.jws === undefined)
            return;
        
        for (j = 0; j< act_json.jws.Activities.length; j++){
            if (act_json.jws.Activities[j].name === activity.activity){
                if (lang === 0){ 
                     return  activity.sig0 + '<br /> ' + act_json.jws.Activities[j].lang0;
                    }
                    else {
                     return  activity.sig1 + '<br />  ' + act_json.jws.Activities[j].lang1;
                    }
            }

        }
       
     }
    const setIsOpen = ({isOpen}) => {
        
        setPopupIsOpen(isOpen);
      }
    const openDetails = (activity, good, not_good) => {
        setCurrentTitle(getActivityTitle(activity, props.lang, props.activities_json.activities, good, not_good));
        setCurrentActivity(getActivityDesc(activity, props.lang, props.activities_json.activities));
        setPopupIsOpen(true);
    }
    return (
        <div className={"white_box " + (props.lang === 1? 'rtl textright' : 'textleft')}> {t("GOOD_TIME_FOR")}
        {props.activities.map((activity, i) => {
        return activity.value == 1 ? <div className="blue_transp_box inline activity" key={i}>
                <a href="javascript:void(0)" className="info">
                <img onClick={() => openDetails(activity, t("GOOD_TIME_FOR"), t("NOT_GOOD_TIME_FOR"))} src={`https://www.02ws.co.il/images/activities/${activity.activity.toString().toLowerCase()}.png`} height="25" width="25" alt="something" ></img> 
                    <span className="info">{getActivityTitle(activity, props.lang, props.activities_json.activities, t("GOOD_TIME_FOR"), t("NOT_GOOD_TIME_FOR"))}</span>
                </a>
                
               
            
           
            </div>: ''
        
        })}<br/>
        {t("NOT_GOOD_TIME_FOR")}
        {props.activities.map((activity, i) => {
        return activity.value == 0 ? <div className="blue_transp_box inline activity" key={i}>
            
                <img onClick={() => openDetails(activity, t("GOOD_TIME_FOR"), t("NOT_GOOD_TIME_FOR"))} src={`https://www.02ws.co.il/images/activities/${activity.activity.toString().toLowerCase()}.png`} height="25" width="25" alt="something" ></img> 
               
            
           
            </div> : ''
        
        })}
        <ReactModal
        
        isOpen={isOpen}
        contentLabel="Example Modal"
        style={customStyles}
        onRequestClose={() => setIsOpen(false)}

      >
         <Btn btnOnClick={() => setIsOpen(false)} btnTitleText={""}  img={"X"}>
                
        </Btn>
        <h3>{currentTitle}</h3>
        <div dangerouslySetInnerHTML={{__html:currentActivity}}></div>
         <br/><br/><br/>
         <Btn btnOnClick={() => setIsOpen(false)} btnTitleText={"Ok"} >
                
        </Btn>
      </ReactModal>
    </div>
    );
}

export default Activities; 
import Btn from './Button';
import ReactModal  from 'react-modal';
import { useState } from 'react';
const Activities = (props) => {
    const [isOpen, setPopupIsOpen] = useState(false);
    const [currentActivity, setCurrentActivity] = useState(false);
    const [currentTitle, setCurrentTitle] = useState(false);
    
    const customStyles = {
        content: {
          width:'400px',
          top: '50%',
          left: '50%',
          right: 'auto',
          bottom: 'auto',
          marginRight: '-50%',
          transform: 'translate(-50%, -50%)',
        },
      };
    

    function getActivityTitle(activity, lang, act_json){
        var j;
        if (act_json.jws === undefined)
            return;
        for (j = 0; j< act_json.jws.Activities.length; j++){
            if (act_json.jws.Activities[j].name === activity){
                if (lang === 0) {
                    return act_json.jws.Activities[j].title0;
                }
                else {
                    return act_json.jws.Activities[j].title1;
                }
            }

        }
    }
    function getActivityDesc(activity, lang, act_json){
        var j;
        if (act_json.jws === undefined)
            return;
        for (j = 0; j< act_json.jws.Activities.length; j++){
            if (act_json.jws.Activities[j].name === activity){
                if (lang === 0){ 
                     return act_json.jws.Activities[j].lang0;
                    }
                    else {
                     return act_json.jws.Activities[j].lang1;
                    }
            }

        }
       
     }
    const setIsOpen = ({isOpen}) => {
        
        setPopupIsOpen(isOpen);
      }
    const openDetails = (activity) => {
        setCurrentTitle(getActivityTitle(activity.activity, props.lang, props.activities_json.activities));
        setCurrentActivity(getActivityDesc(activity.activity, props.lang, props.activities_json.activities));
        setPopupIsOpen(true);
    }
    return (
        <div className="white_transp_box">
        {props.activities.map((activity, i) => {
        return <div className="white_box inline activity" key={i}>
            
                <img onClick={() => openDetails(activity)} src={`https://www.02ws.co.il/images/activities/${activity.activity.toString().toLowerCase()}.png`} height="30" width="30" alt="something" ></img> 
               
            
           
            </div>
        
        })}
        <ReactModal
        isOpen={isOpen}
        contentLabel="Example Modal"
        style={customStyles}
        onRequestClose={() => setIsOpen(false)}

      >
        <h3>{currentTitle}</h3>
         {currentActivity}
      </ReactModal>
    </div>
    );
}

export default Activities; 
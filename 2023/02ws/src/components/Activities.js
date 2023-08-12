import Btn from './Button';
import ReactModal  from 'react-modal';
import { useState } from 'react';
const Activities = (props) => {
    const [isOpen, setPopupIsOpen] = useState(false);
    const [currentActivity, setCurrentActivity] = useState(false);
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
    function getActivityTitle(activity, lang){
        return activity;
    }
    const setIsOpen = ({isOpen}) => {
        
        setPopupIsOpen(isOpen);
      }
    const openDetails = (activity) => {
        
    }
    return (
        <div className="white_transp_box">
        {props.activities.map((activity, i) => {
        return <div className="white_box inline" key={i}>
            
            <img onClick={openDetails(activity)} src={`https://www.02ws.co.il/images/activities/${activity.activity.toString().toLowerCase()}.png`} height="30" width="30" alt={getActivityTitle(activity.activity, props.lang)} ></img> 
           
            </div>
        
        })}
        <ReactModal
        isOpen={isOpen}
        contentLabel="Example Modal"
        style={customStyles}
        onRequestClose={() => setIsOpen(false)}

      >
         {currentActivity}
      </ReactModal>
    </div>
    );
}

export default Activities; 
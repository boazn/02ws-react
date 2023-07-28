import Button from 'react-bootstrap/Button';

const Activities = (props) => {

    function getActivityTitle(activity, lang){
        return activity;
    }

    return (
        <div>
        {props.activities.map((activity, i) => {
        return <div class="white_box inline" key={i}>
            <img src={`https://www.02ws.co.il/images/activities/${activity.activity.toString().toLowerCase()}.png`} height="30" width="30" alt={getActivityTitle(activity.activity, props.lang)} ></img> 
            </div>
        
        })}
    </div>
    );
}

export default Activities; 
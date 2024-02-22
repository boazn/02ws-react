import ForecastDay from './ForecastDay';

const NextDays = (props) => {
    
    return (
    
    <ul id="forcast_days">
        {props.days.map((day, i) => {
             return <ForecastDay key={i} a_key={i} className="white_box" {...day} lang={props.lang} yest={props.yest} activities_json={props.activities_json}></ForecastDay>;
          })}
    </ul>
    );
}

export default NextDays; 
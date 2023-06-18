import ForecastDay from './ForecastDay';

const NextDays = (props) => {
   
    return (
    
    <ul id="forcast_days">
        {props.days.map((day, i) => {
             return <ForecastDay key={i} className="white_box" {...day} lang={props.lang} ></ForecastDay>;
          })}
    </ul>
    );
}

export default NextDays; 
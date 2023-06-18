import ForecastHour from './ForecastHour';

const Forecast24h = (props) => {
  
    return (
        <div id="graph_forcast" class="metric-chart h-bar-chart" className={" " + (props.lang === 1? 'rtl' : '')}>
             			
        <ul id="forcast_hours" class="for24_graph_ng x-axis-bar-list count-10">
        {props.hours.map((hour, i) => {
              return <ForecastHour key={i} {...hour} lang={props.lang} ></ForecastHour>;
          })}
        </ul>
        </div>
    );
}

export default Forecast24h; 
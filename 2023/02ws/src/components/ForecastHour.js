

const ForecastHour = (props) => {
    return (
        <li className="x-axis-bar-item">
            <div className="x-axis-bar-item-container" >
                <div className="x-axis-bar primary" style={{'height': '100%'}}>{props.time}:00</div>
                <div className="x-axis-bar tertiary icon" style={{'height': '85%'}}>
                <img src={`https://www.02ws.co.il/images/icons/day/${props.icon}`} height="30" width="35" alt="n4_partlycloudy.svg" />
                </div>
                <div className="x-axis-bar secondaryalt  temp" style={{'height': '42.666666666666668%'}}>
                    <span className="span-value" data-value="{props.temp}° {props.hum}%">{props.temp}<div className="paramunit">°</div></span>
                </div>
                <div className="x-axis-bar tertiary cloth icon " style={{'height': '19.666666666666668%'}}>
                    <span className="span-value " data-value="שכבה דקה, ארוכה או קצרה, תלוי במשתמש, אפשר גם לשלב" >
                    <img  src={`https://www.02ws.co.il/${props.cloth}`} height="30" width="30" alt="" />
                    </span>
                </div>
                <div className="x-axis-bar tertiary humidity" style={{'height': '60%'}}>
                    
                </div>
            </div>
        </li>
      );
}

export default ForecastHour; 
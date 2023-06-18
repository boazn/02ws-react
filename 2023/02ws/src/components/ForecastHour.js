

const ForecastHour = (props) => {
    return (
        <li class="x-axis-bar-item">
            <div class="x-axis-bar-item-container" >
                <div class="x-axis-bar primary" style={{'height': '100%'}}>{props.time}:00</div>
                <div class="x-axis-bar tertiary icon" style={{'height': '85%'}}>
                <img style={{'vertical-align': 'middle'}} src={`https://www.02ws.co.il/images/icons/day/${props.icon}`} height="30" width="35" alt="n4_partlycloudy.svg" />
                </div>
                <div class="x-axis-bar secondaryalt  temp" style={{'height': '42.666666666666668%'}}>
                    <span class="span-value" data-value="{props.temp}° {props.hum}%">{props.temp}<div class="paramunit">°</div></span>
                </div>
                <div class="x-axis-bar tertiary cloth icon " style={{'height': '19.666666666666668%'}}>
                    <span class="span-value " data-value="שכבה דקה, ארוכה או קצרה, תלוי במשתמש, אפשר גם לשלב" >
                    <img style={{'vertical-align': 'middle'}} src={`https://www.02ws.co.il/${props.cloth}`} height="30" width="30" alt="" />
                    </span>
                </div>
                <div class="x-axis-bar tertiary humidity" style={{'height': '60%'}}>
                    <span class="span-value" data-value="לחות">{props.hum}%</span>
                </div>
            </div>
        </li>
      );
}

export default ForecastHour; 
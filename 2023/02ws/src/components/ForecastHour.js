

const ForecastHour = (props) => {
    return (
        <li className={"x-axis-bar-item " + (props.vertical == true ? "vertical": "")}>
            <div className="x-axis-bar-item-container" >
                <div className="x-axis-bar primary">{props.time}:00</div>
                <div className="x-axis-bar tertiary icon">
                <img src={`https://www.02ws.co.il/images/icons/day/${props.icon}`} height="30" width="35" alt="n4_partlycloudy.svg" />
                </div>
                {props.isTemp &&
                    <div className="x-axis-bar secondaryalt  temp">
                    <span className="span-value" data-value={`${props.temp}° ${props.hum}%`}>{props.temp}<div className="paramunit">°</div></span>
                    </div>
                }
                
                {props.isCloth &&
                    <div className="x-axis-bar tertiary cloth " >
                        <span className="span-value " data-value="שכבה דקה, ארוכה או קצרה, תלוי במשתמש, אפשר גם לשלב" >
                        <img  src={`https://www.02ws.co.il/${props.cloth}`} height="30" width="30" alt="" />
                        </span>
                    </div>
                    
                }
                {props.isHumidity && 
                    <div className="x-axis-bar tertiary humidity" >
                        <span class="span-value" data-value="לחות">{props.hum}%</span>
                    </div>
                }
                {props.isRainrate && 
                    <div className="x-axis-bar tertiary rain" style={{'height': '${props.rainrate}%'}}>
                        <span class="span-value" data-value="גשם">{props.rain}%</span>
                    </div>
                }
                {props.isText && 
                    <div className="x-axis-bar tertiary text" >
                        {eval(`props.title${props.lang}`)}
                    </div>
                }
                
            </div>
        </li>
      );
}

export default ForecastHour; 
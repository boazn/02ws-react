import decodeUriComponent from 'decode-uri-component';

const Notifications = (props) => {
    
    var latestalert_title = eval(`props.notifications.latestalert_title${props.lang}`);
    let latestalert = decodeUriComponent(eval(`props.notifications.latestalert${props.lang}`)).replace(/\+/g, ' ');
    let detailedForecast_title = decodeUriComponent(eval(`props.notifications.detailedforecast_title${props.lang}`)).replace(/\+/g, ' ');
    let detailedForecast = decodeUriComponent(eval(`props.notifications.detailedforecast${props.lang}`)).replace(/\+/g, ' ').replace(/(\r\n|\r|\n)/g, '<br/>');
    return (
        <div className="now_messages">       
        <div id="alerts" className="span7 offset3 white_box">
           <div id="alerts_app_promo"></div>
            <div id="message" className={"box_text " + (props.lang === 1? 'rtl' : '')}>
                <h4>{latestalert_title}</h4>
                {props.notifications.latestalerttype} ttl:{props.notifications.latestalertttl}  passedts:{props.notifications.passedts}
                {props.notifications.timelatestalert1}<br/>
                <div dangerouslySetInnerHTML={{__html: latestalert}}></div>
                <br/>
                <h4>{detailedForecast_title}</h4>
                {props.notifications.timeforecast1}<br/>
                <div dangerouslySetInnerHTML={{__html: detailedForecast}}></div>
                
              

            </div>
            <p id="personal_message" className="box_text"></p>
            <p id="alertachive_href" className="box_text">
                
            </p>
                   
        </div>
     
    </div>
    );
}

export default Notifications; 
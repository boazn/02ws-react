import decodeUriComponent from 'decode-uri-component';

const Notifications = (props) => {
    var latestalertprop = `props.notifications.latestalert${props.lang}`;
    let latestalert = decodeUriComponent(`${props.notifications.latestalert1}`).replace(/\+/g, ' ');
    let detailedForecast_title = decodeUriComponent(`${props.notifications.detailedforecast_title1}`).replace(/\+/g, ' ');
    let detailedForecast = decodeUriComponent(`${props.notifications.detailedforecast1}`).replace(/\+/g, ' ');
    return (
        <div class="now_messages">       
        <div id="alerts" class="span7 offset3 white_box">
           <div id="alerts_app_promo"></div>
            <div id="message" className={"box_text " + (props.lang === 1? 'rtl' : '')}>
                <h4>{props.notifications.latestalert_title1}</h4>
                {props.notifications.timelatestalert1}<br/>
                {latestalert}<br/><br/><br/>
                <h4>{detailedForecast_title}</h4>
                {props.notifications.timeforecast1}<br/>
                {detailedForecast}
              

            </div>
            <p id="personal_message" class="box_text"></p>
            <p id="alertachive_href" class="box_text">
                
            </p>
                   
        </div>
     
    </div>
    );
}

export default Notifications; 
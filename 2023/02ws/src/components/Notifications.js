import decodeUriComponent from 'decode-uri-component';
import Ad from './Ad';

const Notifications = (props) => {
    
    return (
        <div className="now_messages">       
        <div id="alerts" className={"span7 offset3 white_box " + (props.lang === 1? 'rtl' : '')} >
        {props.notifications.alerts.map((alert, i) => {
        return  (
                <div className="white_box inline alert" key={i}  a_key={i}>
                 <h4>{ decodeUriComponent(eval(`alert.title${props.lang}`)).replace(/\+/g, ' ')}</h4>
                 {new Intl.DateTimeFormat('he-IS', {year: 'numeric', month: '2-digit',day: '2-digit', hour: '2-digit', minute: '2-digit'}).format(alert.ts* 1000)} <br/>
                 
                <div dangerouslySetInnerHTML={{__html: decodeUriComponent(eval(`alert.desc${props.lang}`)).replace(/\+/g, ' ').replace(/(\r\n|\r|\n)/g, '<br/>')}}></div>
                <Ad />
            </div>
        )
            
        
        })} 
      </div>
    </div>
    );
}

export default Notifications; 
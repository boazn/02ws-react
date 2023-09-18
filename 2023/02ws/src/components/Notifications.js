import decodeUriComponent from 'decode-uri-component';
import Ad from './Ad';
import ReactModal  from 'react-modal';
import { useState } from 'react';
import Btn from './Button';
import External from './Extrenal';
import { useTranslation } from 'react-i18next';

const Notifications = (props) => {
    const [isOpen, setPopupIsOpen] = useState(false);
    const { t } = useTranslation();
    const toggleOpen = () => {
        
        setPopupIsOpen(!isOpen);
      }
      const customStyles = {
        content: {
          width:'400px',
          top: '0',
          left: '0',
          direction: (props.lang === 1) ? 'rtl' : '',
          right: 'auto',
          bottom: '0',
          position: 'absolute',
          marginRight: '',
          transform: '',
        },
      };
    return (
        <div className="now_messages">       
        <div id="alerts" className={"span7 offset3 white_box " + (props.lang === 1? 'rtl textright' : 'textleft')} >
        {props.notifications.alerts.map((alert, i) => {
          var isVideo = (alert.img_src.indexOf("mp4") > 0);
          var isImg = ((alert.img_src !== "") && (alert.img_src.indexOf("mp4") < 0));
        return  (
                <div className="white_box inline alert" key={i}  a_key={i}>
                 <h4>{ decodeUriComponent(eval(`alert.title${props.lang}`)).replace(/\+/g, ' ')}</h4>
                 {new Intl.DateTimeFormat('he-IS', {year: 'numeric', month: '2-digit',day: '2-digit', hour: '2-digit', minute: '2-digit'}).format(alert.ts* 1000)} <br/>
                 { isImg && <img src={alert.img_src} width="320" alt="" />}
                 { isVideo && <video width="310" height="240" controls><source src={alert.img_src} type="video/mp4" /></video>}                 
                <div dangerouslySetInnerHTML={{__html: decodeUriComponent(eval(`alert.desc${props.lang}`)).replace(/\+/g, ' ').replace(/(\r\n|\r|\n)/g, '<br/>')}}></div>
                <Ad />
            </div>
        )
            
        
        })}
         <Btn btnOnClick={() => toggleOpen(true)} btnTitleText={t("CHAT_TITLE")}  img={""}>
                
          </Btn> 
      </div>
      <ReactModal
        
        isOpen={isOpen}
        contentLabel="Example Modal"
        style={customStyles}
        onRequestClose={() => toggleOpen(false)}

      >
         <Btn btnOnClick={() => toggleOpen(false)} btnTitleText={""}  img={"X"}>
                
        </Btn>
        <div className="sidepopup">
        <External src={"https://www.02ws.co.il/small/?section=chatmobile.php&lang=" + props.lang} width="350" height="95%" className={props.cssClasses}/>
        </div>
      </ReactModal>
    </div>
    );
}

export default Notifications; 
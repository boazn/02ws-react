
import { Link } from "react-router-dom";
import ExternalContext from "../helpers/ExternalContext";
import { useContext, useState } from "react";
import Btn from './Button';
import External from './Extrenal';
import { useTranslation } from 'react-i18next';
import ReactModal  from 'react-modal';
import reactStringReplace from 'react-string-replace';
const Statuses = (props) => {
    let target  = useContext(ExternalContext);
    const [isOpen, setPopupIsOpen] = useState(false);
    const [url, setUrl] = useState(false);
    const { t } = useTranslation();
    
    const toggleOpen = (url) => {
        
        const url_cor = reactStringReplace(url, '&amp;', (match, i) => (
            '&'
          ));
        setUrl(url_cor.join(''));
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
        <>
        <ul id="more_sigweather" className={"box_text " + (props.lang === 1? 'rtl textright' : 'textleft')}>
            <li>
            <ul id="sigweather" className="white_transp_box">
                    {props.statuses.map((status, i) => {
                        const title = eval(`status.sigtitle${props.lang}`);
                        const ext = eval(`status.sigext${props.lang}`);
                    return <li key={i}>
                            {title} - {ext} &nbsp;
                            <Btn btnOnClick={() => toggleOpen(status.url)}  img={"ArrowLeft"}>
                             </Btn> 
                        </li>;
                })}
                
            </ul>
            </li>
        </ul>
         <ReactModal
        
         isOpen={isOpen}
         contentLabel="Example Modal"
         style={customStyles}
         onRequestClose={() => toggleOpen(false)}
 
       >
          <Btn btnOnClick={() => toggleOpen(false)} btnTitleText={""}  img={"X"}>
                 
         </Btn>
         <External src={`https://www.02ws.co.il/small/${url}`} width="350" height="95%" className={props.cssClasses}/>
 
       </ReactModal>
       </>
    );
}

export default Statuses; 
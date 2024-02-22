import decodeUriComponent from 'decode-uri-component';
import Ad from './Ad';
import ReactModal  from 'react-modal';
import { useEffect, useState } from 'react';
import Btn from './Button';
import External from './Extrenal';
import { useTranslation } from 'react-i18next';
import {getStories} from '../helpers/Utils';

const CurrentStory = (props) => {
    const [isOpen, setPopupIsOpen] = useState(false);
    const [stories, setStories] = useState([]);
    const { t } = useTranslation();
    
      useEffect(() =>{
        const fetchStories = async () => {
          const stories_str = await getStories();
          console.log("stories: " + stories_str);
          setStories(stories_str.jws.Stories);
      };
     fetchStories();
   }, [])
  if (props.lang === undefined)
      return "loading...";
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
        (stories == "") ? 'loading stories' :
        <div className="now_messages">       
        <div id="stories" className={"span7 offset3 white_box " + (props.lang === 1? 'rtl textright' : 'textleft')} >
        {stories.map((story, i) => {
          var isVideo = (eval(`story.img_src${props.lang}`).indexOf("mp4") > 0);
          var isImg = ((eval(`story.img_src${props.lang}`) !== "") && (eval(`story.img_src${props.lang}`).indexOf("mp4") < 0));
        return  (
                <div className="white_box inline story" key={i}  a_key={i}>
                 <h4>{ decodeUriComponent(eval(`story.Title${props.lang}`)).replace(/\+/g, ' ')}</h4>
                 { isImg && <img src={eval(`story.img_src${props.lang}`)} width="320" alt="" />}
                 { isVideo && <video width="310" height="240" controls><source src={eval(`story.img_src${props.lang}`)} type="video/mp4" /></video>}                 
                <div dangerouslySetInnerHTML={{__html: decodeUriComponent(eval(`story.Description${props.lang}`)).replace(/\+/g, ' ').replace(/(\r\n|\r|\n)/g, '<br/>')}}></div>
               
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

export default CurrentStory; 
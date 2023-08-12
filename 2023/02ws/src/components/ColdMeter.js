import { useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';
import ReactModal  from 'react-modal';
const ColdMeter = (props) => {
  const { t } = useTranslation();
  const vote_cm_like = () => {
    alert('vote_cm_like');
  };
  const vote_cm_dislike = () => {
    //alert('vote_cm_dislike');
    setPopupIsOpen(true);
  };
  const [output, setColdMeter] = useState([]);
  const [output_sun, setColdMeterSun] = useState([]);
  const [clothColdMeter, setClothColdMeter] = useState([]);
  const [clothColdMeterSun, setClothColdMeterSun] = useState([]);
  const [coldTitle, setColdTitle] = useState([]);
  const [coldTitleSun, setColdTitleSun] = useState([]);
  const [heatindex, setHeatIndex] = useState([]);
  const [isOpen, setPopupIsOpen] = useState(false);
  const customStyles = {
    content: {
      width:'400px',
      top: '50%',
      left: '50%',
      right: 'auto',
      bottom: 'auto',
      marginRight: '-50%',
      transform: 'translate(-50%, -50%)',
    },
  };
  const setIsOpen = ({isOpen}) => {
    setPopupIsOpen(isOpen);
  }
    useEffect(() =>{
        var opts = {
          headers: {
           
          }
        }
        const fetchJson = async () => {
          
          const response = await fetch(`https://www.02ws.co.il/coldmeter_service.php?lang=${props.lang}&json=1&cloth_type=e`, opts);
          const json = await response.json();
          const clothtitle = json.coldmeter.clothtitle;
          const clothimage = json.coldmeter.cloth_name;
          const asterisk = json.coldmeter.asterisk;
          const coldmeter_title = json.coldmeter.current_feeling;
          const clothtitle_sun = json.coldmeter_sun.clothtitle;
          const clothimage_sun = json.coldmeter_sun.cloth_name;
          const asterisk_sun = json.coldmeter_sun.asterisk;
          const coldmeter_title_sun = json.coldmeter_sun.current_feeling;
          const heatindex = json.coldmeter.heatindex;
          //const output = `<a href="javascript:void(0)" class="info currentcloth" ><span class="info">${clothtitle}</span><img src="images/clothes/${clothimage}" height=100" style="vertical-align: middle" /></a><a class="info" id="coldmetertitle" href="javascript:void(0)" ><span class="info" style="cursor: default;" onclick="redirect('https://www.02ws.co.il?section=survey.php&amp;survey_id=2&amp;lang=1&amp;email=')">לא מסכימים? הצביעו!</span>${coldmeter_title}</a>${asterisk} </div>`;
          const output = `${clothtitle} ${coldmeter_title} ${asterisk}`;
          const output_sun = `${clothtitle_sun} ${coldmeter_title_sun} ${asterisk_sun}`;
          setColdMeter(output);
          setColdMeterSun(output_sun)
          setClothColdMeter(clothimage);
          setClothColdMeterSun(clothimage_sun);
          setColdTitle(coldmeter_title);
          setColdTitleSun(coldmeter_title_sun);
          setHeatIndex(heatindex);
        };
       fetchJson();

        const timer = setInterval(() => {
          fetchJson();
        }, 60000);
      }, [])
    
    return (
      
        <div  id="coldmeter" className="white_transp_box">
        <div id="heatindex">
            {heatindex}
        </div>
        <div id="itfeels_title">{t("it_feels")}</div>
        <div id="shadow_sun_wrapper">         
        <div className="shadow" >
        <h4 >צל {props.shadowtemp}°</h4>
        <div className="inlineGrid"> 
        <span id="current_feeling_link">
            <img src={`https://www.02ws.co.il/images/clothes/${clothColdMeter}`} height="80" alt="cold meter"  /><br/>{coldTitle}<br/>
        </span>
        <div id="cm_dislike"> <img onClick={vote_cm_dislike} src="https://www.02ws.co.il/images/icons/cm_dislike.svg" width="50" height="50" alt="" /></div>
        <div id="cm_like"><img onClick={vote_cm_like} src="https://www.02ws.co.il/images/icons/cm_like.svg" width="50" height="50" alt="" /></div>
        <div id="cm_shadow_result" ><div id="cm_shadow_result_msg"></div></div>
        </div> 
        {output}
        </div>
         {(props.issun === 'true') ? 
          <div className="sun" >
          <h4>שמש {props.suntemp}°</h4>
          <div className="inlineGrid"> 
          <span id="current_feeling_link"><img src={`https://www.02ws.co.il/images/clothes/${clothColdMeterSun}`} height="80" alt="cold meter"  /><br/>{coldTitleSun}<br/></span>
          <div id="cm_dislike"> <img onClick={vote_cm_dislike} src="https://www.02ws.co.il/images/icons/cm_dislike.svg" width="50" height="50" alt="" /></div>
          <div id="cm_like"><img onClick={vote_cm_like} src="https://www.02ws.co.il/images/icons/cm_like.svg" width="50" height="50" alt="" /></div>
          <div id="cm_sun_result" ><div id="cm_sun_result_msg"></div></div>
          </div>
          {output_sun}
          </div> : ''
        }
        </div>
        
        
        <ReactModal
        isOpen={isOpen}
        contentLabel="Example Modal"
        style={customStyles}
        onRequestClose={() => setIsOpen(false)}
      >
         <iframe src="https://www.02ws.co.il/small/?section=survey.php&amp;survey_id=2&amp;" width={320} height={600} sandbox='allow-scripts allow-modal' loading='eager' title="iframePopup"></iframe>
      </ReactModal>
       
         
        </div>
        
    );
}

export default ColdMeter; 
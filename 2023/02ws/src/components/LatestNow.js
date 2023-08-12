
import { useTranslation } from 'react-i18next';
import ColdMeter  from './ColdMeter';
const LatestNow = (props) => {
    const { t } = useTranslation();
    if (props.current === undefined)
        return "loading...";
    return (
          <div id="latestnow" className={" " + (props.lang === 1? 'rtl' : '')}>
            {props.current.date1}<br/>
                <div title="" className="mx-auto parambox white_box">
                <div className="imgbox"><img src="https://www.02ws.co.il/img/temp2.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("temp")} {props.current.temp}°
                <div  id="windy">   
                    <div dangerouslySetInnerHTML={{__html: props.windstatus.lang1}}></div>
                </div>
                </div>
            <div className="" id="itfeels">
               
            </div>
            
            <div className="rainpercent">
            {(props.current.rainchance > 0 ? props.current.rainchance + "%": '')}
            </div>
            <ColdMeter  lang={props.lang} shadowtemp={props.feelslike.avg} suntemp={props.current.thsw} issun={props.current.issun}/>
        </div>      
        
    );
}

export default LatestNow; 
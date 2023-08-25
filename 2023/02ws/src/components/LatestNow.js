
import { useTranslation } from 'react-i18next';
import ColdMeter  from './ColdMeter';
import { Link } from "react-router-dom";
const LatestNow = (props) => {
    const { t } = useTranslation();
    if (props.current === undefined)
        return "loading...";
    return (
          <div id="latestnow" className={"white_transp_box " + (props.lang === 1? 'rtl' : '')}>
            {eval(`props.current.date${props.lang}`)}<br/>
                <div title="" className="mx-auto parambox white_box">
                <Link to={`/Now`}  >{props.current.temp}°</Link>
                 
                <div  id="windy">   
                    <div dangerouslySetInnerHTML={{__html: props.windstatus.lang1}}></div>
                </div>
                </div>
            <div className="" id="itfeels">
            {t("IT_FEELS")} <br/>{props.feelslike.avg}°
            </div>
            
            <div className="rainpercent">
            {(props.current.rainchance > 0 ? props.current.rainchance + "%": '')}
            </div>
            <ColdMeter  lang={props.lang} shadowtemp={props.feelslike.avg} suntemp={props.current.thsw} issun={props.current.issun}/>
        </div>      
        
    );
}

export default LatestNow; 
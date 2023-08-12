
import { useTranslation } from 'react-i18next';
const Now = (props) => {
    const { t } = useTranslation();
    if (props.current === undefined)
        return "loading...";
    return (
          <div id="now" className={" " + (props.lang === 1? 'rtl' : '')}>
            <div id="tempdivvalue" title="" className="mx-auto">
                {props.current.date1}<br/>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/temp2.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("temp")} {props.current.temp}°
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/temp2.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("temp")} {props.current.temp2}°
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/temp2.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("temp")} {props.current.temp3}°
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/moist.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("humidity")} {props.current.hum}%
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/wind.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("wind")} {props.current.windspd}k/h {props.current.winddir}
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/dewp.png" width="36px" height="30px" alt={t("temp")} /></div>
                {t("dew")} {props.current.dew}°
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/rain.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("rain")} {props.current.rain}mm    
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/radiation.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("radiation")} {props.current.rad}W/m2    
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/uv.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("uv")} {props.current.uv}
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/dust2.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("pm10")} {props.current.pm10} µg/m3
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/dust2.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("pm25")} {props.current.pm25} µg/m3
                </div>
                <div title="" className="mx-auto parambox white_box">
                <div class="imgbox"><img src="https://www.02ws.co.il/img/temp2.png" width="72px" height="30px" alt={t("temp")} /></div>
                {t("pressure")} {props.current.pressure} mb
                </div>
                
            </div>
            <div className="" id="itfeels">
     
            </div>
            <div  id="windy">   

            </div>
            <div className="rainpercent">

            </div>
        </div>
        
    );
}

export default Now; 
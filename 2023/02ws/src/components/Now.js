
import { useTranslation } from 'react-i18next';
const Now = (props) => {
    const { t } = useTranslation();
    if (props.current === undefined)
        return "loading...";
    return (
          <div id="latestnow" className={" " + (props.lang === 1? 'rtl' : '')}>
            <div id="tempdivvalue" title="" className="mx-auto">
                {props.current.date1}<br/>
                {t("temp")} {props.current.temp}°<br/>
                {t("temp")} {props.current.temp2}°<br/>
                {t("temp")} {props.current.temp3}°<br/>
                {t("humidity")} {props.current.hum}%<br/>
                {t("wind")} {props.current.windspd}k/h {props.current.winddir}<br/>
                {t("dew")} {props.current.dew}°<br/>
                {t("rain")} {props.current.rain}mm<br/>
                {t("radiation")} {props.current.rad}W/m2<br/>
                {t("uv")} {props.current.uv}<br/>
                {t("pm10")} {props.current.pm10} µg/m3<br/>
                {t("pm25")} {props.current.pm25} µg/m3<br/>
                {t("pressure")} {props.current.pressure} mb<br/>
            </div>
            <div class="" id="itfeels">
     
            </div>
            <div  id="windy">

            </div>
            <div class="rainpercent">

            </div>
        </div>
        
    );
}

export default Now; 
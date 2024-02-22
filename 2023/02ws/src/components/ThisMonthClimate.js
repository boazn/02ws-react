
import { useTranslation } from 'react-i18next';

const ThisMonthClimate = ({ThisMonth, lang}) => {
    const { t } = useTranslation();
    
    if (ThisMonth === undefined)
        return "loading...";
    return (
          <div id="thismonth_box_container" className={" " + (lang === 1? 'rtl' : '')}>
                    <ul id="thismonth_box">
                            <li className="white_box">
                                 {t("AVERAGE")} <br />
                                  {t("MAX")}:{ThisMonth.hightemp_av}° <br/>  {t("MIN")}:{ThisMonth.lowtemp_av}° 
                            </li>
                           
                            <li className="white_box">
                                {t("RECORDS")} <br />
                                {t("MAX")}:{ThisMonth.hightemp_ab}° ({ThisMonth.hightemp_ab_date})<br/>{t("MIN")}:{ThisMonth.lowtemp_ab}°  ({ThisMonth.lowtemp_ab_date})
                            </li>
                           
                      </ul> 
                <div  title="" className="mx-auto parambox float">
               
               
                </div>
               
                
                 
        </div>      
        
    );
}

export default ThisMonthClimate; 
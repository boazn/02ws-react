import { useEffect, useState } from 'react';

const ColdMeter = (props) => {
  const [output, setColdMeter] = useState([]);
  const [output_sun, setColdMeterSun] = useState([]);
  const [clothColdMeter, setClothColdMeter] = useState([]);
  const [clothColdMeterSun, setClothColdMeterSun] = useState([]);
  const [coldTitle, setColdTitle] = useState([]);
  const [coldTitleSun, setColdTitleSun] = useState([]);
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
          //const output = `<a href="javascript:void(0)" class="info currentcloth" ><span class="info">${clothtitle}</span><img src="images/clothes/${clothimage}" height=100" style="vertical-align: middle" /></a><a class="info" id="coldmetertitle" href="javascript:void(0)" ><span class="info" style="cursor: default;" onclick="redirect('https://www.02ws.co.il?section=survey.php&amp;survey_id=2&amp;lang=1&amp;email=')">לא מסכימים? הצביעו!</span>${coldmeter_title}</a>${asterisk} </div>`;
          const output = `${clothtitle} ${coldmeter_title} ${asterisk}`;
          const output_sun = `${clothtitle_sun} ${coldmeter_title_sun} ${asterisk_sun}`;
          setColdMeter(output);
          setColdMeterSun(output_sun)
          setClothColdMeter(clothimage);
          setClothColdMeterSun(clothimage_sun);
          setColdTitle(coldmeter_title);
          setColdTitleSun(coldmeter_title_sun);
        };
       fetchJson();

        const timer = setInterval(() => {
          fetchJson();
        }, 60000);
      }, [])
    
    return (
        <div  id="coldmeter">
        <h4 cssClass="shadow">צל</h4>
        <a href={`?section=survey.php&amp;survey_id=2&amp;lang=${props.lang}`}> <span id="current_feeling_link"><img src={`https://www.02ws.co.il/images/clothes/${clothColdMeter}`} height="100" alt="cold meter"  />{coldTitle}</span></a>
        <div id="cm_dislike"><button onclick="change_circle('cold_line', 'coldmetersurvey')" class="info"><span class="info"></span> <img src="https://www.02ws.co.il/images/icons/cm_dislike.svg" width="50" height="50" alt="" /></button></div>
        <div id="cm_like"><button onclick="vote_cm_like()" class="info"><span class="info"></span> <img src="https://www.02ws.co.il/images/icons/cm_like.svg" width="50" height="50" alt="" /></button></div>
        <div id="cm_result" ><div id="cm_result_msg"></div><div><input type="button" value="" onclick="$('#cboxClose').click();" id="cm_result_OK" class="info  inv_plain_3 button" /></div></div>
        {output}
        <h4 cssClass="sun">שמש</h4>
        <a href={`?section=survey.php&amp;survey_id=2&amp;lang=${props.lang}`}> <span id="current_feeling_link"><img src={`https://www.02ws.co.il/images/clothes/${clothColdMeterSun}`} height="100" alt="cold meter"  />{coldTitleSun}</span></a>
        <div id="cm_dislike"><button onclick="change_circle('cold_line', 'coldmetersurvey')" class="info"><span class="info"></span> <img src="https://www.02ws.co.il/images/icons/cm_dislike.svg" width="50" height="50" alt="" /></button></div>
        <div id="cm_like"><button onclick="vote_cm_like()" class="info"><span class="info"></span> <img src="https://www.02ws.co.il/images/icons/cm_like.svg" width="50" height="50" alt="" /></button></div>
        <div id="cm_result" ><div id="cm_result_msg"></div><div><input type="button" value="" onclick="$('#cboxClose').click();" id="cm_result_OK" class="info  inv_plain_3 button" /></div></div>
        {output_sun}
        </div>
        
    );
}

export default ColdMeter; 
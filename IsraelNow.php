
<h1>Israel Now</h1>
<br/><br/><br/>
<p>
<?

echo "<h2>IMS = ".$SOURCE[$lang_idx].": ".$IMS[$lang_idx]."</h2>";
    
?>
</p>
<div class="ImsNowRes" id="ImsNowRes"></div><br/><br/>
<p>
<?echo "<h2 style=\"clear:both\">WU = ".$SOURCE[$lang_idx].": Weather Underground</h2>";?>
<div class="WUNowRes" id="WUNowRes"></div>
</p>
<!--<iframe src="https://www.wunderground.com/wundermap/?isPresentationActive=0&renderer=2&Units=metric&zoom=13&lat=31.77708743611025&lon=35.17300056593422&covid19=0&wxstn=1&wxstnmode=tw&aq=0&aqvalue=NaN&radar=0&radarType=NaN&radaropa=0.7&satellite=0&satelliteopa=0.8&insertHurricaneNameHere=false&goes16opa=&storm-cells=0&severe=0&severeopa=0.9&sst=0&sstopa=0.8&sstanom=0&sstanomopa=0.8&cam=0&fronts=0&hur=0&models=0&modelsmodel=ecmwf&modelsopa=0.8&modelstype=SURPRE&lightning=0&fire=0&fireopa=0.9&fireRisk=0&fireRiskOpacity=0.9&firePerimeter=0&firePerimeterOpacity=0.9&smoke=0&smokeOpacity=0.9&rep=0&surge=0&tor=0&windstr=0&windstrDensity=undefined&windstreamSpeed=undefined&windstreamSpeedFilter=undefined&windstreamPalette=undefined&hurrArch=0&hurrArchBasin=undefined&hurrArchYear=undefined&hurrArchStorm=undefined"  style="width:500px;height:300px" ></iframe>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
    getLatest("פסגת זאב", "IJERUSAL49", "WU");
    getLatest("עיר-גנים", "IISRAELJ6", "WU");
    getLatest("גוננים", "IJERUS4", "WU");
    getLatest("ארנונה", "I1765", "WU");
    getLatest("מבשרת", "IJERUS8", "WU");
    getLatest("הקסטל", "IMAOZZ1", "WU");
    getLatest("מעלה אדומים", "IISRAELM2", "WU");
    getLatest("צרעה", "ITZORA2", "WU");
    getLatest("גבעת-יערים", "IJERUSAL37", "WU");
    getLatest("מודיעין", "IMODII2", "WU");
    getLatest("מודיעין", "ICENTRAL268", "WU");
    getLatest("כפר האורנים", "IISRAEL8", "WU");
    getLatest("גבעת זאב", "IISRAELG2", "WU");
    getLatest("צור-הדסה", "IZURHA1", "WU");
    getLatest("מצפה יריחו", "IJERIC2", "WU");
    getLatest("פסגות", "IRAMALLA2", "WU");
    getLatest("בית-לחם", "IBETHLEH2", "WU");
    //getLatest("תא", "ITELAV5", "WU");
    //getLatest("העיר שליד רכבת מרכז", "ITELAVIV51", "WU");
    getLatest("העיר שליד רכבת מרכז", "ITELAVIV44", "WU");
    getLatest("רמת השרון", "IRAMATHA4", "WU");
    getLatest("פתח-תקווה", "IMKEFARG2", "WU");
    getLatest("רישפון", "IRISHP1", "WU");
    getLatest("הרצליה", "I1084", "WU");
    getLatest("רעננה", "IKFARMAL5", "WU");
    getLatest("עין-ורד", "IEINVE1", "WU");
    getLatest("קדימה-צורן", "ICENTERD16", "WU");
    getLatest("אבן-יהודה", "IKFARNET2", "WU");
    getLatest("נתניה", "INETANYA12", "WU");
    getLatest("שוהם", "ISHOHA1", "WU");
    getLatest("בן-שמן", "ISHFELAB2", "WU");
    getLatest("נס ציונה", "IREHOV3", "WU");
    getLatest("כרמל חיפה", "IHAIFA12", "WU");
    getLatest("חיפה2", "IHARAMAT2", "WU");
    getLatest("נצרת", "INAZAR12", "WU");
    getLatest("עין המפרץ", "IACRE8", "WU");
    getLatest("עין יהב", "IENYAHAV2", "WU");
    getLatest("ירוחם", "IYERUHAM2", "WU");
    getLatest("ניר משה", "INIRMO1", "WU");
    getLatest("באר טוביה", "IBEERT1", "WU");

    getLatest("ראש-צורים", "77", "IMS");
    getLatest("צובה", "188", "IMS");
    getLatest("חוף מערבי", "178", "IMS");
    getLatest("עין גדי", "211", "IMS");
    getLatest("צמח", "6", "IMS");
    getLatest("מצוקי דרגות", "210", "IMS");
    getLatest("מעלה אדומים", "218", "IMS");
    getLatest("נחשון", "259", "IMS");
    getLatest("מעלה גלבוע", "224", "IMS");
    getLatest("גמלא", "227", "IMS");
    
    getLatest("עין כרמל", "44", "IMS");
    
    
    getLatest("גת", "236", "IMS");
    getLatest("כפר גלעדי", "241", "IMS");
    getLatest("חרשים", "269", "IMS");
    
    
    
    
    getLatest("יבנה", "74", "IMS");
    getLatest("אילון", "73", "IMS");
    getLatest("בית שמש", "75", "IMS");
    
    getLatest("נגבה", "82", "IMS");
    getLatest("מצפה רמון", "379", "IMS");
    
    
    getLatest("תבור", "13", "IMS");
    getLatest("בית-דגן", "54", "IMS2");
    getLatest("יבנה", "74", "IMS2");
    //getLatest("בית שמש", "75", "IMS2");
    //getLatest("גת", "236", "IMS2");
   // getLatest("עפולה", "16", "IMS2");
    //getLatest("שערי תקוה", "270", "IMS2");
    //getLatest("הכפר הירוק", "275", "IMS2");
    //getLatest("נתיב הל''ה", "25", "IMS2");
    //getLatest("אילת", "64", "IMS2");
    //getLatest("צפת", "62", "IMS2");
    //getLatest("עבדת", "271", "IMS2");
    //getLatest("זכרון יעקב", "45", "IMS2");
    //getLatest("חיפה", "43", "IMS2");
   // getLatest("באר-שבע", "59", "IMS2");
   // getLatest("חדרה", "46", "IMS2");
    //getLatest("City", "ALL", "IMS2");
    //getLatest("דורות", "79", "IMS2");
});






     
</script>
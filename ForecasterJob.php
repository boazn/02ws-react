<h1><?=$FORECASTER_JOB[$lang_idx]?></h1>
        <?php
        // put your code here
        $explain0 = array("Medium distance forecast", "תחזית  לטווח בינוני");
        $explain1 = array("Forecaster take this kind of map and analize it to a specific place. There are dozens kind of maps like this for each model. The forecaster takes into account all kind of maps and models into his forecat.", "חזאי מנתח מפה כזאת שיוצאת פעמיים ביום לטווחי זמן שונים. המפה נועדה לייצר תחזית לימים הבאים. <br />
יש עשרות סוגים של מפות כאלה לשכבות שונות ופרמטרים שונים כמו לחות, רוח, לחץ וטמפרטורה. מפות כאלה יוצאות לכל מודל והחזאי צריך לקחת בשקלול את כל המפות האלה מכל המודלים האמינים כדי ליצור תחזית.");
        $explain2 = array("Nowcasting", "תחזית  לטווח קצר");
        $explain3 = array("Forecaster follows satellite animations in the infra-red channel and the visible chanel to forecast the cloud motion for the coming hours and the type of clouds", "חזאי עוקב אחרי תנועת תצלומי הלווין בערוץ הנראה ובערוץ האינפרא אדום כדי לחזות את תנועת העננים בשעות הקרובות <br/>
הערוץ הנראה אפשרי רק בשעות היום. הערוץ האינפרא אדום אפשרי בכל שעות היממה. אפשר להיעזר בשניהם כדי לזהות סוגי עננים - ממטירים  או לא ואת קצב התפתחותם.");
        $explain4 = array("Forecaster follows radar animation images to forecast when the rain will come and go", "חזאי עוקב אחרי האנימציות של מכם ענני הגשם כדי לחזות מתי הגשם בא והולך<br/>
מעקב כזה צמוד דרוש כדי לחזות בצורה מדויקת את הצפי בשעות הקרובות. צריך לעקוב לפי תדירות יציאת התמונות שנעה בין 3 דקות ל-10 דקות.");
        ?>

<article class="white_box" style="padding:1em">
    <br/> 
    <p>
        <h2></h2>
        <?=$FORECAST_DESC[$lang_idx]?>
     </p>
     <br/>
    <h2><?=$explain0[$lang_idx]?></h2>
    <p><img src="images/ECMOPEU00_120_1.png" width="300" /><br/>
     <?=$explain1[$lang_idx]?>
     </p>
     <br/>
     <br/>
     <p>
     <h2><?=$explain2[$lang_idx]?></h2>
     <img src="images/Capture_130417.JPG" width="242" height="" /><br/>
     <?=$explain3[$lang_idx]?>
     </p>
     <p>
    <img src="images/dailyradar160326.gif" width="300" height="" /><br/>
    <?=$explain4[$lang_idx]?>
     </p>
     
     
    
</article>
    


   
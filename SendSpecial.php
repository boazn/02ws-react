<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#localimg')
                    .attr('src', e.target.result)
                    .width(300)
                    .show()
                    ;
                    $('#localvid')
                    .attr('src', e.target.result)
                    .width(300)
                    .show()
                    ;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }    
</script>
<style>
    #user_info{
        top:400px
    }
    #progress-wrp {
  border: 1px solid #0099CC;
  padding: 1px;
  position: relative;
  height: 30px;
  border-radius: 3px;
  margin: 0;
  text-align: left;
  background: #fff;
  box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);
}

#progress-wrp .progress-bar {
  height: 100%;
  border-radius: 3px;
  background-color: #bbccbb;
  width: 0;
  box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
}

#progress-wrp .status {
  top: 3px;
  left: 50%;
  position: absolute;
  display: inline-block;
  color: #000000;
}
select{
    height:28px;margin-top:2px
}
#SendSpecialResult{
    line-break: anywhere;
}
#combos{text-align:left}
#combos label{width: 50px;
display: inline-block;
margin-left: 10px;}
#tohome{ display:none}
</style>
<input type='file' onchange="readURL(this);" accept="video/*,image/*,video/mp4,video/x-m4v" name="imagefile" id="imagefile"   size="60"  style="float:left;width:150px"/><br />
<img id="localimg" src="#" alt="your image" width="300"/><br />
<video id="localvid" width="320" height="240" controls>
<source src="#" type="video/mp4">
</video>
<div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
<div id="SendSpecialResult"></div>
<div id="combos">
<label for="subject">subject:</label>
<select name="subject" id="subject">
  <option value=""></option>
  <option value="will start">will start</option>
  <option value="will stop">will stop</option>
  <option value="sunset">sunset</option>
  <option value="boiler">boiler</option>
  <option value="evapotranspiration">evapotranspiration</option>
  <option value="frost">frost</option>
  <option value="uv">uv</option>
</select><br/>
<label for="rainminfrom">from:</label>
<select name="rainminfrom" id="rainminfrom">
  <option value=""></option>
  <option value="10">10</option>
  <option value="20">20</option>
  <option value="30">30</option>
  <option value="45">45</option>
  <option value="60">60</option>
  <option value="90">90</option>
</select><br/>
<label for="rainminto">to:</label>
<select name="rainminto" id="rainminto">
    <option value=""></option>
  <option value="20">20</option>
  <option value="30">30</option>
  <option value="45">45</option>
  <option value="60">60</option>
  <option value="90">90</option>
  <option value="120">120</option>
</select><br/>
<label for="words">hr/min:</label>
<select name="words" id="words">
   <option value=""></option>
  <option value="min">min</option>
  <option value="hours">hours</option>
</select><br/>   
<label for="rainpart">part:</label>
<select name="rainpart" id="rainpart">
   <option value=""></option>
  <option value="west">west</option>
  <option value="north">north</option>
  <option value="south">south</option>
  <option value="east">east</option>
</select><br/>
<label for="ttl">ttl:</label>
<select name="ttl" id="ttl">
   <option value=""></option>
   <option value="60">60</option>
   <option value="90">90</option>
   <option value="120">120</option>
   <option value="180">180</option>
   <option value="240">240</option>
</select>
</div>
<div class="inv_plain_3" style="margin:0 auto;padding:0.5em;width:300px;text-align:right">
	    <input id="title1" name="title1" size="18"  value="" style="width:290px;direction:rtl"  placeholder="כותרת"/>
        <textarea id="message1" name="message1" cols="3   0" rows="3" value="<? echo $message; ?>" style="direction:rtl;font-size: 1em;width:290px"><? echo $message; ?></textarea><br/>
</div>   
<div class="inv_plain_3" style="margin:0 auto;padding:0.5em;width:300px;text-align:left">
	
         <input id="title0" name="title0" size="18"  value="" style="width:290px;" placeholder="title" /><br />
        <textarea id="message0" name="message0" cols="3   0" rows="3"  value="<? echo $message; ?>" style="text-align:left;font-size: 1em;width:290px"><? echo $message; ?></textarea><br/>
 </div>
<div class="inv_plain_3" style="margin:0 auto;padding:0.5em;width:300px;text-align:right">
      	picture url<input id="picture_url" name="picture_url1" size="20"  value="https://www.02ws.co.il/images/webCamera0_r.jpg" style="width:225px;text-align:left"  /><br />
	external url<input id="embedded_url" name="embedded_url1" size="20"  value="" style="width:225px;text-align:left"  /><br /><br />
        <div style="text-align: left">
        <input type="checkbox" id="short_range" name="short_range" value="" style="width:25px"/>short range&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="long_range" name="long_range" value="" style="width:25px"/>long range&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="tip" name="tip" value="" style="width:25px"/>tip
        </div>
        <div style="text-align: left">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="social" name="tip" value="" style="width:35px"/>social&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="is_video" name="tip" value="" style="width:30px"/>video
        </div>
		
</div>
<div id="progress-wrp">
    <div class="progress-bar"></div>
    <div class="status">0%</div>
</div>

<div class="inv_plain_3" style="margin:0 auto;clear:both;text-align:center;padding:0.5em;width:90%">
    <input type="submit" id="togglewebcamurl" name="togglewebcamurl" value="togglewebcam" onClick="javascript:togglewebcam(1);" style="font-size: 1em;width:70%;margin-bottom:10px"/>
	<input type="submit" id="SendButton" name="SendButton" value="Go" onClick="javascript:SendSpecial(1);" style="font-size: 2em;width:70%"/>
	
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
<script type="text/javascript">
        var Upload = function (file, put_alert_section) {
    this.file = file;
    this.put_alert_section = put_alert_section;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    if (typeof this.file === 'undefined')
        return "";
    else
        return this.file.name;
};
Upload.prototype.doUpload = function () {
    var that = this;
    var formData = new FormData();
    var dailyforecast =  <?
        if (empty($_REQUEST['dailyforecast']))
            echo "0";
		else
			echo $_REQUEST['dailyforecast'];
        ?>;
    // add assoc key values, this will be posts values
     if (typeof this.file !== 'undefined'){
        formData.append("file", this.file, this.getName());
        formData.append("picture_url", this.getName());
     }
     else
        formData.append("picture_url", $("#picture_url").val());
    formData.append("dailyforecast", dailyforecast);
    formData.append("email", 1);
    formData.append("alert_section", this.put_alert_section);
    formData.append("buffer", '');
    formData.append("short_range", $("#short_range").is(":checked"));
    formData.append("long_range", $("#long_range").is(":checked"));
    formData.append("tip", $("#tip").is(":checked"));
    formData.append("social", $("#social").is(":checked"));
    formData.append("title1", $("#title1").val());
    formData.append("title0", $("#title0").val());
    formData.append("ttl", $("#ttl").val());
    formData.append("message1", $("#message1").val());
    formData.append("message0", $("#message0").val());
    formData.append("video", $("#is_video").is(":checked"));
    


    $.ajax({
        type: "POST",
        url: "<?=BASE_URL?>/SendSpecialService.php",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        beforeSend: function(){$(".loading").show();},
        success: function (data) {
            $(".loading").hide();

            $("#SendSpecialResult").html(data);
            $("#SendButton").hide();
        },
        error: function (error) {
            $("#SendSpecialResult").html('error:' + error.status + ' ' + error.responseText);
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 30000
    });
};

Upload.prototype.progressHandling = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .status").text(percent + "%");
};


         function SendSpecial(put_alert_section)
        {
            //$("#SendButton").hide();
            //Change id to your id
       
            var file = $('#imagefile')[0].files[0];
            var upload = new Upload(file, put_alert_section);

            // maby check size or type here with upload.getSize() and upload.getType()

            // execute upload
            upload.doUpload();
        

               
        }

        function togglewebcam()
        {
           if ($("#picture_url").val() == "")
                $("#picture_url").val("https://www.02ws.co.il/images/webCamera0_r.jpg");
            else
              $("#picture_url").val("");
        }

        <?
        if (!empty($_REQUEST['dailyforecast']))
            echo "SendSpecial(0);";
        ?>
        $('document').ready(function() {
//    initGeolocation();
    $('progress').hide();
    $('.adunit').hide();
    $('.nav').hide();
    $('#localimg').hide();
    $('#localvid').hide();
    });

    $("#subject").change(function(){
       
        switch ($("#subject").val()){
            case "will start":
                $("#title0").val("rain is coming");
                $("#title1").val("גשם בא");
                $("#message0").append("The rain is expected to arrive");
                $("#message1").append("לפי צפייה בתמונת מכם ולווין גשם צפוי להגיע");
            break;
            case "will stop":
                $("#title0").val("break is coming");
                $("#title1").val("הגשם ייפסק");
                $("#message0").append("The rain is expected to pass" );
                $("#message1").append("לפי צפייה בתמונת מכם ולווין הפוגה צפויה להגיע");
               
            break;
            case "sunset":
                $("#message0").append("Your attention is recommended " );
                $("#message1").append("כדאי להביט מערבה בשעת השקיעה. יהיה מעניין באזור ");
                $("#title0").val("Nicer than usual sunset");
                $("#title1").val("שקיעה מהממת מהרגיל");
               
            break;
            case "boiler":
                $("#message0").append("Low sunshine hours " );
                $("#message1").append("השמש לא סיפקה את הסחורה ");
                $("#title0").val("Turn on the boiler");
                $("#title1").val("כדאי להדליק את הבוילר");
            break;
            case "evapotranspiration":
                $("#message0").append("Irrigation needed " );
                $("#message1").append("הצמחים צמאים ");
                $("#title0").val("High evapotranspiration");
                $("#title1").val("אידוי גבוה");
                
            break;
            case "frost":
                $("#message0").append("Frost on the ground and cars in the lowest places " );
                $("#message1").append("קרה על הקרקע ועל הרכבים במקומות הנמוכים ");
                $("#title0").val("Frost");
                $("#title1").val("קרה");
                
            break;
            case "uv":
                $("#message0").append("Especially for deligate type of skin. " );
                $("#message1").append("במיוחד לבעלי עור רגיש ");
                $("#title0").val("High and dangerous UV");
                $("#title1").val("קרינה גבוהה ומסוכנת");
                
            break;
            default:
            break;
        }
        
    });
    $("#rainminfrom").change(function(){
        $("#message1").append(" תוך כ-"+($("#rainminfrom").val())+" ");
        $("#message0").append(" within "+($("#rainminfrom").val())+" ");
    });
    $("#rainminto").change(function(){
        $("#message1").append("עד "+($("#rainminto").val()));
        $("#message0").append("to "+($("#rainminto").val()));
    });
    $("#words").change(function(){
        var heb_side;
        switch ($("#words").val()){
            case "min":
                heb_side = "דק";
            break;
            case "hours":
                heb_side = "שעות";
            break;
            default:
            break;
        }
        $("#message1").append(" " + heb_side);
        $("#message0").append(" "+($("#words").val()));
    });
    $("#rainpart").change(function(){
        var heb_side;
        switch ($("#rainpart").val()){
            case "south":
                heb_side = "דרום";
            break;
            case "west":
                heb_side = "מערב";
            break;
            case "north":
                heb_side = "צפון";
            break;
            case "east":
                heb_side = "מזרח";
            break;
            default:
            break;
        }
        $("#message1").append(" בדגש "+heb_side+" העיר ");
        $("#message0").append(" esp to the "+($("#rainpart").val())+" parts");
    });
</script>
    
   
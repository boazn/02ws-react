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
  margin: 10px;
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
</style>
<input type='file' onchange="readURL(this);" accept="video/*,image/*,video/mp4,video/x-m4v" name="imagefile" id="imagefile"   size="60"  style="float:left;width:150px"/><br />
<img id="localimg" src="#" alt="your image" width="300"/><br />
<video id="localvid" width="320" height="240" controls>
<source src="#" type="video/mp4">
</video>
<div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
<div id="SendSpecialResult"></div>
<div class="inv_plain_3" style="margin:0 auto;padding:0.5em;width:300px;text-align:right">
	<strong>Your message</strong><br/>
        <textarea id="message0" name="message0" cols="3   0" rows="3"  value="<? echo $message; ?>" style="text-align:left;font-size: 1em;width:290px"><? echo $message; ?></textarea><br/>
        title<input id="title0" name="title0" size="18"  value="" style="width:250px;"  /><br />
</div>
<div class="inv_plain_3" style="margin:0 auto;padding:0.5em;width:300px;text-align:right">
	<strong>כאן כתוב את הודעתך</strong><br/>
        <textarea id="message1" name="message1" cols="3   0" rows="3" value="<? echo $message; ?>" style="direction:rtl;font-size: 1em;width:290px"><? echo $message; ?></textarea><br/>
        title<input id="title1" name="title1" size="18"  value="" style="width:250px;direction:rtl"  /><br />
	picture url<input id="picture_url" name="picture_url1" size="20"  value="https://www.02ws.co.il/images/webCamera0_r.jpg" style="width:225px;text-align:left"  /><br />
	external url<input id="embedded_url" name="embedded_url1" size="20"  value="" style="width:225px;text-align:left"  /><br /><br />
        <div style="text-align: left">
        <input type="checkbox" id="short_range" name="short_range" value="" style="width:20px"/>short range&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="long_range" name="long_range" value="" style="width:20px"/>long range&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="tip" name="tip" value="" style="width:20px"/>tip
        </div>
        <div style="text-align: left">
        <input type="checkbox" id="social" name="tip" value="" style="width:20px"/>social
        <input type="checkbox" id="is_video" name="tip" value="" style="width:20px"/>video
        </div>
		
</div>
<div id="progress-wrp">
    <div class="progress-bar"></div>
    <div class="status">0%</div>
</div>

<div class="inv_plain_3" style="margin:0 auto;clear:both;text-align:center;padding:1em;width:50%">
    <input type="submit" id="togglewebcamurl" name="togglewebcamurl" value="togglewebcam" onClick="javascript:togglewebcam(1);" style="font-size: 1em;width:80%"/>
	<input type="submit" id="SendButton" name="SendButton" value="Go" onClick="javascript:SendSpecial(1);" style="font-size: 2em;width:80%"/>
	
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
    formData.append("message1", $("#message1").val());
    formData.append("message0", $("#message0").val());
    formData.append("video", $("#is_video").is(":checked"));
    


    $.ajax({
        type: "POST",
        url: "SendSpecialService.php",
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

            $("#SendSpecialResult").text(data);
            $("#SendButton").hide();
        },
        error: function (error) {
            $("#SendSpecialResult").text(error);
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
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
</script>
    
   
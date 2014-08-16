<?php
ini_set("display_errors","On");

$CHECK_EMAIL = array("Check your Email to make your user active.", "כעת יש לגשת לאימייל שלך כדי לאשר את הוספתך למערכת");
$USER_ID_EXP = array("User ID (optionally with numbers in it)", "שם משתמש באנגלית, אפשר עם מספרים - לשימוש עתידי");
$DISPLAY_NAME_EXP = array("The name in the forum", "השם שיוצג בהודעות");
$NICENAME_EXP = array("The name in the mailing list and in the forum title", "השם הרשמי שיוצג במייל או בהפניה רשמית");
$HELLO = array("Hello", "שלום");
$user_locked = false;

$numberofPages = 10;
if (strlen($_GET['limit']) > 0)
	$limitLines = $_GET['limit'];
$p = $_GET['p'];
if (!isset($_GET['p']))
	$p = 0;

function getNextPage($addToPage)
{
	global $p;
	if (($p + $addToPage) < 0)
		return (0);
	else
		return ($p + $addToPage);
}


   
?>
<a id="chat" ></a>
<div id="forum">
<div id="chat_entire_div">
<div id="chatWrapper">
	<div id="chat_title" class="big slogan">
	  <a href="<? echo get_query_edited_url(get_url(), 'section', 'chat.php');?>&amp;limit=15" >
		<?=$CHAT_TITLE[$lang_idx]?>
	   </a>
	</div>
	<? if (stristr($_SERVER["PHP_SELF"], "station.php")){?>
	<div id="chat_explain" class="float">
			<?=$MAN_EXP[$lang_idx]?>
	</div>
	
	<?}?>
	<div id="chat_filter">
		
	</div>
           <ul class="nav" id="user_info">
			      <li><p id="user_name"></p><div id="user_icon"></div><span class="arrow_down">&#9660;</span>
					  <ul style="<?echo get_s_align();?>: -2em;">
						<li>
							<div id="notloggedin" style="display:none">
								<div class="clear"><a href="javascript: void(0)" id="login" title="<?=$LOGIN[$lang_idx]?>" ><?=$LOGIN[$lang_idx]?></a></div>
								<div class="clear"><a href="javascript: void(0)" class="register" id="register" title="<?=$REGISTER[$lang_idx]?>"><?=$REGISTER[$lang_idx]?></a></div>
								<div class="clear"><a href="javascript: void(0)" id="forgotpass" title="<?=$FORGOT_PASS[$lang_idx]?>"><?=$FORGOT_PASS[$lang_idx]?></a></div>
							</div>
							<div id="loggedin" style="display:none">
								<input id="updateprofile" class="button" title="<?=$UPDATE_PROFILE[$lang_idx]?>" value="<?=$UPDATE_PROFILE[$lang_idx]?>" /><br />
								<input value="<?=$SIGN_OUT[$lang_idx]?>" onclick="signout_from_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="signout" class="button"/>
							</div>
						</li>
					  </ul>
				  </li>
				          
			 </ul>
	<input type="hidden" value="" name="current_new_msg_idx" id="current_new_msg_idx" />
	<input type="hidden" value="" id="current_display_name" />
	<input type="hidden" value="0" id="current_forum_startline" />
	<input type="hidden" value="" id="current_forum_filter" />
	<input type="hidden" value="R" id="current_forum_update_display" />
	<input type="hidden" value="" id="current_post_idx" />
	<div  class="small" id="inputFieldsDiv">
	    <div id="new_post_btn" onclick="openNewPost(<?=$lang_idx?>)">
				<?=$CREATE_NEW_MSG[$lang_idx]?>
		</div>
		<div class="span4 white_box" id="new_post">
				<div id="new_post_user"></div>                               
				<textarea id="new_post_ta"></textarea>
                                <div id="new_post_private"><input type="checkbox" id="check_private_msg" /><?=$PRIVATE_MSG[$lang_idx]?></div>
                                <div id="new_post_cancel" onclick="closeNewPost();restoreTopDiv();"><?=$CANCEL[$lang_idx]?></div>
				<div id="new_post_okay" onclick="getMessageService(<?=$limitLines?>, '', 0, 1, <?=$lang_idx?>, $('#current_forum_filter').attr('key'));closeNewPost()"><?=$SEND[$lang_idx]?></div>               
		</div>
	</div>
	<div id="chat_links">
			<div>   
			
			<a href="<? echo get_query_edited_url($url_cur, 'section', 'SendEmailForm.php');?>" title="<?=$MANAGER[$lang_idx]?>">
				<?=$PRIVATE_MSG[$lang_idx]?><?=get_arrow()?>
			</a>&nbsp;&nbsp;
			<a href="javascript:void(0)" onclick="window.open('http://pub11.bravenet.com/guestmap/show.php?usernum=893988804&amp;lightmap=0&amp;icons=0&amp;&amp;entrylist=0&amp;zoom=0&amp;welcome=1','bnetguestmap','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,width=720,height=470,top=110,left=110')">
					<? echo $GUESTBOOK[$lang_idx];?><?=get_arrow()?> 
			</a>&nbsp;&nbsp;
			<a href="<? echo get_query_edited_url($url_cur, 'section', 'faq.php');?>"  title="<?=$FAQ[$lang_idx]?>"><? echo $FAQ[$lang_idx];?><?=get_arrow()?>
			</a>
			</div>
			<?
	                if ($_GET['section'] == "chat.php")
	                {
			?>
			<div id="chat_search">
	                <input id="searchname" name="searchname" size="10" maxlength="50" value="" style="text-align:<?if (isHeb()) echo "right"; else "left";?>" />&nbsp;&nbsp;
	                <input type="button" name="SearchSendButton" value="<?=$SEARCH_IN[$lang_idx]?>" onclick="getMessageService('', 0, 1)"/>
	            
	        </div>
			<?} ?>
	</div>
	<hr id="forum_hr" />
	<div class="" id="msgDetails">
				
	</div>
	
	
	<!-- This contains the hidden content for inline calls -->
	<div style='display:none'>
		<div id='href_dialog' >
		<div id="link_title_div">
			<div><?=$LINK_TITLE[$lang_idx]?> </div>
			<input id="linktitle" name="linktitle" size="50" maxlength="50" value=""  />
			
		</div>
		<div id="link_href_div">
			<div><?=$LINK[$lang_idx]?> </div>
			<input id="linkhref" name="linkhref" size="50" maxlength="500" value=""  />
			
		</div>
		<div class="spacer">&nbsp;</div>
		<div class="spacer">&nbsp;</div>
		<div class="float">
			<input type="button" name="SendButton" value="<? if (isHeb()) echo "שליחה"; else echo "Send"; ?>" class="" onclick="addlinkToMessage()"/>
		</div>
		<div class="float">
            <input type="button" name="SendButton" value="<? if (isHeb()) echo "ביטול"; else echo "Cancel"; ?>" class="" onclick="closeLinktoMessage()"/>
        </div>
		</div>
	</div>
	<div style='display:none'>
	<div id='moods_dialog' >
	<? $moods = array(); $moods = getfilesFromdir("images/icons/mood"); foreach ($moods as $mood)
		{ ?>
	<div class="float moodbox">
                <div class='float sprite <? $mood_name =explode(".", end(explode("/",$mood[1]))); echo $mood_name[0];?>' style="cursor:pointer;" onclick="addMoodToMessage(this)"></div>
                <div class="float">&nbsp;<?=getMoodTitle("<?=$mood[1]?>")?></div>
	</div>
	<? }?>
	</div>
	</div>

</div>
</div>
</div>
<div style="display:none">
<div id="profileform" style="padding:1em" >
    <div class="float">
    <table>
    <tr><td><?=$EMAIL[$lang_idx]?>:</td><td><input type="text" name="email" value="" readonly="readonly" id="profileform_email" size="30"/></td></tr>
    <tr><td><?=$PASSWORD[$lang_idx]?>:</td><td><input type="password" name="password" value="" id="profileform_password"/></td></tr>
    <tr><td><?=$DISPLAY_NAME[$lang_idx]?>:</td><td><input type="text" name="user_display_name" value="" id="profileform_displayname"/></td></tr>
    <tr><td><?=$NICE_NAME[$lang_idx]?>:</td><td><input type="text" name="user_nice_name" value="" id="profileform_nicename"/></td></tr>
    </table>
    <input type="checkbox" name="priority" value="" id="profileform_priority"/><?=$GET_UPDATES[$lang_idx]?><br /><br />
    </div>
    <div style="display:none" class="float loading"><img src="images/loading.gif" alt="loading" width="32" height="32" /></div>
    <div id="profileform_result" class="float"></div>
    <input type="submit" value="<?=$UPDATE_PROFILE[$lang_idx]?>" onclick="updateprofile_to_server()" id="profileform_submit" class="invfloat clear"/>
	<input type="submit" value="OK" onclick="$('#cboxClose').click();window.location.reload()" id="profileform_OK" class="info invfloat" style="display:none"/>
	
 </div>
</div>

 <div style="display:none">
      
<div id="loginform" style="padding:1em">
	<div class="float">
        <?=$EMAIL[$lang_idx]?>:<input type="text" name="email" value="" id="loginform_email" size="30" tabindex="1" style="direction:ltr"/><br /><br />
        <?=$PASSWORD[$lang_idx]?>:<input type="password" name="password" value="" id="loginform_password" tabindex="2" size="15"/>&nbsp;&nbsp;
        <input type="checkbox" name="rememberme" value="" id="loginform_rememberme"/><?=$REMEMBER_ME[$lang_idx]?>
        </div>
	<div style="display:none" class="float loading"><img src="images/loading.gif" alt="loading" width="32" height="32"/></div>
        <div id="loginform_result" class="float"></div>
		<input type="submit" value="<?=$LOGIN[$lang_idx]?>" class="invfloat clear" onclick="login_to_server()" id="loginform_submit"/>
        <input type="submit" value="Success!" onclick="$('#cboxClose').click();window.location.reload();" id="loginform_OK" class="info invfloat" style="display:none"/>
 	
</div>
<div id="registerform" style="padding:1em">
    <div class="float">
    <table>
    <tr><td><?=$EMAIL[$lang_idx]?>:</td><td><input type="text" name="email" value="" id="registerform_email" size="30" tabindex="3" style="direction:ltr"/></td></tr>
    <tr><td><?=$PASSWORD[$lang_idx]?>:</td><td><input type="password" name="password" value="" id="registerform_password" tabindex="4"/></td></tr>
    <tr><td><?=$PASSWORD_VERIFICATION[$lang_idx]?>:</td><td><input type="password" name="password_verif" value="" id="registerform_password_verif" tabindex="5"/></td></tr>
    <tr><td><?=$USER_ID[$lang_idx]?>:</td><td><input type="text" name="username" value="" id="registerform_userid" tabindex="6"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;right:-100px"><?=$USER_ID_EXP[$lang_idx]?></span></a></td></tr>
    <tr><td><?=$DISPLAY_NAME[$lang_idx]?>:</td><td><input type="text" name="user_display_name" value="" id="registerform_displayname" tabindex="7"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;right:-100px"><?=$DISPLAY_NAME_EXP[$lang_idx]?></span></a></td></tr>
    <tr><td><?=$NICE_NAME[$lang_idx]?>:</td><td><input type="text" name="user_nice_name" value="" id="registerform_nicename" tabindex="8"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;right:-100px"><?=$NICENAME_EXP[$lang_idx]?></span></a></td></tr>
    </table>
    <input type="checkbox" name="priority" value="" id="registerform_priority"/><?=$GET_UPDATES[$lang_idx]?>
    </div>
    <div style="display:none" class="float loading"><img src="images/loading.gif" alt="loading" width="32" height="32" /></div>
    <div id="registerform_result" class="float">
    </div>
    <input type="submit" value="<?=$REGISTER[$lang_idx]?>" class="invfloat clear" onclick="register_to_server()" id="registerform_submit"/>
    <input type="submit" value="Success!" onclick="$('#cboxClose').click();" id="registerform_OK" class="info invfloat" style="display:none"/>
    
 </div>

<div id="passforgotform" style="padding:1em">
    <?=$EMAIL[$lang_idx]?>:<input type="text" name="email" value="" id="passforgotform_email" size="30" style="direction:ltr"/><br /><br />
    <input type="submit" value="<?=$FORGOT_PASS[$lang_idx]?>" onclick="passforgot_to_server()" id="passforgotform_submit"/>
    <input type="submit" value="Success!" onclick="$('#cboxClose').click();" id="passforgotform_OK" class="info invfloat" style="display:none"/>
 	<div id="passforgotform_result"></div>
 </div>
 </div>
<script type="text/javascript">
<!--
       function attachEnter(){
		   $("#loginform_password").keyup(function(event){
		   if(event.keyCode == 13){
			  $("#loginform_submit").click();
		   }
		   });
		   $("#passforgotform_email").keyup(function(event){
		   if(event.keyCode == 13){
			  $("#passforgotform_submit").click();
		   }
		   });
			$("#registerform_nicename").keyup(function(event){
		   if(event.keyCode == 13){
			  $("#registerform_submit").click();
		   }
		   });
       }	
        function fillUserDetails (jsonstr )
        {
        	var jsonT = JSON.parse( jsonstr  );
        	 $("#profileform_email").val(jsonT.user.email);
                 $("#name").html(jsonT.user.display);
                 $("#nice_name").html("<?=$HELLO[$lang_idx]?>" + ", " + jsonT.user.nicename + ":");
                 $("#profileform_displayname").val(jsonT.user.display);
                 $("#current_display_name").val(jsonT.user.display);
                 $("#profileform_nicename").val(jsonT.user.nicename);
                 $("#profileform_priority").prop("checked", jsonT.user.priority);
        }
        function login_to_server()
        {
        	$("#loginform_result").html("");
                if ($("#loginform_email").val().length == 0){
                	alert('<?=$EMAIL[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                	$("#loginform_email").focus();
                	return false;
                }
                   
                 if ($("#loginform_password").val().length == 0){
                 	alert('<?=$PASSWORD[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#loginform_password").focus();
                 	return false;
                 }
                   
        	$.ajax({
		  type: "POST",
		  url: "checkauth.php?action=login&lang=<?=$lang_idx?>",
		  data: { email: $("#loginform_email").val(), password: $("#loginform_password").val(), isrememberme:$("#loginform_rememberme").is(':checked') ? 1 : 0 },
                  beforeSend: function(){$(".loading").show();}
		}).done(function( jsonstr  ) {
		  try{
                     $(".loading").hide();
                     var jsonT = JSON.parse( jsonstr  );
                     if (!jsonT.user.loggedin)
                         {
                             if (jsonT.user.locked)
                                alert('<?=$USER_LOCKED[$lang_idx]?>');
                         }
                       else {
                         $("#cboxClose").click();
                         fillUserDetails (jsonstr );
                         toggle('loggedin');
                         toggle('notloggedin');
                                                 
                         fillMessage('<img src="images/loading.gif" alt="loading" width="32" height="32"/>');
			var ajax = new Ajax();
			ajax.method = 'POST';
			ajax.setMimeType('text/html');
			ajax.setHandlerBoth(fillMessage);
			ajax.postData = "lang=" + "<?=$lang_idx?>" + "&limit=" + "<?=$limitLines?>" + "&update=<?=$_GET['update']?>";
			ajax.url = 'chat_service.php';
			ajax.doReq();  
                       }
                                                         
                 }
                 catch (e) {
                     $("#loginform_result").html("<div class=\"high\">" + jsonstr + "</div>"  );
                     
                  }
		    
		});
        }
		function signout_from_server()
		{
			$.ajax({
		  type: "POST",
		  url: "checkauth.php?action=signout",
		  data: { },
          beforeSend: function(){$(".loading").show();}
		}).done(function( result  ) {
		 
                     $(".loading").hide();
                    
                     if (result == 0)
                     {
                                               
                         toggle('loggedin');
                         toggle('notloggedin');
                                                
                         fillMessage('<img src="images/loading.gif" alt="loading" width="32" height="32"/>');
						var ajax = new Ajax();
						ajax.method = 'POST';
						ajax.setMimeType('text/html');
						ajax.setHandlerBoth(fillMessage);
						ajax.postData = "lang=" + "<?=$lang_idx?>" + "&limit=" + "<?=$limitLines?>" + "&update=<?=$_GET['update']?>";
						ajax.url = 'chat_service.php';
						ajax.doReq();  
                    }
                                                         
                
		    
		});
		}
        function updateprofile_to_server()
        {
                 $("#profileform_result").html("");                  
                 if ($("#profileform_password").val().length == 0){
                 	alert('<?=$PASSWORD[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#profileform_password").focus();
                 	return false;
                 }
                 
                  if ($("#profileform_displayname").val().length == 0){
                 	alert('<?=$DISPLAY_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#profileform_displayname").focus();
                 	return false;
                 }
                 
                  if ($("#profileform_nicename").val().length == 0){
                 	alert('<?=$NICE_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#profileform_nicename").focus();
                 	return false;
                 }
                   
        	$.ajax({
		  type: "POST",
		  url: "checkauth.php?action=updateprofile&lang=<?=$lang_idx?>",
		  data: { email: $("#profileform_email").val(), 
		          password: $("#profileform_password").val(), 
		          user_display_name: $("#profileform_displayname").val(), 
		          user_nice_name:$("#profileform_nicename").val(), 
		          priority:$("#profileform_priority").is(':checked') ? 1 : 0 }
		}).done(function( msg ) {
		   if (msg.indexOf("uniq_name") > 0){
		  	$("#profileform_result").html("<div class=\"high\"><?=$DISPLAY_NAME[$lang_idx]." ".$IS_TAKEN[$lang_idx]?></div>");
		  	$("#profileform_displayname").focus();
		   }
		   else if (msg==0)
		   {
		      toggle('profileform_submit');
		      toggle('profileform_OK');
		      $("#profileform_OK").addClass("success");
		      
		   }
		  else
		     $("#profileform_result").html( msg );
		});
        }
        function register_to_server()
        {
        	$("#registerform_result").html("");
                 if ($("#registerform_userid").val().length == 0){
                 	alert('<?=$USER_ID[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_userid").focus();
                 	return false;
                 }
                 if ($("#registerform_email").val().length == 0){
                 	alert('<?=$EMAIL[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_email").focus();
                 	return false;
                 }               
                 if ($("#registerform_password").val().length == 0){
                 	alert('<?=$PASSWORD[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_password").focus();
                 	return false;
                 }
                 if ($("#registerform_password_verif").val().length == 0){
                 	alert('<?=$PASSWORD_VERIFICATION[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_password_verif").focus();
                 	return false;
                 }
                 
                 
                  if ($("#registerform_displayname").val().length == 0){
                 	alert('<?=$DISPLAY_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_displayname").focus();
                 	return false;
                 }
                 
                  if ($("#registerform_nicename").val().length == 0){
                 	alert('<?=$NICE_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_nicename").focus();
                 	return false;
                 }
                 
                 if ($("#registerform_password").val() != $("#registerform_password_verif").val()){
                 	alert('Passwords do not match');
                 	$("#registerform_password_verif").focus();
                 	return false;
                 }
                   
        	$.ajax({
		  type: "POST",
		  url: "checkauth.php?action=register&lang=<?=$lang_idx?>",
                  beforeSend: function(){$(".loading").show();},
		  data: { username:$("#registerform_userid").val(),
		  	  email: $("#registerform_email").val(), 
		          password: $("#registerform_password").val(), 
		          user_display_name: $("#registerform_displayname").val(), 
		          user_nice_name:$("#registerform_nicename").val(), 
		          priority:$("#registerform_priority").is(':checked') ? 1 : 0 }
		}).done(function( msg ) {
                  $(".loading").hide();
		  if (msg.indexOf("User_login_Uniq") > 0){
		        $("#registerform_result").html("<div class=\"high\"><?=$USER_ID[$lang_idx]." ".$IS_TAKEN[$lang_idx]?></div>");
		  	$("#registerform_userid").focus();
		  }
		   else if (msg.indexOf("uniq_name") > 0){
		  	$("#registerform_result").html("<div class=\"high\"><?=$DISPLAY_NAME[$lang_idx]." ".$IS_TAKEN[$lang_idx]?></div>");
		  	$("#registerform_displayname").focus();
		  }
		  else if (msg==0){
		  	 toggle('registerform_submit');
		  	 toggle('registerform_OK');
		  	 $("#registerform_OK").val("<?=$CHECK_EMAIL[$lang_idx]?>");
		  	 $("#registerform_OK").addClass("success");
		  }
		  else
		      $("#registerform_result").html( msg );
		    
		  
		     
		});
        }
        function passforgot_to_server()
        {
                if ($("#passforgotform_email").val().length == 0){
                	alert('<?=$EMAIL[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                	$("#passforgotform_email").focus();
                	return false;
                }
                $("#passforgotform_result").html("");
                 
                   
        	$.ajax({
		  type: "POST",
		  url: "checkauth.php?action=forgotpass&lang=<?=$lang_idx?>",
		  data: { email: $("#passforgotform_email").val() }
		}).done(function( msg ) {
		    toggle('passforgotform_OK');
		    toggle('passforgotform_submit');
		    $("#passforgotform_OK").val(msg );
		    $("#passforgotform_OK").addClass("success");
		});
        }
	function addlinkToMessage()
	{
		var target;
		if (($("#linkhref").val().indexOf("youtu") > 0)||
			($("#linkhref").val().indexOf("facebook") > 0))
		{
			target = "\" target=\"_blank\">";
		}
		else
			 target = "\" rel=\"external\">";

		$("#body").val($("#body").val() + " <a href=\"" + $("#linkhref").val() + target + $("#linktitle").val() + "</a> ");
		$("#cboxClose").click();
		$("#body").focus();
		
	}
	function closeLinktoMessage()
	{
				
		$("#cboxClose").click();
					
	}

	function addMoodToMessage(mood)
	{
		
		//$("#chat_mood").html("<input type=\"hidden\" value=\"" + img.src + "\" name=\"mood_img\" />");
		$("#chat_mood").html("<a class=\"mood\" title=\"אייקון שמתאים למצב רוחך\" href=\"javascript:void(0)\">" + "<div class='" + mood.className + "' id=\"mood_img\" title=\"" + getMoodTitle(mood.className) + "\" />" + "</a>");
		$("#cboxClose").click();
	
	}

	function getMoodTitle(imagename)
{
	
	var title = "";
	if (imagename.indexOf('hot') > 0)
		title = "<?=$IMHOT[$lang_idx]?>";
	else if (imagename.indexOf('kiss')> 0)
		title = "<?=$KISS[$lang_idx]?>";
	else if (imagename.indexOf('confuse')> 0)
		title = "<?=$CONFUSE[$lang_idx]?>";
	else if (imagename.indexOf('amazed')> 0)
		title = "<?=$AMAZED[$lang_idx]?>";
	else if (imagename.indexOf('cold')> 0)
		title = "<?=$IMCOLD[$lang_idx]?>";
	else if (imagename.indexOf('angry')> 0)
		title = "<?=$ANGRY[$lang_idx]?>";	
	else if (imagename.indexOf('tire')> 0)
		title = "<?=$TIRE[$lang_idx]?>";
	else if (imagename.indexOf('smiley')> 0)
		title = "<?=$HAPPY[$lang_idx]?>";
	else if (imagename.indexOf('embarrassed')> 0)
		title = "<?=$EMBARRASED[$lang_idx]?>";
	else if (imagename.indexOf('wink')> 0)
		title = "<?=$WINK[$lang_idx]?>";
	else if (imagename.indexOf('sad')> 0)
		title = "<?=$SAD[$lang_idx]?>";
	else if (imagename.indexOf('satisfied')> 0)
		title = "<?=$SATISFIED[$lang_idx]?>";
	else if (imagename.indexOf('doubt')> 0)
		title = "<?=$DOUBT[$lang_idx]?>";
	else if (imagename.indexOf('cool')> 0)
		title = "<?=$COOL[$lang_idx]?>";
	else if (imagename.indexOf('curious')> 0)
		title = "<?=$CURIOUS[$lang_idx]?>";
	else if (imagename.indexOf('digging')> 0)
		title = "<?=$DIGGING[$lang_idx]?>";
	else if (imagename.indexOf('pudency')> 0)
		title = "<?=$PUDENCY[$lang_idx]?>";
	else if (imagename.indexOf('hell')> 0)
		title = "<?=$HELL[$lang_idx]?>";
	return title;
}
 function getMessageService(filter, start, update)
	{	
		
		var name = document.getElementById('name').innerHTML;
		var body = document.getElementById('body').value;
                var category = 0;
		var mood_img = document.getElementById('mood_img');
		var mood_elm = "";
		if ((mood_img != null)&&(mood_img != 'undfined')) 
		{
			mood_elm = "<div class=\"" + mood_img.className + "\" title=\"" + mood_img.title + "\" ></div>";
		}
		
		var searchname = document.getElementById('searchname');
		if (searchname != null)
			searchname = searchname.value;
			else
				 searchname = '';
		
		if ((filter == '') && 
			((searchname == '') || (searchname == null)) && 
			((name == '' ||  body == '' || body == '<?=$BODY[$lang_idx]?>' || name == '<?=$NAME[$lang_idx]?>')))
		{
			return false;
		}
		
		var idx = "";
                var msgDetails = document.getElementById('msgDetails');
		var idxs = msgDetails.getElementsByTagName("input"); 
		for (var i = 0; i < idxs.length; i++) { 
			if (idxs[i].type=="checkbox")  
				if (idxs[i].checked) { 
					idx = idxs[i].value; 
				}
		}
		var limit = "<?=$limitLines?>";
		if ((filter != "") && (filter != "undefined"))
			limit = filter;
		if (update == 0)
		{
			body = '';
			name = '';
		}
		
		restoreTopDiv();
		
		var postData = "lang=" + "<?=$lang_idx?>" + "&limit=" + limit + "&startLine=" + start + "&category=" + category + "&idx=" + idx + "&name=" + escape(encodeURI(name)) + "&searchname=" + escape(encodeURI(searchname)) + "&body=" + escape(encodeURI(body)) + "&mood=" + escape(encodeURI(mood_elm))  + "&update=<?=$_GET['update']?>";
		fillMessage('<img src="images/loading.gif" alt="loading" />');
		$('input[name="SendButton"]').attr("disabled", "disabled");
		var ajax = new Ajax();
		ajax.method = 'POST';
		ajax.setMimeType('text/html');
		ajax.postData = postData;
		ajax.setHandlerBoth(fillMessage);
		ajax.url = 'chat_service.php';
		ajax.doReq();
		
	}
 function startup(page)
        {
        	if (document.getElementById('chatWrapper'))
		{
                        $.ajax({
			  type: "GET",
			  url: "checkauth.php?action=getuser&lang=<?=$lang_idx?>"
			}).done(function( jsonstr ) {
			  try{
	                     
	                     var jsonT = JSON.parse( jsonstr  );
	                     if (!jsonT.user.loggedin)
	                         {
	                            toggle('notloggedin');
	                            if (jsonT.user.locked)
	                                alert('<?=$USER_LOCKED[$lang_idx]?>');
	                         }
	                       else {
	                         toggle('loggedin'); 
	                         fillUserDetails (jsonstr );
	                       }
	                       if (page > 0)
				{
					getMessageService(<?=$limitLines?>, <?echo ($p*$numberofPages*$limitLines);?>, 0);
				}
				else
				{
	                                fillMessage('<img src="images/loading.gif" alt="loading" />');
					var ajax = new Ajax();
					ajax.method = 'POST';
					ajax.setMimeType('text/html');
					ajax.setHandlerBoth(fillMessage);
					ajax.postData = "lang=" + "<?=$lang_idx?>" + "&limit=" + "<?=$limitLines?>" + "&update=<?=$_GET['update']?>";
					ajax.url = 'chat_service.php';
					ajax.doReq();
				}
		                                                           
		                 }
		                 catch (e) {
		                     alert("error:" + e);
		                     
		                  }
			});
			attachEnter();
			
		}
           
            
        }
//-->
</script>
 
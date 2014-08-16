<a id="chat" ></a>


	
	<input type="hidden" value="" name="current_new_msg_idx" id="current_new_msg_idx" />
	<input type="hidden" value="" id="current_display_name" />	
	
	<div class="span9 offset3" id="msgDetails">
				
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
        
	
<div style="display:none">
<div id="profileform" style="padding:1em" >
    <div class="float">
    
    <table>
    <tr><td><?=$EMAIL[$lang_idx]?>:</td><td><input type="text" name="email" value="" readonly="readonly" id="profileform_email" size="30"/></td></tr>
    <tr><td><?=$PASSWORD[$lang_idx]?>:</td><td><input type="password" name="password" value="" id="profileform_password"/></td></tr>
    <tr><td><?=$USER_ICON[$lang_idx]?>:</td><td><div class="inv_plain_3"><div class="user_icon_frame">
<div id="user_icon_contentbox" class="contentbox-wrapper"> <? $user_icons = array(); $user_icons = getfilesFromdir("img/user_icon"); foreach ($user_icons as $user_icon)
            { ?>
    <div class="contentbox">
            <div class='<? $user_icon_name =explode(".", end(explode("/",$user_icon[1]))); echo $user_icon_name[0];?>' style="width:36px;height:36px">&nbsp;</div>

    </div>
        <? }?></div>
 </div>
 <div class="icon_left" onclick="change_icon('left'); return false"></div>
<div class="icon_right" onclick="change_icon('right'); return false"></div>
            </div>
</td></tr>
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
        <?=$PASSWORD[$lang_idx]?>:<input type="password" name="password" value="" id="loginform_password" tabindex="2" size="15"/><br />&nbsp;&nbsp;
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
    <tr><td><?=$USER_ICON[$lang_idx]?>:</td><td><div class="inv_plain_3"><div class="user_icon_frame">
    <div id="user_icon_contentbox" class="contentbox-wrapper"> <? $user_icons = array(); $user_icons = getfilesFromdir("img/user_icon"); foreach ($user_icons as $user_icon)
                { ?>
        <div class="contentbox">
                <div class='<? $user_icon_name =explode(".", end(explode("/",$user_icon[1]))); echo $user_icon_name[0];?>' style="width:36px;height:36px">&nbsp;</div>

        </div>
            <? }?></div>
     </div>
     <div class="icon_left" onclick="change_icon('left'); return false"></div>
    <div class="icon_right" onclick="change_icon('right'); return false"></div>
                </div>
    </td></tr>
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
 
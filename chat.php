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
								<div class="clear"><a href="javascript: void(0)" class="button" id="login" title="<?=$LOGIN[$lang_idx]?>" ><?=$LOGIN[$lang_idx]?></a></div>
								<div class="clear"><a href="javascript: void(0)" class="button register" id="register" title="<?=$REGISTER[$lang_idx]?>"><?=$REGISTER[$lang_idx]?></a></div>
								
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
        <input type="hidden" id="chosen_user_icon" value=""/>
	<div  class="small" id="inputFieldsDiv">
	    <div id="new_post_btn" onclick="openNewPost(<?=$lang_idx?>)">
				<?=$CREATE_NEW_MSG[$lang_idx]?>
		</div>
		<div class="span4 white_box" id="new_post">
				<div id="new_post_user"></div>                               
				<textarea id="new_post_ta"></textarea>
                                <div id="new_post_alert"><input type="checkbox" id="check_alert_msg" /><?=$ALERT_MSG_TO_SENDER[$lang_idx]?></div>
                                <div id="new_post_private" style="display:none"><input type="checkbox" id="check_private_msg" /><?=$PRIVATE_MSG_TO_SENDER[$lang_idx]?></div>
                                <div id="new_post_cancel" onclick="closeNewPost();restoreTopDiv();"><?=$CANCEL[$lang_idx]?></div>
				<div id="new_post_okay" onclick="getMessageService(<?=$limitLines?>, '', 0, 1, <?=$lang_idx?>, $('#current_forum_filter').attr('key'));closeNewPost()"><?=$SEND[$lang_idx]?></div>               
		</div>
	</div>
	<div id="chat_links">
			<div>   
			
			<a href="<? echo get_query_edited_url($url_cur, 'section', 'SendEmailForm.php');?>" title="<?=$MANAGER[$lang_idx]?>">
				<?=$CONTACT_ME[$lang_idx]." - ".$PRIVATE_MSG[$lang_idx]?><?=get_arrow()?>
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
	<div class="big" style="padding:2em">
            <a href='javascript:void(0)' onclick="getNextPage(<?=$lang_idx?>, <?=$limitLines?>)">עוד הודעות</a>
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
	
</div>
</div>
</div>
<div style="display:none">
<div id="profileform" style="padding:0.5em" >
                            <div class="float">

                            <table>
                            <tr><td><?=$EMAIL[$lang_idx]?>:</td><td><input type="text" name="email" value="" readonly="readonly" id="profileform_email" size="30"/></td></tr>
                            <tr><td><?=$PASSWORD[$lang_idx]?>:</td><td><input type="password" name="password" value="" id="profileform_password"/></td></tr>
                            <tr><td><?=$USER_ICON[$lang_idx]?>:</td><td><div><div class="user_icon_frame">
                        <div id="user_icon_contentbox" class="contentbox-wrapper"> <? $user_icons = array(); $user_icons = array_reverse(getfilesFromdir("img/user_icon")); foreach ($user_icons as $user_icon)
                                    { ?>
                            <div class="contentbox">
                                    <div class='<? $user_icon_name =explode(".", end(explode("/",$user_icon[1]))); echo $user_icon_name[0];?>'>&nbsp;</div>

                            </div>
                                <? }?></div>
                         </div>
                         <div class="icon_left" onclick="change_icon('left', this); return false"></div>
                        <div class="icon_right" onclick="change_icon('right', this); return false"></div>
                                    </div>
                        </td></tr>
                            <tr><td><?=$DISPLAY_NAME[$lang_idx]?>:</td><td><input type="text" name="user_display_name" value="" id="profileform_displayname"/></td></tr>
                            <tr><td><?=$NICE_NAME[$lang_idx]?>:</td><td><input type="text" name="user_nice_name" value="" id="profileform_nicename"/></td></tr>
                            </table>
                            <input type="checkbox" name="priority" value="" id="profileform_priority"/><?=$GET_UPDATES[$lang_idx]?><br />
                            </div>

                            <div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
                            <div id="profileform_result" class="float"></div>
                            <input type="submit" value="<?=$UPDATE_PROFILE[$lang_idx]?>" onclick="updateprofile_to_server(<?=$lang_idx?>)" id="profileform_submit" class="invfloat clear inv_plain_3"/>
                            <input type="submit" value="<?=$DONE[$lang_idx]?>" onclick="$('#cboxClose').click();window.location.reload()" id="profileform_OK" class="info invfloat inv_plain_3" style="display:none"/>


   </div>
</div>

 <div style="display:none">
      
<div id="loginform" style="padding:1em">
	<div class="float">
        <input type="text" name="email" value="" placeholder="<?=$EMAIL[$lang_idx]?>" id="loginform_email" size="30" tabindex="1" style="direction:ltr"/><br /><br />
        <input type="password" name="password" placeholder="<?=$PASSWORD[$lang_idx]?>" value="" id="loginform_password" tabindex="2" size="15"/><br /><br />
        </div>
        <div class="clear float big" style="padding:1em 0">
        <input type="checkbox" name="rememberme" value="" id="loginform_rememberme"/><?=$REMEMBER_ME[$lang_idx]?>
        </div>  
	<div style="display:none" class="float loading"><img src="images/loading.gif" alt="loading" width="32" height="32"/></div>
        <div id="loginform_result" class="float"></div>
	<input type="submit" value="<?=$LOGIN[$lang_idx]?>" class="invfloat clear inv_plain_3 big" onclick="login_to_server(<?=$lang_idx?>)" id="loginform_submit"/>
        <input type="submit" value="Success!" onclick="$('#cboxClose').click();window.location.reload();" id="loginform_OK" class="info invfloat" style="display:none"/>
        <div class="clear float big" style="margin-top:0.8em"><a href="javascript: void(0)" id="forgotpass" title="<?=$FORGOT_PASS[$lang_idx]?>"><?=$FORGOT_PASS[$lang_idx]?></a></div>
 	
</div>
<div id="registerform" style="padding:0.5em">
<div id="registerinput" class="float">
<table>
<tr><td></td><td><input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="registerform_email" size="30" tabindex="3" style="direction:ltr"/></td></tr>
<tr><td></td><td><input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="registerform_password" tabindex="4"/></td></tr>
<tr><td></td><td><input type="password" placeholder="<?=$PASSWORD_VERIFICATION[$lang_idx]?>" name="password_verif" value="" id="registerform_password_verif" tabindex="5"/></td></tr>
<tr><td></td><td><input type="text" name="username" placeholder="<?=$USER_ID[$lang_idx]?>" value="" id="registerform_userid" tabindex="6"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?=get_s_align()?>:-100px"><?=$USER_ID_EXP[$lang_idx]?></span></a></td></tr>
<tr><td></td><td><?=$USER_ICON[$lang_idx]?>:<div style="display:inline-block"><div class="user_icon_frame">
<div id="user_icon_contentbox" class="contentbox-wrapper"> <? $user_icons = array(); $user_icons = array_reverse(getfilesFromdir("img/user_icon")); foreach ($user_icons as $user_icon)
            { ?>
    <div class="contentbox">
            <div class='<? $user_icon_name =explode(".", end(explode("/",$user_icon[1]))); echo $user_icon_name[0];?>'>&nbsp;</div>

    </div>
        <? }?></div>
 </div>
 <div class="icon_left" onclick="change_icon('left', this); return false"></div>
<div class="icon_right" onclick="change_icon('right', this); return false"></div>
            </div>
</td></tr>
<tr><td></td><td><input type="text" placeholder="<?=$DISPLAY_NAME[$lang_idx]?>" name="user_display_name" value="" id="registerform_displayname" tabindex="7"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?=get_s_align()?>:-100px"><?=$DISPLAY_NAME_EXP[$lang_idx]?></span></a></td></tr>
<tr><td></td><td><input type="text" placeholder="<?=$NICE_NAME[$lang_idx]?>" name="user_nice_name" value="" id="registerform_nicename" tabindex="8"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?=get_s_align()?>:-100px"><?=$NICENAME_EXP[$lang_idx]?></span></a></td></tr>
</table>
<input type="checkbox" name="priority" value="" id="registerform_priority"/><?=$GET_UPDATES[$lang_idx]?>
</div>
<div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
<div id="registerform_result" class="float">
</div>
<input type="submit" value="<?=$REGISTER[$lang_idx]?>" class="invfloat clear inv_plain_3" onclick="register_to_server(<?=$lang_idx?>)" id="registerform_submit"/>
<input type="submit" value="Success!" onclick="$('#cboxClose').click();" id="registerform_OK" class="info invfloat" style="display:none"/>

</div>

<div id="passforgotform" style="padding:1em">
                                <?=$EMAIL[$lang_idx]?>:<input type="text" name="email" value="" id="passforgotform_email" size="30" style="direction:ltr"/><br /><br />
                                <div id="passforgotform_result"></div>
                                <input type="submit" value="<?=$FORGOT_PASS[$lang_idx]?>" onclick="passforgot_to_server(<?=$lang_idx?>)" id="passforgotform_submit" class="info invfloat"/>
                                <input type="submit" value="<?=$CLOSE[$lang_idx]?>" onclick="$('#cboxClose').click();" id="passforgotform_OK" class="info invfloat" style="display:none"/>
                                    
 </div>
 </div>

 
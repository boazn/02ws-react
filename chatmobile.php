
<?php

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
<style>
    #logo {
        float:<? echo get_s_align();?>
    }
</style>
<a id="chat" ></a>
<div id="forum">
<div id="chat_entire_div">
<div id="chatWrapper">
	<div id="chat_title" class="big slogan">
	  <a href="javascript:void(0)" onclick="startup(<?=$lang_idx?>, <?=$limitLines?>, '')">
		<?=$CHAT_TITLE[$lang_idx]?>&nbsp;
	   </a>
	</div>
	<div id="chat_filter">
		
	</div>
           
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
	                if ($_GET['section'] == "chatmobile.php")
	                {
			?>
			<div id="chat_search">
	                <input id="searchname" name="searchname" size="8" maxlength="50" value="" style="text-align:<?if (isHeb()) echo "right"; else "left";?>" />&nbsp;&nbsp;
	                <input type="button" name="SearchSendButton" value="<?=$SEARCH_IN[$lang_idx]?>" onclick="getMessageService(<?=$limitLines?>, '', 0, 1, <?=$lang_idx?>)"/>
	            
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
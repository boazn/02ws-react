<?php
header('Content-type: text/html; charset=utf-8');
include_once("include.php"); 
include_once("start.php");
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap<?=$lang_idx; ?>.css" type="text/css" >
<link rel="stylesheet"  href="css/main<?=$lang_idx;?>.css" type="text/css">
<link rel="stylesheet" href="<?=BASE_URL?>/css/mobile<?=$lang_idx;?>.css" type="text/css" />
<title>Login/Register</title>
<style>
	body{
		background: white;
	}
	#forgotpass
	{
		text-decoration: none;
	}
</style>
</head>
<body >
<?if ($_GET['action'] == 'profileform'){?>
<div id="profileform" style="padding:0.5em" >
	<div class="float">

	
	<input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" readonly="readonly" id="profileform_email" size="30"/><br />
	<input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="profileform_password"/><br />
	<div><?=$USER_ICON[$lang_idx]?>:</div><div style="display:inline"><div class="user_icon_frame">
<div id="user_icon_contentbox" class="contentbox-wrapper"> 
		<? $user_icons = array(); $user_icons = array_reverse(getfilesFromdir("img/user_icon")); 
		foreach ($user_icons as $user_icon) { ?>
	<div class="contentbox">
			<div class='<? $user_icon_name =explode(".", end(explode("/",$user_icon[1]))); echo $user_icon_name[0];?>'>&nbsp;</div>

	</div>
		<? }?></div>
	</div>
	<div class="icon_left" onclick="change_icon('left', this); return false"></div>
<div class="icon_right" onclick="change_icon('right', this); return false"></div>
			</div><br />

	<input type="text" placeholder="<?=$DISPLAY_NAME[$lang_idx]?>" name="user_display_name" value="" id="profileform_displayname"/><br />
	<!--<input type="text" placeholder="<?=$NICE_NAME[$lang_idx]?>" name="user_nice_name" value="" id="profileform_nicename"/><br />-->
	
	<input type="checkbox" name="priority" value="" id="profileform_priority"/><?=$GET_UPDATES[$lang_idx]?><br />
	<input type="checkbox" name="personal_coldmeter" value="" id="profileform_personal_coldmeter" /><?=$PERSONAL_COLD_METER[$lang_idx]?><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<? echo get_s_align()?>:-100px"><?=$PERSONAL_COLD_METER_EXP[$lang_idx]?></span></a>
	</div>


	
	<div id="profileform_result" class="float"></div>
	<div style="clear:both;height:20px">&nbsp;</div>
	<input type="submit" value="<?=$SEND[$lang_idx]?>" onclick="updateprofile_to_server(<?=$lang_idx?>)" id="profileform_submit" class=" clear inv_plain_3_zebra"/>
	<input type="submit" value="<?=$DONE[$lang_idx]?>" onclick="$('#cboxClose').click();window.location.reload()" id="profileform_OK" class="info  inv_plain_3" style="display:none"/>


	</div>
	<?} if ($_GET['action'] == 'loginform'){?>
<div id="loginform" style="padding:1em">
							<div id="notloggedin" style="display:none">
								<div class="float clear big"><?=$LOGIN[$lang_idx]?> </div>
								<div style="clear:both;height:10px">&nbsp;</div>
								<div class="float clear">
								<input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="loginform_email" size="30" tabindex="1" style="direction:ltr"/><br /><br />
								<input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="loginform_password" tabindex="2" size="15"/><br />&nbsp;&nbsp;
								<input type="checkbox" name="rememberme" value="" id="loginform_rememberme"/><?=$REMEMBER_ME[$lang_idx]?><br /><br />
								<div style="clear:both;height:10px">&nbsp;</div>
								</div>
								<div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32"/></div>
								<div id="loginform_result" class="float"></div>
								<input type="submit" value="<?=$SEND[$lang_idx]?>" class="float clear inv_plain_3 big" onclick="login_to_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="loginform_submit"/>
								<input type="submit" value="Success!" onclick="$('#cboxClose').click();window.location.reload();" id="loginform_OK" class="info float big" style="display:none"/>
								<div style="clear:both;height:10px">&nbsp;</div>
								<a href="<?=BASE_URL?>/login_form.php?action=passforgotform" id="forgotpass" title="<?=$FORGOT_PASS[$lang_idx]?>" ><?echo $FORGOT_PASS[$lang_idx].get_arrow();?></a>
								<div style="clear:both;height:10px">&nbsp;</div>
								<label id="newto02ws" class="float clear"><?=$NEW_TO_02WS[$lang_idx]?></label> <a href="<?=BASE_URL?>/login_form.php?action=profileform" id="clicktoregister" class="float clear"><?echo $REGISTER[$lang_idx].get_arrow();?></a>
								
							</div>
							<div id="loggedin" style="display:none">
								<label id="hello" class="clear big"></label> <?=$HELLO[$lang_idx]?><br />
								<a href="login_form.php?action=profileform&lang=<?=$lang_idx?>" id="clicktoregister" class="float clear inv_plain_3 big"><?echo $UPDATE_PROFILE[$lang_idx];?></a>
								<div style="clear:both;height:10px">&nbsp;</div>
								<a href="index.php?section=myVotes.php&lang=<?=$lang_idx?>" id="clicktoregister" class="float clear inv_plain_3 big"><?echo $MY_VOTES[$lang_idx];?></a>
								<div style="clear:both;height:10px">&nbsp;</div>
								<input value="<?=$SIGN_OUT[$lang_idx]?>" onclick="signout_from_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="signout" class="button inv_plain_3_zebra clear big"/>
							</div>
		

</div>
<?} if ($_GET['action'] == 'registerform'){?>
<div id="registerform" style="padding:0.5em">
	<div class="float clear big"><?=$REGISTER[$lang_idx]?> </div>
	<div style="clear:both;height:10px">&nbsp;</div>
	<div id="registerinput" class="float clear">
	<table>
	<tr><td></td><td><input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="registerform_email" size="30" tabindex="3" style="direction:ltr"/></td></tr>
	<tr><td></td><td><input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="registerform_password" tabindex="4"/></td></tr>
	<tr><td></td><td><input type="password" placeholder="<?=$PASSWORD_VERIFICATION[$lang_idx]?>" name="password_verif" value="" id="registerform_password_verif" tabindex="5"/></td></tr>
	<!--<tr><td></td><td><input type="text" name="username" placeholder="<?=$USER_ID[$lang_idx]?>" value="" id="registerform_userid" tabindex="6"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$USER_ID_EXP[$lang_idx]?></span></a></td></tr>-->
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
	<tr><td></td><td><input type="text" placeholder="<?=$DISPLAY_NAME[$lang_idx]?>" name="user_display_name" value="" id="registerform_displayname" tabindex="7"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$DISPLAY_NAME_EXP[$lang_idx]?></span></a></td></tr>
	<!--<tr><td></td><td><input type="text" placeholder="<?=$NICE_NAME[$lang_idx]?>" name="user_nice_name" value="" id="registerform_nicename" tabindex="8"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$NICENAME_EXP[$lang_idx]?></span></a></td></tr>-->
	</table>
	<input type="checkbox" name="priority" value="" id="registerform_priority"/><?=$GET_UPDATES[$lang_idx]?><br />
	<input type="checkbox" name="personal_coldmeter" value="" id="registerform_personal_coldmeter" disabled/><?=$PERSONAL_COLD_METER[$lang_idx]?><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$PERSONAL_COLD_METER_EXP[$lang_idx]?></span></a>
	</div>
	<div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
	<div id="registerform_result" class="float">
	</div>
	<input type="submit" value="<?=$REGISTER[$lang_idx]?>" class="invfloat clear inv_plain_3" onclick="register_to_server(<?=$lang_idx?>)" id="registerform_submit"/>
	<input type="submit" value="Success!" onclick="$('#cboxClose').click();" id="registerform_OK" class="info invfloat" style="display:none"/>

</div>
<?} if ($_GET['action'] == 'passforgotform'){?>
<div id="passforgotform" style="padding:1em">
	<div><?=$FORGOT_PASS_REQ[$lang_idx]?></div>
	<input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="passforgotform_email" size="30" style="direction:ltr"/><br /><br />
	<div id="passforgotform_result" class="big"></div>
	<input type="submit" value="<?=$SEND[$lang_idx]?>" onclick="passforgot_to_server(<?=$lang_idx?>)" id="passforgotform_submit" class="info invfloat"/>
	
		
 </div>
<?}?>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
<script>!window.jQuery && document.write('<script src="/js/jquery-1.6.1.min.js"><\/script>')</script>
<script src="footerScripts161120.php?lang=<?=$lang_idx?>&temp_unit=<?echo $current->get_tempunit();?>&reg_id=<?=$_GET['reg_id']?>"  type="text/javascript"></script>
<script>
	startup(<?=$lang_idx?>, 10, "");

</script>
</html>
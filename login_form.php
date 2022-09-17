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
	#loginform input[type="text"], #loginform input[type="password"]{
		height: 2.2em;
	}
	@media only screen and (min-width: 1000px) {
		#loginform input[type="text"], #profileform input[type="text"], #registerform input[type="text"], #registerinput input[type="password"], #loginform input[type="password"]
		{
			height: 2em;
			font-size: 1em;
			width: 280px;
		}
    }
	input[type="checkbox"]{
		margin-<?=get_s_align()?>: 10px;
	}
	#registerform_priority, #registerform_personal_coldmeter{
		width:40px
	}
</style>
</head>
<body >

<div id="profileform"  style="display:none" >
	<div class="float big">

	
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
	<input type="submit" value="<?=$END[$lang_idx]?>" onclick="updateprofile_to_server(<?=$lang_idx?>)" id="profileform_submit" class="float clear inv_plain_3_zebra big"/>
	<input type="submit" value="<?=$DONE[$lang_idx]?>" onclick="$('#cboxClose').click();window.location.reload()" id="profileform_OK" class="info  inv_plain_3" style="display:none"/>


	</div>
	
<div id="loginform" style="padding:1em" >
							<div id="notloggedin" style="display:none">
								<div class="float clear big"><?=$LOGIN[$lang_idx]?> </div>
								<div style="clear:both;height:10px">&nbsp;</div>
								<div id="login_greeting" class="float clear big"><?=$LOGIN_GREETING[$lang_idx]?> </div>
								<div style="clear:both;height:30px">&nbsp;</div>
								<div class="float clear">
								<input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="loginform_email" size="30" tabindex="1"/><br /><br />
								<input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="loginform_password" tabindex="2" size="15"/><br /><br />&nbsp;&nbsp;
								<input type="checkbox" name="rememberme" value="" id="loginform_rememberme"/><?=$REMEMBER_ME[$lang_idx]?>
								<div style="clear:both;height:0px">&nbsp;</div>
								</div>
								<div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32"/></div>
								
							    <input type="submit" value="Success!" onclick="$('#cboxClose').click();window.location.reload();" id="loginform_OK" class="info float big" style="display:none"/>
								<div style="clear:both;height:0px">&nbsp;</div>
								<a href="javascript:void()" id="forgotpass" onclick="toggle('loginform');toggle('passforgotform');" title="<?=$FORGOT_PASS[$lang_idx]?>"><?echo $FORGOT_PASS[$lang_idx].get_arrow();?></a>
								<div id="loginform_result" class="float"></div>
								<input type="submit" value="<?=$END[$lang_idx]?>" class="float clear inv_plain_3_zebra big" onclick="login_to_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="loginform_submit"/>
								<div style="clear:both;height:0px">&nbsp;</div>
								<a href="javascript:void()" id="clicktoregister" onclick="toggle('loginform');toggle('registerform');" class="float"><?=$NEW_TO_02WS[$lang_idx]?>&nbsp;<?echo $REGISTER[$lang_idx].get_arrow();?></a>
								
							</div>
							<div id="loggedin" style="display:none">
								<label id="hello" class="clear big float"></label> <?=$HELLO[$lang_idx]?>,<br />
								<a href="login_form.php?action=profileform&lang=<?=$lang_idx?>" id="clicktoupdate" class=" float clear inv_plain_3_zebra big"><?echo $UPDATE_PROFILE[$lang_idx];?></a>
								<div style="clear:both;height:10px">&nbsp;</div>
								<a href="index.php?section=myVotes.php&lang=<?=$lang_idx?>" id="clicktogetvotes" class=" float clear inv_plain_3_zebra big"><?echo $MY_VOTES[$lang_idx];?></a>
								<div style="clear:both;height:10px">&nbsp;</div>
								<input value="<?=$SIGN_OUT[$lang_idx]?>" onclick="signout_from_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="signout" class="float inv_plain_3_zebra clear big"/>
							</div>
		

</div>

<div id="registerform" style="display:none" >
	<div class="clear big"><?=$REGISTER[$lang_idx]?> </div>
	<div style="clear:both;height:10px">&nbsp;</div>
	<div id="registerinput" class="float clear">
	<table>
	<tr><td></td><td><input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="registerform_email" size="30" tabindex="3" /></td></tr>
	<tr><td></td><td><input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="registerform_password" tabindex="4"/></td></tr>
	<tr><td></td><td><input type="password" placeholder="<?=$PASSWORD_VERIFICATION[$lang_idx]?>" name="password_verif" value="" id="registerform_password_verif" tabindex="5"/></td></tr>
	<!--<tr><td></td><td><input type="text" name="username" placeholder="<?=$USER_ID[$lang_idx]?>" value="" id="registerform_userid" tabindex="6"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$USER_ID_EXP[$lang_idx]?></span></a></td></tr>-->
	<tr><td></td><td><?=$USER_ICON[$lang_idx]?>:<div style="display:inline"><div class="user_icon_frame">
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
	<tr><td></td><td><input type="text" placeholder="<?=$DISPLAY_NAME[$lang_idx]?>" name="user_display_name" value="" id="registerform_displayname" tabindex="7" style="margin-top: 15px;"/><!--<a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$DISPLAY_NAME_EXP[$lang_idx]?></span></a>--></td></tr>
	<!--<tr><td></td><td><input type="text" placeholder="<?=$NICE_NAME[$lang_idx]?>" name="user_nice_name" value="" id="registerform_nicename" tabindex="8"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$NICENAME_EXP[$lang_idx]?></span></a></td></tr>-->
	</table>
	<br />
	<input type="checkbox" name="priority" value="" id="registerform_priority"/><?=$GET_UPDATES[$lang_idx]?><br /><br />
	<input type="checkbox" name="personal_coldmeter" value="" id="registerform_personal_coldmeter" /><?=$PERSONAL_COLD_METER[$lang_idx]?><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$PERSONAL_COLD_METER_EXP[$lang_idx]?></span></a>
	</div>
	<div style="display:none" class=" loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
	<div id="registerform_result" class="">
	</div>
	<input type="submit" value="<?=$END[$lang_idx]?>" class="clear inv_plain_3_zebra big" onclick="register_to_server(<?=$lang_idx?>)" id="registerform_submit"/>
	<input type="submit" value="בוצע!" onclick="$('#cboxClose').click();" id="registerform_OK" class="info invfloat" style="display:none"/>

</div>

<div id="passforgotform" class="big"  style="padding:1em;display:none">
	<div><?=$FORGOT_PASS_REQ[$lang_idx]?></div><br />
	<input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="passforgotform_email" size="30" /><br /><br />
	<div id="passforgotform_result" class="big"></div>
	<input type="submit" value="<?=$END[$lang_idx]?>" onclick="passforgot_to_server(<?=$lang_idx?>)" id="passforgotform_submit" class="inv_plain_3_zebra big info"/>
	
		
 </div>

<input type="hidden" id="chosen_user_icon" value=""/>
</body>

<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous"></script>
<script src="footerScripts180422.php?lang=<?=$lang_idx?>&temp_unit=<?echo $current->get_tempunit();?>&reg_id=<?=(empty($_REQUEST['reg_id']))? $_REQUEST['regId'] : $_REQUEST['reg_id']?>"  type="text/javascript"></script>
<script>
	
        fetch("checkauth.php?action=getuser&lang=" + <?=$lang_idx?> +"&reg_id=<?=(empty($_REQUEST['reg_id']))? $_REQUEST['regId'] : $_REQUEST['reg_id']?>")    
        .then(response => response.json())
		.then(jsonT => {console.log(jsonT);
						if (!jsonT.user.loggedin){
							toggle('notloggedin');
							$("#user_name").html('<?=$LOGIN[$lang_idx]?>/<?=$REGISTER[$lang_idx]?>');
							$("#chosen_user_icon").val($("#user_icon_contentbox").children().first().children().first().attr('class'));
							if (jsonT.user.locked)
								$("#user_name").html('<?=$USER_LOCKED[$lang_idx]?>');
						}
						else {
							toggle('loggedin'); 
							fillUserDetails (jsonT );
						}
                       })
        .catch(error => console.error("error:" + error));

			 <? if ($_GET['action'] == "passforgotform") {?>
		toggle('loginform');toggle('passforgotform');
		<?}?>
</script>
</html>
<?php
session_start();
header("Content-type:{$_SESSION['fpa_captcha']['CIM']}");
echo file_get_contents("out/{$_SESSION['fpa_captcha']['hash']}.{$_SESSION['fpa_captcha']['CIF']}");
unlink("out/{$_SESSION['fpa_captcha']['hash']}.{$_SESSION['fpa_captcha']['CIF']}");
?>
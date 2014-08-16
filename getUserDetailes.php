<?php

// Because this script sends out HTTP header information, the first characters in the file must be the <? PHP tag.

   $wmlredirect = "http://proxy.maabarot.org.il/%7EBoaz/Weather/Station/WD/wap/index.wml"; // ABSOLUTE URL to your WML file

  /*if(strpos(strtoupper(getenv('HTTP_ACCEPT')),"VND.WAP.WML") > 0) {        // Check whether the browser/gateway says it accepts WML.
    $br = "WML";
  }
  else {
    $browser=substr(trim(getenv('HTTP_USER_AGENT')),0,4);
    if($browser=="Noki" ||			// Nokia phones and emulators
      $browser=="Eric" ||			// Ericsson WAP phones and emulators
      $browser=="WapI" ||			// Ericsson WapIDE 2.0
      $browser=="MC21" ||			// Ericsson MC218
      $browser=="AUR " ||			// Ericsson R320
      $browser=="R380" ||			// Ericsson R380
      $browser=="UP.B" ||			// UP.Browser
      $browser=="WinW" ||			// WinWAP browser
      $browser=="UPG1" ||			// UP.SDK 4.0
      $browser=="upsi" ||			// another kind of UP.Browser ??
      $browser=="QWAP" ||			// unknown QWAPPER browser
      $browser=="Jigs" ||			// unknown JigSaw browser
      $browser=="Java" ||			// unknown Java based browser
      $browser=="Alca" ||			// unknown Alcatel-BE3 browser (UP based?)
      $browser=="MITS" ||			// unknown Mitsubishi browser
      $browser=="MOT-" ||			// unknown browser (UP based?)
      $browser=="My S" ||                       // unknown Ericsson devkit browser ?
      $browser=="WAPJ" ||			// Virtual WAPJAG www.wapjag.de
      $browser=="fetc" ||			// fetchpage.cgi Perl script from www.wapcab.de
      $browser=="ALAV" ||			// yet another unknown UP based browser ?
      $browser=="Wapa")                         // another unknown browser (Web based "Wapalyzer"?)
        {
        $br = "WML";
    }
    else {
      $br = "HTML";
    }
  }

  if($br == "WML") {
    header("302 Moved Temporarily");       // Force the browser to load the WML file instead
    header("Location: ".$wmlredirect);
    exit;
  }
 */
//ini_set("register_globals","off");
ini_set("session.use_trans_sid","Off");
$session_expire = 8640000000;
$cookie_expire = time()+$session_expire;

ini_set("session.cookie_lifetime",$session_expire);

session_start();
global $HTTP_SESSION_VARS;
if (isset($HTTP_SESSION_VARS['count']))
	  $HTTP_SESSION_VARS['count']++;																			
else 
    $HTTP_SESSION_VARS['count'] = 0;

$count = $HTTP_SESSION_VARS['count'] ;

if (getenv('HTTP_X_FORWARDED_FOR')){
  $ip=getenv('HTTP_X_FORWARDED_FOR');
}
else {
 $ip=getenv('REMOTE_ADDR');
} 
if (isset ($HTTP_COOKIE_VARS["numberOfVisits"])){
	$numberOfVisits = $HTTP_COOKIE_VARS["numberOfVisits"];
	$numberOfVisits++;
}
else	
	 $numberOfVisits = 0;
setcookie ("numberOfVisits", $numberOfVisits, $cookie_expire, '/', '', 0);
//print_r($_COOKIE);
//print_r($HTTP_SESSION_VARS);
$name = getenv('COMPUTERNAME') ;
$sid = session_id();
$filename = 'users.txt';
$date = date("F j, Y, g:i a", time());
$user = getenv('USERPROFILE') ;
$os = getenv('OS') ;
$username = "";
$password = "";
/*  // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence 
    // that's where $somecontent will go when we fwrite() it.
   if (!$fp = fopen($filename, 'a')) {
         print "Cannot open file ($filename)";
         exit;
    }

    // Write $somecontent to our opened file.
    if (!fwrite($fp, $somecontent)) {
        print "Cannot write to file ($filename)";
        exit;
    }
    fclose($fp);
*/
$error = false;
if ((isset ($HTTP_COOKIE_VARS["numberOfVisits"]))
//	 		||(isset($HTTP_SESSION_VARS['count']))
			){
	/* Connecting, selecting database */
	
	 $link = @mysql_connect("62.128.42.9", "boaz", "854456") or $GLOBALS['error'] = true;
    //   or print($php_errormsg);
	if (!$error){
		@mysql_select_db("boaz");
		//	   or print($php_errormsg);
		$query = "UPDATE UserDetails SET cookieVisits=$numberOfVisits, sessionVisits=$count, date='$date' WHERE (SID='$sid')";
		$result = @mysql_query($query) ;
		if (@mysql_affected_rows() == 0) {
			  $query = "INSERT INTO UserDetails VALUES ('$name','$sid','$numberOfVisits','$count','$ip','$date')";
			  $result = @mysql_query($query) ;
				//	  or print($php_errormsg);
		 }
		 /* Free resultset */
		 //  mysql_free_result($result);
		
		/* Closing connection */
		   @mysql_close($link);
	}
	
}
return $error;
?>
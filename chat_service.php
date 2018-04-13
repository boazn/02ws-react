<?

header('Content-type: text/html; charset=utf-8');
session_start();
// Connecting, selecting database
include_once("include.php"); 
include_once("lang.php");
define("MANAGER_NAME","bn19");
define("VICE_MANAGER","vmvm");

//ini_set("display_errors","On");

function isValidIP ($currnet_ip)
{
	$ips = array();
	
	array_push($ips, "87.68.36.177");
	for ($i = 0 ;$i < count($ips); $i++)
	{
		if ($currnet_ip == $ips[$i])
			return false;
        }
	return true;
}

function checkSpam()
{
    global $isAdmin;
	if ((time() - $_SESSION['CHAT_LAST_REQUEST'] < 10)
		&& ($_SERVER['REMOTE_ADDR'] == $_SESSION['CHAT_IP_ADDRESS']) 
		&& ($_SESSION['isAdmin'] != 1))
		{
			print "<div class=\"topbase\">אסור להציף את לוח ההודעות</div>";
			exit;
		}
	
	//print_r ($_SESSION);
	$_SESSION['CHAT_IP_ADDRESS'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['CHAT_LAST_REQUEST'] = time();
}
function insertNewMessage ($name, $icon, $body, $category, $p_alert)
{
    logger("insertNewMessage");
    if (empty($_SESSION['loggedin'])||($_SESSION['loggedin']=="false")){
        echo "צריך להתחבר";
        logger("empty loggedin");
        return false;
    }
            
    $now = date('Y-m-d G:i:s', strtotime(SERVER_CLOCK_DIFF, time()));
    //$now = getLocalTime(time());
    $body = nl2br($body);
    $p_email = $_SESSION['email'];
    if ($_SESSION['isAdmin'] == 1)
	        $name = "<span class=\"high\">".$name."</span>";
    $msg_total_count = $_SESSION['MsgCount'] + $_SESSION['MsgStart'];
    $name .= "<div class=\"msgcount\">#".$msg_total_count."</div>";
    if ($category == "")
        $category = 0;
    $query = "call InsertNewMsg ('$name','$icon', '$body', '$now', $category, '$p_email', '$p_alert')";
    logger($query);
    $result = db_init($query, "");
    $_SESSION['MsgStart'] = $_SESSION['MsgStart'] + 1;
    // Free resultset 
    @mysqli_free_result($result["result"]);
    global $link;
    mysqli_close($link);
		
	
}

function updateMessage ($idx, $body, $isPartialDelete)
{
        $now = date('Y-m-d G:i:s', strtotime(SERVER_CLOCK_DIFF, time()));
        $p_email = $_SESSION['email'];
        logger("last positions:".substr ($body, strlen($body)-strlen("</div>")));
        if (substr ($body, strlen($body)-strlen("</div>")) != "</div>")
        {
            logger("missing </div>: ".substr ($body, strlen($body)-strlen("</div>"))." ".strlen($body)." ".strlen("</div>")." ".$body);
            //$body = $body."</div></div>";
        }
        $query = "call UpdateMessage ($idx,'$body', '$now','$p_email')";
        //echo $query;
        $result = db_init($query, "");
        $_SESSION['MsgCount'] = $_SESSION['MsgCount'] + 1;
        // Free resultset 
        @mysqli_free_result($result);
        global $link;
        mysqli_close($link);
}
function getMsg($idx, $withName)
{
	$query = "select IP, name, body, date_chat, user_email, alert  from chat WHERE (idx=?)";
	//echo $query;
	$result = db_init( $query, $idx);
	$line = mysqli_fetch_array($result["result"]);
	@mysqli_free_result($result["result"]);
	//echo $idx." prev_body=".$line[0];
	$dateInLineStart = date("D   H:i", strtotime("0 hours -0 minutes",strtotime($line['date_chat'])));
	$dateInLineStart = replaceDays($dateInLineStart);
	global $link;
	mysqli_close($link);
        if ($withName == true)
            $line['body'] = "<div class=\"float chatnamereply\">".$dateInLineStart." <strong><span title=\"".$line['IP']."\">".$line['name']."</span></strong>: "."</div>".$line['body'];
	return $line;
}
function AddToMessage($name, $user_icon, $body, $idx, $mood)
{
	//logger("in AddToMEssage");
        $orig_name = $name;
        $msg_total_count = $_SESSION['MsgCount'] + $_SESSION['MsgStart'];
	if ($name != "")
		$body = nl2br($body);
        $line = getMsg($idx, false);
	$prev_body = $line['body'];
	if ((strlen($prev_body) + (strlen($body)) > 230))
	{
		$clearboth = "<div style=\"clear:both\"></div>";
		$firstreplyline = "";
	}
	else
	{
		$clearboth = "";
		$firstreplyline = "firstreplyline";
	}
        
        if ($_SESSION['isAdmin'] == 1)
	        $name = "<span class=\"high\">".$name."</span>";
	$body = $prev_body." ".$clearboth.HIDDENSEPERATOR." <div class=\"float chataftersepreply ".$firstreplyline." \"><div class=\"float chatbodyreply ".$firstreplyline."\">".SEPERATOR."<div class=\"avatar ".$user_icon."\"></div><div class=\"postusername\">".$name."</div><div class=\"msgcount\">#".$msg_total_count."</div>"."<div class=\"chatdatereply\">".replaceDays(date('D H:i', strtotime(SERVER_CLOCK_DIFF, time())))."</div>&nbsp;".$body."</div></div>";
	checkSpam();
        if ($_POST['private'] == "1")
        {
            send_Email($body, $line['user_email'], $_SESSION['email'], $orig_name, "", array("Private Message from 02WS forum"." - ".$orig_name, "הודעה פרטית מפורום ירושמיים"." - ".$orig_name));
        }
        else{
            updateMessage ($idx, $body, false);
        }
        if ($line['alert'] == "1")
        {
            send_Email($body, $line['user_email'], $_SESSION['email'], $orig_name, "", array("New reply for your message in 02WS forum from ".$orig_name, "תגובה חדשה להודעה שלך בפורום ירושמיים"." - ".$orig_name));
        }
}
function SaveAppendtoSession($idx)
{
	$_SESSION['APPEND_TO_MSG_IDX'] = $idx;
}
function DeletePartialMessage($idx, $nodeNumberToDelete)
{
	//print_r( "nodeToDelete:".$nodeNumberToDelete."<br /> ");
	if ($nodeNumberToDelete == 0)
        {
            $line = getMsg($idx, true);
	}
	else
        {
	    $line = getMsg($idx, false);
        }
        $prev_msg = $line['body'];
	//print_r($prev_msg);
	$nodes = explode (HIDDENSEPERATOR, $prev_msg);
	$new_body = "";
	$res = "";
	//var_dump($nodes);
	for ($i = 0; $i < count($nodes); $i++) {
		if ($i != $nodeNumberToDelete)
		{
			$new_body .= $nodes[$i];
			if ($i < count($nodes) - 1)
				$new_body .= " ".HIDDENSEPERATOR." ";
		}
		else
			$res = $nodes[$i];
		//var_dump($new_body);
	}
		
	updateMessage ($idx, $new_body, true);
	return $res;
}


function moveReplyFromTo($nodeNumberToDelete, $idxFrom, $idxTo)
{
	if (($idxFrom != "")&&($idxTo != "")) 
	{
		$msgToMove = DeletePartialMessage($idxFrom, $nodeNumberToDelete);
		//var_dump($msgToMove);
		AddToMessage("", $_SESSION['user_icon'], $msgToMove, $idxTo, $mood);
	}
}

function stickUnstickMessage ($idx, $stickValue)
{
		$now = date('Y-m-d G:i:s');
		$query = sprintf("UPDATE chat SET sticky='%d' WHERE (idx=%d)", $stickValue, $idx);
		//echo $query;
		$result = db_init($query, "");
		// Free resultset 
		@mysqli_free_result($result["result"]);
		global $link;
		mysqli_close($link);
	}

function lockUnlockMessage ($idx, $lockValue)
{
		$now = date('Y-m-d G:i:s');
		$query = sprintf("UPDATE chat SET Locked='%d' WHERE (idx=%d)", $lockValue, $idx);
		//echo $query;
		$result = db_init($query, "");
		
		// Free resultset 
		@mysqli_free_result($$result["result"]);
		global $link;
		mysqli_close($link);
}

function deleteMessage ($idx)
{
		$now = date('Y-m-d G:i:s');
		$query = "DELETE FROM chat WHERE (idx=?)";
		//echo $query;
		$result = db_init($query, $idx);
		// Free resultset 
		@mysqli_free_result($result["result"]);
		global $link;
		mysqli_close($link);
		
	}

function msgManagement($name, $body, $mood)
{
	if (strtoupper(trim($body)) == "D")
		deleteMessage($_POST['idx']);
	else if (strtoupper(trim($body)) == "L") 
		lockUnlockMessage($_POST['idx'], "1");
	else if (strtoupper(trim($body)) == "UL") 
		lockUnlockMessage($_POST['idx'], "0");
	else if (strtoupper(trim($body)) == "S") 
		stickUnstickMessage($_POST['idx'], "1");
	else if (strtoupper(trim($body)) == "U") 
		stickUnstickMessage($_POST['idx'], "0");
	else if (strtoupper(trim($body)) == "A")
		SaveAppendtoSession($_POST['idx']);
	else if (isAdvancedCommand($body))
	{
            logger("advanced command");
		$commands = explode(";", $body);
		//var_dump ($commands);
		if (trim($commands[0]) == "D")
			DeletePartialMessage($_POST['idx'], $commands[1] - 1);
		else if(trim($commands[0]) == "M")
			moveReplyFromTo($commands[1] - 1, $_POST['idx'], $_SESSION['APPEND_TO_MSG_IDX']);
	}
	else
		AddToMessage ($name, $_SESSION['user_icon'], $body, $_POST['idx'], $mood);
}

function isAdvancedCommand($body)
{
	//print_r( " isAdvancedCommand ");
	$commands = explode(";", $body);
	//var_dump ($commands); 
	if ((count($commands) > 1)&&(strlen($body)<5))
		return true;
	else
		return false;
}



 
// en = 0 ; heb = 1
if ($_POST['lang'] == "") 	
{
	$lang_idx = $HEB;
}
else
	$lang_idx = $_POST['lang'];

$limitInput = $_POST['limit'];
//echo " limitInput=".$limitInput;
$name = urldecode($_POST['name']);
$name = str_replace("'", "`", $name);
$body = urldecode($_POST['body']);
$body = str_replace("'", "`", $body);
//$body = str_replace("\"", "``", $body);
$mood = urldecode($_POST['mood']);
$isAdmin = $_SESSION['isAdmin'];
//echo $isAdmin;
$searchname = urldecode($_POST['searchname']);
$body = preg_replace('@ (https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', ' <a href="$1" rel="external">$1</a> ', $body);
if (empty($_SESSION['loggedin'])||$_SESSION['loggedin']=="false"||$name==$NAME[$HEB] || $body==$BODY[$HEB] || $name==$NAME[$EN] || $body==$BODY[$EN] || $name=="" || $body=="")

{
	//logger("chat_service: nothing to do");
	 // only display recent messages
	 if (empty($_SESSION['loggedin'])||($_SESSION['loggedin']=="false"))
	     echo "<div class=\"high\" style=\"width:100;height:2px\"></div>";
}
else if((stristr($_SERVER['HTTP_REFERER'], "02ws.co") > -1 )||(stristr($_SERVER['HTTP_REFERER'], "small.php") > -1 )){
	$orig_name = $name;
	
        //only change messages when not searching
	if ($searchname == "")
	{
            	
                
                if ($_POST['idx'] != "")
		{
			if ($_SESSION['isAdmin'] == 1)
				msgManagement($name, $body, $mood);
			else if ($_SESSION['loggedin'] == "true")
				AddToMessage ($name, $_SESSION['user_icon'], $body, $_POST['idx'], $mood);
                        else
                            logger("message id ".$_POST['idx']." ".$_SESSION['loggedin']." ".$body);
		}
		else if ($_SESSION['loggedin'] == "true")
		{
			checkSpam();
                        if ($_POST['private'] == "1")
                        {
                            send_Email($body, ME, $_SESSION['email'], $name, "", array("Private Message from 02WS forum from ".$name, "הודעה פרטית מפורום ירושמיים של ".$name));
                        }   
                        else
			insertNewMessage($mood.$name, $_SESSION['user_icon'], "<div class=\"float chatfirstbody\">".$body."</div>", $_REQUEST['category'], $_REQUEST['alert']);
		}
                else
                {
                    logger("idx=".$_POST['idx']." and not loggedin");
                }
	}
}
else{
  echo("page came from...".$_SERVER['HTTP_REFERER']." --> exit  ");
  //exit;
}
if ($_POST['startLine'] != "")
	$startLine = $_POST['startLine'];
else
	$startLine = 0;
$totalText = 0;
$filter_is_on = false;
$limitInput = $_REQUEST['from'];
if ($_REQUEST['to'] == "")
    $timestamp_to = time();
else
{
    $date_to = $_REQUEST['to'];
    $timestamp_to = mktime (0, 0, 0, substr($date_to,2,2), substr($date_to,0,2) ,substr($date_to,4,4));
}
if (strlen($limitInput) == 8){ // ddmmyyyy
	$timestamp_from = mktime (0, 0, 0, substr($limitInput,2,2), substr($limitInput,0,2) ,substr($limitInput,4,4));
	$filter_is_on = true;
}
else if (strlen($limitInput) == 7)
{
    $timestamp_from = mktime (0, 0, 0, substr($limitInput,1,2), substr($limitInput,0,1) ,substr($limitInput,3,4));
    $filter_is_on = true;
}
else if (strlen($limitInput) > 0)
	$limitLines = $limitInput;
if (($limitLines == "undefined")||($limitLines == ""))
	$limitLines = 4;
//echo $limitInput;
//echo " limitLines=".$limitLines;
$category = $_REQUEST['category'];
if ($_REQUEST['update'] == 1)
    $category = "";
//echo "from=".$timestamp_from." to=".$timestamp_to;
getCurrentChat($searchname, $filter_is_on, $startLine, $limitLines, $timestamp_from, $timestamp_to,  $category);

?>
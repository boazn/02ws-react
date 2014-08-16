<?php 
/*
 * David's Automagic PHP Picture Gallery (DAPPG)
 * Version 0.9.6
 * By: David Knowles
 * Copyright (c)2002 David Knowles
 * 
 * http://www.jab.nu/dappg/
 * dknowles@jab.nu
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/*
 * Function Declarations:
 */

function GetList() 
{
  $adir=array("");
  $handle=opendir('.'); 
  while ($file = readdir($handle)) 
    { 
      if (stristr($file, ".jpg") || stristr($file, ".gif") || 
	  stristr($file,".jpeg") || stristr($file,".tiff") ||
	  stristr($file, ".png") || stristr($file, ".tif")) 
	{ 
	  array_push($adir, $file);
	} 
    }
  closedir($handle); 
  sort ($adir);
  return $adir;
}

function pchop($schop) 
{
  $len=strlen($schop);
  $freturn=substr($schop,3,$len-3);
  return $freturn;
}

function jchop($schop) 
{
  $temp_schop = explode(".",$schop);
  if (sizeof($temp_schop) > 2)
    {
      $schop = "";
      for ($i=0; $i < sizeof($temp_schop) - 1; $i++)
	{ 
	  if ($i > 0)
	    { $schop .= "."; }
	  $schop .= $temp_schop[$i]; 
	}
    }
  else
    { $schop = $temp_schop[0]; }
  return $schop;
}

function Authenticate($config) 
{
  if (isset($config["password"])) 
    {
      if (!isset($_SERVER["PHP_AUTH_PW"])) 
	{
	  Header("WWW-Authenticate: Basic realm=\"Restricted Area\"");
	  Header("HTTP/1.0 401 Unauthorized");
	  print "You are not authorized to view this page.\n";
	  exit;
	  return false;
	}  
      if ($_SERVER["PHP_AUTH_PW"]==$config["password"]) 
	{ return true; } 
      else 
	{
	  print "You are not authorized to view this page.\n";
	  return false;
	}
    } 
  else 
    { return true; }
}

function ShowConfig() 
{
  if (file_exists("./pic.conf.php")) 
    { @require_once("./pic.conf.php"); }
  if (Authenticate($config)==true) 
    {
      print '<html>
<head>
 <title>DAPPG Configuration</title>
<style type="text/css">
<!--
 body      { color: #000000; background: #C0C0C0; font-family: tahoma,verdana,arial,helvetica,sans-serif; font-size: 10pt; }
 a         { color: #000080; }
 a:visited { color: #000080; }
 a:active  { color: #000080; }
 a:hover   { color: #0000FF; }
 b { font-weight: bold; }
 table { padding: 2px; }
 td { padding: 0px 2px 2px 4px; font-family: tahoma,verdana,arial,helvetica,sans-serif; font-size: 10pt; }
 td.left { background: 737373; color: ffffff; }
 td.right { background: a7a7a7; text-align: left; halign: left; }
 td.bottom { background: dadada; }
 .title { font-weight: bold; font-family: georgia, times new roman; font-size: 24pt; }
-->
</style>
</head>
<body>
<form method="post" action="' . $_SERVER["PHP_SELF"] . '" />
<input type="hidden" name="write_config" value="true" />

<div class="title">DAPPG Configuration Editor</div>
Here, you can define how you want your picture gallery to look and behave.  <br />
You can access this page at any time by viewing: <br />
<a href="?configure=true">http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_FILENAME'] . '?configure=true</a>
<br /><br />
<table width="450">
 <tr>
  <td class="left" width="1%">
   <b>Title:</b>
  </td>
  <td class="right">
   <input type="text" name="title" value="' . $config["title"] . '">
  </td>
 </tr>
 <tr> 
  <td class="bottom" colspan="2">
   The title that goes in the Browser\'s Titlebar
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Title_big:</b>
  </td>
  <td class="right">
   <input type="text" name="title_big" value="' . $config["title_big"] . '">
  </td>
 </tr>
 <tr>
  <td class="bottom" colspan="2">
   The title that goes on the top of the index page.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Pic_Author:</b>
  </td>
  <td class="right">
   <input type="text" name="pic_author" value="' . $config["pic_author"] . '">
  </td>
 </tr>
 <tr>
  <td class="bottom" colspan="2">
   The name of the photographer.  Places a copyright with the photographer\'s name at the bottom of each page.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Email:</b>
  </td>
  <td class="right">
   <input type="text" name="email" value="' . $config["email"] . '">
  </td>
 </tr>
 <tr> 
  <td class="bottom" colspan="2">
   When entered, it makes the photographer\'s name a mailto: link.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Date:</b>
  </td>
  <td class="right">
   <input type="text" name="date" value="' . $config["date"] . '">
  </td>
 </tr>
 <tr>
  <td class="bottom" colspan="2">
   The date(s) on which the pictures were taken.  
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>BGcolor:</b>
  </td>
  <td class="right">
   <input type="text" name="bgcolor" value="' . $config["bgcolor"] . '" maxlength="6">
  </td>
 </tr>
 <tr> 
  <td class="bottom" colspan="2">
   The Background color of all the pages.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Text:</b>
  </td>
  <td class="right">
   <input type="text" name="text" value="' . $config["text"] . '" maxlength="6">
  </td>
 </tr>
 <tr>
  <td class="bottom" colspan="2">
   The color of the non-link text on the pages.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Link:</b>
  </td>
 <td class="right">
   <input type="text" name="link" value="' . $config["link"] . '" maxlength="6">
 </td>
 </tr>
 <tr> 
  <td class="bottom" colspan="2">
   The color of the links.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>ALink:</b>
  </td>
  <td class="right">
   <input type="text" name="alink" value="' . $config["alink"] . '" maxlength="6">
  </td>
 </tr>
 <tr>
  <td class="bottom" colspan="2">
   The color of the active Links.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>VLink:</b>
  </td>
  <td class="right">
   <input type="text" name="vlink" value="' . $config["vlink"] . '" maxlength="6">
  </td>
 </tr>
 <tr>
  <td class="bottom" colspan="2">
   The color of the visted links.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>HLink:</b>
  </td>
  <td class="right">
   <input type="text" name="hlink" value="' . $config["hlink"] . '" maxlength="6">
  </td>
 </tr>
 <tr>
  <td class="bottom" colspan="2">
   The color the links turn when the mouse hovers over them.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Outline:</b>
  </td>
  <td class="right">
   <input type="text" name="outline" value="' . $config["outline"] . '" maxlength="6">
  </td>
 </tr>
 <tr>
  <td class="bottom" colspan="2">
   The color of the outline around the pictures, and the index.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Show_Pic_Name:</b>
  </td>
  <td class="right">
   <input type="checkbox" name="show_pic_name" value="checked" ' . $config["show_pic_name"] . '>
  </td>
 </tr>
 <tr>
  <td class="bottom" colspan="2">
   When checked, this places the filename under each picture.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Index_Page:</b>
  </td>
  <td class="right">
   <input type="checkbox" name="index_page" value="checked" ' . $config["index_page"] . '>
  </td>
 </tr>
 <tr> 
  <td class="bottom" colspan="2">
   When checked, it makes the first page an index of all the pictures.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Numbered:</b>
  </td>
  <td class="right">
   <input type="checkbox" name="numbered" value="checked" ' . $config["numbered"] . '>
  </td>
 </tr>
 <tr> 
  <td class="bottom" colspan="2">
   When checked, it strips the first two characters from each filename.  This only takes effect if Show_Pic_Name is enabled.  
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Strip_EXT:</b>
  </td>
  <td class="right">
   <input type="checkbox" name="strip_ext" value="checked" ' . $config["strip_ext"] . '>
  </td>
 </tr>
 <tr> 
  <td class="bottom" colspan="2">
   When checked, this strips the file extension from the displayed filename.
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Desc:</b>
  </td>
  <td class="right">
   <input type="checkbox" name="desc" value="checked" ' . $config["desc"] . '>';
      if (sizeof($config["descriptions"]) > 0)
	{ 
	  print '
   <a href="?pic=1&edit_desc=true">Edit descriptions</a>';
	}
      print '
  </td>
 </tr>
 <tr> 
  <td class="bottom" colspan="2">
   When checked, enables descriptions to be placed under the pictures.  ';
      if (sizeof($config["descriptions"]) == 0)
	{ 
	  print '
   Once you click the "write config" button, you will be able to edit the descriptions of each picture.';
	}
      print '
   <br /><br />
  </td>
 </tr>
 <tr>
  <td class="left">
   <b>Password:</b>
  </td>
  <td class="right">
   <input type="text" name="password" value="' . $config["password"] . '">
  </td>
 </tr>
 <tr> 
  <td class="bottom" colspan="2">
   Sets the password for this configuration utility. 
   <br /><br />
  </td>
 </tr>
</table>
<br />
<input type="Submit" value=" write config ">
</form>
</body>
</html>
';
    }
}

function WriteNewConfig()
{
  if (file_exists("./pic.conf.php"))
    { @require_once("./pic.conf.php"); }
  if (Authenticate($config)==true)
    {
      @$fp = fopen("./pic.conf.php", "w") 
	or die("Could not write to pic.conf.php.  Make sure the file has the correct permissions set.");
      ftruncate($fp,0);
      
      $config_data='<?php
/* **********************************************
 * DAPPG
 * Config File
 *
 * This file was automatially generated.  
 * To edit the file, go to:
 * http://path/to/here/index.php?configure=true
 *
 */
$config=array(
"title"=>"' . stripslashes($_POST["title"]) . '"
,"title_big"=>"' . stripslashes($_POST["title_big"]) . '"
,"pic_author"=>"' . stripslashes($_POST["pic_author"]) . '"
,"email"=>"' . stripslashes($_POST["email"]) . '"
,"date"=>"' . $_POST["date"] . '"
,"bgcolor"=>"' . $_POST["bgcolor"] . '"
,"text"=>"' . $_POST["text"] . '"
,"link"=>"' . $_POST["link"] . '"
,"alink"=>"' . $_POST["alink"] . '"
,"vlink"=>"' . $_POST["vlink"] . '"
,"hlink"=>"' . $_POST["hlink"] . '"
,"outline"=>"' . $_POST["outline"] . '"
,"show_pic_name"=>"' . $_POST["show_pic_name"] . '"
,"index_page"=>"' . $_POST["index_page"] . '"
,"numbered"=>"' . $_POST["numbered"] . '"
,"strip_ext"=>"' . $_POST["strip_ext"] . '"
,"password"=>"' . $_POST["password"] . '"
,"desc"=>"' . $_POST["desc"] . '"
,"descriptions"=>array(';
      if (sizeof($config["descriptions"]) > 0)
	{ 
	  foreach ($config["descriptions"] as $a => $b)
	    { $config_data .= '"' . $a . '" => "' . $b . '",' . "\n"; }
	}
      $config_data .=' )
);
?>
';
      fputs($fp,$config_data);
      fclose($fp);
      
      if ($config["desc"]==true && sizeof($config["descriptions"])==0)
	{ Header("Location: ./?pic=1&edit_desc=true"); }
      else
	{ Header("Location: ./"); }
    }
}
function WriteConfig()
{
  global $config, $adir;

  if (!$config && file_exists("./pic.conf.php"))
    { @require_once("./pic.conf.php"); }

  if (Authenticate($config)==true)
    {
      @$fp = fopen("./pic.conf.php", "w") 
	or die("Could not write to pic.conf.php.  Make sure the file has the correct permissions set.");
      ftruncate($fp,0);
      
      $config_data = '<?php
/* **********************************************
 * DAPPG
 * Config File
 *
 * This file was automatially generated.  
 * To edit the file, go to:
 * http://path/to/here/index.php?configure=true
 *
 */
$config=array(
';
      if ($config)
	{
	  foreach ($config as $n => $m)
	    {
	      $config_data .= '  "' . $n . '" => ';
	      if (is_array($m))
		{
		  $config_data .= "array(\n";
		  foreach ($m as $o => $p)
		    {
		      $config_data .= "    \"" . $o . "\" => \"";
		      if ($o == $adir[$_POST['edit_pic']])
			{ 
			  $config_data .= $_POST[$_POST['edit_pic']];
			  $added=true;
			}
		      else
			{ $config_data .= $p; }
		      $config_data .= "\",";
		      $config_data .= "\n";
		    } 
		  if ($added != true)
		    { $config_data .= '    "' . $adir[$_POST['edit_pic']] . '" => "' . $_POST[$_POST['edit_pic']] . '",' . "\n"; }
		  $config_data .= "  ),";
		}	  
	      else
		{ $config_data .= '"' . $m . '",'; }
	      $config_data .= "\n";
	    }
	}
      else
	{ $config_data .= '"descriptions" => array("' . $adir[$_POST['edit_pic']] . '" => "' . $_POST[$_POST['edit_pic']] . '")'; }
      $config_data .= ");\n?>\n";
      
      fputs($fp,$config_data);
      fclose($fp);
    }
}
function ShowIndex()
{
  global $adir, $n, $config;
  print '<html>
<head>
<title>' . $config["title"] . '</title>
<style type="text/css">
<!--
body      { color: #' . $config["text"] . '; background: #' . $config["bgcolor"] . '; font-family: tahoma,verdana,arial,helvetica; font-size; 10pt; }
a         { color: #' . $config["link"] . '; }
a:active  { color: #' . $config["alink"] . '; }
a:visited { color: #' . $config["vlink"] . '; }
a:hover   { color: #' . $config["hlink"] . '; }
.title    { font-family: georgia, times new roman; font-weight: bold; font-size: 24pt; text-align: center; margin: 0px; }
.date     { font-size: 10pt; text-align: right; margin: 0px; }
td        { font-family: tahoma,verdana,arial,helvetica; font-size: 10pt; }
td.index  { padding: 20px 5px; background: #' . $config["bgcolor"] . '; border: 1px solid #' . $config["outline"] . '; }
-->
</style>
</head>
<body>
<div align="center">
<table border="0" width="500" height="100%">
 <tr>
  <td>
   <table width="100%">
    <tr>
     <td>
      <div class="title">' . $config["title_big"] . '</div>
      <div class="date">' . $config["date"] . '</div>
     </td>
    </tr>
    <tr> 
     <td valign="top" class="index">' . "\n";

  if ($GLOBALS['edit_desc'])
    {
      print '
      You have now added descriptions to all your pictures.  To change a description, click a picture\'s name below.  
      To change them later, you can use the <a href="?configure=true">Configuration Editor</a>.  If you are happy with
      your descriptions, you can view the normal index by clicking <a href="./">here</a>.<br /><br />' . "\n";
    }

  $a=1;
  while ($a < $n) 
    {
      $filename = $adir[$a];
      if ($config["numbered"]) 
	{ $filename = pchop($filename); } 
      if ($config["strip_ext"]) 
	{ $filename = jchop($filename); }

      print "      <a href=\"?pic=$a\">" . $filename . "</a>";
      if ($config["descriptions"][$adir[$a]])
	{ print " - " . stripslashes($config["descriptions"][$adir[$a]]); }
      print "<br />\n";
      $a++;
    }

  print '     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr height="1">
  <td height="1" valign="bottom" align="middle">' . "\n";

  if ($config["pic_author"])
    { 
      if ($config["email"])
	{ $config["pic_author"]='<a href="mailto:' . $config["email"] . '">' . $config["pic_author"] . '</a>'; }
      print '   Pictures &copy; ' . date("Y") . " " . $config["pic_author"] . ", all rights reserved.<br />\n"; 
    } 

  print '   Powered by <a href="http://www.jab.nu/dappg/">David\'s Automagic PHP Picture Gallery</a>
  </td>
 </tr>
</table>
</body>
</html>';
}

function ShowPic($pic)
{
  global $adir, $n, $config;
  if ($pic == $n - 1) 
    { $next = 0; }
  else 
    { $next = $pic + 1; }
  if ($pic - 1 == 0) 
    { $prev = 0; }
  else 
    { $prev = $pic - 1; }

  if ($GLOBALS['edit_desc'])
    { $edit_desc = "&edit_desc=true"; }

  print '<html>
<head>
<title>' . $config["title"] . ' [' . $pic . ' of ' . $n . '] - ' . $adir[$pic] . '</title>
<style type="text/css">
<!--
body      { color: #' . $config["text"] . '; background: #' . $config["bgcolor"] . '; font-family: tahoma,verdana,arial,helvetica; font-size; 10pt; }
a         { color: #' . $config["link"] . '; }
a:active  { color: #' . $config["alink"] . '; }
a:visited { color: #' . $config["vlink"] . '; }
a:hover   { color: #' . $config["hlink"] . '; }
td        { font-family: tahoma,verdana,arial,helvetica; font-size: 10pt; }
td.pic    { border: 1px solid #' . $config["outline"] . '; }
-->
</style>
</head>
<body>
<table width="100%" height="100%">
 <tr>
  <td align="middle">
   <table>
    <tr>
     <td class="pic">
   <a href="?pic=' . $next . $edit_desc . '">
   <img src="' . $adir[$pic] . '" ';

 $size=GetImageSize($adir[$pic]); 

 print $size[3]; 
 print ' border="0"></a></td>
    </tr>
   </table>' . "\n";

 if ($config["desc"] && $config["descriptions"][$adir[$pic]]) 
   { print "    " . stripslashes($config["descriptions"][$adir[$pic]]) . "<br />\n"; }

 if ($config["show_pic_name"]) 
   {
     $filename = $adir[$pic];
     if ($config["numbered"]) 
       { $filename = pchop($filename); }
     if ($config["strip_ext"]) 
       { $filename = jchop($filename); }
     print $filename . "\n";
   }

 print '   
   <br />
   <table border="0">
    <tr>
     <td valign="top" align="middle">' . "\n";

 if ($GLOBALS['edit_desc'] && Authenticate($config)==true)
   {
     print '      <form method="post" action="?&pic=' . $next . '&edit_desc=true">' . "\n";
     print '      <input type="hidden" name="edit_pic" value="' . $pic . '">' . "\n";
     print '      <textarea style="width: 300px; height: 100px;" cols="10" rows="5" name="' . $pic . '">' 
       . stripslashes($config["descriptions"][$adir[$pic]]) . '</textarea><br />' . "\n";
     print '      <input type="submit" value="    OK    ">' . "\n";
     print "      </form>\n      <br />";
   }

 if ($prev) 
   { print '      <a href="?pic=' . $prev . $edit_desc . '">previous</a> | ' . "\n"; }
 print '      <a href="./">home</a> ' . "\n";
 if ($next) 
   { print '      | <a href="?pic=' . $next . $edit_desc . '">next</a>' . "\n"; }
 print '     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr height="1">
  <td height="1" valign="bottom" align="middle">' . "\n";

 if ($config["pic_author"]) 
   { 
     if ($config["email"]) 
       { $config["pic_author"]='<a href="mailto:' . $config["email"] . '">' . $config["pic_author"] . '</a>'; }
     print '   Pictures &copy; 2000-' . date("Y") . " " . $config["pic_author"] . ", all rights reserved.<br />"; 
   }
 print '   Powered by <a href="http://www.jab.nu/dappg/">David\'s Automagic PHP Picture Gallery</a>
  </td>
 </tr>
</table>
</body>
</html>';
}

/* 
 * Start Main:
 */

if ($_POST['write_config']) 
  { WriteNewConfig(); } 
else 
  { 
    if ((!file_exists("./pic.conf.php") || $configure) && !$edit_desc) 
      { ShowConfig(); }
    else 
      {
	@require_once("./pic.conf.php");
	if (!$config && !$edit_desc && !$_POST['edit_desc'])
	  { Header("Location: ./?configure=true"); }

	$adir=GetList();
	$n=count($adir);
	if ($_POST['edit_pic']) 
	  { WriteConfig(); } 

	if (!$pic) 
	  {
	    if ($config["index_page"] || $index==true) 
	      { ShowIndex(); }
	    else 
	      {	ShowPic(1); }
	  }
	elseif ($pic) 
	  { ShowPic($pic); }
      }
  }
?>
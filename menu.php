<?
 function menu_anchor ( $text, $url, $type="link", $space=0, $toggle="", $toggle_value=0 )
 {
  if ( $toggle!= "" )
   $url .= "?".$toggle."=".$toggle_value;

  $img = "";

  $output = "";
  
  for ( $i=0; $i<$space; $i++ )
  {
   $output .= "<img src=\"img/empty.gif\" height=11 width=20 border=0>";
  }
  
  switch ( $type )
  {
   case "closed":
    $img .= "<img src=\"img/closed.gif\" height=11 width=10 border=0>";
    break;
   case "open":
    $img .= "<img src=\"img/open.gif\" height=11 width=10 border=0>";
    break;
   case "link":default:
    break;
  } 

  $output .= "<a href=\"".$url."\">".$img.$text."</a><br>";
  return $output;
 }

if ( $shownews == 1 )
 $news = 1;
if ( $showarticles == 1 )
 $articles = 1;
if ( $showwriting == 1 )
 $writing = 1;
if ( $showmusic == 1 )
 $music = 1;
if ( $showgraphics == 1 )
 $graphics = 1;
if ( $showprogramming == 1 )
 $programming = 1;
if ( $showlinks == 1 )
 $links = 1;

if ( $shownews == 2 )
 $news = 0;
if ( $showarticles == 2 )
 $articles = 0;
if ( $showwriting == 2 )
 $writing = 0;
if ( $showmusic == 2 )
 $music = 0;
if ( $showgraphics == 2 )
 $graphics = 0;
if ( $showprogramming == 2 )
 $programming = 0;
if ( $showlinks == 2 )
 $links = 0;
 
if ( $closeall == 1 )
 $news = $articles = $writing = $music = $graphics = $programming = $links = 0;
 
$this_script = substr( getenv ( "SCRIPT_NAME" ), 1, 100 );
 
$menu .= menu_anchor ( "Home", "index.php" );
$menu .= menu_anchor ( "FAQ", "faq.php" );

if ( $news==1 )
{
 $menu .= menu_anchor ( "News", $this_script, "open", 0, "shownews", 2 );
 $menu .= menu_anchor ( "Latest", "news.latest.php", "link", 1 );
 $menu .= menu_anchor ( "All", "news.all.php", "link", 1 );
}
else
{
 $menu .= menu_anchor ( "News", $this_script, "closed", 0, "shownews", 1 );
}

if ( $articles==1 )
{
 $menu .= menu_anchor ( "Articles", $this_script, "open", 0, "showarticles", 2 );
 $menu .= menu_anchor ( "Photoshop", "articles.photoshop.php", "link", 1 );
 $menu .= menu_anchor ( "PHP", "articles.php.php", "link", 1 );
 $menu .= menu_anchor ( "Rants", "articles.rants.php", "link", 1 );
}
else
{
 $menu .= menu_anchor ( "Articles", $this_script, "closed", 0, "showarticles", 1 );
}

if ( $writing==1 )
{
 $menu .= menu_anchor ( "Writing", $this_script, "open", 0, "showwriting", 2 );
 $menu .= menu_anchor ( "My Stories", "writing.stories.php", "link", 1 );
 $menu .= menu_anchor ( "Workshops", "writing.workshops.php", "link", 1 );
 $menu .= menu_anchor ( "Tips", "writing.tips.php", "link", 1 );
}
else
{
 $menu .= menu_anchor ( "Writing", $this_script, "closed", 0, "showwriting", 1 );
}

if ( $music==1 )
{
 $menu .= menu_anchor ( "Music", $this_script, "open", 0, "showmusic", 2 );
 $menu .= menu_anchor ( "My Songs", "music.songs.php", "link", 1 );
 $menu .= menu_anchor ( "Software", "music.software.php", "link", 1 );
 $menu .= menu_anchor ( "MP3s", "music.mp3.php", "link", 1 );
}
else
{
 $menu .= menu_anchor ( "Music", $this_script, "closed", 0, "showmusic", 1 );
}

if ( $graphics==1 )
{
 $menu .= menu_anchor ( "Graphics", $this_script, "open", 0, "showgraphics", 2 );
 $menu .= menu_anchor ( "Gallery", "graphics.gallery.php", "link", 1 );
 $menu .= menu_anchor ( "Software", "graphics.software.php", "link", 1 );
 $menu .= menu_anchor ( "Tutorials", "graphics.tutorials.php", "link", 1 );
}
else
{
 $menu .= menu_anchor ( "Graphics", $this_script, "closed", 0, "showgraphics", 1 );
}

if ( $programming==1 )
{
 $menu .= menu_anchor ( "Programming", $this_script, "open", 0, "showprogramming", 2 );
 $menu .= menu_anchor ( "Free Code", "programming.freecode.php", "link", 1 );
 $menu .= menu_anchor ( "Software", "programming.software.php", "link", 1 );
 $menu .= menu_anchor ( "Tutorials", "programming.tutorials.php", "link", 1 );
}
else
{
 $menu .= menu_anchor ( "Programming", $this_script, "closed", 0, "showprogramming", 1 );
}

if ( $links==1 )
{
 $menu .= menu_anchor ( "Links", $this_script, "open", 0, "showlinks", 2 );
 $menu .= menu_anchor ( "Friends", "links.friends.php", "link", 1 );
 $menu .= menu_anchor ( "News", "links.news.php", "link", 1 );
 $menu .= menu_anchor ( "Learning", "links.learning.php", "link", 1 );
 $menu .= menu_anchor ( "Wow! sites", "links.wow.php", "link", 1 );
}
else
{
 $menu .= menu_anchor ( "Links", $this_script, "closed", 0, "showlinks", 1 );
}

$menu .= "<img src=\"img/empty.gif\" width=20 height=10><br>";

$menu .= menu_anchor ( "Close All", $this_script, "link", 2, "closeall", 1 );

echo $menu;
 
?> 

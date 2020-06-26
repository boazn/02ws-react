<?



    
    $result = "";
    $msgSent = true;
    //$name = array($_POST['name0'], $_POST['name1']);
    $email = $_POST['email'];
    $message = array("example", "דוגמא דוגמא");
    $msgSpecial = array("exampleא", "דוגמא דוגמא");
    $title = array("title", "כותרת");
    $picture_url = "https://scontent.fhfa2-2.fna.fbcdn.net/v/t1.0-9/61215207_2412269772165980_4298391471561637888_o.jpg?_nc_cat=102&_nc_oc=AQkanGLwVEXU4J-CIIjajYS4fA-kyi_wgMGkLUJ9b8umc7VPqkxKWMaKtXB8hT7KySU&_nc_ht=scontent.fhfa2-2.fna&oh=827aaa7afc609a52e5bc37a0b4f0dbbe&oe=5DD2B911";
    
    if (isset($_FILES['file'])) {
        
        $comment0 = $_POST["message0"]; 
		$comment1 = $_POST["message1"]; 
     	print_r("storingPic ".$_FILES['file']['name']);
        $res = storePic($_FILES['file']['name'], $comment0, $comment1, 0, 0, 0);
		$picture_url = $res;
        var_dump ($res);
    } 
    //print_r ("picture_url=".$picture_url);
    $embedded_url = $_POST['embedded_url'];
    if (!empty($_POST['dailyforecast'])||!empty($_GET['dailyforecast'])){
        $msgSpecial = getForecastDay();
        $title = array("Daily Forecast", "תחזית יומית");
        
    }
    if ($msgSpecial == ""){
        $result = "Empty Message";
        echo $result;
        exit;
    }
    $class_alerttxt = "";
    if (empty($picture_url))
        $img_tag = "";
    else{
        $img_tag = "<div id=\"alertbg\" style=\"background-image: url(phpThumb.php?src=".$picture_url."&w=400)\"></div>";
        $img_tag = "<div id=\"alertbg\" style=\"width:400px;height:150px;background-image: url(".$picture_url.")\"></div>";
        $class_alerttxt = " class=\"txtindiv\"";
        $class_alerttitle = " txtindiv";
    }
        
        
        /* position: absolute; */
        /* margin-top: 70px; */
        $msgformat = "<div id=\"alerttxt\" ".$class_alerttxt.">%s</div>".$img_tag;
        $msgToAlertSection = array(sprintf($msgformat, $message[0]), sprintf($msgformat, $message[1]));
        if (strlen($title[0]) > 0){
            $msgformat = "<div class=\"title".$class_alerttitle."\">%s</div> %s";
            $msgToAlertSection[0] = sprintf ($msgformat, $title[0], $msgToAlertSection[0]);
            $msgToAlertSection[1] = sprintf ($msgformat, $title[1], $msgToAlertSection[1]);
        }
       
        
        
            
            //updateMessageFromMessages ($msgToAlertSection[0], 1, 'LAlert', 0 ,'' ,'','');
            //updateMessageFromMessages ($msgToAlertSection[1], 1, 'LAlert', 1 ,'' ,'','');
            echo $msgToAlertSection[0];
    
          
       
   
   
?>

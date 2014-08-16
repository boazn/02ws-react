<?
ini_set("display_errors","On");
try {
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_Photos');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
} catch (Zend_Gdata_App_HttpException $e) {
	exit;
}


///////////////////////////////////////////////////////////

try {
$gp = new Zend_Gdata_Photos();
$query = $gp->newAlbumQuery();
$query->setUser("boazn1");
$query->setAlbumName("02ws");
$albumFeed = $gp->getAlbumFeed($query);


   
                $photoEntry = $albumFeed[count($albumFeed) - 1];
                if ($photoEntry->getMediaGroup()->getContent() != null) {
                  $mediaContentArray = $photoEntry->getMediaGroup()->getContent();
                  $contentUrl = $mediaContentArray[0]->getUrl();
                  $caption = $photoEntry->summary->text;
                  
                }
                if ($photoEntry->getExifTags() != null) {
                            $dateTakents = $photoEntry->getExifTags()->getTime()->text;
                             $dateTaken = getLocalTime($dateTakents/1000);
                }
        
                if ($photoEntry->getMediaGroup()->getThumbnail() != null) {
                  $mediaThumbnailArray = $photoEntry->getMediaGroup()->getThumbnail();
                  $thumbnailUrl = $mediaThumbnailArray[1]->getUrl();
                  $mediumSizeUrl = str_replace("s144", "s456", $thumbnailUrl);
                  $contentUrl = str_replace("s144", "s1152", $thumbnailUrl);
                }
             
                //print_r($photoEntry);
       
} catch (Zend_Gdata_App_HttpException $e) {
    logger( "Error: " . $e->getMessage() . "<br >\n");
    if ($e->getResponse() != null) {
        logger( "Body: <br />\n" . $e->getResponse()->getBody() . 
             "<br />\n"); 
    }
    // In new versions of Zend Framework, you also have the option
    // to print out the request that was made.  As the request
    // includes Auth credentials, it's not advised to print out
    // this data unless doing debugging
    // echo "Request: <br />\n" . $e->getRequest() . "<br />\n";
} catch (Zend_Gdata_App_Exception $e) {
    logger( "Error: " . $e->getMessage() . "<br />\n"); 
}


?>

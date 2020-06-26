<?
ini_set("display_errors","On");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
include ("ini.php");
function imageExists($url) {
  if (!$fp = curl_init($url)) return false;
  return true;
  curl_exec($fp);
  $response = curl_getinfo( $fp );
  if ($response['download_content_length'] > 1000)
    return true;
  return false;
  
  
}
function getLatestImgTime($min_sub){
  global $numSearched;
  $coeff = 60 * 10;
  
  $rounded = floor((time() + (GMT_TZ * 60)) / $coeff) * $coeff;
  $found = false;
  $rounded = $rounded - $min_sub*60;
  $imagepath = sprintf("https://ims.gov.il/sites/default/files/ims_data/map_images/IMSRadar/IMSRadar_%s%s%s%s%s.gif", date('Y', $rounded), date('m', $rounded), date('d', $rounded),  date('H', $rounded), date('i', $rounded));
  echo ("<br/>".$min_sub.": ".$imagepath);
   
     
  if (imageExists($imagepath))
     return $imagepath;
  else{
     $numSearched = $numSearched + 1;
     $min_sub = $min_sub + 5;
     echo ("<br/>img not found. ");
     if ($numSearched > 20){
      echo "<br/>passed threshold. no img";
      return false;
     }
        
     else
        return getLatestImgTime($min_sub);
  }
 
}
  $numSearched = 0;
 // Set POST variables
    $url = getLatestImgTime(5);
    if (!$url)
    {
      echo "<br/>no url";
      exit;
    }

   
 // Open connection
    $ch = curl_init();

    // Set the URL, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch, CURLOPT_REFERER, "https://ims.gov.il/he/RadarSatellite");

   
    $result = curl_exec($ch);
    $response = curl_getinfo( $ch );
        // get cookies
    // basic parsing of cookie strings (just an example)
    $cookieParts = array();
    preg_match_all('/Set-Cookie:\s{0,}(?P<name>[^=]*)=(?P<value>[^;]*).*?expires=(?P<expires>[^;]*).*?path=(?P<path>[^;]*).*?domain=(?P<domain>[^\s;]*).*?$/im', $result, $cookieParts);

    $sCookie = $cookieParts['cookie'][0]; // show harvested cookies
    echo "\n".$response['http_code'];
    //print_r($response);
    //print_r($cookieParts);
    print_r($result);
    if ($response['http_code'] == 301 || $response['http_code'] == 302)
    {
      //  curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookies['cookie'] );
        curl_setopt ( $ch , CURLOPT_COOKIE, $sCookie );
    }
    
   // print_r($cookieParts);
    //print_r("<br/>".$result); 
    // Close connection
    curl_close($ch);
    if ($response['download_content_length'] > 1000) {
      $fp = fopen("images/radar/imsradarphp".date("YmdHi").".gif",'w');
      fwrite($fp, $result); 
      fclose($fp);  
    }
       
    
    
    
?>

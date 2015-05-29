<?
 // Set POST variables
    $url = 'http://www.ims.gov.il/Ims/Pages/RadarImage.aspx?Row=9&TotalImages=10&LangID=1&Location=';

   
 // Open connection
    $ch = curl_init();

    // Set the URL, number of POST vars, POST data
    curl_setopt( $ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:11.0) Gecko/20100101 Firefox/11.0');
    curl_setopt($ch, CURLOPT_HEADER  ,0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
   
    $result = curl_exec($ch);
    $response = curl_getinfo( $ch );
        // get cookies
    $cookies = array();
    preg_match_all('/Set-Cookie:(?<cookie>\s{0,}.*)$/im', $result, $cookies);

    $sCookie = $cookies['cookie'][0]; // show harvested cookies
    echo "\n".$response['http_code'];
    if ($response['http_code'] == 301 || $response['http_code'] == 302)
    {
      //  curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookies['cookie'] );
        curl_setopt ( $ch , CURLOPT_COOKIE, $sCookie );
    }
    // basic parsing of cookie strings (just an example)
    //$cookieParts = array();
    //preg_match_all('/Set-Cookie:\s{0,}(?P<name>[^=]*)=(?P<value>[^;]*).*?expires=(?P<expires>[^;]*).*?path=(?P<path>[^;]*).*?domain=(?P<domain>[^\s;]*).*?$/im', $result, $cookieParts);
    //print_r($cookieParts);
    // Close connection
    curl_close($ch);
    $fp = fopen("images/radar/imsradarphp".date("jmyHM")."\".jpg",'w');
    fwrite($fp, $result); 
    fclose($fp);     
    
    
    
?>

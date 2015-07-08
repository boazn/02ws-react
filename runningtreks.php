<!--<iframe src="https://www.google.com/maps/d/u/0/embed?mid=z9vYNAnHbdzc.kui9dJFKL6SY" frameborder="0" style="border:0" width="640" height="480"></iframe>
<iframe src="https://www.google.com/maps/d/u/0/embed?mid=z9vYNAnHbdzc.kTutCf0c6vVE" frameborder="0" style="border:0" width="640" height="480"></iframe>
<iframe src="https://www.google.com/maps/d/u/0/embed?mid=z9vYNAnHbdzc.kYmVpURffRG0" frameborder="0" style="border:0" width="640" height="480"></iframe>-->
<?
include_once("include.php"); 
include_once("start.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/main.php?lang=<?=$lang_idx;?>" type="text/css">
    <title>Running treks</title>
    <style>
      html, body {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #map-canvas, #map-canvas2, #map-canvas3, #map-canvas4{
         width:50%;
         height: 50%;
         float:left
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAT71EmziBDNEFSl7t5J8wSBVonuG2gu9U"></script>
    <script>
function initialize() {
  var jerusalem = new google.maps.LatLng(31.77,35.23);
  var pos1 = new google.maps.LatLng(31.77,35.228);
  var mapOptionsZionMormon = {
        zoom: 15,
    center: jerusalem
  }
  //
  // Zion-Mormon
  //
  var mapZionMormon = new google.maps.Map(document.getElementById('map-canvas'), mapOptionsZionMormon);

  var ctaLayer = new google.maps.KmlLayer({
    url: 'http://www.02ws.co.il/treks/Zion-Mormon.kmz'
  });
    
  var marker = new google.maps.Marker({
      position: pos1,
      map: mapZionMormon,
      title: 'Temp1'
  });
  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
  
  marker.setMap(mapZionMormon);
  ctaLayer.setMap(mapZionMormon);
  infowindow.open(mapZionMormon,marker);
  
  
  //
  // Zion-Mormon
  //
  var mapZionMormon = new google.maps.Map(document.getElementById('map-canvas2'), mapOptionsZionMormon);

  var ctaLayer = new google.maps.KmlLayer({
    url: 'http://www.02ws.co.il/treks/Zion-Mormon.kmz'
  });
    
  var marker = new google.maps.Marker({
      position: pos1,
      map: mapZionMormon,
      title: 'Temp1'
  });
  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
  
  marker.setMap(mapZionMormon);
  ctaLayer.setMap(mapZionMormon);
  infowindow.open(mapZionMormon,marker);
  
  //
  // Zion-Mormon
  //
  var mapZionMormon = new google.maps.Map(document.getElementById('map-canvas3'), mapOptionsZionMormon);

  var ctaLayer = new google.maps.KmlLayer({
    url: 'http://www.02ws.co.il/treks/Zion-Mormon.kmz'
  });
    
  var marker = new google.maps.Marker({
      position: pos1,
      map: mapZionMormon,
      title: 'Temp1'
  });
  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
  
  marker.setMap(mapZionMormon);
  ctaLayer.setMap(mapZionMormon);
  infowindow.open(mapZionMormon,marker);
  //
  // Zion-Mormon
  //
  var mapZionMormon = new google.maps.Map(document.getElementById('map-canvas4'), mapOptionsZionMormon);

  var ctaLayer = new google.maps.KmlLayer({
    url: 'http://www.02ws.co.il/treks/Zion-Mormon.kmz'
  });
    
  var marker = new google.maps.Marker({
      position: pos1,
      map: mapZionMormon,
      title: 'Temp1'
  });
  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
  
  marker.setMap(mapZionMormon);
  ctaLayer.setMap(mapZionMormon);
  infowindow.open(mapZionMormon,marker);
  
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
      <div>&nbsp;</div>
      <div id="tohome" class="invfloat inv_plain_3"><a href="<? echo BASE_URL."?lang=".$lang_idx;?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
	<? echo $HOME_PAGE[$lang_idx];?>
	</a>
      </div>
      <h1 style="margin: 0 auto;display:table">מסלולי ריצה</h1>
      <div>&nbsp;</div>
    <div id="map-canvas"></div>
    <div id="map-canvas2"></div>
    <div id="map-canvas3"></div>
    <div id="map-canvas4"></div>
  </body>
</html>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }
  #map_canvas { height: 100% }
</style>
<script type="text/javascript"
    src="http://maps.googleapis.com/maps/api/js?sensor=false&language=iw&region=GB">
</script>
<script type="text/javascript">
function initialize() {
    var latlng = new google.maps.LatLng(31.775, 35.210);
    var myOptions = {
      zoom: 15,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.SATELLITE
    };
	
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);

  var marker = new google.maps.Marker({map: map, position:
        map.getCenter()});
  var infowindow = new google.maps.InfoWindow();
  infowindow.setContent('<b>ירושלים</b>');
  google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);
      });
  google.maps.event.addListener(map, 'zoom_changed', function() {
		zoomLevel = map.getZoom();
		infowindow.setContent("Zoom: " + zoomLevel);
		if (zoomLevel == 0) {
		  map.setZoom(10);
		}      
	});
}
  

</script>
</head>
<body onload="initialize()">
  <div id="map_canvas" style="width:800px; height:600px"></div>

  <iframe src='http://data.mapchannels.com/instant/map.htm?x=35.15625&y=31.742182&z=9&t=2&name=byhouboyublhvcdfjnon'pm'  style='width:800px;height:600px;border:solid 1px black' frameborder='0' marginwidth='0' marginheight='0' scrolling='off' ></iframe>
</body>
</html>
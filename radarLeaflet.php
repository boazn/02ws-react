<html >
        <head>
<style>
   .leaflet-radar {
       
       /* from leaflet-control-layers */
       border-radius: 5px;
       background: #fff;
       border: 2px solid rgba(0, 0, 0, 0.2);
       background-clip: padding-box;
       
       padding: 5px;
       height: 80.5px;
}

.leaflet-radar .leaflet-radar-timestamp {
       text-align: center;font-size:1.2em
}
.leaflet-radar-slider{
    margin-top: 10px
}
.leaflet-radar-slider input {
   width:100%;
}
.leaflet-radar-toggle input{
   width:20px;height:20px
}
.leaflet-right .leaflet-control {
	margin-right: 30px;
	}
</style>
<link rel="stylesheet" href="css/leaflet.css"/>
   <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet-src.js"></script>
   <script type="text/javascript" src="sprintf2.js"></script>
   <script src="leaflet-radar.js?foo=1292"></script>
  
</head>
<body style="padding: 0; margin: 0;">
<div style="height: 100%; width: 100%;" id="map"></div>

                <script type="text/javascript">

                        var map = L.map("map").setView([31.77, 35.19], 8);
                        //[[34.5318966003582659, 37.8648132475530090], [29.4468656950938161, 31.7662931774178858]]
                        //var corner1 = L.latLng(33.653387, 33.349726),
                        //corner2 = L.latLng(29.39597, 35.929833),
                        var corner1 = L.latLng(34.5318966003582659, 37.8648132475530090),
                        corner2 = L.latLng(29.4468656950938161, 31.7662931774178858),
                        
                        map_bounds = L.latLngBounds(corner1, corner2);
                        var osmAttribution =
                                'Map data &copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
                        var leafletRadarAttribution =
                                '<a href="https://github.com/rwev/leaflet-radar">Radar</a>';

                        L.tileLayer(
                                "https://tile-{s}.openstreetmap.fr/hot/{z}/{x}/{y}.png",
                                {
                                        attribution: [
                                                osmAttribution,
                                                leafletRadarAttribution
                                        ].join(" | ")
                                }
                        ).addTo(map);
                        L.control.radar({}).addTo(map);
                        //L.rectangle(map_bounds).addTo(map);
                     

                       (function() {
                        var checkbox = document.getElementById('leaflet-radar-toggle');
                       //checkbox.click();

                        })();
                  </script>
                              
<div  id="imsradar" class="float" >

</div>
</body>
</html>



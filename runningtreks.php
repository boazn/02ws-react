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
         width:49%;
         height: 49%;
         float:left;margin:0.2em
      }
      .map{
        width: 50%;margin: 0 auto;
        }

        @media only screen and (max-width: 600px) {
            #map-canvas, #map-canvas2, #map-canvas3, #map-canvas4{
         width:99%;
         
            }
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAT71EmziBDNEFSl7t5J8wSBVonuG2gu9U"></script>
    <script>
function initialize() {
  var jerusalem = new google.maps.LatLng(31.77,35.23);
  var pos1 = new google.maps.LatLng(31.77,35.228);
  var pos2 = new google.maps.LatLng(31.77455788,35.23410552);//722m valleytemp + 0.5
  var pos3 = new google.maps.LatLng(31.77959297,35.2399832);//708m valleytemp + 0.5
  var pos4 = new google.maps.LatLng(31.78614117,35.23895323);//718m valleytemp + 0.5 
  var pos5 = new google.maps.LatLng(31.78573078,35.24367392);//755m valleytemp
  var pos6 = new google.maps.LatLng(31.78718081,35.24540126);//794m mountaintemp
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
    
  var marker1 = new google.maps.Marker({
      position: pos1,
      map: mapZionMormon,
      title: 'Temp1'
  });
  var contentString1 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp2() + 0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow1 = new google.maps.InfoWindow({
      content: contentString1
  });
  var marker2 = new google.maps.Marker({
      position: pos2,
      map: mapZionMormon,
      title: 'Temp2'
  });
  var contentString2 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp2() + 0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow2 = new google.maps.InfoWindow({
      content: contentString2
  });
  var marker3 = new google.maps.Marker({
      position: pos3,
      map: mapZionMormon,
      title: 'Temp3'
  });
  var contentString3 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp2() + 0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow3 = new google.maps.InfoWindow({
      content: contentString3
  });
  var marker4 = new google.maps.Marker({
      position: pos4,
      map: mapZionMormon,
      title: 'Temp3'
  });
  var contentString4 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp2().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow4 = new google.maps.InfoWindow({
      content: contentString4
  });
  var marker5 = new google.maps.Marker({
      position: pos5,
      map: mapZionMormon,
      title: 'Temp3'
  });
  var contentString5 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow5 = new google.maps.InfoWindow({
      content: contentString5
  });
  var marker6 = new google.maps.Marker({
      position: pos6,
      map: mapZionMormon,
      title: 'Temp3'
  });
  var contentString6 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow6 = new google.maps.InfoWindow({
      content: contentString6
  });
  ctaLayer.setMap(mapZionMormon);
  marker1.setMap(mapZionMormon);
  marker2.setMap(mapZionMormon);
  marker3.setMap(mapZionMormon);
  infowindow1.open(mapZionMormon,marker1);
  infowindow2.open(mapZionMormon,marker2);
  infowindow3.open(mapZionMormon,marker3);
  marker4.setMap(mapZionMormon);
  marker5.setMap(mapZionMormon);
  marker6.setMap(mapZionMormon);
  infowindow4.open(mapZionMormon,marker4);
  infowindow5.open(mapZionMormon,marker5);
  infowindow6.open(mapZionMormon,marker6);
  
  
  
  
  //
  // Chalutz-GanSacker
  //
  var mapChalutzGanSacker = new google.maps.Map(document.getElementById('map-canvas2'), mapOptionsZionMormon);
  var pos11 = new google.maps.LatLng(31.78277593,35.19125283);//792m
  var pos12 = new google.maps.LatLng(31.78585845,35.19796908);//799m
  var pos13 = new google.maps.LatLng(31.78204632,35.20350516);//805m
  var pos14 = new google.maps.LatLng(31.77996691,35.20863354);//772m
  var pos15 = new google.maps.LatLng(31.77615453,35.20853162);//767m
  var pos16 = new google.maps.LatLng(31.78272121,35.20638585);//792
  var ctaLayer = new google.maps.KmlLayer({
    url: 'http://www.02ws.co.il/treks/Chalutz-GanSacker.kmz'
  });
  var marker11 = new google.maps.Marker({
      position: pos11,
      map: mapChalutzGanSacker,
      title: 'Temp1'
  });
  var contentString11 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp()-0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow11 = new google.maps.InfoWindow({
      content: contentString11
  });  
  var marker12 = new google.maps.Marker({
      position: pos12,
      map: mapChalutzGanSacker,
      title: 'Temp1'
  });
  var contentString12 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp()-0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow12 = new google.maps.InfoWindow({
      content: contentString12
  });
  var marker13 = new google.maps.Marker({
      position: pos13,
      map: mapChalutzGanSacker,
      title: 'Temp1'
  });
  var contentString13 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp()-0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow13 = new google.maps.InfoWindow({
      content: contentString13
  });  
  var marker14 = new google.maps.Marker({
      position: pos14,
      map: mapChalutzGanSacker,
      title: 'Temp1'
  });
  var contentString14 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow14 = new google.maps.InfoWindow({
      content: contentString14
  });
  var marker15 = new google.maps.Marker({
      position: pos15,
      map: mapChalutzGanSacker,
      title: 'Temp1'
  });
  var contentString15 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp()-0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow15 = new google.maps.InfoWindow({
      content: contentString15
  });
  var marker16 = new google.maps.Marker({
      position: pos16,
      map: mapChalutzGanSacker,
      title: 'Temp1'
  });
  var contentString16 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow16 = new google.maps.InfoWindow({
      content: contentString16
  });
  ctaLayer.setMap(mapChalutzGanSacker);
  marker11.setMap(mapChalutzGanSacker);
  infowindow11.open(mapChalutzGanSacker,marker11);
  marker12.setMap(mapChalutzGanSacker);
  infowindow12.open(mapChalutzGanSacker,marker12);
  marker13.setMap(mapChalutzGanSacker);
  infowindow13.open(mapChalutzGanSacker,marker13);
  marker14.setMap(mapChalutzGanSacker);
  infowindow14.open(mapChalutzGanSacker,marker14);
  marker15.setMap(mapChalutzGanSacker);
  infowindow15.open(mapChalutzGanSacker,marker15);
  marker16.setMap(mapChalutzGanSacker);
  infowindow16.open(mapChalutzGanSacker,marker16);
  
  //
  // GivaatRam
  //
  var mapOptionsGivaatRam = {
        zoom: 10,
    center: jerusalem
  }
  var mapGivaatRam = new google.maps.Map(document.getElementById('map-canvas3'), mapOptionsGivaatRam);
 var pos17 = new google.maps.LatLng(31.7762,35.2002);
  var ctaLayer = new google.maps.KmlLayer({
    url: 'http://www.02ws.co.il/treks/GivaatRam.kmz'
  });
    
  var marker17 = new google.maps.Marker({
      position: pos17,
      map: mapGivaatRam,
      title: 'Temp1'
  });
  var contentString17 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp2().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow17 = new google.maps.InfoWindow({
      content: contentString17
  });
  
  marker17.setMap(mapGivaatRam);
  ctaLayer.setMap(mapGivaatRam);
  infowindow17.open(mapGivaatRam,marker17);
  //
  // Station-Zoo
  //
  var mapOptionsZoo = {
        zoom: 14,
    center: jerusalem
  }
  var mapStationZoo = new google.maps.Map(document.getElementById('map-canvas4'), mapOptionsZoo);
  var pos18 = new google.maps.LatLng(31.7691678,35.22436738);//755m
  var pos19 = new google.maps.LatLng(31.75872321,35.21457195);//731m
  var pos20 = new google.maps.LatLng(31.74801285,35.20221233);//696m
  var pos21 = new google.maps.LatLng(31.74799461,35.18822193);//670m
  var pos22 = new google.maps.LatLng(31.75629661,35.1928997);//694m
  var pos23 = new google.maps.LatLng(31.74517541,35.17787397);//653m
  var ctaLayer = new google.maps.KmlLayer({
    url: 'http://www.02ws.co.il/treks/Station-Zoo.kmz'
  });
    
  var marker18 = new google.maps.Marker({
      position: pos18,
      map: mapStationZoo,
      title: 'Temp1'
  });
  var contentString18 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp2().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow18 = new google.maps.InfoWindow({
      content: contentString18
  });
   var marker19 = new google.maps.Marker({
      position: pos19,
      map: mapStationZoo,
      title: 'Temp1'
  });
  var contentString19 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo $current->get_temp2().$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow19 = new google.maps.InfoWindow({
      content: contentString19
  });
   var marker20 = new google.maps.Marker({
      position: pos20,
      map: mapStationZoo,
      title: 'Temp1'
  });
  var contentString20 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp2()+0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow20 = new google.maps.InfoWindow({
      content: contentString20
  });
  var marker21 = new google.maps.Marker({
      position: pos21,
      map: mapStationZoo,
      title: 'Temp1'
  });
  var contentString21 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp2()+0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow21 = new google.maps.InfoWindow({
      content: contentString21
  });
  var marker22 = new google.maps.Marker({
      position: pos22,
      map: mapStationZoo,
      title: 'Temp1'
  });
  var contentString22 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp2()+0.5).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow22 = new google.maps.InfoWindow({
      content: contentString22
  });
  var marker23 = new google.maps.Marker({
      position: pos23,
      map: mapStationZoo,
      title: 'Temp1'
  });
  var contentString23 = '<div id="content">'+
      '<div id="siteNotice">'+
      '<? echo ($current->get_temp2()+1).$current->get_tempunit();?>'+
      '</div>'+
      '</div>'+
      '</div>';

  var infowindow23 = new google.maps.InfoWindow({
      content: contentString23
  });
  ctaLayer.setMap(mapStationZoo);
  marker18.setMap(mapStationZoo);
  infowindow18.open(mapStationZoo,marker18);
  marker19.setMap(mapStationZoo);
  infowindow19.open(mapStationZoo,marker19);
  marker20.setMap(mapStationZoo);
  infowindow20.open(mapStationZoo,marker20);
  marker21.setMap(mapStationZoo);
  infowindow21.open(mapStationZoo,marker21);
  marker22.setMap(mapStationZoo);
  infowindow22.open(mapStationZoo,marker22);
  marker23.setMap(mapStationZoo);
  infowindow23.open(mapStationZoo,marker23);
  
  
  
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <style>
    
    </style>
  </head>
  <body>
      <div>&nbsp;</div>
      <div id="tohome" class="invfloat inv_plain_3"><a href="<? echo BASE_URL."?lang=".$lang_idx;?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
	<? echo $HOME_PAGE[$lang_idx];?>
	</a>
      </div>
      <h1 style="margin: 0 auto;display:table">מסלולי ריצה</h1>
      <div>&nbsp;</div>
      <div class="map" > Zion-Mormon</div>
    <div id="map-canvas"></div>
    <div class="map">Chalutz-GanSacker   חלוץ-גן-סאקר</div>
    <div id="map-canvas2"></div>
    <div class="map">Givaat Ram גבעת רם</div>
    <div id="map-canvas3"></div>
    <div class="map">Station-Zoo התחנה - גן-החיות</div>
    <div id="map-canvas4"></div>
    <div style="direction:rtl" class="inv_plain_3">
    <h1>עוד מסלולים</h1>
    <p>
        <ul>
            <li> גן השבשבת, רמת בית הכרם (בין הפיתול של משה קול ומרכז אביזוהר). יש שם לולאה של כמעט קילומטר. מרגיש קצת כמו אסירים בסרט, שהולכים במעגל.</li>
            <li> הפיל שבחדר: יער ירושלים. בשנים האחרונות היציאה לבית זית סגורה, מה שהוריד דרמטית את התנועה שם.
    המסלול מתחיל ברחוב פרחי-חן, ממשיך בדרך שוכמן, עולה ליד ושם ואז הר הרצל, יורד לאורך כמה מאות מטרים לאורך הר הרצל (הסיפור של עם ישראל: עולה משואה לתקומה - ומאז הכל מדרון תלול), וחוזר חזרה לפרחי-חן.<br/>
            </li>
           
        </ul>
    
      
    </p>
    </div>
  </body>
</html>
// TODO add refresh (reload time layers)
// TODO add buffer time to load layers where radar turned on

function checkImageExists(imageSrc, good, bad) {
    var img = new Image();
    img.onload = good; 
    img.onerror = bad;
    img.src = imageSrc;
 }
 function getLatestImgTime(min_sub){
    var coeff = 1000 * 60 * 10;
    
    var date = new Date();  //or use any other date
    var rounded = new Date(Math.round(date.getTime() / coeff) * coeff);
    var found = false;
    rounded.setTime(rounded.getTime() - min_sub*60*1000);
    var imagepath = sprintf("https://ims.gov.il/sites/default/files/ims_data/map_images/IMSRadar4GIS/IMSRadar4GIS_%04d%02d%02d%02d%02d_0.png", rounded.getFullYear(), ("0" + (rounded.getMonth() + 1)).slice(-2), rounded.getDate(), rounded.getHours(), rounded.getMinutes());
    //var imagepath = sprintf("https://ims.gov.il/sites/default/files/ims_data/map_images/radar/radar_%04d%02d%02d%02d%02d.gif", rounded.getFullYear(), ("0" + (rounded.getMonth() + 1)).slice(-2), rounded.getDate(), rounded.getHours(), rounded.getMinutes());
    //console.log(imagepath);
    checkImageExists(imagepath,
    function(){ 
       //alert(imagepath);
       console.log(imagepath + " found");
       found = true;
       buildImageArray(rounded);
    }, 
    function(){ 
       
       if (numSearched > 8){
          console.log("img not found. passed threshold");
          rounded = null;
          found = false;
       }
          
    else{
       min_sub = min_sub + 5;//default = 5
       numSearched = numSearched + 1;
       console.log(imagepath + " not found. Searching -" + min_sub);
       getLatestImgTime(min_sub);
    } 
    });
      
    /*if (imageExists(imagepath))
       return rounded;
    else{
       numSearched = numSearched + 1
       min_sub = min_sub + 5;
       console.log("img not found. Searching " + min_sub);
       if (numSearched > 20)
          return false;
       else
          return getLatestImgTime(min_sub);
    }*/
   
 }
function buildImageArray(rounded){
    for (i = 0; i < numOfPics ; i++)
 
       {
          var imagepath = sprintf("https://ims.gov.il/sites/default/files/ims_data/map_images/IMSRadar4GIS/IMSRadar4GIS_%04d%02d%02d%02d%02d_0.png", rounded.getFullYear(), ("0" + (rounded.getMonth() + 1)).slice(-2), rounded.getDate(), rounded.getHours(), rounded.getMinutes());
          //var imagepath = sprintf("https://ims.gov.il/sites/default/files/ims_data/map_images/radar/radar_%04d%02d%02d%02d%02d.gif", rounded.getFullYear(), ("0" + (rounded.getMonth() + 1)).slice(-2), rounded.getDate(), rounded.getHours(), rounded.getMinutes());
          modImages[i] = imagepath;
          timeImages[i] = new Date(rounded);
          if (i == 0){
 
             theImages[0] = new Image();
              theImages[0].src = imagepath;
              imageNum[0] = true;
          }
             
          console.log("putting: " + imagepath);
          rounded.setMinutes( rounded.getMinutes() - 5 ); // default = 5
 
       }
      
 }
 var numOfPics = 10;
var numSearched = 0;
modImages = new Array();
timeImages = new Array();
theImages = new Array();      //holds the images
imageNum = new Array();       //keeps track of which images to omit from loop
first_image = 1;
last_image = numOfPics;
 getLatestImgTime(10);
 setInterval(getLatestImgTime, 60*1000, 10);
L.Control.Radar = L.Control.extend({

    NEXRAD_URL: `https://mesonet.agron.iastate.edu/cgi-bin/wms/nexrad/n0q.cgi`,
    NEXRAD_LAYER: `nexrad-n0q-900913`,

    isPaused: false,
    timeLayerIndex: 0,
    timeLayers: [],

    options: {
        position: `topright`,
        opacity: 0.575,
        zIndex: 200,
        transitionMs: 750,
        playHTML: `&#9658;`,
        pauseHTML: `&#9616;`,
    },

    onRemove: function () {
        L.DomUtil.remove(this.container);
    },

    onAdd: function (map) {
        this.map = map;

        // setup control container
        this.container = L.DomUtil.create(`div`, "leaflet-radar");

        L.DomEvent.disableClickPropagation(this.container);
        L.DomEvent.on(this.container, `control_container`, function (e) {
            L.DomEvent.stopPropagation(e);
        });
        L.DomEvent.disableScrollPropagation(this.container);

        // add control elements within container
        checkbox_div = L.DomUtil.create(
            `div`,
            `leaflet-radar-toggle`,
            this.container
        );

        this.checkbox = document.createElement(`input`);
        this.checkbox.id = `leaflet-radar-toggle`;
        this.checkbox.type = `checkbox`;
        this.checkbox.checked = false;
        this.checkbox.onclick = () => this.toggle();

        checkbox_div.appendChild(this.checkbox);

        let checkbox_label = document.createElement(`span`);
        checkbox_label.innerText = `Radar`;

        checkbox_div.appendChild(checkbox_label);

        let slider_div = L.DomUtil.create(
            `div`,
            `leaflet-radar-slider`,
            this.container
        );

        this.slider = document.createElement(`input`);
        this.slider.id = `leaflet-radar-slider`;
        this.slider.type = `range`;
        this.slider.min = 0;

        slider_div.appendChild(this.slider);

        this.timestamp_div = L.DomUtil.create(
            `div`,
            `leaflet-radar-timestamp`,
            this.container
        );

        this.setDisabled(true);
        this.isPaused = true;

        return this.container;
    },

    hideLayerByIndex: function (index) {
        this.timeLayers[index].tileLayer.setOpacity(0);
        this.timestamp_div.innerHTML = ``;
    },

    showLayerByIndex: function (index) {
        this.timeLayers[index].tileLayer.setOpacity(
            this.options.opacity
        );
        this.timestamp_div.innerHTML = this.timeLayers[index].timestamp;
    },

    setDisabled: function (disabled) {
        this.slider.disabled = disabled;
        this.timestamp_div.innerText = ``;
    },

    toggle: function () {
        if (!this.checkbox.checked) {
            this.setDisabled(true);
            this.removeLayers();
            return;
        }

        this.setDisabled(false);

        this.timeLayers = this.generateLayers();
        this.addLayers(this.timeLayers);

        this.slider.max = `${this.timeLayers.length - 1}`;

        this.timeLayerIndex = 0;

        this.isPaused = false;

        this.slider.oninput = () => {

            this.hideLayerByIndex(this.timeLayerIndex);
            this.timeLayerIndex = +this.slider.value;
            this.showLayerByIndex(this.timeLayerIndex);

            this.isPaused = true;
        };

        this.setTransitionTimer();
    },


    setTransitionTimer: function () {
        setTimeout(() => {
            if (this.isPaused) {
                return;
            }

            this.timeLayers.forEach(timeLayer => {
                timeLayer.tileLayer.setOpacity(0);
                timeLayer.tileLayer.addTo(this.map);
            });

            if (this.checkbox.checked) {

                this.hideLayerByIndex(this.timeLayerIndex);
                this.incrementLayerIndex();
                this.showLayerByIndex(this.timeLayerIndex);

                this.slider.value = `${this.timeLayerIndex}`;

                this.setTransitionTimer();
            } else {
                this.setDisabled(true);
                this.removeLayers();
            }
        }, this.options.transitionMs);
    },

    incrementLayerIndex: function () {
        this.timeLayerIndex++;
        if (this.timeLayerIndex > this.timeLayers.length - 1) {
            this.timeLayerIndex = 0;
        }
    },

    addLayers: function () {
        this.timeLayers.forEach(timeLayer => {
            timeLayer.tileLayer.setOpacity(0);
            timeLayer.tileLayer.addTo(this.map);
        });
    },

    removeLayers: function () {
        this.timeLayers.forEach(timeLayer =>
            timeLayer.tileLayer.removeFrom(this.map)
        );
        this.timeLayers = [];
        this.timeLayerIndex = 0;
    },

    generateLayers: function () {
        let timeLayers = [];

        const TOTAL_INTERVALS = 10;
        const INTERVAL_LENGTH_HRS = 5;

        const currentTime = new Date();
        const r_Imagse = modImages.reverse();
        const r_timeImagse = timeImages.reverse();
        for (let i = 0; i <= TOTAL_INTERVALS; i++) {

            const timeDiffMins =
                TOTAL_INTERVALS * INTERVAL_LENGTH_HRS -
                INTERVAL_LENGTH_HRS * i;
             
           // var corner1 = L.latLng(33.653387, 33.349726),
           // corner2 = L.latLng(29.39597, 35.929833),
            var corner1 = L.latLng(34.5318966003582659, 37.8648132475530090),
            corner2 = L.latLng(29.4468656950938161, 31.7662931774178858),
            map_bounds = L.latLngBounds(corner1, corner2);
            layer = L.tileLayer(r_Imagse[i], {
                format: `image/png`,    
                //tileSize: 940,
                bounds: map_bounds,
                transparent: true,
                opacity: this.options.opacity,
                zIndex: this.options.zIndex
            });
            //[[34.5318966003582659, 37.8648132475530090], [29.4468656950938161, 31.7662931774178858]]
            var layer = L.imageOverlay(r_Imagse[i], map_bounds);
            layer.setOpacity(0.8);

            const timeString = new Date(
                currentTime.valueOf() - timeDiffMins * 60 * 1000
            ).toLocaleTimeString();
            if (timeDiffMins > 0)
            timeLayers.push({
                timestamp: r_timeImagse[i],
                tileLayer: layer
            });

            
        }
        return timeLayers;
    }
});

L.control.radar = function (options) {
    return new L.Control.Radar(options);
};

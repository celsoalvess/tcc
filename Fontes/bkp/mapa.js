      /* OSM & OL example code provided by https://mediarealm.com.au/ */
    var map;
    var mapLat = -23.083357;
    var mapLng = -47.219190;
    var mapDefaultZoom = 10;
    var v_url = window.location.href.toString().replace("frmRotas.php", "");
    
    function initialize_map() {
      map = new ol.Map({
      target: "map",
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM({
            url: "https://a.tile.openstreetmap.org/{z}/{x}/{y}.png"
          })
        })
      ],
      view: new ol.View({
          center: ol.proj.fromLonLat([mapLng, mapLat]),
          zoom: mapDefaultZoom
        })
      });
    }

    function add_map_point(lat, lng) {
      var vectorLayer = new ol.layer.Vector({
        source:new ol.source.Vector({
          features: [new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lng), parseFloat(lat)], 'EPSG:4326', 'EPSG:3857')),
          })]
        }),
          style: new ol.style.Style({
            image: new ol.style.Icon({
              anchor: [0.5, 0.5],
              anchorXUnits: "fraction",
              anchorYUnits: "fraction",
              src: v_url+"images/RedDot.svg"
          })
        })
      });

      map.addLayer(vectorLayer);
    }

    function add_map_point_yell(lat, lng) {            
      var vectorLayer = new ol.layer.Vector({
        source:new ol.source.Vector({
          features: [new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lng), parseFloat(lat)], 'EPSG:4326', 'EPSG:3857')),
          })]
        }),
          style: new ol.style.Style({
            image: new ol.style.Icon({
              anchor: [0.5, 0.5],
              anchorXUnits: "fraction",
              anchorYUnits: "fraction",
              src: v_url+"images/YellowDot.svg"
          })
        })
      });

      map.addLayer(vectorLayer);
    }
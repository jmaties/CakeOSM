<?php

/*
 * CakeMap -- a openlayers integrated application built on CakePHP framework.
 * Dic 30, 2011  Geekia S.L.L.
 *
 * @author      javiermaties <javier@geekia.es>
 * @version     1.0
 * @license     OPPL
 *

 */
define('KEYCLOUD', 'b91a65637b084957816f940ab6601e36');
define('KEYLEFT', 'b91a65637b084957816f940ab6601e36');

class OpenLayersHelper extends Helper {

    var $helpers = array('Html');
    public $scriptpuntos = '';

    function map($default, $style = 'width: 100%; height: 100%', $type = null) {

        //if (empty($default)){return "error: You have not specified an address to map"; exit();}
        $out = "<div id=\"mapaopen\"";
        $out .= isset($style) ? " style=\"" . $style . "\"" : null;
        $out .= " ></div>";

        $out .= '<script type="text/javascript">
		//<![CDATA[';
		$tipo=1;
                if (isset($default['typecloud'])){
                    $tipo = $default['typecloud'];
                }
        switch ($type) {
            case 'cloudmade':
                
                
                $out .= $this->Html->script('http://tile.cloudmade.com/wml/latest/web-maps-lite.js', false);

                $out .= " 
            var cloudmade = new CM.Tiles.CloudMade.Web({key: '" . KEYCLOUD . "', styleId: ".$tipo." });
            var map = new CM.Map('mapaopen', cloudmade);
            map.setCenter(new CM.LatLng(" . $default['lat'] . ", " . $default['long'] . "), " . $default['zoom'] . ");
            var topRight = new CM.ControlPosition(CM.TOP_RIGHT, new CM.Size(50, 20));
//map.addControl(new CM.SmallMapControl(), topRight);
            map.addControl(new CM.LargeMapControl());
//map.addControl(new CM.ScaleControl());
//map.addControl(new CM.OverviewMapControl());";

                break;

            case 'leaflet':
                $out .= $this->Html->css('leaflet', 'stylesheet', array('inline' => false));
                $out .= $this->Html->script('leaflet', false);

                $out .= "
                    
                var map = new L.Map('mapaopen');
		
		var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/" . KEYLEFT . "/".$tipo."/256/{z}/{x}/{y}.png',
                    cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
                    cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution});
                
                
		
		map.setView(new L.LatLng(" . $default['lat'] . ", " . $default['long'] . "), " . $default['zoom'] . ").addLayer(cloudmade);

            ";
                break;


            default:

                $out .= $this->Html->script('http://openlayers.org/api/OpenLayers.js', false);
                $out .= $this->Html->script('http://openstreetmap.org/openlayers/OpenStreetMap.js', false);
                $out .= '
                    
                function init() {
                map = new OpenLayers.Map("mapaopen");
                /*
                var mapnik = new OpenLayers.Layer.OSM();
                map.addLayer(mapnik);
                */';
                
                if (isset($default['marcasOpenlayers'])){
                    $out .='
                        var pois = new OpenLayers.Layer.Text( "Puntos de Interés",
                            { location:"'.$default['marcasOpenlayers'].'",
                              projection: map.displayProjection
                            });
                        map.addLayer(pois);
    
                        ';
                }
                

                $out .= '
                map.addControl( new OpenLayers.Control.LayerSwitcher);

                 var layMapnik = new OpenLayers.Layer.OSM.Mapnik("Mapnik");
                 map.addLayer(layMapnik);

                 var layOsmarender = new OpenLayers.Layer.OSM.Osmarender("Osmarender");
                 map.addLayer(layOsmarender);

                 var layCycleMap = new OpenLayers.Layer.OSM.CycleMap("CycleMap");
                 map.addLayer(layCycleMap);
                 
                var center = new OpenLayers.LonLat(' . $default['long'] . ',' . $default['lat'] . ');
                     var centerOSM = center.transform(
                        new OpenLayers.Projection("EPSG:4326"),
                        new OpenLayers.Projection("EPSG:900913")
                     );

                     map.setCenter(centerOSM, ' . $default['zoom'] . ');
                     map.setBaseLayer(layMapnik);
                     map.events.register("mousemove", map, mouseMoveHandler);
     
/*
                map.setCenter(new OpenLayers.LonLat(' . $default['long'] . ',' . $default['lat'] . ') // Center of the map
                  .transform(
                    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                    new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
                  ), ' . $default['zoom'] . ' // Zoom level
                );
*/
              }
              
              function mouseMoveHandler(e) {
        	var position = this.events.getMousePosition(e);
        	var lonlat = map.getLonLatFromPixel(position);
            OpenLayers.Util.getElement("coords").innerHTML = transformMouseCoords(lonlat);
        }
        function transformMouseCoords(lonlat) {
        	var newlonlat=transformToWGS84(lonlat);
			var x = Math.round(newlonlat.lon*10000)/10000;
			var y = Math.round(newlonlat.lat*10000)/10000;
			newlonlat = new OpenLayers.LonLat(x,y);
			return newlonlat;
        }
        function transformToWGS84( sphMercatorCoords) {
        	// Transforma desde SphericalMercator a WGS84
        	// Devuelve un OpenLayers.LonLat con el pto transformado
        	var clon = sphMercatorCoords.clone(); // Si no uso un clon me transforma el punto original
        	var pointWGS84= clon.transform(
                    new OpenLayers.Projection("EPSG:900913"), // to Spherical Mercator Projection;
        			new OpenLayers.Projection("EPSG:4326")); // transform from WGS 1984
        	return pointWGS84;
        }
        function transformToSphericalMercator( wgs84LonLat) {
        	// Transforma desde SphericalMercator a WGS84
        	// Devuelve un OpenLayers.LonLat con el pto transformado
        	var clon = wgs84LonLat.clone(); // Si no uso un clon me transforma el punto original
        	var pointSphMerc= clon.transform(
                    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                    new OpenLayers.Projection("EPSG:900913")); // to Spherical Mercator Projection;
        	return pointSphMerc;
        }';
                break;
        }


        $out .='
    //]]>
		</script>';
        return $out;
    }

    function addMarkers(&$data, $icon = null, $type = null) {

        $out = "<script type=\"text/javascript\">
			//<![CDATA[
			";
        
        if ($type=='cloudmade'){
            $out .= '
                var markers = [];
                ';
        }
        
        for ($i = 0; $i < count($data); $i++) {
            switch ($type) {

                case 'cloudmade':
                    $out .='
                        var pos = new CM.LatLng(' . $data[$i]['lat'] . ',' . $data[$i]['long'] . ');
                        var marca = new CM.Marker(pos);
                        markers.push(marca);
                        marca.bindInfoWindow("' . $data[$i]['title'] . '");
                        /*map.openInfoWindow(pos, "' . $data[$i]['title'] . '", {maxWidth: 200});*/';
                        
                    break;
                
                
                case 'leaflet':
                    $out .='
                        var markerLocation = new L.LatLng(' . $data[$i]['lat'] . ',' . $data[$i]['long'] . ');
                        var marker = new L.Marker(markerLocation);
                        map.addLayer(marker);
                        marker.bindPopup("' . $data[$i]['title'] . '");
            ';


                    break;

                default:
                    break;
            }
        }

        if ($type=='cloudmade'){
            $out .= '
                var clusterer = new CM.MarkerClusterer(map, {clusterRadius: 70});
                clusterer.addMarkers(markers);';
        }
        $out .= "
				//]]>
			</script>";
        return $out;
    }

}

?>

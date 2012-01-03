<?php

//echo Router::url($this->here, true);
$url=$this->here;

$avg_lat = 36.845148;
$avg_lon = -2.452011;

$marcasOpenlayers = $url.'nodes/texto';

$default = array(
        'typecloud' => 1, 
        'zoom' => 14, 
        'lat' => $avg_lat, 
        'long' => $avg_lon,
        'marcasOpenlayers'=> $marcasOpenlayers
        );

$marca = array(
    0 => array(
        'lat'=> 36.83187741946325, 
        'long'=> -2.4574451554641428, 
        'title'=>'Geekia S.L.L.'),
    1 => array(
        'lat'=> 36.8521709017013,
        'long'=> -2.46947754510495, 
        'title'=>'Otra')
    );

/*
 * $tipo:
 *  NULL
 *  cloudmade
 *  leaflet
 */

$tipo = NULL;

echo $this->OpenLayers->map($default, $style = 'width:100%; height: 100%', $tipo);
/* addmarkers no es necesario si $tipo==null */
echo $this->OpenLayers->addmarkers($marcasOpenlayers,null,$tipo);

if (!$tipo) {
    print '<div id="coords"></div>';
}
?>

<?php
header("Content-type:image/png");
for($t=1;$t<=$c;$t++){
$data[] = ${"datay".$t};
$array_leyenda[]=${"country".$t};
}
$array_colors=array(
array(255,102,0),
array(255,170,0),
array(219 , 170 , 0 ),
array(165 , 123 , 0 ),
array(165 , 170 , 0 ),
array(165 , 230 , 0 ),
array(100 , 221 , 160 ),
array(100 , 162 , 160 ),
array(100 , 129 , 160 ),
array(100 , 129 , 236 ),
array(164 , 129 , 236 ),
array(211 , 129 , 255 ),
array(255 , 129 , 255 ),
array(255 , 129 , 235 ),
array(255 , 129 , 215 ),
array(255 , 129 , 195 ),
array(255 , 129 , 185 ),
array(255 , 129 , 155 ),
array(255 , 129 , 115 ),
array(255 , 129 , 175 ),
array(255 , 129 , 145 ),
array(255 , 129 , 105 ),
array(255 , 129 , 65 ),
array(255 , 129 , 5 ),
);
include "class.bargraph.php";
$g = new BarGraph();
$arrays_datos=$data;
   $g->SetGraphPadding(20, 30, 20, 22*(count($arrays_datos))+15);
   $g-> SetGraphTransparency(20);
   $g-> SetBarPadding(3);
   $g-> SetTimeLine($time_line);
   $g-> SetBarDimensions_time(count($time_line));
  $g->SetBarData($arrays_datos);
  $g->SetIdentidades(count($arrays_datos));
  $g->SetBarBackgroundColor($array_colors);
  $g->SetGraphTitle($titulo_grafico);
  $g->SetLeyendas($array_leyenda);
  $g->DrawGraph();
?>
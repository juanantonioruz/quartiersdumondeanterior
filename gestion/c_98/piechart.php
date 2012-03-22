<?php
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
header ("Content-type: image/jpeg");
include "piechart.class.php";
foreach($data as $suma)
$suma_total+=$suma;
$chart1=new piechart(
150,
$entidad,
$data,
$array_colors,
$suma_total, $title
);
$chart1->draw();
#$chart1->out('test2.jpg',90);
?>
<?php
$objeto->datos->query(
"select 
establecimiento_01.nombre as identidad
,count(*) as frecuencia, sum(count_stats_02) as suma
 from stats_02
left join establecimiento_01 on (establecimiento_01.id_establecimiento_01 =stats_02.id_establecimiento_01)
where  mi_seleccion<>0 and '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10)
group by  establecimiento_01.nombre
order by frecuencia desc"
);
while($objeto->datos->next_record()){
$data[]=$objeto->datos->Record["frecuencia"]+$objeto->datos->Record["suma"];
$entidad[]=$objeto->datos->de_html($objeto->datos->Record["identidad"]);
}
$title="Consulta de establecimientos. Intervalo: $fecha_1/$fecha_2";
if($objeto->datos->record_count)
include("piechart.php");
else
echo "no hay ninguna entrada en este intervalo";
?>
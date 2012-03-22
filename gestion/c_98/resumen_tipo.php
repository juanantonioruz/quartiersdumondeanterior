<?php
$objeto->conecto_datos->query(
"select 
establecimiento_00.establecimiento_tipo_esp as identidad
,count(*) as frecuencia, sum(count_stats_02) as suma
 from stats_02
left join establecimiento_00 on (establecimiento_00.id_establecimiento_00 =stats_02.id_establecimiento_00)
where  mi_seleccion<>0 and '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10)
group by establecimiento_00.establecimiento_tipo_esp
order by frecuencia desc"
);
while($objeto->conecto_datos->next_record()){
$data[]=$objeto->conecto_datos->Record["frecuencia"]+$objeto->conecto_datos->Record["suma"];
$entidad[]=$objeto->conecto_datos->Record["identidad"];
}
$title="Consulta Tipos de establecimientos. Intervalo: $fecha_1/$fecha_2";
if($objeto->conecto_datos->record_count)
include("piechart.php");
else
echo "no hay ninguna entrada en este intervalo";
?>
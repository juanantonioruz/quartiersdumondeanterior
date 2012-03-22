<?php
$objeto->conecto_datos->query(
"select 
concat(seccion, ' > ', archivo) as identidad, 
count(*) as frecuencia, sum(count_stats_03) as suma
 from stats_03
 where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat(seccion, archivo)
order by frecuencia desc, seccion, archivo limit 24"
);
while($objeto->conecto_datos->next_record()){
$data[]=$objeto->conecto_datos->Record["frecuencia"]+$objeto->conecto_datos->Record["suma"];
$entidad[]=$objeto->conecto_datos->Record["identidad"];
}
$title="Estadisticas en $usuario_nombre. Consulta Secciones. Intervalo: $fecha_1/$fecha_2";
if($objeto->conecto_datos->record_count)
include("piechart.php");
else
echo "no hay ninguna entrada en este intervalo";
?>

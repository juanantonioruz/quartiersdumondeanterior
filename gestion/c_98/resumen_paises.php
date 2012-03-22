<?php
$objeto->conecto_datos->query("select 
country as identidad, count(*) as frecuencia
from stats_00
right join stats_03 on(stats_03.id_stats_00=stats_00.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro

group by country order by frecuencia desc limit 24");
while($objeto->conecto_datos->next_record()){
$data[]=$objeto->conecto_datos->Record["frecuencia"];
$entidad[]=$objeto->conecto_datos->Record["identidad"];
}
$title="Estadisticas en $usuario_nombre. Consulta Paises. Intervalo: $fecha_1/$fecha_2";
if($objeto->conecto_datos->record_count)
include("piechart.php");
else
echo "no hay ninguna entrada en este intervalo";

?>

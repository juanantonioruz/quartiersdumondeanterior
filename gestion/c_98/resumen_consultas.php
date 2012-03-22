<?php
$objeto->datos->query(
"select 
parametro as identidad, 
count(*) as frecuencia
 from stats_04
  where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10)
group by parametro
order by frecuencia desc, parametro limit 24"
);
while($objeto->datos->next_record()){
$data[]=$objeto->datos->Record["frecuencia"];
        if($objeto->datos->de_html($objeto->datos->Record['identidad'])=="id_establecimiento_00")
        $entidad[]="tipo de establecimiento";
        elseif($objeto->datos->de_html($objeto->datos->Record['identidad'])=="id_sala_00")
        $entidad[]="tipo de sala";
        else
        $entidad[]=$objeto->datos->de_html($objeto->datos->Record['identidad']);
#$entidad[]=$objeto->datos->Record["identidad"];
}
$title="Consultas. Intervalo: $fecha_1/$fecha_2";
if($objeto->datos->record_count)
include("piechart.php");
else
echo "no hay ninguna entrada en este intervalo";
?>

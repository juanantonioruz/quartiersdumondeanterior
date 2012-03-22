<?php
$url_array=array_reverse(explode('/', $_SERVER['PHP_SELF']));
if(count($url_array)==5) $url_2="../";
require("$url_2../../include/objeto.php");
$objeto=new objeto();
if($objeto->subseccion) $seccion= $objeto->subseccion; else  $seccion= $objeto->seccion;
$objeto->conecto_datos->query("select equipos_00_id_registro_00 as id from equipos_00 where directorio='$seccion' ");
$objeto->conecto_datos->next_record();
$id_reg_agenda=$objeto->conecto_datos->Record[id];
$inf=$objeto->documento->modulo_qdm("Agenda", $objeto->documento->escribir_agenda_web(200, 200,"left", $id_reg_agenda));
$objeto->documento->salida($inf, true, true);
?>
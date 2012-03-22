<?php
$url_array=array_reverse(explode('/', $_SERVER['PHP_SELF']));
if(count($url_array)==5) $url_2="../";
require("$url_2../../include/objeto.php");
$objeto=new objeto();
$objeto->conecto_datos->query("select nombre, document_up_id_principal, seccion_principal from 
document_up
left join equipos_00 on (id_registro_00=equipos_00_id_registro_00)
 where id_document_up=".$_GET[id]);
$objeto->conecto_datos->next_record(); 
$id_reg=$objeto->conecto_datos->Record[document_up_id_principal];
$nombre_usuario=$objeto->conecto_datos->Record[nombre];
$seccion_principal=$objeto->conecto_datos->Record[seccion_principal];
//IF AGENDA SACAR EL URL DE FECHA A PARTIR DEL ID
if($seccion_principal=="c_16"){
$objeto->conecto_datos->query("select SUBSTRING(fecha,1,10) as fecha  from agenda where id_agenda= $id_reg");
$objeto->conecto_datos->next_record(); 
$fecha=explode("-",$objeto->conecto_datos->Record[fecha]);
$url="?dia=".$fecha[2]."&mes=".$fecha[1]."&anyo=".$fecha[0];
}elseif($seccion_principal=="c_19" or $seccion_principal=="c_14" ){
$objeto->conecto_datos->query("
select id_noticia_00
  from noticia_00
  left join noticia_01 on (noticia_01_id_noticia_00=id_noticia_00)
        where id_noticia_01=$id_reg");
$objeto->conecto_datos->next_record(); 
$url="?id=".$objeto->conecto_datos->Record[id_noticia_00]."&id2=".$id_reg;
}else{
$url="?id=$id_reg";
}
if($nombre_usuario=="qdm_a"){
    if($seccion_principal=="c_21") $url="../presenta/index.php".$url;
    elseif($seccion_principal=="c_19") $url="../objetivos/index.php".$url;
    elseif($seccion_principal=="c_16") $url="../agenda/index.php".$url;
}elseif($nombre_usuario=="qdm_p"){
    if($seccion_principal=="c_21") $url="../qdm/presenta.php".$url;
    elseif($seccion_principal=="c_14") $url="../qdm/info.php".$url;
    elseif($seccion_principal=="c_16") $url="../qdm/agenda.php".$url;
    elseif($seccion_principal=="c_27") $url="../qdm/foros.php".$url;
#	ESTO SERÍA PARA ACCEDER A LOS DOCS ADJUNTOS POR LA ASOCIACION A LOS TEMAS DE LOS FOROS
    elseif($seccion_principal=="c_25") $url="../qdm/foros.php".$url;
#
}else{
    if($seccion_principal=="c_21") $url="../qdm/".strtolower($nombre_usuario)."/presenta.php".$url;
    elseif($seccion_principal=="c_14") $url="../qdm/$nombre_usuario/info.php".$url;
    elseif($seccion_principal=="c_16") $url="../qdm/$nombre_usuario/agenda.php".$url;
    elseif($seccion_principal=="c_27") $url="../qdm/foros.php".$url;
    elseif($seccion_principal=="c_25") $url="../qdm/foros.php".$url;

}
header("location: $url");

/*
if($objeto->subseccion) $seccion= $objeto->subseccion; else  $seccion= $objeto->seccion;
$objeto->conecto_datos->query("select equipos_00_id_registro_00 as id from equipos_00 where directorio='$seccion' ");
$objeto->conecto_datos->next_record();
$id_reg_agenda=$objeto->conecto_datos->Record[id];
$inf=$objeto->documento->modulo_qdm("Agenda", $objeto->documento->escribir_agenda_web(200, 200,"left", $id_reg_agenda));
$objeto->documento->salida($inf, true, true);

array(

c_14 Documentos anexos de información
c_16 Documentos adjuntos de cita de agenda
c_19 Documentos adjuntos a objetivos
c_21 Documentos adjuntos a presentación
c_25 Documentos anexos a temas de foros
c_27 Documentos anexos a foros de participación


if($objeto->conecto_datos->Record[nombre]=="qdm_a")
$dir="index.php"


qdm_a && c_21 ../presenta/index.php?id=43
qdm_a && c_19 ../objetivos/index.php?id=43
qdm_a && c_16 ../agenda/index.php?id=43
*/
?>
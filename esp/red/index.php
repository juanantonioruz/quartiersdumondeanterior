<?php
$url_array=array_reverse(explode('/', $_SERVER['PHP_SELF']));
if(count($url_array)==5) $url_2="../";
require("$url_2../../include/objeto.php");
$objeto=new objeto();
if($objeto->documento->id_reg){
$query_00="select * from  noticia_01  right join noticia_02 on (id_noticia_01=noticia_02_id_noticia_01 )    where  id_noticia_01=".$objeto->documento->id_reg." order  by id_noticia_01, id_noticia_02";
$objeto->conecto_datos->query($query_00);
if($objeto->conecto_datos->record_count)
while($objeto->conecto_datos->next_record()){
if(!$con){$con=true; 
if($objeto->conecto_datos->Record["titulo_".$objeto->idioma])$titulo=$objeto->conecto_datos->Record["titulo_".$objeto->idioma];
else $titulo=$objeto->conecto_datos->Record["titulo_".$objeto->otro_idioma];
}
if($objeto->conecto_datos->Record["parrafo_".$objeto->idioma]) $parrafo=$objeto->documento->a_html_format($objeto->conecto_datos->Record["parrafo_".$objeto->idioma]);
else $parrafo=$objeto->documento->a_html_format($objeto->conecto_datos->Record["parrafo_".$objeto->otro_idioma]);
$arra_info[]=array($parrafo, $objeto->conecto_datos->Record["imagen"]);
}//while

if($objeto->conecto_datos->record_count)
$lista_archivos=$objeto->documento->docs_adjuntos('c_210', $objeto->documento->id_reg);
if($lista_archivos) $arra_info[]=array("<br><br>".$lista_archivos,null);
}//if $objeto->documento->id_reg
$inf=$objeto->documento->modulo_qdm($titulo, $arra_info);
$objeto->documento->salida($inf, true, true);
?>
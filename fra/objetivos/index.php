<?php
$url_array=array_reverse(explode('/', $_SERVER['PHP_SELF']));
if(count($url_array)==5){ $url_2="../"; $seccion_principal='c_14';
$info_sec="mas_infos";}else{if($url_array[1]<>'qdm'){$seccion_principal='c_19';$info_sec="mas_objetivos";} else{ $seccion_principal='c_14';$info_sec="mas_infos";} }
require("$url_2../../include/objeto.php");
$objeto=new objeto(array("'mas_objetivos'", "'mas_infos'"));
if($_GET[id2]){
 $sql_cont=" and id_noticia_01=".$_GET[id2];
 $id2=$_GET[id2];
}
if($objeto->documento->id_reg){

$query_listado_noticias="select * from noticia_00 
right join noticia_01 on (id_noticia_00=noticia_01_id_noticia_00) 
where id_noticia_00=".$objeto->documento->id_reg."   order by id_noticia_01";
$objeto->conecto_datos->query($query_listado_noticias);
$numero_noticias=$objeto->conecto_datos->record_count;
while($objeto->conecto_datos->next_record()){
$conta_noticias++;
if($objeto->conecto_datos->Record["titulo_".$objeto->idioma])
 $titu_2=$objeto->conecto_datos->Record["titulo_".$objeto->idioma]; 
 else $titu_2=$objeto->conecto_datos->Record["titulo_".$objeto->otro_idioma];
if($id2){
if($id2<>$objeto->conecto_datos->Record[id_noticia_01]){
$listado.="<span class='margin_20px' align='left'><a href='".$objeto->archivo."?id=".$objeto->documento->id_reg."&id2=".$objeto->conecto_datos->Record[id_noticia_01]."'> > $titu_2 </a></span><br>";
}
}else{
if($numero_noticias>1 and $conta_noticias<>1){
$listado.="<span class='margin_20px' align='left'><a href='".$objeto->archivo."?id=".$objeto->documento->id_reg."&id2=".$objeto->conecto_datos->Record[id_noticia_01]."'> > $titu_2 </a></span><br>";
}
}
}//while
#echo $listado;










$qquery_01="select * from noticia_00 
right join noticia_01 on (id_noticia_00=noticia_01_id_noticia_00) 
where id_noticia_00=".$objeto->documento->id_reg."  $sql_cont order by id_noticia_01";

$objeto->conecto_datos->query($qquery_01);
while($objeto->conecto_datos->next_record()){
if(($objeto->conecto_datos->Record[id_noticia_01]<>$id_noticia_01_ant) ){


if(!$conn_joao or $id2==$objeto->conecto_datos->Record[id_noticia_01]){
if($objeto->conecto_datos->Record["titulo_".$objeto->idioma])
 $titu=$objeto->conecto_datos->Record["titulo_".$objeto->idioma]; 
 else $titu=$objeto->conecto_datos->Record["titulo_".$objeto->otro_idioma];
 $id2=$objeto->conecto_datos->Record[id_noticia_01];
}else{
if($objeto->conecto_datos->Record["titulo_".$objeto->idioma])
 $titu_2=$objeto->conecto_datos->Record["titulo_".$objeto->idioma]; 
 else $titu_2=$objeto->conecto_datos->Record["titulo_".$objeto->otro_idioma];

#$listado.="<span class='margin_20px' align='left'><a href='".$objeto->archivo."?id=".$objeto->documento->id_reg."&id2=".$objeto->conecto_datos->Record[id_noticia_01]."'> > $titu_2 </a></span><br>";
}//if
if(!$conn_joao){ $conn_joao=true;  }

$id_noticia_01_ant=$objeto->conecto_datos->Record[id_noticia_01];

}else{

continue;
}//if
}//while



if($sql_cont){
$qquery="select * from noticia_01
right join noticia_02 on (id_noticia_01=noticia_02_id_noticia_01) 
where 1=1 $sql_cont  order by id_noticia_01, id_noticia_02";
}else{
$qquery="select * from noticia_00 
right join noticia_01 on (id_noticia_00=noticia_01_id_noticia_00) 
right join noticia_02 on (id_noticia_01=noticia_02_id_noticia_01) 
where id_noticia_00=".$objeto->documento->id_reg." $sql_cont  order by id_noticia_01, id_noticia_02";

}//If
#echo $qquery; 


$objeto->conecto_datos->query($qquery);
if($objeto->conecto_datos->record_count)
while($objeto->conecto_datos->next_record()){
	if(!$con_00){

	$con_00=true;
	$id_noticia_01_ant=$objeto->conecto_datos->Record[id_noticia_01];
}

if($objeto->conecto_datos->Record[id_noticia_01]==$id_noticia_01_ant){
	if($objeto->conecto_datos->Record["titulo_".$objeto->idioma])$titulo=$objeto->conecto_datos->Record["titulo_".$objeto->idioma];
	else $titulo=$objeto->conecto_datos->Record["titulo_".$objeto->otro_idioma];
	
	if($objeto->conecto_datos->Record["parrafo_".$objeto->idioma]) $parrafo=$objeto->conecto_datos->Record["parrafo_".$objeto->idioma];
	else $parrafo=$objeto->conecto_datos->Record["parrafo_".$objeto->otro_idioma];

	$arra_info[]=array($parrafo, $objeto->conecto_datos->Record["imagen"]);
			$id_noticia_01_ant=$objeto->conecto_datos->Record[id_noticia_01];

}else{
continue;
}

}//while



if($id2)
$lista_archivos=$objeto->documento->docs_adjuntos($seccion_principal, $id2);
if($lista_archivos) $arra_info[]=array("<br><br>".$lista_archivos,null);

if($listado){
 $listado= $objeto->documento->cubito_mas_info_qdm($objeto->documento->conecto_datos->traduccion[$info_sec].$objeto->documento->menu_navega."<br>").$listado;
 $arra_info[]=array("<br><div align='left'>".$listado."</div>",null);
 }//listado
$hori="  <div class='idioma' align='left'>oo > $titulo </div>";
}//if
$inf=$objeto->documento->modulo_qdm($objeto->documento->menu_navega." > ".$titulo, $arra_info, $hori);
$objeto->documento->salida($inf, true, true);
?>

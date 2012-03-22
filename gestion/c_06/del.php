<?php
require("../../include/objeto.php");
$objeto=new objeto(array("'prueba2'"));
/*
#echo "traduccion: ".$objeto->gestion->datos->traduccion['prueba2']."<hr>";
#$objeto->gestion->mostrar_variables=true;
$objeto->gestion->id_seccion="id_dato_tabla";
$objeto->gestion->datos->query("select * from dato_tabla
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla) where dato_tabla='dato_tabla'");
$dat=$objeto->gestion->datos;
while($dat->next_record()){
if($dat->Record[dato_campo_id_seccion_mod] OR $dat->Record[dato_campo_id_seccion]){
    if($dat->Record[dato_campo_id_seccion]){ 
    $nex="<>"; 
    ${"index_tabla".$dat->Record[dato_campo_ntabla]}=$dat->Record[dato_campo]."='".$_POST[$dat->Record[dato_campo]]."'";
    $index_campo=$dat->Record[dato_campo]."=";
    } else{ 
    $nex="=";
    }//if
if($dat->Record[dato_campo_html])
  ${"mod_tabla".$dat->Record[dato_campo_ntabla]}[]=$dat->Record[dato_campo].$nex."'".$objeto->documento->a_html($_POST[$dat->Record[dato_campo]])."'";
  else
  ${"mod_tabla".$dat->Record[dato_campo_ntabla]}[]=$dat->Record[dato_campo].$nex."'".$_POST[$dat->Record[dato_campo]]."'";
}
$objeto->gestion->arra_campos_mod[]=array($dat->Record[dato_campo]." as '".$dat->Record[dato_campo_trad]."'", array("zona".$dat->Record[dato_campo_zona], 'tabla1'), $dat->Record[dato_campo_tipo], $dat->Record[dato_campo_forma_carga], $dat->Record[dato_campo_valor]);
}
$dat->query("select * from dato_tabla
left join dato_sql_select on (dato_tabla.id_dato_tabla=dato_sql_select.dato_sql_select_id_tabla) where dato_tabla='dato_tabla' and dato_sql_select_tipo='2'");
$dat->next_record();
$objeto->gestion->sql_mod=$dat->Record[dato_sql_select]." where $index_campo" ;

$objeto->gestion->sql_mod_update=array(
array(null, "mensaje de alarma1" , "delete from dato_tabla  where id_dato_tabla =".$_POST['id_dato_tabla'])
);
$objeto->documento->salida($objeto->gestion->pagina_del(), true, true);
*/
?>
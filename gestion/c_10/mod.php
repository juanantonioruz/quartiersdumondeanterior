<?php
require("../../include/objeto.php");
$objeto=new objeto(array("'prueba2'"));
/*
#echo "traduccion: ".$objeto->gestion->datos->traduccion['prueba2']."<hr>";
#$objeto->gestion->mostrar_variables=true;
$objeto->gestion->id_seccion="id_dato_sql_select";
$objeto->gestion->datos->query("select * from dato_tabla
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla) where dato_tabla='dato_sql_select'");
$dat=$objeto->gestion->datos;
while($dat->next_record())
if($dat->Record[dato_campo_mod]) 
$objeto->gestion->arra_campos_mod[]=array($dat->Record[dato_campo]." as '".$dat->Record[dato_campo_trad]."'", array("zona".$dat->Record[dato_campo_zona], 'tabla1'), $dat->Record[dato_campo_tipo], $dat->Record[dato_campo_forma_carga], $dat->Record[dato_campo_valor]);
$objeto->gestion->sql_mod="select [*] from dato_sql_select left join dato_tabla on (dato_tabla.id_dato_tabla= dato_sql_select.dato_sql_select_id_tabla) where id_dato_sql_select =";
$objeto->gestion->sql_mod_update=array(
array("select * from dato_sql_select where  id_dato_sql_select='".$_POST['id_dato_sql_select']."'  and dato_sql_select='".$_POST['dato_sql_select']."'  and id_dato_sql_select <>".$_POST['id_dato_sql_select'], "mensaje de alarma1" , "update dato_sql_select  set [*] where id_dato_sql_select =".$_POST['id_dato_sql_select'])
);
$objeto->documento->salida($objeto->gestion->pagina_mod(), true, true);
*/
?>
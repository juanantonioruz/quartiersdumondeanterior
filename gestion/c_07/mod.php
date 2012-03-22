<?php
require("../../include/objeto.php");
$objeto=new objeto(array("'prueba2'"));
/*
#echo "traduccion: ".$objeto->gestion->datos->traduccion['prueba2']."<hr>";
#$objeto->gestion->mostrar_variables=true;
$objeto->gestion->id_seccion="id_dato_campo";
$objeto->gestion->datos->query("select * from dato_tabla
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla) where dato_tabla='dato_campo'");
$dat=$objeto->gestion->datos;
while($dat->next_record()){
if($dat->Record[dato_campo_mod])
$objeto->gestion->arra_campos_mod[]=array($dat->Record[dato_campo]." as '".$dat->Record[dato_campo_trad]."'", array("zona".$dat->Record[dato_campo_zona], 'tabla1'), $dat->Record[dato_campo_tipo], $dat->Record[dato_campo_forma_carga], $dat->Record[dato_campo_valor], $dat->Record[dato_campo_html]);
}
$objeto->gestion->sql_mod="select [*] from dato_campo where id_dato_campo =";
$objeto->gestion->sql_mod_update=array(
array("select * from dato_campo where dato_campo_id_tabla ='".$_POST['dato_campo_id_tabla']."' and dato_campo='".$_POST['dato_campo']."' and id_dato_campo<>".$_POST['id_dato_campo'] , "mensaje de alarma1" , "update dato_campo  set [*] where id_dato_campo =".$_POST['id_dato_campo'])
);
$objeto->documento->salida($objeto->gestion->pagina_mod(), true, true);

*/
?>
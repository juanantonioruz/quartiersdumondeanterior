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
while($dat->next_record())
$objeto->gestion->arra_campos_mod[]=array($dat->Record[dato_campo]." as '".$dat->Record[dato_campo_trad]."'", array("zona".$dat->Record[dato_campo_zona], 'tabla1'), $dat->Record[dato_campo_tipo], $dat->Record[dato_campo_forma_carga], $dat->Record[dato_campo_valor]);
$objeto->gestion->sql_mod="select [*] from dato_tabla where id_dato_tabla=";
$objeto->gestion->sql_mod_update=array(
array("select * from traducir where identificativo='".$_POST['identificativo']."' and id_traducir<>".$_POST['id_traducir'], "mensaje de alarma1" , "update traducir  set [*] where id_traducir=".$_POST['id_traducir'])
);
$objeto->documento->salida($objeto->gestion->pagina_mod(), true, true);
*/
?>
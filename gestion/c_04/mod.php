<?php
require("../../include/objeto.php");
$objeto=new objeto(array("'prueba2'"));
/*
#echo "traduccion: ".$objeto->gestion->datos->traduccion['prueba2']."<hr>";
#$objeto->gestion->mostrar_variables=true;
$objeto->gestion->id_seccion="id_traducir";
$objeto->gestion->arra_campos_mod=array(
array("id_traducir as 'referencia'",  array('zona1', 'ref_'), 'hidden', 'consulta'), 
array("esp as 'trad_espa&ntilde;ol'",  array('zona1', 'tabla1'),  'text', 'consulta'), 
array("por as 'trad_portugu&eacute;s'",  array('zona2', 'tabla1'),  'text', 'consulta'), 
array("check_por as 'check_por'",  array('zona1', 'tabla1'),  'radio', 'array', array('si'=>1, 'no'=>0)), 
array("identificativo as 'identificativo'",  array('zona2', 'tabla1'),  'text', 'consulta')
);
$objeto->gestion->sql_mod="select [*] from traducir where id_traducir=";
$objeto->gestion->sql_mod_update=array(
array("select * from traducir where identificativo='".$_POST['identificativo']."' and id_traducir<>".$_POST['id_traducir'], "mensaje de alarma1" , "update traducir  set [*] where id_traducir=".$_POST['id_traducir'])
);
$objeto->documento->salida($objeto->gestion->pagina_mod(), true, true);
*/
?>
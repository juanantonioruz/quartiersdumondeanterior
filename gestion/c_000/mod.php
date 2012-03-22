<?php
require("../../include/objeto.php");
$objeto=new objeto(array("'prueba2'"));
/*
#echo "traduccion: ".$objeto->gestion->datos->traduccion['prueba2']."<hr>";
$objeto->gestion->mostrar_variables=true;
$objeto->gestion->id_seccion="id_registro_00";
$objeto->gestion->arra_campos_mod=array(
array("id_registro_00 as 'referencia'",  array('zona1', 'ref_'), 'hidden', 'consulta'), 
array("user as 'user'",  array('zona1', 'tabla1'),  'text', 'consulta'), 
array("password as 'password'",  array('zona2', 'tabla1'),  'text', 'consulta'), 
array("idioma as 'idioma'",  array('zona2', 'tabla1'),  'text', 'consulta'), 
array("traduce_1 as 'Primer idioma a traducir'",  array('zona1', 'tabla1'),  'select', 'array', $objeto->array_idiomas), 
array("traduce_2 as 'Segundo idioma a traducir'",  array('zona1', 'tabla1'),  'select', 'array', $objeto->array_idiomas), 
array("traduce_3 as 'Tercer idioma a traducir'",  array('zona1', 'tabla1'),  'select', 'array', $objeto->array_idiomas)
);
$objeto->gestion->sql_mod="select [*] from registro_00 where id_registro_00 =";
$objeto->gestion->sql_mod_update=array(
array("select * from registro_00 where user='".$_POST['user']."' and password='".$_POST['password']."' and id_registro_00<>".$_POST['id_registro_00'], "mensaje de alarma1" , "update registro_00  set [*] where id_registro_00=".$_POST['id_registro_00'])
);
$objeto->documento->salida($objeto->gestion->pagina_mod(), true, true);
*/
?>
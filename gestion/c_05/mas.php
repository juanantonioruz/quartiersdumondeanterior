<?php
require("../../include/objeto.php");
$objeto=new objeto(array("'prueba2'"));
#echo "traduccion: ".$objeto->gestion->datos->traduccion['prueba2']."<hr>";
#$objeto->gestion->mostrar_variables=true;
$objeto->gestion->arra_campos_mod=array(
array("esp as 'trad_espa&ntilde;ol'",  array('zona1', 'tabla1'),  'text', 'consulta'), 
array("por as 'trad_portugu&eacute;s'",  array('zona2', 'tabla1'),  'text', 'consulta'), 
array("check_por as 'check_por'",  array('zona1', 'tabla1'),  'radio', 'array', array('si'=>1, 'no'=>0)), 
array("identificativo as 'identificativo'",  array('zona2', 'tabla1'),  'text', 'consulta'), 
);
$objeto->gestion->sql_mas_update=array(
array("select * from traducir where identificativo='".$_POST['identificativo']."'", "mensaje de alarma1" , "insert into traducir([*])  values ([+])")
);
$objeto->documento->salida($objeto->gestion->pagina_mas(), true, true);
?>
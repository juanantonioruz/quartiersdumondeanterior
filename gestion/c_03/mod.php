<?php
require("../../include/objeto.php");
$objeto=new objeto(array("'prueba2'"));
/*
#echo "traduccion: ".$objeto->gestion->datos->traduccion['prueba2']."<hr>";
$objeto->gestion->mostrar_variables=true;
$objeto->gestion->id_seccion="id_seccion_00";
$objeto->gestion->arra_campos_mod=array(
array("id_seccion_00 as 'referencia'",  array('zona1', 'ref_'), 'hidden', 'consulta'), 
array("seccion_00 as 'secci&oacute;n'", array('zona1', 'tabla1'), 'text', 'consulta'), 
array("img as '*prueba'", array('zona3', 'tabla1'), 'img', 'consulta', array('50000', 200, 300)), 
array("seccion_00_esp as 'trad_espa&ntilde;ol'",  array('zona1', 'tabla1'),  'text', 'consulta'), 
array("seccion_00_por as 'trad_portugu&eacute;s'",  array('zona2', 'tabla1'),  'text', 'consulta'), 
array("check_por as 'check_por'",  array('zona1', 'tabla1'),  'radio', 'array', array('si'=>1, 'no'=>0)), 
array("visible as 'visible'",  array('zona2', 'tabla1'),   'radio', 'array', array('si'=>1, 'no'=>0))
);
$objeto->gestion->id_seccion="id_seccion_00";
$objeto->gestion->sql_mod="select [*] from seccion_00
where id_seccion_00=";
$objeto->gestion->sql_mod_update=array(
array("select * from seccion_00 where seccion_00='".$_POST['seccion_00']."' and id_seccion_00<>".$_POST['id_seccion_00'], "mensaje de alarma1" , "update seccion_00  set [*] where id_seccion_00=".$_POST['id_seccion_00'])
);
$objeto->documento->salida($objeto->gestion->pagina_mod(), true, true);
*/
/*
$objeto->documento->salida('');
echo "<form name='general' action='' method='POST'>";
echo "<input type='text' name='pepe' value='".$_POST['pepe']."'>";
for($i=1;$i<=10;$i++)
$objeto->upload->archivo_upload("archivo$i", '50000', 200, 300);
echo "<input type='submit'></form>";
$objeto->gestion->arra_campos_mod=array(
array("id_seccion_00 as referencia",  array('zona1', 'ref_'), 'hidden', 'consulta'), 
array("seccion_00 as 'secci&oacute;n'", array('zona1', 'tabla1'), 'text', 'consulta'), 
array("img as 'miniatura'", array('zona3', 'tabla1'), 'img', 'consulta', array('50000', 200, 300)), 
array("esp as 'trad_espa&ntilde;ol'",  array('zona1', 'tabla2'), 'radio', 'array', array('si'=>1, 'no'=>0)), 
array("por as 'trad_portugu&eacute;s'",  array('zona2', 'tabla2'), 'radio', 'array', array('si'=>1, 'no'=>0)), 
array("check_por as check_por",  array('zona1', 'tabla2'), 'select', 'sql', array('select user as visible, id_registro_00 as invisible from registro_00', 'blanco'))
);

*/
?>
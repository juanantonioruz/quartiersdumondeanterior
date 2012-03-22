<?php
require("../../include/objeto.php");
$objeto=new objeto();
$query_00="select * from equipos_00 where tipo_participante='grupo_trabajo' order by nombre";
$objeto->conecto_datos->query($query_00);
$peters="
<img src='../../images/peters_small.jpg' width='500' height='319' border='0' usemap='#Map'> 
<map name='Map'>
  <area shape='circle' coords='175,221,3' href='rio/index.php'>
  <area shape='circle' coords='141,174,3' href='elalto/index.php'>
  <area shape='circle' coords='133,145,3' href='bogota/index.php'>
  <area shape='circle' coords='238,39,3' href='evry/index.php'>
<area shape='circle' coords='243,43,3' href='montreuil/index.php'>
  <area shape='circle' coords='241,61,3' href='palma/index.php'>
  <area shape='circle' coords='236,55,3' href='barcelona/index.php'>
  <area shape='circle' coords='224,122,3' href='bamako/index.php'>
  <area shape='circle' coords='224,72,3' href='sale/index.php'>
  <area shape='circle' coords='210,121,3' href='pikine/index.php'>
</map><br>";
while($objeto->conecto_datos->next_record()){
if(!$con){$con=true; 
if($objeto->conecto_datos->Record["titulo_".$objeto->idioma])$titulo=$objeto->conecto_datos->Record["titulo_".$objeto->idioma]; else $titulo=$objeto->conecto_datos->Record["titulo_".$objeto->otro_idioma];
$arra_info[]=array($peters);
}
if($objeto->conecto_datos->Record["informacion_".$objeto->idioma])$info=$objeto->documento->a_html_format($objeto->conecto_datos->Record["informacion_".$objeto->idioma]); else $info=$objeto->documento->a_html_format($objeto->conecto_datos->Record["informacion_".$objeto->otro_idioma]);

$arra_info[]=array($objeto->documento->cubito_mas_info_qdm("<a href='".strtolower($objeto->conecto_datos->Record["directorio"])."/index.php'>".$objeto->conecto_datos->Record["nombre"]."</a>")."<br><div class='margin_20px'>$info</div><br><br>", $objeto->conecto_datos->Record["logo"]);
}
$inf=$objeto->documento->modulo_qdm($titulo, $arra_info);
$objeto->documento->salida($inf, true, true);
?>

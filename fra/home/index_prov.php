<?php
require("../../include/objeto.php");
$objeto=new objeto();
$contacto="<br><br><span align='center'><h3> ... .. de toutes fa&ccedil;ons, chaque quartier est un monde. ...</h3></span>
<div align='center'><table id='Table_01' width='434' height='419' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		
    <td colspan='3'> <img src='../../images_acogida/acogida_01.gif' alt='' width='434' height='164' border='0' usemap='#Map'></td>
	</tr>
	<tr>
		
    <td rowspan='2'> <img src='../../images_acogida/acogida_02.gif' alt='' width='149' height='255' border='0' usemap='#Map3'></td>
		
    <td> <img src='../../images_acogida/acogida_03.gif' alt='' name='central' width='128' height='88' id='central'></td>
		
    <td rowspan='2'> <img src='../../images_acogida/acogida_04.gif' alt='' width='157' height='255' border='0' usemap='#Map2'></td>
	</tr>
	<tr>
		
    <td> <img src='../../images_acogida/acogida_05.gif' alt='' width='128' height='167' border='0' usemap='#Map4'></td>
	</tr>
</table></div>
<map name='Map'>
  <area shape='rect' coords='26,76,76,123' href='#'  onClick=\"MM_goToURL('parent','../qdm/rio/');return document.MM_returnValue\"   onMouseOver=\"MM_swapImage('central','','../../images_acogida/acogida_rio.jpg',1)\" onMouseOut='MM_swapImgRestore()'>
  <area shape='rect' coords='153,24,186,44' href='#' onClick=\"MM_goToURL('parent','../qdm/sale/');return document.MM_returnValue\" onMouseOver=\"MM_swapImage('central','','../../images_acogida/acogida_sale.jpg',1)\" onMouseOut='MM_swapImgRestore()'>
  <area shape='rect' coords='263,30,315,49' href='#' onClick=\"MM_goToURL('parent','../qdm/bamako/');return document.MM_returnValue\" onMouseOver=\"MM_swapImage('central','','../../images_acogida/acogida_bamako.jpg',1)\" onMouseOut='MM_swapImgRestore()'>
  <area shape='rect' coords='355,122,419,142' href='#' onClick=\"MM_goToURL('parent','../qdm/barcelona/');return document.MM_returnValue\" onMouseOver=\"MM_swapImage('central','','../../images_acogida/acogida_barcelona.jpg',1)\" onMouseOut='MM_swapImgRestore()'>
</map>
<map name='Map2'>
  <area shape='rect' coords='95,67,142,89' href='#' onClick=\"MM_goToURL('parent','../qdm/bogota/');return document.MM_returnValue\" onMouseOver=\"MM_swapImage('central','','../../images_acogida/acogida_bogota.jpg',1)\" onMouseOut='MM_swapImgRestore()'>
  <area shape='rect' coords='32,182,79,203' href='#' onClick=\"MM_goToURL('parent','../qdm/elalto/');return document.MM_returnValue\" onMouseOver=\"MM_swapImage('central','','../../images_acogida/acogida_elalto.jpg',1)\" onMouseOut='MM_swapImgRestore()'>
</map>
<map name='Map3'>
  <area shape='rect' coords='13,38,63,61' href='#' onClick=\"MM_goToURL('parent','../qdm/pikine/');return document.MM_returnValue\" onMouseOver=\"MM_swapImage('central','','../../images_acogida/acogida_pikine.jpg',1)\" onMouseOut='MM_swapImgRestore()'>
  <area shape='rect' coords='34,149,97,196' href='#' onClick=\"MM_goToURL('parent','../qdm/palma/');return document.MM_returnValue\" onMouseOver=\"MM_swapImage('central','','../../images_acogida/acogida_palma.jpg',1)\" onMouseOut='MM_swapImgRestore()'>
</map>
<map name='Map4'>
  <area shape='rect' coords='22,111,59,138' href='#' onClick=\"MM_goToURL('parent','../qdm/evry/');return document.MM_returnValue\" onMouseOver=\"MM_swapImage('central','','../../images_acogida/acogida_evry.jpg',1)\" onMouseOut='MM_swapImgRestore()'>
</map>



";
$inf=$objeto->documento->modulo_qdm("", $contacto);

$objeto->documento->salida($inf, true, true);
?>


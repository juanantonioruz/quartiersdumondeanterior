<?php
require("../../include/objeto.php");
$objeto=new objeto();
$contacto="
<br><br><h1><a href='..
/qdm/presenta.php?id=288' class='menu_princ_on'>Declaraci&oacute;n de los y las jovenes de barrios del mundo</a></h1><div align='center'>
<table id='Table_01' width='398' height='454' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td>
			<img src='../../images_acogida/acogida_01_".$objeto->idioma.".gif' width='138' height='113' alt=''></td>
		<td>
			<img src='../../images_acogida/acogida_02.jpg' width='128' height='113' alt=''></td>
		<td>
			<img src='../../images_acogida/acogida_03.jpg' width='132' height='113' alt=''></td>
	</tr>
	<tr>
		<td>
			<img src='../../images_acogida/acogida_04.jpg' width='138' height='108' alt=''></td>
		<td>
			<img src='../../images_acogida/acogida_05_".$objeto->idioma.".gif' width='128' height='108' alt=''></td>
		<td>
			<img src='../../images_acogida/acogida_06.jpg' width='132' height='108' alt=''></td>
	</tr>
	<tr>
		<td>
			<img src='../../images_acogida/acogida_07.jpg' width='138' height='111' alt=''></td>
		<td>
			<img src='../../images_acogida/acogida_08.jpg' width='128' height='111' alt=''></td>
		<td>
			<img src='../../images_acogida/acogida_09_".$objeto->idioma.".gif' width='132' height='111' alt=''></td>
	</tr>
	<tr>
		<td>
			<img src='../../images_acogida/acogida_10.jpg' width='138' height='122' alt=''></td>
		<td>
			<img src='../../images_acogida/acogida_11.jpg' width='128' height='122' alt=''></td>
		<td>
			<img src='../../images_acogida/acogida_12.jpg' width='132' height='122' alt=''></td>
	</tr>
</table>
</div>

";
$inf=$objeto->documento->modulo_qdm("", $contacto."__");
$inf=$contacto;
$objeto->documento->salida($inf, true, true);
?>


<?php
require("../../include_gestion/objeto.php");
$objeto=new objeto();
$query_reg="select * from registro_00 where user='{$objeto->user}' and password='{$objeto->password}'";
$objeto->conecto_central->query($query_reg);
if($objeto->conecto_central->record_count){
#$salida.=  "<table border='0' cellspacing='1' cellpadding='5' width='90%' bgcolor='".$objeto->bgcolor_gestion."'>";
 # $salida.=  "<tr class='bg_color_4'><td align='right'><img src='../images/logo_gestion.jpg'></td></tr>";


  #  $salida.=  "<tr class='bg_color_4'><td>".usuario.": {$objeto->user}</td></tr>";
  #  $salida.=  "<tr class='bg_color_4'><td>".pw.": ******</td></tr>";#{$objeto->Record["password"]}
  #      $salida.=  "<tr class='bg_color_4'><td>&nbsp;</td></tr>";
        
$query_all_permisos="select id_registro_00, user, password, idioma, img, seccion_00, id_seccion_00, seccion_00_esp, seccion_00_fra, seccion_00_cat
from registro_00
left join registro_01 on (registro_00.id_registro_00=registro_01_id_registro_00)
left join seccion_00 on (seccion_00.id_seccion_00=registro_01_id_seccion_00)
where user='".$objeto->user."' and password='".$objeto->password."' and visible=1 
order by orden desc";
#and zona_gestion_registro=".$objeto->valor_zona_gestion." and zona_gestion=".$objeto->valor_zona_gestion."
$objeto->conecto_central->query($query_all_permisos);
while($objeto->conecto_central->next_record()){
if($objeto->conecto_central->Record["seccion_00"]=="c_98"){ $stats=true;
}else{
if($objeto->conecto_central->Record["seccion_00_".$objeto->conecto_central->Record[idioma]]) $esp=ucfirst($objeto->conecto_central->Record["seccion_00_".$objeto->conecto_central->Record[idioma]]); else $esp=$objeto->conecto_central->Record[seccion_00];
if($objeto->conecto_central->Record[img]) $img_gestion="<img src='../images/".$objeto->conecto_central->Record[img]."' border='0'>"; else $img_gestion=null;
   #             $salida.=  "\n<tr class='bg_color_4'><td ><a href='../".$objeto->conecto_central->Record[seccion_00]."/' >$img_gestion $esp </a></td></tr>\n";
$valor_tabla[]=array($objeto->conecto_central->Record[id_seccion_00], $esp, $objeto->conecto_central->Record[img]);
}//if
}//while


/*
		<td colspan='3' width='313' height='41' align='right' bgcolor='#0273BD' class='calida'>
		usuario: ".$objeto->user."
		<br>password: ******&nbsp;
		</td>
*/



$salida.="
<table id='Table_00' width='100%' height='100%' border='0' cellpadding='0' cellspacing='0' ><tr><td align='center' valign='middle'> 
<table id='Table_01' width='613' height='' border='0' cellpadding='0' cellspacing='0' >
	<tr>
		<td colspan='6'   align='right' >
			<font color='white'>usuario:".$objeto->user."</font>
			</td>
	</tr>

	<tr>
		<td colspan='6'  height='41' align='left'>
			<a href='#' class='menu_sup_nav'><img src='../images/licq.png' width=70> Inicio </a> <hr color='white'><br>
			</td>
	</tr>
	<tr>
		<td   width='35'>
		</td>
		<td colspan='4' width='558' align='center'>";
		
$salida.="<table id='Table_02'  border='0' cellpadding='0' cellspacing='0' width='558'>
";

$i=1;
foreach($valor_tabla as $valor){
if($i==4) $i=1;
if($i==1) $salida.="<tr>";
$salida.=item( $valor[2], $valor[1], $valor[0]);
if($i<>3)$salida.=espacio();
$i++;
if($i==4) $salida.="</tr>";
}//foerach

$salida.="</table>";
$salida.="	</td>
	<td width='20' ></td>
	</tr>
	
	<tr>
		<td colspan='3' width='50%' align='center'>
			<br><hr color='white'><br><a href='abandon.php' ><img src='../images/staroffice.png' width=50><br>Abandonar sesi&oacute;n</a><br><br></td>
		<td colspan='3' width='50%' align='center'>";
if($stats)	$salida.="<br><hr color='white'><br><a href='stats.php'><img src='../images/kspread.png' width=50><br>Estad&iacute;sticas</a><br><br>";
$salida.="	</td>
	</tr>


</table>
</td>
</tr>
</table>";


#        $salida.=  "<tr class='bg_color_4'><td>&nbsp;</td></tr>";
#        $salida.=  "<tr class='bg_color_4'><td><a href='abandon.php' >abandonar sesi&oacute;n</a></td></tr>";
#        $salida.=  "</table>";



		
        $salida.=$objeto->documento_gestion->close_body();
        $objeto->documento_gestion->salida($objeto->documento_gestion->modulo($salida));
}else{
$objeto->documento_gestion->salida($objeto->documento_gestion->form_registro());
$objeto->documento_gestion->close_body();
}


function espacio(){
return "<td align='center' valign='bottom' width='25%'>
<table id='Table_03'  border='0' cellpadding='0' cellspacing='0'>

	<tr>

		<td>
			<img src='../images/ajuste.gif' width='68' height='90' alt=''></td>
	</tr>
	<tr>
		<td>
			<img src='../images/ajuste.gif' width='68' height='27' alt=''></td>
	</tr>
</table>
</td>";
}

function item($imagen, $texto, $link){
return "<td align='center' valign='bottom' width='25%'>
<table id='Table_02'  border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td align='center'>
			<a href='../c_90/index.php?id_seccion=$link'><img src='../images/$imagen'   width=75  alt=''></a></td>
	</tr>
	<tr>
		<td height='27' align='center'>
			<b>$texto</b></td>
	</tr>
</table>
</td>";
}

?>


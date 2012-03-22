<?php
$url_array=array_reverse(explode('/', $_SERVER['PHP_SELF']));
if(count($url_array)==5) $url_2="../";
require("$url_2../../include/objeto.php");
$objeto=new objeto();
if($objeto->subseccion) $seccion= $objeto->subseccion; elseif($objeto->seccion=="socios") $seccion="agenda"; else $seccion=$objeto->seccion;
$objeto->conecto_datos->query("select * from 
equipos_00
left join socios_00 on (id_registro_00=equipos_00_id_registro_00)
 where directorio='$seccion' order by apoyan_socios, socio_".$objeto->idioma);
 $url_img=$objeto->documento->url;
while($objeto->conecto_datos->next_record()){
if(!$objeto->conecto_datos->Record[apoyan_socios] and !$una or ($una and $objeto->conecto_datos->Record[apoyan_socios])){
$arra_trad=array("Socios asociativos", "Socios institucionales");
$fila.="<tr><td valign='middle' class='td_img_info' colspan='3'>".$objeto->documento->cubito_mas_info_qdm($arra_trad[(int)$i]. $objeto->documento->conecto_datos->traduccion[$info_sec]."<br>")."
</td><tr>";
$fila.="<tr>
		<td colspan=3 style='background: url($url_img../../images_home/dot_666666_down.jpg) repeat-x ;'>
			<img src='$url_img../../images_home/pixel_transp.gif' width='1' height='13' alt=''></td>
</tr>";
if(!$una)$una=true; else $una=false;
$i++;
}
if($objeto->conecto_datos->Record["socio_".$objeto->idioma])$socio=$objeto->conecto_datos->Record["socio_".$objeto->idioma]; else $socio =$objeto->conecto_datos->Record["socio_".$objeto->otro_idioma];
$conn++;
if($objeto->conecto_datos->Record["logo"])
$fila.="<tr><td valign='bottom' width=1 align='right'> 
<img src='$url_img../../imgs/".$objeto->conecto_datos->Record["logo"]."'> 
</td><td style='background: url($url_img../../images_home/dot_666666.jpg) repeat-y ;' width=1>
<img src='$url_img../../images_home/pixel_transp.gif' width='1' height='1' alt=''>
</td>
<td valign='middle' class='td_img_info'>
<a href='http://".$objeto->conecto_datos->Record[link]."' target='_blank'>$socio</a><br><a href='http://".$objeto->conecto_datos->Record[link]."' target='_blank' class='menu_princ_off'>".$objeto->conecto_datos->Record[link]."</a>
</td><tr>";
else
$fila.="<tr><td valign='bottom' width=1 align='right'> 

</td><td width=1>
<img src='$url_img../../images_home/pixel_transp.gif' width='1' height='1' alt=''>
</td>
<td valign='middle' class='td_img_info'>
<a href='http://".$objeto->conecto_datos->Record[link]."' target='_blank'> $socio </a><br><a href='http://".$objeto->conecto_datos->Record[link]."' target='_blank' class='menu_princ_off'>".$objeto->conecto_datos->Record[link]."</a>
</td><tr>";

if($conn<>$objeto->conecto_datos->record_count)
$fila.="<tr>
		<td colspan=3 style='background: url($url_img../../images_home/dot_666666_down.jpg) repeat-x ;'>
			<img src='$url_img../../images_home/pixel_transp.gif' width='1' height='13' alt=''></td>
</tr>";

}
$table_ini="<table width='100%' cellpadding=6 cellspacing=4 border=0>";
$table_fin="</table>";
if($fila) $info=$table_ini.$fila.$table_fin;
$inf=$objeto->documento->modulo_qdm("", $info);
$objeto->documento->salida($inf, true, true);
?>

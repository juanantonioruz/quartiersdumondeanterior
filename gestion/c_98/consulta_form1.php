<?php
#require("../include/include/objetos.php");
$objeto=new objeto(array('formato'),array('clases'),array('local'),array('stats_language'));
for($s=1;$s<3;$s++){
${"dia_".$s}=sprintf("%02d",$_GET["dia_".$s]);
${"mes_".$s}=sprintf("%02d",$_GET["mes_".$s]);
${"anyo_".$s}=sprintf("%04d",$_GET["anyo_".$s]);
}
$fecha_actual=getdate();
if(!$_GET){ 
$error_fecha_1=null;$error_fecha_2=null; 
$anyo_1=$fecha_actual["year"];$anyo_2=$fecha_actual["year"];
$mes_1=$fecha_actual["mon"];$mes_2=$fecha_actual["mon"];
$dia_1=$fecha_actual["mday"];$dia_2=$fecha_actual["mday"];
}
echo "<table border=0 cellpadding=5 cellspacing=5><tr><td bgcolor='#EEEEEE'>";
echo "<form action='consulta_form2.php' target='detalle_gestion' method='GET' name='primero'>";
$array_info=array("<br>fecha inicial de corte<br>", "<br>fecha final de corte<br>");
for($h=1;$h<3;$h++){
echo $array_info[$h-1];
echo ${"error_fecha_".$h};
echo "<select name='dia_$h' >\n";
for($k=1;$k<32;$k++){
if(${"dia_".$h}==$k) $sel="selected"; else $sel="";
printf("<option $sel value='%'02d'>%'02d </option>\n", $k,$k);
}//for
echo "</select>";
echo "<select name='mes_$h' >\n";
for($k=1;$k<13;$k++){
if(${"mes_".$h}==$k) $sel="selected"; else $sel="";
printf(  " <option $sel value='%'02d'>%'02d </option>\n", $k,$k);
}//for
echo "</select>";
echo "<select name='anyo_$h' >\n";
for($k=4;$k<15;$k++){
if(${"anyo_".$h}==$k) $sel="selected"; else $sel="";
printf(  " <option $sel value='20%'02d'>20%'02d </option>\n", $k,$k);
}//for
echo "</select>";
}
$arra_tipo=array("gr&aacute;fico circular"=>"circular", "gr&aacute;fico horario"=>"horario", "gr&aacute;fico diario"=>"diario", "gr&aacute;fico mensual"=>"mensual", "gr&aacute;fico anual"=>"anual");
echo "<br><select name='tiempo' >\n";
foreach($arra_tipo as $valor=>$clave){
if($_GET["tiempo"]==$valor) $sel="selected"; else $sel=null;
echo "<option $sel value='$clave'>$valor</option>\n";
}
echo "</select>";
$consulta_tipo=array("Pa&iacute;ses visitantes"=>"paises", "Secciones visitadas"=>"paginas", "P&aacute;rametros de consulta"=>"consultas", "Tipo de establecimiento"=>"tipo_e", "Establecimientos"=>"establecimientos", "Mi seleccion"=>"mi_seleccion");
echo "<br><select name='consulta' >\n";
foreach($consulta_tipo as $valor=>$clave){
if($_GET["consulta"]==$valor) $sel="selected"; else $sel=null;
echo "<option $sel value='$clave'>$valor</option>\n";
}
echo "</select>";
echo "<br><input type='submit' name='enviar' value='enviar'>";
echo "</form>";
echo "</td></tr></table>";
?>
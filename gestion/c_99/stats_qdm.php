<?php
require("../../include/objeto.php");
$objeto=new objeto();
 $salida.=  "<table border=0><tr class='bg_color_4'><td> <img src='../images/kspread.png'>";
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

 $salida.=  "<form action='../c_98/consulta_form2.php'  method='GET' name='primero' target='detalle_stats'>";
$array_info=array("</td><td valign='bottom'>fecha inicial de corte<br>", "<br>fecha final de corte<br>");
for($h=1;$h<3;$h++){
 $salida.= $array_info[$h-1];
 $salida.= ${"error_fecha_".$h};
 $salida.= "<select name='dia_$h' >\n";
for($k=1;$k<32;$k++){
if(${"dia_".$h}==$k) $sel="selected"; else $sel="";
 $salida.=sprintf("<option $sel value='%'02d'>%'02d </option>\n", $k,$k);
}//for
 $salida.= "</select>";
 $salida.= "<select name='mes_$h' >\n";
for($k=1;$k<13;$k++){
if(${"mes_".$h}==$k) $sel="selected"; else $sel="";
 $salida.=sprintf(  " <option $sel value='%'02d'>%'02d </option>\n", $k,$k);
}//for
 $salida.= "</select>";
 $salida.= "<select name='anyo_$h' >\n";
for($k=4;$k<15;$k++){
if(${"anyo_".$h}==$k) $sel="selected"; else $sel="";
 $salida.=sprintf(  " <option $sel value='20%'02d'>20%'02d </option>\n", $k,$k);
}//for
 $salida.= "</select>";
}
$arra_tipo=array(
"Todo el web"=>"",
"Asociacion QDM"=>"QDM", 
"Proyecto QDM"=>"QDM PROYECTO", 
"Grupo: BAMAKO"=>"bamako",
"Grupo: BARCELONA"=>"barcelona",
"Grupo: BOGOT&Aacute;"=>"bogota",
"Grupo: DAKAR"=>"dakar",
"Grupo: EL ALTO"=>"elalto",
"Grupo: EVRY"=>"evry",
"Grupo: PALMA "=>"palma",
"Grupo: R&Iacute;O DE JANEIRO"=>"rio",
"Grupo: SAL&Eacute;"=>"sale"
);
 $salida.= "</td><td valign='bottom'><select name='usuario' >\n";
foreach($arra_tipo as $valor=>$clave){
if($_GET["tiempo"]==$valor) $sel="selected"; else $sel=null;
 $salida.= "<option $sel value='$clave'>$valor</option>\n";
}
 $salida.="</select>";

$arra_tipo=array( "gr&aacute;fico horario"=>"horario", "gr&aacute;fico diario"=>"diario", "gr&aacute;fico mensual"=>"mensual", "gr&aacute;fico anual"=>"anual", "gr&aacute;fico circular"=>"circular");
 $salida.= "<br><select name='tiempo' >\n";
foreach($arra_tipo as $valor=>$clave){
if($_GET["tiempo"]==$valor) $sel="selected"; else $sel=null;
 $salida.= "<option $sel value='$clave'>$valor</option>\n";
}
 $salida.="</select>";
$consulta_tipo=array(
"Pa&iacute;ses visitantes"=>"paises", 
"Secciones visitadas"=>"paginas",
"Idioma"=>"idioma"
);
 $salida.= "<br><select name='consulta' >\n";
foreach($consulta_tipo as $valor=>$clave){
if($_GET["consulta"]==$valor) $sel="selected"; else $sel=null;
 $salida.= "<option $sel value='$clave'>$valor</option>\n";
}
 $salida.= "</select>";
 $salida.="</td><td valign='bottom'>
 <input type='submit' name='enviar' value='enviar'>
 <input type='button' name='volver' value='volver a zona de gesti&oacute;n' onclick=\"javascript:window.parent.document.location='index.php';\">
";
 $salida.="</form>";


 $salida.= "</td></tr></table>";
 
        $salida.=$objeto->documento_gestion->close_body();
        $objeto->documento_gestion->salida($salida);

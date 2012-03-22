<?php
require("../../include/objeto.php");
$objeto=new objeto();

$salida.=  "<table border='0' cellspacing='1' cellpadding='5' width='90%' bgcolor='".$objeto->bgcolor_gestion."'>";
  $salida.=  "<tr class='bg_color_4'><td align='right'><img src='../images/logo_gestion.jpg'></td></tr>";
$array_usuario=array("esp"=>"Usuario", "fra"=>"Utilisateur");
$array_cerrar=array("esp"=>"Abandonar sesi&oacute;n", "fra"=>"Fermer la session");


        
$query_all_permisos="select id_registro_00, user, password, idioma, img, seccion_00, seccion_00_esp, seccion_00_fra
from registro_00
left join registro_01 on (registro_00.id_registro_00=registro_01_id_registro_00)
left join seccion_00 on (seccion_00.id_seccion_00=registro_01_id_seccion_00)
where user='".$objeto->user."' and password='".$objeto->password."' and visible=1 and zona_gestion_registro=".$objeto->valor_zona_gestion." and zona_gestion=".$objeto->valor_zona_gestion."
order by orden desc";
$objeto->datos_central->query($query_all_permisos);
while($objeto->datos_central->next_record()){
if(!$una){
$una=true;
$idioma_intro=$objeto->datos_central->Record[idioma];
    $salida.=  "<tr class='bg_color_4'><td>".$array_usuario[$idioma_intro].": {$objeto->user}</td></tr>";
#    $salida.=  "<tr class='bg_color_4'><td>".pw.": ******</td></tr>";#{$objeto->Record["password"]}
        $salida.=  "<tr class='bg_color_4'><td>&nbsp;</td></tr>";
}
if($objeto->datos_central->Record["seccion_00"]=="c_98"){ $stats=true;
}else{
if($objeto->datos_central->Record["seccion_00_".$objeto->datos_central->Record[idioma]]) $esp=ucfirst($objeto->datos_central->Record["seccion_00_".$objeto->datos_central->Record[idioma]]); else $esp=$objeto->datos_central->Record[seccion_00];
if($objeto->datos_central->Record[img]) $img_gestion="<img src='../images/".$objeto->datos_central->Record[img]."' border='0'>"; else $img_gestion=null;
                $salida.=  "\n<tr class='bg_color_4'><td ><a href='../".$objeto->datos_central->Record[seccion_00]."/' target='detalle'>$img_gestion $esp </a></td></tr>\n";
}//if
}//while
if($stats){
 $salida.=  "<tr class='bg_color_4'><td><span style='color:".$objeto->f_color_gestion."'>Estad&iacute;sticas</span>";
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

 $salida.=  "<form action='../c_98/consulta_form2.php' target='detalle' method='GET' name='primero'>";
$array_info=array("<br>fecha inicial de corte<br>", "<br>fecha final de corte<br>");
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
 $salida.= "<br><select name='usuario' >\n";
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
 $salida.="<br><input type='submit' name='enviar' value='enviar'>";
 $salida.="</form>";


 $salida.= "</td></tr>";
}

        $salida.=  "<tr class='bg_color_4'><td>&nbsp;</td></tr>";
        $salida.=  "<tr class='bg_color_4'><td><a href='abandon.php' target='_parent'>".$array_cerrar[$idioma_intro]."</a></td></tr>";
        $salida.=  "</table>
            <SCRIPT language=JavaScript>
            <!--
            parent.detalle.document.location='../c_99/detalle_".$idioma_intro.".php';
            //-->
            </SCRIPT>
		";
        $salida.=$objeto->documento->close_body();
		 $objeto->documento->salida($salida);
		 
?>


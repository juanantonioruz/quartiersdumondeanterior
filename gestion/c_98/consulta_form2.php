<?php
require("../../include_gestion/objeto.php");
$objeto=new objeto();
#$objeto=new objeto(array('formato'),array('clases'),array('local'),array('stats_language'));
for($s=1;$s<3;$s++){
${"dia_".$s}=sprintf("%02d",$_GET["dia_".$s]);
${"mes_".$s}=sprintf("%02d",$_GET["mes_".$s]);
${"anyo_".$s}=sprintf("%04d",$_GET["anyo_".$s]);
}
if (checkdate($mes_1, $dia_1,$anyo_1)) $fecha_1=$anyo_1."-".$mes_1."-".$dia_1; else $error_fecha_1="<br><font color='red'>fecha inicial de corte no es correcta</font><br>";
if (checkdate($mes_2, $dia_2,$anyo_2)) $fecha_2=$anyo_2."-".$mes_2."-".$dia_2; else $error_fecha_2="<br><font color='red'>fecha final de corte no es correcta</font><br>";
if($_GET["tiempo"]<>"circular"){
if(($anyo_1.$mes_1.$dia_1)>=($anyo_2.$mes_2.$dia_2) ){
$error_fecha_1="<br><font color='red'>Este tipo de gr&aacute;fica necesita un intervalo de tiempo superior a 1 d&iacute;a</font><br>";
}
}//if

if($fecha_1 && $fecha_2 && !$error_fecha_1 && !$error_fecha_2)
require("consultas_fechas.php");
elseif($error_fecha_1 OR $error_fecha_2)
echo $error_fecha_1. $error_fecha_2;
?>
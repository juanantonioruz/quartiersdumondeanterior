<?php
if($_GET["usuario"]==""){
 $usuario_filtro=null; 
 $usuario_nombre=strtoupper("Todo el web");
 }else{
  $usuario_filtro=" and seccion='".$_GET["usuario"]."' ";
   $usuario_nombre=strtoupper($_GET["usuario"]);
  }
if($_GET["tiempo"]=="circular"){
require("resumen.php");
}else{
if($_GET["tiempo"]=="horario")
require("consulta_hora.php");
elseif($_GET["tiempo"]=="diario")
require("consulta_dia.php");
elseif($_GET["tiempo"]=="mensual")
require("consulta_mes.php");
elseif($_GET["tiempo"]=="anual")
require("consulta_anyo.php");
}//if
?>

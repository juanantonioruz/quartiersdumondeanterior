<?php
class  error{
var $n_error="";
var $path="";
var $mensajes_usuario=array("no","Error en la conexi&oacute;n", "Error en la selecci&oacute;n de la base de datos ", "Error en la consulta a la base de datos" );

function error(){
if($_GET["n_error"]) $error=$_GET["n_error"]; else $error=3;
$this->error=$this->mensajes_usuario[$error];
$this->path=$_GET["path"];
}
}//class
?>
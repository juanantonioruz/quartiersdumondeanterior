<?php
require("../../include/objeto.php");
$objeto=new objeto();
require ("modulo_busqueda.php");
$objeto->documento->salida($objeto->documento->modulo_qdm("Buscador web",$texto_ficha), true, true);
?>
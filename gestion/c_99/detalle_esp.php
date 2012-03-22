<?php
require("../../include/objeto.php");
$objeto=new objeto();
$objeto->documento->salida("<br><h2>".$objeto->idiom."Bienvenido a la zona de gesti&oacute;n. </h2><h3>Usuario registrado: ".$_SESSION["user"]."</h3>");
$objeto->documento->close_body();
?>
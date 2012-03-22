<?php
require("../../include/objeto.php");
$objeto=new objeto();
$objeto->documento->salida("<br><h2>".$objeto->idiom."Bienvenue dans la zone de gestion. </h2><h3>Utilisateur enregistr&eacute;: ".$_SESSION["user"]."</h3>");
$objeto->documento->close_body();
?>
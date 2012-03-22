<?php
if($_GET["consulta"]=="paises")
require("resumen_paises.php");
elseif($_GET["consulta"]=="paginas")
require("resumen_paginas.php");
elseif($_GET["consulta"]=="idioma")
require("resumen_idioma.php");
?>

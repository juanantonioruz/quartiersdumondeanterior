<?php
require("../../include/objeto.php");
$objeto=new objeto();
$objeto->documento->head_in();
$objeto->documento->open_body();
echo "Su petici&oacute;n a la p&aacute;gina web ha originado este error:<br>".$objeto->error->error."<br><a href='".$objeto->error->path."'>volver a intentar</a>";
$objeto->documento->close_body();

?>
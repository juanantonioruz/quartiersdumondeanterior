<?php
require_once("global_interface.php");
class documento_gestion extends global_interface{
var $css="estilos_web4.css"; 
function documento_gestion(){
    $this->graba_variables_obj_ppal(func_get_args());
}//constructor
function abrir_tabla_modulo($ancho,$alto, $alinear_tabla="left"){
$ancho_celda_min="5";
if($ancho=='100%')
$ancho_celda_max=100-($ancho_celda_min*2)."%";
else
$ancho_celda_max=$ancho-($ancho_celda_min*2);
$alto_celda_min="5";

$salida.= "<table class='modulo'  width='$ancho' height='$alto' border='0' cellspacing='0' cellpadding='0' align='$alinear_tabla'>\n";
$salida.= "<tr>\n";
$salida.= "<td width='$ancho_celda_min' height='$alto_celda_min' class='modulo_v1'><img src='".$this->url."../../images/ajuste.gif' width='$ancho_celda_min' height='$alto_celda_min'></td>\n";
$salida.= "<td width='$ancho_celda_max' height='$alto_celda_min' class='modulo_h1'></td>\n";
$salida.= "<td width='$ancho_celda_min' height='$alto_celda_min' class='modulo_v2'><img src='".$this->url."../../images/ajuste.gif' width='$ancho_celda_min' height='$alto_celda_min'></td>\n";
$salida.= "</tr>";
return $salida;
}//function

function abrir_tabla_info($ancho,$alto,$alinear_central_h, $alinear_central_v){
$ancho_celda_min="5";
if($ancho=='100%')
$ancho_celda_max=100-($ancho_celda_min*2)."%";
else
$ancho_celda_max= $ancho-($ancho_celda_min*2);
$alto_celda_min="5";
$alto_max=$alto-($alto_celda_min*2);
$salida.= "<tr>\n";
$salida.= "<td width='$ancho_celda_min' class='modulo_t1'></td>\n";
$salida.= "<td width='$ancho_celda_max' class='modulo_central' align='$alinear_central_h' valign='$alinear_central_v'>\n";
$salida.= "<table border='0' cellspacing='1' cellpadding='5' width='100%' bgcolor='".$this->bgcolor_gestion."'><tr class='bg_color_2'><td align='left'>\n";
return $salida;
}//function

function cerrar_tabla_info($ancho,$alto,$alinear_central_h, $alinear_central_v){
$ancho_celda_min="5";
if($ancho=='100%')
$ancho_celda_max=100-($ancho_celda_min*2)."%";
else
$ancho_celda_max= $ancho-($ancho_celda_min*2);
$alto_celda_min="5";
$salida.= "</td></tr></table></td>\n";
$salida.= "<td width='$ancho_celda_min' class='modulo_t2'></td>\n";
$salida.= "</tr>\n";
return $salida;
}

function cerrar_tabla_modulo($ancho,$alto=""){
$ancho_celda_min="5";
if($ancho=='100%')
$ancho_celda_max=100-($ancho_celda_min*2)."%";
else
$ancho_celda_max= $ancho-($ancho_celda_min*2);
$alto_celda_min="5";
$salida.= "<tr>\n";
$salida.= "<td width='$ancho_celda_min' height='$alto_celda_min' class='modulo_v3'><img src='".$this->url."../../images/ajuste.gif' width='$ancho_celda_min' height='$alto_celda_min'></td>\n";
$salida.= "<td width='$ancho_celda_max' height='$alto_celda_min' class='modulo_h2'></td>\n";
$salida.= "<td width='$ancho_celda_min' height='$alto_celda_min' class='modulo_v4'><img src='".$this->url."../../images/ajuste.gif' width='$ancho_celda_min' height='$alto_celda_min'></td>\n";
$salida.= "</tr>\n";
$salida.= "</table>\n\n\n";
return $salida;
}//function


function salida($info, $open=false, $close=false){
if(!$open && !$close && !$this->open){
$info=$this->head_in().$this->open_body_gestion().$info;
$this->open=true;
}//if
if($open && !$this->open)
 $info=$this->head_in().$this->open_body_gestion().$info;
if($close)
 $info.=$this->close_body();
echo $info;
}


function head_in(){
$salida.= "<html>\n";
$salida.= "<HEAD>\n";
$salida.= "<TITLE>". $this->titulo_pagina."</TITLE>\n";
$salida.= "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
#$salida.= "<script language='JavaScript' src='".$this->url."../../css/funciones.js'></script>\n";
$salida.= "<link rel='stylesheet' type='text/css' href='".$this->url."../../css/".$this->css."'>\n";
#$salida.= "<link rel='shortcut icon' href='../../images/tr_logo.gif' />\n";
$salida.= "</head>\n\n";
return $salida;
}//head_in

function open_body_gestion(){
if($this->seccion=="c_99")
$salida.= "\n\n<body bgcolor='#FFFFFF' text='#000000'  marginwidth='0' marginheight='0' topmargin='0' leftmargin='0' onload='document.forms[0].elements[0].focus();'>\n\n";
else
$salida.= "\n\n<body bgcolor='#FFFFFF' text='#000000'  marginwidth='0' marginheight='0' topmargin='0' leftmargin='0' >\n\n";
return $salida;
}//function



function close_body(){
$salida.= "\n\n</body>\n\n</html>";
return $salida;
} //function


function form_registro(){
$salida.=  "<table width='100%' height='100%' border=0>
<tr><td align='center' valign='middle'>
<table border='0' cellspacing='1' cellpadding='5' width='300' bgcolor='".$this->bgcolor_gestion."' >";
$salida.=  "<tr class='bg_color_4'><td align='right'><font color='".$this->f_color_gestion."'><b>Zona de gesti&oacute;n </b></font></td></tr>";
$salida.=  "<form action='".$_SERVER['PHP_SELF']."' method='post' >";
$salida.=  "<tr class='bg_color_3'><td align='right'><font color='".$this->f_color_gestion."'>usuario  </font><input type='text' name='user' value=''></td></tr>";
$salida.=  "<tr class='bg_color_1'><td align='right'><font color='".$this->f_color_gestion."'>clave </font><input type='password' name='password' value=''></td></tr>";
$salida.=  "<tr class='bg_color_3'><td align='center'><input type='submit' name='enviar_claves' value='enviar'></td></tr>";
$salida.=  "</form>";
$salida.=  "</table>
</td></tr></table>";
return $salida;
}// f_ form_registro


function frame_index_01($row_or_column, $first_frame,  $first_document, $first_size, $second_frame, $second_document, $second_size){
$salida.= "<html>\n";
$salida.= "<head>\n<title>gesti&oacute;n</title>\n";
$salida.= "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
$salida.= "</head>\n";
$salida.= "<frameset $row_or_column='$first_size, $second_size' frameborder='NO' border='0' framespacing='0' > \n";
$salida.= "<frame name='$first_frame' scrolling='AUTO' src='$first_document' >\n";
$salida.= "<frame name='$second_frame' scrolling='AUTO' src='$second_document'>\n";
$salida.= "</frameset>\n";
$salida.= "<noframes></noframes></html>\n";
return $salida;
}//function frame_index

}//class

?>
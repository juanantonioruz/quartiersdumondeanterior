<?php
$url_array=array_reverse(explode('/', $_SERVER['PHP_SELF']));
if(count($url_array)==5) $url_2="../";
require("$url_2../../include/objeto.php");
$objeto=new objeto();
if($objeto->subseccion) $seccion= $objeto->subseccion; else  $seccion= $objeto->seccion;
if($seccion=="contacto") $seccion="agenda";
$objeto->conecto_datos->query("select * from equipos_00
left join contacto_00 on (id_registro_00=equipos_00_id_registro_00) 
where directorio='$seccion' ");
while($objeto->conecto_datos->next_record()){
$conta= $objeto->conecto_datos->Record["contacto_00_".$objeto->idioma];
$mail=$objeto->conecto_datos->Record[mail];
}
if($_POST['name']<>""){
$mensaje="nombre: ".$_POST['name']."\n
apellidos: ".$_POST['surname']."\n
company: ".$_POST['company']."\n
ciudad: ".$_POST['city']."\n
phone: ".$_POST['phone']."\n
email: ".$_POST['email']."\n
mensaje: ".$_POST['message']."";
mail($mail,"Formulario de contacto quartiers du monde.org",$mensaje,"From:contacto@quartiersdumonde.org\nReply-To:".$_POST['email']."\nX-Mailer: PHP/".phpversion());
$contacto=$objeto->documento->conecto_datos->traduccion[mensaje_correcto];
}else{
$contacto[]=array("
<SCRIPT language='JavaScript'>\n<!--\n
function SendForm () {\n
 var required = new Array('name', 'surname', 'email', 'message');\n
var reqdescr = new Array('".$objeto->de_html($objeto->documento->conecto_datos->traduccion[contacto_nombre])."', '".$objeto->de_html($objeto->documento->conecto_datos->traduccion[contacto_apellido])."', 'E-mail', '".$objeto->de_html($objeto->documento->conecto_datos->traduccion[contacto_mensaje])."');\n
var i,j;\n
for(j=0; j<required.length; j++) {\n
  for (i=0; i<document.mail_form.length; i++) {\n
     if (document.mail_form.elements[i].name == required[j] && document.mail_form.elements[i].value == '' )  {\n
    alert('".$objeto->de_html($objeto->documento->conecto_datos->traduccion[contacto_espacio])."\"'+reqdescr[j]+'\"".$objeto->de_html($objeto->documento->conecto_datos->traduccion[contacto_completado])."');\n
    document.mail_form.elements[i].focus();\n
     return false;\n
    }\n
  }\n
}\n
 return true;\n
}\n
//-->\n</SCRIPT>\n
<TABLE cellspacing=0 cellpadding=0 border=0 >
<TR valign=top><TD width=170>
".$objeto->documento->a_html_format($conta)."<br><br>".$objeto->documento->conecto_datos->traduccion[contacto_info]."<a href='mailto:$mail'>$mail</a> ".$objeto->documento->conecto_datos->traduccion[contacto_info2]."</TD><TD><IMG src=$url_2../../images_home/pixel_transp.gif width=25 height=1 alt=''></TD>
<TD valign='top'>
<TABLE cellspacing=0 cellpadding=0 border=0 >
<FORM name=mail_form method=post onSubmit=\"return SendForm();\">
<TR><TD><IMG src=$url_2../../images_home/v1_666666.gif width=9 height=9 alt=''></TD><TD><IMG src=$url_2../../images_home/pixel_transp.gif width=79 height=1 alt=''></TD><TD><IMG src=$url_2../../images_home/pixel_transp.gif width=162 height=1 alt=''></TD><TD><IMG src=$url_2../../images_home/v2_666666.gif width=9 height=9 alt=''></TD></TR>
<TR><TD>&nbsp;</TD><TD><FONT class=bb>".$objeto->documento->conecto_datos->traduccion[contacto_nombre].":</FONT> <FONT class=tit>(*)</FONT></TD><TD ><INPUT type=text name=name value=''></TD><TD>&nbsp;</TD></TR>
<TR><TD colspan=4><IMG src=$url_2../../images_home/pixel_transp.gif width=1 height=4 alt=''></TD></TR>
<TR><TD>&nbsp;</TD><TD><FONT class=bb>".$objeto->documento->conecto_datos->traduccion[contacto_apellido].":</FONT> <FONT class=tit>(*)</FONT></TD><TD ><INPUT type=text name=surname value=''></TD><TD>&nbsp;</TD></TR>
<TR><TD colspan=4><IMG src=$url_2../../images_home/pixel_transp.gif width=1 height=4 alt=''></TD></TR>
<TR><TD>&nbsp;</TD><TD><FONT class=bb>".$objeto->documento->conecto_datos->traduccion[contacto_organizacion].":</FONT></TD><TD ><INPUT type=text name=company value=''></TD><TD>&nbsp;</TD></TR>
<TR><TD colspan=4><IMG src=$url_2../../images_home/pixel_transp.gif width=1 height=4 alt=''></TD></TR>
<TR><TD>&nbsp;</TD><TD><FONT class=bb>".$objeto->documento->conecto_datos->traduccion[contacto_ciudad].":</FONT></TD><TD ><INPUT type=text name=city value=''></TD><TD>&nbsp;</TD></TR>
<TR><TD colspan=4><IMG src=$url_2../../images_home/pixel_transp.gif width=1 height=4 alt=''></TD></TR>
<TR><TD>&nbsp;</TD><TD><FONT class=bb>".$objeto->documento->conecto_datos->traduccion[contacto_telefono]."</FONT></TD><TD ><INPUT type=text name=phone value=''></TD><TD>&nbsp;</TD></TR>
<TR><TD colspan=4><IMG src=$url_2../../images_home/pixel_transp.gif width=1 height=4 alt=''></TD></TR>
<TR><TD>&nbsp;</TD><TD><FONT class=bb>E-mail:</FONT> <FONT class=tit>(*)</FONT></TD><TD><INPUT type=text name=email value=''></TD><TD>&nbsp;</TD></TR>
<TR><TD colspan=4><IMG src=$url_2../../images_home/pixel_transp.gif width=1 height=4 alt=''></TD></TR>
<TR><TD>&nbsp;</TD><TD colspan=2><FONT class=bb>".$objeto->documento->conecto_datos->traduccion[contacto_mensaje].":</FONT> <FONT class=tit>(*)</FONT></TD><TD>&nbsp;</TD></TR>
<TR><TD colspan=4><IMG src=$url_2../../images_home/pixel_transp.gif width=1 height=4 alt=''></TD></TR>
<TR><TD>&nbsp;</TD><TD colspan=2><TEXTAREA name=message rows=5 cols=35></TEXTAREA></TD><TD>&nbsp;</TD></TR>
<TR><TD><IMG src=$url_2../../images_home/v4_666666.gif width=9 height=9 alt=''></TD><TD colspan=2>&nbsp;</TD><TD><IMG src=$url_2../../images_home/v3_666666.gif width=9 height=9 alt=''></TD></TR>
<TR><TD colspan=2>&nbsp;</TD><TD colspan=2><A HREF=\"javascript: if ( SendForm() ) { document.mail_form.submit(); }\"> >> ".$objeto->documento->conecto_datos->traduccion[contacto_enviar]."</A><INPUT type=hidden name=action value='go'>
</TD></TR>
</FORM>
</TABLE></TD></TR></TABLE>","");
}
$inf=$objeto->documento->modulo_qdm($objeto->documento->conecto_datos->traduccion[contacto], $contacto);

$objeto->documento->salida($inf, true, true);
?>
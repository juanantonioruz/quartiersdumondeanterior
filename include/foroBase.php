<?php
session_start();
$foroValido=0;
if($_POST['user_foro']){
if($_POST['user_foro']=="jeune"  or $_POST['user_foro']=="jovem"  or $_POST['user_foro']=="jove" or $_POST['user_foro']=="joven" ){
$_SESSION["foros_reg"]=1;
$_SESSION["foros_tipo"]="joven";
}elseif($_POST['user_foro']=="groupe"  or $_POST['user_foro']=="grup" or $_POST['user_foro']=="grupo" ){
$_SESSION["foros_reg"]=1;
$_SESSION["foros_tipo"]="grupo";
}elseif($_POST['user_foro']=="femme"  or $_POST['user_foro']=="mujer" ){
$_SESSION["foros_reg"]=1;
$_SESSION["foros_tipo"]="mujer";
}elseif($_POST['user_foro']=="migraciones"  or $_POST['user_foro']=="migrations" ){
$_SESSION["foros_reg"]=1;
$_SESSION["foros_tipo"]="migraciones";
}else{
$_SESSION["foros_reg"]=0;
$_SESSION["foros_tipo"]="";
}//if joven

}

if($_GET['abandon']==1){
 $_SESSION["foros_reg"]=0;
 $_SESSION["foros_tipo"]="";
 }

if($tipoForo=="qdm"){
 if($_SESSION["foros_tipo"]=="joven" || $_SESSION["foros_tipo"]=="grupo" || $_SESSION["foros_tipo"]=="migraciones")
 $foroValido=1;

 }elseif($tipoForo=="mujer" &&  $_SESSION["foros_tipo"]=="mujer"){
     $foroValido=1;
 }
require("objeto.php");
$objeto=new objeto(array("'comentario'", "'autor'", "'fecha'", "'nuevo_comentario'", "'contestar_comentario'", "'ver_comentarios'", "'dias'", "'todos_comentarios'", "'filtrar'","'asunto'", "'enviar_comentario'", "'borrar_comentario'", "'cerrar_ventana'", "'introduce_nombre'", "'introduce_asunto'", "'foro_dialogo'", "'usuario'", "'foro_registro'", "'abandon_foro'", "'foro_enviar'", "'sin_comentarios'"));
if($_SESSION["foros_reg"] && $foroValido>0){
$tit_foro="select nombre_foro_esp, nombre_foro_fra, informacion_foro_esp, informacion_foro_fra
from foros_00
where  id_foros_00=".$objeto->documento->id_reg;
$objeto->conecto_datos->query($tit_foro);

if($objeto->conecto_datos->next_record()){
if($objeto->conecto_datos->Record["nombre_foro_".$objeto->idioma]) $nombre_foro =$objeto->conecto_datos->Record["nombre_foro_".$objeto->idioma];
else $nombre_foro =$objeto->conecto_datos->Record["nombre_foro_".$objeto->otro_idioma];
if($objeto->conecto_datos->Record["informacion_foro_".$objeto->idioma]) $info_foro =$objeto->conecto_datos->Record["informacion_foro_".$objeto->idioma];
else $info_foro =$objeto->conecto_datos->Record["informacion_foro_".$objeto->otro_idioma];
}
if($_SESSION["foros_tipo"]=="joven" || $_SESSION["foros_tipo"]=="grupo" || $_SESSION["foros_tipo"]=="mujer" || $_SESSION["foros_tipo"]=="migraciones"){
$doc_foro="select * from document_up left join foros_00 on (id_foros_00=document_up_id_principal)
where  seccion_principal='c_25'
and id_foros_00=".$objeto->documento->id_reg."
";
$objeto->conecto_datos->query($doc_foro);
while($objeto->conecto_datos->next_record()){
if($objeto->conecto_datos->Record["document_up_".$objeto->idioma]) $documento_foro =$objeto->conecto_datos->Record["document_up_".$objeto->idioma];
else $documento_foro =$objeto->conecto_datos->Record["document_up_".$objeto->otro_idioma];
if($objeto->conecto_datos->Record["informacion_".$objeto->idioma]) $info_documento_foro =$objeto->conecto_datos->Record["informacion_".$objeto->idioma];
else $info_documento_foro=$objeto->conecto_datos->Record["informacion_".$objeto->otro_idioma];
$listado_docs_foro.="<div class='margin_20px' align='left'><a href='../../imgs/$documento_foro'> <img src='../../gestion/c_99/imgs/".$objeto->documento->sel_imagen_doc($documento_foro)."' border=0 valign='middle'> > $info_documento_foro </a></div><br>";

}//while
$listado_docs_foro=$objeto->documento->cubito_mas_info_qdm("Documentaci&oacute;n propuesta")."<br>".$listado_docs_foro;
}//if $_SESSION["foros_tipo"]="grupo"
$qq_foro="select id_registro_00, document_up_esp, document_up_fra,document_up.informacion_esp,
nombre_foro_esp, nombre_foro_fra, informacion_foro_esp, informacion_foro_fra, document_up.informacion_fra,  nombre from document_up
right join equipos_00 on (equipos_00_id_registro_00=id_registro_00)
left join foros_00 on (id_foros_00=document_up_id_principal)
where seccion_principal='c_27' and id_foros_00=".$objeto->documento->id_reg." order by  nombre";
$objeto->conecto_datos->query($qq_foro);
#echo $qq_foro;
#echo "<hr>ID LINK".$objeto->conecto_datos->Link_ID."<hr>";
$objeto->foro->Link_ID=$objeto->conecto_datos->Link_ID;
while($objeto->conecto_datos->next_record()){
if(!$una){
$una=true;
if($objeto->conecto_datos->Record["nombre_foro_".$objeto->idioma]) $nombre_foro =$objeto->conecto_datos->Record["nombre_foro_".$objeto->idioma];
else $nombre_foro =$objeto->conecto_datos->Record["nombre_foro_".$objeto->otro_idioma];
if($objeto->conecto_datos->Record["informacion_foro_".$objeto->idioma]) $info_foro =$objeto->conecto_datos->Record["informacion_foro_".$objeto->idioma];
else $info_foro =$objeto->conecto_datos->Record["informacion_foro_".$objeto->otro_idioma];

}
$nombre_grupo=$objeto->conecto_datos->Record[nombre];
$id_grupo=$objeto->conecto_datos->Record[id_registro_00];
if($objeto->conecto_datos->Record["informacion_foro_".$objeto->idioma]) $informacion_doc =$objeto->conecto_datos->Record["informacion_".$objeto->idioma];
else $informacion_doc =$objeto->conecto_datos->Record["informacion_".$objeto->otro_idioma];
if($objeto->conecto_datos->Record["document_up_".$objeto->idioma]) $doc =$objeto->conecto_datos->Record["document_up_".$objeto->idioma];
else $doc =$objeto->conecto_datos->Record["document_up_".$objeto->otro_idioma];

if($doc){
if($nombre_grupo_ant<>$nombre_grupo){
if($nombre_grupo_ant)$listado.="<br><br>";
$listado.=$objeto->documento->cubito_mas_info_qdm($nombre_grupo)."<br>";
}//if
$listado.="<div class='margin_20px' align='left'><a href='../../imgs/$doc'> <img src='../../gestion/c_99/imgs/".$objeto->documento->sel_imagen_doc($doc)."' border=0 valign='middle'> > $informacion_doc </a></div><br>";
$nombre_grupo_ant=$nombre_grupo;
}//doc

}
$objeto->foro->id_foro00=$objeto->documento->id_reg;
$objeto->foro->traduccion=$objeto->documento->conecto_datos->traduccion;
$inf_foro2=$objeto->foro->dibujar();
#if(!$listado) $listado="<b>No existen documentos de participacion en este foro</b>";
if($_SESSION["foros_tipo"]=="grupo") $contenido=$listado."<br><br><br>". $inf_foro2;
else $contenido=$inf_foro2;

$inf=$objeto->documento->modulo_qdm("<b>".$nombre_foro."</b>:<br>".$info_foro, $listado_docs_foro.$contenido);

}else{
$salida.=  "<table width='100%' height='100%' border=0>
<tr><td align='center' valign='middle'>
<table border='0' cellspacing='1' cellpadding='5' width='300' bgcolor='".$objeto->documento->bgcolor_gestion."' >";
$salida.=  "<tr class='bg_color_4'><td align='right'><font color='".$objeto->documento->f_color_gestion."'><b>".$objeto->documento->conecto_datos->traduccion[foro_registro]." </b></font></td></tr>";
$salida.=  "<form action='".$_SERVER['PHP_SELF']."' method='post' >";
$salida.=  "<tr class='bg_color_3'><td align='right'><font color='".$objeto->documento->f_color_gestion."'>".$objeto->documento->conecto_datos->traduccion[usuario]."</font><input type='text' name='user_foro' value=''></td></tr>";
$salida.=  "<tr class='bg_color_3'><td align='center'><input type='submit' name='enviar_claves' value='".$objeto->documento->conecto_datos->traduccion[foro_enviar]."'></td></tr>";
$salida.=  "</form>";
$salida.=  "</table>
</td></tr></table>";

$formulario=$salida;
$inf=$objeto->documento->modulo_qdm("Registro de foros", $formulario);

}
$objeto->documento->salida($inf, true, true);
?>

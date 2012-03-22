<?php
session_register("GlimpseDir");
if(!$GlimpseDir) $GlimpseDir="/";
$basedir="../../imgs/";
function reloadnow() {
#global $PHP_SELF;
global $addons;
#header("Status: 302 Moved");
header("Location: ".$_SERVER['PHP_SELF']."".$addons);
exit(); 
}

if($cancel) $action="";
if($action=="root") $GlimpseDir="/";
if($action=="chdr") $GlimpseDir=$file."/";
if($action=="dele" && $confirm==1){unlink($basedir.$file); $action="";}
if($action=="move" && $confirm && $newfile) {
rename($basedir.$file,$basedir.$newfile); $action="";}
if($action=="rmdr") rmdir($basedir.$file);


if($action=="edit" && $confirm && $file) {
$fp=fopen($basedir.$file,"w");
fputs($fp,stripslashes($code));
fclose($fp);
$addons="?action=edit&file=".rawurlencode($file);
reloadnow(); } 
if($_POST['upload']) { 
#foreach($_FILES['userfile'] as $clave=>$valor)
#echo $clave."-".$valor;
if((($_POST['libre']*1000)-$_FILES['userfile']['size'])>0){
copy($userfile,$basedir.$GlimpseDir.$userfile_name); 
reloadnow();
}else{
echo "<h3>NO DISPONE DE MA&Aacute;S EN SU DISCO VIRTUAL</h3>";

} 
}
if($touch) { touch($basedir.$GlimpseDir.$touchfile); reloadnow(); }
if($mkdir) { mkdir($basedir.$GlimpseDir.$mkdirfile,0700); reloadnow();
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3c.org/TR/REC-html40/loose.dtd">
<?php
#require("../include/gestion.php");
#$gestion=new gestion(array('formato'));
#$gestion->abrir_documento();


#$gestion->documento->abrir_tabla_modulo(600,100,"left","middle", "left");

#$gestion->documento->abrir_tabla_info(600,100,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)




if ($action=="dele") {
echo "Est&aacute;s seguro de borrar el archivo: $file ?<BR>";
echo "<A HREF=\"".$_SERVER['PHP_SELF']."?action=dele&file=" . rawurlencode($file) . "&confirm=1\">SI</A><BR>";
echo "<A HREF=\"".$_SERVER['PHP_SELF']."\">NO</A><BR>";
 #$gestion->documento->cerrar_tabla_info(600,100,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
  #$gestion->documento->cerrar_tabla_modulo(600,100);

#$gestion->cerrar_documento();
exit(); }


if ($action=="edit") {
echo "<FORM METHOD=\"POST\" ACTION=\"".$_SERVER['PHP_SELF']."\">\n";
echo "Archivo actual es: ".$file ." ";
echo "<INPUT TYPE=\"HIDDEN\" NAME=\"file\" VALUE=\"$file\">\n";
echo "<INPUT TYPE=\"HIDDEN\" NAME=\"action\" VALUE=\"edit\">\n";
echo "<INPUT TYPE=\"SUBMIT\" NAME=\"confirm\" VALUE=\"Save\">\n"; 
echo "<INPUT TYPE=\"SUBMIT\" NAME=\"cancel\" VALUE=\"Exit\"><BR>\n";
$fp=fopen($basedir.$file,"r");
$contents=fread($fp,filesize($basedir.$file));
echo "<TEXTAREA NAME=\"code\" rows=\"20\" cols=\"80\">\n";
echo htmlspecialchars($contents);
echo "</TEXTAREA><BR>\n";

echo "</FORM>";
 #$gestion->documento->cerrar_tabla_info(600,100,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
  #$gestion->documento->cerrar_tabla_modulo(600,100);

#$gestion->cerrar_documento();
exit();
}




$handle=opendir($basedir.$GlimpseDir);
while($file = readdir($handle)) {
if ($file != "." && $file != "..") {
$filename=$basedir.$GlimpseDir.$file;
$fileurl=rawurlencode($GlimpseDir.$file);
if ($una==false){
echo "<h3 class='color_5'>Su disco virtual contiene en este momento los siguientes archivos:</h3>\n";

echo "<TABLE width='100%' BORDER='0' cellpadding=5 cellspacing=2 >\n";
echo "<TR align='left' class='bg_color_5'><TD width='25%' class='color_2'>Nombre</TD><TD width='25%' class='color_2'>Tipo</TD><TD width='25%' class='color_2'>Tama&ntilde;o</TD><TD width='25%' class='color_2'>Acci&oacute;n</TD></TR>";
$una=true;
}
echo "<TR class='bg_color_2'>";
echo "<TD class='color_5'>" . htmlspecialchars($file) . "</TD>\n";
echo "<TD class='color_5'>" . filetype($filename) . "</TD>\n";
echo "<TD class='color_5'>" . (int)(filesize($filename)/1000) . "kb. </TD>\n";
$tamanyo+=(int)(filesize($filename)/1000);
echo "<TD class='color_5'>";
if(filetype($filename)=="file") {
echo "<A class='seleccion' HREF=\"$basedir/$file\" target='_blank'>Bajar</A>&nbsp;";
echo "<A class='seleccion' HREF=\"".$_SERVER['PHP_SELF']."?action=edit&file=$fileurl\">Editar</A>&nbsp; ";
echo "<A class='seleccion' HREF=\"".$_SERVER['PHP_SELF']."?action=dele&file=$fileurl\">Borrar</A> &nbsp;";
echo "</TD>";
echo "</TR>\n";
}
}
}
closedir($handle);
if ($una){
echo "<tr class='bg_color_5'><td colspan=4 align='right' class='color_2'>Espacio libre:".(5000-$tamanyo)."kb. Espacio utilizado: $tamanyo kb. </td></tr>";
 echo "</TABLE>\n";
  #$gestion->documento->cerrar_tabla_info(600,100,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
  #$gestion->documento->cerrar_tabla_modulo(600,100);

 }

#$gestion->documento->abrir_tabla_modulo(400,100,"left","middle", "left");

#$gestion->documento->abrir_tabla_info(400,100,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)


echo "<h3 class='color_5'>Para incluir m&aacute;s archivos en su disco virtual utilice este formulario:</h3>\n";
echo "<FORM ENCTYPE='multipart/form-data' METHOD='POST' ACTION='".$_SERVER['PHP_SELF']."' NAME='UPLO'>\n";
echo "<INPUT NAME='userfile' TYPE='file'>\n";
echo "<input type='hidden' value='".(5000-$tamanyo)."' name='libre'>\n";
echo "<INPUT TYPE='SUBMIT' NAME='upload' VALUE='Subir'><BR>\n";
echo "</FORM>\n";
 #$gestion->documento->cerrar_tabla_info(400,100,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
  #$gestion->documento->cerrar_tabla_modulo(400,100);

#$gestion->cerrar_documento();

?>
          
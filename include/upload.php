<?php
require_once("global_interface.php");
class upload extends global_interface{

    var $seccion='';
    var $archivo='';
    var $timestamp='';
    var $espacio_maximo_directorio=10000; #kb
    var $path_temporal="../../tmp_imgs/";
    var $path_definitivo="../../imgs/";

    
function upload(){
session_start();
$this->graba_variables_obj_ppal(func_get_args());
if(substr($this->archivo,0, 10)<>'win_upload'){
$_SESSION['upload']['seccion_referer']=$this->seccion;
$_SESSION['upload']['archivo_referer']=$this->archivo;
}
$this->seccion_referer=$_SESSION['upload']['seccion_referer'];
$this->archivo_referer=$_SESSION['upload']['archivo_referer'];
$this->timestamp=time();
if($this->archivo=='win_upload.php') $this->win_upload();
if($this->archivo=='win_upload_form.php') $this->form_upload();
if($this->archivo=='win_upload_del.php') $this->del_archivo();
}//function

function archivo_upload($nombre_archivo, $tamanyo_max, $max_height, $max_width, $array_idiomas=null){
if(!$this->j_script_echo) $info_up.=$this->j_script_upload();
$ses_nombre_archivo=$_SESSION[$this->seccion][$this->archivo][$nombre_archivo];
if(!$ses_nombre_archivo){
$info_up.= "\n\n<a href=\"javascript:uploading_form('$nombre_archivo','$max_height','$max_width','$tamanyo_max');\">colocar archivo</a> <br>\n\n";
}else{
$this->select_tipo_archivo($ses_nombre_archivo);
if($this->archivo<>'del.php'){
if($this->seccion<>'c_05'){
$info_up.= "<a href=\"javascript:uploading_form('$nombre_archivo','$max_height','$max_width','$tamanyo_max');\">modificar archivo</a> ";
$info_up.= "<a href=\"javascript:eliminar('$ses_nombre_archivo', '$nombre_archivo');\">eliminar archivo</a> <br>";
}else{
if(@in_array(substr($nombre_archivo, -3), $array_idiomas))
$info_up.= "<a href=\"javascript:uploading_form('$nombre_archivo','$max_height','$max_width','$tamanyo_max');\">modificar archivo</a> ";
$info_up.= "<a href=\"../../imgs/".$_SESSION[$this->seccion][$this->archivo][$nombre_archivo]."\">descargar archivo</a><br> ";
}//c_05
}//del.php
 $info_up.= "\n<a name='$nombre_archivo'></a><img src='".$this->v_imagen."' border='1' ><input type='hidden' name='$nombre_archivo' value='".str_replace('../../imgs/','', $ses_nombre_archivo)."'><br>\n";
 }//if
 return $info_up;
}//function

var $archivo_upload=''; #nombre_archivo_definitivo
var $archivo_temporal='';
var $tipo_archivo='';
var $extension_temporal='';

function temporal_copy(){
$this->archivo_upload=$_POST['nombre_archivo'];
$tipo_archivo=strtolower(str_replace(" ", "", $_POST['valor_archivo']));
$tipo_archivo=array_reverse(explode(".", $tipo_archivo));
if($tipo_archivo[1]) $this->tipo_archivo=$tipo_archivo[0]; else $this->tipo_archivo='';
if($this->tipo_archivo) $this->extension_temporal=".".$this->tipo_archivo; else $this->extension_temporal='';
$this->archivo_temporal=$this->timestamp;
$this->tipo_archivo_num();
#die($this->num_extension_temporal);
$this->archivo_def_up=$this->seccion_referer.'_'.$this->num_extension_temporal.'_'.$this->archivo_temporal.'nn'.$this->extension_temporal;

$handle=opendir($this->path_definitivo);
while($file = readdir($handle)){
$tamanyo_directorio_definitivo+=(int)(filesize($this->path_definitivo.$file)/1000);
if($file==$archivo_def_up) $existe_archivo=true;
}
if($existe_archivo) $this->archivo_def_up='bis_'.$archivo_def_up;
if(copy($_FILES[$this->archivo_upload]['tmp_name'], $this->path_temporal.$this->archivo_def_up)){
$tamanyo_directorio_definitivo+=(int)$_FILES[$this->archivo_upload]['size']/1000;
if($tamanyo_directorio_definitivo<$this->espacio_maximo_directorio)
$this->archivo_tipo_imagen();
else{
unlink($this->path_temporal.$this->archivo_def_up.$this->extension_temporal);
    $this->documento->salida("Su capacidad actual ($tamanyo kb) ha sobrepasado el limite de capacidad de su disco (".$this->espacio_maximo_directorio." kb). pongase en contacto con <a href='mailto:info@mediaymedia.com'>info@mediaymedia.com</a> para solucionar el problema<br><br><input type='button'  onclick='javascript:window.self.close();' value='cerrar_ventana' name='cerrar_ventana'></body>");
die();
}
    $this->documento->salida('');
    if($alerta) echo $alerta."<input type='button' onclick='javascript:window.self.close();' value='cerrar ventana' name='cerrar'>";
    else{
    echo "<img src='".$this->previsualizar_archivo."'><br><br>";
   if($img_width) echo "$img_width <br>
    $img_height<br>
    $img_type<br>
    $img_medidas<br>
    $nombre_imagen<br>";
    echo "<form action='' method='post' name='f_aprobacion'  id='f_aprobacion' >
    <input type='hidden' name='archivo_clave' value='".$this->archivo_upload."'>
    <input type='hidden' name='archivo_valor' value='".$this->previsualizar_archivo_valor."'>
    <input type='hidden' name='archivo_tipo' value='".$this->previsualizar_archivo_tipo."'>";
if(!$_SESSION[$this->seccion_referer][$this->archivo_referer][$this->archivo_upload]){
   echo "<input type='submit' value='ok' name='enviar'>";
   echo "<input type='submit' value='no ok' name='borrar'>";
   }else{
   echo "<br><input type='submit' value='modificar' name='enviar'>
<input type='submit'  value='no_modificar' name='borrar'>";
   }//if
    echo "</form>
    ";
    }



 return true;
}else{
 return false;
 }//if

}//function temporal_copy

var $previsualizar_archivo='';

function archivo_tipo_imagen(){
if($this->num_extension_temporal=="00" || $this->num_extension_temporal=="01" || $this->num_extension_temporal=="02" || $this->num_extension_temporal=="03"){
$tamanio=@getimagesize($this->path_temporal.$this->archivo_def_up);
$img_width=$tamanio[0]; 
$img_height=$tamanio[1]; 
$img_type=$tamanio[2]; 
$img_medidas=$tamanio[3]; 

if($_POST['max_height']<$img_height or $_POST['max_width']< $img_width) {
$min_ancho=$_POST['max_width'];
$min_alto=$_POST['max_height'];
if($this->num_extension_temporal=="00" or $this->num_extension_temporal=="01")
 $abc = imagecreatefromjpeg($this->path_temporal.$this->archivo_def_up); 
 elseif($this->num_extension_temporal=="02")
  $abc = imagecreatefromgif($this->path_temporal.$this->archivo_def_up); 
  elseif($this->num_extension_temporal=="03")
    $abc = imagecreatefrompng($this->path_temporal.$this->archivo_def_up);  

 $ancho=ImageSX($abc);
$alto=ImageSY($abc);

 $var1=$this->CalcScrunchSize($alto, $ancho,  $min_alto, $min_ancho);
$ancha_def=(int)$var1[0];
$alta_def=(int)$var1[1];
 $def = imagecreatetruecolor($ancha_def, $alta_def); 
 imagecopyresampled($def, $abc, 0, 0, 0, 0, $ancha_def, $alta_def, $ancho, $alto); 
 if($this->num_extension_temporal=="02" OR !$this->num_extension_temporal=="03"){
$this->ext_00=$this->extension_temporal;
$this->archivo_def_up= str_replace($this->extension_temporal, ".jpg", $this->archivo_def_up);
 }
 imagejpeg($def, str_replace('nn', 'zz',$this->path_temporal.$this->archivo_def_up) , 90); 
 if($this->num_extension_temporal=="02" OR !$this->num_extension_temporal=="03") 
 $this->archivo_def_up= str_replace(".jpg", $this->ext_00,  $this->archivo_def_up);

 ImageDestroy($abc); 
 ImageDestroy($def); 
 $zoom=true;
}
 $min_ancho='100';
$min_alto='100';

if($min_alto <$img_height or $min_ancho< $img_width){
if(!$zoom){ 
if($this->num_extension_temporal=="00" or $this->num_extension_temporal=="01")
 $abc = imagecreatefromjpeg($this->path_temporal.$this->archivo_def_up); 
 elseif($this->num_extension_temporal=="02")
  $abc = imagecreatefromgif($this->path_temporal.$this->archivo_def_up); 
  elseif($this->num_extension_temporal=="03")
    $abc = imagecreatefrompng($this->path_temporal.$this->archivo_def_up);  

 $def = imagecreatetruecolor($img_width, $img_height); 
 imagecopy($def, $abc, 0, 0, 0, 0, $img_width, $img_height); 
$ext=strstr($this->archivo_def_up, ".");
$arch_eliminar=$this->path_temporal.$this->archivo_def_up;
 $this->archivo_def_prov= str_replace($ext, ".jpg",  $this->archivo_def_up);

 imagejpeg($def, str_replace('nn', 'zz',$this->path_temporal.$this->archivo_def_prov) , 90); 
 ImageDestroy($abc); 
 ImageDestroy($def); 
#die($arch_eliminar);
}

if($this->num_extension_temporal=="00" or $this->num_extension_temporal=="01")
 $abc_min = imagecreatefromjpeg($this->path_temporal.$this->archivo_def_up); 
 elseif($this->num_extension_temporal=="02")
  $abc_min = imagecreatefromgif($this->path_temporal.$this->archivo_def_up); 
  elseif($this->num_extension_temporal=="03")
    $abc_min = imagecreatefrompng($this->path_temporal.$this->archivo_def_up);  
 $ancho=ImageSX($abc_min);
$alto=ImageSY($abc_min);

 $var1=$this->CalcScrunchSize($alto, $ancho,  $min_alto, $min_ancho);
$ancha_def=(int)$var1[0];
$alta_def=(int)$var1[1];
$def_min = imagecreatetruecolor($ancha_def, $alta_def); 
imagecopyresampled($def_min, $abc_min, 0, 0, 0, 0, $ancha_def, $alta_def, $ancho, $alto); 
 if($this->num_extension_temporal=="02" or $this->num_extension_temporal=="03"){
$this->archivo_def_up= str_replace($this->extension_temporal, ".jpg", $this->archivo_def_up);
}
imagejpeg($def_min, str_replace('nn', 'mm', $this->path_temporal.$this->archivo_def_up) , 90); 

ImageDestroy($abc_min); 
ImageDestroy($def_min); 
}else{
copy($this->path_temporal.$this->archivo_def_up, str_replace('nn', 'mm', $this->path_temporal.$this->archivo_def_up));
copy($this->path_temporal.$this->archivo_def_up, str_replace('nn', 'zz', $this->path_temporal.$this->archivo_def_up));
}// if tamanyos mayor de lo permitido
#if($arch_eliminar) unlink($arch_eliminar);
$this->previsualizar_archivo=str_replace('nn', 'mm', $this->path_temporal.$this->archivo_def_up);
$this->previsualizar_archivo_valor=$this->archivo_def_up;
$this->previsualizar_archivo_tipo=$this->extension_temporal;
}else{
#echo "<hr>".$_FILES[$this->archivo_upload]['type']."  -- aasd-- ".substr($_FILES[$this->archivo_upload]['type'],-3);
   switch ($this->num_extension_temporal){
       case "04":
   $v_imagen='../c_99/imgs/rtf.jpg';
   break;
       case "05":
   $v_imagen='../c_99/imgs/mp3.jpg';
   break;
       case "06":
   $v_imagen='../c_99/imgs/mov.jpg';
   break;
       case "07":
   $v_imagen='../c_99/imgs/htm.jpg';
   break;
       case "08":
   $v_imagen='../c_99/imgs/htm.jpg';
   break;
    case "09":
   $v_imagen='../c_99/imgs/pdf.jpg';
   break;
    case "10":
   $v_imagen='../c_99/imgs/doc.jpg';
   break;
    case "11":
   $v_imagen='../c_99/imgs/swf.jpg';
   break;
   default:
   $v_imagen='../c_99/imgs/txt.jpg';
}
$this->previsualizar_archivo=$v_imagen;
$this->previsualizar_archivo_valor=$this->archivo_def_up;
$this->previsualizar_archivo_tipo=$this->extension_temporal;
}//if tipo de archivo de imagen
}



function select_tipo_archivo($ses_nombre_archivo){
#echo substr($ses_nombre_archivo,-3)."<br>";
   switch (substr($ses_nombre_archivo,-3)){
   case "jpg":
   $v_imagen='../../imgs/'.$ses_nombre_archivo;
   break;
   case "peg":
   $v_imagen='../../imgs/'.$ses_nombre_archivo;
   break;
   case "gif":
   $v_imagen='../../imgs/'.$ses_nombre_archivo;
   break;
    case "png":
   $v_imagen='../../imgs/'.$ses_nombre_archivo;
   break;
       case "rtf":
   $v_imagen='../c_99/imgs/rtf.jpg';
   break;
       case "mp3":
   $v_imagen='../c_99/imgs/mp3.jpg';
   break;
       case "mov":
   $v_imagen='../c_99/imgs/mov.jpg';
   break;
       case "htm":
   $v_imagen='../c_99/imgs/htm.jpg';
   break;
       case "tml":
   $v_imagen='../c_99/imgs/htm.jpg';
   break;
       case "pdf":
   $v_imagen='../c_99/imgs/pdf.jpg';
   break;
    case "doc":
   $v_imagen='../c_99/imgs/doc.jpg';
   break;
    case "swf":
   $v_imagen='../c_99/imgs/swf.jpg';
   break;
   default:
   $v_imagen='../c_99/imgs/txt.jpg';
   }
   $this->v_imagen=$v_imagen;
}//funtion_select_tipo_archivo

function j_script_upload(){
$info_script.= "\n\n<SCRIPT language=JavaScript>
<!--
function uploading_form(nombre_archivo, max_width, max_height, tamanyo_max){
window.open('../c_upload/win_upload_form.php?nombre_archivo='+nombre_archivo+'&max_width='+max_width+'&max_height='+max_height+'&tamanyo_max='+tamanyo_max,'pop','toolbar=no, location=no, status=no, width=400, height=400, left=0, top=0, scrollbars=yes, resizable=yes');
}
function eliminar(img_valor, img_clave){
window.open('../c_upload/win_upload_del.php?img='+img_valor+'&clave='+img_clave+'&path=../".$this->seccion."/".$this->archivo."','pop','toolbar=yes, location=no, status=yes, width=400, height=400, left=0, top=0, scrollbars=yes, resizable=yes');
}
//-->
</SCRIPT>\n\n";
$this->j_script_echo=true;
return $info_script;
}//funtion j_script_upload

function form_upload(){
$nombre_archivo=$_GET['nombre_archivo'];
$max_height=$_GET['max_height'];
$max_width=$_GET['max_width'];
$tamanyo_max=$_GET['tamanyo_max'];
$this->documento->salida("
<SCRIPT language=JavaScript>
<!--
function uploading(){
if(window.document.forms['upload_form']['$nombre_archivo'].value){
    window.document.forms['upload_form']['valor_archivo'].value=window.document.forms['upload_form']['$nombre_archivo'].value;
   window.document.forms['upload_form'].submit();
    }else{
    alert('tiene que seleccionar un archivo');
}// if
}
-->
</script>");
echo "<form enctype='multipart/form-data' action='win_upload.php' target='pop'  name='upload_form' method='post'>\n";
if($max_height) echo "<input type='hidden' name='max_height' value='$max_height'>\n";
if($max_width) echo "<input type='hidden' name='max_width' value='$max_width'>\n";
echo "<input name='$nombre_archivo' type='file' size=30>\n";
if($tamanyo_max) echo "<input type='hidden' name='MAX_FILE_SIZE' value=$tamanyo_max>\n";
echo "<input name='nombre_archivo' value='$nombre_archivo' type='hidden' >\n";
echo "<input name='valor_archivo' value='' type='hidden' >\n";
echo "<br><input type='button' onclick='javascript:uploading();' value='enviar'><input type='button' onclick='javascript:window.self.close();' value='cerrar ventana'></form><br>\n";

}// f_ upload_form()
function aplicar_sesiones_t_archivo($t_archivo, $valor){
#echo "$t_archivo $valor";
$_SESSION[$this->seccion][$this->archivo][$t_archivo]= $valor;
}
function incluir_archivo_directorio_def(){
if($_POST['enviar']=='ok'){
    if(@copy($this->path_temporal.str_replace('nn', 'mm', $_POST['archivo_valor']), $this->path_definitivo.str_replace('nn', 'mm', $_POST['archivo_valor'])))
        copy($this->path_temporal.str_replace('nn', 'zz', $_POST['archivo_valor']), $this->path_definitivo.str_replace('nn', 'zz', $_POST['archivo_valor']));
    else
    copy($this->path_temporal.$_POST['archivo_valor'], $this->path_definitivo.$_POST['archivo_valor']);
    @unlink($this->path_temporal.$_POST['archivo_valor']);
    @unlink($this->path_temporal.str_replace(".jpg", ".gif", $_POST['archivo_valor']));
    @unlink($this->path_temporal.str_replace(".jpg", ".png", $_POST['archivo_valor']));
    @unlink($this->path_temporal.str_replace('nn', 'zz', $_POST['archivo_valor']));
    @unlink($this->path_temporal.str_replace('nn', 'mm', $_POST['archivo_valor']));
    $tipo_archivo=$_POST['archivo_tipo'];
    if($tipo_archivo=='.jpeg' OR $tipo_archivo=='.jpg' OR $tipo_archivo=='.gif' OR $tipo_archivo=='.png')
        $_SESSION[$this->seccion_referer][$this->archivo_referer][$_POST['archivo_clave']]=str_replace('nn', 'mm', $_POST['archivo_valor']);
    else
    $_SESSION[$this->seccion_referer][$this->archivo_referer][$_POST['archivo_clave']]=$_POST['archivo_valor'];

}elseif($_POST['enviar']=='modificar'){
$borrar_anterior=$_SESSION[$this->seccion_referer][$this->archivo_referer][$_POST['archivo_clave']];
    @unlink("../../imgs/".$borrar_anterior);
    @unlink($this->path_temporal.str_replace(".jpg", ".gif", $_POST['archivo_valor']));
    @unlink($this->path_temporal.str_replace(".jpg", ".png", $_POST['archivo_valor']));
    @unlink("../../imgs/".str_replace('mm', 'zz', $borrar_anterior));
    @unlink("../../imgs/".str_replace('nn', 'mm', $borrar_anterior));
    #die();
    if(@copy($this->path_temporal.str_replace('nn', 'mm', $_POST['archivo_valor']), $this->path_definitivo.str_replace('nn', 'mm', $_POST['archivo_valor'])))
        copy($this->path_temporal.str_replace('nn', 'zz', $_POST['archivo_valor']), $this->path_definitivo.str_replace('nn', 'zz', $_POST['archivo_valor']));
    else
    copy($this->path_temporal.$_POST['archivo_valor'], $this->path_definitivo.$_POST['archivo_valor']);
    @unlink($this->path_temporal.$_POST['archivo_valor']);
    @unlink($this->path_temporal.str_replace(".jpg", ".gif", $_POST['archivo_valor']));
    @unlink($this->path_temporal.str_replace(".jpg", ".png", $_POST['archivo_valor']));
    @unlink($this->path_temporal.str_replace('nn', 'zz', $_POST['archivo_valor']));
    @unlink($this->path_temporal.str_replace('nn', 'mm', $_POST['archivo_valor']));
    $tipo_archivo=$_POST['archivo_tipo'];
    if($tipo_archivo=='.jpeg' OR $tipo_archivo=='.jpg' OR $tipo_archivo=='.gif' OR $tipo_archivo=='.png')
        $_SESSION[$this->seccion_referer][$this->archivo_referer][$_POST['archivo_clave']]=str_replace('nn', 'mm', $_POST['archivo_valor']);
    else
    $_SESSION[$this->seccion_referer][$this->archivo_referer][$_POST['archivo_clave']]=$_POST['archivo_valor'];


}elseif($_POST['borrar']){
    @unlink($this->path_temporal.$_POST['archivo_valor']);
    @unlink($this->path_temporal.str_replace('mm', 'zz', $_POST['archivo_valor']));
    @unlink($this->path_temporal.str_replace('nn', 'mm', $_POST['archivo_valor']));
}
$path=$_POST['path']."#".$_POST['archivo_clave'];
echo "<SCRIPT language=JavaScript>
<!--

if('".$this->seccion_referer."'!='c_05'){
window.opener.document.forms[0].action='../".$this->seccion_referer.'/'.$this->archivo_referer."';
}
if('".$this->archivo_referer."'=='mod.php'){
window.opener.document.forms[0]['actualizar'].value='imagenes_actualizar';
}
window.opener.document.forms[0].submit();
window.opener.focus();
window.self.close();
//-->
</SCRIPT>";
}


function CalcScrunchSize($CurH,$CurW, $MaxH,$MaxW) //calculates how to stuff a big img into a lil space
{
$HRatio = $CurH/$MaxH;
$WRatio = $CurW/$MaxW;
if($HRatio > $WRatio)
{
$result[0] =$CurW*($MaxH/$CurH);
$result[1] = $MaxH;
}
else
{
$result[0] = $MaxW;
$result[1] =$CurH*($MaxW/$CurW);
}
return($result);
}//function CalcScrunchSize

function tipo_archivo_num(){
$tipo_temp=$this->extension_temporal;
   switch (strtolower($tipo_temp)){
   case ".jpg":
   $num_extension_temporal='00';
   break;
   case ".jpeg":
   $num_extension_temporal='01';
   break;
   case ".gif":
   $num_extension_temporal='02';
   break;
    case ".png":
   $num_extension_temporal='03';
   break;
       case ".rtf":
   $num_extension_temporal='04';
   break;
       case ".mp3":
   $num_extension_temporal='05';
   break;
       case ".mov":
   $num_extension_temporal='06';
   break;
       case ".htm":
   $num_extension_temporal='07';
   break;
       case ".html":
   $num_extension_temporal='08';
   break;
       case ".pdf":
   $num_extension_temporal='09';
   break;
    case ".doc":
   $num_extension_temporal='10';
   break;
    case ".swf":
   $num_extension_temporal='11';
   break;
   default:
   $num_extension_temporal='12';
   }
   $this->num_extension_temporal=$num_extension_temporal;
}


function del_archivo(){
if($_POST['borrar']){
# if el archivo contiene mm entonces borrar mm y zz
# else borrar nn
    @unlink($this->path_definitivo.$_POST['img_valor']);
    @unlink($this-> path_definitivo.str_replace('mm', 'zz', $_POST['img_valor']));
    @unlink($this-> path_definitivo.str_replace('nn', 'mm', $_POST['img_valor']));
    @unlink($this-> path_definitivo.str_replace('mm', 'nn', $_POST['img_valor']));
    $_SESSION[$this->seccion_referer][$this->archivo_referer][$_POST['img_clave']]=null;

$path='../'.$this->seccion_referer.'/'.$this->archivo_referer."#".$_POST['img_clave'];
echo "<SCRIPT language=JavaScript>
<!--
if('".$this->seccion_referer."'!='c_05'){
window.opener.document.forms[0].action='$path';
}
if('".$this->archivo_referer."'=='mod.php'){
window.opener.document.forms[0]['actualizar'].value='imagenes_actualizar';
}
window.opener.document.forms[0].submit();
window.opener.focus();
window.self.close();
//-->
</SCRIPT>";
die();
}
if($_GET){
$this->select_tipo_archivo($_GET['img']);
$prev=$this->v_imagen;
$this->documento->salida('');
echo "<img src='$prev'>
    <form action='' method='post' name='f_aprobacion'  id='f_aprobacion' >
    <input type='hidden' name='path' value='".$_GET['path']."'>
    <input type='hidden' name='img_valor' value='".$_GET['img']."'>
    <input type='hidden' name='img_clave' value='".$_GET['clave']."'>";
   echo "<br><br><input type='submit' value='borrar' name='borrar'>";
   echo "<input type='button' onclick='javascript:window.self.close();' value='no borrar' name='no_borrar'>";
    echo "</form>
    ";
    }elseif(!$_GET){
$this->documento->salida("se produjo un error al intentar borrar el archivo<br><input type='button' onclick='javascript:window.self.close();' value='intentar nuevamente' >");
    }
}//funtion del_archivo
function win_upload(){
if($_POST['enviar'] or $_POST['borrar']){
$this->incluir_archivo_directorio_def();
}else{
if($this->temporal_copy()){
}else{
$this->documento->salida("intentar otra vez, no se ha producido la copia<br>es posible que el archivo supere las 2000 kb permitidas<br><input type='button' onclick='javascript:window.self.close();' value='cerrar ventana' >");
}
}
}// function win_upload


}//end class
?>

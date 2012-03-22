<?php
require_once("global_interface.php");
class upload extends global_interface{

	var $path_temporal="../../tmp_imgs/";
	var $path_definitivo="../../imgs/";
    var $timestamp='';
    var $espacio_maximo_directorio=10000; #kb

function upload(){
$this->graba_variables_obj_ppal(func_get_args());
$this->seccion=
}//f_upload


function aplicar_sesiones_t_archivo($t_archivo, $valor){
#echo "$t_archivo $valor";
$_SESSION[$this->seccion][$this->archivo][$t_archivo]=$valor;
if($this->depurar_upload) $this->depurar_mensaje("<b>Aplicar sesiones:</b><bR>".$this->seccion." ".$this->archivo." ".$t_archivo."=".$_SESSION[$this->seccion][$this->archivo][$t_archivo]);
}//function aplicar_Sesiones


function archivo_upload($nombre_archivo, $tamanyo_max, $max_height, $max_width, $array_idiomas=null){
if(!$this->j_script_echo) $info_up.=$this->j_script_upload();
$ses_nombre_archivo=$_SESSION[$this->seccion][$this->archivo][$nombre_archivo];
if($this->depurar_upload) $this->depurar_mensaje("<b>sesion en llamada a imagen:</b><bR>".$nombre_archivo."=".$ses_nombre_archivo);
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
}//function archivo_upload


}//class
?>
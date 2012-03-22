<?php
require_once("global_interface.php");
class objeto extends global_interface{

var $pack_0='';
var $pack_1=array('conecto_datos', 'database_stats',  'documento' );
var $pack_2=array('registro', 'conecto_datos', 'conecto_central', 'documento', 'upload','gestion_indice' );
var $pack_3=array('documento', 'error');
var $pack_4=array('registro', 'conecto_datos', 'conecto_central', 'documento', 'upload','gestion_indice' );
var $pack_5=array('registro', 'conecto_datos', 'conecto_central',  'documento_gestion');

var $idioma='';
var $seccion='';
var $archivo='';
var $fichero='';
var $user='';
var $password='';


var $bgcolor_gestion="#666666";
var $f_color_gestion="#FF6600";
var $idioma_traduccion='';
var $zona_gestion_registro='';



var $include_array=array(
'error'=>null,
'registro'=>array('seccion'),
'conecto_datos'=>array('idioma','otro_idioma', 'seccion','subseccion', 'archivo', 'html', 'traducir', 'idioma_traduccion' , 'zona_gestion_registro'),
'conecto_central'=>array('idioma', 'otro_idioma', 'seccion', 'archivo','html', 'traducir', 'idioma_traduccion', 'Link_ID'),
'conecto_stats'=>array('idioma', 'seccion', 'archivo', 'html', 'traducir', 'idioma_traduccion'),
'documento'=>array('idioma', 'otro_idioma','seccion','subseccion','url', 'archivo', 'html', 'conecto_datos','conecto_stats', 'bgcolor_gestion', 'f_color_gestion'),
'upload'=>array('idioma','documento_gestion', 'seccion', 'archivo', 'user', 'password', 'zona_gestion_registro', 'conecto_central'),
'documento_gestion'=>array('idioma', 'otro_idioma','seccion','subseccion','url', 'archivo', 'html', 'conecto_datos','conecto_stats', 'bgcolor_gestion', 'f_color_gestion'),
'gestion_index'=>array('valor_zona_gestion', 'archivo', 'seccion', 'user', 'password', 'html', 'conecto_datos', 'conecto_central' ,'documento_gestion', 'upload', 'idioma_traduccion', 'zona_gestion_registro'),
'gestion_mod'=>array('valor_zona_gestion', 'archivo', 'seccion', 'user', 'password', 'html', 'conecto_datos', 'conecto_central' ,'documento_gestion', 'upload', 'idioma_traduccion',  'zona_gestion_registro'),
'gestion_del'=>array('valor_zona_gestion', 'archivo', 'seccion', 'user', 'password', 'html', 'conecto_datos', 'conecto_central' ,'documento_gestion', 'upload', 'idioma_traduccion',  'zona_gestion_registro'),
'gestion_mas'=>array('valor_zona_gestion', 'archivo', 'seccion', 'user', 'password', 'html', 'conecto_datos', 'conecto_central' ,'documento_gestion', 'upload', 'idioma_traduccion',  'zona_gestion_registro'),
'gestion_mail'=>array('valor_zona_gestion', 'archivo', 'seccion', 'user', 'password', 'html', 'conecto_datos', 'conecto_central' ,'documento_gestion', 'upload', 'idioma_traduccion',  'zona_gestion_registro')
);



/*
$include_array
-------------------
1 valor= llamada desde la funcion
1 valor array=nombre_archivo
2 valor_array=¬øse debe crear el objeto?
3 valor_array=nombre_objeto
4 valor_array=nombre_clase
5 valores del objeto mayor que hereda el derivado (muy indicado para compartir informacion entre objetos, y tambien util en casos de pequenyas traducciones)
*/
function objeto($array_traducciones_directas=''){
/*
$this->query("select * from seccion_00");
echo $this->record_count."<hr>";
die();
*/
if(!$this->html)$this->html=get_html_translation_table(HTML_ENTITIES);
$this->mirar_info_archivo();
if(is_array($array_traducciones_directas)) $this->traducir=$array_traducciones_directas;

    $this->aplicar_pack();
    foreach($this->pack_0 as $elemento){

        if($this->include_array[$elemento]<>''){
		  require_once("$elemento.php");
          $this->crear_objetos($elemento, $this->include_array[$elemento]);

        }//if
         #   echo $elemento."<hr>";

    }//foreach

}//f_constructora

/*
crear_objetos
------------------
se ocupa de inicializar los objetos y las variables comunes de estos, en los dos sentidos, tanto desde el objeto general al derivado, como del objeto derivado al general

*/
function crear_objetos($nombre_objeto, $valores_comunes){
if($this->depurar_objeto) $this->depurar_mensaje("objeto: ".$nombre_objeto);
    $arra_comun=array();
        if($valores_comunes) 
			foreach($valores_comunes as $comun)	
			$this->addArray($arra_comun, $comun, $this->{$comun});
		$this->{$nombre_objeto}=new $nombre_objeto($arra_comun) ;
        if($nombre_objeto=='registro'){
			$this->user=$this->registro->user;
			$this->password=$this->registro->password;
			$query_reg="select * from registro_00 where user='{$this->user}' and password='{$this->password}'";
			$this->query($query_reg);
				if($this->next_record()){
					$this->zona_gestion_registro=$this->Record[zona_gestion_registro];
				}//if next_record
            }elseif($nombre_objeto=='gestion'){
			$this->seccion=$this->gestion->seccion;
			echo $this->seccion;
#			$this->password=$this->registro->password;

#            $this->idioma_traduccion=$this->gestion_indice->idioma_traduccion;
#            $this->documento->conecto_datos->idioma_traduccion=$this->gestion_indice->idioma_traduccion;
        }//if registro entonces se pasa a la inversa los valores
}//function


function aplicar_pack(){
# AQUI TENGO QUE INCLUIR SECCION Y ARCHIVO
$arra_pack_1=array('index.php', 'presenta.php', 'info.php', 'noticias.php', 'bienvenida.php', 'coordinadora_cab.php', 'voluntariado.php', 'agenda.php', 'socios.php', 'contacto.php', 'entidad_cab.php', 'entidad.php', 'agenda_cab.php', 'agenda.php', 'diccionario_cab.php', 'diccionario.php' , 'guias_cab.php', 'guias.php', 'buscador_cab.php', 'buscador.php');
$arra_pack_2=array('p_gestion_0.php', 'p_gestion_1.php', 'mod.php');
$arra_pack_3=array('error.php');
    if($this->idioma=="gestion"){
	
		if($this->seccion=='c_99'){
				$this->pack_0=$this->pack_5;
		}else{
		# es gestion y aqui mira el archivo y se lo anexa a pack_0
			$this->pack_0=array('registro', 'conecto_datos', 'conecto_central', 'documento_gestion', 'upload');
			array_push($this->pack_0, 'gestion_'.str_replace(".php", "", $this->archivo));
		}//if seccion=c_99
		
    }else{
    foreach($arra_pack_1 as $item) if( $item==$this->archivo ) $this->pack_0=$this->pack_1;
        if(!$this->pack_0) 
            foreach($arra_pack_2 as $item) if( $item==$this->archivo ) $this->pack_0=$this->pack_2;
        if(!$this->pack_0) 
            foreach($arra_pack_3 as $item) if( $item==$this->archivo ) $this->pack_0=$this->pack_3;
    }//idioma==gestion
}// f_ aplicar_pack


function grabar_info($arra_datos ){
foreach($arra_datos as $clave=>$valor) $_SESSION[$clave]=$valor;
}//grabar_info





}//class
?>
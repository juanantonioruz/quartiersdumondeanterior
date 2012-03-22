<?php
class global_interface{

var $depurar_objeto=0;
var $depurar_database=0;
var $depurar_gestion=0;
var $depurar_gestion_index_consultas=0;
var $depurar_gestion_index=0;
var $depurar_gestion_mod=0;
var $depurar_gestion_del=0;
var $depurar_gestion_mas=0;
var $depurar_upload=0;
var $depurar_documento=0;
var $depurar_registro=0;
var $depurar_interface=0;
var $ejecutar_bases_datos_locales=0;
var $posibilidad_duplicar_registros=0;
function global_interface(){
}

function graba_variables_obj_ppal($array_variables){
    foreach($array_variables as $valor_comun){
        foreach($valor_comun as $clave=>$valor){ $this->$clave=$valor;
			#echo get_class($this)." - ". $clave."<br>";
		}
    }//foreach
}// f_graba_variables_obj_ppal


function mirar_info_archivo(){
    $url_array=array_reverse(explode('/', $_SERVER['PHP_SELF']));
    $this->idioma=$url_array[2];
    if($this->idioma=="esp") $this->otro_idioma="fra"; else $this->otro_idioma="esp";
    $this->seccion=$url_array[1];
    $archivo=explode('?', $url_array[0]);
    $this->archivo=$archivo[0];
if(count($url_array)==5){
    $this->idioma=$url_array[3];
        $this->seccion=$url_array[2];
    $this->subseccion=$url_array[1];
$this->url="../";
}
if(!$this->archivo) $this->archivo="index.php";
}//function mirar_info_archivo



# ------ database

function conectar(){
if(!$this->Host){
if(!$this->ejecutar_bases_datos_locales){
		$this->Host="localhost";
		$this->User="extremos";
		$this->Password="nickel";
		$this->Database="qz285";
}else{
		$this->Host="localhost";
		$this->User="root2";
		$this->Password="nickel";
		$this->Database="qz285";

}//if

}
        if (0 == $this->Link_ID ) {
		$this->Link_ID=@mysql_connect($this->Host, $this->User, $this->Password);
		if($this->depurar_interface or $this->depurar_gestion) $this->depurar_mensaje( "<b>Abrir conexion: </b>".$this->Host." - ".$this->Database." - ".$this->User."<br>
				Link_ID: ".$this->Link_ID);

             if(!$this->Link_ID){
			 if($this->depurar_interface  or $this->depurar_gestion) 
			$this->depurar_mensaje( "<b>Cerrar conexion: </b>".$this->Host." - ".$this->Database."");
            $this->parar("Conexi&oacute;n ha fallado: Host:".$this->Host);
            }//if
                    
          if (!mysql_query(sprintf("use %s", $this->Database),$this->Link_ID)){
              $this->parar("No se puede usar esta base de datos: ".$this->Database);
            }//if

        }//if
    }//end of the function


function cerrar_consulta(){
mysql_free_result($this->Query_ID);
}
function cerrar_conexion(){
if($this->depurar_interface  or $this->depurar_gestion) 			
$this->depurar_mensaje( "<b>cerrar conexion: </b>".$this->Host." - ".$this->Database."");
#mysql_close($this->Link_ID);
}


function query($Query_String){
if(!$this->Link_ID) $this->conectar();
$this->qq=$Query_String;
    $this->ss_timing_start();
    $this->Query_ID=mysql_query($Query_String,$this->Link_ID);
    $this->ss_timing_stop();
    $this->Row=0;
    $this->Errno=mysql_errno();
    $this->Error=mysql_error();

        if(!$this->Query_ID){
            $this->parar("Invalid SQL: ".$Query_String);
        }//end if

    $this->Num_Atrib=@mysql_num_fields($this->Query_ID);
    $this->record_count=@mysql_num_rows($this->Query_ID);
    $this->Nombre_Atrib=null;
            for ($i=0;$i< $this->Num_Atrib;$i++){
  $this->Nombre_Atrib[]=mysql_field_name($this->Query_ID,$i);   
  }

    return $this->Query_ID;
}//function

function next_record(){
    $this->Record=mysql_fetch_array($this->Query_ID);
    $this->Row+=1;
    $this->Errno=mysql_errno();
    $this->Error=mysql_error();
    $stat=is_array($this->Record);
    if (!$stat){
        mysql_free_result($this->Query_ID);
        $this->Query_ID=0;
    }
    return $stat; //true or false
}//end function




function seek($pos){
    if ($this->record_count){
        $status=mysql_data_seek($this->Query_ID, $pos);       
        if ($status) $this->next_record();
    }//if
}//end function



function parar($msg){
        if ($msg!="")
        printf("</td></tr></table><b> Error de base de datos:</b> %s<br>\n",$this->Host." ".$this->Database."<br>". $msg);
        if ($this->Errno!=0){
        if($this->depurar_interface  or $this->depurar_gestion) 
		$this->depurar_mensaje("host/database: ".$this->Host." - ".$this->Database."");

		printf("<b>Error de MySql </b>: %s (%s)<br>\n",$this->Errno, $This->Error);
		}
	die("Sesi&oacute;n detenida");
}// ebd of the funtion


function ss_timing_start ($name = defa) {
$this->ss_timing_start_times[$name] = explode(' ', microtime());
}

function ss_timing_stop ($name = defa) {
$this->ss_timing_stop_times[$name] = explode(' ', microtime());
}

function ss_timing_current ($name = defa) {
if (!isset($this->ss_timing_start_times[$name])) {
    return 0;
}
if (!isset($this->ss_timing_stop_times[$name])) {
    $stop_time = explode(' ', microtime());
}
else {
    $stop_time = $this->ss_timing_stop_times[$name];
}
// do the big numbers first so the small ones aren’ÄöˆÑˆ’àöˆë’àö¬€t lost
$current = $stop_time[1] - $this->ss_timing_start_times[$name][1];
$current += $stop_time[0] - $this->ss_timing_start_times[$name][0];
$this->current+=substr($current,0,6);
return $current;
}
   
#  funciones de reserva
function describir_tabla($tabla){
/*
For version PHP 4.3.4, types returned are:
 STRING, VAR_STRING: string
 TINY, SHORT, LONG, LONGLONG, INT24: int
 FLOAT, DOUBLE, DECIMAL: real
 TIMESTAMP: timestamp
 YEAR: year
 DATE: date
 TIME: time
 DATETIME: datetime
 TINY_BLOB, MEDIUM_BLOB, LONG_BLOB, BLOB: blob
 NULL: null
 Any other: unknown
*/
$Latrib=mysql_list_fields($this->Database,$tabla);
$Num_Atrib= mysql_num_fields($Latrib);
for ($i=0;$i< $Num_Atrib;$i++){
echo "<b>$i -*</b> ";
$nombre=mysql_field_name($Latrib,$i);
$tipo=mysql_field_type($Latrib, $i);
$longitud=mysql_field_len($Latrib,$i);
$car=mysql_field_flags($Latrib,$i);
echo "<br><b>nombre:</b>". $nombre." ";
echo "<br><b>tipo:</b>".$tipo." ";
echo "<br><b>long:</b>".$longitud." ";
if(!$car) {echo "<br><b>caracteracteristicas </b>ninguna <br>\n";
}else  {echo "<br><b> caracteracteristicas:</b>". $car." <br>\n";}


if($tipo=='int'){
echo "<hr>tipo=int<input type='text' name='".$nombre."' size=2><hr>";
}elseif($tipo=='string'){
if($longitud<25)
echo "<hr>tipo=string<input type='text' name='".$nombre."' size=10><hr>";
else
echo "<hr>tipo=string<textarea name='".$nombre."' cols=60 rows=2></textarea><hr>";//se acaba el if interno
}//end if




}//end for

}// end of the funtion    

#/------ database





function addArray(&$array, $key, $val){
    $tempArray=array($key=>$val);
    $array=$array+$tempArray;
}//function

# -------- formato

function a_html($cadena){
#$cadena=str_replace('"', "&quot;", $cadena);
$resultado=strtr($cadena, $this->html);
return $resultado;
}//function

function de_html($cadena){
//evaluar la siguiente linea
$resultado=strtr($cadena, array_flip($this->html));
$resultado=str_replace('"', "&quot;", $resultado);
$resultado=str_replace("\\","", $resultado);
return $resultado;
}//function

function a_html_format($cadena){
#$resultado=strtr($cadena, array_flip($this->html));
$resultado=$this-> url_to_link($cadena);
$resultado=ereg_replace("\n","<br>", $resultado);
#$resultado =ereg_replace("[b]","<b>", $resultado);
#$resultado =ereg_replace("[/b]","</b>", $resultado);
#$resultado =ereg_replace("<i>","[i]", $resultado);
#$resultado =ereg_replace("</i>","[/i]", $resultado);
return $resultado;
}//function

function url_to_link($str)
{
if(strpos($str, $_SERVER['HTTP_HOST'])) $tar="_self"; else $tar='_blank';
  $str = eregi_replace ("[[:alpha:]]+://www", "www", $str);
  $str = ereg_replace ("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/](\.[a-z0-9-]{2,4})+", " <a href=\\0 target=$tar >\\0</a> ", $str);
  $str = ereg_replace ("www.[^<>[:space:]]+[[:alnum:]/](\.[a-z0-9-]{2,4})+", " <a href=http://\\0 target=$tar >\\0</a> ", $str);
  $str = ereg_replace ("[[:alpha:]]+@[^<>[:space:]]+[[:alnum:]/](\.[a-z0-9-]{2,4})+", " <a href=mailto:\\0 target=$tar >\\0</a> ", $str);
return $str;
} 



#/ -------- formato


#/ upload


#/ upload
function depurar_mensaje($mensaje=""){
echo "<hr><span class='bg_color_6'><B>".strtoupper(get_parent_class(get_parent_class($this)))."::".strtoupper(get_parent_class($this))."::".strtoupper(get_class($this))."</B><BR></span><span class='bg_color_1'> $mensaje</span><hr>";
}//depurar mensaje


}//class
?>
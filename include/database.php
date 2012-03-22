<?php
require_once("objeto.php");
require_once("global_interface.php");
class  database extends global_interface{

var $Link_ID = 0; // Result of mysql_connect().
var $Query_ID = 0;// Result of most recent mysql_query
var $Record = array(); //current mysql_fetch_array()-result
var $Row; // current row number

var $Errno =0;//error state of query
var $Error ="";
var $record_count="";
var $Num_Atrib="";
var $Nombre_Atrib="";#array
var $mensajes_usuario=array("no","Error en la conexi&oacute;n", "Error en la selecci&oacute;n de la base de datos ", "Error en la consulta a la base de datos" );
var $traduccion=array();


/*
function database(){
}//end of the function constructor
*/







function traducir_arra(){
if($this->depurar_database) $this->depurar_mensaje("Traducciones de web realiz&aacute;ndose");

        if(( $this->idioma_traduccion) or $this->idioma<>"gestion"){
        if($this->idioma=="gestion"){
        $this->query("select identificativo, texto_esp, texto_fra from traducir_gestion ");
        while($this->next_record()){
         if($this->Record["texto_".$this->idioma_traduccion])
          $tt=$this->Record["texto_".$this->idioma_traduccion];
         else
           $tt=$this->Record["texto_".$this->otro_idioma];

         $this->addArray($this->traduccion, $this->Record[identificativo],$tt);
         }
        }else{
		$this->query("select * from traducir_web");
        while($this->next_record()){
        if($this->Record["texto_".$this->idioma])
         $this->addArray($this->traduccion, $this->Record[identificativo_esp],$this->Record["texto_".$this->idioma]);
        else
          $this->addArray($this->traduccion, $this->Record[identificativo_esp],$this->Record["texto_".$this->otro_idioma]);
}
        }//if_gestion
        }//if
#       foreach($this->traduccion as $clave=>$valor) echo "$clave  $valor<hr>";
}


function mostrar_esquema_consulta($limite_registros=null){
    $salida.= "<style type='text/css'>
    <!--
    td.data_cabecera {font-family:Verdana,Helvetica,Arial,sans-serif;font-size:10px;color:brown;}
    td.data_celda_1 {font-family:Verdana,Helvetica,Arial,sans-serif;font-size:10px;color:gray;}
    td.data_celda_2 {font-family:Verdana,Helvetica,Arial,sans-serif;font-size:10px;color:brown;}
    -->
    </style>";
    $salida.=  "\n\n<table border=1 cellpadding=2 cellspacing=0 bordercolor=antiquewhite bgcolor=beige width='100%'>\n<tr>";
    for ($i=0;$i<$this->Num_Atrib;$i++){
        $salida.=  "\n\t<td class='data_cabecera'>
        ".mysql_field_name($this->Query_ID,$i)."</td>";          
    }//for
    $salida.=  "</tr>\n<tr>";
    for ($i=0;$i< $this->Num_Atrib;$i++){
        $salida.=  "\n\t<td  class='data_celda_1'>".mysql_field_type($this->Query_ID,$i)."</td>";
    }//end for
    while($this->next_record() && $j<>$limite_registros){
        $j++;
        $salida.=  "</tr>\n<tr>";
        for ($i=0;$i< $this->Num_Atrib;$i++){
            $salida.=  "\n\t<td  class='data_celda_2'>
                    ".$this->Record[mysql_field_name($this->Query_ID,$i)]."</td>";
        }//end for
    }//while next_record()
    $salida.=  "</tr>\n</table>\n\n";
    return $salida;
}//end function



# / STATS

function stats_ver_country(){
    $this->rm_address=(string)$_SERVER["REMOTE_ADDR"];
#$this->rm_address='90.246.7.120';
if($_COOKIE["quartiers"]){
    $quartiers=$_COOKIE["quartiers"];
$sql_ip="select id_stats_00 from stats_00 where id_stats_00=$quartiers";
}else{
$sql_ip="select id_stats_00 from stats_00 where ip='".$this->rm_address."'";
}//if
#en caso de IP diferente solo importa en caso de que no acepte cookies ya que habrˆ‚a que seguirle por la IP y esto ya lo hace
# en caso de que acepte cookies ya se le estˆ° siguiendo por id_stats_00 y de esta forma se tiene una claridad mayor sobre las repeticiones de cliente
$this->query($sql_ip);
if(!$this->record_count){
if($this->depurar_stats) $this->depurar_mensaje("nuevo ip, hay que hacer conexion a stats");
return false;
}else{
if($this->depurar_stats) $this->depurar_mensaje("Ya existe ip. Aumenta el contador de stats_00");
$this->next_record();
        $this->id_stats_00=$this->Record["id_stats_00"];
            $sql="update stats_00 set count_stats_00=(count_stats_00+1) where id_stats_00=".$this->id_stats_00;
			setcookie("quartiers", $this->id_stats_00);
$this->query($sql);
$this->stats_03();
}//if this->record_count
return true;
}//function


function stats_00(){
if($this->depurar_stats) $this->depurar_mensaje("insertar nuevo IP en stats_00");

        $sql="INSERT INTO stats_00 (ip, browser, country) VALUES ('".$this->rm_address."', '".$_SERVER["HTTP_USER_AGENT"]."', '".$this->country_name."')";
        $this->query($sql);
        $sql="select LAST_INSERT_ID() as id_stats_00 from stats_00";
        $this->query($sql);
        $this->next_record();
        $this->id_stats_00=$this->Record["id_stats_00"];
}//stats_00

function stats_03(){

$path=$_SERVER["SCRIPT_NAME"];
$lugar_guion=strrpos($this->archivo, "_");
if(!$this->subseccion){
$idioma_00=$this->idioma;
if($this->seccion==qdm){
$seccion_00="QDM PROYECTO";
if($lugar_guion) $archivo_00=str_replace(".php", "",  substr($this->archivo,0, $lugar_guion)); 
else $archivo_00=str_replace(".php", "", $this->archivo);
}else{
$archivo_00=$this->seccion;
$seccion_00="QDM";

}
}else{
$idioma_00=$this->idioma;
$seccion_00=$this->subseccion;
if($lugar_guion) $archivo_00=str_replace(".php", "",  substr($this->archivo,0, $lugar_guion)); 
else $archivo_00=str_replace(".php", "", $this->archivo);

}//if subseccion
#echo "$idioma_00<br> $seccion_00 <br> $archivo_00 <br><hr>";
if(!$archivo_00) $archivo_00="index.php";
$host_len=strlen("http://".$_SERVER["HTTP_HOST"]);
$refer=substr($_SERVER["HTTP_REFERER"], $host_len);
$sql="select id_stats_03 from stats_03 where path='$path' and referencia='$refer' and left(recibido,10)=left(curdate(),10) and id_stats_00=".$this->id_stats_00;
$this->query($sql);
    if(!$this->record_count){
	if($this->depurar_stats) $this->depurar_mensaje("inserta un nuevo registro en stats_03");
        $sql="INSERT INTO stats_03 (id_stats_00, path, referencia, recibido, idioma, seccion, archivo) VALUES ($this->id_stats_00,'$path', '$refer', now(), '$idioma_00', '$seccion_00', '$archivo_00')";
        $this->query($sql);
    }else{
    $this->next_record();
		if($this->depurar_stats) $this->depurar_mensaje("aumenta contador de stats_03");
    $sql="update stats_03 set count_stats_03=(count_stats_03+1) where id_stats_03=".$this->Record["id_stats_03"];
        $this->query($sql);
    }//if
}//function action_stats_03_stats_00

# / STATS


}//class conecto
?>
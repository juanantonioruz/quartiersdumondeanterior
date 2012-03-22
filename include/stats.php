<?php
require_once("conecto_stats.php");
class  stats extends conecto_stats{
function mirar_otra_base(){
$this->cerrar_conexion();
#cambio



 $this->Link_ID=mysql_connect($this->Host, $this->User, $this->Password);
#$this->conecto_00();

$country_query = "SELECT country_name FROM all_ip WHERE ip_from<=inet_aton('".$this->rm_address."') AND ip_to>=inet_aton('".$this->rm_address."') ";
$this->query($country_query);
#echo $country_query;
    if($this->record_count){
    $this->next_record();
    $this->country_name=$this->Record['country_name'];
    }else{
    $this->country_name="sin especificar";
    }//next record
    $this->cerrar_conexion();


   #cambio


   


 $this->Link_ID=mysql_connect($this->Host, $this->User, $this->Password);
}//function


function stats_ver_country(){
    global $HTTP_COOKIE_VARS;
    $this->rm_address=(string)$_SERVER["REMOTE_ADDR"];
 #$this->rm_address='248.246.7.100';
if($HTTP_COOKIE_VARS["coordinadora"]){
    $coordinadora =$HTTP_COOKIE_VARS["coordinadora"];
$sql_ip="select id_stats_00 from stats_00 where id_stats_00=$coordinadora";
}else{
$sql_ip="select id_stats_00 from stats_00 where ip='".$this->rm_address."'";
}//if
$this->query($sql_ip);
#echo "<h3>".$sql_ip."</h3>";
if(!$this->record_count){
#echo "no existe ip";
#die();
$this->mirar_otra_base();
    $this->stats_00();
    $this->stats_03();
}else{
#echo "ya existe registro";
$this->next_record();
        $this->id_stats_00=$this->Record["id_stats_00"];
            $sql="update stats_00 set count_stats_00=(count_stats_00+1) where id_stats_00=".$this->id_stats_00;
$this->query($sql);
$this->stats_03();
}//if this->record_count
#echo $this->country_name;
return $this->country_name;
}//function


function stats_00(){
        $sql="INSERT INTO stats_00 (ip, browser, country) VALUES ('".$this->rm_address."', '".$_SERVER["HTTP_USER_AGENT"]."', '".$this->country_name."')";
        $this->query($sql);
        $sql="select LAST_INSERT_ID() as id_stats_00 from stats_00";
        $this->query($sql);
        $this->next_record();
        $this->id_stats_00=$this->Record["id_stats_00"];
}//stats_00

function stats_03(){
if(!stristr($this->archivo, "_cab")){
if($_GET[id_clase]){$id_clase=$_GET[id_clase];$id_con01=" and id_clase=$id_clase";}
if(!$id_clase && $_GET[id]){ $id_consulta=$_GET[id]; $id_con00=" and id_consulta=$id_consulta ";}
if(!$id_clase and !$id_consulta){$id_tipo_clase=$_GET[tipo_clase];$id_conn02="and id_tipo_clase=$id_tipo_clase";}
if(!$id_clase and !$id_consulta)$id_cp=$_GET[cp]; 
if(!$id_clase and !$id_consulta)$id_horario=$_GET[id_horario];
$path=$this->seccion."/".$this->archivo;
$lugar_guion=strrpos($this->archivo, "_");
$idioma_00=$this->idioma;
$seccion_00=$this->seccion;
$archivo_00=substr($this->archivo,0, -4);
$referencia=explode("/", substr($_SERVER["HTTP_REFERER"],strlen("http://".$_SERVER["HTTP_HOST"])));
$referencia=$referencia[2];

#echo "<h2>$idioma_00  $seccion_00  $archivo_00 </h2>";

$sql="select id_stats_03 from stats_03 where path='$path' and referencia='$referencia' and left(recibido,10)=left(curdate(),10) and id_stats_00=".$this->id_stats_00." $id_con00  $id_con01  $id_conn02";
$this->query($sql);
    if(!$this->record_count){
        $sql="INSERT INTO stats_03 (id_stats_00, path, referencia, recibido, idioma, seccion, archivo, id_consulta, id_clase, id_tipo_clase, id_cp, id_horario) VALUES ($this->id_stats_00,'$path', '$referencia', now(), '$idioma_00', '$seccion_00', '$archivo_00', '$id_consulta', '$id_clase', '$id_tipo_clase', '$id_cp', '$id_horario')";
        $this->query($sql);
    }else{
    $this->next_record();
    $sql="update stats_03 set count_stats_03=(count_stats_03+1) where id_stats_03=".$this->Record["id_stats_03"];
        $this->query($sql);
    }//if
    }//if no strstr
}//function action_stats_03_stats_00
}//class
?>
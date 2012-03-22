<?php
require_once("gestion.php");
class gestion_mod extends gestionar{
#tener en cuenta que cuando se modifica una imagen se borra del directorio, por lo cual habr’àö’âÝ’àö¬ƒ que actualizar la imagen en base de datos
#"update f_alumno_00 set ".$_POST["accion"]."='".$_SESSION[$_POST["accion"]]."' where id_alumno_00=".$_POST["id_alumno_00"]."",
#RELOAD=?&session_name()."=".session_id(),

#var $sql_indice='';
#var $id_seccion='';
#var $array_campos='';
#var $array_usabilidad='';
#var $arra_imagenes=''; ---------> esto ya esta incluido en el arra_campos como tipo de campo
var $sql_mod='';
var $sql_mod_update=''; #array de tablas y sentencias sql de modificacion, es posible hacer arrays de valores y luego implode(',', $arra). CONDICIONES y mensajes de alarma
var $zona1=array();
var $zona2=array();
var $zona3=array();
var $zona4=array();

function pagina_mod(){
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000

    mirar si mulltiple
    
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
$this->conecto_central->query("select dato_tabla, tabla_multiple, dato_campo,dato_campo_tipo, seccion_00_sql_select_mod_del from dato_tabla 
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla)
left join seccion_00 on (dato_tabla.dato_tabla_id_seccion_00=seccion_00.id_seccion_00)
where  (dato_campo_tipo='referencia' or (dato_campo_tipo='last_insert_id' and tabla_multiple=1)) and seccion_00='".$this->seccion."' and zona_gestion=".$this->zona_gestion_registro);
$dat=$this->conecto_central;
while($dat->next_record()){
$consulta=$dat->Record[seccion_00_sql_select_mod_del];
if($dat->Record[tabla_multiple] && $dat->Record[dato_campo_tipo]=='referencia') $valor_id=$dat->Record[dato_campo];
else $camp[]=$dat->Record[dato_campo];
}//while

/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
MOD


999999999999 HAY QUE PULIR EL TEMA DE LAS ACTUALIZACIONES Y SELECCIONES A VARIAS TABLAS 010101001010101010101010101010

888888888888 he realizado un par de chapuces para reconocer las secciones secundarias, es decir aquellas que reciben un id_registro que las
                      condiciona, como es el caso de los selects y el caso de la registro_00 y registro_01

                      el otro chapuz consiste en implementar en este codigo la gestion de traducciones, aunque a’àö’à´n no reconoce todas las opciones,
                      es decir, trabaja bien en el caso de espa’àö¬±ol, portugues 
                      
                        

            AQUI SE CREA EL ARRAY:  	arra_campos_mod
            
            SE DEFINEN LAS VARIABLES: 	campo_id
                                                        id_seccion
                                                        index_tabla(N¬¨’à´_TABLA)
                                                        index_campo
                                                        mod_tabla (N¬¨’à´_TABLA)

00000000000000000000000000000000000000000000000000000000000000000000000000000
*/



$this->conecto_central->query("select * from dato_tabla
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla)
left join seccion_00 on (dato_tabla.dato_tabla_id_seccion_00=seccion_00.id_seccion_00)
where seccion_00='".$this->seccion."' and zona_gestion=".$this->zona_gestion_registro." order by dato_campo_orden desc");
while($this->conecto_central->next_record()){
if(!$this->conecto_central->Record[dato_campo_idioma] or 
($this->conecto_central->Record[dato_campo_idioma] && (@in_array(substr($this->conecto_central->Record[dato_campo], -3), $this->traduce)) 
or  substr($this->conecto_central->Record[dato_campo], -3)==$this->idioma_traduccion)
){
if(!@in_array(substr($this->conecto_central->Record[dato_campo], -3), $this->traduce) and substr($this->conecto_central->Record[dato_campo], -9,6)=="check_" and $this->seccion<>"c_05")
continue;
if($this->conecto_central->Record["dato_campo_trad_".$this->idioma_traduccion]) $this->conecto_central->Record[dato_campo_trad]=$this->de_html($this->conecto_central->Record["dato_campo_trad_".$this->idioma_traduccion]);
if(!$ya){
$ya=true; 
$sql_mod_prov=$this->conecto_central->Record[seccion_00_sql_select_mod_del]; 
$this->datos_central_fuente=$this->conecto_central->Record[datos_central]; 
}
if($this->seccion=='c_05' or $this->seccion=='c_29' or $this->seccion=='c_33'){
if($this->conecto_central->Record[dato_campo]=='check_'.$this->idioma_traduccion )
$this->conecto_central->Record[dato_campo]=str_replace("idioma", "", $_GET[campo_actualizar])."check_".$this->idioma_traduccion;
}
if($this->conecto_central->Record[dato_campo_tipo]=='referencia'){
    ${"mod_tabla".$this->conecto_central->Record[dato_campo_ntabla]}[]=$this->conecto_central->Record[dato_campo]."<>'".$_POST[$this->conecto_central->Record[dato_campo]]."'";
    if($this->conecto_central->Record[dato_campo_ntabla]==1){
$this->campo_id=$this->conecto_central->Record[dato_campo];
if($_GET[$this->campo_id]) $this->id_seccion=$_GET[$this->campo_id];
else $this->id_seccion=$_POST[$this->campo_id];
}//if  if($this->conecto_central->Record[dato_campo_ntabla]==1)
}

if($this->conecto_central->Record[dato_campo_id_seccion_mod] OR $this->conecto_central->Record[dato_campo_id_seccion]){
    if($this->conecto_central->Record[dato_campo_id_seccion]){ 
    $nex="<>"; 
    ${"index_tabla".$this->conecto_central->Record[dato_campo_ntabla]}=$this->conecto_central->Record[dato_campo]."='".$_POST[$this->conecto_central->Record[dato_campo]]."'";
    $index_campo=$this->conecto_central->Record[dato_campo]."=";
    } else{ 
    $nex="=";
    }//if

    if($this->conecto_central->Record[dato_campo_html]){
#    echo "___".$this->conecto_central->Record[dato_campo]."<br>";
    ${"mod_tabla".$this->conecto_central->Record[dato_campo_ntabla]}[]=$this->conecto_central->Record[dato_campo].$nex."'".$this->a_html($_POST[$this->conecto_central->Record[dato_campo]])."'";
    }else{
    ${"mod_tabla".$this->conecto_central->Record[dato_campo_ntabla]}[]=$this->conecto_central->Record[dato_campo].$nex."'".$_POST[$this->conecto_central->Record[dato_campo]]."'";
    }//if dato_campo_html
}// if($this->conecto_central->Record[dato_campo_id_seccion_mod] OR $this->conecto_central->Record[dato_campo_id_seccion]){
if($this->conecto_central->Record[dato_campo_mod]){
if($this->conecto_central->Record[dato_campo_join]){
$this->arra_campos_mod[]=array($this->conecto_central->Record[dato_campo]." as '".$this->conecto_central->Record[dato_campo_trad]."'", array("zona".$this->conecto_central->Record[dato_campo_zona], 'tabla'.$this->conecto_central->Record[dato_campo_ntabla]), $this->conecto_central->Record[dato_campo_tipo], $this->conecto_central->Record[dato_campo_forma_carga], "join@".$this->conecto_central->Record[dato_campo_join]."@".$this->conecto_central->Record[dato_campo_valor]);
}else{
if($this->conecto_central->Record[dato_campo_tipo]=='idioma'){
$this->conecto_central->Record[dato_campo]=str_replace("idioma", $this->conecto_central->Record[dato_campo], $_GET[campo_actualizar]);
#echo $this->idioma_traduccion." - ".$this->conecto_central->Record[dato_campo]."<br>";
if(substr($this->conecto_central->Record[dato_campo], -3)<>$this->idioma_traduccion)
$this->conecto_central->Record[dato_campo_tipo]='text';

if($this->seccion=='c_05' or $this->seccion=='c_29' or $this->seccion=='c_33'){
if($_GET[tipo]) $valor_00=$_GET[tipo];
elseif($_POST[tipo]) $valor_00=$_POST[tipo];
if(substr($this->conecto_central->Record[dato_campo], -3)<>$this->idioma_traduccion && $valor_00<>"doc")
$this->conecto_central->Record[dato_campo_tipo]='textarea';
else
$this->conecto_central->Record[dato_campo_tipo]=$valor_00;
}//c_05

}
$this->arra_campos_mod[]=array(
$this->conecto_central->Record[dato_campo]." as '".$this->conecto_central->Record[dato_campo_trad]."'", 
array("zona".$this->conecto_central->Record[dato_campo_zona], 'tabla'.$this->conecto_central->Record[dato_campo_ntabla]), 
$this->conecto_central->Record[dato_campo_tipo], 
$this->conecto_central->Record[dato_campo_forma_carga], 
$this->conecto_central->Record[dato_campo_valor], 
$this->conecto_central->Record[dato_campo_html], 
$this->conecto_central->Record[tabla_multiple]);
}
}//if dato_campo_mod
}//if idioma
}//while

#foreach($this->arra_campos_mod as $valor) echo "<h3 style='color:orange;'>".$valor[0]."</h3>";

/*
000000000000000000000000000000000000000000000000000000000000000000000000000000
AQUI SE FORMA $ids_valores_multiple EN FUNCION DE  $this->campo_id."=".$this->id_seccion);
000000000000000000000000000000000000000000000000000000000000000000000000000000
*/
if($consulta){
if(strstr($consulta, "where")) 
$query_sel_mod=str_replace("order", " and ".implode($camp, "=")." and ".$this->campo_id."=".$this->id_seccion." order ", $consulta);
else
$query_sel_mod=str_replace("order"," where ". implode($camp, "=")." and ".$this->campo_id."=".$this->id_seccion." order ", $consulta);
#echo $query_sel_mod;
if($this->datos_central_fuente){
$datos_fuente="conecto_central";
}else{
$datos_fuente="conecto_datos";
}
$this->$datos_fuente->query($query_sel_mod);
while($this->$datos_fuente->next_record()){
#echo "<h1>".$valor_id." . ".$this->conecto_datos->Record[id_noticia_02]."</h1>";
$ids_valores_multiple[]=$this->$datos_fuente->Record[$valor_id];
}//while
}//if $consulta
if($sql_mod_prov){
if(stristr($sql_mod_prov, "where")) $where_existe=" and "; else $where_existe=" where ";
if(stristr($sql_mod_prov, "order"))
$sql_mod_prov=str_replace("order", " $where_existe ".$this->campo_id."=".$this->id_seccion." order ", $sql_mod_prov);
else
$sql_mod_prov= $sql_mod_prov." $where_existe ".$this->campo_id."=".$this->id_seccion;
$this->sql_mod=$sql_mod_prov;
}else{
if($_GET[tabla])
$this->sql_mod="select * from ".$_GET[tabla]." where ".$_GET[campo_id]."=".$_GET[id_seccion] ;
else
$this->sql_mod="select * from ".$_POST[tabla]." where ".$_POST[campo_id]."=".$_POST[id_seccion] ;
} //if tabla se genera por union de varias tablas
#echo $this->sql_mod."<hr>";
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
MOD
            AQUI SE CREA EL   sql_mod    A PARTIR DE LA CONSULTA SOBRE  dato_seccion

00000000000000000000000000000000000000000000000000000000000000000000000000000
*/

#echo "<h3 style='color:green;'>".$this->sql_mod."</h3>";
/*
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
MOD
            AQUI SE CREA EL ARRAY DE ACTUALIZACIONES DE VARIAS TABLAS  sql_mod_update    
            A PARTIR DE LA CONSULTA SOBRE  dato_sql_act_mod
            
            ****
            existe el caso de las traducciones de toda la informaci’àö’â€n
            en ese caso se ha realizado un condicional manual solo para esa ocasion, es decir no funciona con otras

000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
*/
$this->conecto_central->query("select * from dato_sql_act_mod 
left join seccion_00 on (dato_sql_act_mod.dato_sql_act_mod_id_seccion_00=seccion_00.id_seccion_00)
where seccion_00='".$this->seccion."' and zona_gestion=".$this->zona_gestion_registro);
if($this->conecto_central->record_count){
    while($this->conecto_central->next_record()){
    $j=$this->conecto_central->Record[dato_sql_act_mod_ntabla];
    if($j<2){
  #  echo $this->conecto_central->Record[dato_sql_act_mod]." where ".$this->campo_id."=".$this->id_seccion;
    $this->sql_mod_update[]=array($this->conecto_central->Record[dato_sql_act_mod]." where ".$this->campo_id."=".$this->id_seccion , $this->conecto_central->Record[datos_central]);
}    else{
#echo "<br>pepe";
    foreach($ids_valores_multiple as $vv)
    $this->sql_mod_update[]=array($this->conecto_central->Record[dato_sql_act_mod]." ", $this->conecto_central->Record[datos_central]);
    }//if
    }//while
}else{
    if($_GET[tabla]){
            if($this->seccion=='c_05'){
            $this->sql_mod_update[]=array("update  ".$_GET[tabla]." set [*] where ".$_GET[campo_id]."=".$_GET[id_seccion], 0) ;
            }elseif($this->seccion=='c_29' or $this->seccion=='c_33'){
            $this->sql_mod_update[]=array("update  ".$_GET[tabla]." set [*] where ".$_GET[campo_id]."=".$_GET[id_seccion], 1) ;
			}else{
			$this->sql_mod_update[]=array("update  ".$_POST[tabla]." set [*] where ".$_POST[campo_id]."=".$_POST[id_seccion],0);
			}//if
	}//if
} //if tabla se genera por union de varias tablas
#foreach($this->sql_mod_update as $vol) echo "<h3 style='color:red;'>".$vol[0]."<br>".$vol[1]."</h3>";
$this->conecto_central->query("select * from dato_sql_condicion 
left join seccion_00 on (dato_sql_condicion_id_seccion_00=id_seccion_00)
where seccion_00='".$this->seccion."' and dato_sql_condicion_tipo='insertar_modificar' and zona_gestion=".$this->zona_gestion_registro);
while($this->conecto_central->next_record()){
$j=$this->conecto_central->Record[dato_sql_condicion_ntabla];
$this->sql_mod_condicion[]=array(
$this->conecto_central->Record[dato_sql_condicion]." where ".implode(" and ", ${"mod_tabla".$j}), $this->conecto_central->Record[dato_sql_condicion_alarma_esp], 
$this->conecto_central->Record[datos_central]);
#echo $this->conecto_central->Record[dato_sql_condicion]." where ".implode(" and ", ${"mod_tabla".$j})."<hr>";
}//while


/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
MOD
            COMIENZA A EJECUTARSE EL PROGRAMA DE MODIFICACI’àöˆ¨N 
            SEGUN LAS VARIABLES ANTERIORES

00000000000000000000000000000000000000000000000000000000000000000000000000000
*/

if($_GET[$this->id_seccion]) $this->id_seccion_value=$_GET[$this->id_seccion];
else $this->id_seccion_value=$_POST[$this->id_seccion];
$info_mod="";
if($this->mostrar_variables) $info_mod.=$this->info_registro_indice;
#$info_mod.=$this->navega_sup();
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
   
     Comienza analisis de arra_campos_mod:
        1. se genera la consulta de seleccion inicial
        2. tipos de campo: select, text, radio ...
        3. se define la estructura de la pagina en 4 zonas, reticula de 4 celdas
        

## 
##	$arra_imgs ---> array con nombres de campos de imagenes
##	$arra_selects_valores ---> array con nombres de campo de la seleccion inicial sql
## 
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
foreach($this->arra_campos_mod as $valor){
$valor_0=explode(" as ", $valor[0]);
#echo "____ ".$valor[1][1]. $valor_0[0]."<br>";
 if($valor[2]=='img' or $valor[2]=='doc'){ $arra_imgs[]=$valor_0[0];}
if($valor[6]) $arra_selects_valores_multiple[]=$valor_0[0]; 
$arra_selects_valores[]=$valor_0[0];

  if(substr($valor[1][1],0, 4)<>'tabla'){
  if($valor[2]=='img' or $valor[2]=='doc' ){
            if(@in_array($valor_0[0], $arra_imgs)) {
                ${$valor[1][1]}[]="$valor_0[0]='".$_SESSION[$this->seccion][$this->archivo][$valor_0[0]]."'";
                }else{
                ${$valor[1][1]}[]="$valor_0[0]='".$_POST[$valor_0[0]]."'";
            }
  }else{
  if($valor[5])  ${$valor[1][1]}[]="$valor_0[0]=\"".$this->a_html(str_replace('"', "'", $_POST[$valor_0[0]]))."\"";
  else  ${$valor[1][1]}[]="$valor_0[0]='".$_POST[$valor_0[0]]."'";
  }//if img or doc
  }
}//foreach
#foreach($arra_imgs as $valor)    echo "<h5 style='color:red'>". $valor."</h5>";
#   foreach($arra_selects_valores as $valor)    echo "<h5 style='color:red'>". $valor."</h5>";

/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
            if($_POST['actualizar']
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
if($_POST['actualizar']=='go'){
/* 
000000000000000 000000000000000 000000000000000
aqui se miran las condiciones de la actualizacion
000000000000000 000000000000000 000000000000000
*/
if(is_array($this->sql_mod_condicion))
foreach($this->sql_mod_condicion as $valor){
if($valor[2]){
$datos_fuente="conecto_central";
}else{
$datos_fuente="conecto_datos";
}
#echo $valor[0]."<hr>";
$this->$datos_fuente->query($valor[0]);
if($this->$datos_fuente->record_count){
$cambio_no_autorizado[]=$valor[1];
#echo $valor[0]."<br>".$valor[1]."<br>";
}//if
}//foreach



if(!$cambio_no_autorizado){
foreach($this->sql_mod_update as $valor){
#echo $valor;
if($i<1){
$i++;
#echo "<br>".str_replace("[*]", implode(", ", ${"tabla".$i}), $valor)."<hr>";
$this->sql_mod_update_def[]=array(str_replace("[*]", implode(", ", ${"tabla".$i}), $valor[0]),$valor[1]) ; # valor[1] es el tipo de base de datos
#echo "<br>".str_replace("[*]", implode(", ", ${"tabla".$i}), $valor[0])."<br>";
}elseif($i==1){
$i=2;
    $vh_temp00='';
        foreach($tabla2 as $vh){
        if(!@in_array($vh, $arra_vh)){
        $arra_vh[]=$vh;
        $vh=explode("=", $vh);
        foreach($ids_valores_multiple as $vv){ 
        if($vh[0]==$valor_id){
        ${"where".$vv}="where ".$vh[0]."=".$_POST[$vh[0].$vv]; 
        }else{      
        if(@in_array($vh[0], $arra_imgs)) 
        ${$vh_temp.$vv}[]=$vh[0]."='".$_SESSION[$this->seccion][$this->archivo][$vh[0].$vv]."'";
     else
        ${$vh_temp.$vv}[]=$vh[0]."=\"".$this->a_html($_POST[$vh[0].$vv])."\""; 
        }//if=valor id
        }
        }//if
        }//foreach
                foreach($ids_valores_multiple as $vv){
                $this->sql_mod_update_def[]=array(str_replace("[*]", implode(", ", ${$vh_temp.$vv}), $valor[0].${"where".$vv}), $valor[1]); # el valor[1] es por la base de datos
             #  echo "<br>" .str_replace("[*]", implode(", ", ${$vh_temp.$vv}), $valor[0].${"where".$vv})."<br>";
                }

#    foreach(${$vh_temp.$vv} as $vv_lor) echo $vv_lor."<br>";
    
    #$this->sql_mod_update[]=$dat->Record[dato_sql_act_mod]." where ".$valor_id."=".$_POST[$valor_id.$vv];
    
}//if i<2
}//foreach
}//if
#foreach($_POST as $clave=>$valor) echo "<br>$clave ".str_replace("_idioma","", $valor)."<br>";
foreach($this->sql_mod_update_def as $actualizacion_definitiva){
if($actualizacion_definitiva[1]) $fuente_datos="conecto_central"; else $fuente_datos="conecto_datos";
if(($this->seccion=="c_29" or $this->seccion=="c_33") or ($this->seccion=='c_05' and $this->idioma_traduccion<>'fra'))
$actualizacion_definitiva[0]=str_replace("check", str_replace("_idioma","", $_POST[campo_actualizar])."_check", $actualizacion_definitiva[0]);
$this->$fuente_datos->query(str_replace("last_insert", $this->id_seccion, $actualizacion_definitiva[0]));
echo $fuente_datos." - - ". str_replace("last_insert", $this->id_seccion, $actualizacion_definitiva[0])."<hr>";
}
die("link: <a href='index.php'>indice</a>");
// coordinadora funcion para insertar nuevos usuarios desde tabla entidades con las confguraciones de registro_00, registro_01
if(!$cambio_no_autorizado and $this->seccion=='c_38'){
$this-> datos_central->query("update registro_00 set user='".$_POST[user_entidad]."' , password='".$_POST[pw_entidad]."' where id_registro_00=".$_POST[id_registro_00]);
}
// FIN coordinadora funcion para insertar nuevos usuarios desde tabla entidades con las confguraciones de registro_00, registro_01

if($_POST[PHPSESSID])$sesid="?PHPSESSID=".$_POST[PHPSESSID];
if(!$cambio_no_autorizado && $_POST['actualizar']=='go'){header("location: index.php?$sesid");die();}
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
           ELSE if($_POST['actualizar']
           $ids_valores_multiple
           $valor_id
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
}
if($_POST['actualizar']<>'go'){ # if $_POST['accion']
if($this->datos_central_fuente) $datos_fuente="conecto_central"; else $datos_fuente="conecto_datos";
if($arra_selects_valores){
#echo "pepe".str_replace("[*]", implode(", ", $arra_selects_valores), $this->sql_mod);
#echo implode("<br>/ ", $arra_selects_valores)."<hr>";
#die($datos_fuente);
$this->$datos_fuente->query(str_replace("[*]", implode(", ", $arra_selects_valores), $this->sql_mod));

#echo "<h1>".$this->conecto_datos->record_count."</h1>";
#echo str_replace("[*]", implode(", ", $arra_selects_valores), $this->sql_mod);
while($this->$datos_fuente->next_record()){
    foreach($arra_selects_valores as $valor){
    #echo "<hr>select_$valor";
    $multiple='';
     if(@in_array($valor, $arra_selects_valores_multiple)) $multiple=$this->$datos_fuente->Record[$valor_id];
    $this->{"select_".$valor.$multiple}=$this->$datos_fuente->Record[$valor];
	#echo "<h5 style='color:blue'> select_$valor$multiple ".$this->{"select_".$valor.$multiple}."</h5>";
        $url_ref=array_reverse(explode('/', $_SERVER['HTTP_REFERER']));
        $url_ref=$url_ref[0];
            #echo "<hr> $url_ref";
    if(@in_array($valor ,$arra_imgs)){
    #echo "$valor: ".$this->conecto_datos->Record[$valor]. $url_ref;
    if(!$url_ref  or substr($url_ref,0,5)=='index')    $this->upload->aplicar_sesiones_t_archivo($valor.$multiple, $this->$datos_fuente->Record[$valor]);
    }//if
    }//foreach
    }//while
}//if $arra_selects_valores
foreach($this->arra_campos_mod as $valor){
$campo_multiple=$valor[6];
$campo_select=$valor[0];
$id_zona=$valor[1][0];
$tipo_campo=$valor[2];
$tipo_carga_datos=$valor[3];
$this->arra_campos[]= $campo_select;
$valor_0=explode(" as ", $campo_select);
$id_campo=$valor_0[0];
$campo_trad=str_replace("'", "", $valor_0[1]);
$tipo_argumentos=$valor[4];
if($tipo_carga_datos=='consulta') $argumentos=$tipo_argumentos;
elseif($tipo_carga_datos =='get/post')
if($_GET[$id_campo]) $argumentos=$_GET[$id_campo];
else $argumentos=$_POST[$id_campo];
elseif($tipo_carga_datos =='array'){
$arra_database='';
if(strrchr($valor[4],";")) eval(str_replace('_idioma', '_'.$this->idioma_traduccion, $valor[4]));
if($arra_database)$valor[4]=$arra_database;
$argumentos=$valor[4];
}elseif($tipo_carga_datos =='directo') $argumentos=$valor[4];
elseif($tipo_carga_datos =='sql' && $tipo_campo=='select' ){
$arra_database='';
if(substr($valor[4],0,5)=='join@'){
 $array_join=explode("@", $valor[4]);
    $valor[4]= $array_join[2];
 }else{
 $array_join=null;
 }
    if(strrchr($valor[4],";")) eval(str_replace('_idioma', '_'.$this->idioma_traduccion, $valor[4]));
    if($arra_database)$valor[4]=$arra_database;

if($array_join){
 if(strstr($valor[4][0], "where")) {
  $consulta_join= " and ".$array_join[1]."=".$_SESSION["sqls"][$this->pack_name][$this->seccion][$array_join[1]] ;
  }else{
  $consulta_join=" where ".$array_join[1]."=".$_SESSION["sqls"][$this->pack_name][$this->seccion][$array_join[1]] ;
 }
  if(strstr($valor[4][0], "order"))
  $valor[4][0]=str_replace("order", $consulta_join." order", $valor[4][0]);
  else
  $valor[4][0].= $consulta_join;

}
        if($valor[4][2]) $datos_fuente=$valor[4][2];
    $this->$datos_fuente->query($valor[4][0]);
#echo $valor[4][0]."<hr>";

    $arra_prov=array();
    if($valor[4][1]=='blanco')
        $this->addArray($arra_prov, '', '');
    while($this->$datos_fuente->next_record()){
    if($arra_prov[$this->$datos_fuente->Record[visible]]){
     $separ.="_";
     $this->$datos_fuente->Record[visible]=$separ.$this->$datos_fuente->Record[visible];
     }
    $this->addArray($arra_prov, $this->$datos_fuente->Record[visible], $this->$datos_fuente->Record[invisible]);
    }
    $argumentos[0]=$arra_prov;
}
for($i=1; $i<5;$i++)
if($id_zona=="zona$i")$this->{"zona$i"}[]=array($id_campo, $campo_trad ,$tipo_campo, $tipo_carga_datos, $argumentos, $campo_multiple); 
}
$info_mod.=$this->documento_gestion->abrir_tabla_modulo('100%', 50,"left");//($ancho,$alto, $alinear_tabla="left")
$info_mod.=$this->documento_gestion->abrir_tabla_info('100%', 50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)


/*
####
####	TRADUCCIONES
####
#$info_mod.="traduccion: ".$this->conecto_datos->traduccion['prueba2']."<hr>";
000000000000000000000000000000000000000000000000000000000
*/
$info_mod.="<form method='post' name='gestion'>";
#$this->conecto_datos->next_record();
#echo "<hr>".$this->conecto_datos->Record[]
$info_mod.="\n\n\n<table border=0 width='100%' height='100%' cellspacing=2 cellpadding=5 bgcolor='#CCCCCC'>
<tr><td colspan=2 valign='top' align='left' class='bg_color_8'>".$this->navega_sup_info."</td></tr>";
for($i=1; $i<5;$i++){
if($i==1 or $i==3){
    if(count($this->{"zona".$i}) and !count($this->{"zona".($i+1)}) )
    $info_mod.="\n\n\n<tr><td colspan=2 valign='top' align='left' bgcolor='#EEEEEE'>";
    elseif(count($this->{"zona".$i}) and count($this->{"zona".($i+1)}))
    $info_mod.="\n\n\n<tr><td valign='top' align='left' bgcolor='#EEEEEE'>";
}elseif($i==2 or $i==4){
    if(count($this->{"zona".$i}) and !count($this->{"zona".($i-1)}) )
    $info_mod.="\n\n\n<tr><td colspan=2 valign='top' align='left' bgcolor='#EEEEEE'>";
    elseif(count($this->{"zona".$i}) and count($this->{"zona".($i-1)}))
    $info_mod.="\n\n\n<td valign='top' align='left' bgcolor='#EEEEEE'>";
}

    foreach($this->{"zona$i"} as $valor){
    #$info_mod.= "<b>zona$i</b> $valor[0] $valor[1] $valor[2] $valor[3]<br>";
    ##
    ##	000 aqui se sustituye el valor visible del campo por su traduccion, si el primer caracter es una '*'
    ##
    $valor_trad=$valor[1];
    if($valor_trad[0]=='*') $valor_trad=$this->conecto_central->traduccion[substr($valor_trad,1)];
    if($valor[5]){
    ${"arra_val".$i}[]=array($valor[0], $valor_trad, $valor[2], $valor[3], $valor[4]);
    #foreach($ids_valores_multiple as $id_m)
    #$info_mod.="<b>zona$i </b>".$this->select_tipo_campo($valor[0].$id_m, $valor_trad.$id_m, $valor[2], $valor[3], $valor[4])."<br>";
    }else{
    if($valor[2]<>"hidden" and $valor[2]<>"last_insert" and $valor[2]<>"referencia") $br="<br>"; else $br='';
    $info_mod.="\n".$this->select_tipo_campo($valor[0], $this->a_html($valor_trad), $valor[2], $valor[3], $valor[4]).$br;
    }
    }//foreach
if(is_array(${"arra_val".$i})){
$numero=1;
foreach($ids_valores_multiple as $id_m){
foreach(${"arra_val".$i} as $vol){
#echo $vol[0]." $numero <br>";
    if($vol[2]<>"hidden" and $vol[2]<>"last_insert" and $vol[2]<>"referencia") $br="<br>"; else $br='';
$info_mod.="\n".$this->select_tipo_campo($vol[0].$id_m, $this->a_html($vol[1])." ".$numero, $vol[2], $vol[3], $vol[4]).$br."\n";
}//foreach
$numero++;
}//foreach
}//if
if($i==1 or $i==3){
    if(count($this->{"zona".$i}) and !count($this->{"zona".($i+1)}) )
    $info_mod.="</td></tr>\n\n\n";
    elseif(count($this->{"zona".$i}) and count($this->{"zona".($i+1)}))
    $info_mod.="</td>\n\n\n";
}elseif($i==2 or $i==4){
    $info_mod.="</td></tr>\n\n\n";
}


}//for


$info_mod.="<tr><td colspan=2 bgcolor='#FFFFFF'><input type='hidden' value='' name='actualizar'><input type='button' name='modificar' value='modificar' onclick=\"javascript:window.self.document.forms[0]['actualizar'].value='go';window.self.document.forms[0].submit();\"></td></tr>";
$info_mod.="</table></form>";
$info_mod.=$this->documento_gestion->cerrar_tabla_info('100%', 50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
$info_mod.=$this->documento_gestion->cerrar_tabla_modulo('100%', 50);
$this->conecto_central->cerrar_conexion();


return $info_mod;
}//if $_POST['accion']==enviar
}//function pagina_mod
}//class
?>
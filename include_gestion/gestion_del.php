<?php
require_once("gestion.php");
class gestion_del extends gestionar{

function pagina_del(){
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000

   DEL  mirar si multiple
    
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
$this->conecto_central->query("select dato_tabla, tabla_multiple, dato_campo,dato_campo_tipo, seccion_00_sql_select_mod_del from dato_tabla 
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla)
left join seccion_00 on (dato_tabla.dato_tabla_id_seccion_00=seccion_00.id_seccion_00)
where  (dato_campo_tipo='referencia' or (dato_campo_tipo='last_insert' and tabla_multiple=1)) and seccion_00='".$this->seccion."' and zona_gestion=".$this->zona_gestion_registro);
while($this->conecto_central->next_record()){
$consulta=$this->conecto_central->Record[seccion_00_sql_select_mod_del];
if($this->conecto_central->Record[tabla_multiple] && $this->conecto_central->Record[dato_campo_tipo]=='referencia') $valor_id=$this->conecto_central->Record[dato_campo];
else $camp[]=$this->conecto_central->Record[dato_campo];
}
/*
del 00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
$this->conecto_central->query("select * from dato_tabla
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla)
left join seccion_00 on (dato_tabla.dato_tabla_id_seccion_00=seccion_00.id_seccion_00)
where seccion_00='".$this->seccion."' and zona_gestion=".$this->zona_gestion_registro." order by dato_campo_orden desc");
while($this->conecto_central->next_record()){
if(!$this->conecto_central->Record[dato_campo_idioma] or ($this->conecto_central->Record[dato_campo_idioma] && (@in_array(substr($this->conecto_central->Record[dato_campo], -3), $this->traduce)) or  substr($this->conecto_central->Record[dato_campo], -3)==$this->idioma_traduccion)){
if(!@in_array(substr($this->conecto_central->Record[dato_campo], -3), $this->traduce) and substr($this->conecto_central->Record[dato_campo], -9,6)=="check_")
continue;
if($this->conecto_central->Record["dato_campo_trad_".$this->idioma_traduccion]) $this->conecto_central->Record[dato_campo_trad]=$this->de_html($this->conecto_central->Record["dato_campo_trad_".$this->idioma_traduccion]);
if(!$ya){$ya=true; 
$this->datos_fuente=$this->conecto_central->Record[datos_central];
$tabla_del=$this->conecto_central->Record[seccion_00_sql_select_mod_del];}
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
    ${"mod_tabla".$this->conecto_central->Record[dato_campo_ntabla]}[]=$this->conecto_central->Record[dato_campo].$nex."'".$this->a_html($_POST[$this->conecto_central->Record[dato_campo]])."'";
    }else{
    ${"mod_tabla".$this->conecto_central->Record[dato_campo_ntabla]}[]=$this->conecto_central->Record[dato_campo].$nex."'".$_POST[$this->conecto_central->Record[dato_campo]]."'";
    }//if dato_campo_html
}// if($this->conecto_central->Record[dato_campo_id_seccion_mod] OR $this->conecto_central->Record[dato_campo_id_seccion]){
if($this->conecto_central->Record[dato_campo_mod]){
if($this->conecto_central->Record[dato_campo_join]){
$this->arra_campos_mod[]=array(
$this->conecto_central->Record[dato_campo]." as '".$this->conecto_central->Record[dato_campo_trad]."'",
 array("zona".$this->conecto_central->Record[dato_campo_zona], 'tabla'.$this->conecto_central->Record[dato_campo_ntabla]),
  $this->conecto_central->Record[dato_campo_tipo],
   $this->conecto_central->Record[dato_campo_forma_carga],
    "join@".$this->conecto_central->Record[dato_campo_join]."@".$this->conecto_central->Record[dato_campo_valor],
"",
"",
	$this->conecto_central->Record[dato_campo_trad]
);
}else{
if($this->conecto_central->Record[dato_campo_tipo]=='idioma'){
$this->conecto_central->Record[dato_campo]=str_replace("idioma", $this->conecto_central->Record[dato_campo], $_GET[campo_actualizar]);
#echo $this->idioma_traduccion." - ".$this->conecto_central->Record[dato_campo]."<br>";
if(substr($this->conecto_central->Record[dato_campo], -3)<>$this->idioma_traduccion)
$this->conecto_central->Record[dato_campo_tipo]='text';
}

$this->arra_campos_mod[]=array(
$this->conecto_central->Record[dato_campo]." as '".$this->conecto_central->Record[dato_campo_trad]."'", 
array("zona".$this->conecto_central->Record[dato_campo_zona], 'tabla'.$this->conecto_central->Record[dato_campo_ntabla] ), 
$this->conecto_central->Record[dato_campo_tipo], 
$this->conecto_central->Record[dato_campo_forma_carga], 
$this->conecto_central->Record[dato_campo_valor],
$this->conecto_central->Record[dato_campo_html], 
$this->conecto_central->Record[tabla_multiple],
$this->conecto_central->Record[dato_campo_trad]
);
}
}//if dato_campo_mod
}//if_idioma
}//while
#foreach($this->arra_campos_mod as $valor) echo $valor[0]."<br>";
if(stristr($tabla_del, "where")) $where_existe=true;
if(stristr($tabla_del, "order")){
if($where_existe)
$this->sql_mod=str_replace("order", " and ".$this->campo_id."=".$this->id_seccion ." order", $tabla_del);
else
$this->sql_mod=str_replace("order", " where ".$this->campo_id."=".$this->id_seccion ." order", $tabla_del);
}else{
if($where_existe)
$this->sql_mod=$tabla_del." and ".$this->campo_id."=".$this->id_seccion;
else
$this->sql_mod=$tabla_del." where ".$this->campo_id."=".$this->id_seccion;
}
#echo "<h3 >---".$this->sql_mod."</h3>";
/*
000000000000000000000000000000000000000000000000000000000000000000000000000000
AQUI SE FORMA $ids_valores_multiple EN FUNCION DE  $this->campo_id."=".$this->id_seccion);
000000000000000000000000000000000000000000000000000000000000000000000000000000
*/
if(stristr($consulta, "order")){
$consulta=str_replace("order", " where ". implode($camp, "=")." and ".$this->campo_id."=".$this->id_seccion ." order", $consulta);
#echo $consulta;
#die();
#$this->conecto_central->query($consulta);
}else{
 if(strstr ($consulta, "where")) {
 $consulta=str_replace("where", " where ". implode($camp, "=")." and ".$this->campo_id."=".$this->id_seccion." and ", $consulta);
 }else{
$consulta=$consulta." where ". implode($camp, "=")." and ".$this->campo_id."=".$this->id_seccion;
 }
}
 if($this->datos_fuente) $datos_fuente ="conecto_central"; else $datos_fuente ="conecto_datos";
$this-> $datos_fuente->query($consulta);
#echo "<h3>".$consulta."</h3>";

while($this-> $datos_fuente->next_record()){
$ids_valores_multiple[]=$this-> $datos_fuente->Record[$valor_id];
}
/*
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000

del	AQUI SE CREA EL ARRAY DE ACTUALIZACIONES DE VARIAS TABLAS  sql_mod_update    
            A PARTIR DE LA CONSULTA SOBRE  dato_sql_act_mod
            
            ****
            existe el caso de las traducciones de toda la informaci’àö’â€n
            en ese caso se ha realizado un condicional manual solo para esa ocasion, es decir no funciona con otras

000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
*/


$this->conecto_central->query("select * from dato_sql_act_mod 
left join seccion_00 on (dato_sql_act_mod.dato_sql_act_mod_id_seccion_00=seccion_00.id_seccion_00)
left join dato_tabla on (id_dato_tabla=dato_sql_act_mod_id_tabla)
where seccion_00='".$this->seccion."' and zona_gestion=".$this->zona_gestion_registro);


while($this->conecto_central->next_record()){
$j=$this->conecto_central->Record[dato_sql_act_mod_ntabla];
$this->sql_mod_update_tabla[]=array($this->conecto_central->Record[id_dato_tabla], $this->conecto_central->Record[dato_tabla]);
$data_central=$this->conecto_central->Record[datos_central];
if($j<2){
 if(strstr ($this->conecto_central->Record[dato_sql_act_delete], "where")) {
 $consulta_00=str_replace("where", " where ".$this->campo_id."=".$this->id_seccion." and ".$this->campo_id."=".$this->id_seccion." and ", $this->conecto_central->Record[dato_sql_act_delete]);
 }else{
$consulta_00 =$this->conecto_central->Record[dato_sql_act_delete]." where ".$this->campo_id."=".$this->id_seccion;
 }
$this->sql_mod_update[]=array($consulta_00, $data_central);
}else{
foreach($ids_valores_multiple as $vv){
 if(strstr ($this->conecto_central->Record[dato_sql_act_delete], "where")) {
 $consulta_01=str_replace("where", " where $valor_id=$vv  and ".$this->campo_id."=".$this->id_seccion." and ", $this->conecto_central->Record[dato_sql_act_delete]);
 }else{
$consulta_01 =$this->conecto_central->Record[dato_sql_act_delete]." where $valor_id=$vv";
 }
$this->sql_mod_update[]=array($consulta_01, $data_central);
}//foreach
}//if
}//while

#foreach($this->sql_mod_update as $valor) echo $valor[0]."<br>";

/*
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
DEL
                   inicio de condiciones a la eliminacion
                   
                   se mira los registros incluidos en dato_sql_condicion
                   
                   

0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
*/

$this->conecto_central->query("select * from dato_sql_condicion 
left join seccion_00 on (dato_sql_condicion_id_seccion_00=id_seccion_00)
left join dato_tabla on (sql_condicion_id_tabla=id_dato_tabla)
where  seccion_00='".$this->seccion."' and dato_sql_condicion_tipo='borrar' and zona_gestion=".$this->zona_gestion_registro);

while($this->conecto_central->next_record()){
$tabla_delete[]=array(
$this->conecto_central->Record[dato_tabla],
$this->conecto_central->Record[dato_sql_condicion],
$this->conecto_central->Record[dato_sql_condicion_alarma_esp] , 
$this->conecto_central->Record[datos_central]);
}//while

$numero_condiciones=0;
if($tabla_delete)
foreach($tabla_delete as $val){ 
$v=$val[0];
#echo "<h1> $v </h1>";
$this->conecto_central->query("select id_dato_tabla, dato_campo, dato_campo_join, dato_campo_tipo, tabla_multiple 
from  dato_tabla 
left join dato_campo on (dato_campo_id_tabla=id_dato_tabla)
left join seccion_00 on (dato_tabla_id_seccion_00 =id_seccion_00)
where dato_tabla='$v' and (dato_campo_tipo='referencia' or dato_campo_tipo='img' or dato_campo_tipo='doc'  or dato_campo_join<>'') and zona_gestion=".$this->zona_gestion_registro );
while($this->conecto_central->next_record()){
#echo "<h3> ".$this->conecto_central->Record[dato_campo]." </h3>";
    if($this->conecto_central->Record[dato_campo_tipo]=='referencia') 
        ${"referencia".$numero_condiciones}=$this->conecto_central->Record[dato_campo];
    elseif($this->conecto_central->Record[dato_campo_tipo]=='img' or $this->conecto_central->Record[dato_campo_tipo]=='doc') 
        ${"img_campos_delete".$numero_condiciones}[]=$this->conecto_central->Record[dato_campo];
    elseif($this->conecto_central->Record[dato_campo_join]<>'') 
        ${"join".$numero_condiciones}=$this->conecto_central->Record[dato_campo]; 
    ${"tabla".$numero_condiciones}=$v;
}//while

$this->{"sql_del_condicion".$numero_condiciones}[]="select ".${"referencia".$numero_condiciones}." from $v where ".${"join".$numero_condiciones}."=".$this->id_seccion;
#echo "select ".${"referencia".$numero_condiciones}." from $v where ".${"join".$numero_condiciones}."=".$this->id_seccion."<hr>";

if(!strstr($val[1], "where"))
$v_sql=$val[1]."  where ".$this->campo_id."=".$this->id_seccion;
else
$v_sql=$val[1]." and  ".$this->campo_id."=".$this->id_seccion;
${"sql_cond_select".$numero_condiciones}=$v_sql;
${"sql_cond_select_alarma".$numero_condiciones}=$val[2];
${"sql_cond_select_datos_fuente".$numero_condiciones}=$val[3];
#echo ${"sql_cond_select".$numero_condiciones}."<hr>";
$numero_condiciones++;

}//foreach

for($n_condiciones=0; $n_condiciones<$numero_condiciones; $n_condiciones++){
    $arra_select=${"img_campos_delete".$n_condiciones};
    $arra_select[]=${"referencia".$n_condiciones};
  #  foreach(${"img_campos_delete".$n_condiciones} as $v67) echo $v67;
    $sql_sel_00=str_replace("[*]", implode(", ", $arra_select), ${"sql_cond_select".$n_condiciones});
    $datos_fuente_00= ${"sql_cond_select_datos_fuente".$n_condiciones};
    if($datos_fuente_00) $datos_fuente="conecto_central"; else $datos_fuente="conecto_datos";
 #echo "<h2>". $sql_sel_00."</h2><hr>";

    $this->$datos_fuente->query($sql_sel_00);
#echo $sql_sel_00."<hr>";
        if($this-> $datos_fuente->record_count) ${"eliminacion_tabla_n".$n_condiciones}=true;
    if($this-> $datos_fuente->record_count and ${"sql_cond_select_alarma".$n_condiciones}<>''){
    ${"alarma_eliminacion_tablas_sec".$n_condiciones}=true;
     $alarma_eliminacion_tablas_sec[]=${"sql_cond_select_alarma".$n_condiciones};
     }
    while($this-> $datos_fuente->next_record()){
        ${"arra_ids".$n_condiciones}[]=$this-> $datos_fuente->Record[${"referencia".$n_condiciones}];
        ${"arra_ids_fuente".$n_condiciones}=$datos_fuente_00;
           if(${"img_campos_delete".$n_condiciones}){
                foreach(${"img_campos_delete".$n_condiciones} as $imagen_campo)
                ${"arra_imgs_delete".$n_condiciones}[]=$this-> $datos_fuente->Record[$imagen_campo];
            }//if imagenes o archivos
    }
}//for
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
DEL

    fin de mirar las tablas relacionadas(secundarias) que hacen de condicion a la eliminacion
        
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
if($_GET[$this->id_seccion]) $this->id_seccion_value=$_GET[$this->id_seccion];
else $this->id_seccion_value=$_POST[$this->id_seccion];
$info_del="";
if($this->mostrar_variables) $info_del.=$this->info_registro_indice;
#$info_del.=$this->navega_sup();
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
DEL
            COMIENZA A EJECUTARSE EL PROGRAMA DE MODIFICACI’àöˆ¨N 
            SEGUN LAS VARIABLES ANTERIORES

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

 if($valor[2]=='img' or $valor[2]=='doc') $arra_imgs[]=$valor_0[0];
 if($valor[6]) $arra_selects_valores_multiple[]=$valor_0[0];
  $arra_selects_valores[]=$valor_0[0];
  if(substr($valor[1][1],0, 4)<>'tabla'){
 /*
  if(!$valor[5])
  ${$valor[1][1]}[]="$valor_0[0]='".$_POST[$valor_0[0]]."'";
  else
  ${$valor[1][1]}[]="$valor_0[0]='".$this->documento->a_html($_POST[$valor_0[0]])."'";
  */
  }
}//foreach
##
##	aqui se comprueba el boton submit para generar la actualizacion de registros por tablas
##	estaria bien comprobar el referer para que no te hackeen los registros
##
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
DEL
            if($_POST['actualizar']
            aqui se miran las condiciones de la actualizacion

00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
if($_POST['actualizar']){
$arra_def_del_images=array();
foreach($this->sql_mod_update_tabla as $valor){
$this->conecto_central->query("select id_dato_tabla, dato_campo, dato_campo_join, dato_campo_tipo, tabla_multiple, tabla_datos_central, dato_campo_valor
from  dato_tabla 
left join dato_campo on (dato_campo_id_tabla=id_dato_tabla)
where id_dato_tabla='".$valor[0]."' and (dato_campo_tipo='img'  or dato_campo_tipo='doc'  or dato_campo_tipo='referencia')");
if($this->depurar_gestion_del) $this->depurar_mensaje($valor[1]." - select id_dato_tabla, dato_campo, dato_campo_join, dato_campo_tipo, tabla_multiple, tabla_datos_central 
from  dato_tabla 
left join dato_campo on (dato_campo_id_tabla=id_dato_tabla)
where id_dato_tabla='$valor' and (dato_campo_tipo='img'  or dato_campo_tipo='doc'  or dato_campo_tipo='referencia')");
$img_delete='';
while($this->conecto_central->next_record()){
if($this->conecto_central->Record[tabla_datos_central]) $datos="conecto_central"; else $datos="conecto_datos";
#if($this->depurar_gestion_del) $this->depurar_mensaje($this->conecto_central->Record[dato_campo]);
if($this->conecto_central->Record[dato_campo_tipo]=='img' or $this->conecto_central->Record[dato_campo_tipo]=='doc'){
$img_delete[]=$this->conecto_central->Record[dato_campo];
if($this->conecto_central->Record[dato_campo_valor]){
$arra_argumentos=explode( "&", $this->conecto_central->Record[dato_campo_valor]);
$url_path=$arra_argumentos[4];
}else{
$url_path="../../imgs/";
}//if
}else{
$ref_delete=$this->conecto_central->Record[dato_campo];
}//if
}//while
#echo "<h1> $valor</h1>";
    if($img_delete){
        if($jjj){ // es decir que es la tabla multiple
            foreach($ids_valores_multiple as $vv){
			if($this->depurar_gestion_del) $this->depurar_mensaje("select ".implode(', ', $img_delete)." from ".$valor[1]." where ".$ref_delete."=".$vv);
                $this->$datos->query("select ".implode(', ', $img_delete)." from ".$valor[1]." where ".$ref_delete."=".$vv);
                while($this->$datos->next_record()){
                foreach($img_delete as $valor_imagen_del){
                $arra_def_del_images[]=$this->$datos->Record[$valor_imagen_del];
                $arra_def_del_images[]=str_replace("mm", "zz", $this->$datos->Record[$valor_imagen_del]);
				$img_delete_url[]=$url_path.$this->$datos->Record[$valor_imagen_del];
				$img_delete_url[]=$url_path.str_replace("mm", "zz", $this->$datos->Record[$valor_imagen_del]);
                }//foreach
                }//while
            }//foreach
        }else{
					if($this->depurar_gestion_del) $this->depurar_mensaje("select ".implode(', ', $img_delete)." from ".$valor[1]." where ".$ref_delete."=".$this->id_seccion);

            $this->$datos->query("select ".implode(', ', $img_delete)." from ".$valor[1]." where ".$ref_delete."=".$this->id_seccion);

            #die("$datos -- select ".implode(', ', $img_delete)." from $valor where ".$ref_delete."=".$this->id_seccion);

            while($this->$datos->next_record()){
                foreach($img_delete as $valor_imagen_del){
                $arra_def_del_images[]=$this->$datos->Record[$valor_imagen_del];
                $arra_def_del_images[]=str_replace("mm", "zz", $this->$datos->Record[$valor_imagen_del]);
				$img_delete_url[]=$url_path.$this->$datos->Record[$valor_imagen_del];
				$img_delete_url[]=$url_path.str_replace("mm", "zz", $this->$datos->Record[$valor_imagen_del]);
                }//foreach
            }//while


        }//if
        $jjj++;

    }//if $img_delete

}//foreach

/*
0000000000000 tablas secundarias borrar
*/
for($n_condiciones=0; $n_condiciones<$numero_condiciones; $n_condiciones++){
if(${"eliminacion_tabla_n".$n_condiciones}){
foreach(${"arra_ids".$n_condiciones} as $id) $this->sql_mod_update[]=array("delete from ". ${"tabla".$n_condiciones}." where ". ${"referencia".$n_condiciones}."=$id", ${"arra_ids_fuente".$n_condiciones});
if(${"arra_imgs_delete".$n_condiciones}){
foreach(${"arra_imgs_delete".$n_condiciones} as $imagen_del){
#echo "__../../imgs/".$imagen_del."<br>";
if(!in_array($imagen_del, $arra_def_del_images)){ 
	$arra_def_del_images[]=$imagen_del;
	$img_delete_url[]=$url_path.$imagen_del;
}
if(!in_array(str_replace("mm", "zz", $imagen_del), $arra_def_del_images)){
  $arra_def_del_images[]=str_replace("mm", "zz", $imagen_del);
  $img_delete_url[]=$url_path.str_replace("mm", "zz", $imagen_del);
}//if
}//foreach
}//if
}
}//for
if(is_array($img_delete_url)){
/*
for($imagen_borrar=0; $imagen_borrar<count($arra_def_del_images); $imagen_borrar++){
#@unlink($img_delete_url[$imagen_borrar].$arra_def_del_images[$imagen_borrar]);
$imagenes_borrar_mensaje.=$img_delete_url[$imagen_borrar].$arra_def_del_images[$imagen_borrar]."<br>";
}
*/
foreach($img_delete_url as $img_del){
@unlink($img_del);
$imagenes_borrar_mensaje.="DEF_BORRAR".$img_del."<br>";
}
}
/*
0000000000000 tablas secundarias borrar_end

*/
if(!$cambio_no_autorizado)
foreach($this->sql_mod_update as $valor){
$i++;
if($valor[1]) $datos_fuente="conecto_central"; else $datos_fuente="conecto_datos";
$valor=$valor[0];
$tabla_sec_mensaje.=$datos_fuente." --- ". $valor."<br>";
$this->$datos_fuente->query($valor);
}//foreach
#die();

// coordinadora funcion para insertar nuevos usuarios desde tabla entidades con las confguraciones de registro_00, registro_01
if(!$cambio_no_autorizado and $this->seccion=='c_38'){
$this->conecto_central->query("delete from registro_00 where id_registro_00=".$_POST[id_registro_00]);
$this->conecto_central->query("delete from registro_01 where registro_01_id_registro_00=".$_POST[id_registro_00]);
}
// FIN coordinadora funcion para insertar nuevos usuarios desde tabla entidades con las confguraciones de registro_00, registro_01


if($this->depurar_gestion_del)$this->depurar_mensaje("<b>borrado de tablas secundarias:</b><br>".$tabla_sec_mensaje);
if($this->depurar_gestion_del)$this->depurar_mensaje("<b>borrado de im&aacute;genes:</b><br>".$imagenes_borrar_mensaje);
if($this->depurar_gestion_del)$this->depurar_mensaje("link: <a href='index.php'>indice</a>");

if($_POST[PHPSESSID])$sesid="?PHPSESSID=".$_POST[PHPSESSID];
if(!$this->depurar_gestion_del && !$cambio_no_autorizado && $_POST['actualizar']=='go'){header("location: index.php?$sesid");die();}
}else{ # if $_POST['accion']
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
           ELSE if($_POST['actualizar']
           $ids_valores_multiple
           $valor_id
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
#foreach($arra_selects_valores_multiple as $val) echo $val."<br>";
if($arra_selects_valores){
#echo "<h2>".str_replace("[*]", implode(", ", $arra_selects_valores), $this->sql_mod.$this->id_seccion_value)."</h2>";
if($this->datos_fuente) $datos_fuente="conecto_central"; else  $datos_fuente="conecto_datos";
$this->$datos_fuente->query(str_replace("[*]", implode(", ", $arra_selects_valores), $this->sql_mod.$this->id_seccion_value));

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
if(!$url_ref or substr($url_ref,0,5)=='index')  {
if(@in_array($valor ,$arra_imgs)) $this->upload->aplicar_sesiones_t_archivo($valor.$multiple, $this->$datos_fuente->Record[$valor]);
}//if
    }//foreach
}//while $this->conecto_datos->next_record()
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
#$campo_trad=str_replace("'", "", $valor_0[1]);
$campo_trad=$valor[7];
$tipo_argumentos=$valor[4];
if($tipo_carga_datos =='consulta') $argumentos=$tipo_argumentos;
elseif($tipo_carga_datos =='array'){
$arra_database='';
if(strrchr($valor[4],";")) eval(str_replace('_idioma', '_'.$this->idioma_traduccion, $valor[4]));
if($arra_database)$valor[4]=$arra_database;
$argumentos=$valor[4];
}elseif($tipo_carga_datos =='sql' && $tipo_campo=='select'){
$arra_database='';
if(substr($valor[4],0,5)=='join@'){
 $array_join=explode("@", $valor[4]);
    $valor[4]= $array_join[2];
 }else{
 $array_join=null;
 }//if joni@

    if(strrchr($valor[4],";")) eval(str_replace('_idioma', '_'.$this->idioma_traduccion, $valor[4]));
    if($arra_database)$valor[4]=$arra_database;
#echo "<h2>".$valor[4][0]."</h2>";

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

}//array_join

    $this->$datos_fuente->query($valor[4][0]);
    $arra_prov=array();
    if($valor[4][1]=='blanco')
        $this->addArray($arra_prov, '', '');
    while($this->$datos_fuente->next_record())
    $this->addArray($arra_prov, $this->$datos_fuente->Record[visible], $this->$datos_fuente->Record[invisible]);
    $argumentos[0]=$arra_prov;
}
for($i=1; $i<5;$i++)
if($id_zona=="zona$i")$this->{"zona$i"}[]=array($id_campo, $campo_trad ,$tipo_campo, $tipo_carga_datos, $argumentos, $campo_multiple); 
}
#$this->conecto_datos->query(str_replace("[*]", implode(", ", $this->arra_campos), $this->sql_mod.$this->id_seccion_value));
#$info_del.=$this->conecto_datos->mostrar_esquema_consulta(100);
#$info_del.=$this->documento_gestion->abrir_tabla_modulo('100%', 50,"left");//($ancho,$alto, $alinear_tabla="left")
#$info_del.=$this->documento_gestion->abrir_tabla_info('100%', 50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)

#$arra_prueba=array("hola"=>"hola mensaje de texto", "adios"=>"mensaje de texto de adios");
/*
####
####	TRADUCCIONES
####
#$info_del.="traduccion: ".$this->conecto_central->traduccion['prueba2']."<hr>";
*/
#$info_del.=str_replace("[*]", implode(", ", $this->arra_campos), $this->sql_mod)."<hr>";
$info_del.="<form method='post' name='gestion'>";
#$this->conecto_datos->next_record();
#echo "<hr>".$this->conecto_datos->Record[]
$info_del.=$this->navega_sup_info."<br><br>\n\n\n<table border=0 width='500' height='100%' cellspacing=2 cellpadding=5 bgcolor='#CCCCCC'>";
/* $info_del.= "<tr class='bg_color_0'> <td colspan='2' align='left' valign='bottom' class='bg_color_8'>".$this->navega_sup_info."</td></tr>";*/

for($i=1; $i<5;$i++){
if($i==1 or $i==3){
    if(count($this->{"zona".$i}) and !count($this->{"zona".($i+1)}) )
    $info_del.="\n\n\n<tr><td colspan=2 valign='top' align='left' class='bg_color_0'>";
    elseif(count($this->{"zona".$i}) and count($this->{"zona".($i+1)}))
    $info_del.="\n\n\n<tr><td valign='top' align='left' class='bg_color_0'>";
}elseif($i==2 or $i==4){
    if(count($this->{"zona".$i}) and !count($this->{"zona".($i-1)}) )
    $info_del.="\n\n\n<tr><td colspan=2 valign='top' align='left' class='bg_color_0'>";
    elseif(count($this->{"zona".$i}) and count($this->{"zona".($i-1)}))
    $info_del.="\n\n\n<td valign='top' align='left' class='bg_color_0'>";
}
if(is_array($this->{"zona$i"}))
foreach($this->{"zona$i"} as $valor){

#$info_del.= "<b>zona$i</b> $valor[0] $valor[1] $valor[2] $valor[3]";
##
##	000 aqui se sustituye el valor visible del campo por su traduccion, si el primer caracter es una '*'
##
$valor_trad=$valor[1];
if($valor_trad[0]=='*') $valor_trad=$this->conecto_central->traduccion[substr($valor_trad,1)];
if($valor[5]){
${"arra_val".$i}[]=array($valor[0], $valor_trad, $valor[2], $valor[3], $valor[4]);
#foreach($ids_valores_multiple as $id_m)
#$info_del.="<b>zona$i </b>".$this->select_tipo_campo($valor[0].$id_m, $valor_trad.$id_m, $valor[2], $valor[3], $valor[4])."<br>";
}else
$info_del.="\n".$this->select_tipo_campo($valor[0], $valor_trad, $valor[2], $valor[3], $valor[4])."<br>";
}//foreach
if(is_array(${"arra_val".$i})){
foreach($ids_valores_multiple as $id_m){
$o++;
foreach(${"arra_val".$i} as $vol){
#echo $vol[0]."<br>";
$info_del.="\n".$this->select_tipo_campo($vol[0].$id_m, $vol[1].$o, $vol[2], $vol[3], $vol[4])."<br>\n";
}//foreach
}//foreach
}//if
if($i==1 or $i==3){
    if(count($this->{"zona".$i}) and !count($this->{"zona".($i+1)}) )
    $info_del.="</td></tr>\n\n\n";
    elseif(count($this->{"zona".$i}) and count($this->{"zona".($i+1)}))
    $$info_del.="</td>\n\n\n";
}elseif($i==2 or $i==4){
    $info_del.="</td></tr>\n\n\n";
}
}//for
if(is_array($alarma_eliminacion_tablas_sec)){
$info_del.="<tr><td colspan=2 bgcolor='yellow'>";
$boton_eliminar=$this->conecto_central->traduccion[gest_eliminar_alarma];
foreach($alarma_eliminacion_tablas_sec as $valor_alarma)
$info_del.="<img src='../images/00_alerta.gif'> ".$valor_alarma."<br>";
$info_del.="</td></tr>";
}else{
$boton_eliminar=$this->conecto_central->traduccion[gest_eliminar];
}
$info_del.="<tr><td colspan=2 class='bg_color_0' align='center'>
<input type='button' name='volver' value='".$this->conecto_central->traduccion[gest_volver_listado]."' onclick=\"javascript:window.self.document.location='index.php';\">
<input type='hidden' value='' name='actualizar'><input type='button' name='modificar' value='$boton_eliminar' onclick=\"javascript:window.self.document.forms[0]['actualizar'].value='go';window.self.document.forms[0].submit();\"></td></tr></table></form>";

#$info_del.=$this->documento_gestion->cerrar_tabla_info('100%', 50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
#$info_del.=$this->documento_gestion->cerrar_tabla_modulo('100%', 50);
$this->conecto_datos->cerrar_conexion();


return $this->documento_gestion->modulo($info_del);
}//if $_POST['accion']==enviar
}//function pagina_del
}//class
?>
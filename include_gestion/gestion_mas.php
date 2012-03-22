<?php
require_once("gestion.php");
class gestion_mas extends gestionar{

function pagina_mas(){
if($_GET[valor_multiple])$valor_multiple=$_GET[valor_multiple];
elseif($_POST[valor_multiple])$valor_multiple=$_POST[valor_multiple];
$query_ini="select * from dato_tabla
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla)
left join seccion_00 on (dato_tabla.dato_tabla_id_seccion_00=seccion_00.id_seccion_00)
where id_seccion_00=".$this->id_seccion;
$this->conecto_central->query($query_ini);
if($this->depurar_gestion_mas) $this->depurar_mensaje("<b>".$this->conecto_central->Host."/".$this->conecto_central->Database."</b><br><b>CONSULTA LISTADO: </b>".$query_ini);
while($this->conecto_central->next_record()){
$consulta=$this->conecto_central->Record[seccion_00_sql_select_mod_del];
$this->datos_fuente=$this->conecto_central->Record[datos_central];
if($this->conecto_central->Record[tabla_multiple] && $this->conecto_central->Record[dato_campo_tipo]=='referencia') $valor_id=$this->conecto_central->Record[dato_campo];
elseif($this->conecto_central->Record[tabla_multiple]) $camp[]=$this->conecto_central->Record[dato_campo];
}//while
#foreach($camp as $valor) echo "<h5>valor_id= $valor_id ".$valor."</h5>";

#die();
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
MAS
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/

$this->conecto_central->query("select * from dato_tabla
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla)
left join seccion_00 on (dato_tabla.dato_tabla_id_seccion_00=seccion_00.id_seccion_00)
where id_seccion_00=".$this->id_seccion." order by dato_campo_orden desc");
while($this->conecto_central->next_record()){
if(!$this->conecto_central->Record[dato_campo_idioma] or ($this->conecto_central->Record[dato_campo_idioma] && (@in_array(substr($this->conecto_central->Record[dato_campo], -3), $this->traduce)) or  substr($this->conecto_central->Record[dato_campo], -3)==$this->idioma_traduccion)){
if(!@in_array(substr($this->conecto_central->Record[dato_campo], -3), $this->traduce) and substr($this->conecto_central->Record[dato_campo], -9,6)=="check_")
continue;
if($this->conecto_central->Record["dato_campo_trad_".$this->idioma_traduccion]) $this->conecto_central->Record[dato_campo_trad]=$this->de_html($this->conecto_central->Record["dato_campo_trad_".$this->idioma_traduccion]);
    if($this->conecto_central->Record[dato_campo_mod]) {
    if($this->conecto_central->Record[dato_campo_join]){
$this->arra_campos_mod[]=array(
$this->conecto_central->Record[dato_campo]." as '".$this->conecto_central->Record[dato_campo_trad]."'",
 array("zona".$this->conecto_central->Record[dato_campo_zona], 'tabla'.$this->conecto_central->Record[dato_campo_ntabla]),
  $this->conecto_central->Record[dato_campo_tipo],
   $this->conecto_central->Record[dato_campo_forma_carga],
    "join@".$this->conecto_central->Record[dato_campo_join]."@".$this->conecto_central->Record[dato_campo_valor],
	         $this->conecto_central->Record[dato_campo_html],
			 $this->conecto_central->Record[tabla_multiple],
$this->conecto_central->Record[dato_campo_lugar_carga],
		$this->conecto_central->Record[dato_campo_trad]
);
}else{

                    #echo $this->conecto_central->Record[dato_campo]." ".$this->conecto_central->Record[dato_campo_mod]."<hr>";
        $this->arra_campos_mod[]=array(
        $this->conecto_central->Record[dato_campo]." as '".$this->conecto_central->Record[dato_campo_trad]."'", 
        array("zona".$this->conecto_central->Record[dato_campo_zona], "tabla".$this->conecto_central->Record[dato_campo_ntabla]), 
        $this->conecto_central->Record[dato_campo_tipo], 
        $this->conecto_central->Record[dato_campo_forma_carga], 
        $this->conecto_central->Record[dato_campo_valor],
        $this->conecto_central->Record[dato_campo_html],
        $this->conecto_central->Record[tabla_multiple],
        $this->conecto_central->Record[dato_campo_lugar_carga],
		$this->conecto_central->Record[dato_campo_trad]
        
        );
        }
    }//if dato_campo_mod
            if($this->conecto_central->Record[dato_campo_id_seccion] OR $this->conecto_central->Record[dato_campo_id_seccion_mod]){
            if($this->conecto_central->Record[dato_campo_id_seccion] ){ 
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
            }//if html
       }//if [dato_campo_id_seccion_mod] OR [dato_campo_id_seccion]

}//if idioma
}//while




/*
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
MAS
            AQUI SE CREA EL ARRAY DE ACTUALIZACIONES DE INSERT VARIAS TABLAS  sql_mod_update    
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
*/

$this->conecto_central->query("select * from dato_sql_act_mod 
left join seccion_00 on (dato_sql_act_mod.dato_sql_act_mod_id_seccion_00=seccion_00.id_seccion_00)
where id_seccion_00=".$this->id_seccion);
while($this->conecto_central->next_record()){
$j++;
$this->sql_mas_update[]=array(
$this->conecto_central->Record[dato_sql_act_insert], 
$this->conecto_central->Record[datos_central]);

}

/*
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
MAS
                    array de condiciones

0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
*/

$this->conecto_central->query("select * from dato_sql_condicion 
left join seccion_00 on (dato_sql_condicion_id_seccion_00=id_seccion_00)
where id_seccion_00=".$this->id_seccion." and dato_sql_condicion_tipo='insertar_modificar'");
while($this->conecto_central->next_record()){
$j=$this->conecto_central->Record[dato_sql_condicion_ntabla];
$this->sql_mas_condicion[]=array($this->conecto_central->Record[dato_sql_condicion]." where ".implode(" and ", ${"mod_tabla".$j}), $this->conecto_central->Record[dato_sql_condicion_alarma_esp], $this->conecto_central->Record[datos_central]);
#echo $this->conecto_central->Record[dato_sql_condicion]." where ".implode(" and ", ${"mod_tabla".$j})."<hr>";
}//while



if($this->mostrar_variables) $info_mas.=$this->info_registro_indice;
/*
    Comienza analisis de arra_campos_mod:
        1. se genera la consulta de seleccion inicial
        2. tipos de campo: select, text, radio ...
        3. se define la estructura de la pagina en 4 zonas, reticula de 4 celdas
        
*/
## 
##	$arra_imgs ---> array con nombres de campos de imagenes
##	$arra_selects_valores ---> array con nombres de campo de la seleccion inicial sql
##	$tabla1, $tabla2 ... se agrupan los valores en funcion de la consulta
## 
foreach($this->arra_campos_mod as $valor){
$valor_0=explode(" as ", $valor[0]);
#if($valor[6])
#for($j=1;$j<=$valor_multiple;$j++)
#echo "<h5 style='color:red'>".$valor_0[0].$j."=".$_POST[$valor_0[0].$j]."</h5>";
#echo "<h5 style='color:red'>".$valor[2]."</h5>";
 if($valor[2]=='img' or $valor[2]=='doc') $arra_imgs[]=$valor_0[0];
  $arra_selects_valores[]=$valor_0[0];
  if(substr($valor[1][1],0, 4)<>'tabla'){
  ${$valor[1][1]."_campos"}[]=$valor_0[0];
 if($valor[2]=='LAST_INSERT_ID()') ${$valor[1][1]."_valores"}[]="LAST_INSERT_ID()";
 elseif($valor[2]=='directo')  ${$valor[1][1]."_valores"}[]="'".$valor[3]."'";
  else{
  if(!$valor[6]){
    if(!$valor[5]){
  ${$valor[1][1]."_valores"}[]="\"".$_POST[$valor_0[0]]."\"";
}  else{
    ${$valor[1][1]."_valores"}[]="\"".$this->a_html($_POST[$valor_0[0]])."\"";
  }//if !valor[5] de_html
  }else{//valor[6]
    for($j=1;$j<=$valor_multiple;$j++){
    if($valor[2]=='LAST_INSERT_ID()' )
        ${$valor[1][1]."_valores".$j}[]="LAST_INSERT_ID()";
    else
        if(!$valor[5]){
        ${$valor[1][1]."_valores".$j}[]="\"".$_POST[$valor_0[0].$j]."\"";
        }  else{
        ${$valor[1][1]."_valores".$j}[]="\"".$this->a_html($_POST[$valor_0[0].$j])."\"";
        }//if !valor[5]
    }//for
  }//if valor[6]
  }
  }
}//foreach
#  foreach($arra_selects_valores as $valor)    echo "<h5 style='color:red'>". $valor."</h5>";
#foreach($mod_tabla1 as $valor)    echo "<h5 style='color:green'>". $valor."</h5>";

/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
            if($_POST['actualizar']
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
if($_POST['actualizar']){
#foreach($tabla0 as $clave) echo "$clave<hr>";
if(is_array($this->sql_mas_condicion))
foreach($this->sql_mas_condicion as $valor){
#echo $valor[0]."<br>";
if($valor[2]) $datos_fuente="conecto_central"; else $datos_fuente="conecto_datos";
$this->$datos_fuente->query($valor[0]);
if($this->$datos_fuente->record_count){
$cambio_no_autorizado[]=$valor[1];
echo $valor[0]."<br>".$valor[1]."<br>";
}
}//foreach
if($cambio_no_autorizado) die("error");
if(!$valor_multiple){
foreach($this->sql_mas_update as $valor){
if($valor[1]) $datos_fuente="conecto_central"; else $datos_fuente="conecto_datos";
$i++;
$consulta=str_replace("[*]", implode(", ", ${"tabla".$i."_campos"}), $valor[0]);
$consulta=str_replace("[+]", implode(", ", ${"tabla".$i."_valores"}), $consulta);
#echo $datos_fuente.$consulta."<hr>";
if($this->depurar_gestion_mas) $this->depurar_mensaje("oooo".$consulta);
$this->$datos_fuente->query($consulta);
}//foreach
}else{//$valor_multiple
if($this->sql_mas_update[0][1]) $datos_fuente="conecto_central"; else $datos_fuente="conecto_datos";
$con1=$this->sql_mas_update[0][0];
$consulta=str_replace("[*]", implode(", ", ${"tabla1_campos"}), $con1);
$consulta=str_replace("[+]", implode(", ", ${"tabla1_valores"}), $consulta);

if($this->depurar_gestion_mas) $this->depurar_mensaje("eeee".$consulta);

$this-> $datos_fuente->query($consulta);
$this-> $datos_fuente->query("select LAST_INSERT_ID() as last");
$this-> $datos_fuente->next_record();
$last=$this->$datos_fuente->Record[last];

#echo "$last multiple".$datos_fuente." ".$consulta;

if($this->sql_mas_update[1][1]) $datos_fuente="conecto_central"; else $datos_fuente="conecto_datos";
$con2=$this->sql_mas_update[1][0];
for($j=1;$j<=$valor_multiple;$j++){
$consulta=str_replace("[*]", implode(", ", ${"tabla2_campos"}), $con2);
#echo "<br>".$consulta."<br>";
$consulta=str_replace("[+]", implode(", ", ${"tabla2_valores".$j}), $consulta);
#echo "<br>".$consulta."<br>";

$consulta=str_replace("last_insert_id()", $last, $consulta);
#echo "<br>".$consulta."<br>";

$this-> $datos_fuente->query($consulta);
if($this->depurar_gestion_mas) $this->depurar_mensaje($consulta);
}

}
// coordinadora funcion para insertar nuevos usuarios desde tabla entidades con las confguraciones de registro_00, registro_01
if(!$cambio_no_autorizado and $this->seccion=='c_38'){
$this->conecto_central->query("insert into registro_00(user, password, idioma, traduce_1, zona_gestion_registro) values ('".$_POST[user_entidad]."', '".$_POST[pw_entidad]."', 'cat', 'esp', 3)");
$this->conecto_central->query("select LAST_INSERT_ID() as last");
$this->conecto_central->next_record();
$last=$this->conecto_central->Record[last];
$this-> conecto_datos->query("
update entidad set id_registro_00=$last where user_entidad='".$_POST[user_entidad]."' and  pw_entidad='".$_POST[pw_entidad]."'
");
$arra_id_secciones=array(39,40,46, 47, 49, 50, 52, 53, 54, 86, 88, 89);
foreach($arra_id_secciones as $valor_id)
$this->conecto_central->query("insert into registro_01(registro_01_id_registro_00, registro_01_id_seccion_00) values ($last,  $valor_id)");
}
// FIN coordinadora funcion para insertar nuevos usuarios desde tabla entidades con las confguraciones de registro_00, registro_01

if($this->depurar_gestion_mas) die("link: <a href='index.php'>indice</a>");
if($_POST[PHPSESSID])$sesid="?PHPSESSID=".$_POST[PHPSESSID];
if(!$cambio_no_autorizado){header("location:index.php$sesid");die();}
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000
           ELSE ($_POST['actualizar']
00000000000000000000000000000000000000000000000000000000000000000000000000000
*/
}else{ # if $_POST['accion']
        $url_ref=array_reverse(explode('/', $_SERVER['HTTP_REFERER']));
        $url_ref=$url_ref[0];
if($arra_selects_valores){
    foreach($arra_selects_valores as $valor){
    if(@in_array($valor ,$arra_imgs)){
    if(!$url_ref or substr($url_ref,0,5)=='index' or $url_ref==''){
        if(@in_array($valor, $camp)) 
        for($nn=1; $nn<=$_GET[valor_multiple];  $nn++)
        $this->upload->aplicar_sesiones_t_archivo($valor.$nn, '');
        else
            $this->upload->aplicar_sesiones_t_archivo($valor, '');
    }//if
    }//if in_array
    }//foreach
}//if $arra_selects_valores
foreach($this->arra_campos_mod as $valor){
$campo_multiple=$valor[6];
$campo_select=$valor[0];
$id_zona=$valor[1][0];
$tipo_campo=$valor[2];
 #echo "$tipo_campo <hr>";

$tipo_carga_datos=$valor[3];
$this->arra_campos[]= $campo_select;
$valor_0=explode(" as ", $campo_select);
$id_campo=$valor_0[0];
#$campo_trad=str_replace("'", "", $valor_0[1]);
$campo_trad=$valor[8];

$tipo_argumentos=$valor[4];
if($tipo_carga_datos =='consulta') $argumentos=$tipo_argumentos;
elseif($tipo_carga_datos =='variable'){ 
$argumentos=$this->{$valor[4]};
$tipo_carga_datos='directo';
}elseif($tipo_carga_datos =='array'){ 
if(strrchr($valor[4],";")) eval(str_replace('_idioma', '_'.$this->idioma_traduccion, $valor[4]));
if($arra_database)$valor[4]=$arra_database;
$argumentos=$valor[4];
}elseif($tipo_carga_datos =='directo') $argumentos=$valor[4];
elseif($tipo_carga_datos =='sql' && $tipo_campo=='select'){
$argumentos=array();
$arra_database='';
        if(substr($valor[4],0,5)=='join@'){
        #echo "JOIN<hr>";
        $array_join=explode("@", $valor[4]);
            $valor[4]= $array_join[2];
        }else{
        $array_join=null;
        }//if join
    if(strrchr($valor[4],";")) eval(str_replace('_idioma', '_'.$this->idioma_traduccion, $valor[4]));
    if($arra_database)$valor[4]=$arra_database;
    if($array_join){
 if(strstr($valor[4][0], "where")) {
  $consulta_join= " and ".$array_join[1]."=".$_SESSION["sqls"][$this->pack_name][$this->seccion][$array_join[1]] ;
  }else{
  $consulta_join=" where ".$array_join[1]."=".$_SESSION["sqls"][$this->pack_name][$this->seccion][$array_join[1]] ;
 }//if where
  if(strstr($valor[4][0], "order"))
  $valor[4][0]=str_replace("order", $consulta_join." order", $valor[4][0]);
  else
  $valor[4][0].= $consulta_join;
}//if($tipo_carga_datos =='sql' && $tipo_campo=='select')
#echo $valor[4][0];
if($this->datos_fuente) $datos_fuente="conecto_central"; else $datos_fuente="conecto_datos";
        if($valor[4][2]) $datos_fuente=$valor[4][2];
    $this->$datos_fuente->query($valor[4][0]);
#echo $datos_fuente."<hr>".$valor[4][0];
    $this->$datos_fuente->query($valor[4][0]);
    #echo "<br>".$this->conecto_datos->record_count;
    $arra_prov=array();
    if($valor[4][1]=='blanco')
        $this->addArray($arra_prov, '', '');
    while($this->$datos_fuente->next_record()){
    $this->addArray($arra_prov, $this->$datos_fuente->Record[visible], $this->$datos_fuente->Record[invisible]);
    }//while
    $argumentos[0]=$arra_prov;
}
for($i=1; $i<5;$i++){
if($id_zona=="zona$i")$this->{"zona$i"}[]=array($id_campo, $campo_trad ,$tipo_campo, $tipo_carga_datos, $argumentos, $campo_multiple); 
}//for
}
#$this->conecto_datos->query(str_replace("[*]", implode(", ", $this->arra_campos), $this->sql_mod.$this->id_seccion_value));
#$info_mas.=$this->conecto_datos->mostrar_esquema_consulta(100);
#$info_mas.=$this->documento_gestion->abrir_tabla_modulo('100%', 50,"left");//($ancho,$alto, $alinear_tabla="left")
#$info_mas.=$this->documento_gestion->abrir_tabla_info('100%', 50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)

#$arra_prueba=array("hola"=>"hola mensaje de texto", "adios"=>"mensaje de texto de adios");
/*
####
####	TRADUCCIONES
####
#$info_mas.="traduccion: ".$this->conecto_central->traduccion['prueba2']."<hr>";
*/
#$info_mas.=str_replace("[*]", implode(", ", $this->arra_campos), $this->sql_mod)."<hr>";
$info_mas.="<form method='post' name='gestion'>";
#$this->conecto_datos->next_record();
#echo "<hr>".$this->conecto_datos->Record[]
$info_mas.=$this->navega_sup_info."<br><br>\n\n\n<table border=0 width='500' height='100%' cellspacing=2 cellpadding=5 bgcolor='#CCCCCC'>";
#$info_mas.= "<tr class='bg_color_0'>
# <td colspan='2' align='left' valign='bottom' class='bg_color_8'>".$this->navega_sup_info."</td></tr>";

for($i=1; $i<5;$i++){
if($i==1 or $i==3){
    if(count($this->{"zona".$i}) and !count($this->{"zona".($i+1)}) )
    $info_mas.="\n\n\n<tr><td colspan=2 valign='top' align='left' class='bg_color_0'>";
    elseif(count($this->{"zona".$i}) and count($this->{"zona".($i+1)}))
    $info_mas.="\n\n\n<tr><td valign='top' align='left' class='bg_color_0'>";
}elseif($i==2 or $i==4){
    if(count($this->{"zona".$i}) and !count($this->{"zona".($i-1)}) )
    $info_mas.="\n\n\n<tr><td colspan=2 valign='top' align='left' class='bg_color_0'>";
    elseif(count($this->{"zona".$i}) and count($this->{"zona".($i-1)}))
    $info_mas.="\n\n\n<td valign='top' align='left' class='bg_color_0'>";
}
if(is_array($this->{"zona$i"}))
foreach($this->{"zona$i"} as $valor){
#$info_mas.= "<b>zona$i</b> $valor[0] $valor[1] $valor[2] $valor[3]";
##
##	000 aqui se sustituye el valor visible del campo por su traduccion, si el primer caracter es una '*'
##
$valor_trad=$valor[1];
if($valor_trad[0]=='*') $valor_trad=$this->conecto_central->traduccion[substr($valor_trad,1)];
if($valor[5]){
#$info_mas.="\n<b>zona$i</b>".$this->select_tipo_campo($valor[0].$j, $valor_trad.$j, $valor[2], $valor[3], $valor[4])."<br>\n";
${"arra_val".$i}[]=array($valor[0], $valor_trad, $valor[2], $valor[3], $valor[4]);
}else{
if($valor[2]<>"hidden" and $valor[2]<>"last_insert" and $valor[2]<>"referencia") $br="<br>"; else $br='';
$info_mas.="\n".$this->select_tipo_campo($valor[0], $this->a_html($valor_trad), $valor[2], $valor[3], $valor[4]).$br."\n";
}//if
}//foreach
if(is_array(${"arra_val".$i})){
for($j=1;$j<=$valor_multiple;$j++)
foreach(${"arra_val".$i} as $vol){
#echo $vol[0]."<br>";
    if($vol[2]<>"hidden" and $vol[2]<>"last_insert" and $vol[2]<>"referencia") $br="<br>"; else $br='';
$info_mas.="\n".$this->select_tipo_campo($vol[0].$j, $this->a_html($vol[1]).$j, $vol[2], $vol[3], $vol[4]).$br."\n";
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
$info_mas.="<tr><td colspan=2 class='bg_color_0' align='center'>";
if($valor_multiple) $info_mas.="<input type='hidden' value='$valor_multiple' name='valor_multiple'>";
$info_mas.="
<input type='button' name='volver' value='".$this->conecto_central->traduccion[gest_volver_listado]."' onclick=\"javascript:window.self.document.location='index.php';\">
<input type='hidden' value='' name='actualizar'><input type='button' name='modificar' value='".$this->conecto_central->traduccion[gest_incluir]."' onclick=\"javascript:window.self.document.forms[0]['actualizar'].value='go';window.self.document.forms[0].submit();\"></td></tr></table></form>";

#$info_mas.=$this->documento_gestion->cerrar_tabla_info('100%', 50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
#$info_mas.=$this->documento_gestion->cerrar_tabla_modulo('100%', 50);
$this->conecto_central->cerrar_conexion();


return $this->documento_gestion->modulo($info_mas);
}//if $_POST['accion']==enviar
}//function pagina_mas



}//class
?>
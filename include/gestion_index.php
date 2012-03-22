<?php
require_once("gestion.php");
class gestion_index extends gestionar{
var $sql_indice='';
var $id_seccion='';
var $array_campos='';
var $array_usabilidad='';

function indice(){
/*
00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
$this->arra_campos(campo_sql, campo_esp, campo_tipo, ¬ølista_indice?) mirar si tabla es multiple  y 
00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
*/
$query_00="select 
dato_campo_indice, dato_campo_idioma, dato_campo, dato_campo_valor, dato_campo_trad_".$this->idioma_traduccion.", dato_campo_tipo, dato_campo_lista_indice, tabla_multiple, seccion_00_sql_select_index, datos_central, seccion_filtrada_id_registro_00
from dato_tabla
left join dato_campo on (dato_tabla.id_dato_tabla=dato_campo.dato_campo_id_tabla)
left join seccion_00 on (dato_tabla.dato_tabla_id_seccion_00=seccion_00.id_seccion_00)
where id_seccion_00='".$this->id_seccion."'  order by id_dato_campo";
$this->conecto_central->query($query_00);
if($this->depurar_gestion) $this->depurar_mensaje("<b>".$this->conecto_central->Host."/".$this->conecto_central->Database."</b><br><b>CONSULTA LISTADO: </b>".$query_00);
if(!$this->conecto_central->record_count) die("<br><br><br>Secci&oacute;n no disponible <a href='../c_99/'>Volver a men&uacute; principal </a>");
while($this->conecto_central->next_record()){
extract($this->conecto_central->Record);
#00
#00	condicion para que aparezcan los campos de idioma unicamente 
#00	cuando coincida el campo con el idioma de traduccion
#00	o todos los campos que no sean idioma 
#00	y que aparezcan en datos central como listados en el indice
#00
if(!$dato_campo_idioma or ($dato_campo_idioma && substr($dato_campo, -3)==$this->idioma_traduccion)){
/*
0000000000000000000000000000000000000000000000000000
    SEMI EXCEPCION 1
personalizar listado en funcion de 
    campos que son arrays
0000000000000000000000000000000000000000000000000000
*/ 
    # convierte a html el campo
    if(${"dato_campo_trad_".$this->idioma_traduccion}) $dato_campo_trad=$this->de_html(${"dato_campo_trad_".$this->idioma_traduccion});
    else $dato_campo_trad=$dato_campo;
    if($dato_campo_lista_indice or $dato_campo_indice)
	$this->arra_campos[]=array(
		$dato_campo." as '".$dato_campo_trad."'", 
		$dato_campo, 
		$dato_campo_trad, 
		$dato_campo_tipo, 
		$dato_campo_lista_indice
	);
    ${"dato_campo_trad_".$this->idioma_traduccion}=null;
# eliminar    if($dato_campo_id_seccion){ $this->id_seccion[]=$dato_campo; echo "<h3>$dato_campo</h3>";}
     if(strrchr($dato_campo_valor,";")) {
        $arra_database=null;
        $i++;
        eval($dato_campo_valor);
        ${${"dato_campo_trad_".$this->idioma_traduccion}."_array"}=array_flip($arra_database);
    }//if
if($tabla_multiple){ $multiple_menu_mas=true;
#echo "MULTIPLE<hr>";
}
}//if dato_campo_idioma or !dato_campo_idioma
}//while
$this->sql_indice=$seccion_00_sql_select_index;
$this->datos_central_fuente=$datos_central;
/*
0000000000000000000000000000000000000000000000000000
    personalizar listado en funcion de variable id_registro_00 ej: agenda de coordinadora frente a agenda de entidad
0000000000000000000000000000000000000000000000000000
*/
if($seccion_filtrada_id_registro_00)
 if(strstr($this->sql_indice, "where")) 
 $this->sql_indice=str_replace("where"," where id_registro_00=".$this->id_registro_00." and ", $this->sql_indice);
else
$this->sql_indice.=" where id_registro_00=".$this->id_registro_00;
/*
0000000000000000000000000000000000000000000000000000
dato usable seleccion
0000000000000000000000000000000000000000000000000000
*/
$this->conecto_central->query("select dato_imagen_gestion, dato_usable_link, dato_usable_info_".$this->idioma_traduccion.", ventana_propia  from dato_usable 
right join dato_imagen_gestion on (id_dato_imagen_gestion=dato_usable_id_dato_imagen_gestion)
left join seccion_00 on (dato_usable_id_seccion=seccion_00.id_seccion_00)
where id_seccion_00='".$this->id_seccion."'   order by id_dato_usable");
while($this->conecto_central->next_record()){
extract($this->conecto_central->Record);
$this->array_usabilidad[]=array($dato_imagen_gestion, $dato_usable_link, ${"dato_usable_info_".$this->idioma_traduccion}, $ventana_propia);
}//while
/*
0000000000000000000000000000000000000000000000000000
    Comienza analisis de arra_campos:
        1. se genera la consulta de seleccion inicial
        2. en funcion de tipos de campo: select, text, radio, password se visualiza la informacion o se procede a realizar filtrados
        3. los tipos de radio se hace por igualdad y no por concordancia
        4. los tipos de textarea hacer una seleccion hasta el primer punto...
        5. if crear variables de objeto vale para el tema de las traducciones y sobreescribe el arra de campos
0000000000000000000000000000000000000000000000000000
*/
foreach($this->arra_campos as $valor){
$se_lista=$valor[4];

    $arra_consulta[]=$valor[0];
#    if($valor[3]<>'hidden') $contaceldas++;
    if($valor[3]=='referencia'  ) $this->referencias_tabla[]=$valor[1];
    if($se_lista){$arra_selects_valores[]=$valor[1];$contaceldas++;}
       if($se_lista) $arra_selects_campos_valores[]=$valor[2];
    if($se_lista) $arra_tipos_campos[]=$valor[3];
}//foreach

/*
0000000000000000000000000000000000000000000000000000
    RELACION DE PERTENENCIA A PACKS ENTRE SECCIONES
0000000000000000000000000000000000000000000000000000
*/
if($_SESSION["sqls"][$this->pack_name][$this->seccion][$this->pack_id_name])
 $this->sql_indice=str_replace(" 1=1", " ".$this->pack_id_condicion."=".$_SESSION["sqls"][$this->pack_name][$this->seccion][$this->pack_id_name]." " , $this->sql_indice);
 
$this->sql_indice=str_replace("[*]", implode(", ", $arra_consulta), $this->sql_indice);

/*
0000000000000000000000000000000000000000000000000000

    AQUI SE CONSTRUYE LA CONSULTA O SELECCION 
    BASADO EN FILTRADO DE CAMPOS Y ORDENACION DE CAMPOS, 
    PAGINACION Y LIMITE DE REGISTROS

0000000000000000000000000000000000000000000000000000
*/
if($this->datos_central_fuente) $datos_fuente="conecto_central"; else $datos_fuente="conecto_datos";
/*
0000000000000000000000000000000000000000000000000000
    SEMI EXCEPCION 3
    
      una seleccion final basada en multiples selecciones  
      con un condicional para la seccion de traducciones

0000000000000000000000000000000000000000000000000000
*/

if(strrchr($this->sql_indice, ";")){
    $arra_consultas=explode(";", $this->sql_indice);
    for($n=0; $n<(count($arra_consultas)-2); $n++){
        $this->$datos_fuente->query($arra_consultas[$n]);
#		echo $arra_consultas[$n]."<br>";
    }//for

    if($this->seccion=="c_012" or $this->seccion=="c_013" or $this->seccion=="c_014" or $this->seccion=="c_017" or $this->seccion=="c_018")
        $this->sql_indice=$arra_consultas[$n];
    else
        $this->sql_indice=$arra_consultas[$n]." where ".$this->idioma_traduccion."<>''";
}//if se encuentra ";" en sql_indice

if(strstr($this->sql_indice, " where ")) $nexo_filtrar=" and "; else $nexo_filtrar= " where ";
if($this->filtrar<>null){
    $v=0;
    foreach($arra_selects_valores as $val){
        if($this->menu_filtrar<>$val) $v++; else $valor=$v;
    }//foreach
    if($arra_tipos_campos[$valor]=="radio"){
        if((int)$this->filtrar==0) $this->filtrar=0; else $this->filtrar=1;
        $this->sql_indice=$this->sql_indice.$nexo_filtrar.$this->menu_filtrar."=".$this->filtrar;
        }else{#if($arra_tipos_campos[$valor]=="text")
        $this->sql_indice= $this->sql_indice.$nexo_filtrar.$this->menu_filtrar." LIKE '%".$this->conecto_datos->a_html($this->filtrar)."%'";
    }//$arra_tipos_campos[$valor]=="radio"
}//if_$this->filtrar<>null


if(!$this->order_01) $order_01=" desc";
if($this->order_00) $this->sql_indice= $this->sql_indice." order by ".$this-> order_00.$order_01.""; 


$this->$datos_fuente->query($this->sql_indice);
$registros_totales=$this->$datos_fuente->record_count;
if(!$this->limite) $this->limite=10;
$limit=$this->limite;
$paginas_totales=(int)($registros_totales/$limit);
if($registros_totales%$limit) $paginas_totales++; 
        if($this->pagina_actual>$paginas_totales) $this->pagina_actual=$paginas_totales;
        elseif($this->pagina_actual<1) $this->pagina_actual=1;
if($this->pagina_actual>1){
    $this->$datos_fuente->seek((($this->pagina_actual)-1)*$limit);
    $inicial=(($this->pagina_actual)-1)*$limit;
    }else{
    $this->$datos_fuente->seek(0);
    $inicial=1;
}//if_$this->pagina_actual>1
$final=$inicial+($this->limite);
if($final>$registros_totales) $final=$registros_totales;

if($this->depurar_gestion) $this->depurar_mensaje("<b>".$this->$datos_fuente->Host."/".$this->$datos_fuente->Database."</b><br><b>CONSULTA LISTADO: </b>".$this->sql_indice);
$info_indice.=$this->documento_gestion->abrir_tabla_modulo('100%' ,50,"left");//($ancho,$alto, $alinear_tabla="left")
$info_indice.=$this->documento_gestion->abrir_tabla_info('100%',50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
$info_indice.= "\n\n<form action='$direct' method='GET' >";
$info_indice.= "\n\n<table border='0' cellspacing='1' cellpadding='5' width='100%'  bgcolor='#CCCCCC'>";
 $info_indice.= "<tr class='bg_color_0'>
 <td colspan='".($contaceldas +1)."' align='left' valign='bottom' class='bg_color_8'>".$this->navega_sup_info."</td></tr>";
/*
0000000000000000000000000000000000000000000000000000
    paginacion
0000000000000000000000000000000000000000000000000000
*/
 $info_indice.= "<tr class='bg_color_0'>";
  $info_indice.= "<td colspan='".($contaceldas +1)."' align='center' valign='bottom'>".$this->conecto_central->traduccion[gest_pag_act];
  if($this->pagina_actual<>1 and $this->pagina_actual) $info_indice.= "<a href='index.php?pagina_actual=1'><img src='../images/pag_first_01.gif'></a>";
  else   $info_indice.= "<img src='../images/pag_first_00.gif'>";
  if($this->pagina_actual>1) $info_indice.= "<a href='index.php?pagina_actual=".(($this->pagina_actual)-1)."'><img src='../images/pag_prev_01.gif'></a>";
  else   $info_indice.= "<img src='../images/pag_prev_00.gif'>";
  $info_indice.= "<input type='text' name='pagina_actual' value='$this->pagina_actual' size=2>";
        if($this->pagina_actual<$paginas_totales) $info_indice.= "<a href='index.php?pagina_actual=".(($this->pagina_actual)+1)."'><img src='../images/pag_next_01.gif'></a>";
  else   $info_indice.= "<img src='../images/pag_next_00.gif'>";
    if($this->pagina_actual<$paginas_totales) $info_indice.= "<a href='index.php?pagina_actual=$paginas_totales'><img src='../images/pag_last_01.gif'></a>";
  else   $info_indice.= "<img src='../images/pag_last_00.gif'>";
  $info_indice.= "&nbsp; ".$this->conecto_central->traduccion[gest_pag_disp]." $paginas_totales";
  $info_indice.= "</td></tr>"; 
/*
0000000000000000000000000000000000000000000000
filtrado de registros
0000000000000000000000000000000000000000000000
*/
$info_indice.= "<tr class='bg_color_0'>";
if($this->filtrar) $c="class='bg_color_6'"; else $c='';
$info_indice.= "<td colspan='".($contaceldas +1)."' align='right' $c>";
$info_indice.= $this->conecto_central->traduccion[gest_filtrar].": <input type='text' value='".$this->filtrar."' name='filtrar' >";
$info_indice.= "<select name='menu_filtrar'>\n";
$j=0;
foreach($arra_selects_valores as $valor_0){
if ($this->menu_filtrar== $valor_0) $sel="selected";
else $sel=null;
if($valor_0 <>"miniatura" and $valor_0 <>"$valor_filtro" and $arra_tipos_campos[$j]<>'password' and $arra_tipos_campos[$j]<>'hidden')
$info_indice.=  " <option $sel value='$valor_0'>".$this->a_html(str_replace("'", "", $arra_selects_campos_valores[$j]))."</option>\n";
$j++;
}//foreach
$info_indice.= "</select>";
$info_indice.= "<input type='submit' value='".$this->conecto_central->traduccion[gest_filtrar]."' name='filtrar_button'><input type='hidden' value='".$_GET["order"]."' name='order'>\n";
$info_indice.= "</td>";
$info_indice.= "</tr>";
/*
0000000000000000000000000000000000000000000000
info sobre todos los registros y boton de mas registros
0000000000000000000000000000000000000000000000
*/
  $info_indice.= "<tr class='bg_color_0'>";
  $info_indice.= "<td colspan='". $contaceldas."' align='right'><i class='gestion'>";
  
    if($this->pagina_actual==$paginas_totales && $this->pagina_actual==1)
        $info_indice.= $this->conecto_central->traduccion[gest_most_reg_disp].":  $registros_totales<br>";
        else{
        if(!$registros_totales) $inicial=0;
        $info_indice.= $this->conecto_central->traduccion[gest_num_reg_disp].": ".$registros_totales.". ".$this->conecto_central->traduccion[gest_most_de]." $inicial - &gt; $final <br>";
    }
$info_indice.= "</i></td>";
  $info_indice.= "<td  align='left' nowrap >";
    if(!$multiple_menu_mas){
    if($this->array_usabilidad[0][0] && $this->array_usabilidad[0][1]=='mas.php'){ 
    $str="<table  border='2' cellspacing='0' cellpadding='0' bordercolor='white'><tr><td>
    <a  href='".$this->array_usabilidad[0][1].$this->vinculo."'  onmouseover=\"window.status='".$this->array_usabilidad[0][2]."';return true\" onmouseout=\"window.status='&copy; Copyrigth 2004 mediaymedia.com';return true\"><img src='../images/{$this->array_usabilidad[0][0]}' border=0></a>\n
    </td></tr></table>" ;
    }
    }else{
$str="\n<script language='JavaScript' type='text/JavaScript'>\n
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf(\"?\"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_jumpMenuGo(selName,targ,restore){ //v3.0
  var selObj = MM_findObj(selName); if (selObj) MM_jumpMenu(targ,selObj,restore);
}
//-->
\n</script>\n";
$str.="<select name='multiple' class='forms'  >\n"; 
    for($i=1;$i<21;$i++)
    $str.=" <option value='mas.php?valor_multiple=$i'> $i </option>\n";
    $str.="</select>\n\n";
    if($this->array_usabilidad[0][0] && $this->array_usabilidad[0][1]){ 
    $str.="<table  border='2' cellspacing='0' cellpadding='0' bordercolor='white'><tr><td>";
        $str.="<a  onmouseover=\"window.status='".$this->array_usabilidad[0][2]."';return true\" onmouseout=\"window.status='&copy; Copyrigth 2004 mediaymedia.com';return true\"  onClick=\"MM_jumpMenuGo('multiple','parent.frames[\'detalle\']',0)\"><img src='../images/{$this->array_usabilidad[0][0]}' border=0></a>\n";
        $str.="</td></tr></table>";
    }//if $this->array_usabilidad
}
  $info_indice.= "$str";
  $info_indice.= "</td></tr>";
/*
0000000000000000000000000000000000000000000000
    menu de campos del listado
0000000000000000000000000000000000000000000000
*/
    if($valor_filtro){
        $info_indice.= "<tr class='bg_color_0'>";
        $info_indice.= "<td colspan='".($contaceldas +1)."' align='left' class='bg_color_5'>";
        $info_indice.= "<b class='gestion'><a href='{$array_consultas[$this->consulta_00][5]}'><img src='../99/imagenes_gestion/$valor_imagen'  border=0>$valor_campo</a>  $valor_titulo </b>";
        if($titulo_02) $info_indice.= "<br><b class='gestion'><a href='$url_02'><img src='../99/imagenes_gestion/$img_02' >$campo_02</a>  $titulo_02 </b>";
        $info_indice.= "</td></tr>";
  }//valor_filtro
  

  $info_indice.= "<tr class='bg_color_0'>";
    foreach($this->arra_campos as $item){
	if(!$item[4]) continue;
        $tipo= $item[3];
        $valor=$item[1];
        $clave=str_replace("'", "", $item[2]);
        $order_01=1;$letra="(*)";$class_listar=''; $c=""; $d="";
        if($this->order_00==$valor){
            $c="class='bg_color_6'"; $d="class='menu_activo_listado'";
            if($this->order_01==1){
                $order_01=0;$letra="(<img src='../images/00_desc.gif' border='0'>)";$class_listar="class='bg_listar'";
            }else{
                $order_01=1;$letra="(<img src='../images/00_asc.gif' border='0'>)";$class_listar="class='bg_listar'";
            }//if $this->order_01==1
        }//if $this->order_00==$valor
        if($tipo <>'hidden'){
        if($clave<>"miniatura") $info_indice.= "<td nowrap $c><a href='?order_00=$valor&order_01=$order_01' $d >".$b1.$this->a_html($clave)."&nbsp;".$letra.$b2."</a></td>\n";
        else $info_indice.= "<td $class_listar nowrap>$b1$clave&nbsp;$b2</td>\n";
        }//if
    }//foreach
     $info_indice.= "<td >&nbsp;</td>\n";
   $info_indice.= "</tr>\n"; 

/*
00000000000000000000000 00000000000000000000000 00000000000000000000000 00000000000000000000000
listado de registros
*/
for($i=0;$i<$limit;$i++){
if(!$this->$datos_fuente->Record) break;
  if ($class=="class='bg_color_2'") $class="class='bg_color_0'";
  else $class="class='bg_color_2'";
  $info_indice.= "<tr $class >";
  $j=0;
  foreach($arra_selects_campos_valores as $item){
        $valor=str_replace("'", "", $item);
        $clave= $arra_selects_valores[$j];
        $tipo= $arra_tipos_campos[$j];
        $j++;
        if($tipo<>"hidden"){
        $info_indice.= "<td $class  valign='top' align='left'>";
        if($id_zona_00==$valor && !$info_zona_00){
            $info_zona_00= $this->$datos_fuente->Record[$id_zona_00];
            $_SESSION["sqls"][$this->pack_name][$this->seccion]["info_zona_00"]=$info_zona_00;
        }//if $id_zona_00==$valor && !$info_zona_00
            if ($tipo =="miniatura" ){
                $info_indice.= "<a href='{$array_uso[1][1]}".$this->$datos_fuente->Record[$id_registro].$this->vinculo."' >";
                if ($this->$datos_fuente->Record[$valor]!=""){
                    $info_indice.= "<img src='imagenes/".$this->$datos_fuente->Record[$valor]."' border='0' width='50'>";
                }//if $this->$datos_fuente->Record[$valor]!=""
                $info_indice.= "</a>";
            }else if ($tipo =="password" ){
                        $info_indice.='******';
            }else if ($tipo =="textarea" ){
                        $info_indice.= $this->$datos_fuente->Record[$valor];
            }else if ($tipo =="status" ){
            if(is_null($this->$datos_fuente->Record[$valor]))	$info_indice.= "<img src='../images/11_help.gif'>";
                    elseif($this->$datos_fuente->Record[$valor])	$info_indice.= "<img src='../images/11_pass.gif'><a href='ver.php?id_ref_alumno_00=".$this->$datos_fuente->Record[0]."&id_examen_00=".$this->$datos_fuente->Record[id_examen_00]."'><img src='../images/00_examen_view.gif'></a>";
                    else					$info_indice.= "<img src='../images/11_fail.gif'><a href='ver.php?id_ref_alumno_00=".$this->$datos_fuente->Record[0]."&id_examen_00=".$this->$datos_fuente->Record[id_examen_00]."'><img src='../images/00_examen_view.gif'></a>";
                }else{
                    if(is_array(${$valor."_array"}))	$info_indice.=$this->$datos_fuente->Record[$valor]."  (".${$valor."_array"}[$this->$datos_fuente->Record[$valor]].")";
                    else				$info_indice.= $this->$datos_fuente->Record[$valor];
            }//if
        $info_indice.= "</td>\n";
        }//if hidden
    }//foreach
  $info_indice.= "<td>";
  $info_indice.= "<table cellpadding=2 cellspacing=0 border=0><tr>";
    if ($class=="class='bg_color_2'") 	$class_imagen="#EEEEEE";
    else 				$class_imagen="#FFFFFF";

for($j=0;$j<count($this->array_usabilidad);$j++){

if($this->array_usabilidad[$j][3]) $separar=true; else $separar=false;
if($this->array_usabilidad[$j][1]=='mas.php') continue;

if($this->array_usabilidad[$j][4]){
    $v_din=$this->array_usabilidad[$j][4];
    $v_din2=$this->$datos_fuente->Record[$this->array_usabilidad[$j][4]];
    $link="&$v_din=$v_din2";
}else{
    $link="";
}//if $this->array_usabilidad[$j][4]

if($this->array_usabilidad[$j][0]) $str="<img src='../images/{$this->array_usabilidad[$j][0]}' border=0>"; else $str=$this->array_usabilidad[$j][2];
#$link_usabilidad="pe".$this->array_usabilidad[$j][1]."pe";
$link_usabilidad=str_replace("../", "", $this->array_usabilidad[$j][1]);
#$link_usabilidad=str_replace("index.php", "", $this->array_usabilidad[$j][1]);
if(is_array($this->referencias_tabla)){
#$ids=$this->id_seccion;
$ids_link='';
foreach($this->referencias_tabla as $valor){ 
if($this->seccion=='c_05'){
$ids_link[]=$valor."=".$this->$datos_fuente->Record[$valor];
#echo $valor."=".$this->$datos_fuente->Record[$valor]."<br>";
}elseif($this->seccion=='c_29' or $this->seccion=='c_33'){
#joao_trad
$ids_link[]=$valor."=".$this->conecto_central->Record[$valor];
}else{
$ids_link[]=$valor."=".$this->$datos_fuente->Record[0];
}//if
}//foreach
if(strrchr($link_usabilidad,"?")){
$link_usabilidad.="&".implode('&', $ids_link);
}else{
$link_usabilidad.="?".implode('&', $ids_link);
}//if
}else{
if(strrchr($link_usabilidad,"?")){
$link_usabilidad.="&".$this->id_seccion."=".$this->$datos_fuente->Record[0];
}else{
$link_usabilidad.="?".$this->id_seccion."=".$this->$datos_fuente->Record[0];
}
}
/*
limitar el uso de las secciones en las consultas sql de alumno que se generan mezclando las 2 tablas grupo y alumno
estas limitaciones hay que hacerlas en el mod()------>EXTREMOS
if($this->$datos_fuente->Record[0])

*/

if(($this->seccion<>"c_014" && $this->seccion<>"c_012" && $this->seccion<>"c_013" && $this->seccion<>"c_017" && $this->seccion<>"c_018") 
or ($this->seccion=="c_012"  && $this->$datos_fuente->Record[0]<>"0") or 
($this->seccion=="c_014" && $this->$datos_fuente->Record[3]=="sin grupo" && $this->$datos_fuente->Record[4]=="sin curso" && $this->$datos_fuente->Record[5]=="sin asignatura") or
($this->seccion=="c_013" && $this->$datos_fuente->Record[4]=="sin grupo" && $this->$datos_fuente->Record[5]=="sin curso") or
($this->seccion=="c_017"  && $this->$datos_fuente->Record[2]=="sin curso") or
($this->seccion=="c_018"  && $this->$datos_fuente->Record[2]=="sin curso" && $this->$datos_fuente->Record[3]=="sin asignatura")
)
if(!$separar)
$info_indice.= "<td>
<table  border='2' cellspacing='0' cellpadding='0' bordercolor='$class_imagen'><tr><td>
<a  href='$link_usabilidad'  onmouseover=\"window.status='".$this->array_usabilidad[$j][2]."';return true\" onmouseout=\"window.status='&copy; Copyrigth 2004 mediaymedia.com';return true\">$str</a></td></tr></table>
</td>";
else
$info_indice.= "<td>
<table  border='2' cellspacing='0' cellpadding='0' bordercolor='$class_imagen'><tr><td>
<a  href=\"javascript:window.open('$link_usabilidad','pop','toolbar=no, location=no, status=no, width=400, height=500, left=0, top=0, scrollbars=yes, resizable=yes');\"  onmouseover=\"window.status='".$this->array_usabilidad[$j][2]."';return true\" onmouseout=\"window.status='&copy; Copyrigth 2004 mediaymedia.com';return true\">$str</a></td></tr></table>
</td>";


}
$info_indice.= "</tr></table>";

        $info_indice.= "</td>";
  $info_indice.= "</tr>\n";
  if(!$this->$datos_fuente->next_record()){ break;}
  }//for limit

/*
0000000000000000000000000000000000000000000000
tiempo de consulta a la base de datos y limite de registros
0000000000000000000000000000000000000000000000
*/

$info_indice.= "\n<tr class='bg_color_0'>\n\t<td colspan='".($contaceldas +1)."' align='right'>";
$info_indice.= "<span class='small'>".$this->conecto_central->traduccion[gest_cons_base_dat].": ".substr($this->$datos_fuente-> ss_timing_current(),0,6)." ". $this->conecto_central->traduccion[gest_seg].".  </span>";
$info_indice.= "</td></tr>";
$info_indice.= "\n<tr class='bg_color_0'>";
if($this->limite<>10) $c="class='bg_color_6'"; else $c='';
$info_indice.= "\n\t<td colspan='".($contaceldas +1)."' align='right' $c >";
$info_indice.= $this->conecto_central->traduccion[gest_num_lim_reg].": <input type='text' name='limite' value='$this->limite' size='2'>";
$info_indice.= "</td></tr>";
$info_indice.= "\n\n</table>\n\n</form>\n\n";
$info_indice.=$this->documento_gestion->cerrar_tabla_info('100%' ,50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
$info_indice.=$this->documento_gestion->cerrar_tabla_modulo('100%' ,50);
$this->$datos_fuente->cerrar_conexion();
return $info_indice;
}//function_indice
}//class
?>
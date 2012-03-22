<?php
require_once("global_interface.php");
class documento extends global_interface{

    var $titulo="pruebas.";
    var $css="estilos.css";
    var $open='';
    var $close='';
    



function documento(){
    $this->graba_variables_obj_ppal(func_get_args());
    if($this->idioma=="gestion"){ $this->css="estilos.css";  $this->body_open="open_body_gestion";}else{ $this->css="estilos_web4.css"; $this->body_open="open_body_coordinadora";}
if($this->idioma<>"gestion"){ $this->conecto_datos->stats_ver_country();
#    if(!$this->conecto_datos->traducciones_hechas)$this->conecto_datos->traducir_arra();

}

#echo "<hr>".$this->idioma.$this->seccion. $this->subseccion.$this->archivo."<hr>";



}//documento

function head_in(){
$salida.= "<html>\n";
$salida.= "<HEAD>\n";
$salida.= "<TITLE>". $this->titulo_pagina."</TITLE>\n";
$salida.= "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
#$salida.= "<script language='JavaScript' src='".$this->url."../../css/funciones.js'></script>\n";
$salida.= "<link rel='stylesheet' type='text/css' href='".$this->url."../../css/".$this->css."'>\n";
#$salida.= "<link rel='shortcut icon' href='../../images/tr_logo.gif' />\n";
$salida.= "</head>\n\n";
return $salida;
}//head_in

function open_body_gestion(){
if($this->seccion=="c_99")
$salida.= "\n\n<body bgcolor='#FFFFFF' text='#000000'  marginwidth='0' marginheight='0' topmargin='0' leftmargin='0' onload='document.forms[0].elements[0].focus();'>\n\n";
else
$salida.= "\n\n<body bgcolor='#FFFFFF' text='#000000'  marginwidth='0' marginheight='0' topmargin='0' leftmargin='0' >\n\n";
return $salida;
}//function



function close_body(){
$salida.= "\n\n</body>\n\n</html>";
return $salida;
} //function








#0000000000000 funciones de documento de qdm004 0000000000000000000000000000000000000000




function open_body_coordinadora(){
$salida.= "\n\n<body  leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' style='background-color:#FFFFFF;background: url(../../home_design/images/fondo_".$this->seccion.".jpg) repeat-y ;background-attachment: fixed'>";
return $salida;
}


function docs_adjuntos($seccion="", $id_principal=""){
$this->conecto_datos->query("select * from document_up 
where seccion_principal='$seccion'  and document_up_id_principal=$id_principal");
while($this->conecto_datos->next_record()){
if($this->conecto_datos->Record["informacion_".$this->idioma]) $info=$this->conecto_datos->Record["informacion_".$this->idioma]; else $info=$this->conecto_datos->Record["informacion_".$this->otro_idioma];
if($this->conecto_datos->Record["document_up_".$this->idioma]) $doc=$this->conecto_datos->Record["document_up_".$this->idioma]; else $doc=$this->conecto_datos->Record["document_up_".$this->otro_idioma];
if($doc){ If(!$uno){$uno=true; 

#$lista_archivos.="<b>Puedes descargar los siguientes documentos: </b>".$this->conecto_datos->traduccion[descarga_doc]."<br><br>";
}

$lista_archivos.="<div class='margin_20px'><a href='".$this->url."../../imgs/$doc'><img src='$this->url../../gestion/c_99/imgs/".$this->sel_imagen_doc($doc)."' border=0 valign='bottom'> >  $info </a></div><br>";}
}
return $lista_archivos;
}//function

function sel_imagen_doc($doc){
   switch (substr($doc, 5, 2)){
       case "04":
   $v_imagen='rtf_min.jpg';
   break;
       case "05":
   $v_imagen='mp3_min.jpg';
   break;
       case "06":
   $v_imagen='mov_min.jpg';
   break;
       case "07":
   $v_imagen='htm_min.jpg';
   break;
       case "08":
   $v_imagen='htm_min.jpg';
   break;
    case "09":
   $v_imagen='pdf_min.jpg';
   break;
    case "10":
   $v_imagen='doc_min.jpg';
   break;
    case "11":
   $v_imagen='swf_min.jpg';
   break;
   default:
   $v_imagen='txt_min.jpg';
}
return $v_imagen;
}



#00000000000000000000000000000000000000000000000000000000000000000000000000000000






function salida($info, $open=false, $close=false){
if(!$open && !$close && !$this->open){
$info=$this->head_in().$this->{"$this->body_open"}().$info;
$this->open=true;
}//if
if($open && !$this->open)
if($this->idioma<>"gestion")$info=$this->head_in().$this->{"$this->body_open"}().$this->coordinadora_cuerpo_open().$info;
else $info=$this->head_in().$this->{"$this->body_open"}().$info;
if($close)
if($this->idioma<>"gestion") $info.=$this->coordinadora_cuerpo_close().$this->close_body();
else $info.=$this->close_body();
echo $info;
}

function salida_sin_cab($info, $open=false, $close=false){
$info="<table width='697' border=0 cellspacing=0 cellpadding=0>
<!-- espacio_up -->
<tr><td align='center'>
<table width='90%' border=0 cellspacing=0 cellpadding=0>
<tr><td>
<div align='center'>$info</div>
</td></tr>
</table>
</td></tr>
";
if(!$open && !$close && !$this->open){
$info=$this->head_in().$this->{"$this->body_open"}().$info;
$this->open=true;
}//if
if($open && !$this->open)
if($this->idioma<>"gestion")$info=$this->head_in().$this->{"$this->body_open"}().str_replace("<!-- espacio_up -->","<tr><td><br><br><br></td></tr>", $info);
else $info=$this->head_in().$this->{"$this->body_open"}().$info;
if($close)
if($this->idioma<>"gestion") $info.=$this->coordinadora_cuerpo_close().$this->close_body();
else $info.=$this->close_body();
echo $info;
}

function salida_con_cab($info, $open=false, $close=false){
if(!$open && !$close && !$this->open){
$info=$this->head_in().$this->{"$this->body_open"}().$info;
$this->open=true;
}//if
if($open && !$this->open)
if($this->idioma<>"gestion")$info=$this->head_in().$this->{"$this->body_open"}().$this->coordinadora_cuerpo_open();
else $info=$this->head_in().$this->{"$this->body_open"}().$info;
if($close)
if($this->idioma<>"gestion") $info.=$this->coordinadora_cuerpo_close().$this->close_body();
else $info.=$this->close_body();
echo $info;
}


//0000000000000000 AGENDA 00000000000000000000000
var $fecha="";
var $anyo="";
var $mes="";
var $dia="";
var $query="";
var $agenda_mes_array="";//
var $dias_semana="";
var $meses="";

function agenda(){
  $this->ver_url();
  $this->meses=array("ENE","FEB","MARZ","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
  $this->dias_semana=array("lunes","martes","miercoles","jueves","viernes","s&aacute;bado","domingo");
}//function

function ver_url(){
    if ($_GET["anyo"]!=""){
    $this->anyo=$_GET["anyo"];
    }else{
    $this->anyo=date("Y");
    }//if
    
    if ($_GET["mes"]!=""){
    $this->mes=$_GET["mes"];
    }else{
    $this->mes=date("m");
    }//if
    
    if ($_GET["dia"]!=""){
    $this->dia=$_GET["dia"];
    }else{
    $this->dia=date("d");
    }//if
    
    if ($_GET["fecha"]!=""){
    $this->fecha=$_GET["fecha"];
    $arra=explode("-", $this->fecha);
    $this->anyo=$arra[0];
    $this->mes=$arra[1];
    $this->dia=$arra[2];
    }//if
    
$mes_marcado=$mes_actual;

}//function



function array_agenda(){
$this->agenda_mes_array=array();
$this->conecto_datos->query("select * from agenda where MONTH(fecha)=".$this->mes." and year(fecha)=".$this->anyo."  and id_registro_00=".$this->registro_agenda." order by fecha desc");
  while($this->conecto_datos->next_record())
  $this->array_unshift_assoc($this->agenda_mes_array, $this->conecto_datos->Record["fecha"],$this->conecto_datos->Record["id_agenda_00"]);
}//function


function array_unshift_assoc(&$arr, $key, $val){
  $arr = array_reverse($arr, true); 
  $arr[$key] = $val; 
  $arr = array_reverse($arr, true); 
  return count($arr); 
} //function













function escribir_agenda_web($ancho_tabla=200, $alto_tabla=200,$align="left", $registro_agenda){
$this->registro_agenda=$registro_agenda;
$this->agenda();
$this->array_agenda();
$celda_width=(int)($ancho_tabla/7);

$info.="<table width='100%' cellpadding=6 cellspacing=4 border=0>
<tr><td valign='top' width=$ancho_tabla align='left'>";
#cambio_a
$info.="<table  width='$ancho_tabla' height='$alto_tabla'align='$align' border=0 cellspacing=4 cellpadding=0>";
$info.="<tr>";
$info.="<td  align='center'  colspan='7'>";
$mes_navega=$this->mes-1;
$anyo_navega=$this->anyo;
if ($this->mes==1){
$mes_navega=12;
$anyo_navega=$this->anyo-1;
}
$info.="<a href='?mes=".($mes_navega)."&anyo=".($anyo_navega)."'><<</a>";
$mes_navega=$this->mes+1;
$anyo_navega=$this->anyo;
if ($this->mes==12){
$mes_navega=1;
$anyo_navega=$this->anyo+1;
}
$info.=" ".$this->meses[$this->mes-1]." ".$this->anyo." ";
$info.="<a href='?mes=".($mes_navega)."&anyo=".($anyo_navega)."'>>></a>";
$info.="</td>";


$info.="</tr>";


$info.="<tr>";
for($i=0;$i<7;$i++){
$info.="<td  align='center'  width='114'>";
$info.=($this->dias_semana[$i][0]);
$info.="</td>";
}//for
$info.="</tr>";

$j=2;


$fech=mktime(0,0,0,$this->mes,01,$this->anyo);
$d_fech=date("w",$fech);
$d_fech=$d_fech+1;


while($j!=$d_fech){
if ($j==2) {
$info.="<tr>";
}
$info.="<td  width='114'>";
$j = $j % 7 +1;

}//while






for ($diario=1; $diario<32; $diario++){
if (!checkdate ( $this->mes, $diario, $this->anyo))
break;
//if

if(((date("w",mktime(0,0,0,$this->mes, $diario,$this->anyo))+1)==2))
$info.="<tr>";
//if


$fechar_array=mktime(0,0,0,$this->mes,$diario,$this->anyo);
$fechar_array =date("Y-m-d", $fechar_array);

if (array_key_exists($fechar_array, $this->agenda_mes_array)) {
$info.="<td  class='bg_color_2' valign=top width='114' >";
$info.= "<a  href='$PHP_SELF?inicio=si&dia=".$diario."&mes=".$this->mes."&anyo=".$this->anyo."'>$diario.</a>";
$info.="</td>";
}else{
$info.="<td  class='bg_color_0' valign=top width='114' >";
$info.= $diario;
$info.="</td>";
}

}//for

$info.="</table>
<td width=1 style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-y ;'>
<img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='1' alt=''>
</td><td>";
$info.=$this->mostrar_actuales();
$info.="</td></tr></table>";

return $info;
}//function


function mostrar_actuales(){

$conn1=$this->datos;
$this->query ="select * from agenda where MONTH(fecha)=".$this->mes." and year(fecha)=".$this->anyo." and dayofmonth(fecha)=". $this->dia." order by fecha desc, hora";
$conn1->query($this->query);
$info.="<table width='100%' cellspacing=4 border=0></tr>";

while($conn1->next_record()){
if(!$uno){ $info.="<tr><td width=1 style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-x ;'>
<img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='10' alt=''>
</td></tr>";$uno=true;}
$this->id_agenda=$conn1->Record[id_agenda];
$img=$conn1->Record["imagen"];

if ($img){

$abc= @imagecreatefromjpeg($this->url."../../imgs/".$conn1->Record["imagen"]);  
$abc_zz = @imagecreatefromjpeg($this->url."../../imgs/".str_replace('mm','zz',$conn1->Record["imagen"]));  

 $ancho=@ImageSX($abc);
$alto=@ImageSY($abc);
 $ancho_zz=@ImageSX($abc_zz);
$alto_zz=@ImageSY($abc_zz);
if($ancho<>$ancho_zz && $abc_zz){
$img="<table width=$ancho height=$alto cellspacing=0 cellpadding=0 border=1 bordercolor='#FF6600' ><tr><td><a href=\"javascript:window.open('".$this->url."../../imgs/".str_replace('mm','zz',$conn1->Record["imagen"])."','pop','toolbar=no, location=no, status=no, width=$ancho_zz, height=$alto_zz, left=0, top=0, scrollbars=no, resizable=yes');\"><img src='".$this->url."../../imgs/".$conn1->Record["imagen"]."'  border=0 alt='zoom' width=$ancho height=$alto ></a></td></tr></table>";

$info.="<tr><td valign='top'  align='left'> $img </td></tr>\n";
}
}
$info.="<tr><td valign='top'  align='left' ><div class='fecha_agenda'><b class='color_333333'>".strftime("%H:%M",strtotime($conn1->Record["hora"]))."</b> - <b class='color_666666'>".$conn1->Record["titular_".$this->idioma]."</b></div><br>".$this-> a_html_format ($conn1->Record["texto_".$this->idioma])."<br>";





 
$info.="<br><br>".$this->doc_relacionados_agenda()."</td></tr><tr><td width=1 style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-x ;'>
<img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='10' alt=''>
</td></tr>";
}//while
$info.="\n";
$info.="</table>";
return $info;
}//function

function doc_relacionados_agenda(){
return $this->docs_adjuntos("c_16",$this->id_agenda);
}

//00000000000000000000000000000   AGENDA  000000000000000000

//00000000000000000000000000000 coordinadora  000000000000000000
var $arra_valores_menu=array( 
array("buscador","BUSCAR&nbsp;CLASES","BUSCAR&nbsp;CLASES_cat"), 
array("coordinadora","COORDINADORA","COORDINADORA"), 
array("entidad","ENTIDADES PARTICIPANTES","ENTIDADES&nbsp;PARTICIPANTES_cat"), 
array("agenda","AGENDA","AGENDA_cat"), 
array("diccionario","DICCIONARIO&nbsp;VISUAL","DICCIONARIO&nbsp;VISUAL_cat"), 
array("guias","GUIAS&nbsp;UTILES","GUIAS&nbsp;UTILES_cat")
);
var $arra_coordinadora=array(
array("bienvenida.php", "BIENVENIDA", "BIENVENIDA_cat"), 
array("noticias.php", "NOTICIAS", "NOTICIAS_cat"), 
array("voluntariado.php","VOLUNTARIADO","VOLUNTARIADO_cat"), 
array("contacto.php", "CONTACTO", "CONTACTO_cat")
);

function coordinadora_cuerpo_open(){
$info.="<table id='estructura' width='723'  border='0' cellpadding='0' cellspacing='0'>";

$info.="	
<tr><td bgcolor='#000000'><img src='../../home_design/images/ajuste.gif' width='723' height='10' alt=''></td></tr>

<tr><td style=\"background-image:url('../../home_design/images/estructura_04_000000.gif');\">
		<table id='cabecera' width='723' height='15' border='0' cellpadding='0' cellspacing='0' >
	<tr>
		<td class='idioma'>";
                $clase_esp="verde_blanca_underline"; $clase_cat="blanca_verde_none";
                if($this->idioma=="cat"){ $clase_esp="blanca_verde_none"; $clase_cat="verde_blanca_underline";}
	$info.="	&nbsp; <a href='../../cat/".$this->seccion."/index.php' class='$clase_cat' target='_parent'>catal&aacute;</a> - <a href='../../esp/".$this->seccion."/index.php' class='$clase_esp' target='_parent'>castellano</a>";
                        $info.="</td>
		<td >
			<img src='../../home_design/images/ajuste.gif' width='2' height='15' alt=''></td>
	</tr>

</table>

</td></tr>";
$info.="    <tr><td bgcolor='#000000'><img src='../../home_design/images/ajuste.gif' width='723' height='2' alt=''></td></tr>";
$info.="    <tr>
		<td><img src='../../home_design/images/cab_".$this->seccion.".jpg' width='723' height='120' alt=''></td>
	</tr>";


$info.="<tr>
            <td bgcolor='black' width='723' height='15' class='menu' align='center'>";
if($this->idioma=="esp") $idioma_posicion=1; else $idioma_posicion=2;
foreach($this->arra_valores_menu as $menu_p){
if($menu_p[0]==$this->seccion){ $clase="verde_blanca_underline"; $menu_p_tit="<b>".$menu_p[$idioma_posicion]." </b>";
}else{
  $clase="blanca_verde_none";
  $menu_p_tit =$menu_p[$idioma_posicion];
  }
$info.="<a href='../{$menu_p[0]}/index.php' class='$clase' target='_parent'>$menu_p_tit</a>&nbsp;&nbsp;&nbsp;";
}//foreach
$info.="</td></tr>";
if(is_array($this->{"arra_".$this->seccion})){
    $this->arra_valores_submenu=$this->{"arra_".$this->seccion};
    $info.="<tr>
                <td bgcolor='black' width='723' height='15' class='menu_activo' align='center'>";
    foreach($this->arra_valores_submenu as $submenu_p){
    if($this->archivo==$submenu_p[0]){
    $clase="negra_verde_underline"; 
    $submenu_p_tit="<b> {$submenu_p[$idioma_posicion]}</b>";
    }else{
    $clase="negra_verde_none";
        $submenu_p_tit=$submenu_p[$idioma_posicion];

    }
    $info.="<a href='{$submenu_p[0]}#' class='$clase' target='main'> $submenu_p_tit </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }//foreach
    $info.="</td></tr>";
}//if existe el array de subseccion
  
        

                            


$info.="	<tr>
		<td ><!-- style=\"background-image:url('../../home_design/images/fondo_reticula.gif');\" -->
                    <table id='interior_forma' width='723'  border='0' cellpadding='0' cellspacing='0' style='background: url(../../home_design/images/fondo_".$this->seccion.".gif)  ;'>
                        <tr><td colspan=3><img src='../../home_design/images/ajuste.gif' width='723' height='25' alt=''></td></tr>

                    <tr>
		<td>
			<img src='../../home_design/images/ajuste.gif' width='65' height='20' alt=''>
                           </td>
                           <td >";
return $info;
} //coordinadora_cuerpo_open


function coordinadora_cuerpo_close(){
$info.="		<tr>
                            <td>
			<img src='../../home_design/images/ajuste.gif' width='65' height='20' alt=''>
                           </td>
                    </tr>
                    <tr><td><img src='../../home_design/images/ajuste.gif' width='723' height='25' alt=''></td></tr>
                    <tr><td ><img src='../../home_design/images/ajuste.gif' width='723' height='350' alt=''></td></tr>




	<tr bgcolor='black'>
		<td align='center' class='copy'><span style='color:#66cc00;font-size:12px;'>&copy; Ajuntament de Barcelona</span></td>
	</tr>
                    <tr><td ><img src='../../home_design/images/ajuste.gif' width='723' height='50' alt=''></td></tr>


</table>";
return $info;
}//coordinadora_cuerpo_close

function copy_coordinadora(){

}//coordinadora_cuerpo


function modulo($info, $color_base="", $color_capa="", $centrado="center", $padding=""){
if(!$color_base)$color_base='ffffff';
if(!$color_capa)$color_capa='f7f8dd';
if(!$padding) $padding="padding:15px"; else $padding="padding:".$padding."px";
$base_imagen='mod_'.$color_base.'_'.$color_capa;
return  "<div align='$centrado'>
<table id='Table_01'   border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td>
			<img src='../../home_design/images/".$base_imagen."_01.gif' width='13' height='13' alt=''></td>
		<td style='background: url(../../home_design/images/".$base_imagen."_02.gif) repeat-x ;'>
			<img src='../../home_design/images/ajuste.gif'  height='13' alt=''></td>
		<td>
			<img src='../../home_design/images/".$base_imagen."_03.gif' width='14' height='13' alt=''></td>
	</tr>
	<tr>
		<td style='background: url(../../home_design/images/".$base_imagen."_04.gif) repeat-y ;'>
			<img src='../../home_design/images/ajuste.gif' width='13' height='5' alt=''></td>
		<td style='background:url(../../home_design/images/".$base_imagen."_05.gif); $padding' align='left'>$info</td>
		<td style='background: url(../../home_design/images/".$base_imagen."_06.gif) repeat-y ;'>
			<img src='../../home_design/images/ajuste.gif' width='14' height='5' alt=''>
                        </td>
	</tr>

	<tr>
		<td>
			<img src='../../home_design/images/".$base_imagen."_07.gif' width='13' height='13' alt=''></td>
		<td style='background: url(../../home_design/images/".$base_imagen."_08.gif) repeat-x ;'>
			<img src='../../home_design/images/ajuste.gif'  height='13' alt=''></td>
		<td>
			<img src='../../home_design/images/".$base_imagen."_09.gif' width='14' height='13' alt=''></td>
	</tr>
</table>
</div>";

}//function


//00000000000000000000000000000 //coordinadora  000000000000000000

}//class
?>
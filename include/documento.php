<?php
require_once("global_interface.php");
class documento extends global_interface{


    var $titulo="pruebas.";
    var $css="estilos.css";
    var $open='';
    var $close='';

var $qdm=array("fra"=>"QUARTIERS DU MONDE", "esp"=>"BARRIOS DEL MUNDO");
var $equipos_trabajo=array("montreuil"=>array("MONTREUIL", 55),"barcelona"=>array("BARCELONA", 8), "palma"=>array("PALMA DE MALLORCA", 9), "evry"=>array("EVRY", 10), "pikine"=>array("PIKINE", 11), "bamako"=>array("BAMAKO", 5), "sale"=>array("SAL&Eacute;", 12), "rio"=>array("R&Iacute;O DE JANEIRO", 13), "elalto"=>array("EL ALTO", 14), "bogota"=>array("BOGOT&Aacute;", 15));
var $equipos_trabajo_numero=array(55=>array("montreuil", "MONTREUIL"), 8=>array("barcelona", "BARCELONA"), 9=>ARRAY("palma", "PALMA DE MALLORCA"),
10=>ARRAY("evry", "EVRY"), 11=>ARRAY("pikine", "PIKINE"),5=>array("bamako", "BAMAKO"),12=>array("sale", "SAL&Eacute;"), 13=>array("rio", "R&Iacute;O DE JANEIRO"), 14=>ARRAY("elalto", "EL ALTO"),15=>ARRAY("bogota", "BOGOT&Aacute;"), 4=>array("qdm_a", "qdm_asociacion"), 7=>array("qdm_p", "qdm_proyecto"));
var $arra_def=array(
    array("presenta", "PRESENTACION", "PR&Eacute;SENTATION", "ff9900", "ffcc66", "CC6633", "DATABASE"), 
	array("objetivos", "PROYECTOS", "PROJETS","999933", "cccc66","333333", "DATABASE"),
    array("qdm", "PROYECTO BARRIOS DEL MUNDO:<BR>HISTORIAS URBANAS", "PROJET QUARTIERS DU MONDE:<BR>HISTOIRES URBAINES","ffcc00","ffff99", "CC6633",  
            array(
            array("presenta", "PRESENTACION", "PR&Eacute;SENTATION","DATABASE"),
			array("red", "RED", "R&Eacute;SEAU","DATABASE"),
            array("equipos", "EQUIPOS", "EQUIPES","DATABASE",
                    array(
                            array("presenta", "PRESENTACION", "PR&Eacute;SENTATION", "database"),
                            array("info", "ACTIVIDADES", "ACTIVIT&Eacute;S", "database"),
                            array("agenda", "AGENDA", "AGENDA",NULL),
                            array("socios", "SOCIOS", "PARTENAIRES",NULL),
                            array("contacto", "CONTACTO", "CONTACT",NULL)
                            )
            ),
			array("foros", "DISCUSIONES", "DISCUSSIONS","DATABASE"),
			array("info", "DOCUMENTACI&Oacute;N", "DOCUMENTATION","DATABASE"),
            array("agenda","AGENDA", "AGENDA",NULL),
            array("socios", "SOCIOS", "PARTENAIRES",NULL),
            array("contacto", "CONTACTO", "CONTACT",NULL)
            )
    ),
 
    array("socios", "SOCIOS", "PARTENAIRES","cc6633", "ffcc99","993300", null),
    array("agenda", "AGENDA", "AGENDA","ff9900", "ffcc66","cc6633", null),
    array("contacto", "CONTACTO", "CONTACT","996666", "cc9999","663333", null)
);


function documento(){
    $this->graba_variables_obj_ppal(func_get_args());
		if($this->depurar_documento) $this->depurar_mensaje("seccion:".$this->seccion);
/*
    foreach($this->traducir as $elemento){
	echo "hola $elemento";
	}
	*/
if(!$this->conecto_datos->traducciones_hechas) $this->conecto_datos->traducir_arra();

$this->css="estilos_qdm2.css"; 
$this->body_open="open_body_qdm";
if(!$this->conecto_datos->stats_ver_country() ){
$this->conecto_stats->select_country();
$this->conecto_datos->country_name=$this->conecto_stats->country_name;
$this->conecto_datos->stats_00();
$this->conecto_datos->stats_03();
}//if
if($this->seccion=="mujer" && $this->archivo=="foros.php"){
if($_GET[id])
$this->id_reg=$_GET[id];

}

$this->idioma_arra=array("esp"=>1, "fra"=>2);
$this->numero_idioma=$this->idioma_arra[$this->idioma];
#echo "<hr>".$this->idioma.$this->seccion. $this->subseccion.$this->archivo."<hr>";
foreach($this->arra_def as $color){
if($color[0]<>"qdm") $this->array_princ_joao[]=$color[0];

if($color[0]==$this->seccion){
$this->color_base=$color[3];
$this->color_base_suave=$color[4];
$this->color_base_oscuro=$color[5];
$this->seccion_sel=$color[0];
$this->archivo_sel=str_replace(".php", "", $this->archivo);
$this->id_reg=$_GET[id];
}//if color
}//foreach
if($this->subseccion){
$this->equipo_actual=$this->equipos_trabajo[$this->subseccion][0];
$this->id_equipo_actual=$this->equipos_trabajo[$this->subseccion][1];
}
if($this->seccion=="presenta" ){

///////	presentacion de registros de asociacion id_registro=4 	//////

$this->arra_def[0][6]=$this->presenta_reg(4);
}elseif($this->seccion=="red"){
$this->arra_def[1][6]=$this->presenta_reg(4);

}elseif($this->seccion=="objetivos"){

///////	presentacion de objetivos de asociacion -->> seccion_principal='c_17'  order by id_noticia_00	//////

     $this->arra_def[1][6]=$this->objetivos_reg("c_17", 4);

}elseif($this->seccion=="qdm"   ){
    $this->qdm_reg_asoc();

}elseif($this->seccion=="mujer"){

//$this->arra_def[2][7]=$this->foros_reg();
}



#$this->documento->salida("<h1>".$objeto->datos_stats->record_count."</h1>");

$this->izq=$this->navega_izquierdo();
}//formato

function graba_variables_obj_ppal($array_variables){
    foreach($array_variables as $valor_comun){
        foreach($valor_comun as $clave=>$valor) $this->$clave=$valor;
    }//foreach
}// f_graba_variables_obj_ppal

function head_in(){
$salida.= "<html>\n";
$salida.= "<HEAD>\n";
$salida.="<meta name='google-site-verification' content='g6xt2M9b_SUw4hLR-OSuIb3k8SFZyu-t92K9GNRlVl8' />\n";
$salida.= "<TITLE>". str_replace("<BR>", " ", $this->titulo_pagina)."</TITLE>\n";
$salida.= "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
#$salida.= "<script language='JavaScript' src='".$this->url."../../css/funciones.js'></script>\n";
$salida.= "<link rel='stylesheet' type='text/css' href='".$this->url."../../css/".$this->css."'>\n";
#$salida.= "<link rel='shortcut icon' href='../../images/tr_logo.gif' />\n";
if($this->seccion=="home"){
$salida.="
<script language=\"JavaScript\" type=\"text/JavaScript\">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf(\"#\")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf(\"?\"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+\".location='\"+args[i+1]+\"'\");
}
  
//-->
</script>
";
}
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


function form_registro(){
$salida.=  "<table width='100%' height='100%' border=0>
<tr><td align='center' valign='middle'>
<table border='0' cellspacing='1' cellpadding='5' width='300' bgcolor='".$this->bgcolor_gestion."' >";
$salida.=  "<tr class='bg_color_4'><td align='right'><img src='../images/logo_gestion.jpg'><br><font color='".$this->f_color_gestion."'><b>Zona de gesti&oacute;n </b></font></td></tr>";
$salida.=  "<form action='".$_SERVER['PHP_SELF']."' method='post' >";
$salida.=  "<tr class='bg_color_3'><td align='right'><font color='".$this->f_color_gestion."'>usuario  </font><input type='text' name='user' value=''></td></tr>";
$salida.=  "<tr class='bg_color_1'><td align='right'><font color='".$this->f_color_gestion."'>clave </font><input type='password' name='password' value=''></td></tr>";
$salida.=  "<tr class='bg_color_3'><td align='center'><input type='submit' name='enviar_claves' value='enviar'></td></tr>";
$salida.=  "</form>";
$salida.=  "</table>
</td></tr></table>";
return $salida;
}// f_ form_registro


function frame_index_01($row_or_column, $first_frame,  $first_document, $first_size, $second_frame, $second_document, $second_size){
$salida.= "<html>\n";
$salida.= "<head>\n<title>gesti&oacute;n</title>\n";
$salida.= "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
$salida.= "</head>\n";
$salida.= "<frameset $row_or_column='$first_size, $second_size' frameborder='NO' border='0' framespacing='0' > \n";
$salida.= "<frame name='$first_frame' scrolling='AUTO' src='$first_document' >\n";
$salida.= "<frame name='$second_frame' scrolling='AUTO' src='$second_document'>\n";
$salida.= "</frameset>\n";
$salida.= "<noframes></noframes></html>\n";
return $salida;
}//function frame_index


function abrir_tabla_modulo($ancho,$alto, $alinear_tabla="left"){
$ancho_celda_min="5";
if($ancho=='100%')
$ancho_celda_max=100-($ancho_celda_min*2)."%";
else
$ancho_celda_max=$ancho-($ancho_celda_min*2);
$alto_celda_min="5";

$salida.= "<table class='modulo'  width='$ancho' height='$alto' border='0' cellspacing='0' cellpadding='0' align='$alinear_tabla'>\n";
$salida.= "<tr>\n";
$salida.= "<td width='$ancho_celda_min' height='$alto_celda_min' class='modulo_v1'><img src='".$this->url."../../images/ajuste.gif' width='$ancho_celda_min' height='$alto_celda_min'></td>\n";
$salida.= "<td width='$ancho_celda_max' height='$alto_celda_min' class='modulo_h1'></td>\n";
$salida.= "<td width='$ancho_celda_min' height='$alto_celda_min' class='modulo_v2'><img src='".$this->url."../../images/ajuste.gif' width='$ancho_celda_min' height='$alto_celda_min'></td>\n";
$salida.= "</tr>";
return $salida;
}//function


function abrir_tabla_info($ancho,$alto,$alinear_central_h, $alinear_central_v){
$ancho_celda_min="5";
if($ancho=='100%')
$ancho_celda_max=100-($ancho_celda_min*2)."%";
else
$ancho_celda_max= $ancho-($ancho_celda_min*2);
$alto_celda_min="5";
$alto_max=$alto-($alto_celda_min*2);
$salida.= "<tr>\n";
$salida.= "<td width='$ancho_celda_min' class='modulo_t1'></td>\n";
$salida.= "<td width='$ancho_celda_max' class='modulo_central' align='$alinear_central_h' valign='$alinear_central_v'>\n";
$salida.= "<table border='0' cellspacing='1' cellpadding='5' width='100%' bgcolor='".$this->bgcolor_gestion."'><tr class='bg_color_2'><td align='left'>\n";
return $salida;
}//function

function cerrar_tabla_info($ancho,$alto,$alinear_central_h, $alinear_central_v){
$ancho_celda_min="5";
if($ancho=='100%')
$ancho_celda_max=100-($ancho_celda_min*2)."%";
else
$ancho_celda_max= $ancho-($ancho_celda_min*2);
$alto_celda_min="5";
$salida.= "</td></tr></table></td>\n";
$salida.= "<td width='$ancho_celda_min' class='modulo_t2'></td>\n";
$salida.= "</tr>\n";
return $salida;
}

function cerrar_tabla_modulo($ancho,$alto=""){
$ancho_celda_min="5";
if($ancho=='100%')
$ancho_celda_max=100-($ancho_celda_min*2)."%";
else
$ancho_celda_max= $ancho-($ancho_celda_min*2);
$alto_celda_min="5";
$salida.= "<tr>\n";
$salida.= "<td width='$ancho_celda_min' height='$alto_celda_min' class='modulo_v3'><img src='".$this->url."../../images/ajuste.gif' width='$ancho_celda_min' height='$alto_celda_min'></td>\n";
$salida.= "<td width='$ancho_celda_max' height='$alto_celda_min' class='modulo_h2'></td>\n";
$salida.= "<td width='$ancho_celda_min' height='$alto_celda_min' class='modulo_v4'><img src='".$this->url."../../images/ajuste.gif' width='$ancho_celda_min' height='$alto_celda_min'></td>\n";
$salida.= "</tr>\n";
$salida.= "</table>\n\n\n";
return $salida;
}//function

#0000000000000 funciones de formato de qdm004 0000000000000000000000000000000000000000




function open_body_qdm(){
if($this->seccion=="home"){
$salida.="<body bgcolor='#FFFFFF' text='#000000'  marginwidth='0' marginheight='0' topmargin='0' leftmargin='0' onLoad=\"MM_preloadImages('images/acogida_bogota.jpg','images/acogida_barcelona.jpg','images/acogida_bamako.jpg','images/acogida_sale.jpg','images/acogida_rio.jpg','images/acogida_pikine.jpg','images/acogida_palma.jpg','images/acogida_evry.jpg','images/acogida_elalto.jpg')\">";
}else{
$salida.= "\n\n<body  leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' >
<!-- style='background: url(".$this->url."../../images_home/fondo_l2_cccccc.jpg) repeat-y 48% 0;' -->\n\n";
}
$salida.=$this->izq; 
return $salida;
}


function  navega_izquierdo(){
$navega.= "<div align='center' valign='top'>
<table id='Table_01' width='755'   border='0' cellpadding='0' cellspacing='0' BGCOLOR='#FFFFFF'>
	<tr><td rowspan=4 width='10' style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-y ;' valign='top'>  <img src='".$this->url."../../images_home/pixel_transp.gif' width='10' height='1' alt=''></td>
 <td colspan=6  width='741'>       
        <table id='CABECERA' width='741' height='126' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='115' height='58'>";
                        
if($this->idioma=="esp")
$navega.=" <br><span class='idioma'><a href='".str_replace("/esp/", "/fra/", $_SERVER['REQUEST_URI'])."' class='gris_medio'>Fran&ccedil;ais</a></span><br><span class='idioma' >Espa&ntilde;ol </span>";
else
$navega.=" <br><span class='idioma'>Fran&ccedil;ais</span><br><span class='idioma' ><a href='".str_replace("/fra/", "/esp/", $_SERVER['REQUEST_URI'])."' class='gris_medio'>Espa&ntilde;ol </a></span>";

if($this->seccion=="qdm"  ){
$logo_cab="logo_qdm_p2_".$this->idioma.".gif"; $logo_qdm="ajuste.gif";
$colspan=4;
}elseif($this->seccion=="home"){
$logo_cab="logo_home_qdm_p_".$this->idioma.".gif"; 
}else{ 
$logo_cab="logo_qdm_a.gif";$logo_qdm="cabecera_04_bis.jpg";
$colspan=3;
}
$navega.="                        </td>
		<td rowspan='3' colspan='".$colspan."' align='right'>
			<img src='".$this->url."../../images_logos/$logo_cab' width='537' height='126' alt=''>
                        </td>";

if($colspan==3)
$navega.=" 	<td rowspan='3' valign='top' align='right'>
			<img src='".$this->url."../../images_home/$logo_qdm' width='88' height='92' alt=''></td>
		";
$navega.=" 	<td>	<img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='58' alt=''></td>
                       	</tr>
	<tr>
		<td rowspan='2' width='115' height='68'>                     
                        <form action='".$this->url."../buscador/index.php' method='POST' name='buscador'> <b class='buscador'><br>".$this->datos->traduccion[buscador_web]."</b><br><input type='text' name='busqueda' value='".$_POST[busqueda]."' size='10'><IMG  SRC='".$this->url."../../images_home/pixel_transp.gif' WIDTH=3 HEIGHT=18 ALT='' border=0 ><A  href=\"javascript:document.forms['buscador'].submit();\"><IMG valign='bottom' SRC='".$this->url."../../images_home/btn-search.gif' WIDTH=18 HEIGHT=18 ALT='' border=0 ></a></form></td>
		<td>
			<img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='34' alt=''></td>
	</tr>
	<tr>
		<!-- <td colspan='3' align='right'>
			<img src='".$this->url."../../images_home/cabecera_06.gif' width='293' height='34' alt=''></td> -->
		";
$navega.=" 	 <td></td>
                        
	</tr>
</table>
</td>

</tr>
        
        
        
        	<tr>
		<td colspan='6'>
		<table id='Table_03' width='740'  border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td valign='top' >";
$navega.="<table id='navegador_izq_princ' width='218'  border='0' cellpadding='0' cellspacing='0'>
";

#joao navega
$navega.="<tr>
<td  width='218' >";
if($this->subseccion) $l_url_adj="../".$url_adj; else $l_url_adj=$url_adj;
$navega.="<table width='100%' border='0'  cellspacing=0 cellpadding=0  background='".$this->url."../../images_home/linea_01_666666.jpg' >";
if(in_array($this->seccion_sel, $this->array_princ_joao) or $this->seccion=="buscador" or $this->seccion=="home") $c_00="menu_princ_on"; else $c_00="menu_princ_off";
if($this->idioma=="esp") $info_as="ASOCIACI&Oacute;N QUARTIERS DU MONDE"; else $info_as="ASSOCIATION QUARTIERS DU MONDE";
$navega.="<tr><td class='menu_base_naranja' >
<a href='$l_url_adj../presenta/index.php' class='$c_00' >$info_as</a>
</td></tr>
";
    $this->menu_navega="<a href='$url_adj../index.php' class='menu_princ_on' > ".$this->qdm[$this->idioma]."</a>";

$this->titulo_pagina.=$this->qdm[$this->idioma];
foreach($this->arra_def as $menu){
$this->menu=$menu;
$this->proyecto_01= $menu[0];
$this->proyecto_01_idioma= $menu[$this->numero_idioma];
if($this->subseccion){
  $url_adj="../";
}
    $fin="<tr><td class='menu_princ_naranja' ><img src='".$this->url."../../images_home/pixel_transp.gif' width=4 height=5></td></tr>";
if($this->proyecto_01==$this->seccion_sel ){

if(in_array($this->seccion_sel, $this->array_princ_joao) ){
$navega.="<tr><td class='menu_princ_naranja' bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=20 height=5></td></tr>
<tr><td class='menu_princ_naranja' ><img src='".$this->url."../../images_home/pixel_transp.gif' width=20 height=5></td></tr>";
$this->navega_pri.="<tr><td class='menu_princ_naranja' >
<a href='$url_adj../".$this->proyecto_01."/index.php' class='menu_princ_on' >".$this->proyecto_01_idioma." </a>
</td></tr> $fin $fin";
$this->cambio_menu=true;
}else{
$navega.="<tr><td  bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=20 height=5></td></tr> 
<tr><td  bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=20 height=5></td></tr>";
$this->navega_sec="<tr><td class='menu_base_naranja' >
<a href='$url_adj../".$this->proyecto_01."/index.php' class='menu_princ_on' >".$this->proyecto_01_idioma." </a>
</td></tr> $fin";
}//if in array
    $this->menu_navega=" <a href='$url_adj../".$this->proyecto_01."/index.php' class='menu_princ_on' >".$this->proyecto_01_idioma."</a>";
    $this->titulo_pagina.=" > ".$this->proyecto_01_idioma;

$navega.=$this->navega_sec_simple();

if(in_array($this->seccion_sel, $this->array_princ_joao)) {
$this->navega_pri.= $this->navega_sec;
}else{
$this->cambio_menu=true;
}// if in array
}else{
if($this->proyecto_01<>"qdm"  ){
$this->navega_pri.="<tr><td class='menu_princ_naranja' ><a href='$url_adj../".$this->proyecto_01."/index.php' class='menu_princ_off'>".$this->proyecto_01_idioma."</a></td></tr><tr><td class='menu_princ_naranja' ></td></tr> $fin $fin ";
 $sec_vista=true;
}else{
 $this->navega_sec_bis.="<tr><td bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=4 height=20></td></tr><tr><td class='menu_base_naranja' >
 <a href='$url_adj../".$this->proyecto_01."/index.php' class='menu_princ_off'>".$this->proyecto_01_idioma."</a></td></tr> <tr><td bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=4 height=5></td></tr>";
 $this->navega_sec_bis_bis.="<tr><td bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=4 height=10></td></tr><tr><td class='menu_base_naranja' >
 <a href='$url_adj../".$this->proyecto_01."/index.php' class='menu_princ_on'>".$this->proyecto_01_idioma."</a></td></tr> <tr><td bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=4 height=5></td></tr>";
 }//if($this->proyecto_01<>"qdm")
}//if
}
$this->navega_pri.="<tr><td class='menu_base_naranja' >
<a href='$l_url_adj../index.php' class='menu_princ_on' >&nbsp;</a>
</td></tr>";

$this->navega_pri.= "<tr><td class='menu_princ_naranja' bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=20 height=5></td></tr>";
if(!in_array($this->seccion_sel, $this->array_princ_joao)) {
$navega.=$this->navega_sec;
}else{
$navega.= $this->navega_pri.$this->navega_sec_bis;
}
if($this->seccion=="buscador" or $this->seccion=="home") {
$navega.= $this->navega_sec_bis_bis;
}
if($this->seccion=='mujer' || $this->seccion=='home')$c_00="menu_princ_on"; else $c_00="menu_princ_off";
if($this->idioma=="esp") $info_muj="PROYECTO MUJERES DEL MUNDO: UNA RED DE PROTRAGONISTAS SOLIDARIAS"; else $info_muj="PROJET FEMMES DU MONDE : UN RESEAU DE PROTAGONISTES SOLIDAIRES";

if($this->seccion=='mujer' ){
if($this->idioma=="esp") $infoTT=$this->arra_def[2][1];  else $infoTT=$this->arra_def[2][2];
$navega.="<tr><td bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=4 height=20></td></tr><tr><td class='menu_base_naranja' >
 <a href='$url_adj../".$this->arra_def[2][0]."/index.php' class='menu_princ_off'>".$infoTT."</a></td></tr> <tr><td bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=4 height=5></td></tr>";
$navega.="<tr><td  bgcolor='white'><img src='".$this->url."../../images_home/pixel_transp.gif' width=20 height=5></td></tr> ";


}
$navega.="<tr><td class='menu_base_naranja' >
<a href='$l_url_adj../mujer/foros.php' class='$c_00' >$info_muj</a>
</td></tr>
";
if($_SESSION["foros_tipo"]=='mujer' || $_SESSION["foros_tipo"]=='migraciones'){


//hola$navega.=$this->foros_reg();
$arra_foro_mujer=array();
$arra_foro_mujer=$this->foros_reg();

foreach($arra_foro_mujer as $v=>$c){
$navega.= "<tr><td class='menu_princ_naranja'><a class='menu_princ_off' href='$v'>$c </a></td></tr>";
}
}

if(!$sec_vista) echo "NO";
$navega.="</table>";

#<!-- <img src="../../images_home/home_07_01_02.gif" width="218" height="120" alt=""> -->

$navega.="</td>
</tr>";

$navega.="<tr>
<td bgcolor='white'>
<img src='".$this->url."../../images_home/pixel_transp.gif' width='218' height='39' alt='' ></td>
</tr>
</table>

                        </td>
                        <td width='522'  valign='top'>";   
return $navega;
}//navega_izquierdo


function navega_sec_simple(){
if($this->cambio_menu){
 $this->pri_00="menu_princ_naranja";
 $this->sec_00="menu_sec_naranja";
 $this->ter_00="menu_terc_naranja";
  $this->cua_00="menu_cuat_naranja";
  $this->table_sec_00="menu_sec";
$this->linea_02="linea_02_666666";
$this->linea_03="linea_03_666666";
$this->linea_04="linea_04_666666";
 }else{
  $this->pri_00="menu_base_naranja";
 $this->sec_00= "menu_princ_naranja";
 $this->ter_00= "menu_sec_naranja";
  $this->cua_00="menu_terc_naranja";
$this->linea_02="linea_01_666666";
$this->linea_03="linea_02_666666";
$this->linea_04="linea_03_666666";
 }//if
    $fin="<tr><td class='".$this->pri_00."' ><img src='".$this->url."../../images_home/pixel_transp.gif' width=4 height=5></td></tr>";

if(is_array($this->menu[6])){
$navega.="<tr><td >
<table id='menu_sec' width='218'  border='0' cellpadding='0' cellspacing='0' background='".$this->url."../../images_home/".$this->linea_02.".jpg'>";
foreach($this->menu[6] as $submenu_clave=> $submenu_valor){
if($this->subseccion){
$this->equipo_actual=$this->equipos_trabajo[$this->subseccion][0];
$this->id_equipo_actual=$this->equipos_trabajo[$this->subseccion][1];
  $url_completa="equipos.php";
  $url_adj="../../qdm/";
}else{
if($_GET[id]) $url_completa=$this->archivo."?id=".$_GET[id];
elseif($this->id_reg){
 $url_completa=$this->archivo."?id=".$this->id_reg; 
 }else{
  $url_completa=$this->archivo;
  }
  }
#echo "PP___".$submenu_clave." $url_completa <br>";
if($submenu_clave=="equipos.php" && $this->equipo_actual) $submenu_valor.= ": ".$this->equipo_actual;
if($submenu_clave==$url_completa){
$navega.="<tr><td class='".$this->sec_00."'  ><img src='".$this->url."../../images_home/pixel_transp.gif' height=5 width=1></td></tr><tr><td class='".$this->sec_00."' ><a href='$url_adj$submenu_clave' class='menu_princ_on' > $submenu_valor</a></td> $fin";
    $this->menu_navega="<a href='$submenu_clave' class='menu_princ_on' >".$submenu_valor."</a>";
$this->titulo_pagina.=" > $submenu_valor";
if($submenu_valor=="FOROS"){
if($_SESSION["foros_reg"])
$navega.=$this->navega_terciario();
}else{
$navega.=$this->navega_terciario();
}//if foros no reg
}else{

$navega.="<tr><td class='".$this->sec_00."' ><img src='".$this->url."../../images_home/pixel_transp.gif' height=5 width=1></td></tr><tr><td class='".$this->sec_00."' ><a href='$url_adj$submenu_clave' class='menu_princ_off'  > $submenu_valor </a></td></tr> $fin";

}//if
}//foreach

$navega.="</table></td></tr> $fin $fin";
}//if
 $this->navega_sec.=$navega;
}//function





function navega_terciario(){
    $fin="<tr><td class='".$this->pri_00."' ><img src='".$this->url."../../images_home/pixel_transp.gif' width=4 height=5></td></tr>";
    if(is_array($this->menu[7]) ){
    #die();
    $navega.="	<tr><td>
    <table id='menu_terc' width='218'  border='0' cellpadding='0' cellspacing='0' background='".$this->url."../../images_home/".$this->linea_03.".jpg'>";
    foreach($this->menu[7] as $clave=>$valor){
    if($this->subseccion){
    $url_completa=$this->archivo;
    }else
    if($_GET[id]) $url_completa=$this->archivo."?id=".$_GET[id];
elseif($this->id_reg){
 $url_completa=$this->archivo."?id=".$this->id_reg; 
 }elseif(!$this->id_reg or !$_GET[id]){
  $url_completa=$this->archivo;
  }
#echo "<b>TT--- $clave $valor <br>$url_completa </b><br>";
if($clave== $url_completa){
    $navega.="<tr><td class='".$this->ter_00."' >
    <a href='$clave' class='menu_princ_on' > $valor </a>
    </td></tr>
   $fin";
       $this->menu_navega="<a href='$clave' class='menu_princ_on' >".$valor."</a>";
$this->titulo_pagina.=" > ".$valor;
        $navega.=$this-> navega_cuaternario();
    }else {

    $navega.="<tr><td class='".$this->ter_00."' >
    <a href='$clave' class='menu_princ_off' > $valor </a>
    </td></tr>
    $fin";
}//if
    }//foreach
    
    $navega.="	
        </table>
            </td></tr>
    ";
    }//if isarray

    return $navega;
}//function navega terciario



function navega_cuaternario(){
    if(is_array($this->menu[8]) ){
    #die();
    $navega.="	<tr><td>
    <table id='menu_terc' width='218'  border='0' cellpadding='0' cellspacing='0' background='".$this->url."../../images_home/".$this->linea_04.".jpg'>
";
    foreach($this->menu[8] as $clave=>$valor){
    if($_GET[id]) $url_completa=$this->archivo."?id=".$_GET[id];
elseif($this->id_reg){
 $url_completa=$this->archivo."?id=".$this->id_reg; 
 }elseif(!$this->id_reg or !$_GET[id]){
  $url_completa=$this->archivo;
  }
#echo "<b>CC--- $clave $valor <br>$url_completa </b><br>";
if($clave== $url_completa){
    $navega.="<tr><td class='".$this->cua_00."' >
    <a href='$clave' class='menu_princ_on' > $valor </a>
    </td></tr>
    <tr><td class='".$this->cua_00."' ><img src='".$this->url."../../images_home/pixel_transp.gif' height=5 width=1></td></tr>";
    $this->menu_navega=" <a href='$clave' class='menu_princ_on' >".$valor."</a>";
    }else {
    $navega.="<tr><td class='".$this->cua_00."' >
    <a href='$clave' class='menu_princ_off'  > $valor </a>
    </td></tr>
    <tr><td class='".$this->cua_00."' ><img src='".$this->url."../../images_home/pixel_transp.gif' height=5 width=1></td></tr>";
}//if
    }//foreach
    
    $navega.="	
        </table>
            </td></tr>
    ";
    }//if isarray
    return $navega;
}//function navega cuaternario

function cubito_mas_info_qdm($info=""){
return "<div align='left'><img src='".$this->url."../../images_home/cubito_ff9900.gif'>&nbsp;<span class='modulo_titulo'> $info </span></div>";
}


function modulo_qdm($titulo="", $arra_info="", $navegador_h=""){

$this->menu_navega.=" > ";
$salida.= "<table id='interior' width='522'  border='0' cellpadding='0' cellspacing='0' >
	<tr>
		<td >
			<img src='".$this->url."../../images_home/pixel_blanco.jpg' width='522' height='12' alt=''></td>
	</tr>
                <tr><td  style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-x ;' > <img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='1' alt=''></td></tr>";
$salida.= "<tr><td  ><img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='10' alt=''></td></tr>";

if($titulo)$salida.= "<tr><td class='navega_titulo'><div class='margin_20px'>$titulo</div></td></tr>";
$salida.= "<tr><td  ><img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='3' alt=''></td></tr>";

$salida.= "<tr><td  ><img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='3' alt=''></td></tr>

        <tr><td > <img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='1' alt=''></td></tr>



	<tr>
		<td>
			
                        <table id='modulo' width='522'  border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-y ;'>
			<img src='".$this->url."../../images_home/v1_666666.jpg' width='13' height='13' alt=''> </td>
		<td style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-x ;' >
			<img src='".$this->url."../../images_home/pixel_transp.gif' width='496' height='13' alt=''>
                        </td>
		<td >
			<img src='".$this->url."../../images_home/curva_v2_666666.jpg' width='13' height='13' alt=''></td>
	</tr>
	<tr>
		<td style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-y ;'>
			<!-- <img src='".$this->url."../../images_home/pixel_blanco.jpg' width='13' height='13' alt=''>--></td><td valign='top'  style='text-align:justify'>";
                        
if(is_array($arra_info)){
foreach($arra_info as $info_reg)
if($info_reg[1]){


if(strstr($info_reg[0], "*/")){
$info_parrafo=explode("*/", $info_reg[0]);
$info_parrafo_tit=$info_parrafo[0];
$info_parrafo_text=$info_parrafo[1];
$salida.= "<div align='left'><br><br><img src='".$this->url."../../images_home/cubito_ff9900.gif'>&nbsp;<span class='modulo_titulo'> $info_parrafo_tit</span></div><br>";
$inicio_j=1;
}else{
$inicio_j=0;
$info_parrafo_text=$info_reg[0];

}//if strstr($info_reg[0], "*"


$info_a=explode("\n", $info_reg[0]);
if(count($info_a)>1) $info_parrafo_text=$info_a[0];

$abc=@imagecreatefromjpeg($this->url."../../imgs/".$info_reg[1]);
$abc_zz=@imagecreatefromjpeg($this->url."../../imgs/".str_replace('mm','zz',$info_reg[1]));
$ancho=@ImageSX($abc);
$alto=@ImageSY($abc);
$ancho_zz=@ImageSX($abc_zz);
$alto_zz=@ImageSY($abc_zz);
if($ancho<>$ancho_zz && $abc_zz)
$img="<table width=$ancho height=$alto border=1 bordercolor='#FF6600' cellpadding=0 cellspacing=0><tr><td><a href='#' onclick=\"javascript:window.open('".$this->url."../../imgs/".str_replace('mm','zz',$info_reg[1])."','pop','toolbar=no, location=no, status=no, width=$ancho_zz, height=$alto_zz, left=0, top=0, scrollbars=no, resizable=yes');\"><img src='".$this->url."../../imgs/".$info_reg[1]."'  border=0 alt='zoom' width=$ancho height=$alto></a></td></tr></table>";
else
$img="<img src='".$this->url."../../imgs/".$info_reg[1]."'  border=0 width=$ancho height=$alto>";


$temp= "<table width='100%' cellpadding=0 cellspacing=0 border=0><tr><td valign='top' width=100> $img </td><td valign='top' class='td_img_info' style='text-align:justify'>".$info_parrafo_text."</td><tr></table><br>";
$salida.=$temp;
for($j=$inicio_j+1; $j<count($info_a); $j++)
$salida.=$info_a[$j]."<br>";

}else{
if(strstr($info_reg[0], "*/")){
$info_parrafo=explode("*/", $info_reg[0]);
$info_parrafo_tit=$info_parrafo[0];
$salida.= "<div align='left'><br><br><img src='".$this->url."../../images_home/cubito_ff9900.gif'>&nbsp;<span class='modulo_titulo'> $info_parrafo_tit</span></div><br>";
$salida.=$info_parrafo[1]."<br>";
}else{
$salida.=$info_reg[0]."<br><br><br>";
}//if *
}

}else{//is array
$salida.=$arra_info;
}//if is array

$salida.= "<br><br></td>
		<td style='background: url(".$this->url."../../images_home/dot_666666_left.jpg) repeat-y ;'>
			<!-- <img src='".$this->url."../../images_home/pixel_blanco.jpg' width='13' height='13' alt=''>-->
                        </td>
	</tr>
	<tr>
		<td>
			<img src='".$this->url."../../images_home/curva_v4_666666.jpg' width='13' height='13' alt=''></td>
		<td style='background: url(".$this->url."../../images_home/dot_666666_down.jpg) repeat-x ;'>
			<img src='".$this->url."../../images_home/pixel_transp.gif' width='477' height='13' alt=''></td>
		<td>
			<img src='".$this->url."../../images_home/v4_666666.jpg' width='13' height='13' alt=''></td>
	</tr>
</table>

                        <!-- <img src='../../images_home/tabla_03.gif' width='462' height='332' alt=''>-->
                        </td>
	</tr>
	<tr>
		<td>
			<img src='".$this->url."../../images_home/pixel_blanco.jpg' width='462' height='20' alt=''></td>
	</tr>
</table>

                        
                        </td>
	</tr>
</table>";
return $salida;
}//function_modulo_qdm


function copy_qdm(){                    
$copy.="                        </td>
	</tr>";
$copy.="<tr>
        <td align='left' colspan=6><table width='180' cellspacing=10>
        
        <tr><td style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-x ;'><img src='".$this->url."../../pixel_blanco.jpg' width='1' height='1'></td></tr>
        <tr><td  align='center' style='color: #333333;'><b style='color: #FF6600;'>&copy;</b> QuartierDuMonde</td></tr>
        <tr><td  style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-x ;'><img src='".$this->url."../../pixel_blanco.jpg' width='1' height='40'></td></tr>
        </table></td></tr>
        <tr><td colspan=6><table  width='740'  border='0' cellpadding='0' cellspacing='0' BGCOLOR='#FFFFFF'><tr><td align='left' >&nbsp;&nbsp;&nbsp;<a href='http://mediaymedia.com/' target='blank' class='gris_medio'>webDesign:</a><a href='http://mediaymedia.com/' target='blank' class='gris_claro'>mediaymedia.com</a><br><br><br></td></tr></table></td>
                
";
return $copy;
}//function_copy_qdm

function presenta_reg($reg){
if($this->archivo=="red.php") $cont=" and presentacion_red=1 ";
elseif($this->archivo=="presenta.php") $cont=" and presentacion_red=0 ";
$id_registro_00=$reg;
$q_presenta="select titulo_esp,titulo_fra, id_noticia_01 as indice  from noticia_01 where id_registro_00=$id_registro_00 and  noticia_01_id_noticia_00=0  $cont order by id_noticia_01 ";
	   $this->conecto_datos->query($q_presenta);
	$arra_prov=array();
    while($this->conecto_datos->next_record()){
    if(!$comienzo  && !$_GET['id']){$comienzo=true; 
    $this->id_reg=$this->conecto_datos->Record[indice];}
    if($this->conecto_datos->Record["titulo_".$this->idioma]) $titul=$this->conecto_datos->Record["titulo_".$this->idioma]; 
    else $titul=$this->conecto_datos->Record["titulo_".$this->otro_idioma];
	#echo $titul."<br>";
    $arra_prov[$this->archivo."?id=".$this->conecto_datos->Record[indice]]= $titul;
    }//while
    $comienzo=false;
    if($this->conecto_datos->record_count>1) return $arra_prov;

}//funtion


function objetivos_reg($seccion, $i_reg){
    $this->conecto_datos->query("select id_noticia_00 as indice, noticia_00_esp,  noticia_00_fra from noticia_00 
    right join noticia_01 on (id_noticia_00=noticia_01_id_noticia_00) 
    where seccion_principal='$seccion' and noticia_00.id_registro_00=$i_reg order by id_noticia_00 
    ");
    $arra_prov=array();
    while($this->conecto_datos->next_record()){
    if(!$comienzo && !$_GET['id']){$comienzo=true; $this->id_reg=$this->conecto_datos->Record[indice];}
        if($this->conecto_datos->Record["noticia_00_".$this->idioma]) $titul=$this->conecto_datos->Record["noticia_00_".$this->idioma]; 
    else $titul=$this->conecto_datos->Record["noticia_00_".$this->otro_idioma];

    $arra_prov[$this->archivo."?id=".$this->conecto_datos->Record[indice]]=$titul;
    }
    if($this->conecto_datos->record_count>1) return $arra_prov;
}//function


function foros_reg(){
    $arra_prov=array();
$tipo=0;
$validar_foros=$_SESSION["foros_reg"];
$tipo_foro=$_SESSION["foros_tipo"];
if($validar_foros)
if($tipo_foro=="grupo") $tipo=1;
elseif($tipo_foro=="mujer") $tipo=3;
elseif($tipo_foro=="migraciones") $tipo=4;
else $tipo=2;
$where_add="where foro_grupo_joven=".$tipo;
$qq="select id_foros_00 as indice, nombre_foro_esp, nombre_foro_fra  from foros_00  ".$where_add." order by id_foros_00 desc";
    $this->conecto_datos->query($qq);
    while($this->conecto_datos->next_record()){
    if(!$comienzo && !$_GET['id']){$comienzo=true; $this->id_reg=$this->conecto_datos->Record[indice];}
            if($this->conecto_datos->Record["nombre_foro_".$this->idioma]) $titul=$this->conecto_datos->Record["nombre_foro_".$this->idioma];
    else $titul=$this->conecto_datos->Record["nombre_foro_".$this->otro_idioma];

    $arra_prov[$this->archivo."?id=".$this->conecto_datos->Record[indice]]=$titul;
   }
    if($this->conecto_datos->record_count>1) return $arra_prov;
}//function

function docs_adjuntos($seccion="", $id_principal=""){
#  foreach($this->conecto_datos->traduccion as $clave=>$valor) echo "$clave  $valor<hr>";

$this->conecto_datos->query("select * from document_up 
where seccion_principal='$seccion'  and document_up_id_principal=$id_principal");
if($this->conecto_datos->record_count)
while($this->conecto_datos->next_record()){
if($this->conecto_datos->Record["informacion_".$this->idioma]) $info=$this->conecto_datos->Record["informacion_".$this->idioma]; else $info=$this->conecto_datos->Record["informacion_".$this->otro_idioma];
if($this->conecto_datos->Record["document_up_".$this->idioma]) $doc=$this->conecto_datos->Record["document_up_".$this->idioma]; else $doc=$this->conecto_datos->Record["document_up_".$this->otro_idioma];
if($doc){ If(!$uno){$uno=true; 
#if(!$this->conecto_datos->traduccion) $this->conecto_datos->traducir_arra();
$lista_archivos.=$this->cubito_mas_info_qdm($this->conecto_datos->traduccion[descarga_doc])."<br><br>";}

$lista_archivos.="<div class='margin_20px' align='left'><a href='".$this->url."../../imgs/$doc'><img src='$this->url../../gestion/c_99/imgs/".$this->sel_imagen_doc($doc)."' border=0 valign='bottom'> >  $info </a></div><br>";}
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




///// eyyyyy



////eyyyy


function qdm_reg_asoc(){

if($this->subseccion){
if($this->archivo=="presenta.php"){
foreach($this->arra_def[2][6][2][4] as $val)
$oor[$val[0].".php"]=$val[$this->numero_idioma];

$arra_00=array();
$this->arra_def[2][7]=$oor;
$this->arra_def[2][8]=$this->presenta_reg($this->id_equipo_actual);
#foreach($this->arra_def[2][7] as $v->$c) echo $v." $c<br>";

foreach($this->arra_def[2][6] as $val){
 if($val[0].".php"==$this->archivo && !$this->subseccion)$arra_00[$val[0].".php?id=".$this->id_reg]=$val[$this->numero_idioma];
 else $arra_00[$val[0].".php"]=$val[$this->numero_idioma];
 }
$this->arra_def[2][6]=$arra_00;

}elseif($this->archivo=="info.php"){
foreach($this->arra_def[2][6][2][4] as $val)
$oor[$val[0].".php"]=$val[$this->numero_idioma];

$arra_00=array();
$this->arra_def[2][7]= $oor;
$this->arra_def[2][8]=$this->objetivos_reg("c_11", $this->id_equipo_actual);

#foreach($this->arra_def[2][7] as $v->$c) echo $v." $c<br>";

foreach($this->arra_def[2][6] as $val){
 if($val[0].".php"==$this->archivo && !$this->subseccion)$arra_00[$val[0].".php?id=".$this->id_reg]=$val[$this->numero_idioma];
 else $arra_00[$val[0].".php"]=$val[$this->numero_idioma];
 }
$this->arra_def[2][6]=$arra_00;

}elseif($this->archivo=="socios.php" or $this->archivo=="contacto.php" or $this->archivo=="agenda.php" ){
foreach($this->arra_def[2][6][2][4] as $val)
$oor[$val[0].".php"]=$val[$this->numero_idioma];

$arra_00=array();
$this->arra_def[2][7]= $oor;

#foreach($this->arra_def[2][7] as $v->$c) echo $v." $c<br>";

foreach($this->arra_def[2][6] as $val){
 if($val[0].".php"==$this->archivo)$arra_00[$val[0].".php?id=".$this->id_reg]=$val[$this->numero_idioma];
 else $arra_00[$val[0].".php"]=$val[$this->numero_idioma];
 }
$this->arra_def[2][6]=$arra_00;

}//if presenta
#die($this->subseccion);
}elseif(!$this->subseccion){



///	this->seccion=qdm this->subseccion==""
#foreach($this->menu as $v) echo $v."<br>";
if($this->archivo=="equipos.php" or $this->archivo=="socios.php"  or $this->archivo=="contacto.php" or $this->archivo=="agenda.php" ){
$arra_00=array();
foreach($this->arra_def[2][6] as $val) $arra_00[$val[0].".php"]=$val[$this->numero_idioma];
$this->arra_def[2][6]=$arra_00;

}elseif($this->archivo=="presenta.php" or $this->archivo=="red.php"){
$arra_00=array();
$this->arra_def[2][7]=$this->presenta_reg(7);
foreach($this->arra_def[2][6] as $val){
 if($val[0].".php"==$this->archivo)$arra_00[$val[0].".php?id=".$this->id_reg]=$val[$this->numero_idioma];
 else $arra_00[$val[0].".php"]=$val[$this->numero_idioma];
 }
$this->arra_def[2][6]=$arra_00;

}elseif($this->archivo=="info.php"){
$arra_00=array();
$this->arra_def[2][7]=$this->objetivos_reg("c_11",7);
#foreach($this->arra_def[2][7] as $v->$c) echo $v." $c<br>";

foreach($this->arra_def[2][6] as $val){
 if($val[0].".php"==$this->archivo)$arra_00[$val[0].".php?id=".$this->id_reg]=$val[$this->numero_idioma];
 else $arra_00[$val[0].".php"]=$val[$this->numero_idioma];
 }
$this->arra_def[2][6]=$arra_00;
}elseif($this->archivo=="foros.php"){

$arra_00=array();
if($_SESSION["foros_tipo"]=='grupo'  || $_SESSION["foros_tipo"]=='joven' || $_SESSION["foros_tipo"]=='migraciones')
$this->arra_def[2][7]=$this->foros_reg();
#foreach($this->arra_def[2][7] as $v->$c) echo $v." $c<br>";

foreach($this->arra_def[2][6] as $val){
 if($val[0].".php"==$this->archivo)$arra_00[$val[0].".php?id=".$this->id_reg]=$val[$this->numero_idioma];
 else $arra_00[$val[0].".php"]=$val[$this->numero_idioma];
 }
$this->arra_def[2][6]=$arra_00;
}//if
}
}//qdm_reg_asoc
#00000000000000000000000000000000000000000000000000000000000000000000000000000000

function a_html($cadena){

$resultado=strtr($cadena, $this->html);
#$cadena=str_replace("'", "oooooo", $cadena);

#$resultado=str_replace("oooooo", "'", $cadena);
return $resultado;
}//function

function de_html($cadena){
$resultado=strtr($cadena, array_flip($this->html));
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

function convierte_de_html_02($cadena){
$matriz1=get_html_translation_table(HTML_ENTITIES);
$matriz1=array_flip($matriz1);
$resultado=ereg_replace("<br>","\n", $cadena);
$resultado =ereg_replace("<b>","[b]", $resultado);
$resultado =ereg_replace("</b>","[/b]", $resultado);
$resultado =ereg_replace("<i>","[i]", $resultado);
$resultado =ereg_replace("</i>","[/i]", $resultado);
$resultado=strtr($resultado,$matriz1);
return $resultado;
}//function


function salida($info, $open=false, $close=false){
if(!$open && !$close && !$this->open){
$info=$this->head_in().$this->open_body_qdm().$info;
$this->open=true;
}//if
if($open && !$this->open)$info=$this->head_in().$this->open_body_qdm().$info;
if($close)
$info.=$this->copy_qdm().$this->close_body();
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
$info.=strtoupper($this->dias_semana[$i][0]);
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
#cambio_agenda




$info.=$this->mostrar_actuales();
$info.="<td></tr></table>";

return $info;
}//function


function mostrar_actuales(){
$info.="<table width='100%' cellspacing=4 border=0>";
$query_reg ="select * from agenda where MONTH(fecha)=".$this->mes." and year(fecha)=".$this->anyo." and dayofmonth(fecha)=". $this->dia." and id_registro_00=".$this->registro_agenda." order by fecha desc, hora";

$this->conecto_datos->query($query_reg);
if($this->conecto_datos->record_count){
$info.="<tr><td><b>".$this->dia."-".$this->mes."-".$this->anyo."</b></td></tr>";
while($this->conecto_datos->next_record()){
$imagen=$this->conecto_datos->Record["imagen"];
$id_agenda=$this->conecto_datos->Record[id_agenda];
$hora=$this->conecto_datos->Record[hora];
$titular=$this->a_html_format( $this->conecto_datos->Record["titular_".$this->idioma]);
$texto=$this->a_html_format($this->conecto_datos->Record["texto_".$this->idioma]);
if ($imagen){
$abc= @imagecreatefromjpeg($this->url."../../imgs/".$imagen);  
$abc_zz = @imagecreatefromjpeg($this->url."../../imgs/".str_replace('mm','zz',$imagen));  

$ancho=@ImageSX($abc);
$alto=@ImageSY($abc);
$ancho_zz=@ImageSX($abc_zz);
$alto_zz=@ImageSY($abc_zz);
}//if imagen
$arra_agenda[]=array($imagen, $ancho, $alto, $ancho_zz, $alto_zz, $abc_zz, $hora, $titular, $texto, $id_agenda);


}//while
}//if record_count
if(is_array($arra_agenda))
foreach($arra_agenda as $valor_agenda){
if(!$uno){ 
	$info.="<tr><td width=1 style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-x ;'>
	<img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='10' alt=''>
	</td></tr>";
	$uno=true;
}


if($valor_agenda[1]<>$valor_agenda[3] && $valor_agenda[5]){
$img="<table width=$ancho height=$alto cellspacing=0 cellpadding=0 border=1 bordercolor='#FF6600' >
<tr><td>
<a href=\"javascript:window.open('".$this->url."../../imgs/".str_replace('mm','zz',$valor_agenda[0])."','pop','toolbar=no, location=no, status=no, width=$ancho_zz, height=$alto_zz, left=0, top=0, scrollbars=no, resizable=yes');\">
<img src='".$this->url."../../imgs/".$valor_agenda[0]."'  border=0 alt='zoom' width=$ancho height=$alto ></a>
</td></tr>
</table>";
$info.="<tr><td valign='top'  align='left'> $img </td></tr>\n";
}//if

$hora=$valor_agenda[6];

if(!$hora) $hora="00:00:00";
$info.="<tr><td valign='top'  align='left' ><div class='fecha_agenda'><b class='color_333333'>".strftime("%H:%M",strtotime($hora))."</b> - <b class='color_666666'>".$valor_agenda[7]."</b></div><br>".$valor_agenda[8]."<br>";

$info.="<br><br>".$this->doc_relacionados_agenda($valor_agenda[9])."</td></tr>
<tr><td width=1 style='background: url(".$this->url."../../images_home/dot_666666.jpg) repeat-x ;'>
<img src='".$this->url."../../images_home/pixel_transp.gif' width='1' height='10' alt=''>
</td></tr>";

 


}//foreach


$info.="\n";
$info.="</table>";

return $info;
}//function

function doc_relacionados_agenda($id_agenda_prov){
return $this->docs_adjuntos("c_16",$id_agenda_prov);
}

//00000000000000000000000000000   AGENDA  000000000000000000
}//class
?>

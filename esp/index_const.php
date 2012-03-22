<?php
$arra_princ=array(
"PRESENTACION"=>array("ff9900", "ffcc66", "CC6633",array(
                    "presenta1"=>array(
                "PRESENTACION", 
                "INFORMACIONES"),
                    "presenta2"=>null
                    )
        ), 

"OBJETIVOS"=>array("999933", "cccc66","333333", array(
                    "objetivo1"=>array(
                "PRESENTACION", 
                "INFORMACIONES"),
                    "objetivo2"=>null
                    )
        ), 
"PROYECTOS"=>array("ffcc00","ffffcc","CC9900", array(
        "QUARTIERS DU MONDE"=>array(
                "PRESENTACION", 
                "INFORMACIONES", 
                "LISTADO DE EQUIPOS DE TRABAJO", 
                "AGENDA", 
                "SOCIOS COLABORADORES", 
                "CONTACTO"
                ), 
        "PROYECTO2"=>NULL)
        ),
"SOCIOS COLABORADORES"=>array("cc6633", "ffcc99","993300", array(
                    "presenta1"=>array(
                "PRESENTACION", 
                "INFORMACIONES"),
                    "presenta2"=>null
                    )
        ), 

"AGENDA"=>array("ff9900", "ffcc66","CC6633", null),
"CONTACTO"=>array("996666", "cc9999","663333", array(
                    "presenta1"=>array(
                "PRESENTACION", 
                "INFORMACIONES"),
                    "presenta2"=>null
                    )
        )
);
if($_GET[principal]<>"")$principal=$_GET[principal]; else $principal="PRESENTACION";
$color_base=$arra_princ[$principal][0];
$color_base_suave=$arra_princ[$principal][1];
$color_base_oscuro=$arra_princ[$principal][2];
echo "<html>
<head>
<title>qdm-04- construccion</title>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<link rel='stylesheet' type='text/css' href='../../css/estilos_web.css'>
</head>
<body  leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' style='background: url(images/fondo_l2_$color_base.jpg) repeat-y 50% 0;'>
<div align='center' valign='top'>
<table id='Table_01' width='740' height='550' border='0' cellpadding='0' cellspacing='0' BGCOLOR='#FFFFFF'>
	<tr>
		<td width='93' height='126' valign='top'><br><span class='idioma'><a href='#' class='gris_medio'>Francais</a></span><br><span class='idioma' style='color:#$color_base'>Espa&ntilde;ol </span>
			<!-- <img src='images/home_01.jpg'  alt=''> -->
                        </td>
		<td>
			<img src='images/home_02.gif' width='109' height='126' alt=''></td>
		<td>
			
                                            <table id='Table_02' width='300' height='126' border='0' cellpadding='0' cellspacing='0'>
                                            <tr>
                                            <td>
                                            <img src='images/home_03_01.gif' width='300' height='52' alt=''></td>
                                            </tr>
                                            <tr>
                                            <td bgcolor='#FFFFFF'  width='300' height='74'>
                                            <img src='images/pixel_blanco.jpg' width='300' height='74' alt=''>
                                            </td>
                                            </tr>
                                            </table>
                                                        </td>
		<td>
			<img src='images/pixel_blanco.jpg' width='66' height='126' alt=''></td>
		<td width='119' height='126' valign='top'>
		                <form action='../buscador/index.php' method='POST' name='buscador'> <b class='buscador'><br>Buscador web</b><br><input type='text' name='busqueda' value='' size='10'>&nbsp;<A  href='javascript:document.forms['buscador'].submit();'><IMG valign='bottom' SRC='images/btn-search.gif' WIDTH=18 HEIGHT=18 ALT='' border=0></a></form>

                        	<!-- <img src='images/home_05.gif' width='119' height='126' alt=''> --> 
                        </td>
		<td>
			<img src='images/home_06_$color_base.gif' width='53' height='126' alt=''></td>
	</tr>
	<tr>
		<td colspan='6'>
		<table id='Table_03' width='740' height='424' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td valign='top'>";
echo "<table id='Table_04' width='218'  border='0' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table id='Table_05' width='218' height='68' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td>
			<img src='images/pixel_$color_base.jpg' width='109' height='68' alt=''></td>
		<td>
			<img src='images/menu_curva_sup_$color_base.gif' width='109' height='68' alt=''></td>
	</tr>
</table>
</td>
</tr>
<tr>
<td  width='218' >";

echo "<table width='100%' border='0' cellspacing=0 cellpadding=0 >";
foreach($arra_princ as $v=>$val){
if($v==$principal){
if(is_array($val[3])){
$inicio="<tr><td><img src='images/menu_princ_on_$color_base.gif' width=178 height=8></td></tr>";
$fin="<tr><td class='menu_princ_naranja' style=\"background-image:url('images/fondo_".$color_base."_menu.gif');background-repeat: repeat-y;\"><img src='images/pixel_transp.gif' width=4 height=4></td></tr>";
$color_cambio=$color_base;
echo $inicio;
}else{
$color_cambio=$color_base_suave;
$fin="";
}
echo "<tr><td class='menu_princ_naranja' style=\"background-image:url('images/fondo_".$color_cambio."_menu.gif');background-repeat: repeat-y;\">
<a href='?principal=$v' class='menu_princ_on' style='color:#$color_base_oscuro'> $v</a>
</td></tr> $fin";
if(is_array($val[3])){
echo "<tr><td >
<table id='menu_sec' width='218'  border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td>
			<img src='images/menu_sec_01_$color_base.gif' width='218' height='9' alt=''></td>
	</tr>";
        foreach($val[3] as $sec_v=>$sec_val){
if($sec_v==$_GET[secundario]){
echo "<tr><td class='menu_sec_naranja' style=\"background-image:url('images/menu_sec_02_".$color_base.".jpg');background-repeat: repeat-x;\"><img src='images/pixel_transp.gif' height=5 width=1></td></tr><tr><td class='menu_sec_naranja' style=\"background-image:url('images/menu_sec_02_".$color_base.".jpg');background-repeat: repeat-y;\"><a href='?principal=$v&secundario=$sec_v' class='menu_princ_on' style='color:#$color_base_oscuro'>:: $sec_v </a></td></tr><tr><td class='menu_sec_naranja' style=\"background-image:url('images/menu_sec_02_".$color_base.".jpg');background-repeat: repeat-x;\"><img src='images/pixel_transp.gif' height=5 width=1></td></tr>";
if(is_array($sec_val)){
echo "	<tr><td>
<table id='menu_terc' width='218'  border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td>
			<img src='images/menu_terc_01_$color_base.gif' width='218' height='9' alt=''></td>
	</tr>";
foreach($sec_val as $terc_v){
if($_GET[terciario]==$terc_v)
echo "<tr><td class='menu_terc_naranja' style=\"background-image:url('images/menu_terc_02_".$color_base.".jpg');background-repeat: repeat-y;\"><a href='?principal=$v&secundario=$sec_v&terciario=$terc_v' class='menu_princ_on' style='color:#$color_base_oscuro'>:: $terc_v </a></td></tr><tr><td class='menu_terc_naranja' style=\"background-image:url('images/menu_terc_02_".$color_base.".jpg');background-repeat: repeat-y;\"><img src='images/pixel_transp.gif' height=5 width=1></td></tr>";
else 
echo "<tr><td class='menu_terc_naranja' style=\"background-image:url('images/menu_terc_02_".$color_base.".jpg');background-repeat: repeat-y;\"><a href='?principal=$v&secundario=$sec_v&terciario=$terc_v' class='menu_princ_off' style='color:#$color_base_suave'>:: $terc_v </a></td></tr><tr><td class='menu_terc_naranja' style=\"background-image:url('images/menu_terc_02_".$color_base.".jpg');background-repeat: repeat-y;\"><img src='images/pixel_transp.gif' height=5 width=1></td></tr>";
}//foreach

echo "	<tr>
		<td>
			<img src='images/menu_terc_04_$color_base.gif' width='218' height='9' alt=''></td>
	</tr>
</table>
        </td></tr>
";
}//if isarray
}else{
echo "<tr><td class='menu_sec_naranja' style=\"background-image:url('images/menu_sec_02_".$color_base.".jpg');background-repeat: repeat-y;\"><img src='images/pixel_transp.gif' height=5 width=1></td></tr><tr><td class='menu_sec_naranja' style=\"background-image:url('images/menu_sec_02_".$color_base.".jpg');background-repeat: repeat-y;\"><a href='?principal=$v&secundario=$sec_v' class='menu_princ_off'  style='color:#$color_base_suave'>:: $sec_v </a></td></tr>";

}//if
}//foreach

echo "	 <tr>
		<td>
			<img src='images/menu_sec_04_".$color_base.".gif' width='218' height='9' alt=''></td>
	</tr>
 <tr>
		<td>
			<img src='images/fondo_".$color_base."_menu.gif' width='218' height='9' alt=''></td>
	</tr>
</table>
</td></tr>";
}//if

}else{
echo "<tr><td class='menu_princ_naranja' style=\"background-image:url('images/fondo_".$color_base."_menu.gif');background-repeat: repeat-y;\"><a href='?principal=$v' class='menu_princ_off'>$v</a></td></tr><tr><td class='menu_princ_naranja' style=\"background-image:url('images/fondo_".$color_base."_menu.gif');background-repeat: repeat-y;\"><img src='images/pixel_$color_base.jpg' height=4></td></tr>";
}//if
}
echo "</table>";

#<!-- <img src="images/home_07_01_02.gif" width="218" height="120" alt=""> -->

echo "</td>
</tr>
<tr>
<td>
<table id='Table_06' width='218' height='70' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td>
			<img src='images/pixel_$color_base.jpg' width='109' height='70' alt=''></td>
		<td>
			<img src='images/menu_curva_inf_$color_base.gif' width='109' height='70' alt=''></td>
	</tr>
</table>

</td>
</tr>
<tr>
<td>
<img src='images/pixel_transp.gif' width='218' height='39' alt='' ></td>
</tr>
</table>

                        </td>";

echo "		<td width='522' height='424' valign='top'>                
<!-- <img src='images/home_07_02.jpg' width='522' height='424' alt=''> -->
                        
<table id='interior' width='522' height='395' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan='3' class='navega_sup' style='color: #".$color_base.";background-color:#".$color_base_suave.";
'><b>Presentaci&oacute;n del proyecto en Palma de Mallorca</b>
			<!--<img src='images/pixel_blanco.jpg' width='522' height='19' alt=''>-->
                        </td>
	</tr>
	<tr>
		<td colspan='3'>
			<img src='images/pixel_blanco.jpg' width='522' height='19' alt=''></td>
	</tr>
	<tr>
		<td rowspan='2'>
			<img src='images/pixel_blanco.jpg' width='13' height='376' alt=''></td>
		<td>
			
                        <table id='modulo' width='462' height='332' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td>
			<img src='images/v1_$color_base.gif' width='13' height='13' alt=''></td>
		<td>
			<img src='images/pixel_blanco.jpg' width='436' height='13' alt=''></td>
		<td>
			<img src='images/v2_$color_base.gif' width='13' height='13' alt=''></td>
	</tr>
	<tr>
		<td>
			<img src='images/pixel_blanco.jpg' width='13' height='306' alt=''></td>
		<td>
			<!-- <img src='images/modulo_05.gif' width='436' height='306' alt=''>-->
                        <h3 style='color: #".$color_base.";'>Presentaci&oacute;n de Barrios del Mundo en Mallorca</h3>
El proyecto Barrios del Mundo se propone realizar una iniciaci&oacute;n a las 
pol&iacute;ticas de la ciudad y a la participaci&oacute;n ciudadana de los j&oacute;venes 
de nueve ciudades del Sur y del Norte a traves de la realizaci&oacute;n de una 
investigaci&oacute;n-acci&oacute;n participativa sobre su vida. <br>
Este proyecto permitir&aacute; conocerse los unos a los otros, el Norte y el Sur, 
para construir una mirada com&uacute;n frente a la exclusi&oacute;n social y a 
la cuidadan&iacute;a a traves de encuentros y intercambios permitiendo la formaci&oacute;n, 
el debate y la reflexi&oacute;n entre los habitantes de los barrios.
<br><br><img src='images/cubito_".$color_base.".gif'>&nbsp;<b>Contexto del proyecto</b><br><br>
<table width='100%'><tr><td valign='top'><img src='images/foto_prueba_bamako.jpg' ></td><td valign='top' class='td_img_info'>
Asistimos desde algunos a&ntilde;os, en las grandes ciudades del mundo, al Sur 
como al Norte, a un crecimiento urbano descontrolado. Este fen&oacute;meno se 
manifiesta por movimientos de migraci&oacute;n urbanos de poblaciones viniendo 
del interior del pa&iacute;s y/o de pa&iacute;s m&aacute;s pobres. Eso desemboca 
en un fen&oacute;meno de crecimiento demogr&aacute;fico que llena las ciudades 
de habitantes desarraigados, subvalorizados en su cultura de origen, y sin referencias 
culturales locales o afectivas que podr&iacute;an hacer que se integren y se protegen 
socialmente.</td><tr></table><br>
En todas las ciudades del mundo, de manera organizada o espont&aacute;nea (seg&uacute;n 
el grado de intervenci&oacute;n de las autoridades p&uacute;blicas), estas poblaciones 
se encuentran agrupadas en barrios llamados, seg&uacute;n los pa&iacute;ses : 
&quot;cit&eacute;s&quot;, &quot;favelas&quot;, &quot;villas miserias&quot;, &quot;pueblos 
jovenes&quot;, etc. Estos barrios presentan numerosas caracter&iacute;sticas comunes 
a pesar de los diferentes niveles econ&oacute;micos de los pa&iacute;ses. Se trata 
de una falta de opurtunidades, una falta o una insuficiencia de infraestructura 
p&uacute;blica, de la marginalizaci&oacute;n debida al prejuicio que asimila la 
pobreza a la delincuencia, a la violencia, al desempleo, a la exclusi&oacute;n 
social, etc.
            </td>
		<td>
			<img src='images/pixel_blanco.jpg' width='13' height='306' alt=''></td>
	</tr>
	<tr>
		<td>
			<img src='images/v3_$color_base.gif' width='13' height='13' alt=''></td>
		<td>
			<img src='images/pixel_blanco.jpg' width='436' height='13' alt=''></td>
		<td>
			<img src='images/v4_$color_base.gif' width='13' height='13' alt=''></td>
	</tr>
</table>

                        <!-- <img src='images/tabla_03.gif' width='462' height='332' alt=''>-->
                        </td>
		<td rowspan='2'>
			<img src='images/pixel_blanco.jpg' width='47' height='376' alt=''></td>
	</tr>
	<tr>
		<td>
			<img src='images/pixel_blanco.jpg' width='462' height='60' alt=''></td>
	</tr>
</table>

                        
                        </td>
	</tr>
</table>
	
                        
                        </td>
	</tr>
        <tr>
        <td align='center' colspan=6><table width='50%'>
        
        <tr><td style='background: url(images/fondo_linea_puntos_h_$color_base.jpg) repeat-x ;'><img src='pixel_blanco.jpg' width='1' height='1'></td></tr>
        <tr><td  align='center'><br>&copy; QuartierDuMonde<br><br></td></tr>
        <tr><td  style='background: url(images/fondo_linea_puntos_h_$color_base.jpg) repeat-x ;'><img src='pixel_blanco.jpg' width='1' height='40'></td></tr>
        </table></td></tr>
</table>
</div>
<div align='center' valign='top'><table  width='740'  border='0' cellpadding='0' cellspacing='0' BGCOLOR='#FFFFFF'><tr><td align='left' >&nbsp;&nbsp;&nbsp;<a href='http://mediaymedia.com/' target='blank' class='gris_medio'>webDesign:</a><a href='http://mediaymedia.com/' target='blank' class='gris_claro'>mediaymedia.com</a>&nbsp;&nbsp;&nbsp;<br><br></td></tr></table></div>
</body>
</html>";
?>
<?php
require("../../include/objeto.php");
$objeto=new objeto();
$hoy=date("Y-m-d");
if($hoy<>leer_doc("fecha_mail.txt")){
$arra_traducciones=array(
'select id_document_up as id_seccion, document_up_esp as "esp", document_up_fra as "fra", document_up_check_fra as check_fra, "document_up" as tabla, "document_up_idioma" as campo_actualizar, "id_document_up" as campo_id , "doc" as tipo from document_up where document_up_esp<>"" or document_up_fra<>""',
'select id_socios_00 as id_seccion, informacion_esp as "esp", informacion_fra as "fra", informacion_check_fra as check_fra, "socios_00" as tabla, "informacion_idioma" as campo_actualizar, "id_socios_00" as campo_id , "idioma" as tipo from socios_00',
'select id_traducir_web as id_seccion, texto_esp as "esp", texto_fra as "fra", texto_check_fra as check_fra, "traducir_web" as tabla, "texto_idioma" as campo_actualizar, "id_traducir_web" as campo_id , "idioma" as tipo from traducir_web',
'select id_noticia_00 as id_seccion, noticia_00_esp as "esp", noticia_00_fra as "fra", noticia_00_check_fra as check_fra, "noticia_00" as tabla, "noticia_00_idioma" as campo_actualizar, "id_noticia_00" as campo_id , "idioma" as tipo from noticia_00',
'select id_noticia_01 as id_seccion, titulo_esp as "esp", titulo_fra as "fra", titulo_check_fra as check_fra, "noticia_01" as tabla, "titulo_idioma" as campo_actualizar, "id_noticia_01" as campo_id , "idioma" as tipo from noticia_01',
'select id_noticia_02 as id_seccion, parrafo_esp as "esp", parrafo_fra as "fra", parrafo_check_fra as check_fra, "noticia_02" as tabla, "parrafo_idioma" as campo_actualizar, "id_noticia_02" as campo_id , "idioma" as tipo from noticia_02',
'select id_agenda as id_seccion, titular_esp as "esp", titular_fra as "fra", titular_check_fra as check_fra, "agenda" as tabla, "titular_idioma" as campo_actualizar, "id_agenda" as campo_id , "idioma" as tipo from agenda',
'select id_agenda as id_seccion, texto_esp as "esp", texto_fra as "fra", texto_check_fra as check_fra, "agenda" as tabla, "texto_idioma" as campo_actualizar, "id_agenda" as campo_id , "idioma" as tipo from agenda',
'select id_foros_00 as id_seccion, nombre_foro_esp as "esp", nombre_foro_fra as "fra", nombre_foro_check_fra as check_fra, "foros_00" as tabla, "nombre_foro_idioma" as campo_actualizar, "id_foros_00" as campo_id , "idioma" as tipo from foros_00',
'select id_foros_00 as id_seccion, informacion_foro_esp as "esp", informacion_foro_fra as "fra", informacion_foro_check_fra as check_fra, "foros_00" as tabla, "informacion_foro_idioma" as campo_actualizar, "id_foros_00" as campo_id , "idioma" as tipo from foros_00',
'select id_document_up as id_seccion, informacion_esp as "esp", informacion_fra as "fra", informacion_check_fra as check_fra, "document_up" as tabla, "informacion_idioma" as campo_actualizar, "id_document_up" as campo_id , "idioma" as tipo from document_up',
'select id_equipos_00 as id_seccion, informacion_esp as "esp", informacion_fra as "fra", informacion_check_fra as check_fra, "equipos_00" as tabla, "informacion_idioma" as campo_actualizar, "id_equipos_00" as campo_id , "idioma" as tipo from equipos_00',
'select id_contacto_00 as id_seccion, contacto_00_esp as "esp", contacto_00_fra as "fra", contacto_00_check_fra as check_fra, "contacto_00" as tabla, "contacto_00_idioma" as campo_actualizar, "id_contacto_00" as campo_id , "idioma" as tipo from contacto_00',
'select id_foro01 as id_seccion, foro01_titulo_esp as "esp", foro01_titulo_fra as "fra", foro01_titulo_check_fra as check_fra, "foro01" as tabla, "foro01_titulo_idioma" as campo_actualizar, "id_foro01" as campo_id , "idioma" as tipo from foro01',
'select id_foro01 as id_seccion, foro01_texto_esp as "esp", foro01_texto_fra as "fra", foro01_texto_check_fra as check_fra, "foro01" as tabla, "foro01_texto_idioma" as campo_actualizar, "id_foro01" as campo_id , "idioma" as tipo from foro01',
'select id_foro02 as id_seccion, foro02_titulo_esp as "esp", foro02_titulo_fra as "fra", foro02_titulo_check_fra as check_fra, "foro02" as tabla, "foro02_titulo_idioma" as campo_actualizar, "id_foro02" as campo_id , "idioma" as tipo from foro02',
'select id_foro02 as id_seccion, foro02_texto_esp as "esp", foro02_texto_fra as "fra", foro02_texto_check_fra as check_fra, "foro02" as tabla, "foro02_texto_idioma" as campo_actualizar, "id_foro02" as campo_id , "idioma" as tipo from foro02',
'select id_foro03 as id_seccion, foro03_titulo_esp as "esp", foro03_titulo_fra as "fra", foro03_titulo_check_fra as check_fra, "foro03" as tabla, "foro03_titulo_idioma" as campo_actualizar, "id_foro03" as campo_id , "idioma" as tipo from foro03',
'select id_foro03 as id_seccion, foro03_texto_esp as "esp", foro03_texto_fra as "fra", foro03_texto_check_fra as check_fra, "foro03" as tabla, "foro03_texto_idioma" as campo_actualizar, "id_foro03" as campo_id , "idioma" as tipo from foro03',
);
foreach($arra_traducciones as $query){
if($trad) continue;
$objeto->conecto_datos->query($query);
if($objeto->conecto_datos->record_count){ $trad=true;}
}//foreach
mail("alice.carre@quartiersdumonde.org","Traducciones de qdm","Traducciones disponibles en qdm","From:traducciones@quartiersdumonde.org\nReply-To:\nX-Mailer: PHP/".phpversion());
reescribir_doc("fecha_mail.txt", $hoy);
}//if
session_start();
$_SESSION["user"]="";
$_SESSION["password"]="";
$_SESSION["refer"]="";
header( "location:index.php");



function leer_doc($documento_en_carpeta){
$fichero=fopen ($documento_en_carpeta, "r"); 
while(!feof($fichero)){
$buffer=fgets($fichero,4096);
$contenido=$buffer;
}//while
fclose($fichero);
return $contenido;
}//constructora


function reescribir_doc($documento_en_carpeta, $contenido){
$fp   = fopen ($documento_en_carpeta, "wb"); 
fwrite($fp, $contenido); 
fclose($fp); 

}//constructora
die();
?>

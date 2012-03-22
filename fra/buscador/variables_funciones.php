<?php
$idiom=$objeto->idioma;
$trad=new conecto_datos();





# presenta asociacion
$query_noticias_tipo="CREATE TEMPORARY TABLE temp_union  (
resultado varchar(255) default NULL,
url varchar(255) default NULL,
path varchar(255) default NULL
) TYPE=HEAP;

#tipo de informacion grupo_trabajo y qdm_p, tipo de objetivo en qdm_a
INSERT INTO temp_union select 
noticia_00_$idiom as resultado, 
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('../objetivos/index.php?id=', id_noticia_00), 
    concat('../qdm/info.php?id=', id_noticia_00)), 
concat('../qdm/',directorio,'/info.php?id=', id_noticia_00)) 
as url,
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('QDM > PROYECTO QDM > OBJETIVOS > '), 
    concat('PROYECTO QDM > INFO > ')), 
concat('PROYECTO QDM > ', nombre,' > INFO > ')) 
as path
from 
noticia_00, equipos_00
where equipos_00_id_registro_00=id_registro_00 and noticia_00_$idiom like '%$busqueda%';


#presentacion titulo qdm_a, qdm_p, grupo_trabajo
INSERT INTO temp_union select 
titulo_$idiom as resultado, 
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('../presenta/index.php?id=', id_noticia_01), 
    concat('../qdm/presenta.php?id=', id_noticia_01)), 
concat('../qdm/',directorio,'/presenta.php?id=', id_noticia_01))
 as url,

if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    'QDM > PRESENTA', 
    'QDM > PROYECTO QDM > PRESENTA'), 
 concat('QDM > PROYECTO QDM > ', nombre,' > PRESENTA '))
 as path
from noticia_01
right join equipos_00 on (equipos_00_id_registro_00=noticia_01.id_registro_00)
where noticia_01_id_noticia_00=0 and   titulo_$idiom like '%$busqueda%';

#presentacion titulo qdm_a, qdm_p, grupo_trabajo BIS
INSERT INTO temp_union select 
parrafo_$idiom as resultado, 
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('../presenta/index.php?id=', id_noticia_01), 
    concat('../qdm/presenta.php?id=', id_noticia_01)), 
concat('../qdm/',directorio,'/presenta.php?id=', id_noticia_01))
 as url,

if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('QDM > PRESENTA > ', titulo_$idiom), 
    concat('QDM > PROYECTO QDM > PRESENTA > ', titulo_$idiom)), 
 concat('QDM > PROYECTO QDM > ', nombre,' > PRESENTA > ', titulo_$idiom))
 as path
from noticia_01
left join noticia_02 on (noticia_02_id_noticia_01=id_noticia_01)
right join equipos_00 on (equipos_00_id_registro_00=noticia_01.id_registro_00)
where noticia_01_id_noticia_00=0 and   parrafo_$idiom like '%$busqueda%';


#presentacion objetivos titulo qdm_a, info titulos qdm_p, info titulos grupo_trabajo
INSERT INTO temp_union select 
titulo_$idiom as resultado, 
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('../objetivos/index.php?id=', id_noticia_00,'&id2=', id_noticia_01), 
    concat('../qdm/info.php?id=', id_noticia_00,'&id2=', id_noticia_01)), 
concat('../qdm/',directorio,'/info.php?id=', id_noticia_00,'&id2=', id_noticia_01))
as url,
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
     'QDM > PROYECTO QDM > OBJETIVOS', 
    'PROYECTO QDM > INFO'), 
 concat('PROYECTO QDM > ', nombre,' > INFO  > '))
as path
from noticia_01
right join noticia_00 on (noticia_01_id_noticia_00=id_noticia_00)
right join equipos_00 on (equipos_00_id_registro_00=noticia_00.id_registro_00)
where noticia_01_id_noticia_00<>0 and   titulo_$idiom like '%$busqueda%';

#presentacion objetivos titulo qdm_a, info titulos qdm_p, info titulos grupo_trabajo BIS
INSERT INTO temp_union select 
parrafo_$idiom as resultado, 

if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('../objetivos/index.php?id=', id_noticia_00,'&id2=', id_noticia_01), 
    concat('../qdm/info.php?id=', id_noticia_00,'&id2=', id_noticia_01)), 
concat('../qdm/',directorio,'/info.php?id=', id_noticia_00,'&id2=', id_noticia_01))
as url,
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
     concat('QDM > PROYECTO QDM > OBJETIVOS > ', titulo_$idiom), 
    concat('PROYECTO QDM > INFO > ', titulo_$idiom)), 
 concat('PROYECTO QDM > ', nombre,' > INFO  > ', titulo_$idiom))
as path
from noticia_01
left join noticia_02 on (noticia_02_id_noticia_01=id_noticia_01)
right join noticia_00 on (noticia_01_id_noticia_00=id_noticia_00)
right join equipos_00 on (equipos_00_id_registro_00=noticia_00.id_registro_00)
where noticia_01_id_noticia_00<>0 and parrafo_$idiom like '%$busqueda%';


#documentos anexos
INSERT INTO temp_union select 
document_up.informacion_$idiom as resultado, 
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('../documents/index.php?id=', id_document_up), 
    concat('../documents/index.php?id=', id_document_up)), 
    concat('../documents/index.php?id=', id_document_up)) 
as url,
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('QDM > DOCUMENTOS ANEXOS > '), 
    concat('PROYECTO QDM > DOCUMENTOS ANEXOS > ')), 
concat('PROYECTO QDM > ', nombre,' > DOCUMENTOS ANEXOS > ')) 
as path
from 
document_up, equipos_00
where equipos_00_id_registro_00=id_registro_00 and document_up.informacion_$idiom like '%$busqueda%';


#agenda texto
INSERT INTO temp_union select 
texto_$idiom as resultado, 
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('../documents/index.php?id=', id_agenda), 
    concat('../qdm/documents.php?id=', id_agenda)), 
    concat('../qdm/',directorio,'/documents.php?id=', id_agenda)) 
as url,
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('QDM > PROYECTO QDM > AGENDA > ', titular_$idiom), 
    concat('PROYECTO QDM > AGENDA > ', titular_$idiom)), 
concat('PROYECTO QDM > ', nombre,' > AGENDA > ', titular_$idiom)) 
as path
from 
agenda, equipos_00
where equipos_00_id_registro_00=id_registro_00 and texto_$idiom like '%$busqueda%';

#agenda titulo
INSERT INTO temp_union select 
titular_$idiom as resultado, 
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('../documents/index.php?id=', id_agenda), 
    concat('../qdm/documents.php?id=', id_agenda)), 
    concat('../qdm/',directorio,'/documents.php?id=', id_agenda)) 
as url,
if(tipo_participante<>'grupo_trabajo', 
    if(tipo_participante='qdm_a', 
    concat('QDM > PROYECTO QDM > AGENDA > '), 
    concat('PROYECTO QDM > AGENDA > ')), 
concat('PROYECTO QDM > ', nombre,' > AGENDA > ')) 
as path
from 
agenda, equipos_00
where equipos_00_id_registro_00=id_registro_00 and titular_$idiom like '%$busqueda%';


select resultado, url, path from temp_union";




?>
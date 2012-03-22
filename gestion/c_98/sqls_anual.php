<?php
$query_pais ="select 
SUBSTRING(recibido, 1,4) as anyo, SUBSTRING(recibido, 3,2) as anyo2
,count(*) as frecuencia, country as identidad, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat( country,SUBSTRING(recibido, 1,4))
order by country, anyo";

$query_paginas ="select 
SUBSTRING(recibido, 1,4) as anyo, SUBSTRING(recibido, 3,2) as anyo2
,count(*) as frecuencia, concat(seccion, ' > ',archivo) as identidad, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat(seccion, archivo,SUBSTRING(recibido, 1,4))
order by seccion, archivo, anyo";

$query_idioma ="select 
SUBSTRING(recibido, 1,4) as anyo, SUBSTRING(recibido, 3,2) as anyo2
,count(*) as frecuencia, idioma as identidad, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat( idioma,SUBSTRING(recibido, 1,4))
order by idioma, anyo";


if($_GET["consulta"]=="paises")
$query_anyo=$query_pais;
elseif($_GET["consulta"]=="paginas")
$query_anyo =$query_paginas;
elseif($_GET["consulta"]=="idioma")
$query_anyo=$query_idioma;

?>
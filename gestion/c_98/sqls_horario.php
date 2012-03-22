<?php
$query_pais="select 
country as identidad, 
SUBSTRING(recibido, 12,2) as hora
,count(*) as frecuencia, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat(country,SUBSTRING(recibido, 12,2))
order by country, hora limit 155";

$query_paginas="select 
concat(seccion, ' > ', archivo)  as identidad, 
SUBSTRING(recibido, 12,2) as hora
,count(*) as frecuencia, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat(idioma,SUBSTRING(recibido, 12,2))
order by seccion,archivo,  hora limit 155";

$query_idioma="select 
idioma as identidad, 
SUBSTRING(recibido, 12,2) as hora
,count(*) as frecuencia, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat(idioma,SUBSTRING(recibido, 12,2))
order by idioma, hora ";




if($_GET["consulta"]=="paises")
$query_horario=$query_pais;
elseif($_GET["consulta"]=="paginas")
$query_horario=$query_paginas;
elseif($_GET["consulta"]=="idioma")
$query_horario=$query_idioma;
?>

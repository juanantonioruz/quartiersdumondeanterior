<?php
$query_pais="select 
country as identidad, 
 SUBSTRING(recibido, 9,2) as dia
,count(*) as frecuencia, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat( country,SUBSTRING(recibido, 9,2))
order by country,dia";

$query_paginas="select 
concat(seccion, ' > ' ,archivo) as identidad, 
 SUBSTRING(recibido, 9,2) as dia
,count(*) as frecuencia, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat(seccion, archivo,SUBSTRING(recibido, 9,2))
order by seccion, archivo, dia";

$query_idioma="select 
idioma as identidad, 
 SUBSTRING(recibido, 9,2) as dia
,count(*) as frecuencia, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10) $usuario_filtro
group by concat(idioma,SUBSTRING(recibido, 9,2))
order by idioma, dia";



if($_GET["consulta"]=="paises")
$query_diario=$query_pais;
elseif($_GET["consulta"]=="paginas")
$query_diario=$query_paginas;
elseif($_GET["consulta"]=="idioma"){
$query_diario= $query_idioma;
}

?>

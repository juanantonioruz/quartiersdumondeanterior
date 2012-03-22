<?php
$objeto->conecto_datos->query("select 
country, 
SUBSTRING(recibido, 12,2) as hora
,count(*) as frecuencia, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10)
group by concat(country,SUBSTRING(recibido, 12,2))
order by country, hora");
$p=0;
$limite_p=24;
$c=1;
while($objeto->conecto_datos->next_record()){
        $country=$objeto->conecto_datos->Record['country'];
        if($country_ant<>$country && $p){ 
                
                while($p<$limite_p){
                if($c===1 && !$fin_time) $time_line[]=sprintf("%02d",$p);
                ${"datay".$c}[]=0;
                $p++;
                }//while
        
        $c++;
        $p=0;
        }

        ${"country".$c}=$country;
        
            while($objeto->conecto_datos->Record['hora']<>$p && $p<$limite_p ){
                if($c===1 && !$fin_time) $time_line[]=sprintf("%02d",$p);
                ${"datay".$c}[]=0;
                $p++;
            }//while
            
        if($c===1 && !$fin_time) $time_line[]=$objeto->conecto_datos->Record['hora']."0";
        
        ${"datay".$c}[]=$objeto->conecto_datos->Record['frecuencia']+$objeto->conecto_datos->Record['suma'];
        
        if($p==$limite_p){$fin_time=true;$p=0;}else{$p++;}
        $country_ant=$country;

}//while database
while($p<$limite_p){
if($c===1 && !$fin_time) $time_line[]=sprintf("%02d",$p);
${"datay".$c}[]=0;
$p++;
}//while
?>
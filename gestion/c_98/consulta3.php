<?php
require("../../include/objeto.php");
#$objeto=new objeto(array('formato'),array('clases'),array('local'),array('stats_language'));
$objeto->conecto_datos->query("select 
country, 
SUBSTRING(recibido, 1,15) AS dd, SUBSTRING(recibido, 15,1) as dd2
,count(*) as frecuencia, country, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where   '2004-04-15 12:00:00'<=recibido and date_add('2004-04-15 12:00:00', interval 1 hour)>=recibido
group by concat(SUBSTRING(recibido, 1,15), country)
order by country, recibido
");
$p=0;
$c=1;
while($objeto->conecto_datos->next_record()){
        $country=$objeto->conecto_datos->Record['country'];

        if($country_ant<>$country && $p){ 
                
                while($p<6){
                if($c===1 && !$fin_time) $time_line[]=$p."0";
                ${"datay".$c}[]=0;
                $p++;
                }//while
        
        $c++;
        $p=0;
        }

        ${"country".$c}=$country;
        
            while($objeto->conecto_datos->Record['dd2']<>$p && $p<6 ){
                if($c===1 && !$fin_time) $time_line[]=$p."0";
                ${"datay".$c}[]=0;
                $p++;
            }//while
            
        if($c===1 && !$fin_time) $time_line[]=$objeto->conecto_datos->Record['dd2']."0";
        
        ${"datay".$c}[]=$objeto->conecto_datos->Record['frecuencia']+$objeto->conecto_datos->Record['suma'];
        
        if($p==6){$fin_time=true;$p=0;}else{$p++;}
        $country_ant=$country;

}//while database
while($p<6){
if($c===1 && !$fin_time) $time_line[]=$p."0";
${"datay".$c}[]=0;
$p++;
}//while
?>
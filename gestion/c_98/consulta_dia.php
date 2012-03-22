<?php
require("sqls_diario.php");
$titulo_grafico="Estadisticas en $usuario_nombre. Grafico diario. Intervalo ($fecha_1/$fecha_2)";
$objeto->conecto_datos->query($query_diario);
$limite_p=date_diff($fecha_1 , $fecha_2)+1;
if($limite_p>400)$limite_line=100;
elseif($limite_p>100)$limite_line=20;
elseif($limite_p>50)$limite_line=10;
elseif($limite_p>29)$limite_line=7;
elseif($limite_p>15)$limite_line=3;
else $limite_line=1;
$p=0;
$c=1;
while($objeto->conecto_datos->next_record()){
        if($objeto->conecto_datos->de_html($objeto->conecto_datos->Record['identidad'])=="id_establecimiento_00")
        $country="tipo de establecimiento";
        elseif($objeto->conecto_datos->de_html($objeto->conecto_datos->Record['identidad'])=="id_sala_00")
        $country="tipo de sala";
        else
        $country=$objeto->conecto_datos->de_html($objeto->conecto_datos->Record['identidad']);
        if($country_ant<>$country && $country_ant){ 
                while($p<$limite_p){
                    if($country_ant && !$fin_time ){
                        $d=date("d/m", mktime(0,0,0, $mes_1 , $dia_1+$p , $anyo_1));
                        if($p%$limite_line==0){
                        $time_line[]=$d;
                        }else{
                        $time_line[]=" ";
                        }//if
                    }//if
                    if($c)${"datay".$c}[]=0;

                    $p++;


                }//while
        
        $c++;
                if($p==$limite_p){$fin_time=true;$p=0;}else{$p++;}
        }//if

        ${"country".$c}=$country;
        
            while($objeto->conecto_datos->Record['dia']<>date("d", mktime(0,0,0, $mes_1 , $dia_1+$p , $anyo_1)) && $p<$limite_p ){
                if($c && !$fin_time  ){ 
                $d=date("d/m", mktime(0,0,0, $mes_1 , $dia_1+$p , $anyo_1));
                    if($p%$limite_line==0 )
                        $time_line[]=$d;
                        else
                        $time_line[]=" ";
                    }//if
                    
                ${"datay".$c}[]=0;
                $p++;
            }//while
            
        if($c && !$fin_time ){
                $d=date("d/m", mktime(0,0,0, $mes_1 , $dia_1+$p , $anyo_1));
                if($p%$limite_line==0 )
                $time_line[]=$d;
                else
                $time_line[]=" ";
         }
        
        ${"datay".$c}[]=$objeto->conecto_datos->Record['frecuencia']+$objeto->conecto_datos->Record['suma'];
        
        if($p==$limite_p){$fin_time=true;$p=0;}else{$p++;}
        $country_ant=$country;

}//while database
while($p<$limite_p){
if($c && !$fin_time ){
                $d=date("d/m", mktime(0,0,0, $mes_1 , $dia_1+$p , $anyo_1));
                if($p%$limite_line==0 )
                $time_line[]=$d;
                else
                $time_line[]=" ";
}
${"datay".$c}[]=0;
$p++;

}//while
if($objeto->conecto_datos->record_count){
include("index_img.php");
/*
echo "limite de dias $limite_p";
for($t=1; $t<=$c;$t++){
echo "<hr>$t<hr>";
foreach(${"datay".$t} as $grafica) echo $grafica.".<br>";
}
$objeto->conecto_datos-> mostrar_esquema_consulta("select 
country, 
 SUBSTRING(recibido, 9,2) as dia
,count(*) as frecuencia, country, sum(count_stats_03) as suma
 from stats_03
left join stats_00 on (stats_00.id_stats_00=stats_03.id_stats_00)
where  '$fecha_1'<=SUBSTRING(recibido,1,10) and '$fecha_2'>=SUBSTRING(recibido,1,10)
group by concat( country,SUBSTRING(recibido, 9,2))
order by country, dia");
*/
}else
echo "no hay ninguna entrada en este intervalo";
function date_diff($date1, $date2)
{
 $d1 = explode("-", $date1);
 $y1 = $d1[0];
 $m1 = $d1[1];
 $d1 = $d1[2];
 $d2 = explode("-", $date2);
 $y2 = $d2[0];
 $m2 = $d2[1];
 $d2 = $d2[2];
 $date1_set = mktime(0,0,0, $m1, $d1, $y1);
 $date2_set = mktime(0,0,0, $m2, $d2, $y2);
 return(round(($date2_set-$date1_set)/(60*60*24))); 
 }
 /*
 $fecha_1_arra=explode("-", $fecha_1);
$dia_1=$fecha_1_arra[2];
$mes_1=$fecha_1_arra[1];
$anyo_1=$fecha_1_arra[0];

 */
?>
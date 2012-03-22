<?php
require("sqls_mes.php");
$titulo_grafico="Estadisticas en $usuario_nombre. Grafico mensual. Intervalo ($fecha_1/$fecha_2)";
$objeto->conecto_datos->query($query_mes);
#echo "<hr>$mes_1 $mes_2";
$p=0;
# HAY QUE MIRAR A VER SI HAY CAMBIO DE AˆëO
$diferencia_anual=$anyo_2-$anyo_1;
$limite_p=$mes_2-$mes_1+1;
if($diferencia_anual) $limite_p+=$diferencia_anual*12;
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
                if($c && !$fin_time) $time_line[]=date("m", mktime(0,0,0, $mes_1+$p , $dia_1 , $anyo_1));
                ${"datay".$c}[]=0;
                $p++;
                }//while
                if($p==$limite_p){$fin_time=true;$p=0;}else{$p++;}

        $c++;
       # $p=0;
        }

        ${"country".$c}=$country;
        
            while($objeto->conecto_datos->Record['mes']<>date("m", mktime(0,0,0, $mes_1+$p , $dia_1 , $anyo_1)) && $p<$limite_p ){
                if($c && !$fin_time) $time_line[]=date("m", mktime(0,0,0, $mes_1+$p , $dia_1 , $anyo_1));
                ${"datay".$c}[]=0;
                $p++;
            }//while
            
        if($c && !$fin_time) $time_line[]=date("m", mktime(0,0,0, $objeto->conecto_datos->Record['mes'] , $dia_1 , $anyo_1));
        
        ${"datay".$c}[]=$objeto->conecto_datos->Record['frecuencia']+$objeto->conecto_datos->Record['suma'];
        
        if($p==$limite_p){$fin_time=true;$p=0;}else{$p++;}
        $country_ant=$country;

}//while database
while($p<$limite_p){
if($c===1 && !$fin_time) $time_line[]=date("m", mktime(0,0,0, $mes_1+$p , $dia_1 , $anyo_1));
${"datay".$c}[]=0;
$p++;
}//while
if($objeto->conecto_datos->record_count)
include("index_img.php");
else
echo "no hay ninguna entrada en este intervalo";
?>
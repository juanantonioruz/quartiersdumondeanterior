<?php
require("sqls_anual.php");
$titulo_grafico="Estadisticas en $usuario_nombre. Grafico anual. Intervalo ($fecha_1/$fecha_2)";
$objeto->conecto_datos-> query($query_anyo);
$p=0;
$limite_p=$anyo_2-$anyo_1+1;
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
                if($c && !$fin_time) $time_line[]=date("y", mktime(0,0,0, $mes_1 , $dia_1 , $anyo_1+$p));
                ${"datay".$c}[]=0;
                $p++;
                }//while
        
        $c++;
                if($p==$limite_p){$fin_time=true;$p=0;}else{$p++;}
        }

        ${"country".$c}=$country;
        
            while($objeto->conecto_datos->Record['anyo2']<>date("y", mktime(0,0,0, $mes_1 , $dia_1 , $anyo_1+$p)) && $p<$limite_p ){
                if($c && !$fin_time) $time_line[]=date("y", mktime(0,0,0, $mes_1 , $dia_1 , $anyo_1+$p));
                ${"datay".$c}[]=0;
                $p++;
            }//while
            
        if($c && !$fin_time) $time_line[]=date("y", mktime(0,0,0, $mes_1 , $dia_1 , $objeto->conecto_datos->Record['anyo']));
        
        ${"datay".$c}[]=$objeto->conecto_datos->Record['frecuencia']+$objeto->conecto_datos->Record['suma'];
        
        if($p==$limite_p){$fin_time=true;$p=0;}else{$p++;}
        $country_ant=$country;

}//while database
while($p<$limite_p){
if($c && !$fin_time) $time_line[]=date("y", mktime(0,0,0, $mes_1 , $dia_1 , $anyo_1+$p));
${"datay".$c}[]=0;
$p++;
}//while
if($objeto->conecto_datos->record_count)
include("index_img.php");
else
echo "no hay ninguna entrada en este intervalo";
?>
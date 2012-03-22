<?php
$busqueda=$objeto->conecto_datos->a_html($_POST['busqueda']);
$busqueda_mysql=strtoupper($busqueda);
$info.="<b class='buscador'>Termino de busqueda: ".$_POST['busqueda']."</b><br><br>";

/*comienzo de busqueda*/

if($busqueda and strlen($busqueda)>1){

require ("variables_funciones.php");


#$info.="numero de registros que participan en la busqueda a traves de las traducciones: ".$objeto->conecto_datos->record_count."<br><br>";


    $arra_consultas =explode(";", $query_noticias_tipo);
foreach($arra_consultas as $query_actual){
if($j<count($arra_consultas)-1){$objeto->conecto_datos->query($query_actual); $j++;continue;}

#echo "<hr><font color=green> $query_actual </font><hr>";
$objeto->conecto_datos->query($query_actual);
while($objeto->conecto_datos->next_record()){
$rec=$objeto->conecto_datos->Record;
#echo "resultado:".$rec["resultado"]."<br>";
$grupo=str_replace("&&&", "",stristr($rec["url"], "&&&"));
$rec["url"]=str_replace("/grupo/",  "/".$objeto->documento->equipos_trabajo_numero[$grupo][0]."/", $rec["url"]);
$rec["path"]=str_replace("> grupo >",  "> ".$objeto->documento->equipos_trabajo_numero[$grupo][1]." >", $rec["path"]);

$link="<a href='{$rec["url"]}' class='idioma'>{$rec["path"]}</a>";
$url_def="<a href='{$rec["url"]}' class='idioma'>";
/*funcion comun */

$valor_html=$rec["resultado"];
$busqueda_html=$busqueda;
$valor_nohtml=$objeto->conecto_datos->de_html($valor_html);
$busqueda_nohtml=$_POST['busqueda'];
$valor_def=str_replace($busqueda_nohtml, ucfirst($busqueda_nohtml), $valor_nohtml);
$valor_def=str_replace(strtolower($busqueda_nohtml), ucfirst($busqueda_nohtml), $valor_def);
$valor_def=str_replace(strtoupper($busqueda_nohtml), ucfirst($busqueda_nohtml), $valor_def);
$valor_def=str_replace(ucfirst($busqueda_nohtml), "|*".ucfirst($busqueda_nohtml)."*|", $valor_def);
#echo $valor_def."<hr>";
if(!strrchr($valor_def, ".")) $valor_def.=".";

$largo=strlen($valor_def);
$largo_busqueda=strlen($busqueda_nohtml);
$posicion=strpos($valor_def, $busqueda_nohtml);

$numero_apariciones=totalStr($objeto, $valor_def, ucfirst($busqueda_nohtml));
$numero_apariciones_punto=totalStr($objeto, $valor_def, ".");
$largo_valor_nohtml=strlen($valor_def) ;


$puntos_ascendente=null;
$arra_puntos_def=null;
$arra_puntos_def[]=0;
foreach($numero_apariciones_punto as $id_punto=>$valor_punto){
    $punto_0= $valor_punto[0];
    $punto_1= $valor_punto[1];
    
    if($largo_valor_nohtml<> $punto_1){
    $posicion_punto_AA= $punto_0+($largo_valor_nohtml-$punto_1);
    }else{
    $posicion_punto_AA= $punto_0;
    }//IF GENERAL
    $arra_puntos_def[]=$posicion_punto_AA;
}//foreach

$puntos_ascendente=$arra_puntos_def;

$punto_inicial=null;
$punto_final=null;

if(count($numero_apariciones)>0){
$largo_valor_nohtml=strlen($valor_nohtml) +(count($numero_apariciones)*4);
foreach($numero_apariciones as $clave1=>$valor1){
$z++;
#echo "<hr>Id de registro:$clave1- Lugar:<b class='buscador_web'>{$valor1[0]}</b> Longitud_cadena:{$valor1[1]} ";
if($largo_valor_nohtml<>$valor1[1]){
$posicion_AA=$valor1[0]+($largo_valor_nohtml-$valor1[1]);
#echo "diferencia: ".($largo_valor_nohtml-$valor1[1])."<br>NO 1 aparicion<br>";
}else{
#echo "diferencia 0<br>SI 1 aparicion<br>";
$posicion_AA=$valor1[0];
}//IF GENERAL

for($p=count($puntos_ascendente)-1; $p>=0; $p--){
if($puntos_ascendente[$p]<=$posicion_AA){
#echo "<br><font color='blue'> $puntos_ascendente[$p]  {$valor_def[$puntos_ascendente[$p]]} </font><br>";
$punto_inicial=$puntos_ascendente[$p];
$p=0;
}
}//for

for($p=0; $p<count($puntos_ascendente); $p++){
#echo "<br><font color='gray'> $puntos_ascendente[$p]  {$valor_def[$puntos_ascendente[$p]]} </font><br>";
if($puntos_ascendente[$p]>=$posicion_AA){
#echo "<br><font color='red'> $puntos_ascendente[$p]  {$valor_def[$puntos_ascendente[$p]]} </font><br>";
$punto_final=$puntos_ascendente[$p]-$punto_final_ant;
$p=count($puntos_ascendente);
}
$punto_final_ant=$puntos_ascendente[$p];
}//for


$fragmento_def=substr($valor_def, $punto_inicial, $punto_final).".";
if($fragmento_def[0]==".") $fragmento_def=substr($fragmento_def, 1);
$fragmento_def=$objeto->conecto_datos->a_html($fragmento_def);
$fragmento_def =str_replace("|*", "$url_def<b class='buscador_web'>", $fragmento_def);
$fragmento_def =str_replace("*|", "</b></a>", $fragmento_def);
$fragmento_def =str_replace("[*]", "<br>", $fragmento_def);
$fragmento_def =str_replace("[b]", "<b class='buscador_web'>", $fragmento_def);
$fragmento_def =str_replace("[/b]", "</b>", $fragmento_def);



#$info.= "<b class='buscador_web'>Posicion_AA= $posicion_AA Inicio: $punto_inicial  FIn: $punto_final</b><br>". $fragmento_def."<br><br>";
if($fragmento_def<>$fragmento_def_ant_00){
$info.="$fragmento_def<br><br><b class='buscador'>Directorio:</b> $link<br><br><br>";
}
$fragmento_def_ant_00= $fragmento_def;
}//foreach GENERAL
}//IF EXISTE APARICION



$info.="";



}//while
}//foreach
}else{
$info.="<b class='buscador_web'>no existe ningun termino de busqueda</b>";
}
$titulo_ficha="Resultados de su busqueda";
$texto_ficha=$info;
$imagen="";
$mod_right="";
function totalStr($objeto, $total_string, $fragmento_string,$i = 0){
$arra_prov=array();
#$objeto->addArray($arra_prov, 0, $total_string);
while(strpos($total_string,$fragmento_string)!==false){
$total_string_ant=$total_string;
$total_string= substr($total_string, (strpos($total_string,$fragmento_string) + 1));
$i++;
$objeto->addArray($arra_prov, $i, array( strpos($total_string_ant, $fragmento_string), strlen($total_string_ant)));
}//while
return $arra_prov;
#return $i;
}
?>
<?php
require("../../include/objeto.php");
$objeto=new objeto();
$handle=opendir("../../imgs/");
while($file = readdir($handle)){
if(strstr($file, "mm.jpg")) {
#echo $file."<br>";
#$tamanyo_directorio_definitivo+=(int)(filesize($path_definitivo.$file)/1000);
#if($file==$archivo_def_up){
 $existe_archivo=true;

$path="../../imgs/";
$archivo=str_replace("mm", "zz", $file);
$abc = imagecreatefromjpeg($path.$archivo); 
$ancho=ImageSX($abc);
$alto=ImageSY($abc);

$min_alto=200;
$min_ancho=200;
if($min_alto<$alto or $min_ancho<$ancho){
$var1=CalcScrunchSize($alto, $ancho,  $min_alto, $min_ancho);
$ancha_def=(int)$var1[0];
$alta_def=(int)$var1[1];
$def =imagecreatetruecolor($ancha_def, $alta_def); 
#echo "<br><b>".$path.$file."</b><br>";
 imagecopyresampled($def, $abc, 0, 0, 0, 0, $ancha_def, $alta_def, $ancho, $alto); 
imagejpeg($def, $path.$file , 90); 
ImageDestroy($abc); 
ImageDestroy($def); 
}
}//if file
}//while



function CalcScrunchSize($CurH,$CurW, $MaxH,$MaxW) //calculates how to stuff a big img into a lil space
{
$HRatio = $CurH/$MaxH;
$WRatio = $CurW/$MaxW;
if($HRatio > $WRatio)
{
$result[0] =$CurW*($MaxH/$CurH);
$result[1] = $MaxH;
}
else
{
$result[0] = $MaxW;
$result[1] =$CurH*($MaxW/$CurW);
}
return($result);
}//function CalcScrunchSize

?>

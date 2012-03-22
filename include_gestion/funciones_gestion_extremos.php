
function detalle_examen(){

if($_POST["actualizar"]=="go"){
#foreach($_POST as $clave=>$valor) echo "$clave __ $valor<br>";
$id_ref_examen_00=$_POST['id_ref_examen_00'];
$id_ref_alumno_00=$_POST['id_ref_alumno_00'];
$id_examen_00=$_POST['id_examen_00'];
$id_alumno_00=$_POST['id_alumno_00'];
$arra_form=array();
foreach($_POST as $clave=>$valor){
if(substr($clave, 0, 9)=="pregunta_" ){
$arra_form[]=$valor;
}//if
}//foreach
$query_valores_00="select id_ref_examen_01 from f_ref_examen_01 where ref_examen_01_id_ref_examen_00=$id_ref_examen_00 order by id_ref_examen_01";
$this->datos->query($query_valores_00);
$arra_valores_000[]="inicio";
while($this->datos->next_record()) $arra_valores_000[]=$this->datos->Record["id_ref_examen_01"];
foreach($arra_form as $clave){
$arra_conn_00=array();
for($e=1;$e<8;$e++){
if($_POST["r_".$e."_".$clave]) $val=$_POST["r_".$e."_".$clave]; else $val=0;
$arra_conn_00[]=" respuesta_0".$e."='$val'";
}//for $e
$this->datos->query("select id_ref_examen_01, ref_examen_01_id_examen_01 from f_ref_examen_01 where ref_examen_01_id_ref_examen_00 =$id_ref_examen_00 and ref_examen_01_id_examen_01=$clave");
#echo "<hr><hr>select id_ref_examen_01, ref_examen_01_id_examen_01 from f_ref_examen_01 where ref_examen_01_id_ref_examen_00 =$id_ref_examen_00 and ref_examen_01_id_examen_01=$clave <hR><hR>";
if($this->datos->record_count){
$this->datos->next_record();
$con_00="update f_ref_examen_01 set ".implode(",", $arra_conn_00)." where id_ref_examen_01=".$this->datos->Record[id_ref_examen_01];
#echo $con_00."<hr>";
$this->datos->query($con_00);
}else{
$valores_00=null;
$valores_01=null;
foreach($arra_conn_00 as $v){
 $valores_00[]=substr($v, 0, 13);
 $valores_01[]=substr($v, -3);
 }
$con_01="insert into f_ref_examen_01( ".implode(",",$valores_00).", ref_examen_01_id_ref_examen_00, ref_examen_01_id_examen_01) values(".implode(",",$valores_01).", $id_ref_examen_00, $clave)";
#echo $con_01."<br>";
$this->datos->query($con_01);
}
}//foreach as $clave=>$valor

$this->datos->query("
select * from
f_ref_examen_00
right join f_ref_examen_01 on (ref_examen_01_id_ref_examen_00=id_ref_examen_00)
where id_ref_examen_00=$id_ref_examen_00
order by ref_examen_01_id_examen_01");
$arra_form=array();
while($this->datos->next_record()){
    $arra_prov=null;
    $arra_prov[]=0;
        for($h=1;$h<8;$h++){
            if($this->datos->Record["respuesta_0".$h])  $arra_prov[]=$h;
        }//for
        sort($arra_prov);
    $this->addArray($arra_form, $this->datos->Record[ref_examen_01_id_examen_01], $arra_prov);
}//while
extract($arra_form, EXTR_PREFIX_ALL, "examen");

/*
foreach($arra_form as $clave=>$valor)
foreach($valor as $j) 
echo "EXAMEN: $clave  --  $j<br>";
*/


$q="
select * from
f_examen_00
left join f_examen_01 on (examen_01_id_examen_00=id_examen_00)
where examen_01_id_examen_00=$id_examen_00
order by id_examen_01";
$this->datos->query($q);
$resultados=array();
$numero_preguntas=$this->datos->record_count;
#echo "preguntas:".$numero_preguntas;
while($this->datos->next_record()){
$rec=$this->datos->Record;
$id_examen_01=$rec["id_examen_01"];
if(!$entro){
$examen=$rec["examen_00_".$objeto->idioma];
$punt_min=$rec["punt_min"];
$punt_max=$rec["punt_max"];
$entro=true;
}//if $entro
$id_preguntas[]=$id_examen_01;
    $arra_prov=null;
        $arra_prov[]=0;
    for($h=1;$h<8;$h++){
        if($this->datos->Record["respuesta_0".$h])  $arra_prov[]=$h;
    }//for
    if(is_array($arra_prov))
    sort($arra_prov);
    if($arra_prov==${"examen_".$id_examen_01}){
        //echo "<hr> pregunta n-$id_examen_01:  <b>iguales</b><br> ";
        ${"pregunta".$id_examen_01}=true;
        }else{
        //echo "<hr> pregunta n-$id_examen_01:  desiguales<br>arra_prov".implode(",",$arra_prov)."<br>examen".implode(",",${"examen_".$id_examen_01})."<br> ";
        ${"pregunta".$id_examen_01}=false;
   }
           $this->addArray($resultados, $id_examen_01, $arra_prov);
}//while
foreach($id_preguntas as $n){
if(${"pregunta".$n}) $numero++;
}
$punt=($punt_max/$numero_preguntas)*$numero;
#echo "punt_max: $punt_max numero prefguntas: $numero_preguntas numero: $numero  puntuacion: $punt<hr>";
if($punt>=$punt_min){ $status="Examen aprobado"; $stat=1;}else{ $status="<font color='red'>Examen suspenso</font>";$stat=0;}
$info.="Preguntas acertadas: <b>$numero</b>. de un total de: $numero_preguntas<br>";
$info.="Puntuaci&oacute;n: <b> $punt </b>. <br>";
$info.="<b> $status </b>.<br>";
$info.="Checkear examen respuestas <a href='examen2.php?id_examen_00=$id_examen_00' class='green_line'>check</a>";
#echo "update f_ref_examen_00 set punt='$punt',  status='$stat' where ref_examen_00_id_alumno_00=$id_alumno_00 and ref_examen_00_id_examen_00=$id_examen_00";
$this->datos->query("update f_ref_examen_00 set punt='$punt',  status='$stat' where ref_examen_00_id_alumno_00=$id_alumno_00 and ref_examen_00_id_examen_00=$id_examen_00");
$punt_ini=$punt;

header( "location:index.php");
}else{
$id_examen_00=$_GET['id_examen_00'];
$id_ref_alumno_00=$_GET['id_ref_alumno_00'];

$this->datos->query("select * from f_ref_alumno_00 
 right join f_alumno_00 on (id_alumno_00=ref_alumno_00_id_alumno_00) 
right join f_examen_00 on (id_examen_00= $id_examen_00) 
right join f_ref_examen_00 on (ref_examen_00_id_examen_00= id_examen_00) 
where id_ref_alumno_00=$id_ref_alumno_00");
$this->datos->next_record();
$id_alumno_00=$this->datos->Record[id_alumno_00];
$id_ref_examen_00 =$this->datos->Record[id_ref_examen_00];
$examen=$this->datos->Record["examen_00_".$this->idioma_traduccion];
$punt=$this->datos->Record[punt];
$punt_min=$this->datos->Record[punt_min];
$punt_max=$this->datos->Record[punt_max];
$status=$this->datos->Record[status];
$fecha=$this->datos->Record[fecha];
$this->navega_sup_info.=$examen;
$info.="<form name='clock' action='' method='post'>";
$this->datos->query("select * from
f_ref_examen_00
right join f_ref_examen_01 on (ref_examen_01_id_ref_examen_00=id_ref_examen_00)
where id_ref_examen_00=$id_ref_examen_00
order by ref_examen_01_id_examen_01");
$arra_form=array();
while($this->datos->next_record()){
    $arra_prov=null;
        $arra_prov[]=0;
        for($h=1;$h<8;$h++){
            if($this->datos->Record["respuesta_0".$h])  $arra_prov[]=$h;
        }//for
        sort($arra_prov);
    $this->addArray($arra_form, $this->datos->Record[ref_examen_01_id_examen_01], $arra_prov);
    $ref_examen_00_id_examen_00=$this->datos->Record[$ref_examen_00_id_examen_00];
}//while
extract($arra_form, EXTR_PREFIX_ALL, "examen");
/*
foreach($arra_form as $clave=>$valor)
foreach($valor as $j) 
echo "EXAMEN: $clave  --  $j<br>";
*/
$this->datos->query("
select * from
f_examen_00
right join f_examen_01 on (examen_01_id_examen_00=id_examen_00)
where id_examen_00=$id_examen_00
order by id_examen_01");
$resultados=array();
$numero_preguntas=$this->datos->record_count;

while($this->datos->next_record()){
$rec=$this->datos->Record;
$id_examen_01=$rec["id_examen_01"];
if(!$entro){
$examen=$rec["examen_00_".$this->idioma_traduccion];
$punt_min=$rec["punt_min"];
$punt_max=$rec["punt_max"];
$entro=true;
}//if $entro
$id_preguntas[]=$id_examen_01;
    $arra_prov=null;
    $arra_prov[]=0;
    for($h=1;$h<8;$h++){
        if($this->datos->Record["respuesta_0".$h])  $arra_prov[]=$h;
    }//for
    if(is_array($arra_prov))
    sort($arra_prov);
    if($arra_prov==${"examen_".$id_examen_01}){
        //echo "<hr> pregunta n-$id_examen_01:  <b>iguales</b><br> ";
        ${"pregunta".$id_examen_01}=true;
        }else{
        //echo "<hr> pregunta n-$id_examen_01:  desiguales<br> ";
        ${"pregunta".$id_examen_01}=false;
   }
           ${"correcto_".$id_examen_01}=$arra_prov;
           $this->addArray($resultados, $id_examen_01, $arra_prov);
}//while
/*
foreach($resultados as $clave=>$valor)
foreach($valor as $j) 
echo "teoria: $clave  --  $j<br>";
*/
$this->datos->query("select 
f_examen_00.id_examen_00, id_examen_01,
examen_00_".$this->idioma_traduccion." as examen,
punt_min, punt_max, tiempo_pregunta, pregunta_a_pregunta, ir_atras,
pregunta_".$this->idioma_traduccion." as pregunta, explicacion_".$this->idioma_traduccion.",
respuesta_01_".$this->idioma_traduccion." as r1,
respuesta_02_".$this->idioma_traduccion." as r2,
respuesta_03_".$this->idioma_traduccion." as r3,
respuesta_04_".$this->idioma_traduccion." as r4,
respuesta_05_".$this->idioma_traduccion." as r5,
respuesta_06_".$this->idioma_traduccion." as r6,
respuesta_07_".$this->idioma_traduccion." as r7,
miniatura
 from f_examen_00
right join f_examen_01 on (id_examen_00=examen_01_id_examen_00)
where id_examen_00=$id_examen_00
");
$i=1;
$numero_preguntas=$this->datos->record_count;
#echo "<hr> $numero_preguntas <hr>";
$inicio=0; 
$fin= $numero_preguntas;
for($actual=$inicio;$actual<$fin;$actual++){
$this->datos->seek($actual);
#echo "<hr>ACTUAL: $actual. TOTAL: $numero_preguntas <hr>";
$h=1;
$rec=$this->datos->Record;
$id_examen_01=$rec["id_examen_01"];
if(!$una){
$una=true;$examen=$rec["examen"]; $punt_min=$rec["punt_min"]; $punt_max=$rec["punt_max"]; $tiempo_pregunta=$rec["tiempo_pregunta"]; $pregunta_a_pregunta=$rec["pregunta_a_pregunta"]; $ir_atras=$rec["ir_atras"];$id_examen_00=$rec["id_examen_00"];  $explicacion=$rec["explicacion_".$this->idioma_traduccion];
}
if($rec["pregunta"]) $pregunta ="<b>".($actual+1).". {$rec["pregunta"]}</b><br>";  else $pregunta=null;
for($w=1;$w<8;$w++) if($_POST["r_".$w."_".$id_examen_01]) ${value.$w}=checked; else ${value.$w}="";
$val_examen=${"examen_".$id_examen_01};
$val_correcto=${"correcto_".$id_examen_01};
for($k=1;$k<8;$k++){
if($rec["r".$k] ){ 
if(is_array($val_examen) and in_array($k , $val_examen)) 
 $img_examen="<INPUT TYPE=CHECKBOX   NAME='r_".$k."_".$id_examen_01."' VALUE='1' checked>"; 
else $img_examen="<INPUT TYPE=CHECKBOX   NAME='r_".$k."_".$id_examen_01."' VALUE='1' >";
if(is_array($val_correcto)) if(in_array($k , $val_correcto)) $img_correcto="<img src='../../img/01_check_profesor.gif' valign='bottom'>"; else $img_correcto ="<img src='../../img/00_check_profesor.gif' valign='bottom'>";
${"r".$k} ="<span class='margin_05' > $img_examen $img_correcto 
 $h. {$rec["r".$k]}</span><br>"; $h++;
 } else 
 ${"r".$k}=null;
 }

/*
${"pregunta".$id_examen_01}=true,false
${"examen_".$id_examen_01}=arra_valores_pregunta_examen_elegidos
${"correcto_".$id_examen_01}
*/
if(${"pregunta".$id_examen_01}) $color=""; else $color="red";
$inf_text="<font color='$color'><input type=hidden name='pregunta_$id_examen_01' value='$id_examen_01'>$pregunta</font><br><br>".$r1.$r2.$r3.$r4.$r5.$r6.$r7."<br><br><font color='$color'> $explicacion </font><br>";
$im=$this->datos->Record["miniatura"];//<img src='../../00_gestion/66_preguntas/imagenes/$im'>
$inf=$this->modulo("green", null, "27", $inf_text );
$info.=$inf."<br>";
$i++;
}//while




$info_examen.=$this->documento->abrir_tabla_modulo('100%', 50,"left");//($ancho,$alto, $alinear_tabla="left")
$info_examen.=$this->documento->abrir_tabla_info('100%', 50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
$info_examen.="\n\n\n<table border=0 width='100%' height='100%' cellspacing=2 cellpadding=5 bgcolor='#CCCCCC'>
<tr><td colspan=2 valign='top' align='left' bgcolor='#FFFFFF'>".$this->navega_sup_info."</td></tr>";
    $info_examen.="\n\n\n<tr><td colspan=2 valign='top' align='left' bgcolor='#EEEEEE'> $info </td></tr>";
$info_examen.="<tr><td colspan=2 bgcolor='#FFFFFF'><input type='hidden' value='' name='actualizar'>
<input type=hidden value='$id_ref_examen_00' name='id_ref_examen_00'>
<input type=hidden value='$id_ref_alumno_00' name='id_ref_alumno_00'>
<input type=hidden value='$id_examen_00' name='id_examen_00'>
<input type=hidden value='$id_alumno_00' name='id_alumno_00'>
<input type='button' name='modificar' value='modificar' onclick=\"javascript:window.self.document.forms[0]['actualizar'].value='go';window.self.document.forms[0].submit();\"></td></tr>";
$info_examen.="</table></form>";
$info_examen.=$this->documento->cerrar_tabla_info('100%', 50,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
$info_examen.=$this->documento->cerrar_tabla_modulo('100%', 50);
return $info_examen;
}//if
}


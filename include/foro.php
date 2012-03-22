<?php
require_once("global_interface.php");
class  foro extends conecto_datos{
var $id_foro00=4;
var $limite='';
var $days='';
var $target='';
var $link1='';
var $link2='';
var $link3='';
var $matriz_thread_si='';
var $matriz__thread_si='';
var $clase_color1='bg_color_0';
var $clase_color2='bg_color_5';
var $imagen_din='19_51_33';



function foro(){
    $this->graba_variables_obj_ppal(func_get_args());
	$this->conecto_datos();
if ($_GET['days']<>""){
$this->days=$_GET['days'];
}else{
$this->days=10000;
}
$limite=mktime(0,0,0,date("m"),date("d")-$this->days,date("Y"));
$limite=strftime("%Y%m%d%H%M%S", $limite);
$this->limite=$limite;
$this->target="?id=".$this->id_foro00."&days=".$this->days."&";
$this->link1="".$this->target."id_foro01=";
$this->link2="".$this->target."id_foro02=";
$this->link3="".$this->target."id_foro03=";




}//foro constructora

function graba_variables_obj_ppal($array_variables){
    foreach($array_variables as $valor_comun){
        foreach($valor_comun as $clave=>$valor) $this->$clave=$valor;
    }//foreach
}// f_graba_variables_obj_ppal


function dibujar(){
$info_00_foro=$this->inicio_forum();

$info_00_foro.=$this->construir_foro_02();
$info_00_foro.=$this->fin_forum();
return $info_00_foro;
}


function construir_foro_02(){



$query="

select  *
from foro01
left join foro02 on (foro02_id_foro01=id_foro01)
left join foro03 on (foro03_id_foro02=id_foro02)

where foro01_fecha>$this->limite and id_tipo_foro=".$this->id_foro00." and tipo_user='".$_SESSION["foros_tipo"]."'

order by foro01_fecha desc, foro02_fecha desc, foro03_fecha desc
";
#order by  id_foro01, id_foro02, id_foro03

$this->query($query);

$arra_global=array();
$arra_global_sec=array();
while($this->next_record()){
$rec=$this->Record;
$id_01=$this->Record[id_foro01];
$id_02=$this->Record[id_foro02];
$id_03=$this->Record[id_foro03];
if($id_01<>$id_01_ant){ 
    $new_01=true; 
	if($rec['foro01_titulo_'.$this->idioma]) $titulo=$rec['foro01_titulo_'.$this->idioma]; else $titulo=$this->sustitucion_lenguaje($rec['foro01_titulo_'.$this->otro_idioma]);
	if($rec['foro01_texto_'.$this->idioma]) $texto=$rec['foro01_texto_'.$this->idioma]; else $texto=$this->sustitucion_lenguaje($rec['foro01_texto_'.$this->otro_idioma]);
    $arra_global[]=array($id_01, $rec[foro01_fecha], $rec[foro01_autor], $titulo, $texto, $rec[foro01_mail]); 
    if($mostrar_ayuda) echo "<br>inserto en princ: $id_01 <hr>";
}

if($id_02<>$id_02_ant){ 
    $new_02=true; 
		if($rec['foro02_titulo_'.$this->idioma]) $titulo=$rec['foro02_titulo_'.$this->idioma]; else $titulo=$this->sustitucion_lenguaje($rec['foro02_titulo_'.$this->otro_idioma]);
	if($rec['foro02_texto_'.$this->idioma]) $texto=$rec['foro02_texto_'.$this->idioma]; else $texto=$this->sustitucion_lenguaje($rec['foro02_texto_'.$this->otro_idioma]);

    $arra_global_sec[]=array($id_02, $rec[foro02_fecha], $rec[foro02_autor], $titulo, $texto, $rec[foro02_mail]); 
}

if($id_02 and ($id_02<>$id_02_ant) ){  
		if($rec['foro02_titulo_'.$this->idioma]) $titulo=$rec['foro02_titulo_'.$this->idioma]; else $titulo=$this->sustitucion_lenguaje($rec['foro02_titulo_'.$this->otro_idioma]);
	if($rec['foro02_texto_'.$this->idioma]) $texto=$rec['foro02_texto_'.$this->idioma]; else $texto=$this->sustitucion_lenguaje($rec['foro02_texto_'.$this->otro_idioma]);

${"arra_global_". $id_01}[]=array($id_02, $rec[foro02_fecha], $rec[foro02_autor], $titulo, $texto, $rec[foro02_mail]); 
if($mostrar_ayuda) echo "<br>inserto en sec de $id_01: $id_02 <hr>";
}

if($id_03) { 
		if($rec['foro03_titulo_'.$this->idioma]) $titulo=$rec['foro03_titulo_'.$this->idioma]; else $titulo=$this->sustitucion_lenguaje($rec['foro03_titulo_'.$this->otro_idioma]);
	if($rec['foro03_texto_'.$this->idioma]) $texto=$rec['foro03_texto_'.$this->idioma]; else $texto=$this->sustitucion_lenguaje($rec['foro03_texto_'.$this->otro_idioma]);

${"arra_global_sec_". $id_02}[]=array($id_03, $rec[foro03_fecha], $rec[foro03_autor], $titulo, $texto, $rec[foro03_mail]); 
if($mostrar_ayuda) echo "<br>inserto en terc de $id_01 >  $id_02: $id_03 <hr>";
}




$id_01_ant=$id_01;
$id_02_ant=$id_02;
$id_03_ant=$id_03;
}//while
    $this->item_lista=array();

foreach($arra_global as $c){
$contador_arra_global++;
$contador_arra_global_c=0;

if(is_array(${"arra_global_".$c[0]})){
    foreach(${"arra_global_".$c[0]} as $v){
    $contador_arra_global_c++;
    $contador_arra_global_sec_v=0;
        if(is_array(${"arra_global_sec_".$v[0]})) {
            foreach(${"arra_global_sec_".$v[0]} as $h){
            $contador_arra_global_sec_v++;
            #echo "{$c[0]} -- {$v[0]} --- {$h[0]}  ______ contador secundario ".count(${"arra_global_sec_".$v[0]})."<br>";
            $this->item_foro(3, "p_n: ".count($arra_global)." s_n:".count(${"arra_global_sec_".$v[0]})
            , "p_l:".$contador_arra_global." s_l".$contador_arra_global_c." t_l".$contador_arra_global_sec_v,
            $c, $v, $h,
            array(count($arra_global), $contador_arra_global) ,
            array(count(${"arra_global_".$c[0]}), $contador_arra_global_c),
            array(count(${"arra_global_sec_".$v[0]}), $contador_arra_global_sec_v)

            );
                        }
        }else{
            $this->item_foro(2, "p_n: ".count($arra_global)." s_n:".count(${"arra_global_".$c[0]})
            , "p_l:".$contador_arra_global." s_l".$contador_arra_global_c, 
            $c, $v, $h,
            array(count($arra_global), $contador_arra_global) ,
            array(count(${"arra_global_".$c[0]}), $contador_arra_global_c),
                        array(count(${"arra_global_sec_".$v[0]}), $contador_arra_global_sec_v)


            );
             #       echo "{$c[0]} -- {$v[0]}   ______ contador primario ".count(${"arra_global_".$c[0]})."<br>";
        }//if sec
    }//foreach
}else{//global princ
$this->item_foro(1, "p_n: ".count($arra_global)." s_n:".count(${"arra_global_".$c[0]}), 
"p_l:". $contador_arra_global, 
$c, $v, $h,
array(count($arra_global), $contador_arra_global),
array(count(${"arra_global_".$c[0]}), $contador_arra_global_c),
array(count(${"arra_global_sec_".$v[0]}), $contador_arra_global_sec_v)


);
               #     echo "{$c[0]}  <br>";

}//if_global_princ
}//foreach
if(!count($arra_global)) $info_no_hay="<tr><td colspan=3 valign='middle' align='center'><br><h3>".$this->traduccion[sin_comentarios]."</h3></td></tr>";
return $this->item_foro."$info_no_hay </table>

</td></table>";

#foreach($this->item_lista as $vv) echo "$vv<br>";
}//function construir_foro_02
#            $v[3], $v[5], $v[2], $v[1], 

#    sprintf("%s/%s/%s %s:%s", substr($fecha1,6,2), substr($fecha1,4,2), substr($fecha1,0,4), substr($fecha1,8,2), substr($fecha1,10,2));

function item_foro($nivel, $total, $lugar, $arra_pri,$arra_sec,$arra_ter, $arra_total_lugar_pri, $arra_total_lugar_sec, $arra_total_lugar_ter){
#echo "<b> $nivel ... $total ........ $lugar  ..... ".$arra_pri[0]."-".$arra_sec[0]."-".$arra_ter[0]."  ...</b><br>";
if(!$this->item_foro) $this->item_foro="";
if($nivel==1){
$this->lugar_exacto=array($arra_total_lugar_pri[1], $arra_total_lugar_pri[0], $arra_total_lugar_sec[1], $arra_total_lugar_sec[0], $arra_total_lugar_ter[1], $arra_total_lugar_ter[0]);
$this->nivel_item= 1;
$this->lugar_item= $arra_total_lugar_pri[1];
$this->lugar_total_item=$arra_total_lugar_pri[0];

$this->titulo_item= $arra_pri[3];
$this->autor_item= $arra_pri[2];
$this->mail_item= $arra_pri[5];
$this->fecha_item = $arra_pri[1];
$this->id_item=$arra_pri[0];
$this->item();
}elseif($nivel==2){
$this->lugar_exacto=array($arra_total_lugar_pri[1], $arra_total_lugar_pri[0], $arra_total_lugar_sec[1], $arra_total_lugar_sec[0], $arra_total_lugar_ter[1], $arra_total_lugar_ter[0]);
$this->nivel_item= 1;
$this->lugar_item= $arra_total_lugar_pri[1];
$this->lugar_total_item=$arra_total_lugar_pri[0];
$this->titulo_item= $arra_pri[3];
$this->autor_item= $arra_pri[2];
$this->mail_item= $arra_pri[5];
$this->fecha_item = $arra_pri[1];
$this->id_item=$arra_pri[0];
$this->item();
$this->nivel_item= 2;
$this->lugar_item= $arra_total_lugar_sec[1];
$this->lugar_total_item=$arra_total_lugar_sec[0];
$this->titulo_item= $arra_sec[3];
$this->autor_item= $arra_sec[2];
$this->mail_item= $arra_sec[5];
$this->fecha_item = $arra_sec[1];
$this->id_item=$arra_pri[0]."-".$arra_sec[0];
$this->item();


}elseif($nivel==3){
$this->lugar_exacto=array($arra_total_lugar_pri[1], $arra_total_lugar_pri[0], $arra_total_lugar_sec[1], $arra_total_lugar_sec[0], $arra_total_lugar_ter[1], $arra_total_lugar_ter[0]);
$this->nivel_item= 1;
$this->lugar_item= $arra_total_lugar_pri[1];
$this->lugar_total_item=$arra_total_lugar_pri[0];
$this->titulo_item= $arra_pri[3];
$this->autor_item= $arra_pri[2];
$this->mail_item= $arra_pri[5];
$this->fecha_item = $arra_pri[1];
$this->id_item=$arra_pri[0];
$this->item();
$this->nivel_item= 2;

$this->lugar_item= $arra_total_lugar_sec[1];
$this->lugar_total_item=$arra_total_lugar_sec[0];
$this->titulo_item= $arra_sec[3];
$this->autor_item= $arra_sec[2];
$this->mail_item= $arra_sec[5];
$this->fecha_item = $arra_sec[1];
$this->id_item=$arra_pri[0]."-".$arra_sec[0];
$this->item();
$this->nivel_item= 3;

$this->lugar_item= $arra_total_lugar_ter[1];
$this->lugar_total_item=$arra_total_lugar_ter[0];
$this->titulo_item= $arra_ter[3];
$this->autor_item= $arra_ter[2];
$this->mail_item= $arra_ter[5];
$this->fecha_item = $arra_ter[1];
$this->id_item=$arra_pri[0]."-".$arra_sec[0]."-".$arra_ter[0];
$this->item();

}

}//function


function item(){
#echo "<b>". $this->lugar_item." - ".$this->lugar_total_item."</b><br>";
$img_fin_linea="<img src='../../images_foros/19_51_33_b2.png' width=20 height=20 border=0 vspace=0 hspace=0 align=left>";
$img_espacio_blanco="<img src='../../images_foros/ajuste.png' width=20 height=20 border=0 vspace=0 hspace=0 align=left>";
$img_espacio_linea="<img src='../../images_foros/19_51_33_b0.png' width=20 height=20 border=0 vspace=0 hspace=0 align=left>";
$img_espacio_linea_cruzada="<img src='../../images_foros/19_51_33_b1.png' width=20 height=20 border=0 vspace=0 hspace=0 align=left>";
$img_cuadrado_mas="<img src='../../images_foros/19_51_33_b4.png' width=20 height=20 border=0 vspace=0 hspace=0 align=left>";
$img_cuadrado_menos="<img src='../../images_foros/19_51_33_b5.png' width=20 height=20 border=0 vspace=0 hspace=0 align=left>";
$img_cuadrado_vacio="<img src='../../images_foros/19_51_33_b6.png' width=20 height=20 border=0 vspace=0 hspace=0 align=left>";

$lugar=$this->lugar_exacto;
$ids_query=explode("-", $this->id_item);

if($this->nivel_item==1){
$this->id_item="?id_foro01=".$ids_query[0]."&open_01=".$ids_query[0]."&open_02=".$ids_query[1];
 $this->img_espacio="";
}elseif($this->nivel_item==2){
$this->id_item="?id_foro02=".$ids_query[1]."&open_01=".$ids_query[0]."&open_02=".$ids_query[1];

    if($lugar[0]==$lugar[1]) $this->img_espacio= $img_espacio_blanco; # nivel 1
    elseif($lugar[0]<$lugar[1]) $this->img_espacio= $img_espacio_linea_cruzada; # nivel 1
}elseif($this->nivel_item==3){
$this->id_item="?id_foro03=".$ids_query[2]."&open_01=".$ids_query[0]."&open_02=".$ids_query[1];

    if($lugar[0]==$lugar[1]){
    
     if($lugar[2]==$lugar[3])
     $this->img_espacio= $img_espacio_blanco. $img_espacio_blanco; # nivel 2
     else
          $this->img_espacio= $img_espacio_blanco. $img_espacio_linea; # nivel 2
     }elseif($lugar[0]<$lugar[1]){ 
     if($lugar[2]==$lugar[3])
     $this->img_espacio= $img_espacio_linea; # nivel 2
     else
          $this->img_espacio= $img_espacio_linea; # nivel 2

     }
}
$this->id_item.="&id=".$this->id_foro00."&days=".$this->days;
if($this->lugar_item==$this->lugar_total_item)  $this->img_visible = $img_fin_linea;
elseif($this->lugar_item<$this->lugar_total_item)  $this->img_visible = $img_espacio_linea_cruzada;



if(!in_array($this->id_item, $this->item_lista) ){
$this->fecha =sprintf("%s/%s/%s %s:%s", substr($this->fecha_item,8,2), substr($this->fecha_item,5,2), substr($this->fecha_item,0,4), substr($this->fecha_item,10,3), substr($this->fecha_item,14,2));
$desplegar_lineas=true;
if($desplegar_lineas){

	if($this->nivel_item==1){
	if($lugar[2]<>$lugar[3] )
	if($_GET['open_01']<>$ids_query[0]) $this->img_visible= $img_cuadrado_menos; 
	else  $this->img_visible= $img_cuadrado_menos;
	if($lugar[2]==$lugar[3] ) 
	if(!$lugar[2])
	 $this->img_visible= $img_cuadrado_vacio;
	elseif($_GET['open_01']<>$ids_query[0]) $this->img_visible= $img_cuadrado_menos; 
	else  $this->img_visible= $img_cuadrado_menos;


	}elseif($this->nivel_item==2){

	if($lugar[4]<>$lugar[5] and  $lugar[5]){
	if($_GET['open_02']<>$ids_query[1]) 
	$this->img_visible= $img_cuadrado_menos; 
	else  $this->img_visible= $img_cuadrado_menos;
	}elseif($lugar[4]==$lugar[5]){
	if(!$lugar[5])
	 $this->img_visible=""; # joao mirar --> aqui estaba $img_cuadrado_vacio
	else
	if($_GET['open_02']<>$ids_query[1])
	$this->img_visible= $img_cuadrado_menos; 
	else
	$this->img_visible= $img_cuadrado_menos; 

	}




	}//nivel
	$this->item_tabla();

}else{

if($this->nivel_item==1){
if($lugar[2]<>$lugar[3] )
if($_GET['open_01']<>$ids_query[0]) $this->img_visible= $img_cuadrado_mas; 
else  $this->img_visible= $img_cuadrado_menos;
if($lugar[2]==$lugar[3] ) 
if(!$lugar[2])
 $this->img_visible= $img_cuadrado_vacio;
elseif($_GET['open_01']<>$ids_query[0]) $this->img_visible= $img_cuadrado_mas; 
else  $this->img_visible= $img_cuadrado_menos;

$this->item_tabla();

}elseif($this->nivel_item==2){

if($lugar[4]<>$lugar[5] and  $lugar[5]){
if($_GET['open_02']<>$ids_query[1]) 
$this->img_visible= $img_cuadrado_mas; 
else  $this->img_visible= $img_cuadrado_menos;
}elseif($lugar[4]==$lugar[5]){
if(!$lugar[5])
 $this->img_visible=""; # joao mirar --> aqui estaba $img_cuadrado_vacio
else
if($_GET['open_02']<>$ids_query[1])
$this->img_visible= $img_cuadrado_mas; 
else
$this->img_visible= $img_cuadrado_menos; 

}



if($_GET['open_01']==$ids_query[0]) $this->item_tabla();
}elseif($this->nivel_item==3){
if($_GET['open_01']==$ids_query[0] && $_GET['open_02']==$ids_query[1] ) $this->item_tabla();

}//nivel
}

}//in array


}

function item_tabla(){
$img_cuadrado_vacio="<img src='../../images_foros/19_51_33_b6.png' width=20 height=20 border=0 vspace=0 hspace=0 align=left>";

if($this->color==$this->clase_color1){
$this->color=$this->clase_color2;
}else{
$this->color=$this->clase_color1;
} 

if($this->nivel_item==1) {
$cuadrado_width=20;
$padding_celda="style='padding-left: 0px;padding-right: 5px;'";$padding_titol= " style='color:#FF6600;font-weight:bold;' ";$padding_autor=" style='color:#FF6600;' "; }
elseif($this->nivel_item==2){
$cuadrado_width=10;
$padding_celda="style='padding-left: 12px;padding-right: 5px;'";$padding_titol= " style='color:#333333;' ";$padding_autor=" style='color:#333333;' "; }
elseif($this->nivel_item==3){
$cuadrado_width=5;
$padding_celda="style='padding-left: 26px;padding-right: 5px;'";$padding_titol= " style='color:#666666;' ";$padding_autor=" style='color:#666666;' "; }
$this->img_espacio="";
$this->img_visible="";

if($this->nivel_item==1 ){
    $info_00_foro.="<tr><td colspan=3>&nbsp;</td></tr>";
}
    $info_00_foro.="<tr valign='center' class='".$this->color."' height=10>
	<td valign='top'  $padding_celda>\n";
    $info_00_foro.=$this->img_espacio."<a href='".$this->id_item."#gotoforum'>". $this->img_visible." </a>
	<a class='s' href='".$this->id_item."#gotoforum' $padding_titol> - ".$this->titulo_item."</a>\n";
    $info_00_foro.="</TD><td class=t valign='top' style='padding-right:5px;'><a class='a' href='mailto:".$this->mail_item."' $padding_autor >".$this->autor_item."</a></td>\n";
    $info_00_foro.="<td class='d'><font size='-2'>". $this->fecha."</font></td>\n";
    $info_00_foro.="</tr>\n";
    $this->item_foro.=$info_00_foro;
    $this->item_lista[]= $this->id_item;
}



function inicio_forum(){
$color_base="#ffcc66";
$info_00_foro.="<!-- FORUM TABLE -->\n";
$info_00_foro.="<table align='left' border='0' cellpadding='2' cellspacing='0'  width='100%' class='bg_color_5'>";
if($_SESSION["foros_tipo"]=="equipo") $info_00_foro.="<tr><td  style='background: url($url_img../../images_home/dot_666666_down.jpg) repeat-x ;'>
			<img src='$url_img../../images_home/pixel_transp.gif' width='1' height='13' alt=''></td></tr><tr><td><br><br></td></tr>";
$info_00_foro.="                     
<tr><td><h1 style='color:#FF6600'>".$this->traduccion[foro_dialogo]."</h1></td></tr>
<tr><TD>\n";
$info_00_foro.="<table border=0 cellspacing='0' cellpadding='0' width='100%' >
<tr>
<td width='300'><img src='../../images_foros/ajuste.png' width='300' height=1></td>
<td width='10'><img src='../../images_foros/ajuste.png' width='10' height=1></td>
<td width='10'><img src='../../images_foros/ajuste.png' width='10' height=1></td></tr>
\n";
$info_00_foro.="<tr><td align='right'  colspan=3 ><span class='etiqueta_peq'>
<a class='seleccion' 
 href='#' onclick=\"javascript:window.open('message.php?id_foro00=".$this->id_foro00."','pop','toolbar=no, location=no, status=no, width=400, height=400, left=0, top=0, scrollbars=yes, resizable=yes');\" >
<b>* ".$this->traduccion[nuevo_comentario]." </b> </a>&nbsp;</span></td></tr>";
$info_00_foro.="<tr><td align='right'  colspan=3 class='foro_td'><img src='../../images/ajuste.gif' width=1 height=1></td></tr>";
$info_00_foro.="<tr><td align='right'  colspan=3 >&nbsp;</td></tr>";

$info_00_foro.="<tr valign='middle' >\n";
$info_00_foro.="<td class='foro_td'>&nbsp;<span class='title2'>".$this->traduccion[comentario]." </span><br><IMG src='../../images/ajuste.gif' width=200 height=1 alt=''></td>\n";
$info_00_foro.="<td  class='foro_td'><span class='title2'>".$this->traduccion[autor]."<br><IMG src='../../images/ajuste.gif' width=200 height=1 alt=''></span></td>\n";
$info_00_foro.="<td  class='foro_td'><span class='title2'>".$this->traduccion[fecha]."<br><IMG src='../../images/ajuste.gif' width=130 height=1 alt=''></span></td></tr>
\n";
return $info_00_foro;
}//function


function fin_forum(){
$info_00_foro.="<!-- /FORUM TABLE -->\n";


$info_00_foro.="<br clear=all>\n";
$info_00_foro.="<P>\n";
$info_00_foro.="<FORM METHOD=get ACTION='".$_SERVER['PHP_SELF']."' name=daysfrm>\n";
$info_00_foro.="<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
$info_00_foro.="<tr><td align='right'  class='foro_td'><img src='../../images/ajuste.gif' width=1 height=1></td></tr><tr>\n";
$info_00_foro.="<td><br>\n";
$info_00_foro.="<div align='left'>\n";
$info_00_foro.="\n";
$info_00_foro.=$this->traduccion[ver_comentarios]." &nbsp;&nbsp;";
$dias=$this->traduccion[dias];
$info_00_foro.="<SELECT name='days'>\n";
$selected="";if ($this->days==7)$selected="SELECTED";
$info_00_foro.="<option value='7' $selected > 7 $dias </option>\n";
$selected="";if ($this->days==14)$selected="SELECTED";
$info_00_foro.="<option value='14' $selected > 14 $dias </option>\n";
$selected="";if ($this->days==30)$selected="SELECTED";
$info_00_foro.="<option value='30' $selected > 30 $dias </option>\n";
$selected="";if ($this->days==60)$selected="SELECTED";
$info_00_foro.="<option value='60' $selected > 60 $dias </option>\n";
$selected=""; if ($this->days==10000)$selected="SELECTED";
$info_00_foro.="<option value='10000'  $selected >".$this->traduccion[todos_comentarios]." </option>\n";
$info_00_foro.="</SELECT>\n";
$info_00_foro.="&nbsp;<input type='submit'  value=' ".$this->traduccion[filtrar]." '>\n";
$info_00_foro.="</div>\n";
$info_00_foro.="</td>\n";
$info_00_foro.="<td>\n";
$info_00_foro.="<div align='right'>\n";
$info_00_foro.="</div>\n";
$info_00_foro.="</td></tr>\n";
$info_00_foro.="<tr><td align='right'   >&nbsp;</td></tr>";
$info_00_foro.="<tr><td align='right'  class='foro_td'><img src='../../images/ajuste.gif' width=1 height=1></td></tr>";
if(!$_GET[id_foro01] and !$_GET[id_foro03] and !$_GET[id_foro03])$info_00_foro.="<tr><td align='right' ><a href='?abandon=1'><b>**".$this->traduccion[abandon_foro]."</b></a></td></tr>";


$info_00_foro.="</table>\n";
foreach($_GET as $clave=>$valor)
if ($clave<>"days")
$info_00_foro.="<input type='hidden' name='$clave' id='$clave' value='$valor'>\n";
$info_00_foro.="</FORM>\n";



$info_00_foro.="\n";
if ($_GET['id_foro01']<>"" OR $_GET['id_foro02']<>"" OR $_GET['id_foro03']<>"")
$info_00_foro.= $this->select_message();

return $info_00_foro;
}//function


function select_message(){
$id_foro01=$_GET['id_foro01'];
$id_foro02=$_GET['id_foro02'];
$id_foro03=$_GET['id_foro03'];

if($id_foro01<>""){
$add="where id_foro01=".$_GET['id_foro01']."";
$valorar=1;
}
if($id_foro02<>""){
$add="where id_foro02=".$_GET['id_foro02']."";
$valorar=2;
}
if($id_foro03<>""){
$add="where id_foro03=".$_GET['id_foro03']."";
$valorar=3;
}
$foro="foro0".$valorar;
$query="select ".$foro."_fecha as fecha, ".$foro."_autor as autor, ".$foro."_titulo_".$this->idioma." as titulo, ".$foro."_texto_".$this->idioma." as texto,  ".$foro."_mail as mail from $foro
$add
";
$query="select * from $foro
$add
";

$this->query($query);

$this->next_record();
if($this->Record[$foro."_titulo_".$this->idioma]) $titulo=$this->Record[$foro."_titulo_".$this->idioma]; else $titulo=$this->sustitucion_lenguaje($this->Record[$foro."_titulo_".$this->otro_idioma]);
if($this->Record[$foro."_texto_".$this->idioma]) $texto_mensaje=$this->a_html_format($this->Record[$foro."_texto_".$this->idioma]); else $texto_mensaje=$this->sustitucion_lenguaje($this->a_html_format($this->Record[$foro."_texto_".$this->otro_idioma]));
$fecha=(string)$this->Record[$foro."_fecha"];
$autor=$this->Record[$foro."_autor"];
$mail=$this->Record[$foro."_mail"];
$info_00_foro.="<table width='100%' border='0' cellspacing='0' cellpadding='2' bgcolor='".$this->color2."'>";
$info_00_foro.="<tr>\n";
$info_00_foro.="<td>\n";
$info_00_foro.="<table width='100%' border='0' cellspacing='0' cellpadding='4' bgcolor='".$this->color1."'>\n";
$info_00_foro.="\n";

if ($_GET['id_foro02']<>""){$valorar=2;}else{$valorar=1;}
$info_00_foro.="<tr class='bg_color_0'><td><div align='right'><A NAME='gotoforum'></A></div><b>".$this->traduccion[asunto].":</b> ".$titulo."<br> <b>".$this->traduccion[autor]." </b>".$autor."<br><b>".$this->traduccion[fecha]."</b> ";

$fecha_formato=sprintf("%s/%s/%s %s:%s", substr($fecha,6,2), substr($fecha,4,2), substr($fecha,0,4), substr($fecha,8,2), substr($fecha,10,2));

$info_00_foro.="$fecha_formato <br> <br><b>".$this->traduccion[comentario]." </b><br>".$texto_mensaje."</td></tr>\n";




      $reply="message.php?id_foro01=$id_foro01&id_foro02=".$_GET['id_foro02']."";
      $info_00_foro.="
      <tr><td align='left'   >
     <b> <a class='seleccion' 
 href='#' onclick=\"javascript:window.open('$reply','pop','toolbar=no, location=no, status=no, width=400, height=400, left=0, top=0, scrollbars=yes, resizable=yes');\" > * ".$this->traduccion[contestar_comentario]." </A></b></td></tr>";


$info_00_foro.="<tr>\n";

$info_00_foro.="<td align='center'>\n";
$info_00_foro.="<table width='100%' border='0' bgcolor='".$this->color1."' cellpadding='0' cellspacing='0'>\n";
$info_00_foro.="<tr>\n";
$info_00_foro.="<td>\n";
$info_00_foro.="\n";
$info_00_foro.="\n";



   
$info_00_foro.="</td>\n";
$info_00_foro.="</tr>\n";
$info_00_foro.="<tr><td align='right'  class='foro_td'><img src='../../images/ajuste.gif' width=1 height=1></td></tr>";
if($_GET[id_foro01] or $_GET[id_foro03] or $_GET[id_foro03])$info_00_foro.="<tr><td align='right' ><a href='?abandon=1'><b>** ".$this->traduccion[abandon_foro]."</b></a></td></tr>";

$info_00_foro.="</table>\n";
$info_00_foro.="</td></tr>\n";
$info_00_foro.="</form>\n";
$info_00_foro.="</table>\n";
$info_00_foro.="</td></tr></table>\n";
return $info_00_foro;
}//function select_message



}//class
?>
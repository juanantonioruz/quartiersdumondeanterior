<?php
require_once("global_interface.php");
class gestionar extends global_interface{
var $pack_0=array();
var $arra_idiomas=array('esp', 'por');

# -------------------------------- variables de sesion inicio
var $filtrar=''; 
var $menu_filtrar=''; 
var $order_00=''; 
var $order_01=''; 
var $limite=''; 
var $pagina_actual=''; 
# -------------------------------- variables de sesion fin

var $permiso_actual='';
var $seccion_actual='';
var $info_registro_indice='';

function gestionar(){
    $this->graba_variables_obj_ppal(func_get_args());
    $this->check_registro();
    $this->select_pack();
    $this->registro_indice();
    $this->navega_sup();
        if($this->archivo=='index.php')	$this->documento_gestion->salida($this->indice(),true, true);
        elseif($this->archivo=='mas.php')	$this->documento_gestion->salida($this->pagina_mas(),true, true);
        elseif($this->archivo=='mod.php')	$this->documento_gestion->salida($this->pagina_mod(),true, true);
        elseif($this->archivo=='del.php')	$this->documento_gestion->salida($this->pagina_del(),true, true);
        elseif($this->archivo=='mail.php')	$this->documento_gestion->salida($this->mail(), true, true);
		

}//f_gestionar


function check_registro(){
if($_GET[id_seccion]){
 $this->id_seccion=$_GET[id_seccion];
     $_SESSION[last_id_seccion]=$this->id_seccion;
 }else{
  $this->id_seccion=$_SESSION[last_id_seccion];

 }
$query_permisos="select img, id_registro_00, registro_00.id_registro_00, registro_00.idioma as idioma, user, password, id_registro_01, seccion_00 ,seccion_00_esp, seccion_00_fra, seccion_00_por, seccion_00_cat ,  seccion_00.id_seccion_00, traduce_1, traduce_2, traduce_3, registro_01_id_registro_00
from registro_00
left join registro_01 on (registro_00.id_registro_00=registro_01.registro_01_id_registro_00)
left join seccion_00 on (seccion_00.id_seccion_00=registro_01.registro_01_id_seccion_00)
where user='".$this->user."' and password='".$this->password."' and id_seccion_00='".$this->id_seccion."'
order by registro_00.id_registro_00";
$this->conecto_central->query($query_permisos);
#echo $query_permisos;
if($this->user && $this->password && $this->seccion=='c_upload'){
    $this->permiso_actual=true;
}else{
        if($this->conecto_central->next_record()){
            extract($this->conecto_central->Record);
			  $this->seccion=$seccion_00;
            $this->id_registro_00=$id_registro_00;
            $this->permiso_actual=true;
            $this->seccion_actual=ucfirst(${"seccion_00_".$idioma});
                if($img) $this->img_gestion="<img src='../images/$img' width=70>"; 
                else $this->img_gestion=null;
            $this->idioma_traduccion=$idioma;
                if($traduce_1) $this->traduce[]=$traduce_1;
                if($traduce_2) $this->traduce[]=$traduce_2;
                if($traduce_3) $this->traduce[]=$traduce_3;
            $this->conecto_datos->idioma_traduccion=$idioma;
            $this->conecto_central->idioma_traduccion=$idioma;
        if(!$this->conecto_central->traducciones_hechas)$this->conecto_central->traducir_arra();
        }else{
            echo "
            <SCRIPT language=JavaScript>
            <!--
            parent.document.location='../c_99/index.php';
            //-->
            </SCRIPT>
            ";
            die();
        }//if
}//if
}//function


function select_pack(){
 $this->conecto_central->query("
 select seccion_relacion_id_seccion_00, seccion_relacion_id_seccion_00_bis, condicion, seccion_00, id_seccion_00 from seccion_relacion 
 left join seccion_00 on (id_seccion_00= seccion_relacion_id_seccion_00_bis)
 where id_seccion_00='".$this->id_seccion."'  order by prioridad" 
);
if($this->conecto_central->record_count){
    $arra_cabecera_new=array();
    while( $this->conecto_central->next_record()){
        extract($this->conecto_central->Record);
        $arra_cabecera_new[$seccion_relacion_id_seccion_00]=$condicion;
    }//while
    foreach($arra_cabecera_new as $clave=>$valor){
        if($clave==$this->seccion){ 
        $valor_arra=explode("=", $valor);
        $valor_condicion=$valor_arra[1];
        $condicion=$valor_arra[0];
        $this->pack_0=$arra_cabecera_new; 
        $this->pack_name="$seccion_relacion_id_seccion_00";
        $this->pack_id_name=$condicion; 
        $this->pack_id_condicion=$valor_condicion; 
        #echo "$valor_condicion $condicion ". $this->pack_name."<hr>";
        }//if
        #echo "$clave $valor<br>";
    }//foreach
}//if recordcount
}//f_ select_pack


function registro_indice(){
if($_GET['filtrar_button']<>""){
            if($_GET['filtrar']<>""){
                $cambio=true;
                $this->filtrar=$_GET['filtrar'];
                $this->menu_filtrar=$_GET['menu_filtrar'];
                }else{
                $this->filtrar="";
                $this->menu_filtrar="";
            }//filtrar
    $_SESSION["sqls"][$this->pack_name][$this->seccion]["filtrar"]=$this->filtrar;
    $_SESSION["sqls"][$this->pack_name][$this->seccion]["menu_filtrar"]=$this->menu_filtrar;
    }else{
    $this->filtrar=$_SESSION["sqls"][$this->pack_name][$this->seccion]["filtrar"];
    $this->menu_filtrar=$_SESSION["sqls"][$this->pack_name][$this->seccion]["menu_filtrar"];
}//filtrar_button

$arra_session=array('order_00', 'order_01', 'limite', 'pagina_actual');
foreach($arra_session as $valor)
if($_GET[$valor]<>""){
$cambio=true;
$this->$valor=$_GET[$valor];
$_SESSION["sqls"][$this->pack_name][$this->seccion][$valor]=$this->$valor;
}else{
$this->$valor=$_SESSION["sqls"][$this->pack_name][$this->seccion][$valor];
}

if($cambio && !$_GET['pagina_actual']){
$this->pagina_actual=1;
$_SESSION["sqls"][$this->pack_name][$this->seccion]["pagina_actual"]=$this->pagina_actual;
}

$i='0';
foreach($this->pack_0 as $clave=>$valor){
if(strrchr($valor, '=')){
$valor_arra=explode("=", $valor);
$valor=$valor_arra[0];
}//if


if($_GET[$valor] && $clave==$this->seccion){
$this->{"base_".$i}=$_GET[$valor];
$_SESSION["sqls"][$this->pack_name][$this->seccion][$valor]=$this->{"base_".$i};
}else{
$this->{"base_".$i}=$_SESSION["sqls"][$this->pack_name][$this->seccion][$valor];
}//if
$i++;

}//foreach
# MIRAR SESIONES
if(is_array($_SESSION["sqls"][$this->pack_name]))
foreach($_SESSION["sqls"][$this->pack_name] as $clave_pack=>$valor_pack) 
    foreach($valor_pack as $clave=>$valor) $info.= "\n<span class=calida>".$this-> pack_name ."</span><span class=azul>$clave_pack</span>  $clave $valor<br>";
    $info.="\n\n";
$this->info_registro_indice=$info;

}//function registro_indice



function navega_sup($info=''){
if($this->archivo=='mas.php') $oyo_complemento=$this->conecto_central->traduccion[gest_anyadir_reg];
elseif($this->archivo=='mod.php') $oyo_complemento=$this->conecto_central->traduccion[gest_modificar_reg];
elseif($this->archivo=='index.php') $oyo_complemento=$this->conecto_central->traduccion[gest_indice_reg];
elseif($this->archivo=='del.php') $oyo_complemento=$this->conecto_central->traduccion[gest_eliminar_reg];
    if(is_array($this->{$this->pack_name})) $arra_prov=$this->{$this->pack_name}; 
    elseif(is_array($this->pack_0)) $arra_prov= $this->pack_0;
    if(is_array($arra_prov)) 
        foreach($arra_prov as $clave=>$valor){
        if($clave==$this->seccion) $cond=true;
        if(!$cond){
        $this->conecto_central->query("select id_seccion_00, img, seccion_00_".$this->idioma_traduccion." as content from seccion_00 where seccion_00='".$clave."'");
        if($this->conecto_central->next_record()){
        if($this->conecto_central->Record['img']) $img_gestion="<img src='../images/".$this->conecto_central->Record['img']."' width=70>"; else $img_gestion=null;
        $oyo.="<a href='index.php?id_seccion=".$this->conecto_central->Record[id_seccion_00]."' class='menu_sup_nav'>$img_gestion ".$this->conecto_central->Record['content']."</a> &gt";
        }
        }//if
        }//foreach
$this->navega_sup_info="\n <a href='../c_99/' class='menu_sup_nav'><img src='../images/licq.png' width=70> Inicio </a> > > ".$oyo."<a href='index.php?id_seccion=".$this->id_seccion."' class='menu_sup_nav'>".$this->img_gestion." ".$this->seccion_actual."</a> &gt; $oyo_complemento \n\n"; #.$_SESSION["sqls"][$this->pack_name][$this->seccion]["info_zona_00"].
}//f_ navega_sup








function select_tipo_campo($id_campo, $campo_trad ,$tipo_campo, $tipo_carga_datos, $argumentos){
if($tipo_campo=='password') $tipo_campo='text';
if($tipo_campo=='doc') $tipo_campo='img';
    switch ($tipo_campo){
          case "fecha":
      if($_POST[$id_campo]==null OR $_POST[$id_campo]==''){ $valor=$this->{'select_'.$id_campo};}
      else $valor=$_POST[$id_campo];
      if(!$valor) $valor=date("Y-m-d");
      if($this->archivo<>'del.php')
        $resultado.="<b>$campo_trad</b> <br><input type='text' size=28 name='".$id_campo."'  value=\"".$this->de_html($valor)."\" class='forms'><br>$salto$salto\n\n";
        else
        $resultado.="<b class='gestion2'>$campo_trad</b> ".$this->de_html($valor)." <br>\n\n";
        break;
          case "hora":
      if($_POST[$id_campo]==null OR $_POST[$id_campo]==''){ $valor=$this->{'select_'.$id_campo};}
      else $valor=$_POST[$id_campo];
      if(!$valor) $valor=date("H:i");
      if($this->archivo<>'del.php')
        $resultado.="<b>$campo_trad</b> <br><input type='text' size=28 name='".$id_campo."'  value=\"".$this->de_html($valor)."\" class='forms'><br>$salto$salto\n\n";
        else
        $resultado.="<b class='gestion2'>$campo_trad</b> ".$this->de_html($valor)." <br>\n\n";
        break;

      case "text":
      if($tipo_carga_datos=='consulta'){
      if($_POST[$id_campo]==null OR $_POST[$id_campo]==''){ $valor=$this->{'select_'.$id_campo};}
      else $valor=$_POST[$id_campo];
      }elseif($tipo_carga_datos=='directo'){
      $valor=$argumentos;
      }
      if($this->archivo<>'del.php')
        $resultado.="<b>$campo_trad</b> <br><input type='text' size=28 name='".$id_campo."'  value=\"".$this->de_html($valor)."\" class='forms'><br>$salto$salto\n\n";
        else
        $resultado.="<b class='gestion2'>$campo_trad</b> ".$this->de_html($valor)." <br>\n\n";
        break;
      case "hidden":
if($tipo_carga_datos<>'directo'){
        if($_POST[$id_campo]==null OR $_POST[$id_campo]==''){ $valor=$this->{'select_'.$id_campo};}
      else $valor=$_POST[$id_campo];
      }else{
      $valor=$argumentos;
      }
        $resultado="<input type='hidden' name='".$id_campo."' value=\"$valor\">\n\n";
        break;
      case "last_insert":
      $valor="last_insert_id()";
        $resultado="<input type='hidden' name='".$id_campo."' value=\"$valor\">\n\n";
        break;
              case "idioma":
        $resultado="<b>$campo_trad</b> <br>".$this->{'select_'.$id_campo}."<input type='hidden' name='".$id_campo."' value=\"".$this->{'select_'.$id_campo}."\"><br>\n\n";
        break;

        case "img":
        $resultado.="<b>$campo_trad</b><br><a name='$id_campo'>".$this->upload->archivo_upload("$id_campo", '50000', 600, 600, $this->traduce). "<br>";
        break;
        case "referencia":
        if($argumentos)
                $resultado="<input type='hidden' name='".$id_campo."' value=\"$argumentos\">\n\n";
        else{
                if($_POST[$id_campo]==null OR $_POST[$id_campo]==''){ $valor=$this->{'select_'.$id_campo};}
      else $valor=$_POST[$id_campo];
        $resultado="$argumentos <input type='hidden' name='".$id_campo."' value=\"$valor\">\n\n";
        }
        break;
      case "textarea":
            if($tipo_carga_datos=='consulta'){
      if($_POST[$id_campo]==null OR $_POST[$id_campo]==''){ $valor=$this->{'select_'.$id_campo};}
      else $valor=$_POST[$id_campo];
      }elseif($tipo_carga_datos=='directo'){
      $valor=$argumentos;
      }
        $resultado="<b>$campo_trad</b> <br><textarea name='".$id_campo."' cols=40 rows=8 class='forms'>$valor</textarea><br>$salto$salto\n\n";
        break;
      case "textarea_g":
            if($tipo_carga_datos=='consulta'){
      if($_POST[$id_campo]==null OR $_POST[$id_campo]==''){ $valor=$this->{'select_'.$id_campo};}
      else $valor=$_POST[$id_campo];
      }elseif($tipo_carga_datos=='directo'){
      $valor=$argumentos;
      }
        $resultado="<b>$campo_trad</b> <br><textarea name='".$id_campo."' cols=80 rows=12 class='forms'>$valor</textarea><br>$salto$salto\n\n";
        break;
              case "textarea_p":
            if($tipo_carga_datos=='consulta'){
      if($_POST[$id_campo]==null OR $_POST[$id_campo]==''){ $valor=$this->{'select_'.$id_campo};}
      else $valor=$_POST[$id_campo];
      }elseif($tipo_carga_datos=='directo'){
      $valor=$argumentos;
      }
        $resultado="<b>$campo_trad</b> <br><textarea name='".$id_campo."' cols=40 rows=3 class='forms'>$valor</textarea><br>$salto$salto\n\n";
        break;

        case "fecha":
        $resultado="$informacion<input type='text' size=28 name='".$nombre."' value=\"".$valor."\" class='forms'>$salto$salto\n\n";
        break;         
        case "radio":
        if($this->archivo<>'del.php'){
        $resultado.="<b>$campo_trad</b> <br>";
        if($tipo_carga_datos=='array')
        foreach($argumentos as $clave=>$valor){
            if($_POST[$id_campo]){
            if($_POST[$id_campo]==$valor) $sel="checked"; else $sel='';
            }else{
            if($this->{"select_$id_campo"}==$valor) $sel="checked"; else $sel='';
            }//if
        $resultado.=" $clave  <input type=radio value='$valor' name='$id_campo' $sel >\n";
        }//foreach
                $resultado.="<br>";
        }else{
            if($tipo_carga_datos=='array'){
                foreach($argumentos as $clave=>$valor){
                    if($found==false)
                    if($this->{"select_$id_campo"}==$valor){ $sel="checked"; $found=$clave;} else $sel='';
                }//foreach
                }//if
            $resultado.="<b class='gestion2'>$campo_trad</b> ". $found." \n<br>\n\n";
        }
        break;         
        case "select":
        $resultado="<b>$campo_trad</b>";
        $resultado.=" <br><select name='$id_campo' class='forms'>\n";
        if($tipo_carga_datos=='sql')$valores=$argumentos[0]; else $valores=$argumentos;
       # if(is_array($valores))
        foreach($valores as $clave=>$valor){
#      echo "$clave $valor <br>";
        if($_POST[$id_campo]){
        if($_POST[$id_campo]==$valor) $sel="selected"; else $sel='';
        }else{
        if($this->{"select_$id_campo"}==$valor) $sel="selected"; else $sel='';
        }//if
             $resultado.=" <option $sel value=\"$valor\"> $clave </option>\n";
}
    $resultado.="</select><br>\n\n";
        break;         
    }//switch
#    $resultado.= $campo_trad .$tipo_carga_datos;
return $resultado;

}


function modulo($color, $ancho, $alto, $contenido){
$constante=" WIDTH=9 HEIGHT=9 ";
if($ancho){ $ancho_mitad=$ancho-($nueve*2); $ancho_total=$ancho;}
else{$ancho_mitad=""; $ancho_total="100%";}
$nueve="9";
$info.= "\n\n<TABLE width='$ancho_total' height='$alto' BORDER=0 CELLPADDING=0 CELLSPACING=0>\n";
$info.= "<TR><TD background='../../img/".$color."_mod_01.gif' $constante ><IMG SRC='../../img/ajuste.gif' $constante ></TD>
<TD background='../../img/".$color."_mod_02.gif'><IMG SRC='../../img/ajuste.gif' WIDTH='$ancho_mitad' HEIGHT=$nueve ALT=''></TD>
<TD background='../../img/".$color."_mod_03.gif' $constante ><IMG SRC='../../img/ajuste.gif' $constante></TD>
</TR>\n";
$info.= "<TR><TD background='../../img/".$color."_mod_04.gif'><IMG SRC='../../img/ajuste.gif' WIDTH=$nueve HEIGHT='".($alto-($nueve*2))."' ALT=''></TD>
<TD background='../../img/".$color."_mod_05.gif'   HEIGHT='$ancho_mitad' valign='top'>
$contenido
</TD>
<TD background='../../img/".$color."_mod_06.gif'>
<IMG SRC='../../img/ajuste.gif' WIDTH=$nueve HEIGHT='".($alto-($nueve*2))."' ALT=''></TD>
</TR>\n";
$info.= "<TR><TD background='../../img/".$color."_mod_07.gif' $constante ><IMG SRC='../../img/ajuste.gif' $constante ></TD>
<TD background='../../img/".$color."_mod_08.gif'><IMG SRC='../../img/ajuste.gif' WIDTH='$ancho_mitad' HEIGHT=$nueve ALT=''></TD>
<TD background='../../img/".$color."_mod_09.gif' $constante ><IMG SRC='../../img/ajuste.gif' $constante></TD>
</TR>\n";
$info.= "</TABLE>";
return $info;
}//modulo


}//class
?>
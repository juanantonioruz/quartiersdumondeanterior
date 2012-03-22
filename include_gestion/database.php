<?php
require_once("objeto.php");
require_once("global_interface.php");
class  database extends global_interface{

var $Link_ID = 0; // Result of mysql_connect().
var $Query_ID = 0;// Result of most recent mysql_query
var $Record = array(); //current mysql_fetch_array()-result
var $Row; // current row number

var $Errno =0;//error state of query
var $Error ="";
var $record_count="";
var $Num_Atrib="";
var $Nombre_Atrib="";#array
var $mensajes_usuario=array("no","Error en la conexi&oacute;n", "Error en la selecci&oacute;n de la base de datos ", "Error en la consulta a la base de datos" );
var $traduccion=array();


/*
function database(){
}//end of the function constructor
*/







function traducir_arra(){
if($this->depurar_database) $this->depurar_mensaje("Traducciones de web realiz&aacute;ndose");

        if(($this->idioma_traduccion) or $this->idioma<>"gestion"){
        if($this->idioma=="gestion"){
        $this->query("select identificativo, texto_esp, texto_".$this->idioma_traduccion." from traducir_gestion ");
        while($this->next_record()){
         if($this->Record["texto_".$this->idioma_traduccion])
          $tt=$this->Record["texto_".$this->idioma_traduccion];
         else
           $tt=$this->Record["texto_".$this->otro_idioma];

         $this->addArray($this->traduccion, $this->Record[identificativo],$tt);
         }
        }else{
		$this->query("select * from traducir_web where identificativo_esp in (".implode(',',$this->traducir ).")");
        while($this->next_record()){
        if($this->Record["texto_".$this->idioma])
         $this->addArray($this->traduccion, $this->Record[identificativo_esp],$this->Record["texto_".$this->idioma]);
        else
          $this->addArray($this->traduccion, $this->Record[identificativo_esp],$this->Record["texto_".$this->otro_idioma]);
}
        }//if_gestion
        }//if
        if($this->depurar_database)foreach($this->traduccion as $clave=>$valor) echo "$clave  $valor<hr>";
}


function mostrar_esquema_consulta($limite_registros=null){
    $salida.= "<style type='text/css'>
    <!--
    td.data_cabecera {font-family:Verdana,Helvetica,Arial,sans-serif;font-size:10px;color:brown;}
    td.data_celda_1 {font-family:Verdana,Helvetica,Arial,sans-serif;font-size:10px;color:gray;}
    td.data_celda_2 {font-family:Verdana,Helvetica,Arial,sans-serif;font-size:10px;color:brown;}
    -->
    </style>";
    $salida.=  "\n\n<table border=1 cellpadding=2 cellspacing=0 bordercolor=antiquewhite bgcolor=beige width='100%'>\n<tr>";
    for ($i=0;$i<$this->Num_Atrib;$i++){
        $salida.=  "\n\t<td class='data_cabecera'>
        ".mysql_field_name($this->Query_ID,$i)."</td>";          
    }//for
    $salida.=  "</tr>\n<tr>";
    for ($i=0;$i< $this->Num_Atrib;$i++){
        $salida.=  "\n\t<td  class='data_celda_1'>".mysql_field_type($this->Query_ID,$i)."</td>";
    }//end for
    while($this->next_record() && $j<>$limite_registros){
        $j++;
        $salida.=  "</tr>\n<tr>";
        for ($i=0;$i< $this->Num_Atrib;$i++){
            $salida.=  "\n\t<td  class='data_celda_2'>
                    ".$this->Record[mysql_field_name($this->Query_ID,$i)]."</td>";
        }//end for
    }//while next_record()
    $salida.=  "</tr>\n</table>\n\n";
    return $salida;
}//end function






}//class conecto
?>
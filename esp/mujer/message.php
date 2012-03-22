<?php
session_start();
require("../../include/objeto.php");
$objeto=new objeto(array("'comentario'", "'autor'", "'fecha'", "'nuevo_comentario'", "'contestar_comentario'", "'ver_comentarios'", "'dias'", "'todos_comentarios'", "'filtrar'","'asunto'", "'enviar_comentario'", "'borrar_comentario'", "'cerrar_ventana'", "'introduce_nombre'", "'introduce_asunto'", "'foro_dialogo'"));
$trad=$objeto->documento->conecto_datos->traduccion;
if($_POST['submitb']<>"" ){
$autor=$objeto->a_html($_POST['autor']);
$titulo=$objeto->a_html($_POST['titulo']);
$mail=$_POST['mail'];
$texto=$objeto->a_html($_POST['texto']);
$id_foro=$_POST['id_foro'];
$foro=$_POST['foro'];

if($foro==3) $v_foro="foro03_id_foro02";
elseif($foro==2) $v_foro="foro02_id_foro01";
else{
 $v_foro="id_tipo_foro";
 $valor_tipo_user=", '".$_SESSION["foros_tipo"]."'";
 $tipo_user=", tipo_user";
  }
  $query="insert into foro0$foro ($v_foro, foro0".$foro."_fecha, foro0".$foro."_autor,  foro0".$foro."_titulo_".$objeto->idioma.",  foro0".$foro."_texto_".$objeto->idioma.",  foro0".$foro."_mail $tipo_user)
  values(
  $id_foro,
  null,
  '$autor',
  '$titulo',
  '$texto',
  '$mail'
  $valor_tipo_user
  )";

  $objeto->conecto_datos->query($query);
  /*
  header( "location: ".$_POST['referer']."" );
  die;
  */
  echo "<html>
  <head>
  <SCRIPT language=JavaScript>
  <!--
  window.opener.focus();
  window.opener.location.reload();
  window.self.close();
  //-->
  </SCRIPT>
  </head>
  <body>
  </body>
  </html>
  ";

  #echo $query;
  }else{
  $objeto->documento->titulo_pagina=$trad[foro_dialogo];
  echo $objeto->documento->head_in();
  if($_GET['id_foro00']<>""){$foro=1;$id_foro=$_GET['id_foro00'];}

  if($_GET['id_foro01']<>""){$foro=2;$id_foro=$_GET['id_foro01'];}
  if($_GET['id_foro02']<>""){$foro=3;$id_foro=$_GET['id_foro02'];}

  $objeto->documento->head_in();
  #$objeto->documento->open_body();
  echo "<body><h1 style='color:#FF6600'>".$trad[foro_dialogo]."</h1>";
  echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>\n";
  echo "<!--\n";
  echo "function formsubmit() {\n";
  echo "alertmsg = '';\n";
  echo "if (document.msgform.autor.value == '') { alertmsg = '".$trad[introduce_nombre]."'; }\n";
  echo "if (document.msgform.titulo.value == '') { alertmsg = '".$trad[introduce_asunto]."'; }\n";
  echo "if (alertmsg == '') {\n";
  echo "return true;\n";
  echo "} else {\n";
  echo " window. alert (alertmsg);\n";
  echo "return false;\n";
  echo "}\n";
  echo "}\n";
  echo "function formquote() {\n";
  echo "vvv = '';\n";
  echo "}\n";
  echo "//-->\n";
  echo "</SCRIPT>\n";


  $objeto->documento->abrir_tabla_modulo(200,100,"left","middle", "left");





  $objeto->documento->abrir_tabla_info(200,100,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)

  echo "<form name='msgform' action='message.php' onsubmit='return formsubmit();' method='post'>\n";
  echo "<table border='0' cellspacing='0' cellpadding='2' class='bg_color_0'>\n";
  echo "<tr>\n";
  echo "<td>\n";
  echo "<table width='100%' border='0' cellspacing='0' cellpadding='4' >\n";
  echo "<input type='hidden' name='referer' value='".$_SERVER[HTTP_REFERER]."'>\n";
  echo "<input type='hidden' name='foro' value='$foro'>\n";
  echo "<input type='hidden' name='id_foro' value='$id_foro'>\n";

  echo "<tr><td  align='center'>\n";
  echo "<table border='0' class='bg_color_0' cellpadding='2' cellspacing='0'>\n";
  echo "<tr><td class='t'><b>".$trad[autor]."</b></td><td>\n";
  echo "<input type='text' name='autor' size='40' maxlength='40' value=''>\n";
  echo "&nbsp;&nbsp;&nbsp;</td></tr>\n";
  echo "<tr><td class='t'><b>e-mail </b></td><td>\n";
  echo "<input type='text' name='mail' size='40' maxlength='40' value=''>\n";
  echo "&nbsp;&nbsp;&nbsp;</td></tr>\n";
  echo "<tr><td class='t'><b>".$trad[asunto]."</b></td><td>\n";
  echo "<input type='text' name='titulo' size='40' maxlength='50'  value=''>\n";
  echo "&nbsp;&nbsp;&nbsp;</td></tr>\n";
  echo "<tr><td colspan='2' valign='top' class='t' ><b>".$trad[comentario]."</b><br><font face='xx'>\n";
  echo "<textarea name='texto' cols='48' rows='10' wrap='hard'></textarea>\n";
  echo "</font>&nbsp;&nbsp;&nbsp;</td></tr>\n";
  echo "</table>\n";
  echo "</td></tr>\n";
  echo "<tr>\n";
  echo "<td align='center' ><font size='-1'>\n";
  echo "<input type='submit' name='submitb' value='".$trad[enviar_comentario]."'>\n";
  echo "<input type='reset' value='".$trad[borrar_comentario]."'>\n";
  echo "<br><input type='button' name='cancel' value='".$trad[cerrar_ventana]."' onclick='window.close();'>\n";
  echo "</font>\n";
  echo "</td></tr>\n";
  echo "</table>\n";
  echo "</td></tr></table>\n";
  echo "</form>\n";
    $objeto->documento->cerrar_tabla_info(200,100,"left","middle");//($ancho,$alto,$alinear_central_h, $alinear_central_v)
      $objeto->documento->cerrar_tabla_modulo(200,100);
      echo "\n";
      echo "\n";
      echo "\n";
      }//if
      echo $objeto->documento->close_body();

      ?>


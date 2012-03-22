<?php
require_once("gestion.php");
class gestion_mail extends gestionar{
function mail(){
$info.="\n\n\n<table border=0 width=''  cellspacing=2 cellpadding=5 bgcolor='#CCCCCC'>
<tr><td colspan=2 valign='top' align='left' style='background:url(../c_99/images_gestion/mod_05.gif);'>".$this->navega_sup_info."</td></tr>
<tr><td colspan=2 class='bg_color_0'>";
$info.="
<style type='text/css'>\n
<!--\n
.blanca {\n
font-family:Verdana,Helvetica,Arial,sans-serif;\n
font-size:9px;\n
color: #FFFFFF;\n
}\n
.negra {\n
font-family:Verdana,Helvetica,Arial,sans-serif;\n
font-size:9px;\n
color: #000000;\n
}\n
-->\n
</style>\n";
$info_select.="<b class='negra'>Enviar a:</b> <br>\n<select name='destino' class='forms'>\n";
$info_select.="<option  value=''>Todas las entidades</option>\n";
if(!$this->id_registro_00==17){
 $info_select.="<option  value='coordinadora'>Coordinadora</option>\n";
 $entidad_nombre="Coordinadora de la lengua";
 $entidad_mail="mail@coordinadora";
 }else{
 $this->conecto_datos->Host="llda252.servidoresdns.net";
 $this->conecto_datos->User="qaa121";
 $this->conecto_datos->Password="coordinadora";
 $this->conecto_datos->Database="qaa121";
 $this->conecto_datos->query("select id_registro_00, mail, entidad from entidad where id_registro_00=".$this->id_registro_00);
$this->conecto_datos->next_record();
$entidad_nombre=$this->conecto_datos->Record[entidad];
$entidad_mail=$this->conecto_datos->Record[mail];
 }//if
$this->conecto_datos->query("select id_registro_00, entidad from entidad order by entidad");
while($this->conecto_datos->next_record()){
if($_POST[destino]==$this->conecto_datos->Record[id_registro_00]) $sel="selected"; else $sel="";
$info_select.="<option  value='".$this->conecto_datos->Record[id_registro_00]."' $sel>".$this->conecto_datos->Record[entidad]."</option>\n";
}
$info_select.="</select>\n<br><br>";


$info.="<form action='mail.php' method='POST'>";
if($_POST["previsualizar"]=="" && $_POST["enviar"]==""){        

$info.="$info_select <b class='negra'>Asunto del Mail:</b>(No utilizar &ntilde; o caract&eacute;res acentuados en el asunto)<br> 
            <input type='text' name='asunto' value='' size=60><br><br>
            <b class='negra'>Contenido:</b><br>
            <textarea name='contenido' cols=60 rows=8 class='forms'></textarea><br>
            <input type='submit' name='previsualizar' value='previsualizar'>
              </form>";
}elseif($_POST["enviar"]=="" && $_POST["previsualizar"]<>""){
$contenido=$this->a_html($_POST["contenido"]);
$contenido=ereg_replace("[\n]","<br>",$contenido);
$info.="$info_select <b class='negra'>".$_POST["asunto"]."</b><br> 
            <input type='hidden' name='asunto' value='".$_POST["asunto"]."' size=60><br>
            ".$contenido."<br>
           <input type='hidden' name='contenido' value='".$contenido."' size=60><br>
            <input type='submit' name='enviar' value='enviar'>
            </form>
            ";

}elseif($_POST["enviar"]<>""){
$asunto= $this->a_html($_POST["asunto"]);
#$asunto=ereg_replace("[\n]","<br>",$asunto);
$contenido1= $this->a_html($_POST["contenido"]);

$contenido1 =ereg_replace("&lt;br&gt;","<br>", $contenido1);

$this->conecto_datos->query("insert into mail_00 values(null, '$asunto', '$contenido1', null)");
$this->conecto_datos->query("select id_mail_00 from mail_00 order by id_mail_00 desc limit 1");
$this->conecto_datos->next_record();
$id_mail_00=$this->conecto_datos->Record["id_mail_00"];

$mensaje="
<!-- \n\n\n
Si no visualiza correctamente el mensaje, por favor haga click  en el link siguiente:\n http://www.bcn-llengua.org/mail/index.php?id_mail_00=$id_mail_00
\n\n -->\n<HTML>\n
<HEAD>\n
<TITLE>bisula.net</TITLE>\n
<META HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=iso-8859-1'>\n
<style type='text/css'>\n
<!--\n
.blanca {\n
font-family:Verdana,Helvetica,Arial,sans-serif;\n
font-size:9px;\n
color: #FFFFFF;\n
}\n
.negra {\n
font-family:Verdana,Helvetica,Arial,sans-serif;\n
font-size:9px;\n
color: #000000;\n
}\n
-->\n
</style>\n
</HEAD>\n
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>\n
<TABLE WIDTH=528 BORDER=0 CELLPADDING=0 CELLSPACING=0>\n
<TR><TD><IMG SRC='http://www.bisual.net/00_gestion/10_mail/images/logo.gif' WIDTH=528 HEIGHT=100 ALT=''></TD></TR>\n
<tr><td align='left'><span class='negra'><b>$asunto</b><br><br>$contenido1\n</span></td></tr></table>\n
</body>
</html>
";
 $mailtom= $entidad_mail;
$from_to="$entidad_nombre <$entidad_mail>";
$reply_to=$entidad_mail;
$titulo=$_POST["asunto"];
#mail($mailtom, $titulo, $mensaje, "From:$from_to\nReply-To:$reply_to\nContent-Type:text/html; charset=iso-8859-15\nX-Mailer: PHP/".phpversion());

if(!$_POST[destino]){
$this->conecto_datos->query("select mail from entidad");
while($this->conecto_datos->next_record()){
$mail_base=$this->conecto_datos->Record["mail"];
if(strstr($mail_base, "@")){
$mail_base=strtolower($mail_base);
$array_to[]=trim($mail_base);
}//if
}//while
}elseif($_POST[destino]<>"coordinadora"){
$this->conecto_datos->query("select mail from entidad where id_registro_00=".$_POST[destino]);
$this->conecto_datos->next_record();
$mail_base=$this->conecto_datos->Record["mail"];
if(strstr($mail_base, "@")){
$mail_base=strtolower($mail_base);
$array_to[]=trim($mail_base);
}
}else{
$array_to[]=$entidad_mail;
}
$this->socketmail($array_to, $titulo, $mensaje, $from_to, $reply_to);
$info.="<b>Mensaje correctamente enviado</b><br><a href='index.php'>inicio</a>";
}
$info.="</form>";
$info.="\n</td></tr></table>";
return $this->documento_gestion->modulo($info);

}//function mail

function socketmail($toArray, $subject, $message, $from_to, $reply_to) { 
echo implode(", ", $toArray);
/*
// $toArray format --> array("Name1" => "address1", "Name2" => "address2", ...) 
  
ini_set(sendmail_from, "info@meetingsevilla.org");
$connect = fsockopen (ini_get("SMTP"), ini_get("smtp_port"), $errno, $errstr, 30) or die("Could not talk to the sendmail server!");  
$rcv = fgets($connect, 1024);  
  
fputs($connect, "HELO {$_SERVER['SERVER_NAME']}\r\n"); 
$rcv = fgets($connect, 1024);  
  
while (list($toKey, $toValue) = each($toArray)) { 
  
fputs($connect, "MAIL FROM:info@meetingsevilla.org\r\n");  
$rcv = fgets($connect, 1024);  
fputs($connect, "RCPT TO:$toValue\r\n");  
$rcv = fgets($connect, 1024);  
fputs($connect, "DATA\r\n");  
$rcv = fgets($connect, 1024);  
  
fputs($connect, "Subject: $subject\r\n");  
fputs($connect, "From: Turismo de la Provincia de Sevilla <info@meetingsevilla.org>\r\n");  
fputs($connect, "To: $toKey¬Ý <$toValue>\r\n");  
fputs($connect, "X-Sender: <info@meetingsevilla.org>\r\n");  
fputs($connect, "Return-Path: <info@meetingsevilla.org>\r\n");  
fputs($connect, "Errors-To: <info@meetingsevilla.org>\r\n");  
fputs($connect, "X-Mailer: PHP\r\n");  
fputs($connect, "X-Priority: 3\r\n");  
fputs($connect, "Content-Type: text/html; charset=iso-8859-15\r\n");  
fputs($connect, "\r\n");  
fputs($connect, stripslashes($message)." \r\n");  
fputs($connect, ".\r\n");  
$rcv = fgets($connect, 1024);  
fputs($connect, "RSET\r\n");  
$rcv = fgets($connect, 1024);  
} 
fputs ($connect, "QUIT\r\n");
    $rcv = fgets ($connect, 1024);
    fclose($connect);
    ini_restore(sendmail_from);
*/
}//funtion

}//class
?>
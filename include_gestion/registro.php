<?php
require_once("global_interface.php");
class registro extends global_interface{
    var $user="";
    var $password="";
function registro(){
session_start();
session_register("user");
session_register("password");
if($_GET["out"]){
$_SESSION["user"]="";
$_SESSION["password"]="";
$_SESSION["refer"]="";
header("location: {$_SERVER["HTTP_REFERER"]}");
exit;
}
    $this->graba_variables_obj_ppal(func_get_args());
if ($_POST["user"]<>"" && $_POST["password"]<>"" && $this->seccion=='c_99'){
    $_SESSION["user"]=$_POST["user"];
    $_SESSION["password"]=$_POST["password"];
    $this->user=$_POST["user"];
    $this->password=$_POST["password"];
}else{
    $this->user=$_SESSION["user"];
    $this->password=$_SESSION["password"];
}//if
if ($_POST["user_1"]<>"" && $_POST["password_1"]<>""){
    $_SESSION["user"]=$_POST["user_1"];
    $_SESSION["password"]=$_POST["password_1"];
    $this->user=$_POST["user_1"];
    $this->password=$_POST["password_1"];
}else{
    $this->user=$_SESSION["user"];
    $this->password=$_SESSION["password"];
}//if
}//function

}//class
?>
<?
class CoreObject {
var $name;

function CoreObject($name){
$this->_constructor($name);
}

function _constructor($name){
$this->name = $name;
}

function show(){
printf("%s::%s\n", $this->get_class(), $this->name);
}

function get_class(){
return get_class($this);
}
}




class Container extends CoreObject{
var $members;
function Container($name){
$this->_constructor($name);
}

function &add(&$ref){
$this->members[] = $ref;
return ($ref);
} 

function show(){
parent::show();
foreach($this->members as $item){
$item->show();
}
}//function
}//class





class Person extends CoreObject{
function Person($name){
$this->_constructor($name);
}
}

class Family extends Container {

var $members;
function Family($name){
$this->_constructor($name);
}
}

echo "<pre>\n";

$family = new Family('my family');
$family->add(new Person('father'));
$family->add(new Person('mother'));
$family->add(new Person('girl'));
$family->add(new Person('boy'));

#$family->show();
$family->members[0]->show();
#print_r($family);
/*
function sumar_3(& $v){
$v=$v+3;
}
$avion=15;
$barco=&$avion;
$avion++;
$barco++;
sumar_3($avion);
echo "valor: ".$avion;
*/




?>
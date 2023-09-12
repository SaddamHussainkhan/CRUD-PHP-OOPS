<?php 
include 'database.php';
$obj=new Database();
//$obj->insert("tab_1",['name'=>'Ali','age'=>'24','city'=>'Jubail']);
//echo"Insert Result is:";
//print_r($obj->getResult());

//$obj->update("tab_1",['name'=>'Hussain','age'=>'27','city'=>'Dammam'],'id="2"');
//echo"Update Result is:";
//print_r($obj->getResult());

//$obj->delete("tab_1",'id="2"');
//echo"Delete Result is:";
//print_r($obj->getResult());

// $obj->select_sql("SELECT * FROM tab_1");
// echo"Select Result is:";
// print_r($obj->getResult());

$obj->select('tab_1','*',null,null,null,null);
echo"Select Result is:";
print_r($obj->getResult());
?>
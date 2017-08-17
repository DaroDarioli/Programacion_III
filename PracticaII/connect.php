<?php


try{

//$db = new PDO('mysql:host=localhost;dbname=students;charset=utf8','root','password');
$db = new PDO('mysql:host=localhost;dbname=empresa;charset=utf8','root','password');

//var_dump($db);
	
	
}
catch(Exception $e)
{
	
	echo $e->getMessage();
	//echo "en error has ocurred";
}


?>
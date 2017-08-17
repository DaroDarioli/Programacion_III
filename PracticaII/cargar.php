<?php

//Conecto con base mysql
include 'connect.php';

$varUser = $_POST["user"];
$varName = $_POST["name"];
$varSurname = $_POST["surname"];

$stmt = $db->prepare("INSERT INTO user_info (Name,Surname,User) VALUES (:User,:Name,:Surname)");

$stmt->bindValue(':User',$varUser);
$stmt->bindValue(':Name',$varName);
$stmt->bindValue(':Surname',$varSurname);
$stmt->execute();

$link_address1 = 'Empresa.php';
echo "<a href='".$link_address1."'>Volver al formulario</a>";

// if($_POST["name"] == "mark" && $_POST["surname"]== "pass")
// {
	// echo "user name and passsword are ok";
// }
// else
// {
	// echo "User name or password is/are incorrect";
// }

//Agrego


?>
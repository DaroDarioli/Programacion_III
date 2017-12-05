<?php

include_once 'bicicleta.php';

$elemento = new bicicleta($_GET['color'],$_GET['tipo'],$_GET['precio'],$_GET['cantidad']);

echo bicicleta::Archivar($elemento);



?>


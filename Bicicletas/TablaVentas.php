<?php

include_once 'bicicleta.php';
include_once 'venta.php';

$color = $_GET['color'];
$tipo = $_GET['tipo'];

venta::ImprimirTabla($color,$tipo);


?>


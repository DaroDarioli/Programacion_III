<?php

include_once 'helado.php';
include_once 'venta.php';

$sabor = $_GET['sabor'];
$tipo = $_GET['tipo'];

venta::ImprimirTabla($sabor,$tipo);


?>


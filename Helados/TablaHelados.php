<?php

include_once 'helado.php';

$sabor = $_GET['sabor'];
$tipo = $_GET['tipo'];

helado::ImprimirTabla($sabor,$tipo);


?>


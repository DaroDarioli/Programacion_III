<?php
 
 include_once 'helado.php';
 include_once 'venta.php';

//_________Tomo la opción
 $opcion = $_GET['opcion'];
 $sabor = $_GET['sabor'];

//________Cargo el encabezado 
venta::ImprimirHTML($opcion,$sabor);



?>

<?php
 
 include_once 'helado.php';

//_________Tomo la opción
 $opcion = $_GET['opcion'];
 $sabor = $_GET['sabor'];

//________Cargo el encabezado 
helado::ImprimirHTML($opcion,$sabor);



?>

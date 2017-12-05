<?php

include_once 'helado.php';


$helado = new helado($_GET['sabor'],$_GET['tipo'],$_GET['precio'],$_GET['cantidad']);

echo helado::Archivar($helado);



?>


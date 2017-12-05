<?php

include_once 'bicicleta.php';
include_once 'venta.php';


venta::AltaVentaConImagen($_POST['color'],$_POST['tipo'],$_POST['cantidad'],$_POST['email']);




?>
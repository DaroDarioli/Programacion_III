<?php

include_once 'helado.php';
include_once 'venta.php';


venta::AltaVentaConImagen($_POST['sabor'],$_POST['tipo'],$_POST['cantidad'],$_POST['email']);




?>
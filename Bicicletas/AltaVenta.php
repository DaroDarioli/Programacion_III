<?php

include_once 'bicicleta.php';
include_once 'venta.php';

venta::AltaVenta($_GET['color'],$_GET['tipo'],$_GET['cantidad'],$_GET['email']);




?>
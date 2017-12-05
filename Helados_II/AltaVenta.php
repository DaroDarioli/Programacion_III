<?php

include_once 'helado.php';
include_once 'venta.php';

venta::AltaVenta($_GET['sabor'],$_GET['tipo'],$_GET['cantidad'],$_GET['email']);




?>
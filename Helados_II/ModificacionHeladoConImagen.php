<?php

include_once 'helado.php';
include_once 'venta.php';


$h = new helado($_POST['sabor'],$_POST['tipo'],$_POST['precio'],$_POST['cantidad']);


if((helado::TraeObjeto($h->_sabor,$h->_tipo)) != null){
    
   venta::ModificarVenta($h);
     
}
else{
    echo "El helado no existe";
}


?>

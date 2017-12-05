<?php

include_once 'bicicleta.php';
include_once 'venta.php';


$h = new bicicleta($_POST['color'],$_POST['tipo'],$_POST['precio'],$_POST['cantidad']);


if((bicicleta::TraeObjeto($h->_color,$h->_tipo)) != null){
    
   venta::ModificarVenta($h);
     
}
else{
    echo "El helado no existe";
}


?>

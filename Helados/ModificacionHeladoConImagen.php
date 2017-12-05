<?php

include_once 'helado.php';


$h = new helado($_POST['sabor'],$_POST['tipo'],$_POST['precio'],$_POST['cantidad']);

$aux = new helado();


if((helado::TraeObjeto($h->_sabor,$h->_tipo)) != null){
    
   
      if(helado::MoverAModificados($h))
      {
        helado:: ModificarLista($h);
        $hora = date("Ymd");        
        $destino = "./ImagenesDeLaVenta/".$h->_sabor.'_'.$hora.'.jpg'; 
        if(move_uploaded_file($_FILES['archivo']['tmp_name'],$destino))
        {
            echo "Se modificó el helado";
        }
    
    }
}
else{
    echo "El helado no existe";
}


?>

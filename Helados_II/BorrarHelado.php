<?php

include_once 'helado.php';

$sabor = $_POST['sabor'];
$tipo = $_POST['tipo'];

if((helado::TraeObjeto($sabor,$tipo)) != null){     
  
      if(helado::MoverABorrados($sabor,$tipo)){
          echo "Se eliminó el elemento";
      }
      else{
          echo "No se pudo eliminar el elemento";
      }
   
}
else{
    echo "El elemento no existe";
}




?>


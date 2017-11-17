<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';
require_once 'producto.php';


class productoApi extends producto
{   
    public function CargarProducto($request,$response,$args){
        
        $mi = new producto();
        $ArrayDeParametros = $request->getParsedBody();                     
        $mi->id = $ArrayDeParametros['id'];
        $mi->nombre = $ArrayDeParametros['nombre'];
        $mi->precio = $ArrayDeParametros['precio'];  
        
       return $mi->Insertar(); 
    }
    
    
    public function TraerProductos($request, $response, $args) {
     
        $productos = producto::TraerTodos();        
        $newResponse = $response->withJson($productos, 200); 
        return $newResponse;
    }

    public function ModificarProducto($request, $response,$args)
    {
        $prod = new producto();        
        $vector  = $request->getParams('nombre','precio');
        
        $prod->id = $args['id'];
        $prod->nombre = $vector['nombre'];
        $prod->precio = $vector['precio'];
            
	   	$resultado =$prod->Modificar();
	  	$responseObj= new stdclass();
	    $responseObj->resultado=$resultado;
        $responseObj->tarea="modificar";
	    return $response->withJson($responseObj, 200);	
    }

    public function BorrarProducto($request, $response, $args) {
        
            $prod = new producto();
            $vid = $args['id'];
            $var = producto::TraerUno($vid);
            //___hasta aca 
            if($var != null){
                   
                $prod= $var[0];  
                
                $cantidadDeBorrados=$prod->BorrarUno(); 
    
                $objDelaRespuesta= new stdclass();
                $objDelaRespuesta->cantidad=$cantidadDeBorrados;
    
                if($cantidadDeBorrados == 1)$objDelaRespuesta->resultado="Se borró un elemento!!!";
                
                elseif($cantidadDeBorrados > 1) $objDelaRespuesta->resultado="Se borró más de un elemento!!!";
                
                elseif($cantidadDeBorrados < 1) $objDelaRespuesta->resultado="No se borró ningún elemento!!!";
                
                $newResponse = $response->withJson($objDelaRespuesta, 200);  
                return $newResponse; 
            }
            else{
    
                return "No existe ningún producto con esa id";
            }
        }




/*
    public function TraerUnAuto($request, $response, $args) {
        $vPatente = $args['patente'];      
        $elAuto = auto::TraerUno($vPatente);
        $newResponse = $response->withJson($elAuto, 200);  
        return $newResponse;
    }

    public function ModificarAuto($request, $response,$args)
    {
        $vAuto = new auto();
        $vPatente = $args['patente'];

        $vector  = $request->getParams('marca','color');
        
        $vAuto->patente = $vPatente;
        $vAuto->marca = $vector['marca'];
        $vAuto->color = $vector['color'];
            

        //____________________//
	   	$resultado =$vAuto->Modificar();
	  	$responseObj= new stdclass();
	    $responseObj->resultado=$resultado;
        $responseObj->tarea="modificar";
	    return $response->withJson($responseObj, 200);	
    }


    public function BorrarProducto($request, $response, $args) {
    
        $vAuto = new auto();
        $vPatente = $args['patente'];
        $var = auto::TraerUno($vPatente);
        
        if($var != null){
               
            $vAuto= $var[0];       
            $borrar = $vAuto->foto;  
            if(copy($borrar,"./Eliminados/".$vAuto->patente.'.jpg'))  unlink($borrar);
            
            $cantidadDeBorrados=$vAuto->BorrarUno(); 

            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->cantidad=$cantidadDeBorrados;

            if($cantidadDeBorrados == 1)$objDelaRespuesta->resultado="Se borró un elemento!!!";
            
            elseif($cantidadDeBorrados > 1) $objDelaRespuesta->resultado="Se borró más de un elemento!!!";
            
            elseif($cantidadDeBorrados < 1) $objDelaRespuesta->resultado="No se borró ningún elemento!!!";
            
            $newResponse = $response->withJson($objDelaRespuesta, 200);  
            return $newResponse; 
        }
        else{

            return "No existe ningún auto con esa patente";
        }
    }*/
}


?>
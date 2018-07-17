<?php

require_once 'AccesoDatos.php';
require_once 'comanda.php';

class comandaApi extends comanda
{ 
    
    public $id_comanda;
    public $id_mesa;
    public $id_mozo;
    public $id_estado_pedido;
    public $fecha_alta;
    public $fecha_estipulada;
    public $fecha_entrega;
    public $total;


    public function CargarComanda($request, $response,$args){
    
        $com = new comanda();
        $vector = $request->getParsedBody();
        
        $vHora = date("Y-m-d h:i:sa");
        
        $com->id_comanda = $vector['id_comanda'];
        $com->id_mesa = $vector['id_mesa'];
        $com->id_mozo = $vector['id_mozo'];
        $com->id_estado_pedido = $vector['id_estado_pedido'];        
        $com->fecha_estipulada = $vector['fecha_estipulada'];
        $com->total = $vector['total'];   
        $com->fecha_alta = $vHora;
        
        if($vector['fecha_entrega'] = ""){
            $emp->fecha_entrega = '0000-00-00';
        }            
        else{
            $emp->fecha_entrega = $vector['fecha_entrega'];
        }       
        return $emp->Insertar();         
    }

    public function TraerComandas($request, $response, $args) {
        
        $Comandas = comanda::TraerTodasLasComandas();        
        $newResponse = $response->withJson($Comandas, 200);  
        return $newResponse;
    }  
    
     public function TraerUnaComanda($request, $response, $args) {   
        
        $objDelaRespuesta = new stdclass();  
        $objDelaRespuesta->itsOK = false;              
       
        $vector = $request->getParsedBody();
        $vId = $vector['id_comanda'];         

        $var = comanda::TraerUna($vId);      
           
        if($var != null){            
             
            $objDelaRespuesta->laComanda = new comanda();
            $objDelaRespuesta->itsOK = true;
            $objDelaRespuesta->laComanda = $var[0]; 
            $objDelaRespuesta->token = AutentificadorJWT::CrearToken($var[0]);            
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);        
        return $newResponse;
    }

    public function ModificarComanda($request, $response,$args)
    {
        $emp = new comanda();
        $vector = $request->getParams('id_comanda','id_mesa','id_mozo','id_estado_pedido','fecha_estipulada','fecha_entrega','total');
       
        $com->id_comanda = $vector['id_comanda'];
        $com->id_mesa = $vector['id_mesa'];
        $com->id_mozo = $vector['id_mozo'];
        $com->fecha_entrega = $vector['fecha_alta'];
        $com->id_estado_pedido = $vector['id_estado_pedido'];        
        $com->fecha_estipulada = $vector['fecha_estipulada'];
        $com->fecha_entrega = $vector['fecha_entrega'];
        $com->total = $vector['total'];   
        
	   	$resultado =$emp->ModificarUna();
	  	$responseObj= new stdclass();
	    $responseObj->resultado=$resultado;
        $responseObj->tarea="modificar";
	    return $response->withJson($responseObj, 200);	
    }


    public function BorrarElemento($request, $response, $args) {
        
            $com = new comanda();
            $vId = $args['id'];
        
            $var = Comanda::TraerUna($vId);
            
            if($var != null){
                   
                $com = $var[0];       
               
                $cantidadDeBorrados= $com->BorrarUna(); 
    
                $objDelaRespuesta= new stdclass();
                $objDelaRespuesta->cantidad=$cantidadDeBorrados;
    
                if($cantidadDeBorrados == 1)$objDelaRespuesta->resultado="Se borró un elemento!!!";
                
                elseif($cantidadDeBorrados > 1) $objDelaRespuesta->resultado="Se borró más de un elemento!!!";
                
                elseif($cantidadDeBorrados < 1) $objDelaRespuesta->resultado="No se borró ningún elemento!!!";
                
                $newResponse = $response->withJson($objDelaRespuesta, 200);  
                return $newResponse; 
            }
            else{                
                return "No existe ninguna comanda con ese código";
            }
        }


}



?>
<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';
require_once 'cliente.php';

class clienteApi extends cliente
{   
    public function CargarElemento($request,$response,$args){
              
        $miCliente = new cliente();
        $ArrayDeParametros = $request->getParsedBody();                     
        $miCliente->id_cliente = $ArrayDeParametros['id_cliente'];
        $miCliente->nombre_completo = $ArrayDeParametros['nombre_completo'];
                
        $var = cliente::TraerUno($miCliente->id_cliente);             
        
        if($var == null){
                    
            $arrayConToken = $request->getHeader('token');        
            $token = $arrayConToken[0];
            $payload=AutentificadorJWT::ObtenerData($token);
            
            return $miMesa->Insertar();
        }
        else{
            return $response->withJson(false, 200);            
        }
    
    }
    
    public function TraerUnElemento($request, $response, $args) {
        
        $vector  = $request->getParams('id_cliente');       
        $vId = $vector['id_cliente'];         
        
        $elElemento = cliente::TraerUno($vId);
        $newResponse = $response->withJson($elElemento, 200);  
        return $newResponse;
    }

    public function ModificarElemento($request, $response,$args)
    {
        $vCliente = new cliente();
        $vId = $args['id_cliente'];

        $vector  = $request->getParams('nombre_completo');
        
        $vCliente->id_cliente = $vId;
        $vCliente->nombre_completo = $vector['nombre_completo'];
                    
	   	$resultado = $vCliente->Modificar();
	  	$responseObj= new stdclass();
	    $responseObj->resultado=$resultado;
        $responseObj->tarea="modificar";
	    return $response->withJson($responseObj, 200);	
    }


    public function BorrarElemento($request, $response, $args) {
    
        $vCliente = new cliente();
        $vId = $args['id_cliente'];
        $var = cliente::TraerUno($vId);
        
        if($var != null){
               
            $vCliente = $var[0];       
            
            $cantidadDeBorrados = $vCliente->BorrarUno(); 

            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->cantidad=$cantidadDeBorrados;

            if($cantidadDeBorrados == 1)$objDelaRespuesta->resultado="Se borró un elemento!!!";
            
            elseif($cantidadDeBorrados > 1) $objDelaRespuesta->resultado="Se borró más de un elemento!!!";
            
            elseif($cantidadDeBorrados < 1) $objDelaRespuesta->resultado="No se borró ningún elemento!!!";
            
            $newResponse = $response->withJson($objDelaRespuesta, 200);  
            return $newResponse; 
        }
        else{

            return "No existe ningún elemento con ese código";
        }
    }


    // public function RetirarAuto($request, $response, $args) {
                  
    //         $vector  = $request->getParams('patente');                   
    //         $vPatente = $vector['patente'];
    //         $objDelaRespuesta = new stdclass();
    //         $objDelaRespuesta->itsOk = false;
    //         $newResponse = $response->withJson($objDelaRespuesta, 200);
            
    //         $var = auto::TraerUno($vPatente);             

    //         if($var != null){
                       
                
    //             $vAuto = new auto(); 
    //             $vAuto = $var[0];
                
    //             $vHora = date('H:i:s');
    //             $ingresoStr = explode(":",$vAuto->hora);
    //             $salidaStr = explode(":",$vHora);
                
    //             $ingreso = (int)$ingresoStr[0];
    //             $egreso = (int)$salidaStr[0];

    //             if((int)$ingresoStr[1] < (int)$salidaStr[1]){ $egreso +=1;}

    //             $objDelaRespuesta->auto = $vAuto;
    //             $objDelaRespuesta->costo = ($egreso - $ingreso)*10;

    //           //  if(($vAuto->BorrarUno()) > 0){
    //                 $objDelaRespuesta->itsOk = true;
    //            // }; 
           
    //         $newResponse = $response->withJson($objDelaRespuesta, 200);  
    //      //   return $newResponse; 
    //         }            
    //         return $newResponse; 
            
    //     }

}


?>
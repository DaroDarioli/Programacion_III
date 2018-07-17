<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';
require_once 'mesa.php';

class mesaApi extends mesa
{   
    public function CargarMesa($request,$response,$args){
              

        $miMesa = new mesa();
        $ArrayDeParametros = $request->getParsedBody();                     
        $miMesa->id_mesa = $ArrayDeParametros['id_mesa'];
        $miMesa->id_sector = $ArrayDeParametros['id_sector'];
        $miMesa->id_estado_mesa = $ArrayDeParametros['id_estado_mesa']; 
        
        $var = mesa::TraerUno($miMesa->id_mesa);             
        
        if($var == null){
        
        //_____________Tomo mail___________________________________//
        $arrayConToken = $request->getHeader('token');        
        $token = $arrayConToken[0];
        $payload=AutentificadorJWT::ObtenerData($token);
        //$miAuto->mailEmp = $payload->mail; 

        //$miAuto->mailEmp = $args['mail']; 
       
        //_____________Cargo Foto___________________________________//

      /*  $destino= './Fotos/';
        $archivos = $request->getUploadedFiles();
        $nombreAnterior=$archivos['foto']->getClientFilename();
        $nombre = $miAuto->marca.$miAuto->patente;
        $extension = explode(".",$nombreAnterior);
        $extension = array_reverse($extension);
        $archivos['foto']->moveTo($destino.$nombre.".".$extension[0]);
        $camino = $destino.$nombre.".".$extension[0]; */

        //________Cargo Auto________________________________________//        
                
       // $miAuto->foto = $camino;
       // $miAuto->foto = 'falta';
        return $miMesa->Insertar();
        }
        else{
            return $response->withJson(false, 200);            
        } 
    }
    
    public function TraerUnElemento($request, $response, $args) {
        
        $vector  = $request->getParams('id_mesa');       
        $vId = $vector['id_mesa'];         
        
        $laMesa = mesa::TraerUno($vId);
        $newResponse = $response->withJson($laMesa, 200);  
        return $newResponse;
    }

    public function ModificarElemento($request, $response,$args)
    {
        $vMesa = new mesa();
        $vId = $args['id_mesa'];

        $vector  = $request->getParams('id_sector','id_estado_mesa');
        
        $$vMesa->id_mesa = $vId;
        $$vMesa->id_sector = $vector['id_sector'];
        $$vMesa->id_estado_mesa = $vector['id_estado_mesa'];
            

        //____________________//
	   	$resultado =$vMesa->Modificar();
	  	$responseObj= new stdclass();
	    $responseObj->resultado=$resultado;
        $responseObj->tarea="modificar";
	    return $response->withJson($responseObj, 200);	
    }


    public function BorrarElemento($request, $response, $args) {
    
        $vMesa = new mesa();
        $vId = $args['id_mesa'];
        $var = mesa::TraerUno($vId);
        
        if($var != null){
               
            $vMesa = $var[0];       
            // $borrar = $vAuto->foto;  
            // if(copy($borrar,"./Eliminados/".$vAuto->patente.'.jpg'))  unlink($borrar);
            
            $cantidadDeBorrados=$vMesa->BorrarUno(); 

            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->cantidad=$cantidadDeBorrados;

            if($cantidadDeBorrados == 1)$objDelaRespuesta->resultado="Se borró un elemento!!!";
            
            elseif($cantidadDeBorrados > 1) $objDelaRespuesta->resultado="Se borró más de un elemento!!!";
            
            elseif($cantidadDeBorrados < 1) $objDelaRespuesta->resultado="No se borró ningún elemento!!!";
            
            $newResponse = $response->withJson($objDelaRespuesta, 200);  
            return $newResponse; 
        }
        else{

            return "No existe ninguna mesa con ese código";
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
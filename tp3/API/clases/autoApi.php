<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';
require_once 'auto.php';

class autoApi extends auto
{   
    public function CargarAuto($request,$response,$args){
        
        $miAuto = new auto();
        $ArrayDeParametros = $request->getParsedBody();                     
        $miAuto->patente = $ArrayDeParametros['patente'];
        $miAuto->marca = $ArrayDeParametros['marca'];
        $miAuto->color = $ArrayDeParametros['color'];  
        
        //_____________Tomo mail___________________________________//
        $arrayConToken = $request->getHeader('token');        
        $token = $arrayConToken[0];
        $payload=AutentificadorJWT::ObtenerData($token);
        $miAuto->mailEmp = $payload->mail; 

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
        $miAuto->foto = 'falta';
        return $miAuto->Insertar(); 
    }
    
    public function TraerAutos($request, $response, $args) {
       auto::ImprimirListado();
       /* $Autos=auto::TraerTodos();        
        $newResponse = $response->withJson($Autos, 200); 
        return $newResponse;*/
    }

    public function TraerUnAuto($request, $response, $args) {
        
        $vector  = $request->getParams('patente');       
        $vPatente = $vector['patente'];         
        
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


    public function BorrarAuto($request, $response, $args) {
    
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
    }

}


?>
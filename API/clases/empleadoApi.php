<?php

require_once 'AccesoDatos.php';
require_once 'empleado.php';
require_once 'AutentificadorJWT.php';

class empleadoApi extends empleado
{ 
    public function TraerEmpleados($request, $response, $args) {
        
        $Empleados = empleado::TraerTodoLosEmpleados();        
        $newResponse = $response->withJson($Empleados, 200);  
        return $newResponse;
    }  
    
    public static function ValidarEmpleado($request, $response, $args)
    {
        $vector = $request->getParsedBody();
        $vMail = $vector['email'];
        $vClave = $vector['clave']; 

        $var = empleado::TraerUno($vMail,$vClave);
      //  var_dump($var[0]);
      
        if($var[0] != null){
            
            $token= AutentificadorJWT::CrearToken($var[0]); 
            $newResponse = $response->withJson($token, 200); 
            return $newResponse;
        }
        else{

            return "No se puede crar token a empleado inexistente";
        }

           
    }


    public function TraerUnEmpleado($request, $response, $args) {   
        
        $vector = $request->getParsedBody();
        $vMail = $vector['email'];
        $vClave = $vector['clave'];
       // var_dump($vector);

        $resp->itsOk = false;
        $resp->emp = new empleado();

        $var = empleado::TraerUno($vMail,$vClave);      
       
        if($var != null){
              
            $resp->emp = $var[0]; 
            $resp->itsOk = true;
            $newResponse = $response->withJson($resp, 200);
            
        }
        else{

            $newResponse = $response->withJson($resp->itsOk, 200);
        }
        return $newResponse;
    }


    public function CargarEmpleado($request, $response,$args){
    
        $emp = new empleado();
        $vector = $request->getParsedBody();
        $emp->id = $vector['id'];
        $emp->nombre = $vector['nombre'];
        $emp->apellido = $vector['apellido'];
        $emp->legajo = $vector['legajo'];
        $emp->clave = $vector['clave'];
        $emp->email = $vector['email'];
        $emp->perfil = $vector['perfil'];

        //_________________Foto

        $destino= './Fotos/';
        $archivos = $request->getUploadedFiles();
        $nombreAnterior=$archivos['foto']->getClientFilename();
        $nombre = $emp->nombre;
        $extension = explode(".",$nombreAnterior);
        $extension = array_reverse($extension);
        $archivos['foto']->moveTo($destino.$nombre.".".$extension[0]);
        $camino = $destino.$nombre.".".$extension[0];

        //______________________________________________//        
                
        $emp->foto = $camino;
        return $emp->Insertar();         

    }


    /*
    public function ModificarEmpleado($request, $response,$args)
    {
        $emp = new empleado();
        $vector  = $request->getParams('mail','clave','perfil','turno');
        
        $emp->id = $vector['id']; 
        $emp->clave = $vector['clave'];
        $emp->mail = $vector['mail'];
        $emp->turno = $vector['turno'];
        $emp->perfil = $vector['perfil'];      

        //____________________//
	   	$resultado =$emp->ModificarUno();
	  	$responseObj= new stdclass();
	    $responseObj->resultado=$resultado;
        $responseObj->tarea="modificar";
	    return $response->withJson($responseObj, 200);	
    }

    public function BorrarEmpleado($request, $response, $args) {
        
            $emp = new empleado();
            $vMail = $args['mail'];

        
            $var = empleado::TraerUno($vMail);
            
            if($var != null){
                   
                $emp = $var[0];       
               
                $cantidadDeBorrados= $emp->BorrarUno(); 
    
                $objDelaRespuesta= new stdclass();
                $objDelaRespuesta->cantidad=$cantidadDeBorrados;
    
                if($cantidadDeBorrados == 1)$objDelaRespuesta->resultado="Se borró un elemento!!!";
                
                elseif($cantidadDeBorrados > 1) $objDelaRespuesta->resultado="Se borró más de un elemento!!!";
                
                elseif($cantidadDeBorrados < 1) $objDelaRespuesta->resultado="No se borró ningún elemento!!!";
                
                $newResponse = $response->withJson($objDelaRespuesta, 200);  
                return $newResponse; 
            }
            else{
                
                return "No existe ningún empleado con ese mail";
            }
        }*/


}



?>
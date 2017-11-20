<?php

require_once 'AccesoDatos.php';
require_once 'empleado.php';

class empleadoApi extends empleado
{ 
    public function TraerEmpleados($request, $response, $args) {
        
        $Empleados = empleado::TraerTodoLosEmpleados();        
        $newResponse = $response->withJson($Empleados, 200);  
        return $newResponse;
    }  
    
    
    public function TraerUnEmpleado($request, $response, $args) {   
        
        $objDelaRespuesta = new stdclass();  
        $objDelaRespuesta->itsOK = false;              
       
        $vector = $request->getParsedBody();
        $vMail = $vector['mail'];  
        $vClave = $vector['clave']; 

        $var = empleado::TraerUno($vMail,$vClave);      
       
        if($var != null){            
             
            $objDelaRespuesta->elEmpleado = new empleado();
            $objDelaRespuesta->itsOK = true;
            $objDelaRespuesta->elEmpleado = $var[0]; 
        
           // $token= AutentificadorJWT::CrearToken($var[0]); 
            $objDelaRespuesta->token = AutentificadorJWT::CrearToken($var[0]);
            
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);
        
        return $newResponse;
    }


    public function CargarEmpleado($request, $response,$args){
    
        $emp = new empleado();
        $vector = $request->getParsedBody();
        $emp->nombre = $vector['nombre'];
        $emp->clave = $vector['clave'];
        $emp->mail = $vector['mail'];
        $emp->turno = $vector['turno'];
        $emp->perfil = $vector['perfil'];
        $emp->Insertar();         

    }

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
        }


}



?>
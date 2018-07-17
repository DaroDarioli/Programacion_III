<?php

require_once 'AccesoDatos.php';
require_once 'empleado.php';

class empleadoApi extends empleado
{ 
    
    public function CargarEmpleado($request, $response,$args){
    
        $emp = new empleado();
        $vector = $request->getParsedBody();
        $emp->id_empleado = $vector['id_empleado'];
        $emp->nombre_completo = $vector['nombre_completo'];
        $emp->id_rol = $vector['id_rol'];
        $emp->fecha_ingreso = $vector['fecha_ingreso'];
        $emp->sueldo = $vector['sueldo'];
        $emp->clave = $vector['clave'];   
        
        if($vector['fecha_egreso'] = ""){
            $emp->fecha_egreso = '0000-00-00';
        }            
        else{
            $emp->fecha_egreso = $vector['fecha_egreso'];
        }       
        return $emp->Insertar();         
    }

    public function TraerEmpleados($request, $response, $args) {
        
        $Empleados = empleado::TraerTodoLosEmpleados();        
        $newResponse = $response->withJson($Empleados, 200);  
        return $newResponse;
    }  
    
     public function TraerUnEmpleado($request, $response, $args) {   
        
        $objDelaRespuesta = new stdclass();  
        $objDelaRespuesta->itsOK = false;              
       
        $vector = $request->getParsedBody();
        $vId = $vector['id_empleado'];  
        $vClave = $vector['clave']; 

        $var = empleado::TraerUno($vId,$vClave);      
           
        if($var != null){            
             
            $objDelaRespuesta->elEmpleado = new empleado();
            $objDelaRespuesta->itsOK = true;
            $objDelaRespuesta->elEmpleado = $var[0]; 
            $objDelaRespuesta->token = AutentificadorJWT::CrearToken($var[0]);            
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);        
        return $newResponse;
    }

    public function ModificarEmpleado($request, $response,$args)
    {
        $emp = new empleado();
        $vector = $request->getParams('id_empleado','nombre_completo','id_rol','fecha_ingreso','fecha_egreso','clave','sueldo');
       

        $emp->id_empleado = $vector['id_empleado'];
        $emp->nombre_completo = $vector['nombre_completo'];
        $emp->id_rol = $vector['id_rol'];
        $emp->fecha_ingreso = $vector['fecha_ingreso'];
        $emp->fecha_egreso = $vector['fecha_egreso'];
        $emp->sueldo = $vector['sueldo'];
        $emp->clave = $vector['clave'];

      //  return var_dump($emp);

        //____________________//
	   	$resultado =$emp->ModificarUno();
	  	$responseObj= new stdclass();
	    $responseObj->resultado=$resultado;
        $responseObj->tarea="modificar";
	    return $response->withJson($responseObj, 200);	
    }


    public function BorrarEmpleado($request, $response, $args) {
        
            $emp = new empleado();
            $vId = $args['id'];
        

         //   return var_dump($vId);
            $var = empleado::TraerUnoId($vId);
            
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
                return "No existe ningún empleado con ese id";
            }
        }


}



?>
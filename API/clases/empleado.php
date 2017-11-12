<?php

require_once 'AccesoDatos.php';

class empleado
{
    public $_id;
    public $_nombre;
    public $_clave;
    public $_mail;
    public $_turno;
    public $_perfil;
        
    //_______________________Slim

    public function TraerUno($request, $response, $args) {   
        
        $vector = $request->getParsedBody();
        $vMail = $vector['mail'];
        var_dump($vMail);
     
        $elEmpleado = empleado::TraerUnEmpleado($vMail);
        $newResponse = $response->withJson($elEmpleado, 200);
       return $newResponse;
    }


    public function TraerTodos($request, $response, $args) {

        $Empleados = empleado::TraerTodoLosEmpleados();        
        $newResponse = $response->withJson($Empleados, 200);  
        return $newResponse;
    }

    public function cargarEmpleado($request, $response,$args){
    
        $emp = new empleado();
        $vector = $request->getParsedBody();
        $emp->_nombre = $vector['nombre'];
        $emp->_clave = $vector['clave'];
        $emp->_mail = $vector['mail'];
        $emp->_turno = $vector['turno'];
        $emp->_perfil = $vector['perfil'];
        $emp->InsertarElUsuario();         

    }

    public function modificarEmpleado($request, $response,$args)
    {
        $emp = new empleado();
        $vector  = $request->getParams('mail','clave','perfil','turno');
        
        $emp->_id = $vector['id']; 
        $emp->_clave = $vector['clave'];
        $emp->_mail = $vector['mail'];
        $emp->_turno = $vector['turno'];
        $emp->_perfil = $vector['perfil'];      

        //____________________//
	   	$resultado =$emp->ModificarElEmpleado();
	  	$responseObj= new stdclass();
	    $responseObj->resultado=$resultado;
        $responseObj->tarea="modificar";
	    return $response->withJson($responseObj, 200);	
    }

    //_______________________Fin Slim

    public function InsertarElUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into empleados (nombre,clave,mail,turno,perfil)values(:nombre,:clave,:mail,:turno,:perfil)");
        $consulta->bindValue(':nombre', $this->_nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->_clave, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $this->_mail, PDO::PARAM_STR);
        $consulta->bindValue(':turno', $this->_turno, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->_perfil, PDO::PARAM_STR);
        
        $consulta->execute();		
        //  return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }


    public static function TraerUnEmpleado($vMail){
    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT `id`, `nombre` FROM `empleados` WHERE  `mail` = '$vMail'");
        $consulta->execute();      
        $eBuscado = $consulta->fetchObject('empleado');
        return $eBuscado; 

    }
    public static function TraerTodoLosEmpleados()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT `id`, `nombre` FROM `empleados`");
        $consulta->execute();	
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        return $consulta->fetchAll();
    }

    public function ModificarElEmpleado()
    {
           $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
           $consulta =$objetoAccesoDato->RetornarConsulta("
               update empleados
               set clave ='$this->_clave',
               mail ='$this->_mail',
               turno ='$this->_turno',
               perfil ='$this->_perfil'
               WHERE id='$this->_id'");
           return $consulta->execute();

    }
}



?>
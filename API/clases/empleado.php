<?php

require_once 'AccesoDatos.php';

class empleado
{
    public $id_empleado;
    public $nombre_completo;
    public $id_rol;
    public $fecha_ingreso;
    public $fecha_egreso;
    public $sueldo;
    public $clave;

        public function __construct() {}  

        public function Insertar()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into empleados 
                  (id_empleado, nombre_completo,id_rol,fecha_ingreso,fecha_egreso,sueldo,clave)
            values(:id_empleado,:nombre_completo,:id_rol,:fecha_ingreso,:fecha_egreso,:sueldo,:clave)");


            $consulta->bindValue(':id_empleado', $this->id_empleado, PDO::PARAM_STR);
            $consulta->bindValue(':nombre_completo', $this->nombre_completo, PDO::PARAM_STR);
            $consulta->bindValue(':id_rol', $this->id_rol, PDO::PARAM_STR);
            $consulta->bindValue(':fecha_ingreso', $this->fecha_ingreso, PDO::PARAM_STR);
            $consulta->bindValue(':fecha_egreso', $this->fecha_egreso, PDO::PARAM_STR);
            $consulta->bindValue(':sueldo', $this->sueldo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            
            $consulta->execute();		
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }

        
        public static function TraerTodoLosEmpleados()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT `id_empleado`, `nombre_completo`, 'id_rol','fecha_ingreso' FROM `empleados`");
            $consulta->execute();	
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            return $consulta->fetchAll();
        }


        public static function TraerUno($vId,$vClave){
        
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `empleados` WHERE  `id_empleado` = '$vId' AND `clave`='$vClave'");
            $consulta->execute();      
            $consulta->setFetchMode(PDO::FETCH_CLASS,"empleado"); 
            return $consulta->fetchAll();

        }

        public static function TraerUnoId($vId){
      
           // return var_dump($vId);

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `empleados` WHERE  `id_empleado` = '$vId'");
            $consulta->execute();      
            $consulta->setFetchMode(PDO::FETCH_CLASS,"empleado"); 
            return $consulta->fetchAll();

        }
   

        public function ModificarUno()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
                update empleados
                set                 
                nombre_completo ='$this->nombre_completo',
                id_rol ='$this->id_rol',
                fecha_ingreso ='$this->fecha_ingreso',
                fecha_egreso ='$this->fecha_egreso',
                sueldo ='$this->sueldo',                
                clave ='$this->clave'
                WHERE id_empleado = '$this->id_empleado'");
           return $consulta->execute();

        }

        public function BorrarUno()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
            delete 
            from empleados 				
            WHERE id_empleado =:id_empleado");	
            $consulta->bindValue(':id_empleado',$this->id_empleado, PDO::PARAM_INT);		
            $consulta->execute();
            return $consulta->rowCount();
        }
}



?>
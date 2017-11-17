<?php

require_once 'AccesoDatos.php';

class empleado
{
    public $id;
    public $nombre;
    public $apellido;
    public $clave;
    public $email;
    public $perfil;
    public $foto;

        public function __construct() {}
  

        public function Insertar()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into empleados (id,nombre,apellido,clave,email,legajo,foto,perfil)values(:id,:nombre,:apellido,:clave,:email,:legajo,:foto,:perfil)");
            $consulta->bindValue(':id', $this->id, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
            $consulta->bindValue(':legajo', $this->legajo, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
            
            $consulta->execute();		
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }


        public static function TraerUno($vMail,$vClave){
        
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `empleados` WHERE  `email` = '$vMail' AND `clave`='$vClave' ");
            $consulta->execute();      
            $consulta->setFetchMode(PDO::FETCH_CLASS,"empleado"); 
            return $consulta->fetchAll();

        }

        public static function TraerTodoLosEmpleados()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `empleados`");
            $consulta->execute();	
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            return $consulta->fetchAll();
        }

        public function ModificarUno()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
                update empleados
                set clave ='$this->clave',
                mail ='$this->mail',
                turno ='$this->turno',
                perfil ='$this->perfil'
                WHERE id='$this->id'");
            return $consulta->execute();

        }

        public function BorrarUno()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
            delete 
            from empleados 				
            WHERE mail =:mail");	
            $consulta->bindValue(':mail',$this->mail, PDO::PARAM_INT);		
            $consulta->execute();
            return $consulta->rowCount();
        }
}



?>
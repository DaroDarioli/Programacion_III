<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';

class producto
{
    public $id;
    public $nombre;
    public $precio;
    
    public function __construct() {}

        public function Insertar()
        {
            $vHora = date('H:i:s');
            
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into productos (id,nombre,precio) values (:id,:nombre,:precio)");
            $consulta->bindValue(':id', $this->id, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
            
            $consulta->execute();		
            
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }

        public static function TraerTodos()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `productos`");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"producto");
        }

        public static function TraerUno($vid)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `productos` WHERE  `id` = '$vid'");
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_CLASS,"producto"); 
            return $consulta->fetchAll();
                   
        }

        public function Modificar()
        {
               $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
               $consulta =$objetoAccesoDato->RetornarConsulta("
                   update productos
                   set nombre ='$this->nombre',
                   precio ='$this->precio'
                   WHERE id ='$this->id'");
               return $consulta->execute();
    
        }

        public function BorrarUno()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
            delete 
            from productos				
            WHERE id=:id");	
            $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
            $consulta->execute();
            return $consulta->rowCount();
        }

   
}


?>
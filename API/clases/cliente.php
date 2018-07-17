<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';

class cliente
{
    public $id_cliente;
    public $nombre_completo;
    
    public function __construct() {}

        public function Insertar()
        {                      
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into clientes(id_cliente, nombre_completo)values(:id_cliente,:nombre_completo)");
            $consulta->bindValue(':id_cliente', $this->id_cliente, PDO::PARAM_STR);
            $consulta->bindValue(':nombre_completo', $this->nombre_completo, PDO::PARAM_STR);
            $consulta->execute();		

            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }

        public static function TraerTodos()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `clientes`");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"cliente");
        }

        public static function TraerUno($vIdCliente)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `clientes` WHERE  `id_cliente` = '$vIdCliente'");
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_CLASS,"cliente"); 
            return $consulta->fetchAll();
                   
        }

        public function Modificar()
        {

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
                update clientes
                nombre_completo ='$this->nombre_completo'
                WHERE id_cliente ='$this->id_cliente'");
            return $consulta->execute();
    
        }

        public function BorrarUno()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
            delete 
            from clientes 				
            WHERE id_cliente =:id_cliente");	
            $consulta->bindValue(':id_cliente',$this->id_cliente, PDO::PARAM_INT);		
            $consulta->execute();
            return $consulta->rowCount();
        }
/*  return $consulta->fetchAll(PDO::FETCH_CLASS,"Empleado");*/
   
    // public static function ImprimirListado()
    // {
    //     $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    //     $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `autos`");
    //     $consulta->execute();      

    // //__________________________________________________

    //     echo '<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge">';
    //     echo '<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"><link rel="stylesheet" href="css/estilos.css">';
    //     echo '<script src="bower_components/jquery/dist/jquery.min.js"></script><script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>';
    //     echo "<table style='border: solid 1px black;'>";
    //     echo "<tr class='success'><th>Indice</th><th>Patente</th><th>Marca</th><th>Color</th><th>Hora</th><th>Empleado</th><th>foto</th></tr>";

    //     foreach(new TableRows(new RecursiveArrayIterator($consulta->fetchAll(PDO::FETCH_CLASS,"auto"))) as $k=>$v) { 
    //         echo $v;
    //     }
    
    //     echo '</body></html>'; 
    // }
}


?>
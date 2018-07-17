<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';

class mesa
{
    public $id_mesa;
    public $id_sector;
    public $id_estado_mesa;

    public function __construct() {}

        public function Insertar()
        {                      
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into mesas (id_mesa,id_sector,id_estado_mesa)values(:id_mesa,:id_sector,:id_estado_mesa)");
            $consulta->bindValue(':id_mesa', $this->id_mesa, PDO::PARAM_STR);
            $consulta->bindValue(':id_sector', $this->id_sector, PDO::PARAM_STR);
            $consulta->bindValue(':id_estado_mesa', $this->id_estado_mesa, PDO::PARAM_STR);
            $consulta->execute();		

            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }

        public static function TraerTodos()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `mesas`");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"mesa");
        }

        public static function TraerUno($vIdMesa)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `mesas` WHERE  `id_mesa` = '$id_mesa'");
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_CLASS,"mesa"); 
            return $consulta->fetchAll();
                   
        }

        public function Modificar()
        {

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
                update mesas
                set id_sector ='$this->id_sector',
                id_estado_mesa ='$this->id_estado_mesa'
                WHERE id_mesa ='$this->id_mesa'");
            return $consulta->execute();
    
        }

        public function BorrarUno()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
            delete 
            from mesas 				
            WHERE id_mesa =:id_mesa");	
            $consulta->bindValue(':id_mesa',$this->id_mesa, PDO::PARAM_INT);		
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
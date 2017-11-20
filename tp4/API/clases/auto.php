<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';

class auto
{
    public $indice;
    public $patente;
    public $marca;
    public $color;
    public $hora;
    public $mailEmp;
    public $foto;  

    public function __construct() {}

        public function Insertar()
        {
            $vHora = date('H:i:s');
            
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into autos (patente,marca,color,hora,mailEmp,foto)values(:patente,:marca,:color,:hora,:mail,:foto)");
            $consulta->bindValue(':patente', $this->patente, PDO::PARAM_STR);
            $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->foto,PDO::PARAM_STR);
            $consulta->bindValue(':mail', $this->mailEmp,PDO::PARAM_STR);
            $consulta->bindValue(':hora', $vHora);
            $consulta->execute();		
            
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }

        public static function TraerTodos()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT `indice`, `patente`, `marca`, `color`, `hora`,`foto` FROM `autos`");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"auto");
        }

        public static function TraerUno($vPatente)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT `indice`, `patente`, `marca`, `color`, `hora`,`foto` FROM `autos` WHERE  `patente` = '$vPatente'");
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_CLASS,"auto"); 
            return $consulta->fetchAll();
                   
        }

        public function Modificar()
        {
               $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
               $consulta =$objetoAccesoDato->RetornarConsulta("
                   update autos
                   set marca ='$this->marca',
                   color ='$this->color',
                   foto ='$this->foto'
                   WHERE patente ='$this->patente'");
               return $consulta->execute();
    
        }

        public function BorrarUno()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
            delete 
            from autos 				
            WHERE patente=:patente");	
            $consulta->bindValue(':patente',$this->patente, PDO::PARAM_INT);		
            $consulta->execute();
            return $consulta->rowCount();
        }
/*  return $consulta->fetchAll(PDO::FETCH_CLASS,"Empleado");*/
   
    public static function ImprimirListado()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `autos`");
        $consulta->execute();      

    //__________________________________________________

        echo '<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge">';
        echo '<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"><link rel="stylesheet" href="css/estilos.css">';
        echo '<script src="bower_components/jquery/dist/jquery.min.js"></script><script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>';
        echo "<table style='border: solid 1px black;'>";
        echo "<tr class='success'><th>Indice</th><th>Patente</th><th>Marca</th><th>Color</th><th>Hora</th><th>Empleado</th><th>foto</th></tr>";

        foreach(new TableRows(new RecursiveArrayIterator($consulta->fetchAll(PDO::FETCH_CLASS,"auto"))) as $k=>$v) { 
            echo $v;
        }
    
        echo '</body></html>'; 
    }
}


?>
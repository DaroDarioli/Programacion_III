<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';

class producto
{
    public $id_producto;
    public $nombre_producto;
    public $descripcion;
    public $id_cocina;
    public $precio;

    public function __construct() {}

        public function Insertar()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into productos(id_producto,nombre_producto,descripcion,id_cocina,precio)                
            values(:id_producto,:nombre_producto,:descripcion,:id_cocina,:precio)");
            $consulta->bindValue(':id_producto', $this->id_producto, PDO::PARAM_STR);
            $consulta->bindValue(':nombre_producto', $this->nombre_producto, PDO::PARAM_STR);
            $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $consulta->bindValue(':id_cocina', $this->id_cocina, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio,PDO::PARAM_STR);
            $consulta->execute();		
            
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }

        public static function TraerUno($vId)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `productos` WHERE  `id_producto` = '$vId'");
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_CLASS,"producto"); 
            return $consulta->fetchAll();                   
        }

        public static function TraerTodos()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `productos`");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"producto");
        }

        public function Modificar()
        {
               $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
               $consulta =$objetoAccesoDato->RetornarConsulta("
                   update productos
                   set nombre_producto ='$this->nombre_producto',
                   descripcion ='$this->descripcion',
                   id_cocina ='$this->id_cocina',
                   precio ='$this->precio'
                   WHERE id_producto ='$this->id_producto'");
               return $consulta->execute();
    
        }
        
        public function BorrarUno()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
            delete 
            from productos 				
            WHERE id_producto =:id_producto");	
            $consulta->bindValue(':patente',$this->patente, PDO::PARAM_INT);		
            $consulta->execute();
            return $consulta->rowCount();
        }


        // public $id_producto;
        // public $nombre_producto;
        // public $descripcion;
        // public $id_cocina;
        // public $precio;
    



// /*  return $consulta->fetchAll(PDO::FETCH_CLASS,"Empleado");*/
   
//     public static function ImprimirListado()
//     {
//         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
//         $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `autos`");
//         $consulta->execute();      

//     //__________________________________________________

//         echo '<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge">';
//         echo '<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"><link rel="stylesheet" href="css/estilos.css">';
//         echo '<script src="bower_components/jquery/dist/jquery.min.js"></script><script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>';
//         echo "<table style='border: solid 1px black;'>";
//         echo "<tr class='success'><th>Indice</th><th>Patente</th><th>Marca</th><th>Color</th><th>Hora</th><th>Empleado</th><th>foto</th></tr>";

//         foreach(new TableRows(new RecursiveArrayIterator($consulta->fetchAll(PDO::FETCH_CLASS,"auto"))) as $k=>$v) { 
//             echo $v;
//         }
    
//         echo '</body></html>'; 
//     }
}


?>
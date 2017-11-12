<?php

require_once 'AccesoDatos.php';
require_once 'TableRows.php';

class auto
{
    public $_patente;

    public $_marca;

    public $_color;

    public function __construct() {}

//________________Especialies Slimframework________________________________________//
    public function CargarAuto($request,$response,$args){
        
        $ArrayDeParametros = $request->getParsedBody();
        $vPatente = $ArrayDeParametros['patente'];
        $vMarca = $ArrayDeParametros['marca'];
        $vColor = $ArrayDeParametros['color'];
         
        $miAuto = new auto();
        $miAuto->_patente = $vPatente;
        $miAuto->_marca = $vMarca;
        $miAuto->_color = $vColor;
 
        $destino= __DIR__ .'/../Fotos/';
        $archivos = $request->getUploadedFiles();
        $nombreAnterior=$archivos['foto']->getClientFilename();
        var_dump($nombreAnterior);
        $nombre = $vMarca.$vPatente;
        $extension = explode(".",$nombreAnterior);
        $extension = array_reverse($extension);

        $archivos['foto']->moveTo($destino.$nombre.".".$extension[0]);
        $camino = $destino.$nombre.".".$extension[0];

        return $response;
    }
    


    public function TraerTodos($request, $response, $args) {
        $Autos=auto::TraerTodoLosAutos();        
        $newResponse = $response->withJson($Autos, 200); 
        return $newResponse;
    }

    public function TraerUno($request, $response, $args) {
        $vPatente = $args['patente'];
        var_dump($vPatente);
     //   $elAuto = auto::TraerUnAuto($vPatente);
       // $newResponse = $response->withJson($elAuto, 200);  
        //return $newResponse;
    }

    public function BorrarUno($request, $response, $args) {
    
        $vPatente = $args['patente'];
        $vAuto= new auto();
        $vAuto->_patente = $vPatente;
        $cantidadDeBorrados=$vAuto->BorrarAuto();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->cantidad=$cantidadDeBorrados;
        if($cantidadDeBorrados == 1)
        {
            $objDelaRespuesta->resultado="Se borró un elemento!!!";
        }
        elseif($cantidadDeBorrados > 1)
        {
            $objDelaRespuesta->resultado="Se borró más de un elemento!!!";
        }
        elseif($cantidadDeBorrados < 1)
        {
            $objDelaRespuesta->resultado="No se borró ningún elemento!!!";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);  
        return $newResponse;
    }


    //_______________Fin especiales Slimframework_____________________________________//


    public function BorrarAuto()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
        delete 
        from autos 				
        WHERE patente=:patente");	
        $consulta->bindValue(':patente',$this->_patente, PDO::PARAM_INT);		
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function InsertarElAutoParametros()
    {
        $vHora = date('H:i:s');
        
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into autos (patente,marca,color,hora)values(:patente,:marca,:color,:hora)");
            $consulta->bindValue(':patente', $this->_patente, PDO::PARAM_STR);
            $consulta->bindValue(':marca', $this->_marca, PDO::PARAM_STR);
            $consulta->bindValue(':color', $this->_color, PDO::PARAM_STR);
            $consulta->bindValue(':hora', $vHora);
            $consulta->execute();		
            //  return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerUnAuto($vPatente)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT `indice`, `patente`, `marca`, `color`, `hora` FROM `autos` WHERE  `patente` = '$vPatente'");
        $consulta->execute();      
        //$autoBuscado = $consulta->fetchObject('auto');  //->crea un auto con null 
        $autoBuscado = $consulta->fetchObject();
        return $autoBuscado;      
        
    }
  
    public static function TraerTodoLosAutos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT `indice`, `patente`, `marca`, `color`, `hora` FROM `autos`");
       
        $consulta->execute();			
        //return $consulta->fetchAll(PDO::FETCH_CLASS, "auto");
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        return $consulta->fetchAll();
    	
     /* 
       $consulta->execute();			
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
    //__________________________________________________

        echo '<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge">';
        echo '<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"><link rel="stylesheet" href="css/estilos.css">';
        echo '<script src="bower_components/jquery/dist/jquery.min.js"></script><script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>';
        echo "<table style='border: solid 1px black;'>";
        echo "<tr class='success'><th>Patente</th><th>Marca</th><th>Color</th><th>Hora</th></tr>";

        foreach(new TableRows(new RecursiveArrayIterator($consulta->fetchAll())) as $k=>$v) { 
            echo $v;
        }
        
        echo '</body></html>'; */
    }
}


?>
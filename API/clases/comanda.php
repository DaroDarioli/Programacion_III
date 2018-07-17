<?php

require_once 'AccesoDatos.php';

class empleado
{
    public $id_comanda;
    public $id_mesa;
    public $id_mozo;
    public $id_estado_pedido;
    public $fecha_alta;
    public $fecha_estipulada;
    public $fecha_entrega;
    public $total;


        public function __construct() {}  

        public function Insertar()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into comandas 
                  (id_comanda,id_mesa,id_mozo,id_estado_pedido,fecha_alta,fecha_estipulada,fecha_entrega,total)
            values(:id_comanda,:id_mesa,:id_mozo,:id_estado_pedido,:fecha_alta,:fecha_estipulada,:fecha_entrega,:total)");

            $consulta->bindValue(':id_comanda', $this->id_comanda, PDO::PARAM_STR);
            $consulta->bindValue(':id_mesa', $this->id_mesa, PDO::PARAM_STR);
            $consulta->bindValue(':id_mozo', $this->id_mozo, PDO::PARAM_STR);
            $consulta->bindValue(':id_estado_pedido', $this->id_estado_pedido, PDO::PARAM_STR);
            $consulta->bindValue(':fecha_alta', $this->fecha_alta, PDO::PARAM_STR);
            $consulta->bindValue(':fecha_estipulada', $this->fecha_estipulada, PDO::PARAM_STR);            
            $consulta->bindValue(':fecha_entrega', $this->fecha_entrega, PDO::PARAM_STR);
            $consulta->bindValue(':total', $this->total, PDO::PARAM_STR);
            
            $consulta->execute();		
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }


        public static function TraerTodasLasComandas()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `comandas`");
            $consulta->execute();	
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            return $consulta->fetchAll();
        }


        public static function TraerUna($vId){
        
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `comandas` WHERE  `id_comanda` = '$vId'");
            $consulta->execute();      
            $consulta->setFetchMode(PDO::FETCH_CLASS,"comanda"); 
            return $consulta->fetchAll();

        }
  
        public function ModificarUna()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
                update comandas
                set                 
                id_mesa ='$this->id_mesa',
                id_mozo ='$this->id_mozo',
                id_estado_pedido ='$this->id_estado_pedido',
                fecha_alta ='$this->fecha_alta',
                fecha_estipulada ='$this->fecha_estipulada',                
                fecha_entrega ='$this->fecha_entrega',
                total = '$this->total'
                WHERE id_comanda = '$this->id_comanda'");
           return $consulta->execute();

        }

        public function BorrarUna()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
            delete 
            from comandas 				
            WHERE id_comanda =:id_comanda");	
            $consulta->bindValue(':id_comanda',$this->id_comanda, PDO::PARAM_INT);		
            $consulta->execute();
            return $consulta->rowCount();
        }
}



?>
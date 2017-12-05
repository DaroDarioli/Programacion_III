<?php


class bicicleta{

    public $_color;
    public $_tipo;
    public $_precio;
    public $_cantidad;

    function __construct($color = null, $tipo = null,$precio = null,$cantidad = null)
    {
        $this->_color= $color;
        $this->_precio= $precio;
        $this->_tipo = $tipo;
        $this->_cantidad = $cantidad;

    }

    public function ToString()
    {
        return $this->_color.'-'.$this->_tipo.'-'.$this->_precio.'-'.$this->_cantidad."\r\n";    
    }

    
    public static function Archivar($elemento)
    {   
        $ret = 0;

        $archivo = fopen('bicicletas.txt',"a");
        if((fwrite($archivo,$elemento->ToString())) != false){
            $ret = 1;
        }         
        fclose($archivo);
        return $ret;
    }

    public static function TraeObjeto($color,$tipo)
    {
        $lista = self::TraerLista();       

            foreach($lista as  $l)
            {      
                if($l->_color == $color && $l->_tipo == $tipo)
                {
                    return $l;
                }       
            }
        return null;
    }
    
    public static function TraerLista()
    {
        $archivo = fopen('bicicletas.txt',"r");     
        $lista = array();

        while(!feof($archivo)){
            
            $aux = fgets($archivo);
            $cadena = explode("-",$aux);

            $cadena[0] = trim($cadena[0]);
            if($cadena[0] != ""){
                            
                array_push($lista,new bicicleta($cadena[0],$cadena[1],$cadena[2],$cadena[3]));				

            }                        
        }
        fclose($archivo); 
        return $lista;
    }

    
    public static function Verificar($color,$tipo)
    {
        $lista = array();

        $lista = self::TraerLista();

        $ret = "No hay";

        foreach($lista as $l)
        {
            if($l->_color == $color && $l->_tipo == $tipo)
            {
                $ret = "si hay";
                break;
            }
            else if($l->_color == $color && $l->_tipo != $tipo)
            {
                $ret = "hay color no tipo";
            }
            else if($l->_sabor != $sabor && $l->_tipo == $tipo)
            {
                $ret = "no hay color";
            }

        }
        return $ret;
    }

    public static function ArchivarListaNueva($lista)
    {
        if(unlink('bicicletas.txt'))
        {     
            foreach($lista as $l)
            {
                self::Archivar($l);
            }
        }            
    }


  
    public static function ModificarLista($elemento)
    {
    
        $lista = self::TraerLista();

        $lista2 = array();
        foreach($lista as $l)
        {      
            if($l->_tipo == $elemento->_tipo && $l->_color == $elemento->_color){
                $l = $elemento;
            }            
            array_push($lista2,$l);
        }
    self::ArchivarListaNueva($lista2);

    }




/*
    
        
    public static function MoverABorrados($sabor,$tipo)
    {        
        $lista = self::TraerLista();
        $lista2 = array();
        $hora = date("Ymd");
        $camino = "Del/".$hora.".jpg";
        $ret = 0;

        foreach($lista as $l)
        {      
            if($l->_tipo == $tipo && $l->_sabor == $sabor){
                $file = 'ImagenesDeLaVenta/'.$l->_sabor.'_'.$hora.'.jpg';
                self::ArchivarEliminado($l,$hora);
                continue;
            }            
            array_push($lista2,$l);
        }
        self::ArchivarListaNueva($lista2);
      
        if(rename($file,$camino)){
          $ret = 1;
        }
        return $ret;
    }           
    
    public static function ArchivarEliminado($elemento,$hora)
    {           
        $retorno = 0;
        $archivo = fopen('Eliminados.txt',"a");
        
        if((fwrite($archivo,$hora.'-'.$elemento->ToString())) != false){
            $retorno = 1;
        }
        fclose($archivo);
        return $retorno;
    }
    
  
*/  

}//____________________Cierra Helado 



?>


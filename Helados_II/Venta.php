<?php

include_once "helado.php";

class Venta{

    public $_email;

    function __construct($email = null){
        $this->_email = $email;
    }
    
    public static function AltaVenta($sabor,$tipo,$cantidad,$mail)
    {        
        $h = new helado();
        $h = helado::TraeObjeto($sabor,$tipo);

        $fecha = date("Ymd");
        $destino = "./ImagenesDeLaVenta/".$h->_sabor.'_'.$fecha.'.jpg'; 

        if($h != null)
        {
                if((int)$h->_cantidad >= (int)$cantidad)
                {
                    $h->_cantidad = (int)$h->_cantidad -  (int)$cantidad;

                    helado::ModificarLista($h);
                    $h->_cantidad = $cantidad; 
                    if(self::ArchivarVenta($h,$destino,$mail))
                    {
                        echo "Se efectuó la venta";
                    }                   
                }
                else{
                    echo "no alcanza el helado";
                }
        }
        else{
            echo "El helado no existe";
        }
    }

    public static function AltaVentaConImagen($sabor,$tipo,$cantidad,$mail)
    {        
        $h = new helado();
        $h = helado::TraeObjeto($sabor,$tipo);
        $hora = date("Ymd");

        if($h != null)
        { 
            if((int)$h->_cantidad >= (int)$cantidad)
                {
                    $h->_cantidad = (int)$h->_cantidad -  (int)$cantidad;
                    helado::ModificarLista($h);
                    $h->_cantidad = $cantidad; //lo devuelvo a cantidad vendidad
                                                                      
                    $destino = "./ImagenesDeLaVenta/".$h->_sabor.'_'.$hora.'.jpg'; 
                    self::ArchivarVenta($h,$destino,$mail);
                    return move_uploaded_file($_FILES['archivo']['tmp_name'],$destino);         
                   
                }
                else{
                    echo "no alcanza el helado";
                }
        }
        else{
            echo "El helado no existe";
        }

    }

    public static function ArchivarVenta($elemento,$destino,$mail)
    {   
        $archivo = fopen('venta.txt',"a");
        if((fwrite($archivo,$mail.'-'.$destino.'-'.$elemento->ToString())) != false){
            echo "Se archivó el elemento";
        }         
        else{
            echo "No se pudo archivar el elemento";
        }
        fclose($archivo);
    }
          
    
    public static function ArchivarConImagen($el,$mail)
    {   
        $hora = date("Ymd");
               
        if(self::ArchivarVenta($el,$mail))
        {                    
            $destino = "./ImagenesDeLaVenta/".$el->_sabor.'-'.$hora.'.jpg'; 
            return move_uploaded_file($_FILES['archivo']['tmp_name'],$destino);           
        }         
        return false;    

    }




    public static function ImprimirTabla($sabor,$tipo)
    {
        $lista = array();
        $lista = self::TraerListaVentas();       

        $archivo = fopen('venta.txt',"r");          
        $miContenido  = '<html><head></head><body><h3>Lista</h3>';
        $cuerpo = "";

        while(!feof($archivo)){

            $aux = fgets($archivo);
            $cadena = explode("-",$aux);
                    
            $cadena[0] = trim($cadena[0]);
            if($cadena[0] == "")continue;    

            //yy@mail.com-./ImagenesDeLaVenta/naranja_20171205.jpg-naranja-agua-4-1
            else if($cadena[2] == $sabor && $tipo == $cadena[3]){
            
                    $cuerpo = $cuerpo.'<h4>Mail: '.$cadena[0].'</h4>';
                    $cuerpo = $cuerpo.'<h4>Sabor: '.$cadena[2].'</h4>';
                    $cuerpo = $cuerpo.'<h4>Cantidad: '.$cadena[5].'</h4>';
                    $cuerpo = $cuerpo.'<img src=".'.$cadena[1].'" height="100" width="100"><br>';                         
            }

          }
          $miContenido = $miContenido.'<div>'.$cuerpo.'</div></body></html>';

        //__________Imprimo en HTML
        echo $miContenido;
       
    }   
   

    public static function TraerListaVentas()
    {
        $archivo = fopen('venta.txt',"r");     
        $lista = array();

        while(!feof($archivo)){
            
            $aux = fgets($archivo);
            $cadena = explode("-",$aux);

            $cadena[0] = trim($cadena[0]);
            if($cadena[0] != ""){
                            
                array_push($lista,array("email"=>$cadena[0],"direccion"=>$cadena[1],"sabor"=>$cadena[2],"tipo"=>$cadena[3]));				

            }                        
        }
        fclose($archivo); 
        return $lista;
    }
   

    public static function ModificarVenta($h)
    {
        if(self::MoverAModificados($h))
        {
          helado:: ModificarLista($h);
          $hora = date("Ymd");        
          $destino = "./ImagenesDeLaVenta/".$h->_sabor.'_'.$hora.'.jpg'; 
          if(move_uploaded_file($_FILES['archivo']['tmp_name'],$destino))
          {
              echo "Se modificó el helado";
          }
      
      }
    }
    
    public static function MoverAModificados($elemento)
    {        
        $lista = array();
        $lista = self::TraerListaVentas();
        $ret = 0;

        $direccion = "";        
        foreach($lista as $l)
        {           
            if($elemento->_sabor == $l['sabor'] && $elemento->_tipo == $l['tipo']){
                $direccion = $l['direccion'];           
            }           
        }
               
        if((strlen($direccion)) > 0){

            try{                
                $direccion = trim($direccion);
                rename(__DIR__.$direccion,__DIR__.'./Modi/xxx.jpg');
                $ret = 1;                
            }
            catch(Exception $e){
                echo $e->_getMessage();
            }            
        }
        return $ret; 

    }
        
    
    public static function ImprimirHTML($opcion,$sabor)
    {
                
        $miContenido  = '<html><head></head><body><h3>Listado</h3>';
        $cuerpo = "";

        if($opcion != "Actuales" && $opcion != "Eliminados"){
            $cuerpo = '<h4>Opción inválida</h4>';
        }
        else{

                if($opcion == "Actuales"){ 
                    $archivo = fopen('venta.txt',"r"); 
                }
                else if($opcion == "Eliminados"){
                    $archivo = fopen('Eliminados.txt',"r");     
                }   

                    while(!feof($archivo)){

                        $aux = fgets($archivo);
                        $cadena = explode("-",$aux);      
                        $cadena[0] = trim($cadena[0]);       
                        if($cadena[0] == ""){continue;} 
                        
                        if($opcion == "Eliminados"){

                            if($cadena[1] == $sabor){                
                                    $cuerpo = $cuerpo.'<h4>Sabor: '.$cadena[1].'</h4>';
                                    $cuerpo = $cuerpo.'<img src="../Del/'.$cadena[0].'.jpg" height="100" width="100"><br>';             
                            }  
                        }

                        if($opcion == "Actuales"){
                            
                            if($cadena[2] == $sabor){                
                                    $cuerpo = $cuerpo.'<h4>Sabor: '.$cadena[2].'</h4>';
                                    $cuerpo = $cuerpo.'<img src=".'.$cadena[1].'" height="100" width="100"><br>';             
                            }  
                        }            
                            
                    }
            }            
        //__________Imprimo en HTML
        $miContenido = $miContenido.'<div>'.$cuerpo.'</div></body></html>';
        echo $miContenido;
    }//cierro funcion imprimir

}//____________________Cierra Helado 



?>


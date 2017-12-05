<?php

include_once "bicicleta.php";

class venta{

    public $_email;

    function __construct($email = null){
        $this->_email = $email;
    }
    
    public static function AltaVenta($color,$tipo,$cantidad,$mail)
    {        
        $elemento = new bicicleta();
        $elemento = bicicleta::TraeObjeto($color,$tipo);

        $fecha = date("Ymd");
        $destino = "./ImagenesDeLaVenta/".$elemento->_color.'_'.$fecha.'.jpg'; 

        if($elemento != null)
        {
                if((int)$elemento->_cantidad >= (int)$cantidad)
                {
                    $elemento->_cantidad = (int)$elemento->_cantidad -  (int)$cantidad;

                    bicicleta::ModificarLista($elemento);
                    $elemento->_cantidad = $cantidad; 
                    if(self::ArchivarVenta($elemento,$destino,$mail))
                    {
                        echo "Se efectuó la venta";
                    }                   
                }
                else{
                    echo "no alcanza  la cantidad";
                }
        }
        else{
            echo "El objeto no existe";
        }
    }


    public static function AltaVentaConImagen($color,$tipo,$cantidad,$mail)
    {        
        $elemento = new bicicleta();
        $elemento = bicicleta::TraeObjeto($color,$tipo);

        $fecha = date("Ymd");
        $destino = "./ImagenesDeLaVenta/".$elemento->_color.'_'.$fecha.'.jpg';                
        
        if($elemento != null)
        { 
            if((int)$elemento->_cantidad >= (int)$cantidad)
                {
                    $elemento->_cantidad = (int)$elemento->_cantidad -  (int)$cantidad;
                    bicicleta::ModificarLista($elemento);
                    $elemento->_cantidad = $cantidad; //lo devuelvo a cantidad vendidad
                                                                      
                    
                    self::ArchivarVenta($elemento,$destino,$mail);
                    return move_uploaded_file($_FILES['archivo']['tmp_name'],$destino);         
                   
                }
                else{
                    echo "no alcanza la cantidad";
                }
        }
        else{
            echo "El objeto no existe";
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
          
    
    public static function ImprimirTabla($color,$tipo)
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
            
            else if($cadena[2] == $color && $tipo == $cadena[3]){
                    
            //xx@mail.com-./ImagenesDeLaVenta/rojo_20171205.jpg-rojo-cross-20-1
                    $cuerpo = $cuerpo.'<h4>Mail: '.$cadena[0].'</h4>';
                    $cuerpo = $cuerpo.'<h4>Color: '.$cadena[2].'</h4>';
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
                            
                array_push($lista,array("email"=>$cadena[0],"direccion"=>$cadena[1],"color"=>$cadena[2],"tipo"=>$cadena[3],"precio"=>$cadena[4],"cantidad"=>$cadena[5]));				

            }                        
        }
        fclose($archivo); 
        return $lista;
    }
   
    public static function ModificarVenta($elemento)
    { 
          bicicleta::ModificarLista($elemento);
          $fecha = date("Ymd"); 
          
          $actual = trim("./ImagenesDeLaVenta/".$elemento->_color.'_'.$fecha.'.jpg');
          $destino = trim("./Modi/".$elemento->_color.'_'.$fecha.'.jpg');  
          
          rename(__DIR__.$actual,__DIR__.$destino);

          if(move_uploaded_file($_FILES['archivo']['tmp_name'],$actual))
          {
              echo "Se modificó el elemento";
          }
      
      
    }
    
  /*  public static function MoverAModificados($elemento)
    {        
        
        $ret = 0;
        $hora = date("Ymd"); 
        $destino = "./Modi/".$elemento->_color.'_'.$hora.'.jpg'; 

        try{ 
                            
            $direccion = trim($direccion);
            $destino = trim($destino);
            rename(__DIR__.$direccion,__DIR__.$destino);
            $ret = 1;                
        }
        catch(Exception $e){
            echo $e->_getMessage();
        }            
        
        return $ret; 

    }*/
        
    
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

    
       /*
    
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

*/
}//____________________Cierra Helado 



?>


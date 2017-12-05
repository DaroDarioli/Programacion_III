<?php

include_once 'comentario.php';

class usuario
{
    public $_nombre;

    public $_email;

    public $_clave;

    public $_perfil;

    public $_edad;

    function __construct($nombre = null,$email = null,$clave = null ,$perfil = null,$edad = null){
        $this->_nombre = $nombre;
        $this->_email = $email;
        $this->_clave = $clave;
        $this->_perfil =$perfil;
        $this->_edad = $edad;
     }

    public function ToString()
    {
        return $this->_nombre.'-'.$this->_email.'-'.$this->_clave.'-'.$this->_perfil.'-'.$this->_edad."\r\n";    
    }
    
    public static function TraeObjeto($email)
    {
        $lista = self::TraerLista();       

            foreach($lista as  $l)
            {      
                if($l->_email == $email){
                    return $l;
                }           
            }
        return null;
    }

    
    public static function TraerLista()
    {
        $archivo = fopen('usuarios.txt',"r");     
        $lista = array();

        while(!feof($archivo)){
            
            $aux = fgets($archivo);
            $cadena = explode("-",$aux);

            $cadena[0] = trim($cadena[0]);
            if($cadena[0] != ""){
                            
                array_push($lista,new usuario($cadena[0],$cadena[1],$cadena[2],$cadena[3],$cadena[4]));				

            }                        
        }
        fclose($archivo); 
        return $lista;
    }


    public static function Archivar($usuario)
    {   
        $archivo = fopen('usuarios.txt',"a");
        if((fwrite($archivo,$usuario->ToString())) != false){
            echo "Se archivó el elemento";
        }         
        else{
            echo "No se pudo archivar el elemento";
        }
        fclose($archivo);
    }

    
        


//______________Fin Métodos de Clase_________//






    public static function VerificaUsuario($mail,$clave)
    {
        $archivo = fopen('usuarios.txt',"r");        
        $retorno =  'Usuario inexistente';

        while(!feof($archivo))
        {
            $aux = fgets($archivo);
            $cadena = explode("-",$aux);

            if($cadena[0] == "")continue; 

            else if($cadena[1] == $mail && $cadena[2] == $clave)
            {
                $retorno = 'Bienvenido!'; 
                break;          
            }
            else if($cadena[1] == $mail && $cadena[2] != $clave)
            {
                $retorno = "No se reconoce la clave";
            }                   
        }
        fclose($archivo);        
        return $retorno;
    }

    public static function VerificaMail($mail){
        
            $archivo = fopen('usuarios.txt',"r");        
            $retorno = 0;
        
            while(!feof($archivo)){
        
                $aux = fgets($archivo);
                $cadena = explode("-",$aux);
                if($cadena[0] == "")
                    continue; 
                
                else if($cadena[1] == $mail){
                    $retorno = 1; 
                    break;          
                }                   
            }
            fclose($archivo);        
            return $retorno;
    }

    
    public static function ArchivarListaNueva($lista)
    {
        if(unlink('usuarios.txt'))
        {     
            foreach($lista as $l)
            {
                self::Archivar($l);
            }
        }            
    }


public static function ModificarLista($varUsuario)
{
  
    $lista = self::TraerLista();

    $lista2 = array();
    foreach($lista as  $l)
    {      
        if($l->_email == $varUsuario->_email){
            $l = $varUsuario;
        }            
        array_push($lista2,$l);
    }
   self::ArchivarListaNueva($lista2);
}



} // cierra clase usuario 

?>


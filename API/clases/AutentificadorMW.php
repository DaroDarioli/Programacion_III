<?php

require_once "AutentificadorJWT.php";

class AutentificadorMW
{
 
	public function VerificarUsuario($request, $response, $next) {
         
		$obj = new stdclass();
		$obj->respuesta="";

		if($request->isGet())
		{		 
			$response = $next($request, $response);
		}
		else{
			
			$arrayConToken = $request->getHeader('token');				
			$token = $arrayConToken[0];
			$obj->itsok = true;

			try{
				AutentificadorJWT::verificarToken($token);				
				$obj->itsok = true;
			}
			catch(Exception $e){
				$obj->excepcion = $e->getMessage();
				$obj->itsok = false;
			}
			if($obj->itsok){

				if($request->isPost()){
					$response = $next($request, $response);
				}// a partir de acá válido sólo  para adminstradores
				else{
					$payload=AutentificadorJWT::ObtenerData($token);

					if($payload->perfil=="Administrador"){
						$response = $next($request, $response);
					}//token valido no administrador 		           	
					else{
						$obj->respuesta="Solo administradores";
					}
				}
			}//token inválido
			else{				
				$obj->respuesta="Solo usuarios registrados";
				$obj->elToken=$token;
			}
			if($obj->respuesta!=""){
				$nueva=$response->withJson($obj, 401);  
				return $nueva;
			} 
		}//cierra else para diferente de Get	
	return $response;  
	
	}//cierra método


	public function VerificarAcceso($request, $response, $next) {
		
		$obj = new stdclass();
		$obj->respuesta="";
		$fecha = date('Y-m-d');
		$hora = date('H:i:sa');
		
		$arrayConToken = $request->getHeader('token');

		$token = $arrayConToken[0];
		$obj->itsok = true;


		try{
			AutentificadorJWT::verificarToken($token);				
			$obj->itsok = true;
		}
		catch(Exception $e){
			$obj->excepcion = $e->getMessage();
			$obj->itsok = false;
		}//_______________________Token OK
		if($obj->itsok)
		{		
			//______Tomo data del token
			$payload=AutentificadorJWT::ObtenerData($token);
			$nombre = $payload->nombre; 
			$mail = $payload->mail;
			$perfil = $payload->perfil;

			//______Tomo data del tipo de tarea y archivo el logueo
			if($request->isPost()){
				$tarea = "Ingresar Auto";
				self::ArchivarIngresos($nombre,$mail,$perfil,$tarea,$fecha,$hora);
				$response = $next($request, $response);	
	
			}
			else if($request->isGet()){
				$tarea = "Verificar Auto";
				self::ArchivarIngresos($nombre,$mail,$perfil,$tarea,$fecha,$hora);
				$response = $next($request, $response);	
	
			}
			else if($request->isDelete()){
				$tarea = "Retirar auto";
				self::ArchivarIngresos($nombre,$mail,$perfil,$tarea,$fecha,$hora);
				$response = $next($request, $response);	
	
			}
			else if($request->isPut()){
				$tarea = "Modificar auto";
				self::ArchivarIngresos($nombre,$mail,$perfil,$tarea,$fecha,$hora);
				$response = $next($request, $response);	
	
			}
			
		}//token inválido
		else
		{			
			$obj->respuesta="Solo usuarios registrados";		
			$nueva=$response->withJson($obj, 401);  
			return $nueva;
		} 
		return $response; 
		   
   }//Cierra verificar acceso

   
	public static function ArchivarIngresos($nombre,$mail,$perfil,$tarea,$fecha,$hora)
	{   		
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into ingresos (nombre,mail,perfil,tarea,fecha,hora)values(:nombre,:mail,:perfil,:tarea,:fecha,:hora)");
				
		$consulta->bindValue(':nombre',$nombre, PDO::PARAM_STR);
		$consulta->bindValue(':mail',$mail, PDO::PARAM_STR);
		$consulta->bindValue(':perfil',$perfil, PDO::PARAM_STR);
		$consulta->bindValue(':tarea',$tarea, PDO::PARAM_STR);
		$consulta->bindValue(':fecha',$fecha, PDO::PARAM_STR);
		$consulta->bindValue(':hora',$hora, PDO::PARAM_STR);
		
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
	
}
?>
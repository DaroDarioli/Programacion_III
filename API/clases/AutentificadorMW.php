<?php

require_once "AutentificadorJWT.php";

class AutentificadorMW
{
 
	public function VerificarUsuario($request, $response, $next) {
         
		$obj = new stdclass();
		$obj->respuesta="";

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
		} //token ok
		if($obj->itsok)
		{
			if($request->isGet())
			{		 
				$response = $next($request, $response);	
			}
			else{
				
				$payload=AutentificadorJWT::ObtenerData($token);
				
				if($payload->perfil=="Administrador"){

					$response = $next($request, $response);
				}
		    	else
				{	
					$obj->respuesta="Solo administradores";
				}


				}
			}//token inválido
			else{
				
				$obj->respuesta="Solo usuarios registrados";
				$obj->elToken=$token;

			}
			if($obj->respuesta!="")
			{
				$nueva=$response->withJson($obj, 401);  
				return $nueva;
			} 
			return $response;
	}//cierra método
	
	
	
	
}
?>
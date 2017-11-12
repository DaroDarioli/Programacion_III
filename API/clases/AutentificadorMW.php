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
					
		//	$vector = $request->getParsedBody();
		//	$vMail = $vector['mail'];
		//	$vClave = $vector['clave'];
			
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
				}// a partir de acá sólo válido para adminstradores
				else{

					$payload=AutentificadorJWT::ObtenerData($token);

					if($payload->perfil=="Administrador"){

						$response = $next($request, $response);
					}//token valido no administrador 		           	
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
		}//cierra else para diferente de Get
	
	return $response;  
	
	}//cierra método
}
?>
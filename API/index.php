<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ .'/../composer/vendor/autoload.php';

require_once './clases/AccesoDatos.php';
require_once './clases/auto.php';
require_once './clases/empleado.php';
require_once './clases/AutentificadorMW.php';
require_once './clases/AutentificadorJWT.php';

require_once './clases/MWparaCORS.php';




$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*

¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);

//  $this->get('/', \cdApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');


$app->get('/crearToken/', function (Request $request, Response $response) {
  //   $datos = array('usuario' => 'rogelio@agua.com','perfil' => 'Administrador', 'alias' => "PinkBoy");
    //$datos = array('usuario' => 'rogelio@agua.com','perfil' => 'profe', 'alias' => "PinkBoy");
       
    $datos = $request->getParams('mail','clave','perfil');
    $token= AutentificadorJWT::CrearToken($datos); 
    $newResponse = $response->withJson($token, 200); 
    return $newResponse;
 });
 

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/empleado', function () {
  
   $this->get('/login',\empleado::class . ':TraerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos'); 

   $this->post('/login',\empleado::class . ':cargarEmpleado'); 

   $this->put('/login',\empleado::class . ':modificarEmpleado'); 
 
     
})->add(\AutentificadorMW::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');


$app->group('/auto', function () {   
  
   $this->get('/', \auto::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');  
   
   $this->post('[/]',\auto::class .':CargarAuto');

   $this->delete('/{patente}', \auto::class . ':BorrarUno');
  
  
  })->add(\MWparaCORS::class . ':HabilitarCORS8080');


/*_______________________________________________________________________*/

$app->run();
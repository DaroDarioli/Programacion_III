<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ .'/../composer/vendor/autoload.php';

require_once './clases/AccesoDatos.php';
require_once './clases/producto.php';
require_once './clases/productoApi.php';
require_once './clases/empleado.php';
require_once './clases/empleadoApi.php';

require_once './clases/AutentificadorMW.php';
require_once './clases/AutentificadorJWT.php';
require_once './clases/MWparaCORS.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/empleado', function () {
  
    //    $this->get('/login',\empleadoApi::class . ':TraerEmpleados')->add(\MWparaCORS::class . ':HabilitarCORSTodos'); 
    
    $this->post('/alta',\empleadoApi::class . ':CargarEmpleado'); 
    
    $this->post('/login',\empleadoApi::class . ':TraerUnEmpleado');

    $this->get('/listado',\empleadoApi::class . ':TraerEmpleados'); 
    
    $this->put('/modificar',\empleadoApi::class . ':ModificarEmpleado'); 
    
    $this->delete('/login/{id}',\empleadoApi::class . ':BorrarEmpleado')->add(\MWparaCORS::class . ':HabilitarCORSTodos'); 
     
         
    });


    $app->group('/producto', function () {
  
        //    $this->get('/login',\empleadoApi::class . ':TraerEmpleados')->add(\MWparaCORS::class . ':HabilitarCORSTodos'); 
        
           $this->post('/cargar',\productoApi::class . ':CargarProducto');
    
        //    $this->get('/listado',\empleadoApi::class . ':TraerEmpleados'); 
        
        //    $this->post('/alta',\empleadoApi::class . ':CargarEmpleado'); 
        
        //    $this->put('/login',\empleadoApi::class . ':ModificarEmpleado'); 
        
        //    $this->delete('/login/{mail}', \empleadoApi::class . ':BorrarEmpleado')->add(\MWparaCORS::class . ':HabilitarCORSTodos'); 
         
             
        });



$app->get('/crearToken/', function (Request $request, Response $response) {
  
      $datos = $request->getParams('nombre','mail','clave','perfil');
      $vMail = $datos['mail'];
      $var = empleado::TraerUno($vMail);      
      
      if($var != null){

          $token= AutentificadorJWT::CrearToken($datos); 
          $newResponse = $response->withJson($token, 200); 
          return $newResponse;
      }
      else{

          return "No se puede crar token a empleado inexistente";
      }
 });
 

//_____________________________________Empleado____________//


//->add(\AutentificadorMW::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

//_____________________________________Auto____________//

$app->group('/auto', function () {   
  
  // $this->get('/', \autoApi::class . ':TraerAutos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');  
   
   $this->get('/', \autoApi::class . ':TraerUnAuto');  

   $this->post('/',\autoApi::class .':CargarAuto');

   $this->put('/{patente}',\autoApi::class .':ModificarAuto');

   $this->delete('/', \autoApi::class . ':RetirarAuto');
  
  
  })->add(\AutentificadorMW::class . ':VerificarAcceso')->add(\MWparaCORS::class . ':HabilitarCORSTodos');


/*_______________________________________________________________________*/

$app->run();
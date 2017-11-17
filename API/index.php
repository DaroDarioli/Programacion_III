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

 

//_____________________________________Empleado____________//

$app->group('/empleado', function () {
  
   $this->get('/',\empleadoApi::class . ':TraerEmpleados')->add(\MWparaCORS::class . ':HabilitarCORSTodos'); 

   $this->post('/email/clave/',\empleadoApi::class . ':TraerUnEmpleado');

   $this->post('/Login',\empleadoApi::class . ':ValidarEmpleado');

   $this->post('/',\empleadoApi::class . ':CargarEmpleado'); 

 
     
});

//_____________________________________Producto____________//

$app->group('/producto', function () {   
  
    $this->post('/',\productoApi::class .':CargarProducto');
    
    $this->get('/', \productoApi::class . ':TraerProductos')->add(\MWparaCORS::class . ':HabilitarCORSTodos'); 
   
    $this->put('/{id}',\productoApi::class .':ModificarProducto');
   
    $this->delete('/{id}', \productoApi::class . ':BorrarProducto');
     
  
  })->add(\AutentificadorMW::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080')->add(\MWparaCORS::class . ':HabilitarCORS8080');


/*_______________________________________________________________________*/

$app->run();
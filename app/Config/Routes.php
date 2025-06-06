<?php namespace Config;

// Crea una nueva instancia de nuestra clase RouteCollection.
$routes = Services::routes();

// Carga primero el archivo de rutas del sistema, para que la aplicación y el entorno
// puedan sobrescribirlo si es necesario.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Configuración del enrutador
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');  // Espacio de nombres por defecto para los controladores
$routes->setDefaultController('Home');            // Controlador por defecto
$routes->setDefaultMethod('index');               // Método por defecto
$routes->setTranslateURIDashes(false);            // No traducir guiones a guiones bajos
$routes->set404Override();                        // Manejador personalizado para errores 404 (si se configura)
//$routes->setAutoRoute(false);                   // Desactivar el enrutamiento automático (comentado)

/**
 * --------------------------------------------------------------------
 * Definición de rutas
 * --------------------------------------------------------------------
 */

// Obtenemos un aumento de rendimiento al especificar la ruta por defecto
// ya que no es necesario escanear directorios.
$routes->get('/', 'Home::index');
$routes->get('principal', 'Home::index');
$routes->get('quienes_somos', 'Home::quienes_somos');
$routes->get('Contacto', 'Home::Contacto'); 
$routes->get('Comercializacion', 'home::Comercializacion'); 
$routes->get('termino_usos', 'home::termino_usos');
$routes->get('footer', 'home::footer');

// Rutas CRUD para usuarios 
$routes->get('usuarios', 'UserController::index'); // Listar todos (incluyendo desactivados)
$routes->get('usuarios/activos', 'UserController::activos'); // Listar solo activos
$routes->get('usuarios/(:num)', 'UserController::show/$1'); // Ver uno (incluyendo desactivados)
$routes->post('usuarios/crear', 'UserController::crear'); // Crear
$routes->put('usuarios/editar/(:num)', 'UserController::update/$1'); // Actualizar
$routes->delete('usuarios/eliminar/(:num)', 'UserController::delete/$1'); // Eliminación lógica
$routes->put('usuarios/restaurar/(:num)', 'UserController::restaurar/$1'); // Restaurar usuario

// CRUD de Productos
$routes->get('productos', 'ProductoController::index'); // Listar todos
$routes->get('productos/crear', 'ProductoController::crearView'); // Vista de creación (formulario)
$routes->post('productos/crear', 'ProductoController::crear'); // Procesar creación (POST)
$routes->get('productos/editar/(:num)', 'ProductoController::editarView/$1'); // Vista de edición
$routes->put('productos/editar/(:num)', 'ProductoController::editar/$1'); // Procesar edición (PUT)
$routes->delete('productos/eliminar/(:num)', 'ProductoController::eliminar/$1');

// CRUD Carrito de compras
$routes->get('carrito/usuario/(:num)', 'CarritoController::mostrarCarrito/$1');       // Ver el carrito de un usuario
$routes->post('carrito/agregar', 'CarritoController::agregarProducto');               // Agregar producto al carrito
$routes->put('carrito/editar/(:num)', 'CarritoController::editarProducto/$1');        // Editar cantidad de un producto
$routes->delete('carrito/eliminar/(:num)', 'CarritoController::eliminarProducto/$1'); // Eliminar producto del carrito

// CRUD Pedido
$routes->get('pedido', 'PedidoController::index');               // Listar pedidos
$routes->get('pedido/(:num)', 'PedidoController::show/$1');     // Ver pedido
$routes->post('pedido/crear', 'PedidoController::crear');       // Crear pedido
$routes->put('pedido/editar/(:num)', 'PedidoController::update/$1'); // Editar pedido
$routes->delete('pedido/eliminar/(:num)', 'PedidoController::delete/$1'); // Eliminar pedido

// CRUD Pedido Detalle
$routes->get('pedido_detalle/(:num)', 'PedidoDetalleController::mostrarPorPedido/$1');      // Ver detalles de un pedido
$routes->post('pedido_detalle/agregar', 'PedidoDetalleController::agregar');               // Agregar detalle
$routes->put('pedido_detalle/editar/(:num)', 'PedidoDetalleController::editar/$1');        // Editar detalle
$routes->delete('pedido_detalle/eliminar/(:num)', 'PedidoDetalleController::eliminar/$1'); // Eliminar detalle

// Rutas para autenticación
$routes->get('/', 'Home::index');                               // Página principal
$routes->get('home', 'Home::index');                            // Página de inicio
$routes->get('register', 'AuthController::register');           // Mostrar formulario
$routes->post('register', 'AuthController::processRegister');   // Procesar registro
$routes->get('login', 'AuthController::login');                 // Mostrar formulario  
$routes->post('login', 'AuthController::processLogin');         // Procesar login
$routes->get('logout', 'AuthController::logout');               // Cerrar sesión
$routes->get('test', function() {
    return 'Ruta de prueba funciona';
});
// Rutas para API de usuarios (si las necesitas)
$routes->group('api', function($routes) {
    $routes->get('users', 'UserController::index');              // Todos los usuarios
    $routes->get('users/activos', 'UserController::activos');    // Solo activos
    $routes->get('users/(:num)', 'UserController::show/$1');     // Un usuario específico
    $routes->post('users', 'UserController::crear');             // Crear via API
    $routes->put('users/(:num)', 'UserController::update/$1');   // Actualizar via API
    $routes->delete('users/(:num)', 'UserController::delete/$1'); // Eliminar via API
    $routes->post('users/(:num)/restore', 'UserController::restaurar/$1'); // Restaurar
});
/**
 * --------------------------------------------------------------------
 * Rutas adicionales
 * --------------------------------------------------------------------
 *
 * A menudo necesitarás rutas adicionales y
 * querrás que puedan sobrescribir cualquier valor por defecto en este archivo.
 * Las rutas basadas en entorno son un ejemplo de ello. Usa require() para cargar archivos adicionales aquí.
 *
 * Tendrás acceso al objeto $routes dentro de ese archivo sin necesidad de volver a cargarlo.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

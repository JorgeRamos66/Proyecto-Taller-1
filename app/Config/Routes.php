<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/**
 * Rutas del navBar
 */
$routes->get('/', 'Home::Principal');
$routes->get('quienes_somos', 'Home::Quienes_somos');
$routes->get('comercializacion', 'Home::Comercializacion');
$routes->get('informacion_de_contacto', 'Contacto_controller::contacto');
$routes->get('terminos_y_usos', 'Home::Terminos_y_usos');
$routes->get('catalogoDeProductos', 'Producto_controller::catalogo_productos');
//$routes->get();



/**
 * Rutas del login
 */
$routes->get('login', 'Usuario_controller::login');
$routes->post('enviarlogin', 'Usuario_controller::auth');
$routes->get('panel_perfil', 'Usuario_controller::modificar_perfil', ['filter' => 'logged']);
$routes->get('logout', 'Usuario_controller::logout');

/**
 * Rutas de las consultas
 */

$routes->post('enviar_consulta/(:num)','Contacto_controller::nueva_consulta/$1');
/**
 * Rutas del registro
 */
/*rutas del Registro de Usuarios*/
$routes->get('form-registro','Usuario_controller::registro');
/*La URI enviar-form es el action del formulario registrarse.php*/
$routes->post('enviar-registro','Usuario_controller::nuevo_registro');

//Routes Admin
$routes->group('', ['filter' => 'admin'], function ($routes) {
    $routes->get('panel_admin','Admin_controller::Admin_view');
    $routes->get('gestion_productos','Producto_controller::gestion_productos');
    $routes->get('form-producto','Producto_controller::crear_producto');
    $routes->post('enviar-producto','Producto_controller::store');
    $routes->get('eliminar-producto/(:num)','Producto_controller::eliminar_producto/$1');
    $routes->get('activar-producto/(:num)','Producto_controller::activar_producto/$1');
    $routes->get('editar-producto/(:num)','Producto_controller::editar_producto/$1');
    $routes->post('actualizar-producto/(:num)','Producto_controller::update/$1');

    $routes->get('gestion_categorias','Categoria_controller::gestion_categorias');
    $routes->post('enviar-categoria','Categoria_controller::store');
    $routes->get('form-categoria','Categoria_controller::crear_categoria');
    $routes->get('activar-categoria/(:num)','Categoria_controller::activar_categoria/$1');
    $routes->get('editar-categoria/(:num)','Categoria_controller::editar_categoria/$1');
    $routes->post('actualizar-categoria/(:num)','Categoria_controller::update/$1');
    $routes->get('eliminar-categoria/(:num)', 'Categoria_controller::eliminar_categoria/$1');

    

    $routes->get('gestion_usuarios','Usuario_controller::listar_usuarios');
    $routes->get('eliminar-usuario/(:num)','Usuario_controller::eliminar_usuario/$1');
    $routes->get('activar-usuario/(:num)','Usuario_controller::activar_usuario/$1');

    $routes->get('ver_ventas','Ventas_controller::gestion_ventas');
    $routes->get('obtener_detalle_venta/(:segment)', 'Ventas_controller::obtener_detalle_venta/$1');
    


    $routes->get('gestion_consultas','Contacto_controller::listar_consultas');
    $routes->post('leer-consulta/(:num)','Contacto_controller::marcar_consulta_leido/$1');
    $routes->post('desleer-consulta/(:num)','Contacto_controller::marcar_consulta_desleido/$1');
    
    
    $routes->get('facturacion','Ventas_controller::gestion_ventas');
    
});
$routes->group('', ['filter' => 'logged'], function ($routes) {
    $routes->get('perfil-usuario/(:segment)', 'Usuario_controller::perfil_usuario/$1');

    $routes->group('', ['filter' => 'checkUser'], function ($routes) {
        $routes->get('editar-usuario/(:segment)', 'Usuario_controller::editar_usuario/$1');
        $routes->post('actualizar-usuario/(:segment)', 'Usuario_controller::actualizar_perfil/$1');
    });

    $routes->get('vista_compras/(:segment)', 'Ventas_controller::ver_factura/$1');
    $routes->get('ver_facturas_usuario/(:segment)', 'Ventas_controller::ver_facturas_usuarios/$1');

    /*rutas del Carrito de Usuarios*/
    $routes->get('ver_carrito', 'Carrito_controller::ver_carrito');
    $routes->get('verificar_carrito', 'Carrito_controller::verificar_carrito');
    $routes->post('agregar_carrito', 'Carrito_controller::agregar_al_carrito'); 
    $routes->post('quitar_producto/(:any)','carrito_controller::borrar_del_carrito/$1');
    $routes->post('incrementar_producto/(:num)', 'Carrito_controller::incrementar_producto/$1');
    $routes->post('decrementar_producto/(:num)', 'Carrito_controller::decrementar_producto/$1');
    $routes->post('vaciar_carrito', 'Carrito_controller::vaciar_carrito');
    $routes->post('registrar_venta', 'Ventas_controller::registrar_venta');
});

$routes->get('modificar_usuario','User_modify_controller::user_modify',['filter'=>'register']);
$routes->post('modify_user_post','User_modify_controller::modify_validation',['filter'=>'register']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

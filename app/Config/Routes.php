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
$routes->setDefaultController('Principal');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

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
$routes->get('/', 'Home::Principal');
$routes->get('quienes_somos', 'Home::Quienes_somos');
$routes->get('comercializacion', 'Home::Comercializacion');
$routes->get('informacion_de_contacto', 'Home::Informacion_de_contacto');
$routes->get('terminos_y_usos', 'Home::Terminos_y_usos');
//$routes->get();



/**
 * Rutas del login
 */
$routes->get('login', 'Login_controller::login');
$routes->post('enviarlogin', 'Login_controller::auth');
$routes->get('panel', 'Panel_controller::index', ['filter' => 'auth']);
$routes->get('logout', 'Login_controller::logout');


/**
 * Rutas del registro
 */
/*rutas del Registro de Usuarios*/
$routes->get('registro','Usuario_controller::create');
/*La URI enviar-form es el action del formulario registrarse.php*/
$routes->post('enviar-form','Usuario_controller::formValidation');

//Routes Admin
$routes->get('/admin','Admin_controller::admin_view',['filter'=> 'auth']);
$routes->get('/lista_usuarios','Admin_controller::users_list',['filter'=> 'auth']);

$routes->get('/modificar_usuario','User_modify_controller::user_modify',['filter'=>'register']);
$routes->post('/modify_user_post','User_modify_controller::modify_validation',['filter'=>'register']);

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

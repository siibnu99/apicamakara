<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/auth', 'Auth::index', ['filter' => 'auth']);
// $routes->get('/dashboard', 'Dashboard::index', ['filter' => 'noauth']);
// $routes->post('/aauth/register', 'Aauth::register');
// $routes->post('/aauth/login', 'Aauth::login');

$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'role:admin']);
$routes->get('/documentation', 'Documentation::index', ['filter' => 'role:admin']);
$routes->get('/confirm', 'Confirm::index', ['filter' => 'role:admin']);
$routes->get('/tryout', 'Tryout::index', ['filter' => 'role:admin']);
$routes->get('/tryout/create', 'Tryout::create', ['filter' => 'role:admin']);
$routes->post('/tryout/create', 'Tryout::attemptcreate', ['filter' => 'role:admin']);
$routes->get('/api/user/islogin', 'Apiuser::islogin');
$routes->post('/api/user/forgot', 'Apiuser::forgot');
$routes->post('/api/user/', 'Apiuser::index');
// $routes->resource('/api/user', ['controller' => 'Apiuser']);

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

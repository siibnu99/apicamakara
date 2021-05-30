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
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'role:admin,finance,task']);
$routes->get('/documentation', 'Documentation::index', ['filter' => 'role:admin,finance,task']);
$routes->get('/confirm', 'Confirm::index', ['filter' => 'role:admin,task']);
// ==========================================================================
$routes->get('/tryout', 'Tryout::index', ['filter' => 'role:admin,task']);
$routes->get('/tryout/create', 'Tryout::create', ['filter' => 'role:admin,task']);
$routes->post('/tryout/create', 'Tryout::attemptcreate', ['filter' => 'role:admin,task']);
$routes->get('/tryout/edit/(:segment)', 'Tryout::edit/$1', ['filter' => 'role:admin,task']);
$routes->post('/tryout/edit/(:segment)', 'Tryout::attemptedit/$1', ['filter' => 'role:admin,task']);
$routes->post('/tryout/delete/(:segment)', 'Tryout::delete/$1', ['filter' => 'role:admin,task']);
$routes->get('/tryout/editsoal/(:segment)/(:segment)/(:segment)', 'Tryout::editsoal/$1/$2/$3', ['filter' => 'role:admin,task']);
$routes->post('/tryout/editsoal/(:segment)/(:segment)/(:segment)', 'Tryout::attemptEditSoal/$1/$2/$3', ['filter' => 'role:admin,task']);
$routes->get('/tryout/editbobot/(:segment)/(:segment)', 'Tryout::editbobot/$1/$2', ['filter' => 'role:admin,task']);
$routes->post('/tryout/editbobot/(:segment)/(:segment)', 'Tryout::attempteditbobot/$1/$2', ['filter' => 'role:admin,task']);
$routes->get('/tryout/detail/(:segment)', 'Tryout::detail/$1', ['filter' => 'role:admin,task']);
// ==========================================================================

// ==========================================================================
$routes->get('/quiz', 'Quiz::index', ['filter' => 'role:admin,task']);
$routes->get('/quiz/create', 'Quiz::create', ['filter' => 'role:admin,task']);
$routes->post('/quiz/create', 'Quiz::attemptcreate', ['filter' => 'role:admin,task']);
$routes->get('/quiz/edit/(:segment)', 'Quiz::edit/$1', ['filter' => 'role:admin,task']);
$routes->post('/quiz/edit/(:segment)', 'Quiz::attemptedit/$1', ['filter' => 'role:admin,task']);
$routes->post('/quiz/delete/(:segment)', 'Quiz::delete/$1', ['filter' => 'role:admin,task']);
$routes->get('/quiz/detail/(:segment)', 'Quiz::detail/$1', ['filter' => 'role:admin,task']);
$routes->get('/quiz/editsoal/(:segment)/(:segment)', 'Quiz::editsoal/$1/$2', ['filter' => 'role:admin,task']);
$routes->post('/quiz/editsoal/(:segment)/(:segment)', 'Quiz::attemptEditSoal/$1/$2', ['filter' => 'role:admin,task']);
// ==========================================================================

// ==========================================================================
$routes->get('/confirmfinance', 'Confirmfinance::index', ['filter' => 'role:admin,finance']);
$routes->get('/tabledata', 'Tabledata::index', ['filter' => 'role:admin,finance']);
// ==========================================================================
// ==========================================================================
$routes->get('/api/user/islogin', 'Apiuser::islogin');
$routes->post('/api/user/forgot', 'Apiuser::forgot');
$routes->post('/api/user/login', 'Apiuser::index');
$routes->post('/api/user/update/(:segment)', 'Apiuser::update/$1');
$routes->resource('/api/user', ['controller' => 'Apiuser']);
// ==========================================================================

// ==========================================================================
$routes->resource('/api/address/prov', ['controller' => 'Apiprov']);
// ==========================================================================

// ==========================================================================
$routes->get('/api/address/reg/get/(:segment)', 'Apireg::get/$1');
$routes->resource('/api/address/reg', ['controller' => 'Apireg']);
// ==========================================================================

// ==========================================================================
$routes->resource('/api/univ', ['controller' => 'Apiuniv']);
// ==========================================================================

// ==========================================================================
$routes->get('/api/prodi/get/(:segment)', 'Apiprodi::get/$1');
$routes->resource('/api/prodi', ['controller' => 'Apiprodi']);
// ==========================================================================

// ==========================================================================
$routes->get('/api/tryout/(:segment)', 'Apitryout::index/$1');
$routes->get('/api/tryout/get/(:segment)', 'Apitryout::show/$1');
$routes->resource('/api/tryout', ['controller' => 'Apitryout']);
// ==========================================================================
// ==========================================================================
$routes->get('/api/quiz/get/(:segment)', 'Apiquiz::show/$1');
$routes->get('/api/quiz/(:segment)', 'Apiquiz::index/$1');
$routes->resource('/api/quiz', ['controller' => 'Apiquiz']);
// ==========================================================================

// ==========================================================================
$routes->post('/api/myquiz/invoice/(:segment)/(:segment)', 'Apimyquiz::invoice/$1/$2');
$routes->get('/api/myquiz/get/(:segment)/(:segment)', 'Apimyquiz::get/$1/$2');
$routes->post('/api/myquiz/finish/(:segment)/(:segment)', 'Apimyquiz::finish/$1/$2');
$routes->get('/api/myquiz/(:segment)', 'Apimyquiz::index/$1');
$routes->resource('/api/myquiz', ['controller' => 'Apimyquiz']);
// ==========================================================================

// ==========================================================================
$routes->resource('/api/topup', ['controller' => 'Apitopup']);
// ==========================================================================

// ==========================================================================
$routes->get('/api/transfer/notelp/(:segment)', 'Apitransfer::getByTelp/$1');
$routes->resource('/api/transfer', ['controller' => 'Apitransfer']);
// ==========================================================================

// ==========================================================================
$routes->get('/api/mytryout/get/(:segment)/(:segment)', 'Apimytryout::get/$1/$2');
$routes->get('/api/mytryout/finish/(:segment)/(:segment)', 'Apimytryout::finish/$1/$2');
$routes->get('/api/mytryout/getanswert/(:segment)/(:segment)/(:segment)/(:segment)', 'Apimytryout::getAnswert/$1/$2/$3/$4');
$routes->get('/api/mytryout/(:segment)', 'Apimytryout::index/$1');
$routes->get('/api/mytryout/check', 'Apimytryout::check');
$routes->resource('/api/mytryout', ['controller' => 'Apimytryout']);
// ==========================================================================

// ==========================================================================
$routes->resource('/api/bank', ['controller' => 'Apibank']);
// ==========================================================================

// ==========================================================================
$routes->get('/api/riwayat/(:segment)', 'Apiriwayat::index/$1');
// ==========================================================================

// ==========================================================================
$routes->get('/api/exam/(:segment)/(:segment)', 'Apisoalt::index/$1/$2');
$routes->post('/api/exam/(:segment)/(:segment)/(:segment)', 'Apisoalt::created/$1/$2/$3');
// ==========================================================================
// ==========================================================================
$routes->get('/api/examquiz/score/(:segment)/(:segment)', 'Apisoalq::score/$1/$2');
$routes->get('/api/examquiz/(:segment)', 'Apisoalq::index/$1');
$routes->post('/api/examquiz/(:segment)/(:segment)', 'Apisoalq::created/$1/$2');
// ==========================================================================
// ==========================================================================
$routes->get('/api/score/boardtryoutall/(:segment)', 'Apiscore::boardTryoutAll/$1');
$routes->get('/api/score/(:segment)/(:segment)', 'Apiscore::index/$1/$2');
// ==========================================================================

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

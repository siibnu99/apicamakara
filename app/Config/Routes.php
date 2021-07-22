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
$routes->setAutoRoute(false);

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


$routes->group('api', function ($routes) {
	$routes->group('auth', function ($routes) {
		$routes->post('login', 'Apiauth::login');
		$routes->post('register', 'Apiauth::register');
		$routes->get('islogin', 'Apiauth::islogin');
		$routes->post('forgot', 'Apiauth::forgot');
		$routes->post('tokenv', 'Apiauth::tokenverif');
		$routes->post('setpw', 'Apiauth::setpw');
	});
	$routes->group('profile', ['filter' => 'jwt'], function ($routes) {
		$routes->get('', 'Apiprofile::index');
		$routes->put('', 'Apiprofile::update');
	});
	$routes->group('produk', ['filter' => 'jwt:1'], function ($routes) {
		$routes->resource('quiz', ['controller' => 'Apiquiz']);
		$routes->resource('tryout', ['controller' => 'Apitryout']);
	});
	$routes->group('me', ['filter' => 'jwt'], function ($routes) {
		$routes->group('quiz', function ($routes) {
			$routes->post('invoice', 'Apimyquiz::invoice');
			$routes->post('finish', 'Apimyquiz::finish');
		});
		$routes->resource('quiz', ['controller' => 'Apimyquiz']);
		$routes->group('tryout', function ($routes) {
			$routes->post('finish', 'Apimytryout::finish');
		});
		$routes->resource('tryout', ['controller' => 'Apimytryout']);
		$routes->resource('topup', ['controller' => 'Apitopup']);
		$routes->group('transfer', function ($routes) {
			$routes->get('email/(:segment)', 'Apitransfer::getByEmail/$1');
		});
		$routes->resource('transfer', ['controller' => 'Apitransfer']);
		$routes->get('riwayat', 'Apiriwayat::index');
	});
	$routes->group('exam', ['filter' => 'jwt'], function ($routes) {
		$routes->group('quiz', function ($routes) {
			$routes->post('score', 'Apisoalq::score');
		});
		$routes->resource('quiz', ['controller' => 'Apisoalq']);
		$routes->group('tryout', function ($routes) {
			$routes->get('(:segment)/(:segment)', 'Apisoalt::show/$1/$2');
		});
		$routes->resource('tryout', ['controller' => 'Apisoalt']);
	});
	$routes->group('address', function ($routes) {
		$routes->resource('prov', ['controller' => 'Apiprov']);
		$routes->get('reg/get/(:segment)', 'Apireg::get/$1');
		$routes->resource('reg', ['controller' => 'Apireg']);
	});
	$routes->group('graduate', function ($routes) {
		$routes->resource('univ', ['controller' => 'Apiuniv']);
		$routes->get('prodi/get/(:segment)', 'Apiprodi::get/$1');
		$routes->resource('prodi', ['controller' => 'Apiprodi']);
	});
	$routes->group('resource', function ($routes) {
		$routes->resource('bank', ['controller' => 'Apibank']);
	});
	// $routes->group('board', function ($routes) {
	// 	$routes->get('boardtryoutall/(:segment)', 'Apiscore::boardTryoutAll/$1');
	// 	$routes->get('(:segment)/(:segment)', 'Apiscore::index/$1/$2');
	// });
});
$routes->group('admincamakara', function ($routes) {
	$routes->get('dashboard', 'Dashboard::index', ['filter' => 'role:admin,finance,task']);


	$routes->get('login', 'AuthController::login', ['as' => 'login', 'namespace' => 'Myth\Auth\Controllers']);
	$routes->post('login', 'AuthController::attemptLogin', ['namespace' => 'Myth\Auth\Controllers']);
	$routes->get('logout', 'AuthController::logout', ['namespace' => 'Myth\Auth\Controllers']);

	$routes->group('confirm', ['filter' => 'role:admin,task'], function ($routes) {
		$routes->get('', 'Confirm::index');
		$routes->get('confirm/(:segment)', 'Confirm::confirm/$1');
		$routes->get('notconfirm/(:segment)', 'Confirm::confirm/$1');
		$routes->post('listdata', 'Confirm::listdata');
	});

	$routes->group('tryout', ['filter' => 'role:admin,task'], function ($routes) {
		$routes->get('', 'Tryout::index', ['filter' => 'role:admin,task']);
		$routes->post('listdata', 'Tryout::listdata');
		$routes->get('create', 'Tryout::create', ['filter' => 'role:admin,task']);
		$routes->post('create', 'Tryout::attemptcreate', ['filter' => 'role:admin,task']);
		$routes->get('edit/(:segment)', 'Tryout::edit/$1', ['filter' => 'role:admin,task']);
		$routes->post('edit/(:segment)', 'Tryout::attemptedit/$1', ['filter' => 'role:admin,task']);
		$routes->get('delete/(:segment)', 'Tryout::delete/$1', ['filter' => 'role:admin,task']);
		$routes->get('detail/(:segment)', 'Tryout::detail/$1', ['filter' => 'role:admin,task']);
		$routes->get('editsoal/(:segment)/(:segment)/(:segment)', 'Tryout::editsoal/$1/$2/$3', ['filter' => 'role:admin,task']);
		$routes->post('editsoal/(:segment)/(:segment)/(:segment)', 'Tryout::attemptEditSoal/$1/$2/$3', ['filter' => 'role:admin,task']);
		$routes->get('editbobot/(:segment)/(:segment)', 'Tryout::editbobot/$1/$2', ['filter' => 'role:admin,task']);
		$routes->post('editbobot/(:segment)/(:segment)', 'Tryout::attempteditbobot/$1/$2', ['filter' => 'role:admin,task']);
		$routes->post('toogleactive/(:segment)', 'Tryout::toogleActive/$1', ['filter' => 'role:admin,task']);
	});
	$routes->group('quiz', ['filter' => 'role:admin,task'], function ($routes) {
		$routes->get('', 'Quiz::index', ['filter' => 'role:admin,task']);
		$routes->post('listdata', 'Quiz::listdata');
		$routes->get('create', 'Quiz::create', ['filter' => 'role:admin,task']);
		$routes->post('create', 'Quiz::attemptcreate', ['filter' => 'role:admin,task']);
		$routes->get('edit/(:segment)', 'Quiz::edit/$1', ['filter' => 'role:admin,task']);
		$routes->post('edit/(:segment)', 'Quiz::attemptedit/$1', ['filter' => 'role:admin,task']);
		$routes->get('delete/(:segment)', 'Quiz::delete/$1', ['filter' => 'role:admin,task']);
		$routes->get('detail/(:segment)', 'Quiz::detail/$1', ['filter' => 'role:admin,task']);
		$routes->get('editsoal/(:segment)/(:segment)', 'Quiz::editsoal/$1/$2', ['filter' => 'role:admin,task']);
		$routes->post('editsoal/(:segment)/(:segment)', 'Quiz::attemptEditSoal/$1/$2', ['filter' => 'role:admin,task']);
		$routes->post('toogleactive/(:segment)', 'Quiz::toogleActive/$1', ['filter' => 'role:admin,task']);
	});
	$routes->group('confirmfinance', ['filter' => 'role:admin,finance'], function ($routes) {
		$routes->get('', 'Confirmfinance::index');
		$routes->get('confirm/(:segment)', 'Confirmfinance::confirm/$1');
		$routes->get('notconfirm/(:segment)', 'Confirmfinance::confirm/$1');
		$routes->post('listdata', 'Confirmfinance::listdata');
	});
	$routes->group('tabledata', ['filter' => 'role:admin,finance'], function ($routes) {
		$routes->get('', 'Tabledata::index');
		$routes->post('listdata', 'Tabledata::listdata');
	});
	$routes->group('listuser', ['filter' => 'role:admin'], function ($routes) {
		$routes->get('', 'Listuser::index');
		$routes->get('create', 'Listuser::create', ['filter' => 'role:admin,task']);
		$routes->post('create', 'Listuser::attemptcreate', ['filter' => 'role:admin,task']);
		$routes->get('changepassword/(:segment)', 'Listuser::changePassword/$1', ['filter' => 'role:admin,task']);
		$routes->post('changepassword/(:segment)', 'Listuser::changePasswordAttempt/$1', ['filter' => 'role:admin,task']);
		$routes->get('edit/(:segment)', 'Listuser::edit/$1', ['filter' => 'role:admin,task']);
		$routes->post('edit/(:segment)', 'Listuser::attemptedit/$1', ['filter' => 'role:admin,task']);
		$routes->get('delete/(:segment)', 'Listuser::delete/$1', ['filter' => 'role:admin,task']);
	});
});
$routes->get('/(:any)', 'Home::index');

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

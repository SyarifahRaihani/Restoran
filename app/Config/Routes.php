<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

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
$routes->get('/', 'Home::index');

$routes->group('register', function(RouteCollection $routes){
    $routes->get('/', 'UserController::viewRegister');
    $routes->post('/', 'UserController::register');
});

$routes->group('login', function(RouteCollection $routes){
    $routes->get('lupa', 'UserController::viewLupaPassword');
    $routes->get('/', 'UserController::viewLogin');
    $routes->post('/', 'UserController::login');
    $routes->delete('/', 'UserController::logout');
    $routes->patch('/', 'UserController::lupaPassword');
});

$routes->group('dashboard', function(RouteCollection $routes){
    $routes->get('/', 'DashboardController::index');
});

$routes->group('user', function(RouteCollection $routes){
    $routes->get('/', 'UserController::index');
    $routes->post('/', 'UserController::store');
    $routes->patch('/', 'UserController::update');
    $routes->delete('/', 'UserController::delete');
    $routes->get('(:num)', 'UserController::show/$1');
    $routes->get('all', 'UserController::all');
});

$routes->group('kategori', function(RouteCollection $routes){
    $routes->get('/', 'KategoriController::index');
    $routes->post('/', 'KategoriController::store');
    $routes->patch('/', 'KategoriController::update');
    $routes->delete('/', 'KategoriController::delete');
    $routes->get('(:num)', 'KategoriController::show/$1');
    $routes->get('all', 'KategoriController::all');
});



$routes->group('menu', function(RouteCollection $routes){
    $routes->get('/', 'MenuController::index');
    $routes->post('/', 'MenuController::store');
    $routes->patch('/', 'MenuController::update');
    $routes->delete('/', 'MenuController::delete');
    $routes->get('(:num)', 'MenuController::show/$1');
    $routes->get('(:num)/menu.jpg', 'MenuController::foto/$1');
    $routes->get('all', 'MenuController::all');
});

$routes->group('petugas/menu', function(RouteCollection $routes){
    $routes->get('/', 'MenuPetugasController::index');
});

$routes->group('customer/menu', function(RouteCollection $routes){
    $routes->get('/', 'MenuCustomerController::index');
});

$routes->group('meja', function(RouteCollection $routes){
    $routes->get('/', 'MejaController::index');
    $routes->post('/', 'MejaController::store');
    $routes->patch('/', 'MejaController::update');
    $routes->delete('/', 'MejaController::delete');
    $routes->get('(:num)', 'MejaController::show/$1');
    $routes->get('all', 'MejaController::all');
});

$routes->group('petugas/meja', function(RouteCollection $routes){
    $routes->get('/', 'MejaPetugasController::index');
});

$routes->group('customer/meja', function(RouteCollection $routes){
    $routes->get('/', 'MejaCustomerController::index');
});

$routes->group('pesanan', function(RouteCollection $routes){
    $routes->get('/', 'PesananController::index');
    $routes->post('/', 'PesananController::store');
    $routes->patch('/', 'PesananController::update');
    $routes->delete('/', 'PesananController::delete');
    $routes->get('(:num)', 'PesananController::show/$1');
    $routes->get('all', 'PesananController::all');
});

$routes->group('petugas/pesanan', function(RouteCollection $routes){
    $routes->get('/', 'PesananPetugasController::index');
});

$routes->group('customer/pesanan', function(RouteCollection $routes){
    $routes->get('/', 'PesananCustomerController::index');
});



$routes->group('reservasi', function(RouteCollection $routes){
    $routes->get('/', 'ReservasiController::index');
    $routes->post('/', 'ReservasiController::store');
    $routes->patch('/', 'ReservasiController::update');
    $routes->delete('/', 'ReservasiController::delete');
    $routes->get('(:num)', 'ReservasiController::show/$1');
    $routes->get('all', 'ReservasiController::all');
});

$routes->group('petugas/reservasi', function(RouteCollection $routes){
    $routes->get('/', 'ReservasiPetugasController::index');
});

$routes->group('customer/reservasi', function(RouteCollection $routes){
    $routes->get('/', 'ReservasiCustomerController::index');
});
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

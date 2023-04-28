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

$routes->group('login', function(RouteCollection $routes){
    $routes->get('lupa', 'UserController::viewLupaPassword');
    $routes->get('/', 'UserController::viewLogin');
    $routes->post('/', 'UserController::login');
    $routes->delete('/', 'UserController::logout');
    $routes->patch('/', 'UserController::lupaPassword');
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

$routes->group('pelanggan', function(RouteCollection $routes){
    $routes->get('/', 'PelangganController::index');
    $routes->post('/', 'PelangganController::store');
    $routes->patch('/', 'PelangganController::update');
    $routes->delete('/', 'PelangganController::delete');
    $routes->get('(:num)', 'PelangganController::show/$1');
    $routes->get('all', 'PelangganController::all');
});

$routes->group('produk', function(RouteCollection $routes){
    $routes->get('/', 'ProdukController::index');
    $routes->post('/', 'ProdukController::store');
    $routes->patch('/', 'ProdukController::update');
    $routes->delete('/', 'ProdukController::delete');
    $routes->get('(:num)', 'ProdukController::show/$1');
    $routes->get('all', 'ProdukController::all');
});


$routes->group('ruangan', function(RouteCollection $routes){
    $routes->get('/', 'RuanganController::index');
    $routes->post('/', 'RuanganController::store');
    $routes->patch('/', 'RuanganController::update');
    $routes->delete('/', 'RuanganController::delete');
    $routes->get('(:num)', 'RuanganController::show/$1');
    $routes->get('all', 'RuanganController::all');
});

$routes->group('meja', function(RouteCollection $routes){
    $routes->get('/', 'MejaController::index');
    $routes->post('/', 'MejaController::store');
    $routes->patch('/', 'MejaController::update');
    $routes->delete('/', 'MejaController::delete');
    $routes->get('(:num)', 'MejaController::show/$1');
    $routes->get('all', 'MejaController::all');
});

$routes->group('pesanan', function(RouteCollection $routes){
    $routes->get('/', 'PesananController::index');
    $routes->post('/', 'PesananController::store');
    $routes->patch('/', 'PesananController::update');
    $routes->delete('/', 'PesananController::delete');
    $routes->get('(:num)', 'PesananController::show/$1');
    $routes->get('all', 'PesananController::all');
});

$routes->group('detail', function(RouteCollection $routes){
    $routes->get('/', 'DetailPesananController::index');
    $routes->post('/', 'DetailPesananController::store');
    $routes->patch('/', 'DetailPesananController::update');
    $routes->delete('/', 'DetailPesananController::delete');
    $routes->get('(:num)', 'DetailPesananController::show/$1');
    $routes->get('all', 'DetailPesananController::all');
});

$routes->group('reservasi', function(RouteCollection $routes){
    $routes->get('/', 'ReservasiController::index');
    $routes->post('/', 'ReservasiController::store');
    $routes->patch('/', 'ReservasiController::update');
    $routes->delete('/', 'ReservasiController::delete');
    $routes->get('(:num)', 'ReservasiController::show/$1');
    $routes->get('all', 'ReservasiController::all');
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

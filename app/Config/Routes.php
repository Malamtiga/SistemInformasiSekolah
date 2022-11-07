<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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

$routes->group('/login', ['filter'=>'CekLoggedIn'], function(RouteCollection $routes){
    $routes->get('lupa', 'PegawaiController:viewLupaPassword');
    $routes->get('/', 'PegawaiController::viewLogin');
    $routes->post('/', 'PegawaiController::login');
    $routes->patch('/', 'PegawaiController::lupaPassword');
    
});
$routes->delete('login', 'PegawaiController::logout');

$routes->group('pegawai', ['filter'=>'isLoggedIn'],function(RouteCollection $routes){
    $routes->get('/', 'PegawaiController::index');
    $routes->post('/', 'PegawaiController::store');
    $routes->patch('/', 'PegawaiController::update');
    $routes->delete('/', 'PegawaiController::delete');
    $routes->get('(:num)', 'PegawaiController::show/$1');
    $routes->get('all', 'PegawaiController::all');

});
$routes->group('tahunajaran', function(RouteCollection $routes){
    $routes->get('/', 'TahunAjaranController::index');
    $routes->post('/', 'TahunAjaranController::store');
    $routes->patch('/', 'TahunAjaranController::update');
    $routes->delete('/', 'TahunAjaranController::delete');
    $routes->get('(:num)', 'TahunAjaranController::show/$1');
    $routes->get('all', 'TahunAjaranController::all');

});
$routes->group('mapel', function(RouteCollection $routes){
    $routes->get('/', 'MapelController::index');
    $routes->post('/', 'MapelController::store');
    $routes->patch('/', 'MapelController::update');
    $routes->delete('/', 'MapelController::delete');
    $routes->get('(:num)', 'MapelController::show/$1');
    $routes->get('all', 'MapelController::all');
});
$routes->group('pendidikanguru', function(RouteCollection $routes){
    $routes->get('/', 'PendidikanGuruController::index');
    $routes->post('/', 'PendidikanGuruController::store');
    $routes->patch('/', 'PendidikanGuruController::update');
    $routes->delete('/', 'PendidikanGuruController::delete');
    $routes->get('(:num)', 'PendidikanGuruController::show/$1');
    $routes->get('all', 'PendidikanGuruController::all');
});

$routes->group('kelas', function(RouteCollection $routes){
    $routes->get('/', 'KelasController::index');
    $routes->post('/', 'KelasController::store');
    $routes->patch('/', 'KelasController::update');
    $routes->delete('/', 'KelasController::delete');
    $routes->get('(:num)', 'KelasController::show/$1');
    $routes->get('all', 'KelasController::all');
});

$routes->group('kelassiswa', function(RouteCollection $routes){
    $routes->get('/', 'KelasSiswaController::index');
    $routes->post('/', 'KelasSiswaController::store');
    $routes->patch('/', 'KelasSiswaController::update');
    $routes->delete('/', 'KelasSiswaController::delete');
    $routes->get('(:num)', 'KelasSiswaController::show/$1');
    $routes->get('all', 'KelasSiswaController::all');
});

$routes->group('siswa', function(RouteCollection $routes){
    $routes->get('/', 'SiswaController::index');
    $routes->post('/', 'SiswaController::store');
    $routes->patch('/', 'SiswaController::update');
    $routes->delete('/', 'SiswaController::delete');
    $routes->get('(:num)', 'SiswaController::show/$1');
    $routes->get('all', 'SiswaController::all');
});



$routes->group('kehadiranguru', function(RouteCollection $routes){
    $routes->get('/', 'KehadiranGuruController::index');
    $routes->post('/', 'KehadiranGuruController::store');
    $routes->patch('/', 'KehadiranGuruController::update');
    $routes->delete('/', 'KehadiranGuruController::delete');
    $routes->get('(:num)', 'KehadiranGuruController::show/$1');
    $routes->get('all', 'KehadiranGuruController::all');
});

$routes->group('kehadiransiswa', function(RouteCollection $routes){
    $routes->get('/', 'KehadiranSiswaController::index');
    $routes->post('/', 'KehadiranSiswaController::store');
    $routes->patch('/', 'KehadiranSiswaController::update');
    $routes->delete('/', 'KehadiranSiswaController::delete');
    $routes->get('(:num)', 'KehadiranSiswaController::show/$1');
    $routes->get('all', 'KehadiranSiswaController::all');
});

$routes->group('jadwal', function(RouteCollection $routes){
    $routes->get('/', 'JadwalController::index');
    $routes->post('/', 'JadwalController::store');
    $routes->patch('/', 'JadwalController::update');
    $routes->delete('/', 'JadwalController::delete');
    $routes->get('(:num)', 'JadwalController::show/$1');
    $routes->get('all', 'JadwalController::all');
});

$routes->group('bagian', function(RouteCollection $routes){
    $routes->get('/', 'BagianController::index');
    $routes->post('/', 'BagianController::store');
    $routes->patch('/', 'BagianController::update');
    $routes->delete('/', 'BagianController::delete');
    $routes->get('(:num)', 'BagianController::show/$1');
    $routes->get('all', 'BagianController::all');
});
$routes->group('penilaian', function(RouteCollection $routes){
    $routes->get('/', 'PenilaianController::index');
    $routes->post('/', 'PenilaianController::store');
    $routes->patch('/', 'PenilaianController::update');
    $routes->delete('/', 'PenilaianController::delete');
    $routes->get('(:num)', 'PenilaianController::show/$1');
    $routes->get('all', 'PenilaianController::all');
});

$routes->group('rincianpenilaian', function(RouteCollection $routes){
    $routes->get('/', 'RincianPenilaianController::index');
    $routes->post('/', 'RincianPenilaianController::store');
    $routes->patch('/', 'RincianPenilaianController::update');
    $routes->delete('/', 'RincianPenilaianController::delete');
    $routes->get('(:num)', 'RincianPenilaianController::show/$1');
    $routes->get('all', 'RincianPenilaianController::all');
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

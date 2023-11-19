<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// login
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->post('/auth', 'Login::auth');

// home
$routes->get('/home', 'Home::index');

// menu
$routes->get('/menu', 'Menu::index');
if (session('role') == 'Root') {
    $routes->get('/menu/(:any)', 'Menu::index/$1');
}
$routes->post('/menu/add', 'Menu::add');
$routes->post('/menu/update', 'Menu::update');
$routes->post('/menu/update_check', 'Menu::update_check');
$routes->post('/menu/copy', 'Menu::copy');
$routes->post('/menu/delete', 'Menu::delete');

// crew
$routes->get('/crew', 'Crew::index');
$routes->post('/crew/add', 'Crew::add');
$routes->post('/crew/update', 'Crew::update');
$routes->post('/crew/delete', 'Crew::delete');

// tugas
$routes->get('/tugas', 'Tugas::index');
$routes->post('/tugas/add', 'Tugas::add');
$routes->post('/tugas/update', 'Tugas::update');
$routes->post('/tugas/delete', 'Tugas::delete');

// paket
$routes->get('/paket', 'Paket::index');
$routes->post('/paket/add', 'Paket::add');
$routes->post('/paket/update', 'Paket::update');
$routes->post('/paket/delete', 'Paket::delete');

// options
$routes->get('/options', 'Options::index');
if (session('role') == 'Root') {
    $routes->get('/options/(:any)', 'Options::index/$1');
}
$routes->post('/options/add', 'Options::add');
$routes->post('/options/update', 'Options::update');
$routes->post('/options/delete', 'Options::delete');

// settings
$routes->get('/settings', 'Settings::index');
$routes->post('/settings/update', 'Settings::update');


// job
$routes->get('/job', 'Job::index');
$routes->get('/job/(:any)/(:any)', 'Job::index/$1/$2');
$routes->post('/job/add', 'Job::add');
$routes->post('/job/update', 'Job::update');
$routes->post('/job/add_crew', 'Job::add_crew');
$routes->post('/job/update_crew', 'Job::update_crew');
$routes->post('/job/update_fee', 'Job::update_fee');
$routes->post('/job/update_ket', 'Job::update_ket');
$routes->post('/job/delete', 'Job::delete');
$routes->post('/job/delete_pengeluaran', 'Job::delete_pengeluaran');

// laporan
$routes->get('/laporan/cetak/(:any)/(:any)', 'Laporan::cetak/$1/$2');
$routes->get('/laporan', 'Laporan::index');
$routes->get('/laporan/(:any)/(:any)', 'Laporan::index/$1/$2');

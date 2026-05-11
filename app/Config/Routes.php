<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');

$routes->get('/register', 'Auth::registerStep1');
$routes->post('/register', 'Auth::storeStep1');
$routes->get('/register/health', 'Auth::registerStep2');
$routes->post('/register/health', 'Auth::storeStep2');

$routes->get('/profil', 'Profil::index');
$routes->post('/profil', 'Profil::update');

$routes->get('/imc', 'Imc::index');

$routes->get('/regimes', 'Regimes::index');
$routes->get('/regimes/(:num)', 'Regimes::show/$1');
$routes->post('/regimes/apply/(:num)', 'Regimes::apply/$1');

$routes->get('/activites', 'Activites::index');
$routes->get('/aliments', 'Aliments::index');

$routes->get('/portefeuille', 'Portefeuille::index');
$routes->post('/portefeuille/recharge', 'Portefeuille::recharge');

$routes->get('/gold', 'Gold::index');
$routes->post('/gold/subscribe', 'Gold::subscribe');
$routes->post('/gold/redeem', 'Gold::redeem');

$routes->get('/export', 'ExportProgramme::index');

$routes->get('/admin/login', 'AdminAuth::login');
$routes->post('/admin/login', 'AdminAuth::attempt');
$routes->get('/admin/logout', 'AdminAuth::logout');

$routes->get('/admin', 'AdminDashboard::index');

$routes->get('/admin/regimes', 'AdminRegimes::index');
$routes->get('/admin/regimes/create', 'AdminRegimes::create');
$routes->post('/admin/regimes/store', 'AdminRegimes::store');
$routes->get('/admin/regimes/edit/(:num)', 'AdminRegimes::edit/$1');
$routes->post('/admin/regimes/update/(:num)', 'AdminRegimes::update/$1');
$routes->post('/admin/regimes/delete/(:num)', 'AdminRegimes::delete/$1');

$routes->get('/admin/activites', 'AdminActivites::index');
$routes->get('/admin/activites/create', 'AdminActivites::create');
$routes->post('/admin/activites/store', 'AdminActivites::store');
$routes->get('/admin/activites/edit/(:num)', 'AdminActivites::edit/$1');
$routes->post('/admin/activites/update/(:num)', 'AdminActivites::update/$1');
$routes->post('/admin/activites/delete/(:num)', 'AdminActivites::delete/$1');

$routes->get('/admin/aliments', 'AdminAliments::index');
$routes->get('/admin/aliments/create', 'AdminAliments::create');
$routes->post('/admin/aliments/store', 'AdminAliments::store');
$routes->get('/admin/aliments/edit/(:num)', 'AdminAliments::edit/$1');
$routes->post('/admin/aliments/update/(:num)', 'AdminAliments::update/$1');
$routes->post('/admin/aliments/delete/(:num)', 'AdminAliments::delete/$1');

$routes->get('/admin/codes', 'AdminCodes::index');
$routes->post('/admin/codes/store', 'AdminCodes::store');
$routes->post('/admin/codes/disable/(:num)', 'AdminCodes::disable/$1');
$routes->post('/admin/codes/enable/(:num)', 'AdminCodes::enable/$1');

$routes->get('/admin/parametres', 'AdminParams::index');
$routes->post('/admin/parametres/update', 'AdminParams::update');

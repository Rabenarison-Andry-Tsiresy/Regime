<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Livres::index');

$routes->get('/livres', 'Livres::index');
$routes->get('/livres/(:num)', 'Livres::show/$1');
$routes->get('/livres/create', 'Livres::create');
$routes->post('/livres/store', 'Livres::store');
$routes->post('/livres/delete/(:num)', 'Livres::delete/$1');

$routes->post('/livres/pret/(:num)', 'Emprunts::pret/$1');
$routes->post('/livres/retour/(:num)', 'Emprunts::retour/$1');

<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/login', 'AuthController::index');
$routes->post('/auth/login', 'AuthController::login');
$routes->get('/dashboard', 'AuthController::dashboard');
$routes->get('/auth/logout', 'AuthController::logout');
// API route for Postman (no auth middleware)
$routes->post('/api/admin/create', 'UserController::createAdmin');

// Dashboard user management
$routes->get('/users',        'UserController::index');
$routes->get('/users/create', 'UserController::create');
$routes->post('/users/store', 'UserController::store');
$routes->get('/lablist', 'LabController::index');
$routes->get('/registerform', 'UserController::registerForm');
$routes->post('/labs/store', 'UserController::registerLab');
$routes->get('/labs/(:num)/pricelist',  'LabController::priceList/$1');
$routes->post('/labs/(:num)/pricelist', 'LabController::importPriceList/$1');
$routes->post('/labs/(:num)/pricelist/update', 'LabController::updatePriceList/$1');
$routes->get('/labs/(:num)/edit',  'LabController::edit/$1');
$routes->post('/labs/(:num)/edit', 'LabController::update/$1');
$routes->get('/labs/(:num)/phlebotomist', 'LabController::phlebotomist/$1');
$routes->post('/labs/(:num)/phlebotomist', 'LabController::importPhlebotomist/$1');
$routes->post('/labs/(:num)/phlebotomist/add', 'LabController::addPhlebotomist/$1');
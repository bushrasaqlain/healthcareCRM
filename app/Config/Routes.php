<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'AuthController::index');
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


 // Booking
$routes->get('/booking/new',        'BookingController::index');
$routes->post('booking/add', 'BookingController::add_booking');
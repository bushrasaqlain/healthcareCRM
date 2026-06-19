<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'AuthController::index');
$routes->get('/login', 'AuthController::index');
$routes->post('/auth/login', 'AuthController::login');
$routes->get('/dbadmin/dashboard', 'AuthController::dashboard');
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


 // Booking
$routes->get('/booking/new', 'BookingController::index');
$routes->post('booking/add', 'BookingController::add_booking');

$routes->post('/labs/store', 'UserController::registerLab');
$routes->get('/labs/(:num)/pricelist',  'LabController::priceList/$1');
$routes->post('/labs/(:num)/pricelist', 'LabController::importPriceList/$1');

// Lab Dashboard Routes

$routes->get('/labDashboard/dashboard', 'BookingController::dashboard');
$routes->get('/booking/view/(:num)', 'BookingController::viewBooking/$1');

// Invoice routes
// Booking routes
$routes->get('booking/invoice/(:num)', 'BookingController::viewInvoice/$1');
$routes->get('booking/sharedInvoice/(:num)/(:any)', 'BookingController::sharedInvoice/$1/$2');
$routes->post('booking/generateShareLink/(:num)', 'BookingController::generateShareLink/$1');
$routes->post('booking/regenerateShareLink/(:num)', 'BookingController::regenerateShareLink/$1');
$routes->get('booking/editTests/(:num)',    'BookingController::editTests/$1');
$routes->post('booking/updateTests/(:num)', 'BookingController::updateTests/$1');
 $routes->get('booking/status/(:num)/(:any)', 'BookingController::updateStatus/$1/$2');
 $routes->post('booking/uploadReport/(:num)', 'BookingController::uploadReport/$1');
 
$routes->post('booking/markPaymentPaid/(:num)', 'BookingController::markPaymentPaid/$1');

$routes->post('booking/saveNotes/(:num)', 'BookingController::saveNotes/$1');
$routes->get('booking/editTests/(:num)',    'BookingController::editTests/$1');
$routes->post('booking/updateTests/(:num)', 'BookingController::updateTests/$1');
 $routes->post('booking/assignPhlebotomist/(:num)', 'BookingController::assignPhlebotomist/$1');
 $routes->get('/labDashboard/pricelist', 'LabController::labPriceList');
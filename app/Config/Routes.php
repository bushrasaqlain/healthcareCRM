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


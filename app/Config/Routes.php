<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Jengo Dashboard Route
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'session']);


// Jengo Auth Authentication Routes
service('auth')->routes($routes);

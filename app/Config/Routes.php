<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->post('logout', 'Auth::logout');

$routes->get('dashboard', 'Dashboard::index');

// Products
$routes->get('products', 'Product::index');
$routes->get('products/create', 'Product::create');
$routes->post('products/store', 'Product::store');
$routes->get('products/edit/(:num)', 'Product::edit/$1');
$routes->post('products/update/(:num)', 'Product::update/$1');
$routes->post('products/delete/(:num)', 'Product::delete/$1');

// Customers
$routes->get('customers', 'Customer::index');
$routes->get('customers/create', 'Customer::create');
$routes->post('customers/store', 'Customer::store');
$routes->get('customers/edit/(:num)', 'Customer::edit/$1');
$routes->post('customers/update/(:num)', 'Customer::update/$1');
$routes->post('customers/delete/(:num)', 'Customer::delete/$1');

// Staff
$routes->get('staff', 'Staff::index');
$routes->get('staff/create', 'Staff::create');
$routes->post('staff/store', 'Staff::store');
$routes->get('staff/edit/(:num)', 'Staff::edit/$1');
$routes->post('staff/update/(:num)', 'Staff::update/$1');
$routes->post('staff/delete/(:num)', 'Staff::delete/$1');

// Sales
$routes->get('sales/create', 'Sale::create');
$routes->post('sales/store', 'Sale::store');
$routes->get('sales/history', 'Sale::history');
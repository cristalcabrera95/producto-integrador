<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Página principal y autenticación
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Home::dashboard');

// Autenticación
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');
$routes->get('/user/profile', 'User::profile');

// Gestión de usuarios (solo admin)
$routes->get('/users/list', 'User::list');
$routes->get('/users/create', 'User::create');
$routes->post('/users/store', 'User::store');
$routes->get('/users/edit/(:num)', 'User::edit/$1');
$routes->post('/users/update/(:num)', 'User::update/$1');
$routes->get('/users/delete/(:num)', 'User::delete/$1');

// Galería de imágenes
$routes->get('/images', 'Image::index');
$routes->post('/images/upload', 'Image::upload');
$routes->get('/images/delete/(:num)', 'Image::delete/$1');
$routes->post('/images/update-metadata', 'Image::updateMetadata');
$routes->get('/images/view/(:num)', 'Image::view/$1');

// Panel de administración (solo admin)
$routes->get('/images/admin-panel', 'Image::adminPanel');

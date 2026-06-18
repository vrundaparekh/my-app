<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('register', 'AuthController::showRegisterForm');
$routes->post('register', 'AuthController::register');
$routes->get('login', 'AuthController::showLoginForm');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');
$routes->get('/', 'AuthController::showLoginForm');
$routes->get('forgot-password', 'AuthController::forgotPassword');
$routes->post('forgot-password', 'AuthController::processForgot');

$routes->get('reset-password/(:any)', 'AuthController::resetPassword/$1');
$routes->post('reset-password/(:any)', 'AuthController::processReset/$1');



$routes->group('admin', ['filter' => 'auth:1'], function($routes) {
    $routes->get('dashboard', 'AdminController::index');
    $routes->post('users/store', 'AdminController::store');
    $routes->post('users/search', 'AdminController::search');
    $routes->get('users/view/(:num)', 'AdminController::view/$1');
    $routes->get('users/edit/(:num)', 'AdminController::edit/$1');
    $routes->post('users/update/(:num)', 'AdminController::update/$1');
    $routes->post('users/delete/(:num)', 'AdminController::delete/$1');

    $routes->get('export/excel', 'AdminController::exportExcel');
    $routes->get('export/pdf', 'AdminController::exportPdf');

    $routes->get('healthcare-assistant', 'AdminController::healthcareAssistant');
});

$routes->group('user', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'UserController::index');
});

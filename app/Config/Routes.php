<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index'); // Root URL ( localhost:8080 )
$routes->post('login', 'LoginController::login');

$routes->get('register', 'RegistrationController::index');
$routes->post('register', 'RegistrationController::register');

$routes->get('homepage', 'HomepageController::index');
$routes->get('logout', 'HomepageController::logout'); 
// $routes->post('homepage', 'HomepageController::register');

// $routes->get('/pages', 'Pages::index'); 
$routes->get('pages', [Pages::class, 'index']); // Static URL ( localhost:8080/page )
$routes->get('(:segment)', [Pages::class, 'view']); // Dynamic URL ( localhost:8080/page1 or /page2 or /page3 )



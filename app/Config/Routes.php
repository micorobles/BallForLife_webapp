<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index'); // Root URL ( localhost:8080 )
// $routes->get('/pages', 'Pages::index'); 
$routes->get('pages', [Pages::class, 'index']); // Static URL ( localhost:8080/page )
$routes->get('(:segment)', [Pages::class, 'view']); // Dynamic URL ( localhost:8080/page1 or /page2 or /page3 )

$routes->post('login', 'Login::login');
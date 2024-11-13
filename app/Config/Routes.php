<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AccountController::index'); // Root URL ( localhost:8080 )
$routes->post('login', 'AccountController::login');
$routes->get('getUser/(:num)', 'AccountController::getUser/$1');

$routes->get('userMaster', 'UserMasterController::index');
$routes->post('getUserList', 'UserMasterController::getUserList');
$routes->post('modifyUser/(:num)', 'UserMasterController::modifyUserStatusOrPassword/$1');

$routes->get('registration', 'AccountController::registration');
$routes->post('register', 'AccountController::register');

$routes->get('profile/(:num)', 'AccountController::profile/$1');
// $routes->get('profile', 'AccountController::profile');
$routes->post('editProfile', 'AccountController::editProfile');

$routes->get('homepage', 'HomepageController::index');
$routes->get('logout', 'HomepageController::logout'); 
// $routes->post('homepage', 'HomepageController::register');

$routes->get('schedule', 'ScheduleController::index');


// $routes->get('/pages', 'Pages::index'); 
$routes->get('pages', [Pages::class, 'index']); // Static URL ( localhost:8080/page )
$routes->get('(:segment)', [Pages::class, 'view']); // Dynamic URL ( localhost:8080/page1 or /page2 or /page3 )



<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;

/**
 * @var RouteCollection $routes
 */
// $routes->group('admin', ['filter' => 'auth:Admin'], function($routes) {

// });

$routes->get('/', 'AccountController::index'); // Root URL ( localhost:8080 )
$routes->post('login', 'AccountController::login');
$routes->post('google', 'AccountController::google');
$routes->get('getUser/(:num)', 'AccountController::getUser/$1', ['filter' => 'auth:Admin,User']);
$routes->get('profile/(:num)', 'AccountController::profile/$1', ['filter' => 'auth:Admin,User']);
$routes->post('editProfile', 'AccountController::editProfile', ['filter' => 'auth:Admin,User']);
$routes->get('registration', 'AccountController::registration', ['filter' => 'auth:User']);
$routes->post('register', 'AccountController::register', ['filter' => 'auth:User']);

$routes->get('userMaster', 'UserMasterController::index', ['filter' => 'auth:Admin']);
$routes->post('getUserList', 'UserMasterController::getUserList', ['filter' => 'auth:Admin']);
$routes->post('modifyUser/(:num)', 'UserMasterController::modifyUserStatusOrPassword/$1', ['filter' => 'auth:Admin']);
$routes->post('deleteUser/(:num)', 'UserMasterController::deleteUser/$1', ['filter' => 'auth:Admin']);

$routes->get('scheduleMaster', 'ScheduleMasterController::index', ['filter' => 'auth:Admin']);
$routes->post('createSchedule', 'ScheduleMasterController::createSchedule', ['filter' => 'auth:Admin']);
$routes->get('getAllSchedule', 'ScheduleMasterController::getAllSchedule', ['filter' => 'auth:Admin']);
$routes->get('getSingleSchedule/(:num)', 'ScheduleMasterController::getSingleSchedule/$1', ['filter' => 'auth:Admin']);
$routes->post('editSchedule/(:num)', 'ScheduleMasterController::editSchedule/$1', ['filter' => 'auth:Admin']);
// $routes->get('profile', 'AccountController::profile');

$routes->get('homepage', 'HomepageController::index', ['filter' => 'auth:Admin,User']);
$routes->get('logout', 'HomepageController::logout', ['filter' => 'auth:Admin,User']); 
// $routes->post('homepage', 'HomepageController::register');

// $routes->get('schedule', 'ScheduleController::index', ['filter' => 'auth:Admin']);

$routes->get('unauthorized', 'AccountController::unauthorized');
// $routes->get('/pages', 'Pages::index'); 
// $routes->get('pages', [Pages::class, 'index']); // Static URL ( localhost:8080/page )
// $routes->get('(:segment)', [Pages::class, 'view']); // Dynamic URL ( localhost:8080/page1 or /page2 or /page3 )



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
$routes->get('registration', 'AccountController::registration');
$routes->post('register', 'AccountController::register');
$routes->post('verifyEmail', 'AccountController::verifyEmail');
$routes->post('verifyOTP', 'AccountController::verifyOTP');
$routes->post('changePassword', 'AccountController::changePassword');

$routes->get('userMaster', 'UserMasterController::index', ['filter' => 'auth:Admin']);
$routes->post('getUserList', 'UserMasterController::getUserList', ['filter' => 'auth:Admin']);
$routes->post('modifyUser/(:num)', 'UserMasterController::modifyUserStatusOrPassword/$1', ['filter' => 'auth:Admin']);
$routes->post('deleteUser/(:num)', 'UserMasterController::deleteUser/$1', ['filter' => 'auth:Admin']);
$routes->post('acceptUser/(:num)', 'UserMasterController::acceptUser/$1', ['filter' => 'auth:Admin']);

$routes->get('scheduleMaster', 'ScheduleMasterController::index', ['filter' => 'auth:Admin']);
$routes->post('createSchedule', 'ScheduleMasterController::createSchedule', ['filter' => 'auth:Admin']);
$routes->get('getAllSchedule', 'ScheduleMasterController::getAllSchedule', ['filter' => 'auth:Admin']);
$routes->get('getSingleSchedule/(:num)', 'ScheduleMasterController::getSingleSchedule/$1', ['filter' => 'auth:Admin']);
$routes->get('getWidgetsData', 'ScheduleMasterController::getWidgetsData', ['filter' => 'auth:Admin']);
$routes->post('editSchedule/(:num)', 'ScheduleMasterController::editSchedule/$1', ['filter' => 'auth:Admin']);
$routes->post('deleteSchedule/(:num)', 'ScheduleMasterController::deleteSchedule/$1', ['filter' => 'auth:Admin']);
$routes->post('getScheduleAppointments/(:num)', 'ScheduleMasterController::getScheduleAppointments/$1', ['filter' => 'auth:Admin']);
$routes->post('appointmentApproval/(:num)/(:segment)', 'ScheduleMasterController::appointmentApproval/$1/$2', ['filter' => 'auth:Admin']);

$routes->get('schedules', 'ScheduleController::index', ['filter' => 'auth:Admin,User']);
$routes->get('getAllScheduleToUsers', 'ScheduleController::getAllScheduleToUsers', ['filter' => 'auth:Admin,User']);
$routes->post('bookSchedule', 'ScheduleController::bookSchedule', ['filter' => 'auth:Admin,User']);

$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth:Admin,User']);
$routes->get('logout', 'DashboardController::logout', ['filter' => 'auth:Admin,User']); 

// $routes->post('homepage', 'HomepageController::register');

// $routes->get('schedule', 'ScheduleController::index', ['filter' => 'auth:Admin']);

$routes->get('unauthorized', 'AccountController::unauthorized');
// $routes->get('/pages', 'Pages::index'); 
// $routes->get('pages', [Pages::class, 'index']); // Static URL ( localhost:8080/page )
// $routes->get('(:segment)', [Pages::class, 'view']); // Dynamic URL ( localhost:8080/page1 or /page2 or /page3 )



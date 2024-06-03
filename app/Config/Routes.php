<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login-check', 'Auth::checkLogin');
$routes->get('/auth/logout', 'Auth::logout');




//Tuition Type
$routes->get('/admin/tuition', 'Admin::tuition');
$routes->get('/admin/create-tuition', 'Admin::createTuition');
$routes->post('/admin/save-new-tuition', 'Admin::saveNewTuition');






$routes->group('admin', ['filter' => 'authCheck'], function($routes) {
    //Dashboard 
    $routes->get('dashboard', 'Admin::dashboard');

    //attendance
    $routes->get('attendance/(:num)', 'Admin::attendance/$1');
    $routes->post('add-attendance', 'Admin::addAttendance');
    $routes->post('add-attendance-api', 'Admin::addAttendanceAPI');
    $routes->get('get-attendance/(:num)', 'Admin::getAttendance/$1');
    $routes->get('get-class/(:num)', 'Admin::listOfClass/$1');

    //Invoice
    $routes->get('invoice/(:num)', 'Admin::invoice/$1');
    $routes->get('delete-invoice/(:num)', 'Admin::deletePayment/$1');
    $routes->post('send-invoice', 'Admin::sendMail');

    //Users
    $routes->get('users', 'Admin::users');
    $routes->get('create-users', 'Admin::createUsers');
    $routes->post('save-new-users', 'Admin::saveNewUsers');
    $routes->post('delete-users', 'Admin::deleteUsers');
    $routes->get('edit-users/(:num)', 'Admin::editUsers/$1');
    $routes->post('save-users', 'Admin::saveUsers');

    //Payment
    $routes->get('payment', 'Admin::payment');
    $routes->get('create-payment', 'Admin::createPayment');
    $routes->post('save-new-payment', 'Admin::saveNewPayment');
    $routes->get('edit-payment/(:num)', 'Admin::editPayment/$1');
    $routes->post('save-payment', 'Admin::savePayment');
    $routes->get('dt-payment', 'DataTable::invoice');

    //Currency
    $routes->get('currency', 'Admin::currency');
    $routes->get('create-currency', 'Admin::createCurrency');
    $routes->post('save-new-currency', 'Admin::saveNewCurrency');
    $routes->get('delete-currency/(:num)', 'Admin::deleteCurrency/$1');

    //Student
    $routes->get('student', 'Admin::student');
    $routes->get('create-student', 'Admin::createStudent');
    $routes->post('save-new-student', 'Admin::saveNewStudent');
    $routes->get('delete-student/(:num)', 'Admin::deleteStudent/$1');
    $routes->get('edit-student/(:num)', 'Admin::editStudent/$1');
    $routes->post('save-student', 'Admin::saveStudent');
    $routes->get('import-student', 'Admin::importStudent');
    $routes->post('get-imported-student', 'Admin::getImported');
    $routes->get('dt-student', 'DataTable::student');

    //Class
    $routes->get('class', 'Admin::class');
    $routes->get('create-class', 'Admin::createClass');
    $routes->post('save-new-class', 'Admin::saveNewClass');
    $routes->get('delete-class/(:num)', 'Admin::deleteClass/$1');
    $routes->get('edit-class/(:num)', 'Admin::editClass/$1');
    $routes->post('save-class', 'Admin::saveClass');

    //Branch
    $routes->get('branch', 'Admin::branch');
    $routes->get('create-branch', 'Admin::createBranch');
    $routes->post('save-new-branch', 'Admin::saveNewBranch');
    $routes->get('delete-branch/(:num)', 'Admin::deleteBranch/$1');
    $routes->get('edit-branch/(:num)', 'Admin::editBranch/$1');
    $routes->post('save-branch', 'Admin::saveBranch');
});
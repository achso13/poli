<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// Routes Auth
$routes->get('/auth', 'Auth::index');
$routes->get('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');
$routes->post('/auth/verifying', 'Auth::verifying');

// Routes Users
$routes->get('/users', 'Users::index');
$routes->get('/users/role/(:num)', 'Users::role/$1');
$routes->match(['get', 'post'], '/users/add', 'Users::add');
$routes->post('/users/store', 'Users::store');
$routes->match(['get', 'post'], '/users/edit', 'Users::edit');
$routes->post('/users/update', 'Users::update');
$routes->delete('/users/delete/(:num)', 'Users::delete/$1');

// Routes Medicine
$routes->get('/medicine', 'Medicine::index');
$routes->get('/medicine/role/(:num)', 'Medicine::role/$1');
$routes->match(['get', 'post'], '/medicine/add', 'Medicine::add');
$routes->post('/medicine/store', 'Medicine::store');
$routes->match(['get', 'post'], '/medicine/edit', 'Medicine::edit');
$routes->post('/medicine/update', 'Medicine::update');
$routes->delete('/medicine/delete/(:num)', 'Medicine::delete/$1');

// Routes Clinic
$routes->get('/clinic', 'Clinic::index');
$routes->get('/clinic/role/(:num)', 'Clinic::role/$1');
$routes->match(['get', 'post'], '/clinic/add', 'Clinic::add');
$routes->post('/clinic/store', 'Clinic::store');
$routes->match(['get', 'post'], '/clinic/edit', 'Clinic::edit');
$routes->post('/clinic/update', 'Clinic::update');
$routes->delete('/clinic/delete/(:num)', 'Clinic::delete/$1');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

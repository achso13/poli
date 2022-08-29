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
$routes->get('/users/role/(:alpha)', 'Users::role/$1');
$routes->match(['get', 'post'], '/users/add', 'Users::add');
$routes->post('/users/store', 'Users::store');
$routes->match(['get', 'post'], '/users/edit', 'Users::edit');
$routes->post('/users/update', 'Users::update');
$routes->delete('/users/delete/(:num)', 'Users::delete/$1');

// Routes Medicine
$routes->get('/medicine', 'Medicine::index');
$routes->match(['get', 'post'], '/medicine/add', 'Medicine::add');
$routes->post('/medicine/store', 'Medicine::store');
$routes->match(['get', 'post'], '/medicine/edit', 'Medicine::edit');
$routes->post('/medicine/update', 'Medicine::update');
$routes->delete('/medicine/delete/(:segment)', 'Medicine::delete/$1');

// Routes Clinic
$routes->get('/clinic', 'Clinic::index');
$routes->match(['get', 'post'], '/clinic/add', 'Clinic::add');
$routes->post('/clinic/store', 'Clinic::store');
$routes->match(['get', 'post'], '/clinic/edit', 'Clinic::edit');
$routes->post('/clinic/update', 'Clinic::update');
$routes->delete('/clinic/delete/(:segment)', 'Clinic::delete/$1');

// Routes Doctor
$routes->get('/doctor', 'Doctor::index');
$routes->match(['get', 'post'], '/doctor/add', 'Doctor::add');
$routes->post('/doctor/store', 'Doctor::store');
$routes->match(['get', 'post'], '/doctor/edit', 'Doctor::edit');
$routes->post('/doctor/update', 'Doctor::update');
$routes->delete('/doctor/delete/(:segment)', 'Doctor::delete/$1');

// Routes Jadwal Dokter
$routes->get('/doctor/jadwal', 'JadwalDokter::index');
$routes->match(['get', 'post'], '/doctor/jadwal/add', 'JadwalDokter::add');
$routes->post('/doctor/jadwal/store', 'JadwalDokter::store');
$routes->match(['get', 'post'], '/doctor/jadwal/edit', 'JadwalDokter::edit');
$routes->post('/doctor/jadwal/update', 'JadwalDokter::update');
$routes->delete('/doctor/jadwal/delete/(:segment)', 'JadwalDokter::delete/$1');
$routes->get('/doctor/jadwal/get_jadwal/(:segment)', 'JadwalDokter::ajaxJadwalDokter/$1');


// Routes Patient
$routes->get('/patient', 'Patient::index');
$routes->match(['get', 'post'], '/patient/add', 'Patient::add');
$routes->post('/patient/store', 'Patient::store');
$routes->match(['get', 'post'], '/patient/edit', 'Patient::edit');
$routes->post('/patient/update', 'Patient::update');
$routes->delete('/patient/delete/(:segment)', 'Patient::delete/$1');
$routes->get('/patient/rekam_medis', 'RekamMedis::rekamMedisPasien');
$routes->get('/patient/rekam_medis/(:segment)', 'RekamMedis::index/$1');

// Routes Treatment
$routes->get('/treatment', 'Treatment::index');
$routes->match(['get', 'post'], '/treatment/add', 'Treatment::add');
$routes->post('/treatment/store', 'Treatment::store');
$routes->match(['get', 'post'], '/treatment/edit', 'Treatment::edit');
$routes->post('/treatment/update', 'Treatment::update');
$routes->delete('/treatment/delete/(:segment)', 'Treatment::delete/$1');

// routes unitkerja
$routes->get('/unitkerja', 'UnitKerja::index');
$routes->get('/unitkerja/get_bagian/(:num)', 'Unitkerja::ajaxBagian/$1');

// routes bagian
$routes->get('/unitkerja/bagian', 'UnitKerja::bagian');
$routes->match(['get', 'post'], '/unitkerja/bagian/add', 'UnitKerja::add');
$routes->post('/unitkerja/bagian/store', 'UnitKerja::store');
$routes->match(['get', 'post'], '/unitkerja/bagian/edit', 'UnitKerja::edit');
$routes->post('/unitkerja/bagian/update', 'UnitKerja::update');
$routes->delete('/unitkerja/bagian/delete/(:segment)', 'UnitKerja::delete/$1');

// routes biro
$routes->get('/unitkerja/biro', 'Biro::index');
$routes->match(['get', 'post'], '/unitkerja/biro/add', 'Biro::add');
$routes->post('/unitkerja/biro/store', 'Biro::store');
$routes->match(['get', 'post'], '/unitkerja/biro/edit', 'Biro::edit');
$routes->post('/unitkerja/biro/update', 'Biro::update');
$routes->delete('/unitkerja/biro/delete/(:segment)', 'Biro::delete/$1');

// routes appointment
$routes->get('/appointment', 'Appointment::index');
$routes->match(['get', 'post'], '/appointment/form', 'Appointment::add');
$routes->post('/appointment/store', 'Appointment::store');
$routes->match(['get', 'post'], '/appointment/edit', 'Appointment::edit');
$routes->post('/appointment/update', 'Appointment::update');
$routes->delete('/appointment/delete/(:segment)', 'Appointment::delete/$1');
$routes->get('/appointment/view/(:segment)', 'Appointment::view/$1');
$routes->get('/appointment/status/(:segment)/(:segment)', 'Appointment::status/$1/$2');

// routes rekammedis
$routes->get('/rekam_medis', 'RekamMedis::index');
$routes->match(['get', 'post'], '/rekam_medis/form', 'RekamMedis::add');
$routes->post('/rekam_medis/store', 'RekamMedis::store');
$routes->match(['get', 'post'], '/rekam_medis/edit', 'RekamMedis::edit');
$routes->post('/rekam_medis/update', 'RekamMedis::update');
$routes->delete('/rekam_medis/delete/(:segment)', 'RekamMedis::delete/$1');
$routes->get('/rekam_medis/view/(:segment)', 'RekamMedis::view/$1');

// Routes Treatment Schedule
$routes->get('/treatment_schedule', 'RekamMedis::treatmentSchedule');
$routes->get('/treatment_schedule/(:segment)', 'RekamMedis::viewTreatmentSchedule/$1');
$routes->match(['get', 'post'], '/treatment_schedule/store', 'RekamMedis::storeTreatmentSchedule');

// Routes Resep
$routes->get('/resep', 'Resep::index');
$routes->match(['get', 'post'], '/resep/add', 'Resep::add');
$routes->post('/resep/store', 'Resep::store');
$routes->match(['get', 'post'], '/resep/edit', 'Resep::edit');
$routes->post('/resep/update', 'Resep::update');
$routes->delete('/resep/delete/(:segment)', 'Resep::delete/$1');
$routes->get('/resep/view/(:segment)', 'Resep::view/$1');
$routes->match(['get', 'post'], '/resep/status', 'Resep::statusForm');
$routes->post('/resep/status/store', 'Resep::statusStore');
$routes->post('/resep/get_obat', 'Resep::ajaxObat');

// Routes Tiket
$routes->get('/tiket', 'Tiket::index');
$routes->match(['get', 'post'], '/tiket/form', 'Tiket::form');
$routes->post('/tiket/store', 'Tiket::store');
$routes->get('/tiket/view/(:segment)', 'Tiket::view/$1');
$routes->post('/tiket/form_comment', 'Tiket::form_comment');
$routes->post('/tiket/store_comment', 'Tiket::store_comment');
$routes->get('/tiket/status/(:segment)/(:segment)', 'Tiket::status/$1/$2');

// Routes Profile
$routes->get('/profile', 'Profile::index');
$routes->match(['get', 'post'], '/profile/update', 'Profile::update');

// Routes Export
$routes->get('/export/kunjungan', 'Export::kunjungan');
$routes->get('/export/tiket', 'Export::tiket');
$routes->get('/export/resep', 'Export::resep');
$routes->get('/export/obat', 'Export::obat');



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

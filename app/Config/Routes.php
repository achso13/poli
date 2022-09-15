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
$routes->group('users', ['filter' => 'role:ADMIN'], static function ($routes) {
    $routes->get('', 'Users::index');
    $routes->get('role/(:alpha)', 'Users::role/$1');
    $routes->match(['get', 'post'], 'add', 'Users::add');
    $routes->post('store', 'Users::store');
    $routes->match(['get', 'post'], 'edit', 'Users::edit');
    $routes->post('update', 'Users::update');
    $routes->delete('delete/(:num)', 'Users::delete/$1');
});

// Routes Medicine
$routes->group('medicine', ['filter' => 'role:ADMIN,APOTEKER'], static function ($routes) {
    $routes->get('/', 'Medicine::index');
    $routes->match(['get', 'post'], 'add', 'Medicine::add');
    $routes->post('store', 'Medicine::store');
    $routes->match(['get', 'post'], 'edit', 'Medicine::edit');
    $routes->post('update', 'Medicine::update');
    $routes->delete('delete/(:segment)', 'Medicine::delete/$1');
});

// Routes Clinic
$routes->group('clinic', ['filter' => 'role:ADMIN'], static function ($routes) {
    $routes->get('/', 'Clinic::index');
    $routes->match(['get', 'post'], 'add', 'Clinic::add');
    $routes->post('store', 'Clinic::store');
    $routes->match(['get', 'post'], 'edit', 'Clinic::edit');
    $routes->post('update', 'Clinic::update');
    $routes->delete('delete/(:segment)', 'Clinic::delete/$1');
});

// Routes Doctor
$routes->group('doctor', ['filter' => 'role:ADMIN'], static function ($routes) {
    $routes->get('/', 'Doctor::index');
    $routes->match(['get', 'post'], 'add', 'Doctor::add');
    $routes->post('store', 'Doctor::store');
    $routes->match(['get', 'post'], 'edit', 'Doctor::edit');
    $routes->post('update', 'Doctor::update');
    $routes->delete('delete/(:segment)', 'Doctor::delete/$1');
});

// Routes Jadwal Dokter
$routes->group('doctor/jadwal', ['filter' => 'role:ADMIN'], static function ($routes) {
    $routes->get('/', 'JadwalDokter::index');
    $routes->match(['get', 'post'], 'add', 'JadwalDokter::add');
    $routes->post('store', 'JadwalDokter::store');
    $routes->match(['get', 'post'], 'edit', 'JadwalDokter::edit');
    $routes->post('update', 'JadwalDokter::update');
    $routes->delete('delete/(:segment)', 'JadwalDokter::delete/$1');
});

$routes->get('/doctor/jadwal/get_jadwal/(:segment)', 'JadwalDokter::ajaxJadwalDokter/$1');


// Routes Patient
$routes->group('patient', ['filter' => 'role:ADMIN,DOKTER,KLINIK'], static function ($routes) {
    $routes->get('/', 'Patient::index');
});

$routes->group('patient', ['filter' => 'role:ADMIN'], static function ($routes) {
    $routes->match(['get', 'post'], 'add', 'Patient::add');
    $routes->post('store', 'Patient::store');
    $routes->match(['get', 'post'], 'edit', 'Patient::edit');
    $routes->post('update', 'Patient::update');
    $routes->delete('delete/(:segment)', 'Patient::delete/$1');
});


// Routes Treatment
$routes->group('treatment', ['filter' => 'role:ADMIN,KLINIK'], static function ($routes) {
    $routes->get('/', 'Treatment::index');
    $routes->match(['get', 'post'], 'add', 'Treatment::add');
    $routes->post('store', 'Treatment::store');
    $routes->match(['get', 'post'], 'edit', 'Treatment::edit');
    $routes->post('update', 'Treatment::update');
    $routes->delete('delete/(:segment)', 'Treatment::delete/$1');
});

// routes unitkerja
$routes->group('unitkerja', ['filter' => 'role:ADMIN'], static function ($routes) {
    $routes->get('/', 'UnitKerja::index', ['filter' => 'role:ADMIN']);

    // routes bagian
    $routes->get('bagian', 'UnitKerja::bagian');
    $routes->match(['get', 'post'], 'bagian/add', 'UnitKerja::add');
    $routes->post('bagian/store', 'UnitKerja::store');
    $routes->match(['get', 'post'], 'bagian/edit', 'UnitKerja::edit');
    $routes->post('bagian/update', 'UnitKerja::update');
    $routes->delete('bagian/delete/(:segment)', 'UnitKerja::delete/$1');

    // routes biro
    $routes->get('biro', 'Biro::index');
    $routes->match(['get', 'post'], 'biro/add', 'Biro::add');
    $routes->post('biro/store', 'Biro::store');
    $routes->match(['get', 'post'], 'biro/edit', 'Biro::edit');
    $routes->post('biro/update', 'Biro::update');
    $routes->delete('biro/delete/(:segment)', 'Biro::delete/$1');
});

$routes->get('/unitkerja/get_bagian/(:num)', 'Unitkerja::ajaxBagian/$1');

// routes appointment

$routes->group('appointment', ['filter' => 'role:ADMIN,DOKTER,PASIEN'], static function ($routes) {
    $routes->get('/', 'Appointment::index');
    $routes->get('view/(:segment)', 'Appointment::view/$1');
    $routes->match(['get', 'post'], 'add', 'Appointment::add');
    $routes->post('store', 'Appointment::store');
    $routes->match(['get', 'post'], 'edit', 'Appointment::edit');
    $routes->post('update', 'Appointment::update');
    $routes->delete('delete/(:segment)', 'Appointment::delete/$1');
    $routes->get('/appointment/status/(:segment)/(:segment)', 'Appointment::status/$1/$2');
});

// Routes Rekam Medis
$routes->group('rekam_medis', ['filter' => 'role:ADMIN,DOKTER,KLINIK'], static function ($routes) {
    $routes->get('(:segment)', 'RekamMedis::index/$1');
    $routes->match(['get', 'post'], 'form', 'RekamMedis::add');
    $routes->post('store', 'RekamMedis::store');
    $routes->match(['get', 'post'], 'edit', 'RekamMedis::edit');
    $routes->post('update', 'RekamMedis::update');
    $routes->delete('delete/(:segment)', 'RekamMedis::delete/$1');
});

$routes->get('/rekam_medis', 'RekamMedis::rekamMedisPasien', ['filter' => 'role:PASIEN']);

// Routes Treatment Schedule
$routes->group('treatment_schedule', ['filter' => 'role:KLINIK,PASIEN'], static function ($routes) {
    $routes->get('/', 'RekamMedis::treatmentSchedule');
    $routes->get('(:segment)', 'RekamMedis::viewTreatmentSchedule/$1');
});
$routes->match(['get', 'post'], 'store', 'RekamMedis::storeTreatmentSchedule', ['filter' => 'role:KLINIK']);

// Routes Resep
$routes->get('/resep', 'Resep::index', ['filter' => 'role:APOTEKER,PASIEN']);

$routes->group('resep', ['filter' => 'role:APOTEKER'], static function ($routes) {
    $routes->match(['get', 'post'], 'add', 'Resep::add');
    $routes->post('store', 'Resep::store');
    $routes->match(['get', 'post'], 'edit', 'Resep::edit');
    $routes->post('update', 'Resep::update');
    $routes->delete('delete/(:segment)', 'Resep::delete/$1');
    $routes->get('view/(:segment)', 'Resep::view/$1');
    $routes->match(['get', 'post'], 'status', 'Resep::statusForm');
    $routes->post('status/store', 'Resep::statusStore');
});

$routes->post('/resep/get_obat', 'Resep::ajaxObat');

// Routes Tiket
$routes->group('tiket', ['filter' => 'role:ADMIN,PASIEN,DOKTER'], static function ($routes) {
    $routes->get('/', 'Tiket::index');
    $routes->get('view/(:segment)', 'Tiket::view/$1');
    $routes->match(['get', 'post'], 'add', 'Tiket::form');
    $routes->post('store', 'Tiket::store');
    $routes->get('view/(:segment)', 'Tiket::view/$1');
    $routes->post('form_comment', 'Tiket::form_comment');
    $routes->post('store_comment', 'Tiket::store_comment');
    $routes->get('status/(:segment)/(:segment)', 'Tiket::status/$1/$2');
});

// Routes Profile
$routes->get('/profile', 'Profile::index');
$routes->match(['get', 'post'], '/profile/update', 'Profile::update');

// Routes Export
$routes->get('/laporan', 'Export::laporan', ['filter' => 'role:ADMIN']);
$routes->post('/laporan/export', 'Export::export', ['filter' => 'role:ADMIN']);
$routes->group('export', ['filter' => 'role:ADMIN'], static function ($routes) {
    $routes->get('kunjungan', 'Export::kunjungan');
    $routes->get('tiket', 'Export::tiket');
    $routes->get('resep', 'Export::resep');
    $routes->get('obat', 'Export::obat');
});




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

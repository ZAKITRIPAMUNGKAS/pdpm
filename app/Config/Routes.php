<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --------------------------------------------------------------------
// Route Definitions
// --------------------------------------------------------------------

// Default route configuration
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// --------------------------------------------------------------------
// RUTE HALAMAN PUBLIK
// --------------------------------------------------------------------
$routes->get('/', 'HomeController::index');
$routes->get('/berita', 'HomeController::berita'); // List all berita
$routes->get('/berita/(:segment)', 'HomeController::beritaDetail/$1');
$routes->get('/agenda', 'HomeController::agenda'); // ADDED: Route for Agenda page

$routes->get('/galeri', 'HomeController::galeri');
$routes->get('/profil', 'HomeController::profil');
$routes->get('/kontak', 'HomeController::kontak');

// Dynamic Sitemap and SEO routes
$routes->get('sitemap.xml', 'SitemapController::index');
$routes->get('robots.txt', 'SitemapController::robots');

// --------------------------------------------------------------------
// RUTE AUTENTIKASI
// --------------------------------------------------------------------
$routes->get('/login', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('/login', 'AuthController::processLogin');
$routes->post('login', 'AuthController::processLogin');
$routes->post('/login/process', 'AuthController::processLogin');
$routes->post('login/process', 'AuthController::processLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/register/process', 'AuthController::processRegister');
$routes->get('/logout', 'AuthController::logout');
$routes->get('auth/ranting/([0-9]+)', 'AuthController::getRantingByCabang/$1');

// --------------------------------------------------------------------
// API ROUTES (untuk AJAX calls)
// --------------------------------------------------------------------
$routes->group('api', static function ($routes) {
    $routes->get('csrf-token', 'ApiController::getCsrfToken');
    $routes->get('ranting/([0-9]+)', 'AuthController::getRantingByCabang/$1');
});

// --------------------------------------------------------------------
// ADMIN DASHBOARD ROUTES
// --------------------------------------------------------------------

// Direct dashboard access
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('dashboard/add-to-calendar/(:num)', 'DashboardController::add_to_calendar/$1', ['filter' => 'auth']);
$routes->post('dashboard/quick-join/(:num)', 'DashboardController::quickJoinAgenda/$1', ['filter' => 'auth']);

// Profil Saya
$routes->get('profil-saya', 'ProfilController::index', ['filter' => 'auth']);
$routes->post('profil-saya/update', 'ProfilController::update', ['filter' => 'auth']);
$routes->post('profil-saya/update-foto', 'ProfilController::update_foto', ['filter' => 'auth']);

// --------------------------------------------------------------------
// VERIFIKASI ANGGOTA ROUTES (Super Admin & Admin only)
// --------------------------------------------------------------------
$routes->group('verifikasi-anggota', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'KeanggotaanController::index', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('setujui/([0-9]+)', 'KeanggotaanController::setujui/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('tolak/([0-9]+)', 'KeanggotaanController::tolak/$1', ['filter' => 'role:Super Admin,Admin']);
});

// --------------------------------------------------------------------
// MANAJEMEN ANGGOTA ROUTES (Super Admin & Admin only)
// --------------------------------------------------------------------
$routes->group('manajemen-anggota', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'KeanggotaanController::manajemen', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('edit/([0-9]+)', 'KeanggotaanController::edit/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('update/([0-9]+)', 'KeanggotaanController::update/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('export', 'KeanggotaanController::export', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('hapus', 'KeanggotaanController::hapus', ['filter' => 'role:Super Admin']);
    $routes->post('delete/([0-9]+)', 'KeanggotaanController::delete/$1', ['filter' => 'role:Super Admin']);
});

// --------------------------------------------------------------------
// MANAJEMEN ADMIN ROUTES (Super Admin only)
// --------------------------------------------------------------------
$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'AdminController::index', ['filter' => 'role:Super Admin']);
    $routes->get('create', 'AdminController::create', ['filter' => 'role:Super Admin']);
    $routes->post('store', 'AdminController::store', ['filter' => 'role:Super Admin']);
    $routes->get('edit/([0-9]+)', 'AdminController::edit/$1', ['filter' => 'role:Super Admin']);
    // Browser-compatible PUT/DELETE using POST with _method
    $routes->post('update/([0-9]+)', 'AdminController::update/$1', ['filter' => 'role:Super Admin']);
    $routes->post('delete/([0-9]+)', 'AdminController::delete/$1', ['filter' => 'role:Super Admin']);
    // Keep original PUT/DELETE for API compatibility
    $routes->put('update/([0-9]+)', 'AdminController::update/$1', ['filter' => 'role:Super Admin']);
    $routes->delete('delete/([0-9]+)', 'AdminController::delete/$1', ['filter' => 'role:Super Admin']);
});

// --------------------------------------------------------------------
// MANAJEMEN CABANG ROUTES (Admin only) - Consolidated
// --------------------------------------------------------------------
$routes->group('admin/cabang', ['filter' => 'auth'], static function ($routes) {
    // Main entry point for admin's own branch management
    $routes->get('/', 'AdminCabangController::index', ['filter' => 'role:Admin']); // This will redirect to /admin/cabang/edit

    // Branch Profile Management
    $routes->get('edit', 'AdminCabangController::edit', ['filter' => 'role:Admin']);
    $routes->post('update', 'AdminCabangController::update', ['filter' => 'role:Admin']);

    // Struktur Cabang Management
    $routes->get('struktur', 'AdminCabangController::struktur', ['filter' => 'role:Admin']);
    $routes->get('struktur/create', 'AdminCabangController::createStruktur', ['filter' => 'role:Admin']);
    $routes->post('struktur/store', 'AdminCabangController::storeStruktur', ['filter' => 'role:Admin']);
    $routes->get('struktur/edit/(:num)', 'AdminCabangController::editStruktur/$1', ['filter' => 'role:Admin']);
    $routes->post('struktur/update/(:num)', 'AdminCabangController::updateStruktur/$1', ['filter' => 'role:Admin']);
    $routes->post('struktur/delete/(:num)', 'AdminCabangController::deleteStruktur/$1', ['filter' => 'role:Admin']);
});

// --------------------------------------------------------------------
// MANAJEMEN BERITA ROUTES (Super Admin & Admin only)
// --------------------------------------------------------------------
$routes->group('admin-berita', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'BeritaController::index', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('create', 'BeritaController::create', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('store', 'BeritaController::store', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('edit/([0-9]+)', 'BeritaController::edit/$1', ['filter' => 'role:Super Admin,Admin']);
    // Browser-compatible PUT/DELETE using POST with _method
    $routes->post('update/([0-9]+)', 'BeritaController::update/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('delete/([0-9]+)', 'BeritaController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
    // Keep original PUT/DELETE for API compatibility
    $routes->put('update/([0-9]+)', 'BeritaController::update/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->delete('delete/([0-9]+)', 'BeritaController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
});



// --------------------------------------------------------------------
// MANAJEMEN GALERI ROUTES (Super Admin & Admin only)
// --------------------------------------------------------------------
$routes->group('admin-galeri', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'GaleriController::index', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('store', 'GaleriController::store', ['filter' => 'role:Super Admin,Admin']);
    // Browser-compatible DELETE using POST with _method
    $routes->post('delete/([0-9]+)', 'GaleriController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
    // Keep original DELETE for API compatibility
    $routes->delete('delete/([0-9]+)', 'GaleriController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
});

// --------------------------------------------------------------------
// MANAJEMEN AGENDA ROUTES (Super Admin & Admin only)
// --------------------------------------------------------------------
$routes->group('admin-agenda', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'AgendaController::index', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('create', 'AgendaController::create', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('store', 'AgendaController::store', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('edit/([0-9]+)', 'AgendaController::edit/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('update/([0-9]+)', 'AgendaController::update/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('delete/([0-9]+)', 'AgendaController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
});



// --------------------------------------------------------------------
// SISTEM CABANG ROUTES
// --------------------------------------------------------------------

// Halaman publik cabang
$routes->get('cabang', 'CabangController::index');
$routes->get('cabang/(:segment)', 'CabangController::detail/$1');

// --------------------------------------------------------------------
// MANAJEMEN BERITA ROUTES (Super Admin & Admin only)
// --------------------------------------------------------------------
$routes->group('admin-berita', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'BeritaController::index', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('create', 'BeritaController::create', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('store', 'BeritaController::store', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('edit/([0-9]+)', 'BeritaController::edit/$1', ['filter' => 'role:Super Admin,Admin']);
    // Browser-compatible PUT/DELETE using POST with _method
    $routes->post('update/([0-9]+)', 'BeritaController::update/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('delete/([0-9]+)', 'BeritaController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
    // Keep original PUT/DELETE for API compatibility
    $routes->put('update/([0-9]+)', 'BeritaController::update/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->delete('delete/([0-9]+)', 'BeritaController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
});



// --------------------------------------------------------------------
// MANAJEMEN GALERI ROUTES (Super Admin & Admin only)
// --------------------------------------------------------------------
$routes->group('admin-galeri', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'GaleriController::index', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('store', 'GaleriController::store', ['filter' => 'role:Super Admin,Admin']);
    // Browser-compatible DELETE using POST with _method
    $routes->post('delete/([0-9]+)', 'GaleriController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
    // Keep original DELETE for API compatibility
    $routes->delete('delete/([0-9]+)', 'GaleriController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
});

// --------------------------------------------------------------------
// MANAJEMEN AGENDA ROUTES (Super Admin & Admin only)
// --------------------------------------------------------------------
$routes->group('admin-agenda', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'AgendaController::index', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('create', 'AgendaController::create', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('store', 'AgendaController::store', ['filter' => 'role:Super Admin,Admin']);
    $routes->get('edit/([0-9]+)', 'AgendaController::edit/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('update/([0-9]+)', 'AgendaController::update/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('delete/([0-9]+)', 'AgendaController::delete/$1', ['filter' => 'role:Super Admin,Admin']);
});

// --------------------------------------------------------------------
// SISTEM ABSENSI ROUTES (Authenticated users only)
// --------------------------------------------------------------------
$routes->group('absensi', ['filter' => 'auth'], static function ($routes) {
    // Daftar agenda untuk absensi
    $routes->get('agenda', 'AbsensiController::daftarAgenda');
    $routes->get('agenda/(:num)', 'AbsensiController::detailAgenda/$1');
    // Tambahkan route join agenda (GET)
    $routes->get('agenda/(:num)/join', 'AbsensiController::joinAgenda/$1');
    $routes->post('daftar/(:num)', 'AbsensiController::daftarKeAgenda/$1');
    $routes->post('batal/(:num)', 'AbsensiController::batalkanPendaftaran/$1');
    
    // Proses absensi GPS
    $routes->get('hadir/(:num)', 'AbsensiController::absensi/$1');
    $routes->post('proses', 'AbsensiController::prosesAbsensi');
    
    // Riwayat absensi user
    $routes->get('riwayat', 'AbsensiController::riwayatAbsensi');
});

// --------------------------------------------------------------------
// REKAP ABSENSI ROUTES (Admin only)
// --------------------------------------------------------------------
$routes->group('rekap-absensi', ['filter' => 'auth'], static function ($routes) {
    // List agenda untuk rekap
    $routes->get('/', 'AbsensiController::rekapAbsensi', ['filter' => 'role:Super Admin,Admin']);
    
    // Detail rekap per agenda
    $routes->get('(:num)', 'AbsensiController::rekapAbsensi/$1', ['filter' => 'role:Super Admin,Admin']);
    
    // Export data absensi
    $routes->get('export/(:num)', 'AbsensiController::exportAbsensi/$1', ['filter' => 'role:Super Admin,Admin']);
});

// --------------------------------------------------------------------
// SISTEM CABANG ROUTES
// --------------------------------------------------------------------

// Halaman publik cabang
$routes->get('cabang', 'CabangController::index');
$routes->get('cabang/(:segment)', 'CabangController::detail/$1');

// Admin cabang routes (Super Admin & Admin only)
$routes->group('admin-cabang', ['filter' => 'auth'], static function ($routes) {
    // Profile cabang management
    $routes->get('profile', 'CabangController::admin_profile', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('profile/update', 'CabangController::update_profile', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('profile/upload-foto', 'CabangController::upload_foto_sekretariat', ['filter' => 'role:Super Admin,Admin']);
    
    // Struktur cabang management
    $routes->get('struktur', 'CabangController::admin_struktur', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('struktur/add', 'CabangController::add_struktur', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('struktur/update/([0-9]+)', 'CabangController::update_struktur/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('struktur/delete/([0-9]+)', 'CabangController::delete_struktur/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('struktur/toggle-status/([0-9]+)', 'CabangController::toggle_status_struktur/$1', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('struktur/update-urutan', 'CabangController::update_urutan_struktur', ['filter' => 'role:Super Admin,Admin']);
    $routes->post('struktur/upload-foto/([0-9]+)', 'CabangController::upload_foto_struktur/$1', ['filter' => 'role:Super Admin,Admin']);
});

// --------------------------------------------------------------------
// MANAJEMEN VOTING FORMATUR ROUTES (Super Admin only)
// --------------------------------------------------------------------
$routes->group('admin-voting', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'FormaturVotingController::index', ['filter' => 'role:Super Admin']);
    $routes->get('create', 'FormaturVotingController::create', ['filter' => 'role:Super Admin']);
    $routes->post('store', 'FormaturVotingController::store', ['filter' => 'role:Super Admin']);
    $routes->get('(:num)', 'FormaturVotingController::show/$1', ['filter' => 'role:Super Admin']);
    $routes->get('edit/(:num)', 'FormaturVotingController::edit/$1', ['filter' => 'role:Super Admin']);
    $routes->post('update/(:num)', 'FormaturVotingController::update/$1', ['filter' => 'role:Super Admin']);
    $routes->post('delete/(:num)', 'FormaturVotingController::delete/$1', ['filter' => 'role:Super Admin']);
    $routes->post('status/(:num)', 'FormaturVotingController::changeStatus/$1', ['filter' => 'role:Super Admin']);
    $routes->get('results/(:num)', 'FormaturVotingController::getResults/$1', ['filter' => 'role:Super Admin']);
    $routes->get('export/(:num)', 'FormaturVotingController::exportResults/$1', ['filter' => 'role:Super Admin']);
});

// --------------------------------------------------------------------
// VOTING PARTICIPANT ROUTES (Authenticated users)
// --------------------------------------------------------------------
$routes->group('voting', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'VotingParticipantController::index');
    $routes->get('(:num)', 'VotingParticipantController::show/$1');
    $routes->post('vote/(:num)', 'VotingParticipantController::vote/$1');
    $routes->get('results/(:num)', 'VotingParticipantController::getResults/$1');
    $routes->get('history', 'VotingParticipantController::history');
});

// --------------------------------------------------------------------
// ERROR HANDLING ROUTES
// --------------------------------------------------------------------
$routes->get('404', 'ErrorController::show404');
$routes->get('error', 'ErrorController::showError');

// --------------------------------------------------------------------
// MAINTENANCE MODE (uncomment when needed)
// --------------------------------------------------------------------
// $routes->get('maintenance', 'MaintenanceController::index');

// --------------------------------------------------------------------
// DEVELOPMENT ROUTES (remove in production)
// --------------------------------------------------------------------
if (ENVIRONMENT !== 'production') {
    // Development tools routes can be added here
    $routes->get('test-dashboard', 'DashboardController::index');
    // $routes->get('dev/routes', 'DevController::showRoutes');
}
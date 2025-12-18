<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- 1. DEFAULT ROOT ---
$routes->get('/', 'AuthController::loginAman');

// --- 2. ROUTE LOGOUT
$routes->get('logout', 'AuthController::logout');

// --- 2. AUTH ROUTES (MODIFIKASI: AMAN VS RAWAN) ---
$routes->group('auth', function($routes) {
    // Jalur AMAN (Standard CI4)
    $routes->get('login', 'AuthController::loginAman');       // Halaman Form
    $routes->post('proses_aman', 'AuthController::authAman'); // Action Form
    
    // Jalur RAWAN (SQL Injection Demo)
    $routes->get('login_rawan', 'AuthController::loginRawan');       // Halaman Form Merah
    $routes->post('proses_rawan', 'AuthController::authRawan');      // Action Form Bypass
    
    // Logout
    $routes->get('logout', 'AuthController::logout');
});

// --- 3. DASHBOARD PIMPINAN ---
// (Kita buat group agar konsisten, meski isinya baru dashboard saja)
$routes->group('pimpinan', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'PimpinanController::index');
});

// --- 4. GROUP KAPRODI (Tetap sama) ---
$routes->group('kaprodi', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'KaprodiController::index');
    $routes->post('tambah_periode', 'KaprodiController::tambahPeriode');
    $routes->get('aktifkan/(:num)', 'KaprodiController::aktifkanPeriode/$1');
    $routes->get('kelola_pertanyaan/(:num)', 'KaprodiController::kelolaPertanyaan/$1'); 
    $routes->post('simpan_pertanyaan', 'KaprodiController::simpanPertanyaan'); 
    $routes->get('hapus_pertanyaan/(:num)/(:num)', 'KaprodiController::hapusPertanyaan/$1/$2'); 
    $routes->get('laporan/(:num)', 'KaprodiController::laporan/$1');
});

// --- 5. GROUP MAHASISWA (Tetap sama) ---
$routes->group('mahasiswa', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'MahasiswaController::index');
    $routes->get('isi_kuisioner/(:num)', 'MahasiswaController::isiKuisioner/$1');
    $routes->post('simpan_jawaban', 'MahasiswaController::simpanJawaban');
});

// --- 6. GROUP ADMIN (Tetap sama) ---
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'AdminController::index');
    
    // Create
    $routes->post('tambah_user', 'AdminController::tambahUser');
    $routes->post('tambah_fakultas', 'AdminController::tambahFakultas');
    $routes->post('tambah_jurusan', 'AdminController::tambahJurusan');
    $routes->post('tambah_prodi', 'AdminController::tambahProdi');
    $routes->post('tambah_mahasiswa', 'AdminController::tambahMahasiswa');
    
    // Delete
    $routes->get('hapus_user/(:num)', 'AdminController::hapusUser/$1');
    $routes->get('hapus_fakultas/(:num)', 'AdminController::hapusFakultas/$1');
    $routes->get('hapus_jurusan/(:num)', 'AdminController::hapusJurusan/$1');
    $routes->get('hapus_prodi/(:num)', 'AdminController::hapusProdi/$1');
    $routes->get('hapus_mahasiswa/(:any)', 'AdminController::hapusMahasiswa/$1');
    
    // Edit & Update
    $routes->get('edit/(:segment)/(:any)', 'AdminController::formEdit/$1/$2'); 
    $routes->post('update_data', 'AdminController::updateData'); 
});
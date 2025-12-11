<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');

# Tidak aman
$routes->get('/dashboard', 'Dashboard::index'); 
$routes->get('/dashboard/logout', 'Dashboard::logout');
$routes->get('/dashboard/profile', 'Dashboard::profile');
$routes->post('/dashboard/profile/update', 'Dashboard::updateProfile');

# Aman
$routes->get('/secure-login', 'SecureLogin::index');
$routes->post('/secure-login/auth', 'SecureLogin::auth');
$routes->get('/secure-dashboard', 'SecureDashboard::index');
$routes->get('/secure-dashboard/logout', 'Dashboard::logout');
$routes->get('/secure-dashboard/profile', 'SecureDashboard::profile');
$routes->post('/secure-dashboard/profile/update', 'SecureDashboard::updateProfile');

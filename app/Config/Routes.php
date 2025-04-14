<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//index
$routes->get('/', 'DashboardController::index');

//auth
$routes->get('/auth/login', 'AuthController::login');
$routes->post('/auth/authenticate', 'AuthController::authenticate'); // Route untuk proses login
$routes->get('/auth/logout', 'AuthController::logout'); // Route untuk logout

$routes->group('', ['filter' => 'auth'], function ($routes) {
    //Dashboard
    $routes->get('/dashboard', 'DashboardController::index');

    //Santri
    $routes->get('/santri', 'SantriController::index');
    $routes->get('santri/create', 'SantriController::create');
    $routes->post('santri/store', 'SantriController::store');
    $routes->post('santri/update/(:num)', 'SantriController::update/$1');
    $routes->get('santri/edit/(:num)', 'SantriController::edit/$1');
    $routes->get('santri/delete/(:num)', 'SantriController::delete/$1');
    $routes->get('santri/exportExcel', 'SantriController::exportExcel');
    $routes->get('santri/qrcode/(:num)', 'SantriController::showQrCode/$1');
    $routes->get('santri/showQrCode/(:num)', 'SantriController::showQrCode/$1');
    $routes->get('santri/regenerateQr/(:num)', 'SantriController::regenerateQr/$1');
    $routes->post('santri/updatePin/(:num)', 'SantriController::updatePin/$1');
    $routes->post('santri/regenerateQr/(:num)', 'SantriController::regenerateQr/$1');
    $routes->get('santri/downloadQrCode/(:num)', 'SantriController::downloadQrCode/$1');
    $routes->get('/santri/search', 'SantriController::search');


    //QR Code
    $routes->get('qrcode/show/(:num)', 'QrCodeController::show/$1');
    $routes->get('qrcode/generate/(:num)', 'QrCodeController::generate/$1');
    $routes->get('qrcode/generate_img/(:num)', 'QrCodeController::generateImg/$1');

    //Top-Up
    $routes->get('topup', 'TopupController::index');
    $routes->get('topup/create', 'TopupController::create');
    $routes->post('topup/store', 'TopupController::store');
    $routes->get('/topup/exportExcel', 'TopupController::exportExcel');

    //Transaksi
    $routes->get('transaksi', 'TransaksiController::index');
    $routes->get('transaksi/tambah', 'TransaksiController::tambah');
    $routes->post('transaksi/proses', 'TransaksiController::proses');
    $routes->get('transaksi/hapus/(:num)', 'TransaksiController::delete/$1');
    $routes->get('/transaksi/exportExcel', 'TransaksiController::exportExcel');
    $routes->get('transaksi/search', 'TransaksiController::search');

    //Scanner
    $routes->get('scanner', 'ScannerController::index');
});

$routes->getRoutes();

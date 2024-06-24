<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$action = isset($_GET['act']) ? $_GET['act'] : 'default';

$routes = array(
  array(
    'url' => './',
    'icon' => '<i class=\'text-[1.25rem] text-white bx bxs-grid-alt\'></i>',
    'label' => 'Dashboard'
  ),
  array(
    'url' => '?page=kasir',
    'icon' => '<i class=\'text-[1.25rem] text-white bx bxs-cart-alt\'></i>',
    'label' => 'Kasir'
  ),
  array(
    'url' => '?page=barang-masuk',
    'icon' => '<i class=\'text-[1.25rem] text-white bx bxs-archive-in\'></i>',
    'label' => 'Barang Masuk'
  ),
  array(
    'url' => '?page=daftar-barang',
    'icon' => '<i class=\'text-[1.25rem] text-white bx bxs-package\'></i>',
    'label' => 'Daftar Barang'
  ),
  array(
    'url' => '?page=laporan-barang-masuk',
    'icon' => '<i class=\'text-[1.25rem] text-white bx bxs-file-import\'></i>',
    'label' => 'Laporan Barang Masuk'
  ),
  array(
    'url' => '?page=laporan-barang-keluar',
    'icon' => '<i class=\'text-[1.25rem] text-white bx bxs-file-export\'></i>',
    'label' => 'Laporan Barang Keluar'
  )

);

$pages = array(
  'dashboard' => 'pages/dashboard/dashboard.php',
  'kasir' => array(
    'default' => 'pages/kasir/kasir.php',
  ),
  'barang-masuk' => array(
    'default' => 'pages/barang-masuk/barang-masuk.php',
  ),
  'daftar-barang' => array(
    'default' => 'pages/daftar-barang/daftar-barang.php',
    'add' => 'pages/daftar-barang/add.php',
    'edit' => 'pages/daftar-barang/edit.php',
    'barcode' => 'pages/daftar-barang/barcode.php',
    'delete' => 'pages/daftar-barang/delete.php'
  ),
  'kategori' => array(
    'default' => 'pages/kategori/daftar-kategori.php',
    'add' => 'pages/kategori/add.php',
    'edit' => 'pages/kategori/edit.php',
    'barcode' => 'pages/kategori/barcode.php',
    'delete' => 'pages/kategori/delete.php'
  ),
  'laporan-barang-masuk' => array(
    'default' => 'pages/laporan/barang-masuk/barang-masuk.php',
    'add' => 'pages/laporan/barang-masuk/cetak-pdf.php',
    'delete' => 'pages/laporan/barang-masuk/delete.php'
  ),
  'laporan-barang-keluar' => array(
    'default' => 'pages/laporan/barang-keluar/barang-keluar.php',
    'add' => 'pages/laporan/barang-keluar/cetak-pdf.php',
    'delete' => 'pages/laporan/barang-keluar/delete.php'
  ),
  'logout' => array(
    'default' => 'action/logout.php'
  ),
  'sync' => array(
    'default' => 'action/sync.php'
  ),
  'struk' => array(
    'default' => 'pages/kasir/struk.php'
  )


);

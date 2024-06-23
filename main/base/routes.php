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
  ),
  array(
    'url' => 'logout.php',
    'icon' => '<i class=\'text-[1.25rem] text-white bx bxs-log-out\'></i>',
    'label' => 'Logout'
  )

);

$pages = array(
  'dashboard' => 'pages/dashboard/dashboard.php',
  'kasir' => array(
    'default' => 'pages/kasir/kasir.php',
    'add' => 'pages/periode/add-periode.php',
    'edit' => 'pages/periode/edit-periode.php',
    'delete' => ''
  ),
  'barang-masuk' => array(
    'default' => 'pages/barang-masuk/barang-masuk.php',
  ),
  'daftar-barang' => array(
    'default' => 'pages/daftar-barang/daftar-barang.php',
    'add' => 'pages/daftar-barang/add.php',
  ),
  'laporan-barang-masuk' => array(
    'default' => 'pages/laporan/barang-masuk/barang-masuk.php'
  ),
  'laporan-barang-keluar' => array(
    'default' => 'pages/laporan/barang-keluar/barang-keluar.php'
  ),

);

<?php

$online_host = 'localhost';
$online_username = 'root';
$online_password = '';
$online_db_name = 'tokobangunan_online';

try {
    $online_db = new PDO("mysql:host=$online_host;dbname=$online_db_name", $online_username, $online_password);
    $online_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database online gagal: " . $e->getMessage());
}


$local_host = 'localhost';
$local_username = 'root';
$local_password = '';
$local_db_name = 'tokobangunan_offline';


try {
    $local_db = new PDO("mysql:host=$local_host;dbname=$local_db_name", $local_username, $local_password);
    $local_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database lokal gagal: " . $e->getMessage());
}
?>

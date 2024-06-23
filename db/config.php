<?php


DEFINE("HOST_OFFLINE", "localhost");
DEFINE("USER_OFFLINE", "root");
DEFINE("PASS_OFFLINE", "");
DEFINE("DB_OFFLINE", "tokobangunan_offline");

$conn_offline = new mysqli(HOST_OFFLINE, USER_OFFLINE, PASS_OFFLINE, DB_OFFLINE);

if ($conn_offline->connect_errno) {
    die("Koneksi ke database offline gagal: " . $conn_offline->connect_errno);
}

DEFINE("HOST_ONLINE", "sql12.freesqldatabase.com");
DEFINE("USER_ONLINE", "sql12715284");
DEFINE("PASS_ONLINE", "pxunvyhptv");
DEFINE("DB_ONLINE", "sql12715284");

$conn_online = new mysqli(HOST_ONLINE, USER_ONLINE, PASS_ONLINE, DB_ONLINE);

if ($conn_online->connect_errno) {
    die("Koneksi ke database online gagal: " . $conn_online->connect_errno);
}

// Jika kedua koneksi berhasil
echo "Koneksi ke kedua database berhasil";

?>

<?php


DEFINE("HOST_OFFLINE", "localhost");
DEFINE("USER_OFFLINE", "root");
DEFINE("PASS_OFFLINE", "");
DEFINE("DB_OFFLINE", "tokobangunan_offline");

$conn_offline = new mysqli(HOST_OFFLINE, USER_OFFLINE, PASS_OFFLINE, DB_OFFLINE);

if ($conn_offline->connect_errno) {
    die("Koneksi ke database offline gagal: " . $conn_offline->connect_errno);
}




?>

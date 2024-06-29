<?php

DEFINE("HOST_ONLINE", "sql12.freesqldatabase.com");
DEFINE("USER_ONLINE", "sql12716932");
DEFINE("PASS_ONLINE", "tdFg3LQ7qZ");
DEFINE("DB_ONLINE", "sql12716932");


$conn_online = new mysqli(HOST_ONLINE, USER_ONLINE, PASS_ONLINE, DB_ONLINE);

if ($conn_online->connect_errno) {
    die("Koneksi ke database online gagal: " . $conn_online->connect_errno);
}

global $conn_offline;

$tables = [
    'admins' => 'id',
    'barang' => 'id',
    'kategori' => 'id',
    'transaksi' => 'id',
    'transaksi_barang' => 'id'
];

try {
    foreach ($tables as $table => $primaryKey) {
        mirrorTable($conn_offline, $conn_online, $table, $primaryKey);
        mirrorTable($conn_online, $conn_offline, $table, $primaryKey);
       
    }
    echo "<script>alert('Sinkronisasi Berhasil!'); document.location.href='../main/index.php?page=dashboard';</script>";
} catch (Exception $e) {
    echo "<script>alert('Sinkronisasi Gagal: " . urlencode($e->getMessage()) . "'); document.location.href='../main/index.php?page=dashboard';</script>";
}
exit();
?>

<?php


// Pastikan $conn_online dan $conn_offline adalah koneksi MySQLi
global $conn_online;
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
        mirrorTable($conn_online, $conn_offline, $table, $primaryKey);
        mirrorTable($conn_offline, $conn_online, $table, $primaryKey);
    }
    echo "<script>alert('Sinkronisasi Berhasil!'); document.location.href='../main/index.php?page=dashboard';</script>";
} catch (Exception $e) {
    echo "<script>alert('Sinkronisasi Gagal: " . urlencode($e->getMessage()) . "'); document.location.href='../main/index.php?page=dashboard';</script>";
}
exit();
?>

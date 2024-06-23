<?php

$id = $_GET['id'];
$delete_data =  deleteData('barang', "id = $id");

if ($delete_data = 1) {
    echo "<script>alert('Data berhasil dihapus!');document.location.href='?page=daftar-barang';</script>";
} else {
    echo "<script>alert('Gagal menghapus data!');document.location.href='?page=daftar-barang';</script>";
}


?>
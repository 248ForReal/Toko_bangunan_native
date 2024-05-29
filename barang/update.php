<?php
require '../config.php';
require '../generate_barcode.php';

function isInternetAvailable() {
    $url = 'https://www.google.com';
    $headers = @get_headers($url);
    return $headers && strpos($headers[0], '200');
}

$db = isInternetAvailable() ? $online_db : $local_db;

$id = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM barang WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barcode = $_POST['barcode_barang'];
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori_id'];
    $harga_modal = $_POST['harga_modal'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $updatedAt = date('Y-m-d H:i:s');

    $barcode = $barcode ?: generateBarcode($id);

    $stmt = $db->prepare("UPDATE barang SET barcode_barang = ?, nama_barang = ?, kategori_id = ?, harga_modal = ?, harga_jual = ?, stok = ?, updatedAt = ? WHERE id = ?");
    $stmt->execute([$barcode, $nama, $kategori, $harga_modal, $harga_jual, $stok, $updatedAt, $id]);

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shCzF0V5OGCFW3ZK3voB8V2Ezi1K7xSfoRoC8" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Barang</h2>
        <form method="POST">
            <div class="form-group mb-3">
                <label for="barcode_barang">Barcode Barang</label>
                <input type="text" id="barcode_barang" name="barcode_barang" class="form-control" value="<?= htmlspecialchars($item['barcode_barang']) ?>">
            </div>
            <div class="form-group mb-3">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" required class="form-control" value="<?= htmlspecialchars($item['nama_barang']) ?>">
            </div>
            <div class="form-group mb-3">
                <label for="kategori_id">Kategori ID</label>
                <input type="text" id="kategori_id" name="kategori_id" required class="form-control" value="<?= htmlspecialchars($item['kategori_id']) ?>">
            </div>
            <div class="form-group mb-3">
                <label for="harga_modal">Harga Modal</label>
                <input type="text" id="harga_modal" name="harga_modal" required class="form-control" value="<?= htmlspecialchars($item['harga_modal']) ?>">
            </div>
            <div class="form-group mb-3">
                <label for="harga_jual">Harga Jual</label>
                <input type="text" id="harga_jual" name="harga_jual" required class="form-control" value="<?= htmlspecialchars($item['harga_jual']) ?>">
            </div>
            <div class="form-group mb-3">
                <label for="stok">Stok</label>
                <input type="text" id="stok" name="stok" required class="form-control" value="<?= htmlspecialchars($item['stok']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>

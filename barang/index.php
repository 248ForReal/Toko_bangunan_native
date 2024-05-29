<?php
require '../config.php';
require '../generate_barcode.php';

function isInternetAvailable() {
    $url = 'https://www.google.com';
    $headers = @get_headers($url);
    return $headers && strpos($headers[0], '200');
}

$db = isInternetAvailable() ? $online_db : $local_db;

$query = $db->query("SELECT * FROM barang");
$barang = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Toko Bangunan</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Daftar Barang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Daftar Barang</h2>
        <a href="create.php" class="btn btn-primary mb-3">Tambah Barang</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Barcode Barang</th>
                    <th>Kategori</th>
                    <th>Harga Modal</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                    <th>Print Barcode</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['id']) ?></td>
                    <td><?= htmlspecialchars($item['barcode_barang']) ?></td>
                    <td><?= htmlspecialchars($item['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($item['kategori_id']) ?></td>
                    <td><?= htmlspecialchars($item['harga_modal']) ?></td>
                    <td><?= htmlspecialchars($item['harga_jual']) ?></td>
                    <td><?= htmlspecialchars($item['stok']) ?></td>
                    <td>
                        <a href="update.php?id=<?= $item['id'] ?>" class="btn btn-primary">Edit</a>
                        <a href="delete.php?id=<?= $item['id'] ?>" class="btn btn-danger">Hapus</a>
                    </td>
                    <td>
                        <?php if (!empty($item['barcode_barang'])): ?>
                            <form method="POST" action="print_barcode.php" target="_blank">
                                <input type="hidden" name="barcode" value="<?= htmlspecialchars($item['barcode_barang']) ?>">
                                <button type="submit" class="btn btn-secondary">Print Barcode</button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Print Barcode</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

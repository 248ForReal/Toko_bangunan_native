<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shCzF0V5OGCFW3ZK3voB8V2Ezi1K7xSfoRoC8" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> <!-- Hubungkan file CSS -->
</head>



<body>
    <div class="container mt-5">
        <h2 class="text-center">Daftar Barang</h2>
        <div class="text-center mb-3">
            <?php
            function isInternetAvailable()
            {
                $url = 'https://www.google.com';
                $headers = @get_headers($url);
                return $headers && strpos($headers[0], '200');
            }

            $statusClass = isInternetAvailable() ? 'status-green' : 'status-red';
            echo "<div class='status-indicator $statusClass'></div>";
            ?>
            <span class="ms-2">Koneksi Internet</span>
        </div>

        <?php
        include 'config.php';

        // Ambil data barang dari database lokal
        $stmt = $local_db->query("SELECT * FROM barang");
        $barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cek apakah ada pesan sinkronisasi
        if (isset($_GET['sync_status'])) {
            echo '<div class="alert alert-warning text-center">' . htmlspecialchars($_GET['sync_status']) . '</div>';
        }
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Barcode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang as $item) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['id']); ?></td>
                        <td><?php echo htmlspecialchars($item['nama_barang']); ?></td>
                        <td><?php echo htmlspecialchars($item['barcode_barang']); ?></td>
                        <td>
                            <form action="generate_barcode.php" method="post" class="d-inline">
                                <input type="hidden" name="barcode" value="<?php echo htmlspecialchars($item['barcode_barang']); ?>">
                                <button type="submit" class="btn btn-primary">Generate Barcode</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Tombol Sinkronisasi -->
        <div class="text-center mt-4">
            <form action="sync.php" method="post">
                <button type="submit" name="sync" class="btn btn-primary">Sinkronisasi Data</button>
            </form>
        </div>
    </div>
</body>

</html>

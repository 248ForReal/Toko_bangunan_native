<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barang/index.php">Daftar Barang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Selamat Datang di Toko Bangunan</h2>
        <div class="text-center mb-3">
            <a href="sync.php" class="btn btn-primary">Sinkronisasi Data</a>
        </div>
        <?php
        if (isset($_GET['sync_status'])) {
            $sync_status = htmlspecialchars($_GET['sync_status']);
            echo "<div class='alert alert-info text-center'>$sync_status</div>";
        }
        ?>
    </div>

    <div class="status-footer">
        <?php
        function isInternetAvailable() {
            $url = 'https://www.google.com';
            $headers = @get_headers($url);
            return $headers && strpos($headers[0], '200');
        }

        $statusClass = isInternetAvailable() ? 'status-green' : 'status-red';
        echo "<div class='status-indicator $statusClass'></div>";
        ?>
        <span class="ml-2">Koneksi Internet</span>
        <?php
        if (isInternetAvailable()) {
            echo "<span class='ml-2'>Terhubung ke Internet</span>";
        } else {
            echo "<span class='ml-2'>Tidak Terhubung ke Internet</span>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

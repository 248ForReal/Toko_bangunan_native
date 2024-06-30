<?php
// Set default timezone to WIB (UTC+7)
date_default_timezone_set('Asia/Jakarta');

// Get counts
$countBarang = countData('barang');
$countKategori = countData('kategori');
$countTransaksi = countData('transaksi');
$countTransaksiBarang = countData('transaksi_barang');

// Get profits
$today = date('Y-m-d');
$startToday = "$today 00:00:00";
$endToday = "$today 23:59:59";
$profitToday = getProfit($startToday, $endToday);

// Get profit for this week (WIB)
$startOfWeek = date('Y-m-d', strtotime('monday this week'));
$endOfWeek = date('Y-m-d', strtotime('sunday this week'));
$startWeek = "$startOfWeek 00:00:00";
$endWeek = "$endOfWeek 23:59:59";
$profitWeek = getProfit($startWeek, $endWeek);

// Get profit for this month (WIB)
$startOfMonth = date('Y-m-01');
$endOfMonth = date('Y-m-t');
$startMonth = "$startOfMonth 00:00:00";
$endMonth = "$endOfMonth 23:59:59";
$profitMonth = getProfit($startMonth, $endMonth);

// Get latest transactions
$latestTransactions = getLatestTransactions();
?>
<div class="container mx-auto">
    <h3 class="text-2xl font-semibold mb-10">
        Dashboard
    </h3>

    <!-- Tambahkan tautan sinkronisasi -->
    <a href="?page=sync" id="sync-button" class="text-white bg-blue-500 hover:bg-blue-600 font-bold py-2 px-4 rounded mb-6 inline-block">
        Sinkronisasi
    </a>

    <!-- Kartu jumlah data -->
    <h3 class="text-xl font-semibold mb-4">Jumlah Data</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow-md rounded p-4">
            <div class="text-gray-500">Barang</div>
            <div class="text-2xl font-bold"><?php echo $countBarang; ?></div>
        </div>
        <div class="bg-white shadow-md rounded p-4">
            <div class="text-gray-500">Kategori</div>
            <div class="text-2xl font-bold"><?php echo $countKategori; ?></div>
        </div>
        <div class="bg-white shadow-md rounded p-4">
            <div class="text-gray-500">Transaksi</div>
            <div class="text-2xl font-bold"><?php echo $countTransaksi; ?></div>
        </div>
        <div class="bg-white shadow-md rounded p-4">
            <div class="text-gray-500">Transaksi Barang</div>
            <div class="text-2xl font-bold"><?php echo $countTransaksiBarang; ?></div>
        </div>
    </div>

    <!-- Kartu keuntungan -->
    <h3 class="text-xl font-semibold mb-4">Keuntungan</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow-md rounded p-4">
            <div class="text-gray-500">Hari Ini</div>
            <div class="text-2xl font-bold"><?php echo formatRupiah($profitToday); ?></div>
        </div>
        <div class="bg-white shadow-md rounded p-4">
            <div class="text-gray-500">Minggu Ini</div>
            <div class="text-2xl font-bold"><?php echo formatRupiah($profitWeek); ?></div>
        </div>
        <div class="bg-white shadow-md rounded p-4">
            <div class="text-gray-500">Bulan Ini</div>
            <div class="text-2xl font-bold"><?php echo formatRupiah($profitMonth); ?></div>
        </div>
    </div>

    <!-- Kartu transaksi terbaru -->
    <h3 class="text-xl font-semibold mb-4">Transaksi Terbaru</h3>
    <div class="bg-white shadow-md rounded p-4">
        <?php if (!empty($latestTransactions)): ?>
            <?php foreach ($latestTransactions as $index => $transaction): ?>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-4">
                    <div>
                        <div class="text-gray-500">No. Transaksi</div>
                        <div class="text-2xl font-bold"><?php echo $index + 1; ?></div>
                    </div>
                    <div>
                        <div class="text-gray-500">Total Belanja</div>
                        <div class="text-2xl font-bold">Rp. <?php echo number_format($transaction['total_belanja'], 2, ',', '.'); ?></div>
                    </div>
                    <div>
                        <div class="text-gray-500">Kembalian</div>
                        <div class="text-2xl font-bold">Rp. <?php echo number_format($transaction['kembalian'], 2, ',', '.'); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-gray-500">Tidak ada transaksi terbaru</div>
        <?php endif; ?>
    </div>
</div>

<script>
    function isInternetAvailable() {
        return fetch('https://www.google.com', {mode: 'no-cors'})
            .then(() => true)
            .catch(() => false);
    }

    function updateSyncButton() {
        const syncButton = document.getElementById('sync-button');
        isInternetAvailable().then((connected) => {
            if (!connected) {
                syncButton.classList.remove('bg-blue-500', 'hover:bg-blue-600');      
                syncButton.classList.add('bg-gray-500');
                syncButton.removeAttribute('href');          
            }
        });
    }

    document.addEventListener('DOMContentLoaded', updateSyncButton);
</script>

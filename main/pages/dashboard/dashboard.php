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
<h3 class="text-2xl font-semibold mb-10">
    Dashboard
</h3>

<!-- Tambahkan tautan sinkronisasi -->
<div class="w-full flex justify-end">
<a href="?page=sync" class="text-center py-2 px-4 inline-flex items-center gap-x-2 text-xs font-semibold rounded-lg border border-transparent bg-indigo-700 text-white hover:bg-indigo-800 disabled:opacity-50 disabled:pointer-events-none transition-all">
<i class='bx bx-sync text-[1.1rem] text-white'></i>
    Sinkronisasi
</a>
</div>

<!-- Kartu jumlah data -->
<div class="bg-white p-6 rounded-xl mt-6">
    <h3 class="text-xl font-semibold mb-4">Jumlah Data</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <article class="flex items-center gap-4 rounded-xl border border-gray-200 bg-white p-6">
            <span class="rounded-full bg-blue-100 p-3 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>

            <div>
                <p class="text-2xl font-medium text-gray-900"><?php echo $countBarang; ?></p>

                <p class="text-sm text-gray-500">Barang</p>
            </div>
        </article>
        <article class="flex items-center gap-4 rounded-xl border border-gray-200 bg-white p-6">
            <span class="rounded-full bg-blue-100 p-3 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>

            <div>
                <p class="text-2xl font-medium text-gray-900"><?php echo $countKategori; ?></p>

                <p class="text-sm text-gray-500">Kategori</p>
            </div>
        </article>
        <article class="flex items-center gap-4 rounded-xl border border-gray-200 bg-white p-6">
            <span class="rounded-full bg-blue-100 p-3 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>

            <div>
                <p class="text-2xl font-medium text-gray-900"><?php echo $countTransaksi; ?></p>

                <p class="text-sm text-gray-500">Transaksi</p>
            </div>
        </article>
        <article class="flex items-center gap-4 rounded-xl border border-gray-200 bg-white p-6">
            <span class="rounded-full bg-blue-100 p-3 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>

            <div>
                <p class="text-2xl font-medium text-gray-900"><?php echo $countTransaksiBarang; ?></p>

                <p class="text-sm text-gray-500">Transaksi Barang</p>
            </div>
        </article>
    </div>
</div>

<!-- Kartu keuntungan -->
<div class="bg-white p-6 rounded-xl mt-6">
    <h3 class="text-xl font-semibold mb-4">Keuntungan</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <article class="flex items-end justify-between rounded-lg border border-gray-100 bg-white p-6">
            <div>
                <p class="text-sm text-gray-500">Harian</p>

                <p class="text-2xl font-medium text-gray-900"><?php echo formatRupiah($profitToday); ?></p>
            </div>
        </article>
        <article class="flex items-end justify-between rounded-lg border border-gray-100 bg-white p-6">
            <div>
                <p class="text-sm text-gray-500">Mingguan</p>

                <p class="text-2xl font-medium text-gray-900"><?php echo formatRupiah($profitWeek); ?></p>
            </div>
        </article>
        <article class="flex items-end justify-between rounded-lg border border-gray-100 bg-white p-6">
            <div>
                <p class="text-sm text-gray-500">Bulanan</p>

                <p class="text-2xl font-medium text-gray-900"><?php echo formatRupiah($profitMonth); ?></p>
            </div>
        </article>
    </div>
</div>

<!-- Kartu transaksi terbaru -->
<div class="bg-white p-6 rounded-xl mt-6">
<h3 class="text-xl font-semibold mb-4">Transaksi Terbaru</h3>
<div class="bg-white h-[500px] overflow-auto">
    <?php if (!empty($latestTransactions)) : ?>
        <?php foreach ($latestTransactions as $index => $transaction) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-4 border border-gray-200 rounded-xl px-4 py-2.5">
                <div>
                    <div class="text-gray-500">No. Transaksi</div>
                    <div class="text-2xl font-semibold"><?php echo $index + 1; ?></div>
                </div>
                <div>
                    <div class="text-gray-500">Total Belanja</div>
                    <div class="text-2xl font-semibold">Rp. <?php echo number_format($transaction['total_belanja'], 2, ',', '.'); ?></div>
                </div>
                <div>
                    <div class="text-gray-500">Kembalian</div>
                    <div class="text-2xl font-semibold">Rp. <?php echo number_format($transaction['kembalian'], 2, ',', '.'); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="text-center text-gray-500">Tidak ada transaksi terbaru</div>
    <?php endif; ?>
</div>
</div>
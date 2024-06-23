<?php
$countBarang = countData('barang');
$countKategori = countData('kategori');
$countTransaksi = countData('transaksi');
$countTransaksiBarang = countData('transaksi_barang');

// Dapatkan transaksi terbaru
$latestTransaction = getLatestTransaction();
?>
  <div class="container mx-auto">
        <h3 class="text-2xl font-semibold mb-10">
            Dashboard
        </h3>

        <!-- Tambahkan tautan sinkronisasi -->
        <a href="?page=sync" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">
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

        <!-- Kartu transaksi terbaru -->
        <h3 class="text-xl font-semibold mb-4">Transaksi Terbaru</h3>
        <div class="bg-white shadow-md rounded p-4">
            <?php if ($latestTransaction): ?>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <div class="text-gray-500">ID Transaksi</div>
                        <div class="text-2xl font-bold"><?php echo $latestTransaction['id_transaksi']; ?></div>
                    </div>
                    <div>
                        <div class="text-gray-500">Total Belanja</div>
                        <div class="text-2xl font-bold"><?php echo $latestTransaction['total_belanja']; ?></div>
                    </div>
                    <div>
                        <div class="text-gray-500">Kembalian</div>
                        <div class="text-2xl font-bold"><?php echo $latestTransaction['kembalian']; ?></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center text-gray-500">Tidak ada transaksi terbaru</div>
            <?php endif; ?>
        </div>
    </div>
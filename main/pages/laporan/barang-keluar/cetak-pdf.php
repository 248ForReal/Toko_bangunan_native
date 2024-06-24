<?php
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$condition = "";
if ($startDate && $endDate) {
    $condition = "createdAt BETWEEN '$startDate' AND '$endDate'";
}

$listTransaksi = selectData("transaksi", "*", "", $condition);

$totalJumlahDibayarkan = 0;
foreach ($listTransaksi as $row) {
    $totalJumlahDibayarkan += $row['jumlah_dibayarkan'];
}

function formatRupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}
?>
    <style>
        @media print {
            .print-only { display: block; }
            .no-print { display: none; }
        }
    </style>
    <script>
        function printAndRedirect() {
            const printContents = document.getElementById('print-section').innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            setTimeout(function() {
                document.body.innerHTML = originalContents;
                window.location.href = 'index.php?page=laporan-barang-keluar';
            }, 1000);
        }
        window.onload = printAndRedirect;
    </script>

    <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 no-print">Laporan Barang Keluar</h1>
        <button class="no-print bg-blue-500 text-white px-4 py-2 rounded mb-4" onclick="printAndRedirect()">Print</button>
        <div id="print-section" class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b">ID Transaksi</th>
                        <th class="py-2 px-4 border-b">Total Belanja</th>
                        <th class="py-2 px-4 border-b">Jumlah Dibayarkan</th>
                        <th class="py-2 px-4 border-b">Kembalian</th>
                        <th class="py-2 px-4 border-b">Items</th>
                        <th class="py-2 px-4 border-b">Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listTransaksi as $row): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo formatRupiah($row['total_belanja']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo formatRupiah($row['jumlah_dibayarkan']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo formatRupiah($row['kembalian']); ?></td>
                            <td class="py-2 px-4 border-b">
                                <ul class="list-disc pl-4">
                                    <?php 
                                    $items = json_decode($row['items'], true);
                                    foreach ($items as $item): ?>
                                        <li><?php echo htmlspecialchars($item['nama_barang']) . ' - ' . htmlspecialchars($item['quantity']) . ' x ' . formatRupiah($item['harga_jual']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['createdAt']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-6 print-only">
                <h2 class="text-xl font-bold">Total Pendapatan:</h2>
                <p class="text-lg"><?php echo formatRupiah($totalJumlahDibayarkan); ?></p>
            </div>
        </div>
    </div>


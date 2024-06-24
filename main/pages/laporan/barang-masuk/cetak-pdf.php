<?php
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$condition = "";
if ($startDate && $endDate) {
    $condition = "createdAt BETWEEN '$startDate' AND '$endDate'";
}

$listTransaksi = selectData("transaksi_barang", "*", "", $condition);

$totalJumlahDibayarkan = 0;
foreach ($listTransaksi as $row) {
    $totalJumlahDibayarkan += $row['total_belanja'];
}

function formatRupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
                window.location.href = 'index.php?page=laporan-barang-masuk';
            }, 1000);
        }
        window.onload = printAndRedirect;
    </script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 no-print">Laporan Barang Masuk</h1>
        <button class="no-print bg-blue-500 text-white px-4 py-2 rounded mb-4" onclick="printAndRedirect()">Print</button>
        <div id="print-section" class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b">ID Transaksi</th>
                        <th class="py-2 px-4 border-b">Total Belanja</th>
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
                            <td class="py-2 px-4 border-b"><?php echo formatRupiah($row['kembalian']); ?></td>
                            <td class="py-2 px-4 border-b">
                                <ul class="list-disc pl-4">
                                    <?php 
                                    $items = json_decode($row['items'], true);
                                    foreach ($items as $item): ?>
                                        <li><?php echo htmlspecialchars($item['nama_barang']) . ' - ' . htmlspecialchars($item['quantity']) . ' x ' . formatRupiah($item['harga_modal']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['createdAt']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-6 print-only">
                <h2 class="text-xl font-bold">Total Jumlah Dibayarkan:</h2>
                <p class="text-lg"><?php echo formatRupiah($totalJumlahDibayarkan); ?></p>
            </div>
        </div>
    </div>
</body>
</html>

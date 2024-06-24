<h3 class="text-2xl font-semibold mb-10">
  Daftar Transakso barang_masuk
</h3>
<div class="bg-white p-6 rounded-xl">
  <div class="mb-4 flex gap-4">
    <div class="flex items-center gap-2">
      <input type="date" id="start-date" class="py-2 px-4 text-xs rounded-lg border border-gray-300">
      <span>sampai</span>
      <input type="date" id="end-date" class="py-2 px-4 text-xs rounded-lg border border-gray-300">
      <a id="pdf-link" href="?page=laporan-barang-masuk&act=add&start_date=${startDate}&end_date=${endDate}" class="py-2 px-4 inline-flex items-center gap-x-2 text-xs font-semibold rounded-lg border border-transparent bg-green-700 text-white hover:bg-green-800 transition-all">
        <i class='bx bxs-file-pdf text-[1.1rem] text-white'></i>
        <span class="text-white">Cetak PDF</span>
      </a>
    </div>
  </div>
  <table id="datatable-style" class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
    <thead>
      <tr>
        <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">ID Transaksi</th>
        <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Total Belanja</th>
        <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Kembalian</th>
        <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Items</th>
        <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Tanggal Transaksi</th>
        <th class="whitespace-nowrap text-center px-4 py-2 font-semibold text-gray-900">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      <?php
      $listTransaksi = selectData("transaksi_barang");
      foreach ($listTransaksi as $row) {
        $items = json_decode($row['items'], true);
      ?>
        <tr class="odd:bg-gray-50">
          <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"><?= htmlspecialchars($row['id']) ?></td>
          <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= htmlspecialchars($row['total_belanja']) ?></td>
          <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= htmlspecialchars($row['kembalian']) ?></td>
          <td class="whitespace-nowrap px-4 py-2 text-gray-700">
            <ul class="list-disc pl-5">
              <?php foreach ($items as $item) { ?>
                <li>
                  <?= htmlspecialchars($item['nama_barang']) ?> - <?= htmlspecialchars($item['quantity']) ?> x <?= htmlspecialchars(number_format($item['harga_modal'])) ?>
                </li>
              <?php } ?>
            </ul>
          </td>
          <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= htmlspecialchars($row['createdAt']) ?></td>
          <td class="whitespace-nowrap px-4 py-2 text-gray-700">
            <div class="flex justify-center items-center gap-2">
              <a href="?page=laporan-barang-masuk&act=delete&id=<?= htmlspecialchars($row['id']) ?>" class="rounded-lg px-2 py-1 bg-red-50 border border-red-200 hover:bg-red-100 transition-all" onclick="return confirm('Anda yakin ingin menghapus transaksi ini?')">
                <i class='bx bx-trash text-red-500'></i>
              </a>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const pdfLink = document.getElementById('pdf-link');

    // Fungsi untuk memperbarui href pada link "Cetak PDF"
    function updatePdfLink() {
      const startDate = startDateInput.value;
      const endDate = endDateInput.value;
      pdfLink.href = `?page=laporan-barang-masuk&act=add&start_date=${startDate}&end_date=${endDate}`;
    }

    // Event listener untuk perubahan nilai pada input tanggal
    startDateInput.addEventListener('change', updatePdfLink);
    endDateInput.addEventListener('change', updatePdfLink);
  });
</script>

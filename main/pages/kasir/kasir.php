<h3 class="text-2xl font-semibold mb-10">
  Kasir
</h3>
<div class="bg-white p-6 rounded-xl">
    <table id="datatable-style" class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
      <thead>
        <tr>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Barcode</th>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Nama Barang</th>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Stok</th>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Kategori</th>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Harga Modal</th>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Harga Jual</th>
          <th class="whitespace-nowrap text-center px-4 py-2 font-semibold text-gray-900">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-200">
        <?php
        $listBarang = selectData(
          "barang",
          "barang.*, kategori.nama_kategori",
          "JOIN kategori ON barang.kategori_id = kategori.id"
      );      
        foreach ($listBarang as $row) {
        ?>
          <tr class="odd:bg-gray-50">
            <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"><?= $row['barcode_barang'] ?></td>
            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= $row['nama_barang'] ?></td>
            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= $row['stok'] ?></td>
            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= $row['nama_kategori'] ?></td>
            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= $row['harga_modal'] ?></td>
            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= $row['harga_jual'] ?></td>
            <td class="whitespace-nowrap px-4 py-2 text-gray-700">
              <div class="flex justify-center items-center gap-2">
                <a href="" class="rounded-lg px-2 py-1 bg-gray-50 border hover:bg-gray-100 transition-all">
                  <i class='bx bx-qr-scan text-gray-500'></i>
                </a>
                <a href="?page=daftar-barang&act=edit&id=<?= $row['id'] ?>" class="rounded-lg px-2 py-1 bg-blue-50 border hover:bg-blue-100 transition-all">
                  <i class='bx bxs-pencil text-blue-500'></i>
                </a>
                <a href="?page=daftar-barang&act=delete&id=<?= $row['id'] ?>" onclick="return confirm
            ('Apakah anda yakin ingin menghapus ini?');" class="rounded-lg px-2 py-1 bg-red-50 border hover:bg-red-100 transition-all">
                  <i class='bx bxs-trash text-red-500'></i>
                </a>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
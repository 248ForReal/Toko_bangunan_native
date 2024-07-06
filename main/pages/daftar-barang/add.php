<?php

function generateBarcode($conn_online) {
    $query = "SELECT id FROM barang ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn_online, $query);
    if (!$result) {
        die("Query error: " . mysqli_error($conn_online));
    }
    $row = mysqli_fetch_assoc($result);
    $last_id = $row['id'] ?? 0;
    $new_id = $last_id + 1;
    $id_str = str_pad((string) $new_id, 7, '0', STR_PAD_LEFT);
    $base = '8';
    return $base . $id_str; 
}

$categoriesOpt = selectData('kategori', 'id, nama_kategori');
?>

<div class="bg-white p-8 rounded-xl shadow-sm w-full max-w-md mx-auto">
  <h3 class="mb-6 text-xl text-neutral-900 font-bold">Tambah Barang</h3>
  <form action="" method="POST">
    <div class="relative mb-4">
      <label for="barcode_barang" class="block text-sm font-medium text-gray-700">Barcode Barang</label>
      <input type="number" id="barcode_barang" name="barcode_barang" class="mt-1 py-2 text-xs px-4 w-full rounded-lg border border-gray-200" />
    </div>
    <div class="relative mb-4">
      <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
      <input type="text" id="nama_barang" name="nama_barang" class="mt-1 py-2 text-xs px-4 w-full rounded-lg border border-gray-200" />
    </div>
    <div class="relative mb-4">
      <label for="kategori_id" class="block text-sm font-medium text-gray-900">Kategori</label>
      <select id="kategori_id" name="kategori_id" class="mt-1.5 w-full rounded-lg bg-white py-2.5 text-xs px-4 border border-gray-200 text-gray-700">
        <option value="" selected>Pilih</option>
        <?php foreach ($categoriesOpt as $category): ?>
          <option value="<?= $category['id'] ?>"><?= $category['nama_kategori'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="relative mb-4">
      <label for="harga_modal" class="block text-sm font-medium text-gray-700">Harga Modal</label>
      <input type="number" id="harga_modal" name="harga_modal" class="mt-1 py-2 text-xs px-4 w-full rounded-lg border border-gray-200" />
    </div>
    <div class="relative mb-4">
      <label for="harga_jual" class="block text-sm font-medium text-gray-700">Harga Jual</label>
      <input type="number" id="harga_jual" name="harga_jual" class="mt-1 py-2 text-xs px-4 w-full rounded-lg border border-gray-200" />
    </div>
    <div class="relative mb-4">
      <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
      <input type="number" id="stok" name="stok" class="mt-1 py-2 text-xs px-4 w-full rounded-lg border border-gray-200" />
    </div>
    <div class="flex gap-2 items-center justify-end">
      <button type="submit" class="py-2 px-4 text-xs font-semibold rounded-lg bg-green-700 text-white hover:bg-green-800">Simpan</button>
      <a href="?page=daftar-barang" class="py-2 px-4 text-xs font-semibold rounded-lg bg-white border border-gray-200 text-gray-500 hover:bg-gray-50">Kembali</a>
    </div>
  </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $conn_online;
    $barcode_barang = $_POST['barcode_barang'] ?? '';
    $nama_barang = $_POST['nama_barang'] ?? '';
    $kategori_id = $_POST['kategori_id'] ?? '';
    $harga_modal = $_POST['harga_modal'] ?? '';
    $harga_jual = $_POST['harga_jual'] ?? '';
    $stok = $_POST['stok'] ?? '';
    $now = date('Y-m-d H:i:s');

    if (empty($barcode_barang)) {
        $barcode_barang = generateBarcode($conn_online);
    }

    $data = array(
        'barcode_barang' => $barcode_barang,
        'nama_barang' => $nama_barang,
        'kategori_id' => $kategori_id,
        'harga_modal' => $harga_modal,
        'harga_jual' => $harga_jual,
        'stok' => $stok,
        'createdAt' => $now,
        'updatedAt' => $now,
    );

    $new_id = insertData('barang', $data);

    if ($new_id) {
      echo "<script>alert('Data gagal ditambahkan!');</script>";
       
    } else {
      echo "<script>alert('Data berhasil ditambahkan!');document.location.href='?page=daftar-barang';</script>";
    }
}
?>

<?php
$id = $_GET['id'];
$rowData = selectData('barang', '*', '', "id = $id");
$row = $rowData[0];
$categoriesOpt = selectData('kategori', 'id, nama_kategori');

?>

<div class="bg-white p-8 rounded-xl shadow-sm w-full max-w-md mx-auto">
  <h3 class="mb-6 text-xl text-neutral-900 font-bold">Edit Barang</h3>
  <form action="" method="POST">
    <div class="relative mb-4">
      <label htmlFor="" class="block text-sm font-medium text-gray-700"> Barcode Barang </label>
      <input type="number" placeholder="" name="barcode_barang" value="<?= $row['barcode_barang'] ?>" class="mt-1 py-2 md:py-2 lg:py-2 text-xs md:text-sm lg:text-sm px-4 w-full max-w-xl rounded-lg border border-gray-200" />
    </div>
    <div class="relative mb-4">
      <label htmlFor="" class="block text-sm font-medium text-gray-700"> Nama Barang </label>
      <input type="text" placeholder="" name="nama_barang" value="<?= $row['nama_barang'] ?>" class="mt-1 py-2 md:py-2 lg:py-2 text-xs md:text-sm lg:text-sm px-4 w-full max-w-xl rounded-lg border border-gray-200" />
    </div>
    <div class="relative mb-4">
      <label htmlFor="" class="block text-sm font-medium text-gray-900"> Kategori </label>
      <select name="kategori_id" class="mt-1.5 w-full rounded-lg bg-white py-2.5 md:py-2.5 lg:py-2.5 text-xs md:text-sm lg:text-sm px-4 border border-gray-200 text-gray-700" required>
        <option value="" selected>Pilih</option>
        <?php foreach ($categoriesOpt as $category): ?>
          <option value="<?= $category['id'] ?>"><?= $category['nama_kategori'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="relative mb-4">
      <label htmlFor="" class="block text-sm font-medium text-gray-700"> Harga Modal </label>
      <input type="number" placeholder="" name="harga_modal" value="<?= $row['harga_modal'] ?>" class="mt-1 py-2 md:py-2 lg:py-2 text-xs md:text-sm lg:text-sm px-4 w-full max-w-xl rounded-lg border border-gray-200" />
    </div>
    <div class="relative mb-4">
      <label htmlFor="" class="block text-sm font-medium text-gray-700"> Harga Jual </label>
      <input type="number" placeholder="" name="harga_jual" value="<?= $row['harga_jual'] ?>" class="mt-1 py-2 md:py-2 lg:py-2 text-xs md:text-sm lg:text-sm px-4 w-full max-w-xl rounded-lg border border-gray-200" />
    </div>
    <div class="relative mb-4">
      <label htmlFor="" class="block text-sm font-medium text-gray-700"> Stok </label>
      <input type="number" placeholder="" name="stok" value="<?= $row['stok'] ?>" class="mt-1 py-2 md:py-2 lg:py-2 text-xs md:text-sm lg:text-sm px-4 w-full max-w-xl rounded-lg border border-gray-200" />
    </div>
    <div class="flex gap-2 items-center justify-end">
      <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-1 text-xs md:text-sm lg:text-sm font-semibold rounded-lg border border-transparent bg-green-700 text-white hover:bg-green-800 disabled:opacity-50 disabled:pointer-events-none">
        Simpan
      </button>
      <a href="?page=daftar-barang" class="py-2 px-4 inline-flex items-center gap-x-1 text-xs md:text-sm lg:text-sm font-semibold rounded-lg bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
        Kembali
      </a>
    </div>
  </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $barcode_barang = $_POST['barcode_barang'] ?? '';
  $nama_barang = $_POST['nama_barang'] ?? '';
  $kategori_id = $_POST['kategori_id'] ?? '';
  $harga_modal = $_POST['harga_modal'] ?? '';
  $harga_jual = $_POST['harga_jual'] ?? '';
  $stok = $_POST['stok'] ?? '';

  $data = array(
      'barcode_barang' => $barcode_barang,
      'nama_barang' => $nama_barang,
      'kategori_id' => $kategori_id,
      'harga_modal' => $harga_modal,
      'harga_jual' => $harga_jual,
      'stok' => $stok
  );

  $update_data = updateData("barang", $data, "id = $id");
    if ($update_data = 1) {
        echo "<script>alert('Data berhasil diedit!');document.location.href='?page=daftar-barang';</script>";
    } else {
        echo "<script>alert('Gagal mengedit data!');document.location.href='index.php?page=daftar-barang&act=edit';</script>";
    }
}
?>
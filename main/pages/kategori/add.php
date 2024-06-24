<div class="bg-white p-8 rounded-xl shadow-sm w-full max-w-md mx-auto">
  <h3 class="mb-6 text-xl text-neutral-900 font-bold">Tambah Kategori</h3>
  <form action="" method="POST">
    <div class="relative mb-4">
      <label htmlFor="nama_kategori" class="block text-sm font-medium text-gray-700"> Nama Kategori </label>
      <input type="text" name="nama_kategori" class="mt-1 py-2 text-xs px-4 w-full max-w-xl rounded-lg border border-gray-200" required />
    </div>
    <div class="flex gap-2 items-center justify-end">
      <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-1 text-xs font-semibold rounded-lg border border-transparent bg-green-700 text-white hover:bg-green-800 disabled:opacity-50 disabled:pointer-events-none">
        Simpan
      </button>
      <a href="?page=daftar-kategori" class="py-2 px-4 inline-flex items-center gap-x-1 text-xs font-semibold rounded-lg bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
        Kembali
      </a>
    </div>
  </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kategori = $_POST['nama_kategori'] ?? '';
    $now = date('Y-m-d H:i:s');

    $data = array(
        'nama_kategori' => $nama_kategori,
        'createdAt' => $now,
        'updatedAt' => $now,
    );

    insertData('kategori', $data);

    echo "<script>alert('Kategori berhasil ditambahkan!');document.location.href='?page=kategori';</script>";
}
?>

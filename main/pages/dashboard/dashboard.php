<h3 class="text-2xl font-semibold mb-10">
  Dashboard
</h3>

<!-- Tambahkan tautan sinkronisasi -->
<a href="?page=sync" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
  Sinkronisasi
</a>

<!-- Pesan status sinkronisasi -->
<?php if (isset($_GET['sync_status'])) : ?>
  <div class="mt-4 p-4 rounded <?php echo strpos($_GET['sync_status'], 'berhasil') !== false ? 'bg-green-500 text-white' : 'bg-red-500 text-white'; ?>">
    <?php echo htmlspecialchars($_GET['sync_status']); ?>
  </div>
<?php endif; ?>
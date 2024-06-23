<?php

function getTransactionById($id)
{
  global $conn_online;
  $sql = "SELECT * FROM transaksi WHERE id = $id";
  $result = $conn_online->query($sql);

  if ($result->num_rows > 0) {
    $transaction = $result->fetch_assoc();
    $conn_online->close();
    return $transaction;
  } else {
    $conn_online->close();
    return null;
  }
}

if (isset($_GET['id'])) {
  $transaction = getTransactionById($_GET['id']);
} else {
  echo "<script>alert('Transaksi tidak ditemukan!');document.location.href='index.php?page=kasir';</script>";
  exit;
}
?>

<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
  <?php if ($transaction) : ?>
    <h1 class="text-2xl font-bold text-center mb-4">Struk Transaksi</h1>
    <div class="mb-4">
      <p class="text-sm">ID Transaksi: <span class="font-semibold"><?= $transaction['id'] ?></span></p>
      <p class="text-sm">Waktu Transaksi: <span class="font-semibold"><?= $transaction['createdAt'] ?></span></p>
    </div>

    <div class="mb-4">
      <h2 class="text-xl font-semibold">Total Belanja</h2>
      <p class="text-lg font-semibold text-gray-700">Rp. <?= number_format($transaction['total_belanja'], 2, ',', '.') ?></p>
    </div>

    <div class="mb-4">
      <h2 class="text-xl font-semibold">Pembayaran</h2>
      <p class="text-sm">Jumlah Dibayarkan: <span class="font-semibold">Rp. <?= number_format($transaction['jumlah_dibayarkan'], 2, ',', '.') ?></span></p>
      <p class="text-sm">Kembalian: <span class="font-semibold">Rp. <?= number_format($transaction['kembalian'], 2, ',', '.') ?></span></p>
    </div>

    <div class="mb-4">
      <h2 class="text-xl font-semibold">Daftar Barang</h2>
      <ul class="list-disc list-inside">
        <?php
        $items = json_decode($transaction['items'], true);
        foreach ($items as $item) :
        ?>
          <li class="text-sm">
            <?= $item['nama_barang'] ?> - <?= $item['quantity'] ?> x <?= number_format($item['harga_jual'], 2, ',', '.') ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php else : ?>
    <p class="text-red-500 text-center">Transaksi tidak ditemukan.</p>
  <?php endif; ?>
</div>
<script>
  function printAndRedirect() {
    window.print();
    setTimeout(function() {
      window.location.href = 'index.php?page=kasir';
    }, 1000);
  }
  window.onload = printAndRedirect;
</script>
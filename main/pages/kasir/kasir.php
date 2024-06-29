<?php
function saveCartToJson()
{
    $cartItems = getCartItems();
    $jsonData = json_encode($cartItems, JSON_PRETTY_PRINT);
    file_put_contents('../data-mock/cart.json', $jsonData);
}

function loadCartFromJson()
{
    if (file_exists('../data-mock/cart.json')) {
        $jsonData = file_get_contents('../data-mock/cart.json');
        $_SESSION['cart'] = json_decode($jsonData, true);
    }
}

function getCartItems()
{
    if (isset($_SESSION['cart'])) {
        return $_SESSION['cart'];
    } else {
        return [];
    }
}


function insertTransaction($table, $data) {
  global $conn_offline;


  $escapedData = array();
  foreach ($data as $column => $value) {
      $escapedColumn = mysqli_real_escape_string($conn_offline, $column);
      $escapedValue = mysqli_real_escape_string($conn_offline, $value);
      $escapedData[$escapedColumn] = $escapedValue;
  }

  $columns = implode(", ", array_keys($escapedData));
  $values = "'" . implode("', '", array_values($escapedData)) . "'";

  $sql = "INSERT INTO $table ($columns) VALUES ($values)";

  if ($conn_offline->query($sql) === TRUE) {
      $last_id = $conn_offline->insert_id;
      
      // Update stok barang setelah transaksi berhasil
      updateStockAfterTransaction(json_decode($data['items'], true));


      return $last_id;
  } else {
      return 0;
  }
}





function saveTransaction($totalBelanja, $jumlahDibayarkan, $kembalian, $items)
{
    $now = date('Y-m-d H:i:s');
    $itemsJson = json_encode($items, JSON_PRETTY_PRINT);

    $data = array(
        'total_belanja' => $totalBelanja,
        'jumlah_dibayarkan' => $jumlahDibayarkan,
        'kembalian' => $kembalian,
        'items' => $itemsJson,
        'createdAt' => $now,
        'updatedAt' => $now,
    );

    return insertTransaction('transaksi', $data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $item = [
        'id' => $_POST['id'],
        'barcode_barang' => $_POST['barcode_barang'],
        'nama_barang' => $_POST['nama_barang'],
        'kategori_id' => $_POST['kategori_id'],
        'harga_jual' => $_POST['harga_jual'],
        'quantity' => 1
    ];

    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'][] = $item;
    } else {
        $_SESSION['cart'] = [$item];
    }

    saveCartToJson();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $index = $_POST['item_index'];
    $action = $_POST['update_quantity'];
    $quantity = $_SESSION['cart'][$index]['quantity'];

    if ($action === 'increase') {
        $quantity++;
    } elseif ($action === 'decrease' && $quantity > 1) {
        $quantity--;
    }

    $_SESSION['cart'][$index]['quantity'] = $quantity;
    saveCartToJson();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_cart'])) {
    $index = $_POST['item_index'];

    if (isset($_SESSION['cart'][$index])) {
        array_splice($_SESSION['cart'], $index, 1);
        saveCartToJson();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_to_transaction'])) {
  $jumlahDibayarkan = floatval($_POST['jumlah_dibayarkan']);
  $totalBelanja = array_reduce($_SESSION['cart'], function ($carry, $item) {
      return $carry + ($item['harga_jual'] * $item['quantity']);
  }, 0);
  if ($jumlahDibayarkan < $totalBelanja) {
    echo "<script>alert('Saldo tidak mencukupi!');document.location.href='index.php?page=kasir';</script>";
} else {
    $kembalian = $jumlahDibayarkan - $totalBelanja;
    $items = getCartItems();

    $insert_data = saveTransaction($totalBelanja, $jumlahDibayarkan, $kembalian, $items);

    if ($insert_data != 0) {        
        $_SESSION['cart'] = [];
        saveCartToJson();
        echo "<script>alert('Transaksi berhasil.');document.location.href='?page=struk&id=$insert_data';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan transaksi!');document.location.href='index.php?page=kasir';</script>";
    }
}
}

function updateStockAfterTransaction($items) {
  global $conn_offline;

  foreach ($items as $item) {
      $barcode_barang = $item['barcode_barang'];
      $barcode_barang = $item['barcode_barang'];
      $quantity = $item['quantity'];

      // Ambil stok saat ini berdasarkan barcode_barang
      $sql = "SELECT stok FROM barang WHERE barcode_barang = '$barcode_barang'";
      $result = $conn_offline->query($sql);

      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $stok_sekarang = $row['stok'];

          // Kurangi stok berdasarkan quantity yang dibeli
          $stok_baru = $stok_sekarang - $quantity;

          // Update stok di database
          $update_sql = "UPDATE barang SET stok = $stok_baru WHERE barcode_barang = '$barcode_barang'";
          $conn_offline->query($update_sql);
      }
  }
}

loadCartFromJson();
$cartItems = getCartItems();
$cartIsEmpty = empty($cartItems);
$totalBelanja = 0;
foreach ($cartItems as $item) {
    $totalBelanja += $item['harga_jual'] * $item['quantity'];
}
?>

<h3 class="text-2xl font-semibold mb-10">
  Kasir
</h3>
<section class="<?= $cartIsEmpty ? 'hidden' : 'block'; ?>">
  <div class="w-full bg-white rounded-xl mx-auto px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <div class="w-full mx-auto">
      <header class="">
        <h1 class="text-md md:text-lg lg:text-lg font-bold text-gray-900">
          Daftar Barang (
          <?php
          $total_barang = count($_SESSION['cart']);
          echo $total_barang;
          ?>
          )
        </h1>
      </header>

      <div class="mt-8 flex flex-col justify-between">
        <ul class="space-y-4 max-h-[300px] overflow-y-auto pr-2 pb-4">
          <?php
          foreach ($cartItems as $index => $item) {
          ?>
            <li>
              <form action="" method="POST" class="flex items-center gap-4">
                <input type="hidden" name="item_index" value="<?= $index ?>">
                <img src="https://placehold.co/400" alt="<?= $item['nama_barang'] ?>" class="size-16 rounded object-cover" />

                <div>
                  <h3 class="text-sm text-gray-900 font-semibold"><?= $item['nama_barang'] ?></h3>

                  <dl class="mt-0.5 space-y-px text-[10px] text-gray-600">
                    <div>
                      <dt class="inline">Kategori:</dt>
                      <dd class="inline"><?= $item['kategori_id'] ?></dd>
                    </div>

                    <div>
                      <dt class="inline">Harga satuan:</dt>
                      <dd class="inline"><?= $item['harga_jual'] ?></dd>
                    </div>
                  </dl>
                </div>

                <div class="flex flex-1 items-center justify-end gap-2">
                  <div class="py-2 px-3 inline-block bg-white border border-gray-200 rounded-lg">
                    <div class="flex items-center gap-x-1.5">
                      <button type="submit" name="update_quantity" value="decrease" <?php echo ($item['quantity'] <= 1) ? 'disabled' : ''; ?> class="w-6 h-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                        <i class='bx bx-minus'></i>
                      </button>
                      <input type="text" min="0" value="<?= $item['quantity'] ?>" class="w-16 h-8 px-2 py-1 border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:border-blue-500" />
                      <button type="submit" name="update_quantity" value="increase" class="w-6 h-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none ">
                        <i class='bx bx-plus'></i>
                      </button>
                    </div>
                  </div>

                  <button type="submit" name="remove_from_cart" class="text-gray-600 transition hover:text-red-600">
                    <i class='bx bx-trash text-red-600'></i>
                  </button>
                </div>
              </form>
            </li>
          <?php } ?>
        </ul>

        <div class="mt-8 flex justify-end border-t border-gray-100 pt-8">
          <form method="POST" class="w-screen max-w-lg space-y-10">
            <dl class="space-y-4 text-sm text-gray-700">
              <div class="flex justify-between font-medium">
                <dt>Total Belanja</dt>
                <dd>Rp. <?= number_format($totalBelanja, 2, ',', '.') ?></dd>
              </div>
              <div class="flex items-center justify-between font-medium">
                <dt>Bayar</dt>
                <dd>
                  <input type="number" name="jumlah_dibayarkan" placeholder="-" class="w-full py-1.5 px-2 rounded-md border border-gray-200 shadow-sm text-sm" required />
                </dd>
              </div>
            </dl>

            <div class="flex justify-end flex-col gap-3">
              <button type="submit" name="submit_to_transaction" class="bg-gray-700 hover:bg-gray-600 block text-center w-full rounded-lg px-5 py-2 text-xs md:text-sm lg:text-sm text-gray-100 transition">
                Bayar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="bg-white p-6 rounded-xl mt-6">
  <form action="" method="POST">
    <table id="datatable-style" class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
      <thead>
        <tr>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Barcode</th>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Nama Barang</th>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Stok</th>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Kategori</th>
          <th class="whitespace-nowrap text-left px-4 py-2 font-semibold text-gray-900">Harga Modal</th>
          <th class="whitespace-nowrap !text-end px-4 py-2 font-semibold text-gray-900">Harga Jual</th>
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
            <form action="" method="POST">
              <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="hidden" name="barcode_barang" value="<?= $row['barcode_barang'] ?>">
                <?= $row['barcode_barang'] ?>
              </td>
              <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                <input type="hidden" name="nama_barang" value="<?= $row['nama_barang'] ?>">
                <?= $row['nama_barang'] ?>
              </td>
              <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= $row['stok'] ?></td>
              <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                <input type="hidden" name="kategori_id" value="<?= $row['kategori_id'] ?>">
                <?= $row['nama_kategori'] ?>
              </td>
              <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?= $row['harga_modal'] ?></td>
              <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-end">
                <input type="hidden" name="harga_jual" value="<?= $row['harga_jual'] ?>">
                <?= $row['harga_jual'] ?>
              </td>
              <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                <div class="flex justify-center items-center gap-2">
                  <button type="submit" name="add_to_cart" class="rounded-lg px-2 py-1 bg-black/90 border hover:bg-black/80 transition-all text-white">
                    <i class='bx bx-cart-add text-white'></i>
                  </button>
                </div>
              </td>
            </form>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </form>
</div>

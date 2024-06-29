<?php
$id = $_GET['id'];
$transaction = getTransactionById($id);

if ($transaction) {
    $items = json_decode($transaction['items'], true);

    foreach ($items as $item) {
        $barcode = $item['barcode_barang'];
        $quantity = $item['quantity'];

        updateStock($barcode, $quantity);
    }

    $delete_data = deleteDatas('transaksi', "id = $id");

    if ($delete_data) {
        echo "<script>alert('Data berhasil dihapus!');document.location.href='?page=laporan-barang-keluar';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');document.location.href='?page=laporan-barang-keluar';</script>";
    }
} else {
    echo "<script>alert('Transaksi tidak ditemukan!');document.location.href='?page=laporan-barang-keluar';</script>";
}

function getTransactionById($id)
{
    global $conn_offline;
    $id = mysqli_real_escape_string($conn_offline, $id);
    $query = "SELECT * FROM transaksi WHERE id = $id";
    $result = mysqli_query($conn_offline, $query);

    if ($result) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

function updateStock($barcode, $quantity)
{
    global $conn_offline;
    $barcode = mysqli_real_escape_string($conn_offline, $barcode);
    $quantity = (int)$quantity;
    $query = "UPDATE barang SET stok = stok + $quantity WHERE barcode_barang = $barcode";
    mysqli_query($conn_offline, $query);

    if (mysqli_errno($conn_offline)) {
        die("Error: " . mysqli_error($conn_offline));
    }
}

function deleteDatas($table, $condition)
{
    global $conn_offline;
    $table = mysqli_real_escape_string($conn_offline, $table);
    $query = "DELETE FROM $table WHERE $condition";
    $statement = mysqli_prepare($conn_offline, $query);

    mysqli_stmt_execute($statement);

    if (mysqli_stmt_errno($statement)) {
        die("Error: " . mysqli_stmt_error($statement));
    }

    mysqli_stmt_close($statement);

    return true;
}
?>

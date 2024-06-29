<?php 



function selectData($table, $columns = "*", $join = "", $condition = "", $orderBy = "", $limit = "")
{
    global $conn_offline;
    $query = "SELECT $columns FROM $table";
    if (!empty($join)) $query .= " " . $join;
    if (!empty($condition)) $query .= " WHERE $condition";
    if (!empty($orderBy)) $query .= " ORDER BY $orderBy";
    if (!empty($limit)) $query .= " LIMIT $limit";

    $statement = mysqli_prepare($conn_offline, $query);
    mysqli_stmt_execute($statement);

    $data = array();
    $result = mysqli_stmt_get_result($statement);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_stmt_close($statement);

    return $data;
}

// Fungsi untuk menghasilkan barcode
// function generateBarcode($id) {
//     $id_str = str_pad((string) $id, 7, '8', STR_PAD_LEFT);
//     $base = '8';
//     return $base . $id_str;
// }
// Fungsi untuk memasukkan data
function insertData($table, $data) {
    global $conn_offline;

    $table = mysqli_real_escape_string($conn_offline, $table);
    $escapedData = array();
    foreach ($data as $column => $value) {
        $escapedColumn = mysqli_real_escape_string($conn_offline, $column);
        $escapedValue = mysqli_real_escape_string($conn_offline, $value);
        $escapedData[$escapedColumn] = $escapedValue;
    }

    $columns = implode(", ", array_keys($escapedData));
    $values = "'" . implode("', '", array_values($escapedData)) . "'";
    $query = "INSERT INTO $table ($columns) VALUES ($values)";
    $statement = mysqli_prepare($conn_offline, $query);
    mysqli_stmt_execute($statement);
    
    if (mysqli_stmt_errno($statement)) {
        die("Error: " . mysqli_stmt_error($statement));
    }
    mysqli_stmt_close($statement);

    // Panggil fungsi mirrorTable setelah insert
   

    return mysqli_insert_id($conn_offline);
}

// Fungsi untuk memperbarui data
function updateData($table, $data, $condition) {
    global $conn_offline;

    $table = mysqli_real_escape_string($conn_offline, $table);
    $escapedData = array();
    foreach ($data as $column => $value) {
        $escapedColumn = mysqli_real_escape_string($conn_offline, $column);
        $escapedValue = mysqli_real_escape_string($conn_offline, $value);
        $escapedData[] = "$escapedColumn = '$escapedValue'";
    }

    $setClause = implode(", ", $escapedData);
    $query = "UPDATE $table SET $setClause WHERE $condition";
    $statement = mysqli_prepare($conn_offline, $query);
    mysqli_stmt_execute($statement);
    
    if (mysqli_stmt_errno($statement)) {
        die("Error: " . mysqli_stmt_error($statement));
    }
    mysqli_stmt_close($statement);

    // Panggil fungsi mirrorTable setelah update

    
}

// Fungsi untuk menghapus data
function deleteData($table, $condition) {
    global $conn_offline;

    $table = mysqli_real_escape_string($conn_offline, $table);
    $query = "DELETE FROM $table WHERE $condition";
    $statement = mysqli_prepare($conn_offline, $query);
    mysqli_stmt_execute($statement);
    
    if (mysqli_stmt_errno($statement)) {
        die("Error: " . mysqli_stmt_error($statement));
    }
    mysqli_stmt_close($statement);
}

// Fungsi untuk menghitung data
function countData($table) {
    global $conn_offline;

    $query = "SELECT COUNT(*) as count FROM $table";
    $statement = mysqli_prepare($conn_offline, $query);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($statement);

    return $row['count'];
}

// Fungsi untuk mendapatkan transaksi terbaru
function getLatestTransactions() {
    global $conn_offline;

    $query = "SELECT id, total_belanja, kembalian FROM transaksi ORDER BY createdAt DESC LIMIT 10";
    $statement = mysqli_prepare($conn_offline, $query);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($statement);

    return $transactions;
}

// Fungsi untuk mendapatkan keuntungan
function getProfit($startDate, $endDate) {
    $totalCosts = getTotalCosts($startDate, $endDate);
    $totalSales = getTotalSales($startDate, $endDate);

    $profit = $totalSales - $totalCosts;
    return $profit;
}

// Fungsi untuk mendapatkan total biaya
function getTotalCosts($startDate, $endDate) {
    global $conn_offline;

    $query = "SELECT items FROM transaksi WHERE createdAt BETWEEN ? AND ?";
    $statement = mysqli_prepare($conn_offline, $query);
    mysqli_stmt_bind_param($statement, "ss", $startDate, $endDate);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $totalCosts = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $items = json_decode($row['items'], true);
        foreach ($items as $item) {
            $barcode_barang = $item['barcode_barang'];
            $quantity = $item['quantity'];
            $cost = getItemCost($barcode_barang);
            $totalCosts += $cost * $quantity;
        }
    }
    mysqli_stmt_close($statement);

    return $totalCosts;
}

// Fungsi untuk mendapatkan biaya item
function getItemCost($barcode_barang) {
    global $conn_offline;

    $query = "SELECT harga_modal FROM barang WHERE barcode_barang = ?";
    $statement = mysqli_prepare($conn_offline, $query);
    mysqli_stmt_bind_param($statement, "s", $barcode_barang);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($statement);

    return $row['harga_modal'];
}

// Fungsi untuk mendapatkan total penjualan
function getTotalSales($startDate, $endDate) {
    global $conn_offline;

    $query = "SELECT SUM(total_belanja) as total_sales FROM transaksi WHERE createdAt BETWEEN ? AND ?";
    $statement = mysqli_prepare($conn_offline, $query);
    mysqli_stmt_bind_param($statement, "ss", $startDate, $endDate);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($statement);

    return $row['total_sales'];
}

// Fungsi untuk memformat angka sebagai Rupiah
function formatRupiah($number) {
    return 'Rp. ' . number_format($number, 2, ',', '.');
}

?>

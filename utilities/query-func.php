<?php 

function selectData($table, $columns = "*", $condition = "", $orderBy = "", $limit = "")
{
    global $conn;
    
    // Bangun query SELECT
    $query = "SELECT $columns FROM $table";

    // Tambahkan kondisi jika ada
    if (!empty($condition)) {
        $query .= " WHERE $condition";
    }

    // Tambahkan ORDER BY jika ada
    if (!empty($orderBy)) {
        $query .= " ORDER BY $orderBy";
    }

    // Tambahkan LIMIT jika ada
    if (!empty($limit)) {
        $query .= " LIMIT $limit";
    }

    // Persiapan statement
    $statement = mysqli_prepare($conn, $query);

    // Eksekusi statement
    mysqli_stmt_execute($statement);

    // Ambil hasil query dalam bentuk array asosiatif
    $data = array();
    $result = mysqli_stmt_get_result($statement);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Tutup statement
    mysqli_stmt_close($statement);

    // Kembalikan hasil query
    return $data;
}

?>
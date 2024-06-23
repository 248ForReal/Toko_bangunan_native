<?php 

function selectData($table, $columns = "*", $join = "", $condition = "", $orderBy = "", $limit = "")
{
    global $conn_online;
    
    // Bangun query SELECT
    $query = "SELECT $columns FROM $table";

    // Tambahkan JOIN jika ada
    if (!empty($join)) {
        $query .= " " . $join;
    }

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
    $statement = mysqli_prepare($conn_online, $query);

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

// INSERT DATA
function insertData($table, $data)
{
    global $conn_online;

    // Escape nama tabel
    $table = mysqli_real_escape_string($conn_online, $table);

    // Escape data
    $escapedData = array();
    foreach ($data as $column => $value) {
        $escapedColumn = mysqli_real_escape_string($conn_online, $column);
        $escapedValue = mysqli_real_escape_string($conn_online, $value);
        $escapedData[$escapedColumn] = $escapedValue;
    }

    // Bangun query INSERT
    $columns = implode(", ", array_keys($escapedData));
    $values = "'" . implode("', '", array_values($escapedData)) . "'";
    $query = "INSERT INTO $table ($columns) VALUES ($values)";

    // Persiapan statement
    $statement = mysqli_prepare($conn_online, $query);

    // Eksekusi statement
    mysqli_stmt_execute($statement);

    // Periksa kesalahan eksekusi statement
    if (mysqli_stmt_errno($statement)) {
        die("Error: " . mysqli_stmt_error($statement));
    }

    // Tutup statement
    mysqli_stmt_close($statement);

}

function updateData($table, $data, $condition)
{
    global $conn_online;

    // Escape nama tabel
    $table = mysqli_real_escape_string($conn_online, $table);

    // Escape data
    $escapedData = array();
    foreach ($data as $column => $value) {
        $escapedColumn = mysqli_real_escape_string($conn_online, $column);
        $escapedValue = mysqli_real_escape_string($conn_online, $value);
        $escapedData[] = "$escapedColumn = '$escapedValue'";
    }

    // Bangun query UPDATE
    $setClause = implode(", ", $escapedData);
    $query = "UPDATE $table SET $setClause WHERE $condition";

    // Persiapan statement
    $statement = mysqli_prepare($conn_online, $query);

    // Eksekusi statement
    mysqli_stmt_execute($statement);

    // Periksa kesalahan eksekusi statement
    if (mysqli_stmt_errno($statement)) {
        die("Error: " . mysqli_stmt_error($statement));
    }

    // Tutup statement
    mysqli_stmt_close($statement);
}

function deleteData($table, $condition)
{
    global $conn_online;

    // Escape nama tabel
    $table = mysqli_real_escape_string($conn_online, $table);

    // Bangun query DELETE
    $query = "DELETE FROM $table WHERE $condition";

    // Persiapan statement
    $statement = mysqli_prepare($conn_online, $query);

    // Eksekusi statement
    mysqli_stmt_execute($statement);

    // Periksa kesalahan eksekusi statement
    if (mysqli_stmt_errno($statement)) {
        die("Error: " . mysqli_stmt_error($statement));
    }

    // Tutup statement
    mysqli_stmt_close($statement);
}

?>
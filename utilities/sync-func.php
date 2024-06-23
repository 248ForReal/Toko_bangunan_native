<?php
function mirrorTable($source_db, $destination_db, $table, $primaryKey) {
    // Nonaktifkan foreign key checks
    $destination_db->query("SET foreign_key_checks = 0");

    // Ambil data dari source database
    $source_data = $source_db->query("SELECT * FROM $table");
    $rows = $source_data->fetch_all(MYSQLI_ASSOC);

    // Truncate table di destination database
    $destination_db->query("TRUNCATE TABLE $table");

    // Siapkan query insert
    foreach ($rows as $row) {
        $columns = array_keys($row);
        $column_list = implode(', ', $columns);
        $param_list = implode(', ', array_fill(0, count($columns), '?'));
        $stmt = $destination_db->prepare("INSERT INTO $table ($column_list) VALUES ($param_list)");

        $types = str_repeat('s', count($row)); // Mengasumsikan semua kolom adalah string, sesuaikan jika diperlukan
        $stmt->bind_param($types, ...array_values($row));
        $stmt->execute();
    }

    // Aktifkan kembali foreign key checks
    $destination_db->query("SET foreign_key_checks = 1");
}
?>

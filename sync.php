<?php
include 'config.php';

function syncTable($local_db, $online_db, $table, $primaryKey) {
    $local_data = $local_db->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);
    $online_data = $online_db->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);

    $local_data_map = [];
    foreach ($local_data as $row) {
        $local_data_map[$row[$primaryKey]] = $row;
    }

    $online_data_map = [];
    foreach ($online_data as $row) {
        $online_data_map[$row[$primaryKey]] = $row;
    }

    foreach ($local_data as $row) {
        if (isset($online_data_map[$row[$primaryKey]])) {
            $online_row = $online_data_map[$row[$primaryKey]];
            if ($row != $online_row) {
                $columns = array_keys($row);
                $set_clause = [];
                foreach ($columns as $column) {
                    $set_clause[] = "$column = :$column";
                }
                $set_clause = implode(', ', $set_clause);
                $stmt = $online_db->prepare("UPDATE $table SET $set_clause WHERE $primaryKey = :$primaryKey");
                $stmt->execute($row);
            }
        } else {
            $columns = array_keys($row);
            $column_list = implode(', ', $columns);
            $param_list = implode(', ', array_map(fn($col) => ":$col", $columns));
            $stmt = $online_db->prepare("INSERT INTO $table ($column_list) VALUES ($param_list)");
            $stmt->execute($row);
        }
    }

    foreach ($online_data as $row) {
        if (!isset($local_data_map[$row[$primaryKey]])) {
            $columns = array_keys($row);
            $column_list = implode(', ', $columns);
            $param_list = implode(', ', array_map(fn($col) => ":$col", $columns));
            $stmt = $local_db->prepare("INSERT INTO $table ($column_list) VALUES ($param_list)");
            $stmt->execute($row);
        }
    }
}


$tables = [
    'admins' => 'id',
    'barang' => 'id',
    'kategoris' => 'id',
    'sessions' => 'sid',
    'transaksi' => 'id',
    'transaksi_barang' => 'id'
];


try {
    foreach ($tables as $table => $primaryKey) {
        syncTable($local_db, $online_db, $table, $primaryKey);
    }
    header('Location: index.php?sync_status=Sinkronisasi berhasil');
} catch (Exception $e) {

    header('Location: index.php?sync_status=Sinkronisasi gagal: ' . $e->getMessage());
}
exit();
?>

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

    function generateBarcode($id)
    {
        $id_str = (string) $id;
        $base = '8';
        while (strlen($id_str) + strlen($base) < 8) {
            $base .= '8';
        }
        return $base . $id_str;
    }

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

        return mysqli_insert_id($conn_online); // Mengembalikan ID yang baru dimasukkan
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

    function countData($table)
    {
        global $conn_online;

        // Bangun query COUNT
        $query = "SELECT COUNT(*) as count FROM $table";

        // Persiapan statement
        $statement = mysqli_prepare($conn_online, $query);

        // Eksekusi statement
        mysqli_stmt_execute($statement);

        // Ambil hasil query
        $result = mysqli_stmt_get_result($statement);
        $row = mysqli_fetch_assoc($result);

        // Tutup statement
        mysqli_stmt_close($statement);

        // Kembalikan hasil query
        return $row['count'];
    }

    function getLatestTransactions()
    {
        global $conn_online;

        // Bangun query SELECT
        $query = "SELECT id, total_belanja, kembalian FROM transaksi ORDER BY createdAt DESC LIMIT 10";

        // Persiapan statement
        $statement = mysqli_prepare($conn_online, $query);

        // Eksekusi statement
        mysqli_stmt_execute($statement);

        // Ambil hasil query
        $result = mysqli_stmt_get_result($statement);
        $transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Tutup statement
        mysqli_stmt_close($statement);

        // Kembalikan hasil query
        return $transactions;
    }



    // Function to get profit
    function getProfit($startDate, $endDate)
    {
        $totalCosts = getTotalCosts($startDate, $endDate);
        $totalSales = getTotalSales($startDate, $endDate);

        $profit = $totalSales - $totalCosts;
        return $profit;
    }

    // Function to get total costs
    function getTotalCosts($startDate, $endDate)
    {
        global $conn_online;

        $query = "SELECT items FROM transaksi WHERE createdAt BETWEEN ? AND ?";
        $statement = mysqli_prepare($conn_online, $query);
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

    // Function to get item cost
    function getItemCost($barcode_barang)
    {
        global $conn_online;

        $query = "SELECT harga_modal FROM barang WHERE barcode_barang = ?";
        $statement = mysqli_prepare($conn_online, $query);
        mysqli_stmt_bind_param($statement, "s", $barcode_barang);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($statement);

        return $row['harga_modal'];
    }

    // Function to get total sales
    function getTotalSales($startDate, $endDate)
    {
        global $conn_online;

        $query = "SELECT SUM(total_belanja) as total_sales FROM transaksi WHERE createdAt BETWEEN ? AND ?";
        $statement = mysqli_prepare($conn_online, $query);
        mysqli_stmt_bind_param($statement, "ss", $startDate, $endDate);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($statement);

        return $row['total_sales'];
    }

    // Function to format number as Rupiah
    function formatRupiah($number)
    {
        return 'Rp. ' . number_format($number, 2, ',', '.');
    }


    ?>
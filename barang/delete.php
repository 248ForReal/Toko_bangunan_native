<?php
require '../config.php';

function isInternetAvailable() {
    $url = 'https://www.google.com';
    $headers = @get_headers($url);
    return $headers && strpos($headers[0], '200');
}

$db = isInternetAvailable() ? $online_db : $local_db;

$id = $_GET['id'];

$stmt = $db->prepare("DELETE FROM barang WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit();
?>

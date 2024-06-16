<?php

DEFINE("HOST", "localhost");
DEFINE("USER", "root");
DEFINE("PASS", "");
DEFINE("DB", "tokobangunan_offline");
$conn = new mysqli(HOST,USER,PASS,DB);
if($conn->connect_errno){
	die("Koneksi Gagal : ". $conn->connect_errno);
}

?>
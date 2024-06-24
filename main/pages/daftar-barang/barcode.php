<?php
use Picqer\Barcode\BarcodeGeneratorPNG;

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['barcode']) && !empty($_POST['barcode'])) {
        BuatGambarBarcode($_POST['barcode']);
    } else {
        echo 'Error: Barcode not set or empty.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        BuatGambarBarcode($_GET['id']);
    } else {
        echo 'Error: Barcode ID not set or empty.';
    }
}

// Function to generate barcode
function BuatGambarBarcode($barcodeText) {
    $barcodeText = htmlspecialchars($barcodeText, ENT_QUOTES, 'UTF-8');
    $generator = new BarcodeGeneratorPNG();
    $folderPath = 'assets/images/barcode/';
    $file = $folderPath . 'barcode_' . $barcodeText . '.png';
    
    // Check if the directory exists, if not create it
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0755, true);
    }

    try {
        file_put_contents($file, $generator->getBarcode($barcodeText, $generator::TYPE_CODE_128));
        echo "<img src='$file' alt='Barcode' class='barcode-img'>";
        echo "<script>
                window.onload = function() {
                    window.print();
                };
                window.onafterprint = function() {
                    alert('Barcode Berhasil dicetak');
                    window.location.href = '?page=daftar-barang';
                };
              </script>";
    } catch (Exception $e) {
        error_log('Error generating barcode: ' . $e->getMessage());
        echo 'Error generating barcode. Please try again later.';
    }
}
?>

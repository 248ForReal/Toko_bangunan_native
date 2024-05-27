<?php
require 'vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['barcode']) && !empty($_POST['barcode'])) {
        $barcodeText = $_POST['barcode'];

        $generator = new BarcodeGeneratorPNG();
        $file = 'barcode_' . $barcodeText . '.png';
        
        try {
            file_put_contents($file, $generator->getBarcode($barcodeText, $generator::TYPE_CODE_128));
            echo "<img src='$file' alt='Barcode' class='barcode-img'>";
            echo "<button onclick='window.print();'>Cetak Barcode</button>";
        } catch (Exception $e) {
            echo 'Error generating barcode: ',  $e->getMessage(), "\n";
        }
    } else {
        echo 'Error: Barcode not set or empty.';
    }
}
?>

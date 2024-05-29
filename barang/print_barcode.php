<?php
require '../vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    $generator = new BarcodeGeneratorPNG();
    $barcodeFile = '../barcode/barcode_' . $barcode . '.png';

    if (!file_exists($barcodeFile)) {
        file_put_contents($barcodeFile, $generator->getBarcode($barcode, $generator::TYPE_CODE_128));
    }

    echo "<img src='$barcodeFile' alt='Barcode' class='barcode-img'>";
    echo "<script>window.print();</script>";
} else {
    echo 'Error: Barcode tidak tersedia.';
}
?>

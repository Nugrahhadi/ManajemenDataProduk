<?php
include_once 'config/koneksi.php';
include_once 'objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$product->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID produk tidak ditemukan.');

if ($product->delete()) {
    header("Location: index.php?action=deleted");
} else {
    echo "<div class='alert alert-danger'>Gagal menghapus produk.</div>";
}

<?php
include_once 'config/koneksi.php';
include_once 'objects/category.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID kategori tidak ditemukan.');

if ($category->delete()) {
    header("Location: categories.php?action=deleted");
} else {
    echo "<div class='alert alert-danger'>Gagal menghapus kategori.</div>";
}

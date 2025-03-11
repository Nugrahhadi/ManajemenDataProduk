<?php
include_once 'config/koneksi.php';
include_once 'objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$product->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID produk tidak ditemukan.');

$product->readOne();

$page_title = "Detail Produk";
include_once "header.php";
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Produk</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk:</label>
                        <p><?php echo $product->name; ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori:</label>
                        <p><?php echo $product->category_name ? $product->category_name : "Tidak ada kategori"; ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Harga:</label>
                        <p>Rp <?php echo number_format($product->price, 2, ',', '.'); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Stok:</label>
                        <p><?php echo $product->stock; ?></p>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary me-md-2">Kembali ke Daftar</a>
                        <a href="update_product.php?id=<?php echo $product->id; ?>" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once "footer.php";
?>
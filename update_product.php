<?php
include_once 'config/koneksi.php';
include_once 'objects/product.php';
include_once 'objects/category.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$category = new Category($db);

$product->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID produk tidak ditemukan.');

$product->readOne();

$page_title = "Edit Produk";
include_once "header.php";

if ($_POST) {
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->stock = $_POST['stock'];
    $product->category_id = $_POST['category_id'];

    // Update the product
    if ($product->update()) {
        echo "<div class='alert alert-success'>Produk berhasil diperbarui.</div>";
        echo "<script>
            setTimeout(function(){
                window.location.href = 'index.php';
            }, 2000);
        </script>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui produk. Silakan coba lagi.</div>";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Produk</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$product->id}"); ?>" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo $product->name; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">Pilih Kategori (Opsional)</option>
                                <?php
                                $stmt = $category->readAll();

                                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_category);
                                    $selected = $product->category_id == $id ? "selected" : "";
                                    echo "<option value='{$id}' {$selected}>{$name}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="price" id="price" value="<?php echo $product->price; ?>" min="0" step="0.01" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stock" id="stock" value="<?php echo $product->stock; ?>" min="0" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once "footer.php";
?>
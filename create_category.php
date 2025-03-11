<?php
include_once 'config/koneksi.php';
include_once 'objects/category.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$page_title = "Tambah Kategori";
include_once "header.php";

if ($_POST) {
    $category->name = $_POST['name'];

    if ($category->create()) {
        echo "<div class='alert alert-success'>Kategori berhasil ditambahkan.</div>";
        echo "<script>
        setTimeout(function(){
        window.location.href = 'categories.php';
    }, 2000);
    </script>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan kategori. Silakan coba lagi.</div>";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Kategori Baru</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="categories.php" class="btn btn-secondary me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
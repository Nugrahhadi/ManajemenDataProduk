<?php
include_once 'config/koneksi.php';
include_once 'objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$page_title = "Manajemen Data Produk";
include_once "header.php";

if (isset($_GET['action']) && $_GET['action'] == 'deleted') {
    echo "<div class='alert alert-success'>Produk berhasil dihapus.</div>";
}
?>

<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Daftar Produk</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="create_product.php" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Produk
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table id="productsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $product->readAll();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    echo "<tr>";
                    echo "<td>{$id}</td>";
                    echo "<td>{$name}</td>";
                    echo "<td>" . ($category_name ? $category_name : "Tidak ada kategori") . "</td>";
                    echo "<td>Rp " . number_format($price, 2, ',', '.') . "</td>";
                    echo "<td>{$stock}</td>";
                    echo "<td>";
                    echo "<a href='read_product.php?id={$id}' class='btn btn-info btn-sm me-1' title='Lihat'><i class='bi bi-eye'></i></a>";
                    echo "<a href='update_product.php?id={$id}' class='btn btn-primary btn-sm me-1' title='Edit'><i class='bi bi-pencil'></i></a>";
                    echo "<a href='delete_product.php?id={$id}' class='btn btn-danger btn-sm' title='Hapus' onclick='return confirm(\"Yakin ingin menghapus produk ini?\")'><i class='bi bi-trash'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#productsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            }
        });
    });
</script>

<?php
include_once "footer.php";
?>
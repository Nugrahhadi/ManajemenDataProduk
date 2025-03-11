<?php
include_once 'config/koneksi.php';
include_once 'objects/category.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$page_title = "Manajemen Kategori";
include_once "header.php";
?>

<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Daftar Kategori</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="create_category.php" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Kategori
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table id="categoriesTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $category->readAll();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    echo "<tr>";
                    echo "<td>{$id}</td>";
                    echo "<td>{$name}</td>";
                    echo "<td>";
                    echo "<a href='update_category.php?id={$id}' class='btn btn-primary btn-sm me-1'><i class='bi bi-pencil'></i></a>";
                    echo "<a href='delete_category.php?id={$id}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus kategori ini?\")'><i class='bi bi-trash'></i></a>";
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
        $('#categoriesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            }
        });
    });
</script>

<?php
include_once "footer.php";
?>
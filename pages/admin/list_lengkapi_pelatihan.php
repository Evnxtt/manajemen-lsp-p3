<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'Anda bukan user!',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = '../auth/login.php';
      });
    </script>";
    exit;
}

require '../../vendor/autoload.php'; // MongoDB library
use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->pelatihan;

$beritaList = $collection->find([], ['sort' => ['pembuatan' => -1]]);

?>
<!-- Include Header -->
<link rel="stylesheet" href="../assets/css/vertical-layout-light/testcss.css">

<?php include 'templates/header.php'; ?>

<?php if (isset($_GET['hapus'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($_GET['hapus'] === 'berhasil'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berita berhasil dihapus!',
                    confirmButtonText: 'OK'
                });
            <?php elseif ($_GET['hapus'] === 'gagal'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menghapus berita!',
                    confirmButtonText: 'OK'
                });
            <?php elseif ($_GET['hapus'] === 'error'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan saat menghapus!',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    </script>
<?php endif; ?>

<?php
if (isset($_SESSION['success_message'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: '" . $_SESSION['success_message'] . "',
            confirmButtonText: 'OK'
        });
    </script>";
    unset($_SESSION['success_message']);
}
?>

<!-- partial -->

<!-- partial -->
<div class="main-panel" style="background-color: #F5F7FF;">
    <div class="container">
        <?php
        $beritaList = $collection->find([], ['sort' => ['pembuatan' => -1]]); // Urutkan berdasarkan tanggal pembuatan

        foreach ($beritaList as $berita):
            $judul = $berita['detail_pelatihan']['nama_pelatihan'] ?? '';
            $ringkasan = $berita['detail_pelatihan']['deskripsi'] ?? '';
            $gambar = $berita['gambar'] ?? '../assets/images/training/default.svg';

            $id = (string)$berita['_id'];
        ?>
            <div class="card">
                <img src="<?= htmlspecialchars($gambar) ?>" alt="news" style="max-height: 200px; object-fit: cover;">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;"><?= htmlspecialchars($judul) ?></h2>
                    <p><?= htmlspecialchars($ringkasan) ?></p>
                    <a href="lengkapi_pelatihan.php?id=<?= $id ?>" class="btn btn-warning">Lengkapi Pelatihan</a>
                    <!-- <a href="#" class="btn btn-danger" onclick="confirmDelete('<?= $id ?>')">Hapus</a> -->
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus pelatihan ini?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'hapus_pelatihan.php?id=' + id;
            }
        });
    }
</script>

<!-- Include Footer -->
<?php include 'templates/footer.php'; ?>
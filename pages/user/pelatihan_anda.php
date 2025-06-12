<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "user") {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
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

require '../../vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$collectionPelatihan = $client->lsp_p3->pelatihan;
$collectionPendaftaran = $client->lsp_p3->pendaftaran_pelatihan;

$userId = new MongoDB\BSON\ObjectId($_SESSION['user_id']);

// Ambil hanya pendaftaran yang statusnya terverifikasi
$pendaftaranList = $collectionPendaftaran->find([
    'id_user' => $userId,
    'status' => 'terverifikasi'
]);
?>
<!-- Include Header -->
<link rel="stylesheet" href="../assets/css/vertical-layout-light/testcss.css">
<?php include 'templates/header.php'; ?>

<div class="main-panel" style="background-color: #F5F7FF;">
    <div class="container">
        <?php
        $adaData = false;
        foreach ($pendaftaranList as $pendaftaran):
            $idPelatihan = $pendaftaran['id_pelatihan'];
            $pelatihan = $collectionPelatihan->findOne(['_id' => $idPelatihan]);
            $judul = $pelatihan['detail_pelatihan']['nama_pelatihan'] ?? '';
            $ringkasan = $pelatihan['detail_pelatihan']['deskripsi'] ?? '';
            $gambar = $pelatihan['gambar'] ?? '../assets/images/training/default.svg';
            $id = (string)$pelatihan['_id'];
            $adaData = true;
        ?>
            <div class="card" style="margin-bottom: 20px;">
                <img src="<?= htmlspecialchars($gambar) ?>" alt="news" style="max-height: 200px; object-fit: cover;">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;"><?= htmlspecialchars($judul) ?></h2>
                    <p><?= htmlspecialchars($ringkasan) ?></p>
                    <p><b>Status Pendaftaran:</b> <?= htmlspecialchars($pendaftaran['status'] ?? '-') ?></p>
                    <a href="detail_pelatihan_anda.php?id=<?= $id ?>" class="btn btn-info" style="width:100%;">Lihat Detail Pelatihan</a>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (!$adaData): ?>
            <div class="alert alert-info mt-4">Belum ada pelatihan yang terverifikasi.</div>
        <?php endif; ?>
    </div>
</div>
<?php include 'templates/footer.php'; ?>
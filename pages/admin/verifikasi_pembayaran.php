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
        title: 'Anda bukan admin!',
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
$collectionPendaftaran = $client->lsp_p3->pendaftaran_pelatihan;

// Ambil semua pendaftaran dengan status "Menunggu Verifikasi"
$menungguVerifikasi = iterator_to_array($collectionPendaftaran->find(['status' => 'Menunggu Verifikasi']));

include 'templates/header.php';
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Verifikasi Pembayaran Pendaftaran</h4>
                    <p class="card-description">
                        Silakan verifikasi pembayaran pendaftaran peserta
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Peserta</th>
                                    <th>Email</th>
                                    <th>Nama Pelatihan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menungguVerifikasi as $pendaftaran): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($pendaftaran['nama_peserta'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($pendaftaran['email'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($pendaftaran['nama_pelatihan'] ?? '-') ?></td>
                                        <td><span class="badge badge-warning"><?= htmlspecialchars($pendaftaran['status']) ?></span></td>
                                        <td>
                                            <a href="verifikasi_detail.php?id=<?= $pendaftaran['_id'] ?>" class="badge badge-info">Verifikasi</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if (count($menungguVerifikasi) === 0): ?>
                            <div class="alert alert-info mt-4">Tidak ada data pendaftaran yang menunggu verifikasi.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'templates/footer.php'; ?>
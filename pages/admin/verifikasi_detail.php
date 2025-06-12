<?php
session_start();
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../auth/login.php");
    exit;
}

require '../../vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$collectionPendaftaran = $client->lsp_p3->pendaftaran_pelatihan;

// Fungsi untuk cek ekstensi gambar
function is_image($filename)
{
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
}

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$pendaftaran = $collectionPendaftaran->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if (!$pendaftaran) {
    echo "Data tidak ditemukan.";
    exit;
}

// Ambil nama peserta dari embedded informasi_pribadi
$namaPeserta = '-';
if (
    isset($pendaftaran['informasi_pribadi']['nama_depan']) ||
    isset($pendaftaran['informasi_pribadi']['nama_belakang'])
) {
    $nama_depan = $pendaftaran['informasi_pribadi']['nama_depan'] ?? '';
    $nama_belakang = $pendaftaran['informasi_pribadi']['nama_belakang'] ?? '';
    $namaPeserta = trim($nama_depan . ' ' . $nama_belakang);
}
$emailPeserta = $pendaftaran['informasi_pribadi']['email'] ?? '-';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verifikasi'])) {
        $collectionPendaftaran->updateOne(
            ['_id' => $pendaftaran['_id']],
            ['$set' => ['status' => 'terverifikasi']]
        );
        header("Location: verifikasi_detail.php?id=$id&success=verifikasi");
        exit;
    }
    if (isset($_POST['batal'])) {
        $collectionPendaftaran->updateOne(
            ['_id' => $pendaftaran['_id']],
            ['$set' => ['status' => 'ditolak']]
        );
        header("Location: verifikasi_detail.php?id=$id&success=tolak");
        exit;
    }
}

include 'templates/header.php';
?>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_GET['success']) && $_GET['success'] === 'verifikasi'): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Pembayaran telah diverifikasi.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'verifikasi_pembayaran.php';
        });
    </script>
<?php elseif (isset($_GET['success']) && $_GET['success'] === 'tolak'): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Ditolak!',
            text: 'Pembayaran telah ditolak.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'verifikasi_pembayaran.php';
        });
    </script>
<?php endif; ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-8 grid-margin stretch-card mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Verifikasi Pembayaran</h4>
                    <p><b>Nama Peserta:</b> <?= htmlspecialchars($namaPeserta) ?></p>
                    <p><b>Email:</b> <?= htmlspecialchars($emailPeserta) ?></p>
                    <p><b>Nama Pelatihan:</b> <?= htmlspecialchars($pendaftaran['nama_pelatihan'] ?? '-') ?></p>
                    <hr>
                    <h5>Bukti Pembayaran:</h5>
                    <?php if (!empty($pendaftaran['pembayaran']['bukti_pembayaran'])): ?>
                        <?php $bukti = $pendaftaran['pembayaran']['bukti_pembayaran']; ?>
                        <?php if (is_image($bukti)): ?>
                            <a href="../../<?= htmlspecialchars($bukti) ?>" target="_blank">
                                <img src="../../<?= htmlspecialchars($bukti) ?>" alt="Bukti Pembayaran" style="max-width:300px;max-height:300px;">
                            </a>
                        <?php else: ?>
                            <a href="../../<?= htmlspecialchars($bukti) ?>" target="_blank" class="btn btn-info">Unduh Bukti Pembayaran</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-danger">Bukti pembayaran tidak tersedia.</p>
                    <?php endif; ?>
                    <h5 class="mt-3">Bukti Pendaftaran:</h5>
                    <?php if (!empty($pendaftaran['pembayaran']['bukti_pendaftaran'])): ?>
                        <?php $bukti = $pendaftaran['pembayaran']['bukti_pendaftaran']; ?>
                        <?php if (is_image($bukti)): ?>
                            <a href="../../<?= htmlspecialchars($bukti) ?>" target="_blank">
                                <img src="../../<?= htmlspecialchars($bukti) ?>" alt="Bukti Pendaftaran" style="max-width:300px;max-height:300px;">
                            </a>
                        <?php else: ?>
                            <a href="../../<?= htmlspecialchars($bukti) ?>" target="_blank" class="btn btn-info">Unduh Bukti Pendaftaran</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-danger">Bukti pendaftaran tidak tersedia.</p>
                    <?php endif; ?>

                    <form method="post" class="mt-4" id="form-verifikasi">
                        <button type="submit" name="verifikasi" class="btn btn-success">Verifikasi Pembayaran</button>
                        <button type="button" id="btn-batal" class="btn btn-danger">Batal</button>
                        <input type="hidden" name="batal" value="1" id="input-batal">
                        <a href="verifikasi_pembayaran.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btn-batal').addEventListener('click', function(e) {
        Swal.fire({
            title: 'Yakin ingin menolak pembayaran ini?',
            text: "Tindakan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-verifikasi').submit();
            }
        });
    });
</script>
<?php include 'templates/footer.php'; ?>
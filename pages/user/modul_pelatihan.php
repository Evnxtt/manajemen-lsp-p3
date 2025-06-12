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
$collectionUser = $client->lsp_p3->users;

// Ambil id_pelatihan dari GET
$id_pelatihan = isset($_GET['id_pelatihan']) ? $_GET['id_pelatihan'] : null;
$nama_pelatihan = isset($_GET['nama_pelatihan']) ? urldecode($_GET['nama_pelatihan']) : '';
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? urldecode($_GET['tanggal_mulai']) : '';

if (!$id_pelatihan) {
    echo "ID pelatihan tidak ditemukan.";
    exit;
}

// Ambil data pelatihan
try {
    $pelatihan = $collectionPelatihan->findOne(['_id' => new MongoDB\BSON\ObjectId($id_pelatihan)]);
    if (!$pelatihan) {
        echo "Data pelatihan tidak ditemukan.";
        exit;
    }
} catch (Exception $e) {
    echo "ID pelatihan tidak valid.";
    exit;
}

// Ambil data user
$userId = new MongoDB\BSON\ObjectId($_SESSION['user_id']);
$user = $collectionUser->findOne(['_id' => $userId]);

// Data pelatihan
$detail = $pelatihan['detail_pelatihan'] ?? [];
$gambar = $pelatihan['gambar'] ?? '../assets/images/news/default.svg';
$nama_pelatihan = $detail['nama_pelatihan'] ?? $nama_pelatihan;
$deskripsi = $detail['deskripsi'] ?? '-';
$persyaratan = $detail['persyaratan'] ?? '-';
$unit = $detail['unit_kompetensi'] ?? [];
$judul_skema = $detail['judul_skema'] ?? '-';
$nomor_skema = $detail['nomor_skema'] ?? '-';
$biaya = $detail['biaya'] ?? 0;
$kuota = $pelatihan['kuota'] ?? '-';
$status = $pelatihan['status'] ?? '-';
$durasi = $pelatihan['durasi'] ?? '-';

$biaya_formatted = 'Rp ' . number_format($biaya, 0, ',', '.');

$collectionModul = $client->lsp_p3->modul_pelatihan;

// Ambil data modul_pelatihan
$modul = $collectionModul->findOne(['id_pelatihan' => (string)$id_pelatihan]);
$daftar_modul = $modul['daftar_modul'] ?? [];

// Hitung jumlah tiap tipe modul
$jml_sesi_materi = 0;
$jml_studi_kasus = 0;
$jml_uji_kompetensi = 0;
foreach ($daftar_modul as $dm) {
    if ($dm['tipe'] === 'Sesi Materi') $jml_sesi_materi++;
    if ($dm['tipe'] === 'Studi Kasus') $jml_studi_kasus++;
    if ($dm['tipe'] === 'Uji Kompetensi') $jml_uji_kompetensi++;
}
?>
<!-- Include Header -->
<?php include 'templates/header.php'; ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div style="display: flex; flex-direction: row; justify-content: flex-start;">
            <div class="card" style="padding: 10px; width: 70%; height: auto; margin-right: 25px;">
                <div class="card-body">
                    <h4 class="card-title"><?= htmlspecialchars($nama_pelatihan) ?></h4>
                    <hr>
                    <h5 style="font-weight:bold;">Daftar Modul</h5>
                    <?php if (count($daftar_modul) > 0): ?>
                        <?php foreach ($daftar_modul as $i => $mod): ?>
                            <button type="button" class="btn btn-inverse-warning btn-fw" style="margin-bottom: 12px; padding: 10px 20px; display: flex; align-items: center; justify-content: space-between; width: 100%; height: 40px;">
                                <span style="color: #595846; margin-right: 8px;">
                                    <?= ($i + 1) . " – " . htmlspecialchars($mod['nama']) . " (" . htmlspecialchars($mod['tipe']) . ")" ?>
                                </span>
                                <div class="progress progress-md" style="width: 100px; height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </button>
                        <?php endforeach; ?>
                        <!-- Tombol Unduh Sertifikat -->
                        <a href="unduh_sertifikat.php?id_pelatihan=<?= urlencode($id_pelatihan) ?>"
                            class="btn btn-inverse-success btn-fw"
                            style="margin-bottom: 12px; padding: 10px 20px; display: flex; align-items: center; justify-content: center; width: 100%; height: 40px; font-weight: bold;">
                            <span style="color: #fff; margin-right: 8px;">
                                <i class="mdi mdi-certificate" style="font-size: 20px;"></i> Unduh Sertifikat
                            </span>
                        </a>
                    <?php else: ?>
                        <p>Tidak ada modul tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card" style="padding: 10px; overflow: hidden; width: 30%; height: 100%;box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <img src="<?= htmlspecialchars($gambar) ?>" alt="Banner" style="width: 100%; height: auto; display: block; margin-bottom: 20px; border-radius: 12px;">
                    <p style="font-weight: bold; font-size: 18px;"><?= htmlspecialchars($nama_pelatihan) ?></p>
                    <p style="font-size: 14px; color: gray;"><?= htmlspecialchars($judul_skema) ?></p>
                    <div style="margin-top: 12px;">
                        <p style="font-weight: bold;">Pelatihan yang tersedia</p>
                        <ul style="padding-left: 20px; margin: 0;">
                            <li><?= $jml_sesi_materi ?> Sesi Materi</li>
                            <li><?= $jml_studi_kasus ?> Studi Kasus</li>
                            <li><?= $jml_uji_kompetensi ?> Uji Kompetensi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- partial -->
<?php include 'templates/footer.php'; ?>
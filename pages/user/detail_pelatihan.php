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
$collection = $client->lsp_p3->pelatihan;

if (!isset($_GET['id'])) {
  echo "ID pelatihan tidak ditemukan.";
  exit;
}

$id = $_GET['id'];

try {
  $berita = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
  if (!$berita) {
    echo "Data pelatihan tidak ditemukan.";
    exit;
  }
} catch (Exception $e) {
  echo "ID tidak valid.";
  exit;
}

// Ambil data dari dokumen
$detail = $berita['detail_pelatihan'] ?? [];
$nama_pelatihan = $detail['nama_pelatihan'] ?? 'Nama pelatihan tidak tersedia';
$deskripsi = $detail['deskripsi'] ?? '-';
$persyaratan = $detail['persyaratan'] ?? '-';
$unit = $detail['unit_kompetensi'] ?? '-';
$judul_skema = $detail['judul_skema'] ?? '-';
$nomor_skema = $detail['nomor_skema'] ?? '-';
$biaya = $detail['biaya'] ?? 0;

$metode = $berita['metode'] ?? '-';
$tempat = $berita['tempat'] ?? '-';
$ruangan = $berita['ruangan'] ?? '-';
$tautan = $berita['tautan'] ?? '-';
$platform = $berita['platform'] ?? '-';

$tanggal_mulai = isset($berita['tanggal_mulai']) ? $berita['tanggal_mulai']->toDateTime()->format('d M Y') : '-';
$batas_daftar = isset($berita['batas_daftar']) ? $berita['batas_daftar']->toDateTime()->format('d M Y') : '-';

$durasi = $berita['durasi'] ?? '-';
$kuota = $berita['kuota'] ?? '-';
$status = $berita['status'] ?? '-';

$gambar = $berita['gambar'] ?? '../assets/images/news/default.svg';

$biaya_formatted = 'Rp ' . number_format($biaya, 0, ',', '.');
?>

<?php include 'templates/header.php'; ?>

<div class="main-panel">
  <div class="content-wrapper" style="max-width: auto; margin: 0 auto; padding: 20px;">
    <div class="card-body-besar" style="background-color: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
      <img src="<?= htmlspecialchars($gambar) ?>" style="width: 100%; height: auto; border-radius: 20px; object-fit: cover; margin-bottom: 20px;" alt="news">
      <h2 class="course-title" style="font-size: 25px; margin-bottom: 16px;"><?= htmlspecialchars($nama_pelatihan) ?></h2>
      <div style="display: flex; flex-direction: row; justify-content: flex-start;">
        <div class="card-modul" style="max-width:50%; margin-right:5%">
          <p style="margin-bottom: 30px;"><?= htmlspecialchars($deskripsi) ?></p>
          <p class="font-weight-bold" style="font-size: 17px; margin-bottom: 6px;">Metode Pelatihan :</p>
          <ul class="list-star">
            <?php if (isset($berita['metode']) && is_array($berita['metode'])): ?>
              <?php foreach ($berita['metode'] as $m): ?>
                <li style="font-size: 16px; margin-bottom: 5px;"><?= htmlspecialchars($m) ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li style="font-size: 16px; margin-bottom: 5px;"><?= htmlspecialchars($metode) ?></li>
            <?php endif; ?>
          </ul>
          <blockquote class="blockquote" style="margin: 0%;">
            <div style="display: flex; align-items: center; gap: 6px;">
              <i class="ti-location-pin" style="font-size: 15px;"></i>
              <span style="font-weight: bold; font-size: 15px;">Tempat Pelatihan :</span>
            </div>
            <p style="margin-bottom: 30px; margin-left: 22px; margin-top: 6px;"><?= htmlspecialchars($tempat) ?></p>
            <div style="display: flex; align-items: center; gap: 6px;">
              <i class="mdi mdi-timetable" style="font-size: 15px; line-height: 1;"></i>
              <span style="font-weight: bold; font-size: 15px;">Tanggal Pelatihan :</span>
            </div>
            <p style="margin-bottom: 30px; margin-left: 22px; margin-top: 6px;"><?= htmlspecialchars($tanggal_mulai) ?></p>
            <div style="display: flex; align-items: center; gap: 6px;">
              <i class="mdi mdi-timelapse" style="font-size: 15px; line-height: 1;"></i>
              <span style="font-weight: bold; font-size: 15px;">Durasi Pelatihan :</span>
            </div>
            <p style="margin-left: 22px; margin-top: 6px;"><?= htmlspecialchars($durasi) ?> Jam</p>
          </blockquote>
        </div>
        <div class="card-modul" style="max-width:40%; display: flex; flex-direction: column;">
          <div style="margin-left: 20px;">
            <p class="font-weight-bold" style="font-size: 15px; margin-bottom: 6px;">Persyaratan Peserta :</p>
            <?php if (is_array($persyaratan)): ?>
              <?php foreach ($persyaratan as $p): ?>
                <li style="font-size: 14px; margin-bottom: 5px;"><?= htmlspecialchars($p) ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li style="font-size: 14px; margin-bottom: 5px;"><?= htmlspecialchars($persyaratan) ?></li>
            <?php endif; ?><br>
          </div>
          <div class="card card-light-blue" style="width: 100%; margin-bottom: 15px;">
            <div class="card-body">
              <div style="display: flex; align-items: center; gap: 10px;">
                <i class="mdi mdi-account-multiple" style="font-size: 20px; color: #ffffff; line-height: 1;"></i>
                <span style="font-weight: bold; font-size: 90%; margin-bottom: 1px;">KUOTA PESERTA</span>
              </div>
              <span style="font-size: 180%; margin-top: 20px;"><?= htmlspecialchars($kuota) ?></span>
            </div>
          </div>
          <!-- <div class="card card-light-blue" style="width: 100%; margin-bottom: 20px;">
            <div class="card-body">
              <div style="display: flex; align-items: center; gap: 10px;">
                <i class="mdi mdi-star" style="font-size: 20px; color: #ffffff; line-height: 1;"></i>
                <span style="font-weight: bold; font-size: 90%; margin-bottom: 1px;">RATING PELATIHAN</span>
              </div>
              <span style="font-size: 180%; margin-top: 20px;">
                <?= isset($berita['rating']) ? htmlspecialchars($berita['rating']) : '9,8/10' ?>
              </span>
            </div>
          </div> -->
          <div class="card-body" style="margin-bottom: 1px;">
            <h5 class="card-title" style="font-size: 16px; font-weight: bold;">Status Pelatihan</h5>
            <p class="card-text" style="font-size: 14px;"><?= htmlspecialchars($status) ?></p>
          </div>
        </div>
      </div><br>
      <a href="pendaftaran.php?id_pelatihan=<?= urlencode($id) ?>&nama_pelatihan=<?= urlencode($nama_pelatihan) ?>&tanggal_mulai=<?= urlencode($tanggal_mulai) ?>" class="btn btn-inverse-success btn-fw" style="width: 100%; height: 8%; margin-left: 15px; font-size: 17px;">Daftar Sekarang</a>
      <!-- <button type="button" class="btn btn-inverse-success btn-fw" style="width: 100%; height: 8%; margin-left: 15px; font-size: 17px;">Daftar Sekarang</button> -->
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>
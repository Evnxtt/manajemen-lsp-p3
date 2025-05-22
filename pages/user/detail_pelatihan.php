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
    <div class="content-wrapper" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <div class="card-body-besar" style="background-color: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
              <div class="card" style="width: 910px; margin-bottom: 20px;">
                <div class="card-content" style="background-color: #fffff8; position: relative; display: flex; gap: 24px; padding: 20px; border-radius: 12px; align-items: flex-start; height: auto;">
                    <div style="display: flex; flex-direction: column; align-items: flex-start;">
                        <img src="<?= htmlspecialchars($gambar) ?>" style="max-width: 260px; max-height: 260px; height: auto; border-radius: 25px; object-fit: contain; margin-bottom: 12px;" alt="news">
                        <!-- <b class="ratings" style="margin-top: 8px; margin-left: 5px; font-size: 18px;">⭐ 5 (102)</b> -->
                    </div>
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: flex-start;">
                        <h2 class="course-title" style="line-height: 1.2; font-size: 22px; margin-bottom: 10px; margin-top: 5px;"><?= htmlspecialchars($nama_pelatihan) ?></h2>
                        <p class="course-desc" style="margin-right: 50px;"><?= htmlspecialchars($deskripsi) ?></p>
                        <!-- <p class="course-desc" style="margin-right: 50px; margin-bottom: 15px;">Peserta akan dibekali dengan keterampilan teknis dan praktis dalam mengidentifikasi kerusakan ekosistem, merancang intervensi restoratif, serta memantau efektivitas pemulihan ekosistem baik di kawasan hutan, pesisir, lahan basah, maupun wilayah terdegradasi lainnya. Program ini juga memperkenalkan pendekatan ekologika, yaitu cara pandang sistemik dan holistik dalam menyelesaikan permasalahan lingkungan.</p> -->
                        <p class="price" style="left: 16px; margin: 0; margin-bottom: 20px;">Rp. <?= htmlspecialchars($biaya) ?><span class="bonus"></span></p>
                        <a href="pendaftaran.php" class="btn btn-outline-warning btn-fw" style="max-width: 200px;">Daftar Sekarang</a>
                    </div>
                </div>
              </div>   
            </div>
        </div>
    </div>

<?php include 'templates/footer.php'; ?>

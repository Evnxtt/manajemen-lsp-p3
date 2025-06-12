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

// Handle pembatalan pendaftaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['batal_pendaftaran'], $_POST['batal_id'])) {
  $collectionPendaftaran->updateOne(
    ['_id' => new MongoDB\BSON\ObjectId($_POST['batal_id'])],
    ['$set' => ['status' => 'dibatalkan']]
  );
  header("Location: cek_status.php?batal=success");
  exit;
}
?>
<?php if (isset($_GET['batal']) && $_GET['batal'] === 'success'): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Dibatalkan!',
      text: 'Pendaftaran berhasil dibatalkan.',
      confirmButtonText: 'OK'
    });
  </script>
<?php endif; ?>
<?php
// Ambil semua pendaftaran user ini
$pendaftaranList = $collectionPendaftaran->find(['id_user' => $userId]);
?>
<!-- Include Header -->
<link rel="stylesheet" href="../assets/css/vertical-layout-light/testcss.css">
<?php include 'templates/header.php'; ?>

<div class="main-panel" style="background-color: #F5F7FF;">
  <div class="container">
    <?php
    $adaData = false;
    foreach ($pendaftaranList as $pendaftaran):
      $status = strtolower($pendaftaran['status'] ?? '-');
      // Jika status selesai, skip tampilkan
      if ($status === 'selesai') {
        continue;
      }
      $adaData = true;
      $idPelatihan = $pendaftaran['id_pelatihan'];
      // Ambil data pelatihan terkait
      $pelatihan = $collectionPelatihan->findOne(['_id' => $idPelatihan]);
      $judul = $pelatihan['detail_pelatihan']['nama_pelatihan'] ?? '';
      $ringkasan = $pelatihan['detail_pelatihan']['deskripsi'] ?? '';
      $gambar = $pelatihan['gambar'] ?? '../assets/images/training/default.svg';
      $id = (string)$pelatihan['_id'];
    ?>
      <div class="card" style="margin-bottom: 20px;">
        <img src="<?= htmlspecialchars($gambar) ?>" alt="news" style="max-height: 200px; object-fit: cover;">
        <div class="card-content" style="background-color: #fffff8;">
          <h2 class="course-title" style="line-height: 1.2;"><?= htmlspecialchars($judul) ?></h2>
          <p><?= htmlspecialchars($ringkasan) ?></p>
          <p><b>Status Pendaftaran:</b> <?= htmlspecialchars($pendaftaran['status'] ?? '-') ?></p>
          <?php if ($status === 'dibatalkan'): ?>
            <button class="btn btn-danger" style="width:100%;color:#fff;cursor:default;" disabled>Dibatalkan</button>
          <?php elseif ($status === 'menunggu verifikasi'): ?>
            <button class="btn btn-warning" style="width:100%;color:#fff;cursor:default;" disabled>Menunggu Verifikasi</button>
          <?php elseif ($status === 'terverifikasi'): ?>
            <button class="btn btn-primary" style="width:100%;color:#fff;cursor:default;" disabled>Terverifikasi</button>
          <?php elseif ($status === 'ditolak'): ?>
            <button class="btn btn-secondary" style="width:100%;color:#fff;cursor:default;" disabled>Ditolak</button>
          <?php elseif ($status === 'menunggu pembayaran'): ?>
            <a href="pembayaran.php?id=<?= $id ?>" class="btn btn-primary" style="width:100%;">Lakukan Pembayaran</a>
          <?php endif; ?>
          <?php if (in_array($status, ['menunggu pembayaran', 'menunggu verifikasi', 'terverifikasi'])): ?>
            <form method="post" style="margin-top:8px;" class="form-batal">
              <input type="hidden" name="batal_id" value="<?= htmlspecialchars($pendaftaran['_id']) ?>">
              <button type="button" name="batal_pendaftaran" class="btn btn-danger btn-batal" style="width:100%;">Batalkan</button>
              <input type="hidden" name="batal_pendaftaran" value="1">
            </form>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (!$adaData): ?>
      <div class="alert alert-info mt-4">Belum ada pendaftaran pelatihan yang perlu ditampilkan.</div>
    <?php endif; ?>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.querySelectorAll('.btn-batal').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Batalkan Pendaftaran?',
        text: "Tindakan ini tidak dapat dibatalkan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, batalkan!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          btn.closest('form').submit();
        }
      });
    });
  });
</script>
<?php include 'templates/footer.php'; ?>
<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: ../auth/login.php");
  exit;
}

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
  header("Location: ../auth/login.php");
  exit;
}

require '../../vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->pelatihan;

// Ambil ID dari parameter GET
if (!isset($_GET['id'])) {
  echo "ID tidak ditemukan.";
  exit;
}

$id = $_GET['id'];
$pelatihan = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_pelatihan = $_POST['pelatihan'];
  $nama_pelatihan = $_POST['nama_pelatihan'];
  $deskripsi = $_POST['deskripsi'];
  $persyaratan = $_POST['persyaratan'];
  $unit = $_POST['unit'];
  $judul_skema = $_POST['judul_skema'];
  $nomor_skema = $_POST['nomor_skema'];
  $biaya = (int) $_POST['biaya'];
  $metode = $_POST['metode'];
  $tempat = $_POST['tempat'];
  $ruangan = $_POST['ruangan'];
  $tautan = $_POST['tautan'];
  $platform = $_POST['platform'];
  $tanggal_mulai = $_POST['tanggal_mulai'];
  $durasi = $_POST['durasi'];
  $batas_daftar = $_POST['batas_daftar'];
  $kuota = (int) $_POST['kuota'];
  $status = $_POST['status'];

  // Handle upload gambar
  $uploadDir = '../assets/images/training/';
  $uploadedFilePath = $pelatihan['gambar'] ?? '';
  if (isset($_FILES['img']) && $_FILES['img']['error'][0] === UPLOAD_ERR_OK) {
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }
    $fileName = time() . '_' . basename($_FILES['img']['name'][0]);
    $uploadFile = $uploadDir . $fileName;
    if (move_uploaded_file($_FILES['img']['tmp_name'][0], $uploadFile)) {
      $uploadedFilePath = $uploadFile;
    }
  }

  $detailPelatihan = [
    'nama_pelatihan' => $nama_pelatihan,
    'deskripsi' => $deskripsi,
    'persyaratan' => $persyaratan,
    'unit_kompetensi' => $unit,
    'judul_skema' => $judul_skema,
    'nomor_skema' => $nomor_skema,
    'biaya' => $biaya
  ];

  $data = [
    'id_pelatihan' => $id_pelatihan,
    'detail_pelatihan' => $detailPelatihan,
    'metode' => $metode,
    'tempat' => $tempat,
    'ruangan' => $ruangan,
    'tautan' => $tautan,
    'platform' => $platform,
    'tanggal_mulai' => new MongoDB\BSON\UTCDateTime(strtotime($tanggal_mulai) * 1000),
    'durasi' => $durasi,
    'batas_daftar' => new MongoDB\BSON\UTCDateTime(strtotime($batas_daftar) * 1000),
    'kuota' => $kuota,
    'status' => $status,
    'gambar' => $uploadedFilePath,
    'pembaruan' => new MongoDB\BSON\UTCDateTime()
  ];

  $result = $collection->updateOne(
    ['_id' => new MongoDB\BSON\ObjectId($id)],
    ['$set' => $data]
  );

  $_SESSION['success_message'] = "Pelatihan berhasil diperbarui!";
  header("Location: list_pelatihan.php");
  exit;
}
?>

<!-- Include Header -->
<link rel="stylesheet" href="../assets/css/vertical-layout-light/testcss.css">

<?php include 'templates/header.php'; ?>

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Ubah Data Pelatihan</h4>
          <p class="card-description">
            Silahkan ubah data pelatihan
          </p>
          <form class="forms-sample" method="POST" action="" enctype="multipart/form-data">
            <!-- ...form Anda tetap seperti sebelumnya... -->
            <div class="form-group">
              <label for="exampleInputName1">Id Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputName1" placeholder="Sertifikasi / Pelatihan" name="pelatihan" required value="<?= htmlspecialchars($pelatihan['id_pelatihan'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Nama Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Nama Pelatihan" name="nama_pelatihan" required value="<?= htmlspecialchars($pelatihan['detail_pelatihan']['nama_pelatihan'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label>Sampul Pelatihan</label>
              <input type="file" name="img[]" class="file-upload-default">
              <div class="input-group col-xs-12">
                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image" value="<?= htmlspecialchars($pelatihan['gambar'] ?? '') ?>">
                <span class="input-group-append">
                  <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="isi">Deskripsi</label>
              <textarea class="form-control" id="isi" name="deskripsi" rows="5" placeholder="Deskripsi" required><?= htmlspecialchars($pelatihan['detail_pelatihan']['deskripsi'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
              <label for="penulis">Persyaratan Peserta</label>
              <input type="text" class="form-control" id="penulis" placeholder="Persyaratan Peserta" name="persyaratan" required value="<?= htmlspecialchars($pelatihan['detail_pelatihan']['persyaratan'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Unit Kompetensi</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="unit" placeholder="Unit Kompetensi" required value="<?= htmlspecialchars($pelatihan['detail_pelatihan']['unit_kompetensi'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Judul Skema</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="judul_skema" placeholder="Judul Skema (Sertifikasi)" value="<?= htmlspecialchars($pelatihan['detail_pelatihan']['judul_skema'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Nomor Skema</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="nomor_skema" placeholder="Nomor Skema (Sertifikasi)" value="<?= htmlspecialchars($pelatihan['detail_pelatihan']['nomor_skema'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Biaya Pelatihan</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-primary text-white">Rp.</span>
                </div>
                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="biaya" required value="<?= htmlspecialchars($pelatihan['detail_pelatihan']['biaya'] ?? '') ?>">
                <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Metode Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="metode" placeholder="Metode Pelatihan" required value="<?= htmlspecialchars($pelatihan['metode'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Tempat Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="tempat" placeholder="Tempat Pelatihan" value="<?= htmlspecialchars($pelatihan['tempat'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Ruangan Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="ruangan" placeholder="Ruangan Pelatihan" value="<?= htmlspecialchars($pelatihan['ruangan'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Tautan Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="tautan" placeholder="Tautan Pelatihan" value="<?= htmlspecialchars($pelatihan['tautan'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Platform Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="platform" placeholder="Platform Pelatihan" value="<?= htmlspecialchars($pelatihan['platform'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Tanggal Mulai Pelatihan</label>
              <input type="date" class="form-control" id="exampleInputPassword4" name="tanggal_mulai" placeholder="Tanggal Mulai Pelatihan" required value="<?= isset($pelatihan['tanggal_mulai']) ? date('Y-m-d', $pelatihan['tanggal_mulai']->toDateTime()->getTimestamp()) : '' ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Durasi Pelatihan</label>
              <input type="time" class="form-control" id="exampleInputPassword4" name="durasi" placeholder="Durasi Pelatihan (Menit)" required value="<?= htmlspecialchars($pelatihan['durasi'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Batas Daftar Pelatihan</label>
              <input type="date" class="form-control" id="exampleInputPassword4" name="batas_daftar" placeholder="Batas Daftar Pelatihan" required value="<?= isset($pelatihan['batas_daftar']) ? date('Y-m-d', $pelatihan['batas_daftar']->toDateTime()->getTimestamp()) : '' ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Kuota Pelatihan</label>
              <input type="number" class="form-control" id="exampleInputPassword4" name="kuota" placeholder="Kuota Pelatihan" required value="<?= htmlspecialchars($pelatihan['kuota'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Status Pelatihan</label>
              <select class="form-control" name="status">
                <option value="Dibuka" <?= (isset($pelatihan['status']) && $pelatihan['status'] == 'Dibuka') ? 'selected' : '' ?>>Dibuka</option>
                <option value="Ditutup" <?= (isset($pelatihan['status']) && $pelatihan['status'] == 'Ditutup') ? 'selected' : '' ?>>Ditutup</option>
                <option value="Proses" <?= (isset($pelatihan['status']) && $pelatihan['status'] == 'Proses') ? 'selected' : '' ?>>Proses</option>
                <option value="Selesai" <?= (isset($pelatihan['status']) && $pelatihan['status'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- partial -->

<!-- Include Footer -->
<?php include 'templates/footer.php'; ?>
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
        title: 'Anda bukan super admin!',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = '../auth/login.php';
      });
    </script>";
  exit;
}

?>
<!-- Include Header -->
<?php include 'templates/header.php'; ?>

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Tambahkan Pelatihan Baru</h4>
          <p class="card-description">
            Silahkan masukan data pelatihan baru
          </p>
          <form class="forms-sample" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Id Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputName1" placeholder="Sertifikasi / Pelatihan" name="pelatihan" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Nama Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Nama Pelatihan" name="nama_pelatihan" required>
            </div>
            <div class="form-group">
              <label>Sampul Pelatihan</label>
              <input type="file" name="img[]" class="file-upload-default">
              <div class="input-group col-xs-12">
                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image" required>
                <span class="input-group-append">
                  <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="isi">Deskripsi</label>
              <textarea class="form-control" id="isi" name="deskripsi" rows="5" placeholder="Deskripsi" required></textarea>
            </div>
            <div class="form-group">
              <label for="penulis">Persyaratan Peserta</label>
              <input type="text" class="form-control" id="penulis" placeholder="Persyaratan Peserta" name="persyaratan" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Unit Kompetensi</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="unit" placeholder="Unit Kompetensi" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Judul Skema</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="judul_skema" placeholder="Judul Skema (Sertifikasi)">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Nomor Skema</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="nomor_skema" placeholder="Nomor Skema (Sertifikasi)">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword4">Biaya Pelatihan</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-primary text-white">Rp.</span>
                </div>
                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="biaya" required>
                <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Metode Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="metode" placeholder="Metode Pelatihan" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Tempat Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="tempat" placeholder="Tempat Pelatihan">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Ruangan Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="ruangan" placeholder="Ruangan Pelatihan">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Tautan Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="tautan" placeholder="Tautan Pelatihan">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Platform Pelatihan</label>
              <input type="text" class="form-control" id="exampleInputPassword4" name="platform" placeholder="Platform Pelatihan">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Tanggal Mulai Pelatihan</label>
              <input type="date" class="form-control" id="exampleInputPassword4" name="tanggal_mulai" placeholder="Tanggal Mulai Pelatihan" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Durasi Pelatihan</label>
              <input type="time" class="form-control" id="exampleInputPassword4" name="durasi" placeholder="Durasi Pelatihan (Menit)" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Batas Daftar Pelatihan</label>
              <input type="date" class="form-control" id="exampleInputPassword4" name="batas_daftar" placeholder="Batas Daftar Pelatihan" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Kuota Pelatihan</label>
              <input type="number" class="form-control" id="exampleInputPassword4" name="kuota" placeholder="Kuota Pelatihan" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Status Pelatihan</label>
              <select class="form-control" name="status">
                <option value="Dibuka">Dibuka</option>
                <option value="Ditutup">Ditutup</option>
                <option value="Proses">Proses</option>
                <option value="Selesai">Selesai</option>
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

<?php
require '../../vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->pelatihan;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

  $uploadDir = '../assets/images/training/';
  $uploadedFilePath = '';

  if (!empty($_FILES['img']['name'][0])) {
    $fileTmpPath = $_FILES['img']['tmp_name'][0];
    $fileName = basename($_FILES['img']['name'][0]);
    $uploadedFilePath = $uploadDir . time() . '_' . $fileName;

    // Pastikan folder ada
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    if (!move_uploaded_file($fileTmpPath, $uploadedFilePath)) {
      die("Gagal mengupload file.");
    }
  }


  // Data yang di-embed
  $detailPelatihan = [
    'nama_pelatihan' => $nama_pelatihan,
    'deskripsi' => $deskripsi,
    'persyaratan' => $persyaratan,
    'unit_kompetensi' => $unit,
    'judul_skema' => $judul_skema,
    'nomor_skema' => $nomor_skema,
    'biaya' => $biaya
  ];

  // Struktur utama dokumen
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
    "gambar" => $uploadedFilePath,
  ];

  $result = $collection->insertOne($data);

  if ($result->getInsertedCount() > 0) {
    echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'Pelatihan berhasil ditambahkan!',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = 'list_pelatihan.php';
        });
      </script>";
  } else {
    echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Gagal menambahkan pelatihan.',
          confirmButtonText: 'OK'
        });
      </script>";
  }
}
?>
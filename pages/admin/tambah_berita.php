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
          <h4 class="card-title">Tambahkan Berita Baru</h4>
          <p class="card-description">
            Silahkan masukan data berita baru
          </p>
          <form class="forms-sample" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Judul</label>
              <input type="text" class="form-control" id="exampleInputName1" placeholder="Judul" name="judul" required>
            </div>
            <div class="form-group">
              <label>Gambar Berita</label>
              <input type="file" name="img[]" class="file-upload-default">
              <div class="input-group col-xs-12">
                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image" required>
                <span class="input-group-append">
                  <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Ringkasan</label>
              <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Ringkasan" name="ringkasan" required>
            </div>
            <div class="form-group">
              <label for="isi">Isi</label>
              <textarea class="form-control" id="isi" name="isi" rows="5" placeholder="Isi Berita" required></textarea>
            </div>
            <div class="form-group">
              <label for="penulis">Penulis</label>
              <input type="text" class="form-control" id="penulis" placeholder="Penulis" name="penulis" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Tanggal Pembuatan</label>
              <input type="date" class="form-control" id="exampleInputPassword4" name="pembuatan" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword4">Tanggal Publikasi</label>
              <input type="date" class="form-control" id="exampleInputPassword4" name="publikasi" required>
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
require '../../vendor/autoload.php'; // Pastikan ini sudah sesuai path ke autoload
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->berita;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $judul = $_POST["judul"];
  $ringkasan = $_POST["ringkasan"];
  $isi = $_POST["isi"];
  $penulis = $_POST["penulis"];
  $pembuatan = $_POST["pembuatan"];
  $publikasi = $_POST["publikasi"];

  $uploadDir = '../assets/images/news/';
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

  // Buat struktur data MongoDB
  $insertData = [
    "judul" => $judul,
    "ringkasan" => $ringkasan,
    "pembuatan" => new MongoDB\BSON\UTCDateTime(strtotime($pembuatan) * 1000),
    "gambar" => $uploadedFilePath,
    "detail_berita" => [
      "isi" => $isi,
      "penulis" => $penulis,
      "tanggal_publikasi" => new MongoDB\BSON\UTCDateTime(strtotime($publikasi) * 1000)
    ]
  ];

  $result = $collection->insertOne($insertData);

  if ($result->getInsertedCount() > 0) {
    echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil Menambah Berita!',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = 'berita_pelatihan.php';
        });
      </script>";
  } else {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'Gagal Menambah Berita!',
        confirmButtonText: 'OK'
      });
    </script>";
  }
}
?>
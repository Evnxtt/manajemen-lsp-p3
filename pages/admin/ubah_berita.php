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
$collection = $client->lsp_p3->berita;

// Ambil ID dari parameter GET
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$berita = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$judul = $_POST['judul'];
$ringkasan = $_POST['ringkasan'];
$isi = $_POST['isi'];
$penulis = $_POST['penulis'];

// Simulasi ambil gambar, atau gunakan $_FILES untuk upload
$gambar = $berita['gambar']; // default gambar lama
if (isset($_FILES['img']) && $_FILES['img']['error'][0] === UPLOAD_ERR_OK) {
    $uploadDir = '../assets/images/news/';
    $uploadFile = $uploadDir . basename($_FILES['img']['name'][0]);
    move_uploaded_file($_FILES['img']['tmp_name'][0], $uploadFile);
    $gambar = $uploadFile;
}

$collection->updateOne(
    ['_id' => new MongoDB\BSON\ObjectId($id)],
    ['$set' => [
        'judul' => $judul,
        'ringkasan' => $ringkasan,
        'gambar' => $gambar,
        'detail_berita' => [
            'isi' => $isi,
            'penulis' => $penulis
        ],
        'pembaruan' => new MongoDB\BSON\UTCDateTime()
    ]]
);
$_SESSION['success_message'] = "Berita berhasil diperbarui!";
header("Location: berita_pelatihan.php");
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
                  <h4 class="card-title">Tambahkan Berita Baru</h4>
                  <p class="card-description">
                    Silahkan masukan data berita baru
                  </p>
                  <form class="forms-sample" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="exampleInputName1">Judul</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Judul" name="judul" value="<?= htmlspecialchars($berita['judul'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Ringkasan</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Ringkasan" name="ringkasan" value="<?= htmlspecialchars($berita['ringkasan'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
 <div class="form-group">
  <label for="isi">Isi</label>
  <textarea class="form-control" id="isi" name="isi" rows="5" placeholder="Isi Berita" required value="<?= htmlspecialchars($berita['isi'] ?? '') ?>"></textarea>
</div>
<div class="form-group">
  <label for="penulis">Penulis</label>
  <input type="text" class="form-control" id="penulis" placeholder="Penulis" name="penulis" required value="<?= htmlspecialchars($berita['penulis'] ?? '') ?>">
</div>
                    <div class="form-group">
                      <label>File upload</label>
                      <input type="file" name="img[]" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image" value="<?= htmlspecialchars($berita['gambar'] ?? '') ?>" required>
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
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
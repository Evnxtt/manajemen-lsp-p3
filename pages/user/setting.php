<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: ../auth/login.php");
  exit;
}

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "user") {
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

require '../../vendor/autoload.php'; // MongoDB library
use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->users;

$userId = new MongoDB\BSON\ObjectId($_SESSION['user_id']);
$userData = $collection->findOne(['_id' => $userId]);

$informasi_pribadi = $userData['informasi_pribadi'] ?? [];
$alamat_lengkap = $userData['alamat_lengkap'] ?? [];

?>

<?php include 'templates/header.php'; ?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Rubah data diri</h4>
            <form class="form-sample" action="" method="POST">
              <p class="card-description">
                Informasi Pribadi
              </p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Depan</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="nama_depan" value="<?= $informasi_pribadi['nama_depan'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Belakang</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="nama_belakang" value="<?= $informasi_pribadi['nama_belakang'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">NIK</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" name="nik" value="<?= $informasi_pribadi['nik'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agama</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="agama">
                        <?php
                        $agama_options = ["Islam", "Kristen", "Hindu", "Buddha", "Konghucu", "Lainya"];
                        foreach ($agama_options as $agama) {
                          $selected = ($informasi_pribadi['agama'] ?? '') === $agama ? 'selected' : '';
                          echo "<option value=\"$agama\" $selected>$agama</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" name="jenis_kelamin">Jenis Kelamin</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="jenis_kelamin">
                        <option value="Pria" <?= ($informasi_pribadi['jenis_kelamin'] ?? '') === "Pria" ? 'selected' : '' ?>>Pria</option>
                        <option value="Wanita" <?= ($informasi_pribadi['jenis_kelamin'] ?? '') === "Wanita" ? 'selected' : '' ?>>Wanita</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="date" placeholder="dd/mm/yyyy" name="tanggal_lahir" value="<?= $informasi_pribadi['tanggal_lahir'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
              </div>
              <p class="card-description">
                Alamat Lengkap
              </p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="alamat" value="<?= $alamat_lengkap['alamat'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kelurahan</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="kelurahan" value="<?= $alamat_lengkap['kelurahan'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kecamatan</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="kecamatan" value="<?= $alamat_lengkap['kecamatan'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kota</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="kota" value="<?= $alamat_lengkap['kota'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Provinsi</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="provinsi" value="<?= $alamat_lengkap['provinsi'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kode Pos</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" name="kode_pos" value="<?= $alamat_lengkap['kode_pos'] ?? '' ?>" />
                    </div>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary mr-2" name="submit">Kirim</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>

<?php
require '../../vendor/autoload.php'; // pastikan autoload sudah sesuai


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $client = new Client("mongodb://localhost:27017");
  $collection = $client->lsp_p3->users; // ganti dengan nama database kamu

  $userId = new MongoDB\BSON\ObjectId($_SESSION['user_id']);

  // Ambil dan siapkan data dari form
  $informasi_pribadi = [
    'nama_depan' => $_POST['nama_depan'],
    'nama_belakang' => $_POST['nama_belakang'],
    'nik' => $_POST['nik'],
    'agama' => $_POST['agama'],
    'jenis_kelamin' => $_POST['jenis_kelamin'],
    'tanggal_lahir' => $_POST['tanggal_lahir'],
  ];

  $alamat_lengkap = [
    'alamat' => $_POST['alamat'],
    'kelurahan' => $_POST['kelurahan'],
    'kecamatan' => $_POST['kecamatan'],
    'kota' => $_POST['kota'],
    'provinsi' => $_POST['provinsi'],
    'kode_pos' => $_POST['kode_pos'],
  ];

  // Update data ke MongoDB
  $result = $collection->updateOne(
    ['_id' => $userId],
    ['$set' => [
      'informasi_pribadi' => $informasi_pribadi,
      'alamat_lengkap' => $alamat_lengkap
    ]]
  );

  if ($result->getModifiedCount() > 0) {
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil diperbarui!',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'setting.php';
      });
    </script>";
  } else {
    echo "<script>
      Swal.fire({
        icon: 'info',
        title: 'Tidak ada perubahan data.',
        confirmButtonText: 'OK'
      });
    </script>";
  }
}
?>
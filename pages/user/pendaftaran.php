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

require_once __DIR__ . '/../../vendor/autoload.php';
use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->users;

$userId = new MongoDB\BSON\ObjectId($_SESSION['user_id']);
$userData = $collection->findOne(['_id' => $userId]);

$informasi_pribadi = $userData['informasi_pribadi'] ?? [];
$alamat_lengkap = $userData['alamat_lengkap'] ?? [];

?>
<!-- Include Header -->
<?php include 'templates/header.php'; ?>

<!-- partial -->

 <div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
                <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengisian Data Pribadi</h4>
                  <p class="card-description">
                    Data Pribadi
                  </p>
                  <form class="forms-sample" action="" method="POST">
                    <div class="form-group">
                      <label for="exampleInputName1">Nama Lengkap</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Nama Lengkap" name="nama_lengkap" value="<?= ($informasi_pribadi['nama_depan'] ?? '') . ' ' . ($informasi_pribadi['nama_belakang'] ?? '') ?>">
                    </div>
                    <div class="form-group">Jenis Kelamin</label>
                      <select class="form-control" name="jenis_kelamin">
                        <option value="Pria" <?= ($informasi_pribadi['jenis_kelamin'] ?? '') === "Pria" ? 'selected' : '' ?>>Pria</option>
                        <option value="Wanita" <?= ($informasi_pribadi['jenis_kelamin'] ?? '') === "Wanita" ? 'selected' : '' ?>>Wanita</option>
                      </select>
                    </div>
                    <!-- <div class="form-group">
                      <label for="exampleInputEmail3">Tempat Lahir</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Tempat Lahir" name="tempat_lahir">
                    </div> -->
                    <div class="form-group">
                      <label for="exampleInputEmail3">Tanggal Lahir</label>
                      <input type="date" class="form-control" name="tanggal_lahir" value="<?= $informasi_pribadi['tanggal_lahir'] ?? '' ?>">
                    </div>
                     <div class="form-group">
                      <label for="exampleInputEmail3">Alamat Rumah</label>
                      <input type="text" class="form-control" name="alamat" value="<?= $alamat_lengkap['alamat'] ?? '' ?>">
                    </div>
                     <div class="form-group">
                      <label for="exampleInputEmail3">Kode Pos</label>
                      <input type="text" class="form-control" name="kode_pos" value="<?= $alamat_lengkap['kode_pos'] ?? '' ?>">
                    </div>
                     <div class="form-group">
                      <label for="exampleInputEmail3">Kebangsaan</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Kebangsaan" name="kebangsaan">
                    </div>
                      <div class="form-group">
                      <label for="exampleInputEmail3">Riwayat Pendidikan</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Riwayat Pendidikan" name="riwayat_pendidikan">
                    </div>
                      <div class="form-group">
                  <p class="card-description">
                    Nomor Identitas
                  </p>
                      <label for="exampleInputEmail3">NIK</label>
                      <input type="number" class="form-control" id="exampleInputEmail3" placeholder="NIK" name="nik">
                    </div>
                      <div class="form-group">
                      <label for="exampleInputEmail3">Paspor</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Paspor" name="paspor">
                    </div>
                    <p class="card-description">
                    Kontak Rumah
                  </p>
                      <div class="form-group">
                      <label for="exampleInputEmail3">No Telepon Rumah</label>
                      <input type="number" class="form-control" id="exampleInputEmail3" placeholder="No Telepon Rumah" name="no_tlp_rumah">
                    </div>
                      <div class="form-group">
                      <label for="exampleInputEmail3">Email Pribadi</label>
                      <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email Pribadi" name="email_pribadi">
                    </div>
                      <div class="form-group">
                      <label for="exampleInputEmail3">No Telepon Pribadi</label>
                      <input type="number" class="form-control" id="exampleInputEmail3" placeholder="No Telepon Pribadi" name="no_tlp_pribadi">
                    </div>
                  
                </div>
              </div>
            </div>

                            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengisian Data Pekerjaan</h4>
                  <p class="card-description">
                    Data Pekerjaan
                  </p>

                    <div class="form-group">
                      <label for="exampleInputName1">Nama Institusi</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Nama Institusi" name="nama_institusi">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Jabatan</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Jabatan" name="jabatan">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Alamat Kantor</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Alamat Kantor" name="alamat_kantor">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Kode Pos Kantor</label>
                      <input type="number" class="form-control" id="exampleInputName1" placeholder="Kode Pos Kantor" name="kode_pos_kantor">
                    </div>
                    <p class="card-description">
                    Kontak Kantor
                  </p>
                    <div class="form-group">
                      <label for="exampleInputEmail3">No Telepon Kantor</label>
                      <input type="number" class="form-control" id="exampleInputEmail3" placeholder="No Telepon Kantor" name="no_tlp_kantor">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Email Kantor</label>
                      <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email Kantor" name="email_kantor">
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-12 grid-margin stretch-card">
                <button type="submit" class="btn btn-primary mr-2">Buat Formulir Pelatihan</button>
              </div>
            </div>
          </div>
        </div>
      </form>
<!-- partial -->

  <!-- Include Footer -->
  <?php include 'templates/footer.php'; ?>
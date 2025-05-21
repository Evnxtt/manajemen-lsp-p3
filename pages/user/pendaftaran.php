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
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputName1">Nama Lengkap</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">Jenis Kelamin</label>
                        <select class="form-control" id="exampleSelectGender">
                          <option>Pria</option>
                          <option>Wanita</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Tempat Lahir</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Tempat Lahir">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Tanggal Lahir</label>
                      <input type="date" class="form-control" id="exampleInputEmail3" placeholder="Tanggal Lahir">
                    </div>
                     <div class="form-group">
                      <label for="exampleInputEmail3">Alamat Rumah</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Alamat Rumah">
                    </div>
                     <div class="form-group">
                      <label for="exampleInputEmail3">Kode Pos</label>
                      <input type="number" class="form-control" id="exampleInputEmail3" placeholder="Kode Pos">
                    </div>
                     <div class="form-group">
                      <label for="exampleInputEmail3">Kebangsaan</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Kebangsaan">
                    </div>
                      <div class="form-group">
                      <label for="exampleInputEmail3">Riwayat Pendidikan</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Riwayat Pendidikan">
                    </div>
                      <div class="form-group">
                                          <p class="card-description">
                    Nomor Identitas
                  </p>
                      <label for="exampleInputEmail3">NIK</label>
                      <input type="number" class="form-control" id="exampleInputEmail3" placeholder="NIK">
                    </div>
                      <div class="form-group">
                      <label for="exampleInputEmail3">Paspor</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Paspor">
                    </div>
                    <p class="card-description">
                    Kontak Rumah
                  </p>
                      <div class="form-group">
                      <label for="exampleInputEmail3">No Telepon Rumah</label>
                      <input type="number" class="form-control" id="exampleInputEmail3" placeholder="No Telepon Rumah">
                    </div>
                      <div class="form-group">
                      <label for="exampleInputEmail3">Email Pribadi</label>
                      <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email Pribadi">
                    </div>
                      <div class="form-group">
                      <label for="exampleInputEmail3">No Telepon Pribadi</label>
                      <input type="number" class="form-control" id="exampleInputEmail3" placeholder="No Telepon Pribadi">
                    </div>
                  </form>
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
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputName1">Nama Institusi</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Nama Institusi">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Jabatan</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Jabatan">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Alamat Kantor</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Alamat Kantor">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Kode Pos Kantor</label>
                      <input type="number" class="form-control" id="exampleInputName1" placeholder="Kode Pos Kantor">
                    </div>
                    <p class="card-description">
                    Kontak Kantor
                  </p>
                    <div class="form-group">
                      <label for="exampleInputEmail3">No Telepon Kantor</label>
                      <input type="number" class="form-control" id="exampleInputEmail3" placeholder="No Telepon Kantor">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Email Kantor</label>
                      <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email Kantor">
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengisian Data Pelatihan</h4>
                  <p class="card-description">
                    Data Pelatihan
                  </p>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputName1">Nama Pelatihan</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Nama Pelatihan">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Jadwal Pelatihan</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Jadwal Pelatihan">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-12 grid-margin stretch-card">
            <button type="submit" class="btn btn-primary mr-2">Buat Formulir Pelatihan</button>
</div>
                                        </div>
              </div>
    </div>
<!-- partial -->

  <!-- Include Footer -->
  <?php include 'templates/footer.php'; ?>
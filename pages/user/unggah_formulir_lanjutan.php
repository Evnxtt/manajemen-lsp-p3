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

<!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
                                    <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Silahkan Unggah Formulir</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label>Formulir Pendaftaran</label>
                      <input type="file" name="img[]" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Formulir Unggahan">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Unggah</button>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Bukti Pembayaran</label>
                      <input type="file" name="img[]" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Formulir Unggahan">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Unggah</button>
                        </span>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Kirim</button>
                    <button class="btn btn-light">Kembali</button>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
<!-- partial -->

  <!-- Include Footer -->
  <?php include 'templates/footer.php'; ?>
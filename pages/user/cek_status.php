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
                        <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Cek Status Pendaftaran</h4>
                  <p class="card-description">
                    Silahkan cek status pendaftaran anda
                  </p>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            Nama Pelatihan
                          </th>
                          <th>
                            Jadwal Pelatihan
                          </th>
                          <th>
                            Status
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="py-1">
                            FRM-01
                          </td>
                          <td>
                            Herman Beck
                          </td>
                          <td>
                            <label class="badge badge-primary">Diterima</label>
                          </td>
                        </tr>
                        <tr>
                          <td class="py-1">
                            FRM-02
                          </td>
                          <td>
                            Messsy Adam
                          </td>
                          <td>
                              <label class="badge badge-warning">Ditolak</label>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
<!-- partial -->

  <!-- Include Footer -->
  <?php include 'templates/footer.php'; ?>
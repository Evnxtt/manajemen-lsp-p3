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
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold"><?php echo "Selamat datang, " . $_SESSION["username"]; ?></h3>
                  <!-- <h6 class="font-weight-normal mb-0">Semua sistem berjalan lancar! Anda memiliki <span class="text-primary">3 pesan yang belum dibaca!</span></h6> -->
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <!-- <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                    </button> -->
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                      <a class="dropdown-item" href="#">January - March</a>
                      <a class="dropdown-item" href="#">March - June</a>
                      <a class="dropdown-item" href="#">June - August</a>
                      <a class="dropdown-item" href="#">August - November</a>
                    </div>
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="../assets/images/dashboard/people.svg" alt="people">
                  <div class="weather-info">
                    <div class="d-flex">
                      <div>
                        <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                      </div>
                      <div class="ml-2">
                        <h4 class="location font-weight-normal">Bandung</h4>
                        <h6 class="font-weight-normal">Indonesia</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Sertifikasi Hari Ini</p>
                      <p class="fs-30 mb-2">27</p>
                      <p>+8.00% (30 hari)</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Sertifikasi</p>
                      <p class="fs-30 mb-2">1582</p>
                      <p>+15.20% (30 hari)</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Jumlah Pelatihan</p>
                      <p class="fs-30 mb-2">190</p>
                      <p>+4.80% (30 hari)</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Jumlah Asesor Aktif</p>
                      <p class="fs-30 mb-2">132</p>
                      <p>+1.53% (30 hari)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                  <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <div class="row">
                          <div class="col-md-12 col-xl-3 d-flex flex-row justify-content-start">
                            <div class="ml-xl-4 mt-3 flex-row justify-content-start">
                            <p class="card-title">Berita Sertifikasi</p>
                              <h1 class="text-primary mb-3">Lingkungan</h1>
                              <h3 class="font-weight-500 mb-xl-4 text-primary" style="max-width: 400px; line-height: 1.2;">LSP Ekologika Gelar Sertifikasi Kompetensi Bidang Ekologi dan Lingkungan</h3>
                              <p class="mb-2 mb-xl-0" >The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</p>
                            </div>  
                            </div>
                          <div class="col-md-12 col-xl-9 mt-4 d-flex justify-content-end">
                            <div class="row">
                              <div class="col-md-6 mt-3 justify-content-end">
                                <img src="images/dashboard/berita.svg" class="rounded ms-3" alt="berita">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="carousel-item">
                        <div class="row">
                          <div class="col-md-12 col-xl-3 d-flex flex-row justify-content-start">
                            <div class="ml-xl-4 mt-3 flex-row justify-content-start">
                            <p class="card-title">Berita Sertifikasi</p>
                              <h1 class="text-primary mb-3">Lingkungan</h1>
                              <h3 class="font-weight-500 mb-xl-4 text-primary" style="max-width: 400px; line-height: 1.2;">LSP Ekologika Gelar Sertifikasi Kompetensi Bidang Ekologi dan Lingkungan</h3>
                              <p class="mb-2 mb-xl-0">The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</p>
                            </div>  
                            </div>
                          <div class="col-md-12 col-xl-9 mt-4 d-flex justify-content-end">
                            <div class="row">
                              <div class="col-md-6 mt-3 justify-content-end">
                                <img src="images/dashboard/berita.svg" class="rounded ms-3" alt="berita">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

  <!-- Include Footer -->
  <?php include 'templates/footer.php'; ?>
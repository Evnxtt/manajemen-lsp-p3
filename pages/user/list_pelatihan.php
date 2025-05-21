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
        <div class="container">
            <div class="card">
                <img src="../assets/images/news/news.svg" alt="news">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;">LSP Ekologika Selenggarakan Uji Sertifikasi Profesi untuk Ahli Ekologi</h2>
                    <p>Kegiatan ini bertujuan meningkatkan kompetensi tenaga profesional di bidang pengelolaan lingkungan dan konservasi.</p>
                    <p class="price">Rp 2.300.000 <span class="bonus"></span></p>
                    <button type="button" class="btn btn-primary">Lihat Selengkapnya</button>
                </div>
            </div>
            <div class="card">
                <img src="../assets/images/news/news2.svg" alt="news">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;">Kerja Sama LSP Ekologika dan KLHK: Dorong SDM Lingkungan Berkualitas</h2>
                    <p>Melalui kolaborasi ini, diharapkan tercipta tenaga kerja tersertifikasi yang siap menghadapi tantangan lingkungan global.</p>
                    <p class="price">Rp 2.300.000 <span class="bonus"></span></p>
                    <button type="button" class="btn btn-primary">Lihat Selengkapnya</button>
                </div>
            </div>
            <div class="card">
                <img src="../assets/images/news/news3.svg" alt="news">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;">Pelatihan dan Sertifikasi Ekolog: LSP Ekologika Hadir di 5 Kota Besar</h2>
                    <p>Program ini menyasar lulusan baru dan profesional muda yang ingin meningkatkan kredibilitas serta daya saing di dunia kerja, khususnya bidang ekologi.</p>
                    <p class="price">Rp 2.300.000 <span class="bonus"></span></p>
                    <button type="button" class="btn btn-primary">Lihat Selengkapnya</button>
                </div>
            </div>
            <div class="card">
                <img src="../assets/images/news/news4.svg" alt="news">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;">LSP Ekologika Launching Skema Baru Sertifikasi untuk Pengelola Sampah Organik</h2>
                    <p>Skema ini dirancang untuk mendukung ekonomi sirkular dan pengurangan sampah rumah tangga.</p>
                    <p class="price">Rp 2.300.000 <span class="bonus"></span></p>
                    <button type="button" class="btn btn-primary">Lihat Selengkapnya</button>
                </div>
            </div>
            <div class="card">
                <img src="../assets/images/news/news.svg" alt="news">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;">LSP Ekologika Selenggarakan Uji Sertifikasi Profesi untuk Ahli Ekologi</h2>
                    <p>Kegiatan ini bertujuan meningkatkan kompetensi tenaga profesional di bidang pengelolaan lingkungan dan konservasi.</p>
                    <p class="price">Rp 2.300.000 <span class="bonus"></span></p>
                    <button type="button" class="btn btn-primary">Lihat Selengkapnya</button>
                </div>
            </div>
            <div class="card">
                <img src="../assets/images/news/news2.svg" alt="news">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;">Kerja Sama LSP Ekologika dan KLHK: Dorong SDM Lingkungan Berkualitas</h2>
                    <p>Melalui kolaborasi ini, diharapkan tercipta tenaga kerja tersertifikasi yang siap menghadapi tantangan lingkungan global.</p>
                    <p class="price">Rp 2.300.000 <span class="bonus"></span></p>
                    <button type="button" class="btn btn-primary">Lihat Selengkapnya</button>
                </div>
            </div>
            <div class="card">
                <img src="../assets/images/news/news3.svg" alt="news">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;">Pelatihan dan Sertifikasi Ekolog: LSP Ekologika Hadir di 5 Kota Besar</h2>
                    <p>Program ini menyasar lulusan baru dan profesional muda yang ingin meningkatkan kredibilitas serta daya saing di dunia kerja, khususnya bidang ekologi.</p>
                    <p class="price">Rp 2.300.000 <span class="bonus"></span></p>
                    <button type="button" class="btn btn-primary">Lihat Selengkapnya</button>
                </div>
            </div>
            <div class="card">
                <img src="../assets/images/news/news4.svg" alt="news">
                <div class="card-content" style="background-color: #fffff8;">
                    <h2 class="course-title" style="line-height: 1.2;">LSP Ekologika Launching Skema Baru Sertifikasi untuk Pengelola Sampah Organik</h2>
                    <p>Skema ini dirancang untuk mendukung ekonomi sirkular dan pengurangan sampah rumah tangga.</p>
                    <p class="price">Rp 2.300.000 <span class="bonus"></span></p>
                    <button type="button" class="btn btn-primary">Lihat Selengkapnya</button>
                </div>
            </div>
        </div>
    </div>

  <!-- Include Footer -->
  <?php include 'templates/footer.php'; ?>
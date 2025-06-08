<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: ../auth/login.php");
  exit;
}

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "user") {
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
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
$pendaftaranCollection = $client->lsp_p3->pendaftaran_pelatihan;

$userId = new MongoDB\BSON\ObjectId($_SESSION['user_id']);
$userData = $collection->findOne(['_id' => $userId]);

$informasi_pribadi = $userData['informasi_pribadi'] ?? [];
$alamat_lengkap = $userData['alamat_lengkap'] ?? [];

$id_pelatihan = $_GET['id_pelatihan'] ?? ($_POST['id_pelatihan'] ?? null);

use setasign\Fpdi\Tcpdf\Fpdi; // Ganti TCPDF

$showSuccess = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Ambil data dari form
  $nama_pelatihan = $_POST['nama_pelatihan'];
  $tanggal_mulai = $_POST['tanggal_mulai'];
  $nama_lengkap = $_POST['nama_lengkap'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $tanggal_lahir = $_POST['tanggal_lahir'];
  $alamat = $_POST['alamat'];
  $kode_pos = $_POST['kode_pos'];
  $kebangsaan = $_POST['kebangsaan'];
  $riwayat_pendidikan = $_POST['riwayat_pendidikan'];
  $nik = $_POST['nik'];
  $paspor = $_POST['paspor'];
  $no_tlp_rumah = $_POST['no_tlp_rumah'];
  $email_pribadi = $_POST['email_pribadi'];
  $no_tlp_pribadi = $_POST['no_tlp_pribadi'];
  $nama_institusi = $_POST['nama_institusi'];
  $jabatan = $_POST['jabatan'];
  $alamat_kantor = $_POST['alamat_kantor'];
  $kode_pos_kantor = $_POST['kode_pos_kantor'];
  $no_tlp_kantor = $_POST['no_tlp_kantor'];
  $email_kantor = $_POST['email_kantor'];

  // Validasi input
  if ($id_pelatihan) {
    $sudahAda = $pendaftaranCollection->findOne([
      'id_user' => $userId,
      'id_pelatihan' => new MongoDB\BSON\ObjectId($id_pelatihan)
    ]);
    if (!$sudahAda) {
      $pendaftaranCollection->insertOne([
        'id_user' => $userId,
        'id_pelatihan' => new MongoDB\BSON\ObjectId($id_pelatihan),
        'nama_pelatihan' => $nama_pelatihan,
        'tanggal_mulai' => $tanggal_mulai,
        'status' => 'Menunggu Pembayaran'
      ]);
    }
  }

  // Buat PDF dengan FPDI
  $pdf = new Fpdi();
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);

  $templatePath = __DIR__ . '/Form_APL-01.pdf';
  $pageCount = $pdf->setSourceFile($templatePath);

  for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $pdf->AddPage();
    $templateId = $pdf->importPage($pageNo);
    $pdf->useTemplate($templateId, 0, 0, 210);

    // Hanya isi data di halaman pertama
    if ($pageNo === 1) {
      $pdf->SetFont('Helvetica', '', 10);
      // ───── Isi Data di Template Halaman 1 ─────
      $pdf->SetXY(75, 218.5);
      $pdf->Write(0, $nama_pelatihan);
      $pdf->SetXY(75, 234);
      $pdf->Write(0, $tanggal_mulai);
      $pdf->SetXY(70, 57.5);
      $pdf->Write(0, $nama_lengkap);
      $pdf->SetXY(71, 85.5);
      $pdf->Write(0, $jenis_kelamin);
      $pdf->SetXY(71, 77);
      $pdf->Write(0, $tanggal_lahir);
      $pdf->SetXY(71, 102);
      $pdf->Write(0, $alamat);
      $pdf->SetXY(143, 109);
      $pdf->Write(0, $kode_pos);
      $pdf->SetXY(71, 93.5);
      $pdf->Write(0, $kebangsaan);
      $pdf->SetXY(72, 135);
      $pdf->Write(0, $riwayat_pendidikan);
      $pdf->SetXY(71, 63.5);
      $pdf->Write(0, $nik);
      $pdf->SetXY(71, 69.5);
      $pdf->Write(0, $paspor);
      $pdf->SetXY(88, 116.5);
      $pdf->Write(0, $no_tlp_rumah);
      $pdf->SetXY(138, 124.5);
      $pdf->Write(0, $email_pribadi);
      $pdf->SetXY(83, 124.5);
      $pdf->Write(0, $no_tlp_pribadi);
      $pdf->SetXY(72.5, 152);
      $pdf->Write(0, $nama_institusi);
      $pdf->SetXY(72.5, 162.5);
      $pdf->Write(0, $jabatan);
      $pdf->SetXY(72.5, 171.5);
      $pdf->Write(0, $alamat_kantor);
      $pdf->SetXY(144, 179);
      $pdf->Write(0, $kode_pos_kantor);
      $pdf->SetXY(138, 116.5);
      $pdf->Write(0, $no_tlp_kantor);
      $pdf->SetXY(87, 186.5);
      $pdf->Write(0, $no_tlp_kantor);
      $pdf->SetXY(88, 195);
      $pdf->Write(0, $email_kantor);
    }
  }

  // Output PDF ke file sementara
  $pdf->Output('Formulir_Permohonan_Sertifikasi_Kompetensi.pdf', 'D');

  // Tampilkan SweetAlert sukses dan redirect
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
  echo "<script>
  Swal.fire({
    icon: 'success',
    title: 'Pendaftaran Berhasil!',
    text: 'Formulir berhasil dibuat dan pendaftaran berhasil.',
    confirmButtonText: 'OK'
  }).then(() => {
    window.location.href = 'cek_status.php';
  });
</script>";
  exit;
}
?>

<?php include 'templates/header.php'; ?>

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
            <form class="forms-sample" action="" method="POST" target="_self">
              <div class="form-group">
                <label for="nama_pelatihan">Nama Pelatihan</label>
                <input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan"
                  value="<?= htmlspecialchars($_GET['nama_pelatihan'] ?? ($_POST['nama_pelatihan'] ?? '')) ?>" readonly>
              </div>
              <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai Pelatihan</label>
                <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                  value="<?= htmlspecialchars($_GET['tanggal_mulai'] ?? ($_POST['tanggal_mulai'] ?? '')) ?>" readonly>
              </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include 'templates/footer.php'; ?>
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

<?php include 'templates/header.php'; ?>
<div class="main-panel">
  <div class="content-wrapper">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Rubah Password</h4>
                  <p class="card-description">
                    Silahkan Rubah Password Anda
                  </p>
                  <form class="forms-sample" action="" method="POST">
                    <div class="form-group">
                      <label for="exampleInputName1">Password Lama</label>
                      <input type="password" class="form-control" id="exampleInputName1" placeholder="Password Lama" name="old_password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Password Baru</label>
                      <input type="password" class="form-control" id="exampleInputEmail3" placeholder="Password Baru" name="new_password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Konfirmasi Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword4" placeholder="Ketik Ulang Password Baru" name="confirm_password">
                    </div>
                    <button type="submit" name="change_password" class="btn btn-primary mr-2">Rubah Password</button>
                  </form>
                </div>
              </div>
            </div>
                            </div>
              </div>

<?php include 'templates/footer.php'; ?>

<?php
require '../../vendor/autoload.php'; // Pastikan ini sudah sesuai path ke autoload

use MongoDB\Client;

if (isset($_POST['change_password'])) {
  $oldPassword = $_POST['old_password'];
  $newPassword = $_POST['new_password'];
  $confirmPassword = $_POST['confirm_password'];

  // Validasi: password baru dan konfirmasi harus cocok
  if ($newPassword !== $confirmPassword) {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'Konfirmasi password tidak cocok!',
        confirmButtonText: 'OK'
      });
    </script>";
    exit;
  }

  // Koneksi ke MongoDB dan ambil user berdasarkan session
  $client = new Client("mongodb://localhost:27017");
  $collection = $client->lsp_p3->users; // Ganti dengan nama database

  $userId = new MongoDB\BSON\ObjectId($_SESSION['user_id']);
  $user = $collection->findOne(['_id' => $userId]);

  // Cek apakah password lama benar
  if (!$user || !password_verify($oldPassword, $user['password'])) {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'Password lama salah!',
        confirmButtonText: 'OK'
      });
    </script>";
    exit;
  }

  // Hash password baru dan update
  $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
  $updateResult = $collection->updateOne(
    ['_id' => $userId],
    ['$set' => ['password' => $hashedPassword]]
  );

  if ($updateResult->getModifiedCount() > 0) {
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'Password berhasil diperbarui!',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'index.php';
      });
    </script>";
  } else {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'Password gagal diperbarui!',
        confirmButtonText: 'OK'
      });
    </script>";
  }
}
?>

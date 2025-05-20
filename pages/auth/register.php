<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ekologika</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../assets/images/logo32.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="../assets/images/logo.svg" alt="logo">
              </div>
              <h4>Baru disini?</h4>
              <h6 class="font-weight-light">Silahkan registrasi terlebih dahulu</h6>
              <form class="pt-3" action="" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username" name="username">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>
                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input" id="termsCheckbox" name="terms">
                      Saya setuju atas semua syarat & ketentuan
                    </label>
                  </div>
                </div>
                <div class="mt-3">
                  <!-- <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../assets/index.html">SIGN UP</a> -->
                  <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="Registrasi" name="submit" id="signupBtn" disabled>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Sudah punya akun? <a href="login.php" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/template.js"></script>
  <script src="../assets/js/settings.js"></script>
  <script src="../assets/js/todolist.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const checkbox = document.getElementById('termsCheckbox');
    const signupBtn = document.getElementById('signupBtn');

    checkbox.addEventListener('change', function() {
      signupBtn.disabled = !this.checked;
    });
  </script>

  <!-- endinject -->

</body>

</html>

<?php
require '../../vendor/autoload.php';

use MongoDB\Client;

function registerUser($username, $email, $password)
{
  // Koneksi ke MongoDB
  $client = new Client("mongodb://localhost:27017");
  $collection = $client->your_database->users; // Ganti 'your_database' sesuai nama database

  // Periksa apakah email sudah terdaftar
  $existingUser = $collection->findOne(['email' => $email]);
  if ($existingUser) {
    return "Email sudah digunakan!";
  }

  if (!isset($_POST['terms'])) {
    echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Anda harus menyetujui syarat dan ketentuan!',
      confirmButtonText: 'OK'
    });
  </script>";
    return;
  }

  // Hash password untuk keamanan
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  // Simpan data pengguna
  $insertResult = $collection->insertOne([
    'username' => $username,
    'email' => $email,
    'password' => $hashedPassword
  ]);

  // if ($insertResult->getInsertedCount() > 0) {
  //   return "Registrasi berhasil!";
  // } else {
  //   return "Registrasi gagal!";
  // }
}

// Jika form dikirimkan, tangani data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"] ?? "";
  $email = $_POST["email"] ?? "";
  $password = $_POST["password"] ?? "";

  $message = registerUser($username, $email, $password);
  echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Registrasi berhasil!',
      confirmButtonText: 'OK'
    }).then(() => {
      window.location.href = 'login.php';
    });
  </script>";
}



?>
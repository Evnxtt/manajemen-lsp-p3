<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
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
  <link rel="shortcut icon" href="../assets/images/favicon.png" />
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
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
              <form class="pt-3" action="" method="post" onsubmit="return validateForm()">
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
                      <input type="checkbox" class="form-check-input" id="termsCheckbox">
                      Saya setuju atas semua syarat & ketentuan
                    </label>
                  </div>
                </div>
                <div class="mt-3">
                  <!-- <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../assets/index.html">SIGN UP</a> -->
                  <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="Sign Up" name="submit">
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="login.php" class="text-primary">Login</a>
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
  <script>
  function validateForm() {
      var termsCheckbox = document.getElementById("termsCheckbox");
      if (!termsCheckbox.checked) {
          // Menggunakan SweetAlert untuk menampilkan popup
          Swal.fire({
              icon: "warning",
              title: "Perhatian!",
              text: "Anda harus menyetujui syarat dan ketentuan sebelum mendaftar.",
              confirmButtonText: "OK"
          });
          return false;
      }
      return true;
  }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- endinject -->
</body>

</html>

<?php
ob_start();
require __DIR__ . '/../../vendor/autoload.php';
use MongoDB\Client;

try {
    $client = new Client("mongodb://localhost:27017");
    $database = $client->selectDatabase('user_database'); 
    $collection = $database->selectCollection('users');
} catch (Exception $e) {
    die("Gagal terhubung ke database: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['terms'])) {
        die("Anda harus menyetujui syarat dan ketentuan.");
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        die("Semua field wajib diisi!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email tidak valid.");
    }

    $existingUser = $collection->findOne(['email' => $email]);
    if ($existingUser) {
        die("Email sudah terdaftar.");
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $insertResult = $collection->insertOne([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword,
        'role' => 'user'
    ]);

    if ($insertResult->getInsertedCount() > 0) {
        header("Location: login.php");
        exit();
    } else {
        echo "Gagal melakukan registrasi.";
    }
}
ob_end_flush();
?>
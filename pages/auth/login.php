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
              <h4>Selamat datang!</h4>
              <h6 class="font-weight-light">Silahkan masuk terlebih dahulu.</h6>
              <form class="pt-3" action="" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username/Email" name="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>
                <div class="mt-3">
                  <!-- <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../assets/index.html">SIGN IN</a> -->
                  <input type="submit" value="Sign In" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <!-- <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div> -->
                  <a href="#" class="auth-link text-black">Lupa password?</a>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Belum punya akun? <a href="register.php" class="text-primary">Buat akun</a>
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
  <!-- endinject -->
</body>

</html>

<?php
session_start();
require '../../vendor/autoload.php';

use MongoDB\Client;

function getMongoDBCollection()
{
  $client = new Client("mongodb://localhost:27017");
  return $client->lsp_p3->users; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $collection = getMongoDBCollection();

  $identifier = $_POST["email"]; 
  $password = $_POST["password"];

  $user = $collection->findOne([
    '$or' => [
      ['email' => $identifier],
      ['username' => $identifier],
    ]
  ]);

  if ($user) {
    if (isset($user['status']) && strtolower($user['status']) === 'nonaktif') {
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Akun Nonaktif',
          text: 'Akun anda nonaktif. Silakan hubungi admin.',
          confirmButtonText: 'OK'
        });
      </script>";
      exit;
    }

    if (password_verify($password, $user["password"])) {

      $_SESSION["user_id"] = (string) $user["_id"];
      $_SESSION["username"] = $user["username"];
      $_SESSION["role"] = $user["role"];

      $redirectUrl = '';
      if ($user["role"] === "admin") {
        $redirectUrl = '../admin/index.php';
      } elseif ($user["role"] === "super_admin") {
        $redirectUrl = '../super_admin/index.php';
      } else {
        $redirectUrl = '../user/index.php'; 
      }

      echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil masuk!',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = '$redirectUrl';
        });
      </script>";
      exit;

    } else {
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Gagal masuk!',
          text: 'Password salah.',
          confirmButtonText: 'OK'
        });
      </script>";
    }
  } else {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'Gagal masuk!',
        text: 'Email atau username tidak ditemukan.',
        confirmButtonText: 'OK'
      });
    </script>";
  }
}
?>

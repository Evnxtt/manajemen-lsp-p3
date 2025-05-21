<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "super_admin") {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'Anda bukan super admin!',
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
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pengisian Data Admin</h4>
                    <p class="card-description">
                        Tambah Data Admin
                    </p>
                    <form class="forms-sample" action="" method="POST">
                        <div class="form-group">
                            <label for="exampleInputName1">Username</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Password</label>
                            <input type="password" class="form-control" id="exampleInputEmail3" placeholder="Password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Tambah Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- partial -->

<!-- Include Footer -->
<?php include 'templates/footer.php'; ?>

<?php
require '../../vendor/autoload.php';

use MongoDB\Client;

function registerUser($username, $email, $password)
{

    $client = new Client("mongodb://localhost:27017");
    $collection = $client->lsp_p3->users;

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


    $insertResult = $collection->insertOne([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword,
        'role' => 'admin',
        'status' => 'aktif'
    ]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $message = registerUser($username, $email, $password);
    echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Tambah Admin Berhasil!',
      confirmButtonText: 'OK'
    }).then(() => {
      window.location.href = 'list_admin.php';
    });
  </script>";
}

?>
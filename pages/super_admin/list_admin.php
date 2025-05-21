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

<?php
require '../../vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->users;

if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];

    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'Admin berhasil dihapus!',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'list_admin.php';
      });
    </script>";
    exit;
}

// Ambil user nonaktif untuk ditampilkan
$admin = $collection->find(['role' => 'admin']);
?>
<!-- Include Header -->
<?php include 'templates/header.php'; ?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Aktivasi Akun Pengguna</h4>
                    <p class="card-description">
                        Silahkan pilih akun yang akan diaktivasi
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Username
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admin as $user): ?>
                                    <tr>
                                        <td class="py-1"><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td>
                                            <a href="#" class="badge badge-warning delete-admin-btn" data-id="<?php echo $user['_id']; ?>">Hapus Admin</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->

    <!-- Include Footer -->
    <?php include 'templates/footer.php'; ?>
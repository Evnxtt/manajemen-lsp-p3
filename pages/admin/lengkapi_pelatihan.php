<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../auth/login.php");
    exit;
}

require '../../vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->pelatihan;
$collectionModul = $client->lsp_p3->modul_pelatihan;

// Ambil ID dari parameter GET
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$pelatihan = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $daftar_modul = [];
    if (isset($_POST['modul_tipe']) && is_array($_POST['modul_tipe'])) {
        $count = count($_POST['modul_tipe']);
        for ($i = 0; $i < $count; $i++) {
            $daftar_modul[] = [
                'tipe' => $_POST['modul_tipe'][$i],
                'nama' => $_POST['modul_nama'][$i],
                'deskripsi' => $_POST['modul_deskripsi'][$i]
            ];
        }
    }

    // Update ke collection modul_pelatihan
    $collectionModul->updateOne(
        ['id_pelatihan' => (string)$id],
        [
            '$set' => [
                'daftar_modul' => $daftar_modul,
                'status_kelengkapan' => 'lengkap'
            ]
        ],
        ['upsert' => true]
    );

    $_SESSION['success_message'] = "Modul pelatihan berhasil dilengkapi!";
    header("Location: list_pelatihan.php");
    exit;
}
?>

<!-- Include Header -->
<link rel="stylesheet" href="../assets/css/vertical-layout-light/testcss.css">
<?php include 'templates/header.php'; ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Lengkapi Modul Pelatihan</h4>
                    <form class="forms-sample" method="POST" action="">
                        <div id="modul-container">
                            <div class="form-row modul-item">
                                <div class="form-group col-md-3">
                                    <label>Tipe Modul</label>
                                    <select name="modul_tipe[]" class="form-control" required>
                                        <option value="Sesi Materi">Sesi Materi</option>
                                        <option value="Studi Kasus">Studi Kasus</option>
                                        <option value="Uji Kompetensi">Uji Kompetensi</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nama Modul</label>
                                    <input type="text" name="modul_nama[]" class="form-control" required placeholder="Nama Modul">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Deskripsi Modul</label>
                                    <input type="text" name="modul_deskripsi[]" class="form-control" placeholder="Deskripsi Modul">
                                </div>
                                <div class="form-group col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-remove-modul" style="display:none;">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info" id="add-modul">Tambah Modul</button>
                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('add-modul').addEventListener('click', function() {
        var container = document.getElementById('modul-container');
        var item = container.querySelector('.modul-item');
        var clone = item.cloneNode(true);
        // Bersihkan input pada clone
        clone.querySelectorAll('input').forEach(function(input) {
            input.value = '';
        });
        clone.querySelector('select').selectedIndex = 0;
        clone.querySelector('.btn-remove-modul').style.display = 'block';
        container.appendChild(clone);
    });

    document.getElementById('modul-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-modul')) {
            e.target.closest('.modul-item').remove();
        }
    });
</script>
<?php include 'templates/footer.php'; ?>
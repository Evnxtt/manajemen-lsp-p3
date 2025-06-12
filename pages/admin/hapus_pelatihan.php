<?php
session_start();
require '../../vendor/autoload.php';

use MongoDB\Client;

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: list_pelatihan.php?hapus=gagal");
    exit;
}

$client = new Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->pelatihan;
$collectionModul = $client->lsp_p3->modul_pelatihan;

$id = $_GET['id'];

try {
    // Hapus pelatihan utama
    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    // Hapus juga data modul_pelatihan yang terkait
    $resultModul = $collectionModul->deleteMany(['id_pelatihan' => $id]);

    if ($result->getDeletedCount() > 0) {
        header("Location: list_pelatihan.php?hapus=berhasil");
    } else {
        header("Location: list_pelatihan.php?hapus=gagal");
    }
} catch (Exception $e) {
    header("Location: list_pelatihan.php?hapus=error");
}
exit;

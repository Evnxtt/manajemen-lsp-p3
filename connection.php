<?php
require 'vendor/autoload.php'; // Memuat MongoDB PHP Driver

use MongoDB\Client;

try {
    // Koneksi ke MongoDB
    $client = new Client("mongodb://localhost:27017");

    // Pilih database
    $database = $client->selectDatabase('nama_database');

    echo "Koneksi ke MongoDB berhasil!";
} catch (Exception $e) {
    echo "Gagal terhubung: " . $e->getMessage();
}
?>
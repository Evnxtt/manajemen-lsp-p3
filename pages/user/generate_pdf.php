<?php
require_once __DIR__ . '/../../vendor/autoload.php';
session_start();

use MongoDB\Client;
use mikehaertl\pdftk\Pdf;

// Cek login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil data user dari MongoDB
$client = new Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->form_apl01;
$data = $collection->findOne(['user_id' => $_SESSION["user_id"]], ['sort' => ['created_at' => -1]]);

if (!$data) {
    die("Data tidak ditemukan.");
}

// Mapping data ke field PDF
$formData = [
    'Text1' => $data['nama_lengkap'] ?? '',
    'Text2' => ($data['tempat_lahir'] ?? '') . ' / ' . ($data['tanggal_lahir'] ?? ''),
    'Text3' => $data['jenis_kelamin'] ?? '',
    'Text4' => $data['kebangsaan'] ?? '',
    'Text5' => $data['alamat'] ?? '',
    'Text6' => $data['kode_pos'] ?? '',
    'Text7' => $data['no_tlp_rumah'] ?? '',
    'Text8' => $data['email_pribadi'] ?? '',
    'Text10' => $data['no_tlp_pribadi'] ?? '',
    'Text11' => $data['riwayat_pendidikan'] ?? '',
    'Text12' => $data['nama_institusi'] ?? '',
    'Text13' => $data['jabatan'] ?? '',
    'Text14' => $data['alamat_kantor'] ?? '',
    'Text15' => $data['kode_pos_kantor'] ?? '',
    'Text16' => $data['no_tlp_kantor'] ?? '',
    'Text17' => $data['email_kantor'] ?? '',
    'Text18' => $data['nik'] ?? '',
    'Text22' => $data['paspor'] ?? '',
];

// Lokasi template PDF (HARUS AcroForm, bukan XFA!)
$templatePath = __DIR__ . '/../assets/pdf/template.pdf';

// Generate dan kirim PDF ke browser
$pdf = new Pdf($templatePath);
if (!$pdf->fillForm($formData)->needAppearances()->send('FR_APL_01.pdf')) {
    header('Content-Type: text/plain');
    echo "Gagal membuat PDF:\n";
    echo $pdf->getCommand() . "\n";
    echo $pdf->getError();
    exit;
}
<?php
session_start();
require '../../vendor/autoload.php';

use MongoDB\Client;
use setasign\Fpdi\Tcpdf\Fpdi;

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$client = new Client("mongodb://localhost:27017");
$collectionPelatihan = $client->lsp_p3->pelatihan;
$collectionUser = $client->lsp_p3->users;

$id_pelatihan = isset($_GET['id_pelatihan']) ? $_GET['id_pelatihan'] : null;
$userId = $_SESSION['user_id'];

if (!$id_pelatihan) {
    die("ID pelatihan tidak ditemukan.");
}

// Ambil data pelatihan
$pelatihan = $collectionPelatihan->findOne(['_id' => new MongoDB\BSON\ObjectId($id_pelatihan)]);
$user = $collectionUser->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);

// Ambil nama user (gunakan struktur sesuai database Anda)
$nama_user = '';
if (isset($user['informasi_pribadi'])) {
    $nama_user = trim(($user['informasi_pribadi']['nama_depan'] ?? '') . ' ' . ($user['informasi_pribadi']['nama_belakang'] ?? ''));
} elseif (isset($user['nama'])) {
    $nama_user = $user['nama'];
} else {
    $nama_user = '-';
}

$nama_pelatihan = $pelatihan['detail_pelatihan']['nama_pelatihan'] ?? '-';
$tanggal = isset($pelatihan['tanggal_mulai']) ? $pelatihan['tanggal_mulai']->toDateTime()->format('d-m-Y') : '-';

// Path ke template PDF (pastikan path benar)
$templatePath = __DIR__ . '/Sertif.pdf';

$pdf = new Fpdi();
$pageCount = $pdf->setSourceFile($templatePath);
$templateId = $pdf->importPage(1);
$pdf->AddPage('L');
$pdf->useTemplate($templateId, 0, 0, 297); // 297 = lebar A4 landscape

// Register font custom
$pdf->AddFont('pinyonscript', '', 'pinyonscript.php');
$pdf->AddFont('poppinsb', '', 'poppinsb.php');

// Nama user dengan Pinyon Script
$pdf->SetFont('pinyonscript', '', 65);
$pdf->SetTextColor(225, 167, 48);
$pdf->SetXY(70, 80);
$pdf->Cell(150, 10, $nama_user, 0, 1, 'C');

// Nama pelatihan dengan Poppins Bold
$pdf->SetFont('poppinsb', '', 30);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(70, 115);
$pdf->Cell(150, 10, $nama_pelatihan, 0, 1, 'C');

$pdf->Output('Sertifikat_' . preg_replace('/\s+/', '_', $nama_user) . '.pdf', 'D');
exit;

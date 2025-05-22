<?php
require '../../vendor/autoload.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->lsp_p3->form_apl01;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "user_id" => $_SESSION["user_id"],
        "nama_lengkap" => $_POST["nama_lengkap"],
        "jenis_kelamin" => $_POST["jenis_kelamin"],
        "tempat_lahir" => $_POST["tempat_lahir"],
        "tanggal_lahir" => $_POST["tanggal_lahir"],
        "alamat" => $_POST["alamat"],
        "kode_pos" => $_POST["kode_pos"],
        "kebangsaan" => $_POST["kebangsaan"],
        "riwayat_pendidikan" => $_POST["riwayat_pendidikan"],
        "nik" => $_POST["nik"],
        "paspor" => $_POST["paspor"],
        "no_tlp_rumah" => $_POST["no_tlp_rumah"],
        "email_pribadi" => $_POST["email_pribadi"],
        "no_tlp_pribadi" => $_POST["no_tlp_pribadi"],

        "nama_institusi" => $_POST["nama_institusi"],
        "jabatan" => $_POST["jabatan"],
        "alamat_kantor" => $_POST["alamat_kantor"],
        "kode_pos_kantor" => $_POST["kode_pos_kantor"],
        "no_tlp_kantor" => $_POST["no_tlp_kantor"],
        "email_kantor" => $_POST["email_kantor"],

        "created_at" => new MongoDB\BSON\UTCDateTime()
    ];

    $collection->insertOne($data);
    header("Location: pendaftaran.php?success=1");
    exit;
}
?>

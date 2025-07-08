<?php
if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {
$konektor = mysqli_connect("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");

$tanggal_awal = $_POST['tanggal_awal'];
$tanggal_akhir = $_POST['tanggal_akhir'];

$tanggal_awal_edit = date('F Y', strtotime($_POST['tanggal_awal']));
$tanggal_akhir_edit = date('F Y', strtotime($_POST['tanggal_akhir']));

$filename = "Laporan Posisi Keuangan Bulan " . $tanggal_awal_edit . ".xls";

header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=$filename");

echo "<h3>LAPORAN POSISI KEUANGAN SEKOLAH NUSAPUTERA<br>Bulan: $tanggal_awal_edit </h3>";
}
<?php
include "connect.php";

if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {
    // konektor ke database

// Validasi dan ambil tanggal awal, tanggal akhir, dan nomor kasbon dari input pengguna
$tanggal_awal = $_POST['tanggal_awal'];
$tanggal_akhir = $_POST['tanggal_akhir'];

$tanggal_awal_edit = strtoupper(date('F Y', strtotime($_POST['tanggal_awal'])));
$tanggal_akhir_edit = strtoupper(date('F Y', strtotime($_POST['tanggal_akhir'])));


$filename = "Laporan Laba Rugi Bulan " . $tanggal_awal_edit . ".xls";

header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=$filename");

echo "<h3>LAPORAN LABA RUGI SEKOLAH NUSAPUTERA<br>BULAN: $tanggal_awal_edit </h3>";

echo "<table border='1'>
<tr style='background-color:rgb(77, 255, 71)'>
    <th>KODE AKUN</th>
    <th>NAMA AKUN</th>
    <th>DAYCARE</th>
    <th>TK</th>
    <th>SD</th>
    <th>SMP</th>
    <th>SMA</th>
    <th>SMK1-TKJ, MM</th>
    <th>SMK2-F, FA, H</th>
    <th>STIFERA</th>
    <th>MESS</th>
    <th>SEKOLAH BASKET</th>
    <th>LES MANDARIN</th>
    <th>UMUM</th>
    <th>TOTAL</th>
</tr>";

$sql1 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '1' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '1' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_daycare_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '1' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '1' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_daycare_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '2' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '2' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_tk_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '2' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '2' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_tk_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '3' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '3' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_sd_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '3' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '3' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_sd_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '4' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '4' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_smp_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '4' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '4' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_smp_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '5' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '5' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_sma_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '5' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '5' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_sma_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '6' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '6' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_smk1_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '6' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '6' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_smk1_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '7' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '7' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_smk2_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '7' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '7' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_smk2_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '8' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '8' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_stifera_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '8' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '8' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_stifera_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '9' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '9' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_mess_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '9' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '9' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_mess_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '10' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '10' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_sekolahbasket_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '10' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '10' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_sekolahbasket_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '11' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '11' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_lesmandarin_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '11' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '11' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_lesmandarin_pendapatan,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '12' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '12' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_umum_pendapatan,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '12' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '12' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_umum_pendapatan

FROM akun
WHERE klasifikasi IN ('16. PENDAPATAN DI LUAR USAHA', '17. PENERIMAAN RUTIN', '18. PENERIMAAN TDK RUTIN')";


$sql2 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '1' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '1' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_daycare_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '1' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '1' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_daycare_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '2' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '2' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_tk_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '2' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '2' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_tk_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '3' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '3' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_sd_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '3' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '3' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_sd_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '4' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '4' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_smp_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '4' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '4' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_smp_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '5' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '5' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_sma_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '5' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '5' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_sma_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '6' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '6' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_smk1_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '6' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '6' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_smk1_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '7' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '7' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_smk2_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '7' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '7' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_smk2_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '8' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '8' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_stifera_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '8' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '8' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_stifera_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '9' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '9' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_mess_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '9' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '9' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_mess_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '10' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '10' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_sekolahbasket_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '10' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '10' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_sekolahbasket_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '11' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '11' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_lesmandarin_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '11' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '11' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_lesmandarin_biaya,

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '12' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(debit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '12' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debit_umum_biaya,

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi WHERE status = 1 AND akun.kode_akun = transaksi.kode_akun AND transaksi.kode_jenjang = '12' AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +

(SELECT COALESCE(SUM(kredit), 0) 
FROM transaksi_memorial WHERE status = 1 AND akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '12' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kredit_umum_biaya

FROM akun
WHERE klasifikasi IN ('12. BIAYA DI LUAR USAHA', '13. BIAYA UMUM & ADM', '15. OPERASIONAL RUTIN')";

        $result1 = mysqli_query($konektor, $sql1);
        $total_pendapatan_daycare = 0;
        $total_pendapatan_tk = 0;
        $total_pendapatan_sd = 0;
        $total_pendapatan_smp = 0;
        $total_pendapatan_sma = 0;
        $total_pendapatan_smk1 = 0;
        $total_pendapatan_smk2 = 0;
        $total_pendapatan_stifera = 0;
        $total_pendapatan_mess = 0;
        $total_pendapatan_sekolahbasket = 0;
        $total_pendapatan_lesmandarin = 0;
        $total_pendapatan_umum = 0;

        echo "<tr style='background-color:rgb(127, 227, 238)'>
        <td colspan='15' style='text-align: left; font-weight: bold;'>PENERIMAAN</td>
    </tr>";

        while ($row = mysqli_fetch_assoc($result1)) {
            $pendapatan_daycare = isset($row['kredit_daycare_pendapatan']) && isset($row['debit_daycare_pendapatan']) ? $row['kredit_daycare_pendapatan'] - $row['debit_daycare_pendapatan'] : 0;
            $pendapatan_tk = isset($row['kredit_tk_pendapatan']) && isset($row['debit_tk_pendapatan']) ? $row['kredit_tk_pendapatan'] - $row['debit_tk_pendapatan'] : 0;
            $pendapatan_sd = isset($row['kredit_sd_pendapatan']) && isset($row['debit_sd_pendapatan']) ? $row['kredit_sd_pendapatan'] - $row['debit_sd_pendapatan'] : 0;
            $pendapatan_smp = isset($row['kredit_smp_pendapatan']) && isset($row['debit_smp_pendapatan']) ? $row['kredit_smp_pendapatan'] - $row['debit_smp_pendapatan'] : 0;
            $pendapatan_sma = isset($row['kredit_sma_pendapatan']) && isset($row['debit_sma_pendapatan']) ? $row['kredit_sma_pendapatan'] - $row['debit_sma_pendapatan'] : 0;
            $pendapatan_smk1 = isset($row['kredit_smk1_pendapatan']) && isset($row['debit_smk1_pendapatan']) ? $row['kredit_smk1_pendapatan'] - $row['debit_smk1_pendapatan'] : 0;
            $pendapatan_smk2 = isset($row['kredit_smk2_pendapatan']) && isset($row['debit_smk2_pendapatan']) ? $row['kredit_smk2_pendapatan'] - $row['debit_smk2_pendapatan'] : 0;
            $pendapatan_stifera = isset($row['kredit_stifera_pendapatan']) && isset($row['debit_stifera_pendapatan']) ? $row['kredit_stifera_pendapatan'] - $row['debit_stifera_pendapatan'] : 0;
            $pendapatan_mess = isset($row['kredit_mess_pendapatan']) && isset($row['debit_mess_pendapatan']) ? $row['kredit_mess_pendapatan'] - $row['debit_mess_pendapatan'] : 0;
            $pendapatan_sekolahbasket = isset($row['kredit_sekolahbasket_pendapatan']) && isset($row['debit_sekolahbasket_pendapatan']) ? $row['kredit_sekolahbasket_pendapatan'] - $row['debit_sekolahbasket_pendapatan'] : 0;
            $pendapatan_lesmandarin = isset($row['kredit_lesmandarin_pendapatan']) && isset($row['debit_lesmandarin_pendapatan']) ? $row['kredit_lesmandarin_pendapatan'] - $row['debit_lesmandarin_pendapatan'] : 0;
            $pendapatan_umum = isset($row['kredit_umum_pendapatan']) && isset($row['debit_umum_pendapatan']) ? $row['kredit_umum_pendapatan'] - $row['debit_umum_pendapatan'] : 0;

            $total_pendapatan = $pendapatan_daycare + $pendapatan_tk + $pendapatan_sd + $pendapatan_smp +
                    $pendapatan_sma + $pendapatan_smk1 + $pendapatan_smk2 + $pendapatan_stifera +
                    $pendapatan_mess + $pendapatan_sekolahbasket + $pendapatan_lesmandarin + $pendapatan_umum;
            
            $total_pendapatan_daycare += $pendapatan_daycare;
            $total_pendapatan_tk += $pendapatan_tk; 
            $total_pendapatan_sd += $pendapatan_sd; 
            $total_pendapatan_smp += $pendapatan_smp;  
            $total_pendapatan_sma += $pendapatan_sma; 
            $total_pendapatan_smk1 += $pendapatan_smk1;  
            $total_pendapatan_smk2 += $pendapatan_smk2; 
            $total_pendapatan_stifera += $pendapatan_stifera;
            $total_pendapatan_mess += $pendapatan_mess; 
            $total_pendapatan_sekolahbasket += $pendapatan_sekolahbasket; 
            $total_pendapatan_lesmandarin += $pendapatan_lesmandarin;
            $total_pendapatan_umum += $pendapatan_umum; 

            $total_pendapatan2 = $total_pendapatan_daycare + $total_pendapatan_tk + $total_pendapatan_sd +
                    $total_pendapatan_smp + $total_pendapatan_sma + $total_pendapatan_smk1 +
                    $total_pendapatan_smk2 + $total_pendapatan_stifera + $total_pendapatan_mess +
                    $total_pendapatan_sekolahbasket + $total_pendapatan_lesmandarin + $total_pendapatan_umum;


            

           

                if ($total_pendapatan > 0) {
                    echo "<tr>";
                    echo "<td>" . $row['kode_akun'] . "</td>";
                    echo "<td>" . $row['nama_akun'] . "</td>";
                
                   echo "<td>" . $pendapatan_daycare . "</td>";
                 echo "<td>" . $pendapatan_tk . "</td>";
                  echo "<td>" . $pendapatan_sd . "</td>";
                   echo "<td>" . $pendapatan_smp . "</td>";
                    echo "<td>" . $pendapatan_sma . "</td>";
                  echo "<td>" . $pendapatan_smk1 . "</td>";
                     echo "<td>" . $pendapatan_smk2 . "</td>";
                   echo "<td>" . $pendapatan_stifera . "</td>";
                    echo "<td>" . $pendapatan_mess . "</td>";
                   echo "<td>" . $pendapatan_sekolahbasket . "</td>";
                  echo "<td>" . $pendapatan_lesmandarin . "</td>";
                  echo "<td>" . $pendapatan_umum . "</td>";
                
                    echo "<td><b>" . $total_pendapatan . "</b></td>";
                    echo "</tr>";
                }

        

        }
        echo "<tr style='font-weight: bold; text-align: center; background-color:rgb(127, 227, 238)'>
        <td colspan='2'>TOTAL PENDAPATAN</td>
        <td>{$total_pendapatan_daycare}</td>
        <td>{$total_pendapatan_tk}</td>
        <td>{$total_pendapatan_sd}</td>
        <td>{$total_pendapatan_smp}</td>
        <td>{$total_pendapatan_sma}</td>
        <td>{$total_pendapatan_smk1}</td>
        <td>{$total_pendapatan_smk2}</td>
        <td>{$total_pendapatan_stifera}</td>
        <td>{$total_pendapatan_mess}</td>
        <td>{$total_pendapatan_sekolahbasket}</td>
        <td>{$total_pendapatan_lesmandarin}</td>
        <td>{$total_pendapatan_umum}</td>
        <td>{$total_pendapatan2}</td>
    </tr>";
            $result2 = mysqli_query($konektor, $sql2);
            $total_biaya_daycare = 0;
            $total_biaya_tk = 0;
            $total_biaya_sd = 0;
            $total_biaya_smp = 0;
            $total_biaya_sma = 0;
            $total_biaya_smk1 = 0;
            $total_biaya_smk2 = 0;
            $total_biaya_stifera = 0;
            $total_biaya_mess = 0;
            $total_biaya_sekolahbasket = 0;
            $total_biaya_lesmandarin = 0;
            $total_biaya_umum = 0;
            echo "<tr style='background-color:rgb(245, 197, 187)'>
            <td colspan='15' style='text-align: left; font-weight: bold;'>BIAYA</td>
        </tr>";
        while ($row = mysqli_fetch_assoc($result2)) {
            $biaya_daycare = isset($row['debit_daycare_biaya']) && isset($row['kredit_daycare_biaya']) ? $row['debit_daycare_biaya'] - $row['kredit_daycare_biaya'] : 0;
            $biaya_tk = isset($row['debit_tk_biaya']) && isset($row['kredit_tk_biaya']) ? $row['debit_tk_biaya'] - $row['kredit_tk_biaya'] : 0;
            $biaya_sd = isset($row['debit_sd_biaya']) && isset($row['kredit_sd_biaya']) ? $row['debit_sd_biaya'] - $row['kredit_sd_biaya'] : 0;
            $biaya_smp = isset($row['debit_smp_biaya']) && isset($row['kredit_smp_biaya']) ? $row['debit_smp_biaya'] - $row['kredit_smp_biaya'] : 0;
            $biaya_sma = isset($row['debit_sma_biaya']) && isset($row['kredit_sma_biaya']) ? $row['debit_sma_biaya'] - $row['kredit_sma_biaya'] : 0;
            $biaya_smk1 = isset($row['debit_smk1_biaya']) && isset($row['kredit_smk1_biaya']) ? $row['debit_smk1_biaya'] - $row['kredit_smk1_biaya'] : 0;
            $biaya_smk2 = isset($row['debit_smk2_biaya']) && isset($row['kredit_smk2_biaya']) ? $row['debit_smk2_biaya'] - $row['kredit_smk2_biaya'] : 0;
            $biaya_stifera = isset($row['debit_stifera_biaya']) && isset($row['kredit_stifera_biaya']) ? $row['debit_stifera_biaya'] - $row['kredit_stifera_biaya'] : 0;
            $biaya_mess = isset($row['debit_mess_biaya']) && isset($row['kredit_mess_biaya']) ? $row['debit_mess_biaya'] - $row['kredit_mess_biaya'] : 0;
            $biaya_sekolahbasket = isset($row['debit_sekolahbasket_biaya']) && isset($row['kredit_sekolahbasket_biaya']) ? $row['debit_sekolahbasket_biaya'] - $row['kredit_sekolahbasket_biaya'] : 0;
            $biaya_lesmandarin = isset($row['debit_lesmandarin_biaya']) && isset($row['kredit_lesmandarin_biaya']) ? $row['debit_lesmandarin_biaya'] - $row['kredit_lesmandarin_biaya'] : 0;
            $biaya_umum = isset($row['debit_umum_biaya']) && isset($row['kredit_umum_biaya']) ? $row['debit_umum_biaya'] - $row['kredit_umum_biaya'] : 0;                     

            $total_biaya = $biaya_daycare + $biaya_tk + $biaya_sd + $biaya_smp +
               $biaya_sma + $biaya_smk1 + $biaya_smk2 + $biaya_stifera +
               $biaya_mess + $biaya_sekolahbasket + $biaya_lesmandarin + $biaya_umum;


            $total_biaya_daycare += $biaya_daycare;
            $total_biaya_tk += $biaya_tk;  
            $total_biaya_sd += $biaya_sd; 
            $total_biaya_smp += $biaya_smp;
            $total_biaya_sma += $biaya_sma; 
            $total_biaya_smk1 += $biaya_smk1; 
            $total_biaya_smk2 += $biaya_smk2;  
            $total_biaya_stifera += $biaya_stifera;
            $total_biaya_mess += $biaya_mess; 
            $total_biaya_sekolahbasket += $biaya_sekolahbasket; 
            $total_biaya_lesmandarin += $biaya_lesmandarin;
            $total_biaya_umum += $biaya_umum; 

            $total_biaya2 = $total_biaya_daycare + $total_biaya_tk + $total_biaya_sd +
                $total_biaya_smp + $total_biaya_sma + $total_biaya_smk1 +
                $total_biaya_smk2 + $total_biaya_stifera + $total_biaya_mess +
                $total_biaya_sekolahbasket + $total_biaya_lesmandarin + $total_biaya_umum;


       
        
                if ($total_biaya > 0) {
                    echo "<tr>";
                    echo "<td>" . $row['kode_akun'] . "</td>";
                    echo "<td>" . $row['nama_akun'] . "</td>";
                
                   echo "<td>" . $biaya_daycare . "</td>";
                 echo "<td>" . $biaya_tk . "</td>";
                  echo "<td>" . $biaya_sd . "</td>";
                   echo "<td>" . $biaya_smp . "</td>";
                    echo "<td>" . $biaya_sma . "</td>";
                  echo "<td>" . $biaya_smk1 . "</td>";
                     echo "<td>" . $biaya_smk2 . "</td>";
                   echo "<td>" . $biaya_stifera . "</td>";
                    echo "<td>" . $biaya_mess . "</td>";
                   echo "<td>" . $biaya_sekolahbasket . "</td>";
                  echo "<td>" . $biaya_lesmandarin . "</td>";
                  echo "<td>" . $biaya_umum . "</td>";
                
                    echo "<td><b>" . $total_biaya . "</b></td>";
                    echo "</tr>";
                }
        


        
        }
        echo "<tr style='font-weight: bold; text-align: center; background-color:rgb(245, 197, 187)'>
        <td colspan='2'>TOTAL BIAYA</td>
        <td>{$total_biaya_daycare}</td>
        <td>{$total_biaya_tk}</td>
        <td>{$total_biaya_sd}</td>
        <td>{$total_biaya_smp}</td>
        <td>{$total_biaya_sma}</td>
        <td>{$total_biaya_smk1}</td>
        <td>{$total_biaya_smk2}</td>
        <td>{$total_biaya_stifera}</td>
        <td>{$total_biaya_mess}</td>
        <td>{$total_biaya_sekolahbasket}</td>
        <td>{$total_biaya_lesmandarin}</td>
        <td>{$total_biaya_umum}</td>
        <td>{$total_biaya2}</td>
    </tr>";
        $labarugi_daycare = $total_pendapatan_daycare - $total_biaya_daycare;
        $labarugi_tk = $total_pendapatan_tk - $total_biaya_tk; 
        $labarugi_sd = $total_pendapatan_sd - $total_biaya_sd; 
        $labarugi_smp = $total_pendapatan_smp - $total_biaya_smp; 
        $labarugi_sma = $total_pendapatan_sma - $total_biaya_sma; 
        $labarugi_smk1 = $total_pendapatan_smk1 - $total_biaya_smk1; 
        $labarugi_smk2 = $total_pendapatan_smk2 - $total_biaya_smk2;
        $labarugi_stifera = $total_pendapatan_stifera - $total_biaya_stifera; 
        $labarugi_mess = $total_pendapatan_mess - $total_biaya_mess; 
        $labarugi_sekolah_basket = $total_pendapatan_sekolahbasket - $total_biaya_sekolahbasket; 
        $labarugi_les_mandarin = $total_pendapatan_lesmandarin - $total_biaya_lesmandarin; 
        $labarugi_umum = $total_pendapatan_umum - $total_biaya_umum; 
 
        $total2 = $labarugi_daycare + $labarugi_tk + $labarugi_sd + $labarugi_smp + $labarugi_sma + $labarugi_smk1 + $labarugi_smk2 + $labarugi_stifera + $labarugi_mess + $labarugi_sekolah_basket + $labarugi_les_mandarin + $labarugi_umum;


        echo "<tr style='font-weight: bold; text-align: center; background-color:rgb(249, 219, 84)'>
        <td colspan='2'>LABA/RUGI</td>
        <td>" . $labarugi_daycare . "</td>
        <td>" . $labarugi_tk . "</td>
        <td>" . $labarugi_sd . "</td>
        <td>" . $labarugi_smp . "</td>
        <td>" . $labarugi_sma . "</td>
        <td>" . $labarugi_smk1 . "</td>
        <td>" . $labarugi_smk2 . "</td>
        <td>" . $labarugi_stifera . "</td>
        <td>" . $labarugi_mess . "</td>
        <td>" . $labarugi_sekolah_basket . "</td>
        <td>" . $labarugi_les_mandarin . "</td>
        <td>" . $labarugi_umum . "</td>
        <td>" . $total2 . "</td>
    </tr>";
        echo "</table>";
    } else {
        echo "0 results";
    }
    $konektor->close();

?>


<!-- coding awal ditaruh di function.php -->
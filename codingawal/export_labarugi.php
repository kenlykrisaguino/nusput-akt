<?php
if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {
    // Koneksi ke database
$konektor = mysqli_connect("localhost", "tagy3641_aktsystem", "ku+P.uz?[p$3ldj6", "tagy3641_akt");

// Validasi dan ambil tanggal awal, tanggal akhir, dan nomor kasbon dari input pengguna
$tanggal_awal = $_POST['tanggal_awal'];
$tanggal_akhir = $_POST['tanggal_akhir'];

$tanggal_awal_edit = date('F Y', strtotime($_POST['tanggal_awal']));
$tanggal_akhir_edit = date('F Y', strtotime($_POST['tanggal_akhir']));

$filename = "Laporan Laba Rugi Bulan " . $tanggal_awal_edit . ".xls";

header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=$filename");

echo "<h3>LAPORAN LABA RUGI SEKOLAH NUSAPUTERA<br>Bulan: $tanggal_awal_edit </h3>";

        $sql = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '1' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '1' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '1' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_daycare,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '1' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '1' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '1' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_daycare,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '2' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '2' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '2' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_tk,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '2' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '2' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '2' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_tk,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '3' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '3' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '3' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_sd,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '3' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '3' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '3' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_sd,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '4' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '4' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '4' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_smp,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '4' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '4' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '4' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_smp,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '5' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '5' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '5' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_sma,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '5' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '5' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '5' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_sma,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '6' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '6' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '6' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_smk1,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '6' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '6' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '6' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_smk1,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '7' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '7' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '7' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_smk2,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '7' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '7' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '7' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_smk2,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '8' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '8' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '8' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_stifera,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '8' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '8' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '8' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_stifera,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '9' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '9' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '9' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_mess,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '9' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '9' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '9' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_mess,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '10' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '10' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '10' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_sekolahbasket,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '10' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '10' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '10' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_sekolahbasket,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '11' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '11' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '11' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_lesmandarin,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '11' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '11' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '11' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_lesmandarin,

        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '12' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '12' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '12' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_debit_umum,

        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.kode_jenjang = '12' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.kode_jenjang = '12' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) +
        (SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '12' AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) AS total_kredit_umum

        FROM akun
        WHERE klasifikasi IN ('17. PENERIMAAN RUTIN', '18. PENERIMAAN TDK RUTIN', '15. OPERASIONAL RUTIN', '13. BIAYA UMUM & ADM', 
        '16. PENDAPATAN DI LUAR USAHA', '12. BIAYA DI LUAR USAHA')";

        $result = $konektor->query($sql);
        if ($result === false) {
        die("Error in SQL query: " . $konektor->error);
        }
        if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
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

                $totalDaycare = 0;
                $totalTk = 0;
                $totalSd = 0;
                $totalSmp = 0;
                $totalSma = 0;
                $totalSmk1 = 0;
                $totalSmk2 = 0;
                $totalStifera = 0;
                $totalMess = 0;
                $totalSekolahBasket = 0;
                $totalLesMandarin = 0;
                $totalUmum = 0;
                
                while ($row = $result->fetch_assoc()) {
                    $saldo_normal = $row['saldo_normal'];
                    $total_debit_daycare = $row['total_debit_daycare'];
                    $total_kredit_daycare = $row['total_kredit_daycare'];
                    $total_debit_tk = $row['total_debit_tk'];
                    $total_kredit_tk = $row['total_kredit_tk'];
                    $total_debit_sd = $row['total_debit_sd'];
                    $total_kredit_sd = $row['total_kredit_sd'];
                    $total_debit_smp = $row['total_debit_smp'];
                    $total_kredit_smp = $row['total_kredit_smp'];
                    $total_debit_sma = $row['total_debit_sma'];
                    $total_kredit_sma = $row['total_kredit_sma'];
                    $total_debit_smk1 = $row['total_debit_smk1'];
                    $total_kredit_smk1 = $row['total_kredit_smk1'];
                    $total_debit_smk2 = $row['total_debit_smk2'];
                    $total_kredit_smk2 = $row['total_kredit_smk2'];
                    $total_debit_stifera = $row['total_debit_stifera'];
                    $total_kredit_stifera = $row['total_kredit_stifera'];
                    $total_debit_mess = $row['total_debit_mess'];
                    $total_kredit_mess = $row['total_kredit_mess'];
                    $total_debit_sekolahbasket = $row['total_debit_sekolahbasket'];
                    $total_kredit_sekolahbasket = $row['total_kredit_sekolahbasket'];
                    $total_debit_lesmandarin = $row['total_debit_lesmandarin'];
                    $total_kredit_lesmandarin = $row['total_kredit_lesmandarin'];
                    $total_debit_umum = $row['total_debit_umum'];
                    $total_kredit_umum = $row['total_kredit_umum'];

                    if ($saldo_normal == 'Debit') {
                        $daycare = $total_debit_daycare - $total_kredit_daycare;
                        $tk = $total_debit_tk - $total_kredit_tk;
                        $sd = $total_debit_sd - $total_kredit_sd;
                        $smp = $total_debit_smp - $total_kredit_smp;
                        $sma = $total_debit_sma - $total_kredit_sma;
                        $smk1 = $total_debit_smk1 - $total_kredit_smk1;
                        $smk2 = $total_debit_smk2 - $total_kredit_smk2;
                        $stifera = $total_debit_stifera - $total_kredit_stifera;
                        $mess = $total_debit_mess - $total_kredit_mess;
                        $sekolahbasket = $total_debit_sekolahbasket - $total_kredit_sekolahbasket;
                        $lesmandarin = $total_debit_lesmandarin - $total_kredit_lesmandarin;
                        $umum = $total_debit_umum - $total_kredit_umum;                    
                    } else if ($saldo_normal == 'Kredit') {
                        $daycare = $total_kredit_daycare - $total_debit_daycare;
                        $tk = $total_kredit_tk - $total_debit_tk;
                        $sd = $total_kredit_sd - $total_debit_sd;
                        $smp = $total_kredit_smp - $total_debit_smp;
                        $sma = $total_kredit_sma - $total_debit_sma;
                        $smk1 = $total_kredit_smk1 - $total_debit_smk1;
                        $smk2 = $total_kredit_smk2 - $total_debit_smk2;
                        $stifera = $total_kredit_stifera - $total_debit_stifera;
                        $mess = $total_kredit_mess - $total_debit_mess;
                        $sekolahbasket = $total_kredit_sekolahbasket - $total_debit_sekolahbasket;
                        $lesmandarin = $total_kredit_lesmandarin - $total_debit_lesmandarin;
                        $umum = $total_kredit_umum - $total_debit_umum;
                    }
                    $totalDaycare += $daycare;
                    $totalTk += $tk;
                    $totalSd += $sd;
                    $totalSmp += $smp;
                    $totalSma += $sma;
                    $totalSmk1 += $smk1;
                    $totalSmk2 += $smk2;
                    $totalStifera += $stifera;
                    $totalMess += $mess;
                    $totalSekolahBasket += $sekolahbasket;
                    $totalLesMandarin += $lesmandarin;
                    $totalUmum += $umum;
            echo "<tr>
                    <td>" . $row['kode_akun'] . "</td>
                    <td>" . $row['nama_akun'] . "</td>          
                    <td>" . number_format($daycare, 0, '.', ',') . "</td>
                    <td>" . number_format($tk, 0, '.', ',') . "</td>
                    <td>" . number_format($sd, 0, '.', ',') . "</td>
                    <td>" . number_format($smp, 0, '.', ',') . "</td>
                    <td>" . number_format($sma, 0, '.', ',') . "</td>
                    <td>" . number_format($smk1, 0, '.', ',') . "</td>
                    <td>" . number_format($smk2, 0, '.', ',') . "</td>
                    <td>" . number_format($stifera, 0, '.', ',') . "</td>
                    <td>" . number_format($mess, 0, '.', ',') . "</td>
                    <td>" . number_format($sekolahbasket, 0, '.', ',') . "</td>
                    <td>" . number_format($lesmandarin, 0, '.', ',') . "</td>
                    <td>" . number_format($umum, 0, '.', ',') . "</td>
                    <td>" . number_format($daycare + $tk + $sd + $smp + $sma + $smk1 + $smk2 + $stifera + $mess + $sekolahbasket + $lesmandarin + $umum, 0, '.', ',') . "</td>
                </tr>";
        }
        echo "<tr style='font-weight: bold; text-align: center;'>
        <td colspan='2'>TOTAL</td>
        <td>" . number_format($totalDaycare, 0, '.', ',') . "</td>
        <td>" . number_format($totalTk, 0, '.', ',') . "</td>
        <td>" . number_format($totalSd, 0, '.', ',') . "</td>
        <td>" . number_format($totalSmp, 0, '.', ',') . "</td>
        <td>" . number_format($totalSma, 0, '.', ',') . "</td>
        <td>" . number_format($totalSmk1, 0, '.', ',') . "</td>
        <td>" . number_format($totalSmk2, 0, '.', ',') . "</td>
        <td>" . number_format($totalStifera, 0, '.', ',') . "</td>
        <td>" . number_format($totalMess, 0, '.', ',') . "</td>
        <td>" . number_format($totalSekolahBasket, 0, '.', ',') . "</td>
        <td>" . number_format($totalLesMandarin, 0, '.', ',') . "</td>
        <td>" . number_format($totalUmum, 0, '.', ',') . "</td>
        <td>" . number_format($totalDaycare + $totalTk + $totalSd + $totalSmp + $totalSma + $totalSmk1 + $totalSmk2 + $totalStifera + $totalMess + $totalSekolahBasket + $totalLesMandarin + $totalUmum, 0, '.', ',') . "</td>
    </tr>";
        echo "</table>";
    } else {
        echo "0 results";
    }
    $konektor->close();
} else {
    echo "Mohon masukkan tanggal awal dan tanggal akhir.";
}
?>
<!-- coding awal ditaruh di function.php -->
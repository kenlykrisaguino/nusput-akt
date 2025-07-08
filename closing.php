<?php
    $konektor = mysqli_connect("localhost", "root", "", "1_nusaputera");

    $tanggal_awal = $_GET['tanggal_awal'];
    $tanggal_akhir = $_GET['tanggal_akhir'];

    $tanggal_formatted = date("Ym", strtotime($tanggal_akhir));

    // Ubah format tanggal menjadi hari dan bulan saja
    $hari_bulan_awal = date('d-m', strtotime($tanggal_awal));
    $hari_bulan_akhir = date('d-m', strtotime($tanggal_akhir));

    $waktu_unix = strtotime($tanggal_awal);

    // Ambil awal bulan dari bulan sebelumnya
    $tanggal_awal_2 = date('Y-m-01', strtotime('first day of last month', $waktu_unix));
    $tanggal_akhir_2 = date('Y-m-t', strtotime('last day of last month', $waktu_unix));

// Fungsi untuk mengeksekusi perhitungan dan unggah ke database
function hitungDanUnggahKeDatabase($konektor, $tanggal_awal, $tanggal_akhir, $tanggal_formatted, $tanggal_awal_2, $tanggal_akhir_2, $hari_bulan_awal, $hari_bulan_akhir) {
    $sql1 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_kas 
            WHERE akun.kode_akun = transaksi_kas.kode_akun
            AND transaksi_kas.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_kas.status = 1
        ) +
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_bank 
            WHERE akun.kode_akun = transaksi_bank.kode_akun
            AND transaksi_bank.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_bank.status = 1
        ) +
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_memorial.status = 1
        ) AS debitpendapatan,

        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_kas 
            WHERE akun.kode_akun = transaksi_kas.kode_akun
            AND transaksi_kas.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_kas.status = 1
        ) +
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_bank 
            WHERE akun.kode_akun = transaksi_bank.kode_akun
            AND transaksi_bank.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_bank.status = 1
        ) +
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_memorial.status = 1
        ) AS kreditpendapatan
    
    FROM akun
    WHERE klasifikasi IN ('16. PENDAPATAN DI LUAR USAHA', '17. PENERIMAAN RUTIN', '18. PENERIMAAN TDK RUTIN')";
    
    // Mengambil total pendapatan dari hasil query
    $result1 = mysqli_query($konektor, $sql1);
    $total_pendapatan = 0;
    while ($row = mysqli_fetch_assoc($result1)) {
    $saldo_pendapatan =  $row['kreditpendapatan'] - $row['debitpendapatan'];
    $total_pendapatan += $saldo_pendapatan;
    }
    
    // Query untuk menghitung total biaya
    $sql2 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_kas 
            WHERE akun.kode_akun = transaksi_kas.kode_akun
            AND transaksi_kas.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_kas.status = 1
        ) +
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_bank 
            WHERE akun.kode_akun = transaksi_bank.kode_akun
            AND transaksi_bank.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_bank.status = 1
        ) +
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_memorial.status = 1
        ) AS debitbiaya,

        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_kas 
            WHERE akun.kode_akun = transaksi_kas.kode_akun
            AND transaksi_kas.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_kas.status = 1
        ) +
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_bank 
            WHERE akun.kode_akun = transaksi_bank.kode_akun
            AND transaksi_bank.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_bank.status = 1
        ) +
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal_2' AND '$tanggal_akhir_2'
            AND transaksi_memorial.status = 1
        ) AS kreditbiaya
    
    FROM akun
    WHERE klasifikasi IN ('12. BIAYA DI LUAR USAHA', '13. BIAYA UMUM & ADM', '15. OPERASIONAL RUTIN')";

    
    // Mengambil total biaya dari hasil query
    $result2 = mysqli_query($konektor, $sql2);
    $total_biaya = 0;
    while ($row = mysqli_fetch_assoc($result2)) {
    $saldo_biaya = $row['debitbiaya'] - $row['kreditbiaya'];
    $total_biaya += $saldo_biaya;
    }

    $laba_bulan = $total_pendapatan - $total_biaya;

    // Query untuk mendapatkan nominal terakhir dari labarugi_bulan
    $sql_last_nominal = "SELECT nominal FROM laba_rugi ORDER BY periode DESC LIMIT 1";
    $result_last_nominal = mysqli_query($konektor, $sql_last_nominal);
    
    // Penanganan kesalahan saat menjalankan query
    if (!$result_last_nominal) {
        die("Error in SQL query: " . mysqli_error($konektor));
    }
    
    // Pengecekan apakah hasil query tidak kosong
    if ($result_last_nominal->num_rows > 0) {
        $last_nominal_row = mysqli_fetch_assoc($result_last_nominal);
        $last_nominal = $last_nominal_row['nominal'];
    
        // Hitung nilai baru dengan menambahkan laba bulanan ke nominal terakhir
        $new_nominal = $last_nominal + $laba_bulan;
    
        if ($hari_bulan_awal == '01-07' && $hari_bulan_akhir == '31-07') {
            $query_upload = "INSERT INTO laba_rugi (nominal, periode) VALUES ('0', '$tanggal_formatted')";
        } else {
            $query_upload = "INSERT INTO laba_rugi (nominal, periode) VALUES ('$new_nominal', '$tanggal_formatted')";
        }
    
        $result_upload = mysqli_query($konektor, $query_upload);
    
        // Penanganan kesalahan saat menyimpan ke database
        if ($result_upload) {
            echo "Hasil berhasil diunggah ke database.";
        } else {
            echo "Gagal mengunggah hasil ke database: " . mysqli_error($konektor);
        }
    } else {
        echo "Tidak ada data yang ditemukan dalam tabel labarugi_bulan.";
    }
    
}

// Panggil fungsi untuk mengeksekusi perhitungan dan unggah ke database
hitungDanUnggahKeDatabase($konektor, $tanggal_awal, $tanggal_akhir, $tanggal_formatted, $tanggal_awal_2, $tanggal_akhir_2, $hari_bulan_awal, $hari_bulan_akhir);

?>



<?php
include "connect.php"; // Gunakan koneksi dari connect.php

// Ambil data tempat dan lantai dari request
$tempat = isset($_GET['tempat']) ? $_GET['tempat'] : '';
$lantai = isset($_GET['lantai']) ? $_GET['lantai'] : '';

if ($tempat && $lantai) {
    // Konversi lantai angka ke huruf (1 -> A, 2 -> B, 3 -> C, dst.)
    $lantai_huruf = chr(64 + intval($lantai)); // 1 -> A, 2 -> B, 3 -> C

    // Query untuk mendapatkan kode lokasi terakhir dengan angka terbesar
    $query = "SELECT kode_lokasi FROM lokasi 
    WHERE tempat='$tempat' AND lantai='$lantai' 
    ORDER BY LENGTH(kode_lokasi) DESC, 
             kode_lokasi DESC 
    LIMIT 1";


    $result = mysqli_query($konektor, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        // Ambil angka terakhir dari kode_lokasi
        preg_match('/(\d+)$/', $data['kode_lokasi'], $matches);
        $lastNumber = isset($matches[1]) ? intval($matches[1]) : 0;
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1; // Jika belum ada data, mulai dari 1
    }

    $kode_lokasi = strtoupper($tempat) . "-" . $lantai_huruf . $newNumber;
    echo $kode_lokasi;
}
?>

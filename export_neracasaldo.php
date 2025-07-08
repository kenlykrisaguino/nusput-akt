<?php
include "connect.php";

if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {

    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $tanggal_awal_edit = strtoupper(date('F Y', strtotime($_POST['tanggal_awal'])));
    $tanggal_akhir_edit = strtoupper(date('F Y', strtotime($_POST['tanggal_akhir'])));
    

    // Buat nama file Excel dengan format sesuai tanggal dan nomor kasbon
    $filename = "Neraca Saldo Bulan " . $tanggal_awal_edit . ".xls";

    // Set header untuk menghasilkan file Excel
    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");

    echo "<h3>NERACA SALDO SEKOLAH NUSAPUTERA<br>PERIODE: $tanggal_awal_edit </h3>";

    // SQL query to fetch data based on the date range
    $sql = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
        -- (
        --     SELECT COALESCE(SUM(debit), 0) 
        --     FROM transaksi_kas 
        --     WHERE akun.kode_akun = transaksi_kas.kode_akun
        --     AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        --     AND transaksi_kas.status = 1
        -- ) +
        -- (
        --     SELECT COALESCE(SUM(debit), 0) 
        --     FROM transaksi_bank 
        --     WHERE akun.kode_akun = transaksi_bank.kode_akun
        --     AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        --     AND transaksi_bank.status = 1
        -- ) +

         (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi 
            WHERE akun.kode_akun = transaksi.kode_akun
            AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            AND transaksi.status = 1
        ) +
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            AND transaksi_memorial.status = 1
        ) AS total_debit,

        -- (
        --     SELECT COALESCE(SUM(kredit), 0) 
        --     FROM transaksi_kas 
        --     WHERE akun.kode_akun = transaksi_kas.kode_akun
        --     AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        --     AND transaksi_kas.status = 1
        -- ) +
        -- (
        --     SELECT COALESCE(SUM(kredit), 0) 
        --     FROM transaksi_bank 
        --     WHERE akun.kode_akun = transaksi_bank.kode_akun
        --     AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        --     AND transaksi_bank.status = 1
        -- ) +

        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi 
            WHERE akun.kode_akun = transaksi.kode_akun
            AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            AND transaksi.status = 1
        ) +
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            AND transaksi_memorial.status = 1
        ) AS total_kredit,

        -- (
        --     SELECT COALESCE(SUM(IF(tanggal >= DATE_FORMAT(DATE_SUB('$tanggal_awal', INTERVAL 1 MONTH), '%Y-%m-01') 
        --     AND tanggal < '$tanggal_awal' AND status = 1, debit - kredit, 0)), 0) 
        --     FROM transaksi_kas 
        --     WHERE akun.kode_akun = transaksi_kas.kode_akun
        -- ) +
        -- (
        --     SELECT COALESCE(SUM(IF(tanggal >= DATE_FORMAT(DATE_SUB('$tanggal_awal', INTERVAL 1 MONTH), '%Y-%m-01') 
        --     AND tanggal < '$tanggal_awal' AND status = 1, debit - kredit, 0)), 0) 
        --     FROM transaksi_bank 
        --     WHERE akun.kode_akun = transaksi_bank.kode_akun
        -- ) +

         (
            SELECT COALESCE(SUM(IF(tanggal >= DATE_FORMAT(DATE_SUB('$tanggal_awal', INTERVAL 1 MONTH), '%Y-%m-01') 
            AND tanggal < '$tanggal_awal' AND status = 1, debit, 0)), 0) 
            FROM transaksi 
            WHERE akun.kode_akun = transaksi.kode_akun
        ) +
        (
            SELECT COALESCE(SUM(IF(tanggal >= DATE_FORMAT(DATE_SUB('$tanggal_awal', INTERVAL 1 MONTH), '%Y-%m-01') 
            AND tanggal < '$tanggal_awal' AND status = 1, debit, 0)), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
        ) AS saldo_awal_debit,


        -- (
        --     SELECT COALESCE(SUM(IF(tanggal >= DATE_FORMAT(DATE_SUB('$tanggal_awal', INTERVAL 1 MONTH), '%Y-%m-01') 
        --     AND tanggal < '$tanggal_awal' AND status = 1, kredit - debit, 0)), 0) 
        --     FROM transaksi_kas 
        --     WHERE akun.kode_akun = transaksi_kas.kode_akun
        -- ) +
        -- (
        --     SELECT COALESCE(SUM(IF(tanggal >= DATE_FORMAT(DATE_SUB('$tanggal_awal', INTERVAL 1 MONTH), '%Y-%m-01') 
        --     AND tanggal < '$tanggal_awal' AND status = 1, kredit - debit, 0)), 0) 
        --     FROM transaksi_bank 
        --     WHERE akun.kode_akun = transaksi_bank.kode_akun
        -- ) +

        (
            SELECT COALESCE(SUM(IF(tanggal >= DATE_FORMAT(DATE_SUB('$tanggal_awal', INTERVAL 1 MONTH), '%Y-%m-01') 
            AND tanggal < '$tanggal_awal' AND status = 1, kredit, 0)), 0) 
            FROM transaksi 
            WHERE akun.kode_akun = transaksi.kode_akun
        ) +
        (
            SELECT COALESCE(SUM(IF(tanggal >= DATE_FORMAT(DATE_SUB('$tanggal_awal', INTERVAL 1 MONTH), '%Y-%m-01') 
            AND tanggal < '$tanggal_awal' AND status = 1, kredit, 0)), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
        ) AS saldo_awal_kredit
            FROM akun";

    $result = $konektor->query($sql);
    if ($result === false) {
        die("Error in SQL query: " . $konektor->error);
    }
    if ($result->num_rows > 0) {
        // Create table structure outside the loop
        echo "<table border='1'>
                <tr>
                    <th>Kode Akun</th>
                    <th>Nama Akun</th>
                    <th>Saldo Awal</th>
                    <th>Total Debit</th>
                    <th>Total Kredit</th>
                    <th>Saldo Akhir</th>
                </tr>";

                while ($row = $result->fetch_assoc()) {
                    // Hitung saldo awal berdasarkan saldo normal
                    $saldo_awal = ($row['saldo_normal'] == 'Debit') ? $row['saldo_awal_debit'] : $row['saldo_awal_kredit'];
                    $total_debit = $row['total_debit'] ?? 0;
                    $total_kredit = $row['total_kredit'] ?? 0;
                    $saldo_normal = $row['saldo_normal'];
                
                    if ($saldo_normal == 'Debit') {
                        $saldo_akhir = $saldo_awal + $total_debit - $total_kredit;
                    } else if ($saldo_normal == 'Kredit') {
                        $saldo_akhir = $saldo_awal + $total_kredit + $total_debit;
                    }
                    if ($total_debit != 0 || $total_kredit != 0) {
                        echo "<tr>
                                <td>{$row['kode_akun']}</td>
                                <td>{$row['nama_akun']}</td>
                                <td>" . number_format($saldo_awal, 2) . "</td>
                                <td>" . number_format($total_debit, 2) . "</td>
                                <td>" . number_format($total_kredit, 2) . "</td>
                                <td>" . number_format($saldo_akhir, 2) . "</td>
                              </tr>";
                    }
                }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $konektor->close();
} else {
    echo "Mohon masukkan tanggal awal dan tanggal akhir.";
}
?>

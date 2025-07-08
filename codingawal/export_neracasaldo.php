<?php
if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {
    $konektor = mysqli_connect("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");

    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $tanggal_awal_edit = date('F Y', strtotime($_POST['tanggal_awal']));
    $tanggal_akhir_edit = date('F Y', strtotime($_POST['tanggal_akhir']));

    // Buat nama file Excel dengan format sesuai tanggal dan nomor kasbon
    $filename = "Neraca_Saldo_Bulan_" . $tanggal_awal_edit . ".xls";

    // Set header untuk menghasilkan file Excel
    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");

    echo "<h3>NERACA SALDO SEKOLAH NUSAPUTERA<br>Periode: $tanggal_awal_edit </h3>";

    // SQL query to fetch data based on the date range
    $sql = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
            (
                SELECT COALESCE(SUM(debit), 0) 
                FROM transaksi_kas 
                WHERE akun.kode_akun = transaksi_kas.kode_akun
                AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            ) +
            (
                SELECT COALESCE(SUM(debit), 0) 
                FROM transaksi_bank 
                WHERE akun.kode_akun = transaksi_bank.kode_akun
                AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            ) +
            (
                SELECT COALESCE(SUM(debit), 0) 
                FROM transaksi_memorial 
                WHERE akun.kode_akun = transaksi_memorial.kode_akun
                AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            ) AS total_debit,
            
            (
                SELECT COALESCE(SUM(kredit), 0) 
                FROM transaksi_kas 
                WHERE akun.kode_akun = transaksi_kas.kode_akun
                AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            ) +
            (
                SELECT COALESCE(SUM(kredit), 0) 
                FROM transaksi_bank 
                WHERE akun.kode_akun = transaksi_bank.kode_akun
                AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            ) +
            (
                SELECT COALESCE(SUM(kredit), 0) 
                FROM transaksi_memorial 
                WHERE akun.kode_akun = transaksi_memorial.kode_akun
                AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            ) AS total_kredit

            

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
            // Hitung saldo akhir berdasarkan saldo normal
            $saldo_awal = 10000000;
            $total_debit = $row['total_debit'];
            $total_kredit = $row['total_kredit'];
            $saldo_normal = $row['saldo_normal'];

            if ($saldo_normal == 'Debit') {
                $saldo_akhir1 = $saldo_awal + $total_debit - $total_kredit;
            } else if ($saldo_normal == 'Kredit') {
                $saldo_akhir1 = $saldo_awal - $total_debit + $total_kredit;
            }

            // Output data for each row
            echo "<tr>
                    <td>" . $row['kode_akun'] . "</td>
                    <td>" . $row['nama_akun'] . "</td>
                    <td>" . number_format($saldo_awal, 0, '.', ',') . "</td>
                    <td>" . number_format($total_debit, 0, '.', ',') . "</td>
                    <td>" . number_format($total_kredit, 0, '.', ',') . "</td>
                    <td>" . number_format($saldo_akhir1, 0, '.', ',') . "</td>

                </tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }

    // Tutup koneksi database
    $konektor->close();
} else {
    // Jika tanggal_awal, tanggal_akhir, atau nomor_kasbon tidak diisi, kembali ke halaman sebelumnya atau berikan pesan kesalahan.
    echo "Mohon masukkan tanggal awal dan tanggal akhir.";
}
?>

<!-- coding awal ditaruh di function.php -->

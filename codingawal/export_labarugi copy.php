<?php
if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {
    // Koneksi ke database
    $konektor = mysqli_connect("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");

    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $filename = "Laporan_Laba_Rugi_" . $tanggal_awal . "_sd_" . $tanggal_akhir . ".xls";

    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");

    echo "<h3>LAPORAN LABA RUGI SEKOLAH NUSAPUTERA <br>PERIODE $tanggal_awal - $tanggal_akhir</h3>";

    // Gabungkan hasil dari tiga tabel menggunakan LEFT JOIN dan WHERE untuk periode
    $sql = "SELECT a.kode_akun, a.nama_akun,
            SUM(CASE WHEN t.jenjang = 'DAYCARE' THEN t.nominal ELSE 0 END) AS daycare,
            SUM(CASE WHEN t.jenjang = 'TK' THEN t.nominal ELSE 0 END) AS tk,
            SUM(CASE WHEN t.jenjang = 'SD' THEN t.nominal ELSE 0 END) AS sd,
            SUM(CASE WHEN t.jenjang = 'SMP' THEN t.nominal ELSE 0 END) AS smp,
            SUM(CASE WHEN t.jenjang = 'SMA' THEN t.nominal ELSE 0 END) AS sma,
            SUM(CASE WHEN t.jenjang = 'SMK1-TKJ, MM' THEN t.nominal ELSE 0 END) AS smk1,
            SUM(CASE WHEN t.jenjang = 'SMK2-F, FA, H' THEN t.nominal ELSE 0 END) AS smk2,
            SUM(CASE WHEN t.jenjang = 'STIFERA' THEN t.nominal ELSE 0 END) AS stifera,
            SUM(CASE WHEN t.jenjang = 'SEKOLAH BASKET' THEN t.nominal ELSE 0 END) AS sekolah_basket,
            SUM(CASE WHEN t.jenjang = 'LES MANDARIN' THEN t.nominal ELSE 0 END) AS les_mandarin,
            SUM(CASE WHEN t.jenjang = 'UMUM' THEN t.nominal ELSE 0 END) AS umum,
            SUM(t.nominal) AS total
            FROM akun a
            LEFT JOIN transaksi_bank t ON a.kode_akun = t.kode_akun
            OR a.kode_akun = t.kode_akun
            OR a.kode_akun = t.kode_akun
            WHERE a.klasifikasi IN ('17. PENERIMAAN RUTIN', '18. PENERIMAAN TDK RUTIN', '15. OPERASIONAL RUTIN', '13. BIAYA UMUM & ADM', '16. PENDAPATAN DI LUAR USAHA', '12. BIAYA DI LUAR USAHA')
            AND t.status >= '$tanggal_awal' AND t.status <= '$tanggal_akhir'
            GROUP BY a.kode_akun";

    $result = $konektor->query($sql);

    if ($result) {
        $laporan = array();

        while ($row = $result->fetch_assoc()) {
            $laporan[] = $row;
        }

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
            <th>SEKOLAH BASKET</th>
            <th>LES MANDARIN</th>
            <th>UMUM</th>
            <th>TOTAL</th>
        </tr>";

        // Loop melalui array $laporan dan cetak baris tabel untuk setiap hasil
        foreach ($laporan as $row) {
            echo "<tr>
            <td>" . $row['kode_akun'] . "</td>
            <td>" . $row['nama_akun'] . "</td>
            <td>" . $row['daycare'] . "</td>
            <td>" . $row['tk'] . "</td>
            <td>" . $row['sd'] . "</td>
            <td>" . $row['smp'] . "</td>
            <td>" . $row['sma'] . "</td>
            <td>" . $row['smk1'] . "</td>
            <td>" . $row['smk2'] . "</td>
            <td>" . $row['stifera'] . "</td>
            <td>" . $row['sekolah_basket'] . "</td>
            <td>" . $row['les_mandarin'] . "</td>
            <td>" . $row['umum'] . "</td>
            <td>" . $row['total'] . "</td>
          </tr>";
        }

        echo "</table>";
    } else {
        echo "Error: " . $konektor->error;
    }

    // Tutup koneksi database
    $konektor->close();
} else {
    // Jika tanggal_awal atau tanggal_akhir tidak diisi, kembali ke halaman sebelumnya atau berikan pesan kesalahan.
    echo "Mohon masukkan tanggal awal dan tanggal akhir.";
}
?>

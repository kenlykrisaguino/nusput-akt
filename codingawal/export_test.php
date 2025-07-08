<?php
if (isset($_POST['status']) && isset($_POST['status'])) {
    // Koneksi ke database
    $konektor = mysqli_connect("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");

    $status = $_POST['status'];
    $status = $_POST['status'];

    $filename = "Neraca_Saldo_" . $status . "_sd_" . $status . ".xls";

    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");

    echo "<h3>NERACA SALDO SEKOLAH NUSAPUTERA <br>PERIODE $status - $status</h3>";

    // Gabungkan hasil dari tiga tabel menggunakan UNION
    $sql = "SELECT kode_akun, nama_akun, status FROM akun WHERE status >= '$status'";

    $result = $konektor->query($sql);

    if ($result) {
        $laporan = array();

        while ($row = $result->fetch_assoc()) {
            $laporan[] = $row;
            $sql1 = "SELECT kode_akun, nama_akun, debit, kredit FROM transaksi_kas WHERE kode_akun='".$row['kode_akun']."'";
        }

        echo "<table border='1'>
        <tr>
            <th>KODE AKUN</th>
            <th>NAMA AKUN</th>
            <th>SALDO AWAL</th>
            <th>DEBIT</th>
            <th>KREDIT</th>
            <th>SALDO</th>

        </tr>";

        // Loop melalui array $laporan dan cetak baris tabel untuk setiap hasil
        foreach ($laporan as $row) {
            echo "<tr>
            <td>" . $row['kode_akun'] . "</td>
            <td>" . $row['nama_akun'] . "</td>
            <td>" . $row['status'] . "</td>
            <td>" . $row['debit'] . "</td>
            <td>" . $row['kredit'] . "</td>
            <td>" . $row['status'] . "</td>

          </tr>";
        }

        echo "</table>";
    } else {
        echo "Error: " . $konektor->error;
    }

    // Tutup koneksi database
    $konektor->close();
} else {
    // Jika status, status, atau kode_akun tidak diisi, kembali ke halaman sebelumnya atau berikan pesan kesalahan.
    echo "Mohon masukkan tanggal awal, tanggal akhir, dan kode akun.";
}
?>

<?php
include "connect.php";

if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {

    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $kode_akun = $_POST['kode_akun'];

    $tanggal_awal_edit = date('F Y', strtotime($_POST['tanggal_awal']));
    $tanggal_akhir_edit = date('F Y', strtotime($_POST['tanggal_akhir']));

    $tanggal_awal_edit2 = date('d-m-Y', strtotime($_POST['tanggal_awal']));
    $tanggal_akhir_edit2 = date('d-m-Y', strtotime($_POST['tanggal_akhir']));

    $filename = "Buku Besar Akun " . $kode_akun . " Periode " . $tanggal_awal_edit . ".xls";

    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");

    echo "<h3>Laporan Buku Besar Akun $kode_akun Sekolah Nusaputera Bulan $tanggal_awal_edit <br>Periode $tanggal_awal_edit2 - $tanggal_akhir_edit2 </h3>";


    // Gabungkan hasil dari tiga tabel menggunakan UNION
    $sql = "SELECT tanggal, no_transaksi, kode_akun, nama_akun, nama_jenjang, tahun_ajaran, keterangan, debit, kredit FROM transaksi WHERE status = 1 AND tanggal >= '$tanggal_awal' AND tanggal <= '$tanggal_akhir' AND kode_akun = '$kode_akun' AND status
            UNION
            -- SELECT tanggal, no_transaksi, kode_akun, nama_akun, nama_jenjang, tahun_ajaran, keterangan, debit, kredit FROM transaksi_ban0k WHERE tanggal >= '$tanggal_awal' AND tanggal <= '$tanggal_akhir' AND kode_akun = '$kode_akun'
            -- UNION
            SELECT tanggal, no_transaksi, kode_akun, nama_akun, nama_jenjang, tahun_ajaran, keterangan, debit, kredit FROM transaksi_memorial WHERE status = 1 AND tanggal >= '$tanggal_awal' AND tanggal <= '$tanggal_akhir' AND kode_akun = '$kode_akun'";

    $result = $konektor->query($sql);

    if ($result) {
        $laporan = array();
        $totalDebit = 0;
        $totalKredit = 0;

        while ($row = $result->fetch_assoc()) {
            $laporan[] = $row;
            $totalDebit += $row['debit'];
            $totalKredit += $row['kredit'];
        }

        echo "<table border='1'>
        <tr>
            <th>Tanggal</th>
            <th>No. Transaksi</th>
            <th>Kode Akun</th>
            <th>Nama Akun</th>
            <th>Nama Jenjang</th>
            <th>Tahun Ajaran</th>
            <th>Keterangan</th>
            <th>Debit</th>
            <th>Kredit</th>
        </tr>";

        // Loop melalui array $laporan dan cetak baris tabel untuk setiap hasil
        foreach ($laporan as $row) {
            // Convert the date to dd/mm/yyyy format
            $formattedDate = date('d-m-Y', strtotime($row['tanggal']));
        
            echo "<tr>
            <td>" . $formattedDate . "</td>
            <td>" . $row['no_transaksi'] . "</td>
            <td>" . $row['kode_akun'] . "</td>
            <td>" . $row['nama_akun'] . "</td>
            <td>" . $row['nama_jenjang'] . "</td>
            <td>" . $row['tahun_ajaran'] . "</td>
            <td>" . $row['keterangan'] . "</td>
            <td>" . $row['debit'] . "</td>
            <td>" . $row['kredit'] . "</td>    
          </tr>";
        }

        // Display the total row with bold and center alignment
        echo "<tr style='font-weight: bold; text-align: center;'>
            <td colspan='7'>Total</td>
            <td>" . $totalDebit . "</td>
            <td>" . $totalKredit . "</td>
        </tr>";

        echo "</table>";
    } else {
        echo "Error: " . $konektor->error;
    }

    // Tutup koneksi database
    $konektor->close();
} else {
    // Jika tanggal_awal, tanggal_akhir, atau kode_akun tidak diisi, kembali ke halaman sebelumnya atau berikan pesan kesalahan.
    echo "Mohon masukkan tanggal awal, tanggal akhir, dan kode akun.";
}
?>

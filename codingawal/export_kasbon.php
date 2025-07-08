<?php
if(isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])){
    // Koneksi ke database
    $konektor = mysqli_connect("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");

    // Validasi dan ambil tanggal awal dan akhir dari input pengguna
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    // Buat nama file Excel dengan format sesuai tanggal
    $filename = "Laporan_Tunggakan_Kasbon_" . $tanggal_awal . "_sd_" . $tanggal_akhir . ".xls";

    // Set header untuk menghasilkan file Excel
    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");

    echo"<h3>Laporan Tunggakan Kasbon <br>Periode $tanggal_awal - $tanggal_akhir</h3>";


    // Mulai pembuatan tabel Excel
    echo "<table border='1'>
            <tr>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Keterangan</th>
                <th>Akun</th>
                <th>Debit</th>
                <th>Kredit</th>			
                <th>No. Kasbon</th>
            </tr>";

    // Query untuk mengambil data sesuai tanggal
    $sql = "SELECT * FROM transaksi_bank WHERE tanggal >= '$tanggal_awal' AND tanggal <= '$tanggal_akhir'";
    $result = $konektor->query($sql);

    // Loop untuk mengisi data ke dalam tabel Excel
    while ($data = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$data['tanggal']."</td>
                <td>".$data['no_transaksi']."</td>
                <td>".$data['keterangan']."</td>
                <td>".$data['kode_akun']."</td>
                <td>".number_format($data['debit'],0,'.',',')."</td>
                <td>".number_format($data['kredit'],0,'.',',')."</td>
                <td>".$data['no_kasbon']."</td>
              </tr>";
    }
    // Selesai membuat tabel Excel
    echo "</table>";

    // Tutup koneksi database
    $konektor->close();
} else {
    // Jika tanggal_awal dan tanggal_akhir tidak diisi, kembali ke halaman sebelumnya atau berikan pesan kesalahan.
    echo "Mohon masukkan tanggal awal dan akhir.";
}
?>

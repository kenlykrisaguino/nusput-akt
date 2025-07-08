<?php
if(isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])){
    // Koneksi ke database
    $konektor = mysqli_connect("localhost", "root", "", "1_nusaputera");

    // Validasi dan ambil tanggal awal dan akhir dari input pengguna
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $tanggal_awal_edit = strtoupper(date('F Y', strtotime($_POST['tanggal_awal'])));
    $tanggal_akhir_edit = strtoupper(date('F Y', strtotime($_POST['tanggal_akhir'])));
    

    $tanggalbulantahun1 = date('d-m-Y', strtotime($_POST['tanggal_awal']));
    $tanggalbulantahun2 = date('d-m-Y', strtotime($_POST['tanggal_akhir']));

    // Buat nama file Excel dengan format sesuai tanggal
    $filename = "Laporan Tunggakan Kasbon Bulan " . $bulan .  ".xls";

    // Set header untuk menghasilkan file Excel
    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");

    echo"<h3>LAPORAN TUNGGAKAN KASBON SEKOLAH NUSAPUTERA <br>BULAN $tanggal_akhir_edit <br>PERIODE $tanggalbulantahun1 - $tanggalbulantahun2</h3>";


    // Mulai pembuatan tabel Excel
    echo "<table border='1'>
            <tr>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Keterangan</th>
                <th>Akun</th>
                <th>Debit</th>
                <th>Kredit</th>			
                <th>No. Kasbon</th>
                <th>Jenjang</th>

            </tr>";

    // Query untuk mengambil data sesuai tanggal
    $query = "SELECT jenis_transaksi, tanggal, no_transaksi, keterangan, kode_akun, debit, kredit, no_kasbon, nama_jenjang
    FROM (
        SELECT jenis_transaksi, tanggal, no_transaksi, keterangan, kode_akun, debit, kredit, no_kasbon, nama_jenjang,
            ROW_NUMBER() OVER (PARTITION BY no_kasbon ORDER BY tanggal) AS row_num
        FROM transaksi_bank
        WHERE 
            tanggal >= '$tanggal_awal' AND tanggal <= '$tanggal_akhir' 
            AND no_kasbon IS NOT NULL 
            AND status = 1 
            AND jenis_transaksi = 'Pengeluaran'
            AND kode_akun = 141 -- Filter hanya untuk akun 141
            AND nama_jenjang IS NOT NULL -- Pastikan hanya baris dengan nama_jenjang yang tidak kosong diambil
        ) AS ranked
        WHERE 
        row_num = 1
        AND no_kasbon NOT IN (
            SELECT no_kasbon FROM transaksi_bank WHERE no_kasbon IS NOT NULL
            AND kode_akun = 141 -- Tambahkan filter akun 141 di sini juga
            GROUP BY no_kasbon
            HAVING 
                SUM(CASE WHEN jenis_transaksi = 'Pengeluaran' THEN debit ELSE 0 END) = 
                SUM(CASE WHEN jenis_transaksi = 'Penerimaan' THEN kredit ELSE 0 END)
        )
    ORDER BY tanggal"; // Pastikan data diurutkan berdasarkan tanggal
    
    // Eksekusi query
    $result = $konektor->query($query);

// Check for query execution success
if ($result === false) {
die('Error in query: ' . $konektor->error);
}

// Loop untuk mengisi data ke dalam tabel Excel
while ($data = $result->fetch_assoc()) {
$formattedDate = date('d-m-Y', strtotime($data['tanggal']));

echo "<tr>
        <td>".$data['jenis_transaksi']."</td>
        <td>" . $formattedDate . "</td>
        <td>".$data['no_transaksi']."</td>
        <td>".$data['keterangan']."</td>
        <td>".$data['kode_akun']."</td>
        <td>".$data['kredit']. "</td>
        <td>".$data['debit']."</td>  
        <td>".$data['no_kasbon']."</td>
        <td>".$data['nama_jenjang']."</td>
      </tr>";
}
    echo "</table>";

    $konektor->close();
} else {
    echo "Mohon masukkan tanggal awal dan akhir.";
}
?>




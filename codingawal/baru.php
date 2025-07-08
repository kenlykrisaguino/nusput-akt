<?php
include "connect.php"; // Sesuaikan dengan file koneksi Anda

// Mendapatkan tanggal awal dan tanggal akhir dari form atau parameter lainnya
if (isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
    $tanggal_awal = $_GET['tanggal_awal'];
    $tanggal_akhir = $_GET['tanggal_akhir'];

    // Query untuk mengambil data transaksi kasbon pada rentang tanggal yang dipilih
    $query = "SELECT DISTINCT tb.no_kasbon, tb.tanggal,
                     (SELECT SUM(debit) FROM transaksi_bank WHERE no_kasbon = tb.no_kasbon AND jenis_transaksi = 'pengeluaran') AS total_debit,
                     (SELECT SUM(kredit) FROM transaksi_bank WHERE no_kasbon = tb.no_kasbon AND jenis_transaksi = 'penerimaan') AS total_kredit
              FROM transaksi_bank tb
              WHERE tb.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
              ORDER BY tb.tanggal";

    $result = $konektor->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            // Tampilkan data transaksi kasbon yang belum dikembalikan pada rentang tanggal
            echo "<h2>Transaksi Kasbon pada Rentang Tanggal $tanggal_awal hingga $tanggal_akhir</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>No Kasbon</th>
                        <th>Tanggal</th>
                        <th>Status Pengembalian</th>
                        <!-- tambahkan kolom lain sesuai kebutuhan -->
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                $status_pengembalian = ($row['total_debit'] == $row['total_kredit']) ? 'Sudah Dikembalikan' : 'Belum Dikembalikan';

                echo "<tr>
                        <td>{$row['no_kasbon']}</td>
                        <td>{$row['tanggal']}</td>
                        <td>{$status_pengembalian}</td>
                        <!-- tambahkan data lain sesuai kebutuhan -->
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "Tidak ada transaksi kasbon pada rentang tanggal $tanggal_awal hingga $tanggal_akhir.";
        }
    } else {
        echo "Error: " . $konektor->error;
    }

    // Menutup koneksi
    $konektor->close();
} else {
    echo "Tanggal tidak valid.";
}
?>

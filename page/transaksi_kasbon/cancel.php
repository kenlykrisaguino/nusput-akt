<?php
include "connect.php";

if (isset($_GET['no_transaksi'])) {
    $no_transaksi = $_GET['no_transaksi'];

    // Update status menjadi 0
    $cancel_query = "UPDATE transaksi_bank SET status = 0 WHERE no_transaksi = '$no_transaksi'";
    
    if ($konektor->query($cancel_query) === TRUE) {
        echo "Status transaksi berhasil diupdate menjadi 0.";

        // Menambahkan script JavaScript
        echo '<script type="text/javascript">';
        echo 'alert("Transaksi berhasil dibatalkan.");';
        echo 'window.location.href="?page=transaksi_kasbon&aksi=data";';
        echo '</script>';
    } else {
        echo "Error updating status: " . mysqli_error($konektor);
    }
} else {
    echo "Nomor transaksi tidak valid.";
}

// Menutup koneksi
mysqli_close($konektor);
?>

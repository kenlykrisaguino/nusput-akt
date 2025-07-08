<?php
if (isset($_GET['kegiatan']) && isset($_GET['kode_jenjang'])) {
    include 'connect.php';

    $kode_jenjang = $_GET['kode_jenjang'];
    $kegiatan = $_GET['kegiatan'];

    // Gunakan prepared statement untuk mencegah SQL Injection
    $stmt = $konektor->prepare("DELETE FROM master_kegiatan WHERE kode_jenjang = ? AND kegiatan = ?");
    $stmt->bind_param("ss", $kode_jenjang, $kegiatan);

    if ($stmt->execute()) {
        echo '<script>
                alert("Data Berhasil Dihapus");
                window.location.href="?page=kegiatan";
              </script>';
    } else {
        echo '<script>
                alert("Gagal menghapus data!");
                window.location.href="?page=kegiatan";
              </script>';
    }

    $stmt->close();
    $konektor->close();
}
?>

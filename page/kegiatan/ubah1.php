<?php
include 'connect.php';

if (isset($_POST['kode_jenjang'])) {
    $kode_jenjang = $_POST['kode_jenjang'];

    // Ambil data master kegiatan berdasarkan kode jenjang
    $query = "SELECT * FROM master_kegiatan WHERE kode_jenjang = ?";
    $stmt = $konektor->prepare($query);
    $stmt->bind_param("s", $kode_jenjang);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data_kegiatan = [];
    while ($row = $result->fetch_assoc()) {
        $data_kegiatan[] = $row;
    }
    $stmt->close();
}

?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    <?php if (!empty($data_kegiatan)): ?>
        <?php foreach ($data_kegiatan as $index => $kegiatan): ?>
            tambahDivisi();
            document.getElementsByName("divisi[]")[<?= $index ?>].value = "<?= $kegiatan['divisi'] ?>";

            tambahKodeAkun(<?= $index ?>);
            document.getElementById("kode_akun<?= $index ?>_0").value = "<?= $kegiatan['kode_akun'] ?>";
            document.getElementById("nama_akun<?= $index ?>_0").value = "<?= $kegiatan['nama_akun'] ?>";

            tambahKegiatan(<?= $index ?>, 0);
            document.getElementsByName("kegiatan[<?= $index ?>][0][]")[0].value = "<?= $kegiatan['kegiatan'] ?>";
        <?php endforeach; ?>
    <?php endif; ?>
});
</script>

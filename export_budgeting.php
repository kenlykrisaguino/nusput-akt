<?php
include 'connect.php';

if (isset($_POST['tahun_ajaran']) && isset($_POST['nama_jenjang'])) {

    $nama_jenjang = $_POST['nama_jenjang'];
    $tahun_ajaran = $_POST['tahun_ajaran'];

    $filename = "BUDGETING " . $nama_jenjang . " TAHUN AJARAN " . $tahun_ajaran . ".xls";

    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");

    echo "<h3>LAPORAN RAPBS SEKOLAH NUSAPUTERA JENJANG $nama_jenjang  <br>TAHUN AJARAN $tahun_ajaran </h3>";

    // Query data dari database
    $query = "SELECT nama_jenjang, divisi, kode_akun, nama_akun, kegiatan, nominal, rincian, sumber_dana 
              FROM budgeting 
              WHERE tahun_ajaran = '$tahun_ajaran' AND nama_jenjang = '$nama_jenjang'
              ORDER BY divisi, kode_akun";

    $result = mysqli_query($konektor, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr style='background-color: #f2f2f2; text-align: center; vertical-align: top;'>
                <th>Divisi</th>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Kegiatan</th>
                <th>Sumber Dana</th>
                <th>Rincian</th>
                <th>Nominal</th>
                <th>Total Nominal</th>
                <th>Total Realisasi</th>
                <th>Presentase Penggunaan</th>


              </tr>";


        $prevDivisi = "";
        $prevKodeAkun = "";
        $rowspanDivisi = [];
        $rowspanKodeAkun = [];

        $dataRows = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $dataRows[] = $row;

            // Hitung rowspan untuk Divisi
            if (!isset($rowspanDivisi[$row['divisi']])) {
                $rowspanDivisi[$row['divisi']] = 1;
            } else {
                $rowspanDivisi[$row['divisi']]++;
            }

            // Hitung rowspan untuk Kode Akun
            if (!isset($rowspanKodeAkun[$row['kode_akun']])) {
                $rowspanKodeAkun[$row['kode_akun']] = 1;
            } else {
                $rowspanKodeAkun[$row['kode_akun']]++;
            }
        }

        $printedDivisi = [];
        $printedKodeAkun = [];

        foreach ($dataRows as $row) {
            echo "<tr style='vertical-align: top;'>";

            // Tampilkan Nama Jenjang hanya sekali

            // Tampilkan Divisi dengan rowspan
            if (!isset($printedDivisi[$row['divisi']])) {
                echo "<td rowspan='{$rowspanDivisi[$row['divisi']]}'>{$row['divisi']}</td>";
                $printedDivisi[$row['divisi']] = true;
            }

            // Tampilkan Kode Akun & Nama Akun dengan rowspan
            if (!isset($printedKodeAkun[$row['kode_akun']])) {
                echo "<td rowspan='{$rowspanKodeAkun[$row['kode_akun']]}'>{$row['kode_akun']}</td>";
                echo "<td rowspan='{$rowspanKodeAkun[$row['kode_akun']]}'>{$row['nama_akun']}</td>";
                $printedKodeAkun[$row['kode_akun']] = true;
            }

            echo "<td>{$row['kegiatan']}</td>";
            echo "<td>{$row['rincian']}</td>";            
            echo "<td>{$row['nominal']}</td>";
            echo "<td>{$row['nominal']}</td>";
            echo "<td>{$row['nominal']}</td>";
            echo "<td>{$row['sumber_dana']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Tidak ada data budgeting yang ditemukan untuk tahun ajaran $tahun_ajaran dan jenjang $nama_jenjang.</p>";
    }
}
?>

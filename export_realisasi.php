<?php
// Koneksi ke database
include 'connect.php';

$tahun_ajaran = isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '';
$nama_jenjang = isset($_GET['nama_jenjang']) ? $_GET['nama_jenjang'] : '';

$filename = "REALISASI RAPBS JENJANG " . $nama_jenjang . " TAHUN AJARAN " . $tahun_ajaran . ".xls";

// Set header untuk menghasilkan file Excel
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=$filename");

echo "<h3>LAPORAN REALISASI RAPBS SEKOLAH NUSAPUTERA JENJANG $nama_jenjang  <br>TAHUN AJARAN $tahun_ajaran </h3>";

// Query Data Budgeting
$query = "SELECT divisi, kode_akun, nama_akun, kegiatan, nominal, rincian, sumber_dana 
          FROM budgeting 
          WHERE tahun_ajaran = '$tahun_ajaran' AND nama_jenjang = '$nama_jenjang'
          ORDER BY divisi, kode_akun";

$result = mysqli_query($konektor, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr style='background-color: #f2f2f2; text-align: center;'>
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

    // Simpan data yang diambil
    $dataRows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRows[] = $row;
    }

    // Menghitung jumlah baris per kode akun
    $rowspanKodeAkun = [];
    foreach ($dataRows as $row) {
        $rowspanKodeAkun[$row['kode_akun']] = ($rowspanKodeAkun[$row['kode_akun']] ?? 0) + 1;
    }

    // Query Total Nominal
    $query1 = "SELECT kode_akun, SUM(nominal) AS total_nominal 
               FROM budgeting 
               WHERE tahun_ajaran = ? AND nama_jenjang = ? 
               GROUP BY kode_akun";
    $stmt1 = $konektor->prepare($query1);
    $stmt1->bind_param("ss", $tahun_ajaran, $nama_jenjang);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    // Menyimpan data total nominal
    $budget_data = [];
    while ($data = $result1->fetch_assoc()) {
        $budget_data[$data['kode_akun']] = [
            'total_nominal' => $data['total_nominal']
        ];
    }

    // Query Total Realisasi
    $query2 = "SELECT 
                budgeting.kode_akun, 
                budgeting.nama_akun, 
                akun.saldo_normal, 
                SUM(
                    (SELECT COALESCE(SUM(debit), 0) FROM transaksi_kas WHERE status = 1 AND budgeting.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tahun_ajaran = ? AND transaksi_kas.nama_jenjang = ?)
                ) +
                SUM(
                    (SELECT COALESCE(SUM(debit), 0) FROM transaksi_bank WHERE status = 1 AND budgeting.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tahun_ajaran = ? AND transaksi_bank.nama_jenjang = ?)
                ) +
                SUM(
                    (SELECT COALESCE(SUM(debit), 0) FROM transaksi_memorial WHERE status = 1 AND budgeting.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tahun_ajaran = ? AND transaksi_memorial.nama_jenjang = ?)
                ) AS total_debit,

                SUM(
                    (SELECT COALESCE(SUM(kredit), 0) FROM transaksi_kas WHERE status = 1 AND budgeting.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tahun_ajaran = ? AND transaksi_kas.nama_jenjang = ?)
                ) +
                SUM(
                    (SELECT COALESCE(SUM(kredit), 0) FROM transaksi_bank WHERE status = 1 AND budgeting.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tahun_ajaran = ? AND transaksi_bank.nama_jenjang = ?)
                ) +
                SUM(
                    (SELECT COALESCE(SUM(kredit), 0) FROM transaksi_memorial WHERE status = 1 AND budgeting.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tahun_ajaran = ? AND transaksi_memorial.nama_jenjang = ?)
                ) AS total_kredit

            FROM budgeting
            LEFT JOIN akun ON budgeting.kode_akun = akun.kode_akun
            WHERE budgeting.tahun_ajaran = ? AND budgeting.nama_jenjang = ?
            GROUP BY budgeting.kode_akun, budgeting.nama_akun, akun.saldo_normal";

    $stmt = $konektor->prepare($query2);
    $stmt->bind_param(
        "ssssssssssssss", 
        $tahun_ajaran, $nama_jenjang,
        $tahun_ajaran, $nama_jenjang,
        $tahun_ajaran, $nama_jenjang,
        $tahun_ajaran, $nama_jenjang,
        $tahun_ajaran, $nama_jenjang,
        $tahun_ajaran, $nama_jenjang,
        $tahun_ajaran, $nama_jenjang
    );

    $stmt->execute();
    $result2 = $stmt->get_result();

    // Simpan nominal yang dipakai
    $nominal_terpakai = [];
    while ($data = $result2->fetch_assoc()) {
        $total_debit = $data['total_debit'];
        $total_kredit = $data['total_kredit'];
        $saldo_normal = $data['saldo_normal'];

        // Hitung nominal berdasarkan saldo normal
        if ($saldo_normal == 'Debit') {
            $nominal = $total_debit - $total_kredit;
        } else {
            $nominal = $total_kredit - $total_debit;
        }

        // Simpan nilai realisasi
        $nominal_terpakai[$data['kode_akun']] = $nominal;
    }

    // Menampilkan data dalam tabel
    foreach ($dataRows as $index => $row) {
        $kode_akun = $row['kode_akun'];
        $total_nominal = $budget_data[$kode_akun]['total_nominal'] ?? 0;
        $total_realisasi = $nominal_terpakai[$kode_akun] ?? 0;
        $presentase_penggunaan = ($total_nominal > 0) ? round(($total_realisasi / $total_nominal) * 100, 2) . "%" : "0%";

        echo "<tr style='vertical-align: bottom;'>";

        if ($index == 0 || $dataRows[$index - 1]['kode_akun'] !== $kode_akun) {
            echo "<td rowspan='{$rowspanKodeAkun[$kode_akun]}' style='vertical-align: top;'>{$row['divisi']}</td>";
            echo "<td rowspan='{$rowspanKodeAkun[$kode_akun]}' style='vertical-align: top;'>{$row['kode_akun']}</td>";
            echo "<td rowspan='{$rowspanKodeAkun[$kode_akun]}' style='vertical-align: top;'>{$row['nama_akun']}</td>";
        }

        echo "<td>{$row['kegiatan']}</td>";
        echo "<td>{$row['sumber_dana']}</td>";
        echo "<td>{$row['rincian']}</td>";
        echo "<td>{$row['nominal']}</td>";

        if ($index == 0 || $dataRows[$index - 1]['kode_akun'] !== $kode_akun) {
            echo "<td rowspan='{$rowspanKodeAkun[$kode_akun]}' style='vertical-align: bottom;'>{$total_nominal}</td>";
            echo "<td rowspan='{$rowspanKodeAkun[$kode_akun]}' style='vertical-align: bottom;'>{$total_realisasi}</td>";
            echo "<td rowspan='{$rowspanKodeAkun[$kode_akun]}' style='vertical-align: bottom;'>{$presentase_penggunaan}</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
}
?>

<?php

if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {
    $konektor = mysqli_connect("localhost", "tagy3641_aktsystem", "ku+P.uz?[p$3ldj6", "tagy3641_akt");

    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $tanggal_awal_edit = date('F Y', strtotime($_POST['tanggal_awal']));
    $tanggal_akhir_edit = date('F Y', strtotime($_POST['tanggal_akhir']));

    // Buat nama file Excel dengan format sesuai tanggal dan nomor kasbon
    $filename = "Laporan Arus Kas Bulan " . $tanggal_awal_edit . ".xls";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=$filename");
    header('Cache-Control: max-age=0');

    echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    echo '<head><meta charset="UTF-8"><style>td{border:0px solid #000;}</style></head><body>';

    echo "<h3><center>LAPORAN ARUS KAS SEKOLAH NUSAPUTERA<br>Periode: $tanggal_awal_edit </center></h3>";

    $sqlpenerimaanoperasional = "SELECT akun.kode_akun, akun.nama_akun, akun.arus_kas, akun.klasifikasi,

    (
        SELECT COALESCE(SUM(debit), 0)
        FROM transaksi_kas
        WHERE transaksi_kas.kode_akun = akun.kode_akun
            AND akun.jenis = 'Penerimaan'
            AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(debit), 0)
        FROM transaksi_bank
        WHERE transaksi_bank.kode_akun = akun.kode_akun
            AND akun.jenis = 'Penerimaan'
            AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(debit), 0)
        FROM transaksi_memorial
        WHERE transaksi_memorial.kode_akun = akun.kode_akun
            AND akun.jenis = 'Penerimaan'
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) AS total_debit_penerimaan,
    (
        SELECT COALESCE(SUM(kredit), 0)
        FROM transaksi_kas
        WHERE transaksi_kas.kode_akun = akun.kode_akun
            AND akun.jenis = 'Penerimaan'
            AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(kredit), 0)
        FROM transaksi_bank
        WHERE transaksi_bank.kode_akun = akun.kode_akun
            AND akun.jenis = 'Penerimaan'
            AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(kredit), 0)
        FROM transaksi_memorial
        WHERE transaksi_memorial.kode_akun = akun.kode_akun
            AND akun.jenis = 'Penerimaan'
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) AS total_kredit_penerimaan
    FROM akun
WHERE akun.arus_kas = 'Operasional' AND akun.jenis = 'Penerimaan'";

 // Tambahkan kondisi untuk hanya mengambil akun dengan klasifikasi '10. ASET LANCAR'

$resultpenerimaanoperasional = mysqli_query($konektor, $sqlpenerimaanoperasional);

if ($resultpenerimaanoperasional === false) {
    echo "Error in SQL query: " . mysqli_error($konektor);
} else {
    $totaloperasional = 0;
    echo '<table><tr>';
    echo '<td style="margin-right: 20px;">';
    echo '<table>';
    echo '<tr><td colspan="3" style="text-align: center;"><b>ARUS KAS OPERASIONAL</b></td></tr>';
    echo '<tr>
            <td style="text-align: center;"><b>KLASIFIKASI</b></td>
            <td style="text-align: center;"><b>AKUN</b></td>
            <td style="text-align: center;"><b>SALDO</b></td>
        </tr>';

    while ($row = mysqli_fetch_assoc($resultpenerimaanoperasional)) {
        $total_debit_penerimaan = $row['total_debit_penerimaan'];
        $total_kredit_penerimaan = $row['total_kredit_penerimaan'];
        $penerimaanoperasional = $total_kredit_penerimaan - $total_debit_penerimaan;

        echo '<tr>
                <td>' . $row['klasifikasi'] . '</td>
                <td>' . $row['nama_akun'] . '</td>
                <td>' . $penerimaanoperasional. '</td>
            </tr>';
    }
}

$sqlpengeluaranoperasional = "SELECT akun.kode_akun, akun.nama_akun, akun.arus_kas, akun.klasifikasi,
    (
        SELECT COALESCE(SUM(debit), 0)
        FROM transaksi_kas
        WHERE transaksi_kas.kode_akun = akun.kode_akun
            AND akun.jenis = 'Pengeluaran'
            AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(debit), 0)
        FROM transaksi_bank
        WHERE transaksi_bank.kode_akun = akun.kode_akun
            AND akun.jenis = 'Pengeluaran'
            AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(debit), 0)
        FROM transaksi_memorial
        WHERE transaksi_memorial.kode_akun = akun.kode_akun
            AND akun.jenis = 'Pengeluaran'
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) AS total_debit_pengeluaran,
    (
        SELECT COALESCE(SUM(kredit), 0)
        FROM transaksi_kas
        WHERE transaksi_kas.kode_akun = akun.kode_akun
            AND akun.jenis = 'Pengeluaran'
            AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(kredit), 0)
        FROM transaksi_bank
        WHERE transaksi_bank.kode_akun = akun.kode_akun
            AND akun.jenis = 'Pengeluaran'
            AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(kredit), 0)
        FROM transaksi_memorial
        WHERE transaksi_memorial.kode_akun = akun.kode_akun
            AND akun.jenis = 'Pengeluaran'
            AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ) AS total_kredit_pengeluaran
FROM akun
WHERE akun.arus_kas = 'Operasional'AND akun.jenis = 'Pengeluaran'";

$resultpengeluaranoperasional = mysqli_query($konektor, $sqlpengeluaranoperasional);

if ($resultpengeluaranoperasional === false) {
    echo "Error in SQL query: " . mysqli_error($konektor);
} else {
    $totaloperasional = 0;

    while ($row = mysqli_fetch_assoc($resultpengeluaranoperasional)) {
        $total_debit_pengeluaran = $row['total_debit_pengeluaran'];
        $total_kredit_pengeluaran = $row['total_kredit_pengeluaran'];

        $pengeluaranoperasional = $total_debit_pengeluaran - $total_kredit_pengeluaran;

        echo '<tr>
                <td>' . $row['klasifikasi'] . '</td>
                <td>' . $row['nama_akun'] . '</td>
                <td>' . $pengeluaranoperasional. '</td>
            </tr>';
    }
}
echo '</table>';

 

echo '<td>';
echo '<table>';
echo '<tr><td colspan="2"></td></tr>';
echo '<tr><td colspan="2"></td></tr>';
echo '<tr><td colspan="2"></tr>';
echo '</table>';
echo '</td>';


$sqlinvestasi = "SELECT akun.kode_akun, akun.nama_akun, akun.arus_kas, akun.klasifikasi,

(
    SELECT COALESCE(SUM(debit), 0)
    FROM transaksi_kas
    WHERE transaksi_kas.kode_akun = akun.kode_akun
    AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(debit), 0)
    FROM transaksi_bank
    WHERE transaksi_bank.kode_akun = akun.kode_akun
    AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(debit), 0)
    FROM transaksi_memorial
    WHERE transaksi_memorial.kode_akun = akun.kode_akun
    AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS total_debit_investasi,
(
    SELECT COALESCE(SUM(kredit), 0)
    FROM transaksi_kas
    WHERE transaksi_kas.kode_akun = akun.kode_akun
    AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(kredit), 0)
    FROM transaksi_bank
    WHERE transaksi_bank.kode_akun = akun.kode_akun
    AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(kredit), 0)
    FROM transaksi_memorial
    WHERE transaksi_memorial.kode_akun = akun.kode_akun
    AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS total_kredit_investasi
FROM akun
WHERE akun.arus_kas = 'Investasi'";

// Tambahkan kondisi untuk hanya mengambil akun dengan klasifikasi '10. ASET LANCAR'

$resultinvestasi = mysqli_query($konektor, $sqlinvestasi);

if ($resultinvestasi === false) {
echo "Error in SQL query: " . mysqli_error($konektor);
} else {
$totaloperasional = 0;
echo '<td style="margin-right: 20px;">';
echo '<table>';
echo '<tr><td colspan="3" style="text-align: center;"><b>ARUS KAS INVESTASI</b></td></tr>';
echo '<tr>
        <td style="text-align: center;"><b>KLASIFIKASI</b></td>
        <td style="text-align: center;"><b>AKUN</b></td>
        <td style="text-align: center;"><b>SALDO</b></td>
    </tr>';

while ($row = mysqli_fetch_assoc($resultinvestasi)) {
    $total_debit_investasi = $row['total_debit_investasi'];
    $total_kredit_investasi = $row['total_kredit_investasi'];
    $investasi = $total_kredit_investasi - $total_debit_investasi;

    echo '<tr>
            <td>' . $row['klasifikasi'] . '</td>
            <td>' . $row['nama_akun'] . '</td>
            <td>' . $investasi. '</td>
        </tr>';
}
}


echo '</table>';



echo '<td>';
echo '<table>';
echo '<tr><td colspan="2"></td></tr>';
echo '<tr><td colspan="2"></td></tr>';
echo '<tr><td colspan="2"></tr>';
echo '</table>';
echo '</td>';

$sqlpendanaan = "SELECT akun.kode_akun, akun.nama_akun, akun.arus_kas, akun.klasifikasi,

(
    SELECT COALESCE(SUM(debit), 0)
    FROM transaksi_kas
    WHERE transaksi_kas.kode_akun = akun.kode_akun
    AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(debit), 0)
    FROM transaksi_bank
    WHERE transaksi_bank.kode_akun = akun.kode_akun
    AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(debit), 0)
    FROM transaksi_memorial
    WHERE transaksi_memorial.kode_akun = akun.kode_akun
    AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS total_debit_pendanaan,
(
    SELECT COALESCE(SUM(kredit), 0)
    FROM transaksi_kas
    WHERE transaksi_kas.kode_akun = akun.kode_akun
    AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(kredit), 0)
    FROM transaksi_bank
    WHERE transaksi_bank.kode_akun = akun.kode_akun
    AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(kredit), 0)
    FROM transaksi_memorial
    WHERE transaksi_memorial.kode_akun = akun.kode_akun
    AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS total_kredit_pendanaan
FROM akun
WHERE akun.arus_kas = 'Pendanaan'";

// Tambahkan kondisi untuk hanya mengambil akun dengan klasifikasi '10. ASET LANCAR'

$resultpendanaan = mysqli_query($konektor, $sqlpendanaan);

if ($resultpendanaan === false) {
echo "Error in SQL query: " . mysqli_error($konektor);
} else {
$totaloperasional = 0;
echo '<td style="margin-right: 20px;">';
echo '<table>';
echo '<tr><td colspan="3" style="text-align: center;"><b>ARUS KAS PENDANAAN</b></td></tr>';
echo '<tr>
        <td style="text-align: center;"><b>KLASIFIKASI</b></td>
        <td style="text-align: center;"><b>AKUN</b></td>
        <td style="text-align: center;"><b>SALDO</b></td>
    </tr>';

while ($row = mysqli_fetch_assoc($resultpendanaan)) {
    $total_debit_pendanaan = $row['total_debit_pendanaan'];
    $total_kredit_pendanaan = $row['total_kredit_pendanaan'];
    $pendanaan = $total_kredit_pendanaan - $total_debit_pendanaan;

    echo '<tr>
            <td>' . $row['klasifikasi'] . '</td>
            <td>' . $row['nama_akun'] . '</td>
            <td>' . $pendanaan. '</td>
        </tr>';
}
}
echo '</table>';

}
?>
<?php
include 'connect.php';

if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {

    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $tanggal_awal_edit = date('F Y', strtotime($_POST['tanggal_awal']));
    $tanggal_akhir_edit = date('F Y', strtotime($_POST['tanggal_akhir']));

    $bulan_tanggal_akhir = date('m-d', strtotime($tanggal_akhir));


    // Mengambil tahun dari tanggal akhir
    $tahun_akhir = date('Y', strtotime($tanggal_akhir));
    $tahun_akhir2 = date('Y', strtotime($tanggal_akhir));



    // Buat nama file Excel dengan format sesuai tanggal dan nomor kasbon
    $filename = "Laporan Posisi Keuangan Bulan " . $tanggal_awal_edit . ".xls";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=$filename");
    header('Cache-Control: max-age=0');

    echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    echo '<head><meta charset="UTF-8"><style>td{border:0px solid #000;}</style></head><body>';

    echo "<h3><center>LAPORAN POSISI KEUANGAN SEKOLAH NUSAPUTERA<br>Periode: $tanggal_awal_edit </center></h3>";

    // Query for Aset Lancar
    $sqlAsetLancar = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
    (
        SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi 
        WHERE status = 1 
        AND akun.kode_akun = transaksi.kode_akun
        AND transaksi.tanggal <= '$tanggal_akhir'

    ) +
    (
        SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial 
        WHERE status = 1 
        AND akun.kode_akun = transaksi_memorial.kode_akun
        AND transaksi_memorial.tanggal <= '$tanggal_akhir'
        
    ) AS total_debit_asetlancar,

    (
        SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi 
        WHERE status = 1 
        AND akun.kode_akun = transaksi.kode_akun
        AND transaksi.tanggal <= '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial 
        WHERE status = 1 
        AND akun.kode_akun = transaksi_memorial.kode_akun
        AND transaksi_memorial.tanggal <= '$tanggal_akhir'
    ) AS total_kredit_asetlancar

FROM akun
WHERE akun.klasifikasi IN ('10. ASET LANCAR', '19. PERSEDIAAN')"; // Tambahkan kondisi untuk hanya mengambil akun dengan klasifikasi '10. ASET LANCAR'

    $resultAsetLancar = mysqli_query($konektor, $sqlAsetLancar);
    $totalasetlancar = 0;

    // Isi data ke dalam tabel untuk Aset Lancar
    echo '<table><tr>';
    echo '<td style="margin-right: 20px;">';
    echo '<table>';
    echo '<tr><td colspan="2" style="text-align: center;"><b>ASET LANCAR</b></td></tr>';
    // echo '<tr>
    //     <td style="text-align: center;"><b>Nama Akun</b></td>
    //     <td style="text-align: center;"><b>Saldo</b></td>
    // </tr>';
    while ($row = mysqli_fetch_assoc($resultAsetLancar)) {
        $total_debit_asetlancar = $row['total_debit_asetlancar'];
        $total_kredit_asetlancar = $row['total_kredit_asetlancar'];

        $saldo_asetlancar = $total_debit_asetlancar - $total_kredit_asetlancar;
        if ($saldo_asetlancar != 0) {
            echo '<tr><td>' . $row['nama_akun'] . '</td><td>' . $saldo_asetlancar . '</td></tr>';
            $totalasetlancar += $saldo_asetlancar;
        }
    }
    echo '<tr>
            <td style="text-align: center;"><b>JUMLAH ASSET LANCAR</b></td>
            <td style="text-align: center;"><b>' . $totalasetlancar . '</b></td>
        </tr>';
    echo '<tr><td colspan="2"></td></tr>';
    echo '</table>';


    // Query for Aset Tetap
    $sqlAsetTetap = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi 
            WHERE status = 1 
            AND akun.kode_akun = transaksi.kode_akun
            AND transaksi.tanggal <= '$tanggal_akhir'
        ) +
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_memorial 
            WHERE status = 1 
            AND akun.kode_akun = transaksi_memorial.kode_akun
            AND transaksi_memorial.tanggal <= '$tanggal_akhir'
        ) AS total_debit_asettetap,

         (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi
            WHERE status = 1 
            AND akun.kode_akun = transaksi.kode_akun
            AND transaksi.tanggal <= '$tanggal_akhir'
        ) +
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_memorial 
            WHERE status = 1 
            AND akun.kode_akun = transaksi_memorial.kode_akun
            AND transaksi_memorial.tanggal <= '$tanggal_akhir'
        ) AS total_kredit_asettetap

    FROM akun
    WHERE akun.klasifikasi = '11. ASET TETAP'"; // Adjust this condition accordingly

    $resultAsetTetap = mysqli_query($konektor, $sqlAsetTetap);
    $totalasettetap = 0;

    // Isi data ke dalam tabel untuk Aset Tetap
    echo '<table>';
    echo '<tr><td colspan="2" style="text-align: center;"><b>ASET TETAP</b></td></tr>';
    // echo '<tr>
    //         <td style="text-align: center;"><b>Nama Akun</b></td>
    //         <td style="text-align: center;"><b>Saldo</b></td>
    //     </tr>';
    while ($row = mysqli_fetch_assoc($resultAsetTetap)) {
        $total_debit_asettetap = $row['total_debit_asettetap'];
        $total_kredit_asettetap = $row['total_kredit_asettetap'];

        $saldo_asettetap = $total_debit_asettetap - $total_kredit_asettetap;
        if ($saldo_asettetap != 0) {
            echo '<tr><td>' . $row['nama_akun'] . '</td><td>' . $saldo_asettetap . '</td></tr>';
            $totalasettetap += $saldo_asettetap;
        }
    }

    echo '<tr>
            <td style="text-align: center;"><b>JUMLAH ASET TETAP</b></td>
            <td style="text-align: center;"><b>' . $totalasettetap . '</b></td>
        </tr>

        <tr>
            <td></td>
        </tr>

        <tr>
            <td style="text-align: center;">        
                <b>JUMLAH ASET</b>
            </td>
            <td style="text-align: center;">
                <b>' . ((float)$totalasettetap + (float)$totalasetlancar) . '</b>
            </td>
        </tr>';
    echo '<tr><td colspan="2"></td></tr>';
    echo '</table>';
    echo '</td>';

    // Tabel di sebelah kanan
    echo '<td>';
    echo '<table>';
    echo '<tr><td colspan="2"></td></tr>';
    echo '<tr><td colspan="2"></td></tr>';
    echo '<tr><td colspan="2"></tr>';
    echo '</table>';
    echo '</td>';

    $sqlHutangJangkaPendek = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,

    (
        SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi 
        WHERE status = 1 
        AND akun.kode_akun = transaksi.kode_akun
        AND transaksi.tanggal <= '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial 
        WHERE status = 1 
        AND akun.kode_akun = transaksi_memorial.kode_akun
        AND transaksi_memorial.tanggal <= '$tanggal_akhir'
    ) AS total_debit_hutangjkpendek,

    (
        SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi 
        WHERE status = 1 
        AND akun.kode_akun = transaksi.kode_akun
        AND transaksi.tanggal <= '$tanggal_akhir'
    ) +
    (
        SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial 
        WHERE status = 1 
        AND akun.kode_akun = transaksi_memorial.kode_akun
        AND transaksi_memorial.tanggal <= '$tanggal_akhir'
    ) AS total_kredit_hutangjkpendek

FROM akun
WHERE akun.klasifikasi = '14. HUTANG JK PENDEK'"; // Adjust this condition accordingly

    $resultHutangJangkaPendek = mysqli_query($konektor, $sqlHutangJangkaPendek);
    $totalhutangjkpendek = 0;


    // Isi data ke dalam tabel untuk Hutang Jangka Pendek
    echo '<td style="margin-right: 20px;">';
    echo '<table>';
    echo '<tr><td colspan="2" style="text-align: center;"><b>HUTANG JANGKA PENDEK</b></td></tr>';
    // echo '<tr>
    //     <td style="text-align: center;"><b>Nama Akun</b></td>
    //     <td style="text-align: center;"><b>Saldo</b></td>
    // </tr>';
    while ($row = mysqli_fetch_assoc($resultHutangJangkaPendek)) {
        $total_debit_hutangjkpendek = $row['total_debit_hutangjkpendek'];
        $total_kredit_hutangjkpendek = $row['total_kredit_hutangjkpendek'];

        $saldo_hutangjkpendek = $total_kredit_hutangjkpendek - $total_debit_hutangjkpendek;
        if ($saldo_hutangjkpendek != 0) {

            echo '<tr><td>' . $row['nama_akun'] . '</td><td>' . $saldo_hutangjkpendek . '</td></tr>';
            $totalhutangjkpendek += $saldo_hutangjkpendek;
        }
    }
    echo '<tr>
    <td style="text-align: center;"><b>JUMLAH HUTANG JANGKA PENDEK</b></td>
    <td style="text-align: center;"><b>' . $totalhutangjkpendek . '</b></td>
</tr>';

    echo '<tr><td colspan="2"></td></tr>';
    echo '</table>';


    if (strtotime($tanggal_akhir) > strtotime("$tahun_akhir2-06-30")) {
        $tanggal_batas = "$tahun_akhir2-06-30";
    } else {
        $tanggal_batas = ($tahun_akhir2 - 1) . "-06-30";
    }


    // Query laba rugi ditahan
    $sql1 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
    AND transaksi_memorial.tanggal <= '$tanggal_batas'
) +
(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND transaksi.tanggal <= '$tanggal_batas'
) AS debitpendapatan,

(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
    AND transaksi_memorial.tanggal <= '$tanggal_batas'
) +
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND transaksi.tanggal <= '$tanggal_batas'
) AS kreditpendapatan

FROM akun
WHERE klasifikasi IN ('16. PENDAPATAN DI LUAR USAHA', '17. PENERIMAAN RUTIN', '18. PENERIMAAN TDK RUTIN')";

    // Mengambil total pendapatan dari hasil query
    $result1 = mysqli_query($konektor, $sql1);
    $total_pendapatan = 0;
    while ($row = mysqli_fetch_assoc($result1)) {
        $saldo_pendapatan =  $row['kreditpendapatan'] - $row['debitpendapatan'];
        $total_pendapatan += $saldo_pendapatan;
    }

    // Query untuk menghitung total biaya
    $sql2 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
    AND transaksi_memorial.tanggal <= '$tanggal_batas'
) +
(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND transaksi.tanggal <= '$tanggal_batas'
) AS debitbiaya,

(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
    AND transaksi_memorial.tanggal <= '$tanggal_batas'
) +

(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND transaksi.tanggal <= '$tanggal_batas'
) AS kreditbiaya

FROM akun
WHERE klasifikasi IN ('12. BIAYA DI LUAR USAHA', '13. BIAYA UMUM & ADM', '15. OPERASIONAL RUTIN')";

    // Mengambil total biaya dari hasil query
    $result2 = mysqli_query($konektor, $sql2);
    $total_biaya = 0;
    while ($row = mysqli_fetch_assoc($result2)) {
        $saldo_biaya = $row['debitbiaya'] - $row['kreditbiaya'];
        $total_biaya += $saldo_biaya;
    }

    $sql8 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
) +
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
) AS s_laba_ditahan
    FROM akun
    WHERE akun.kode_akun = '402'";

    $result8 = mysqli_query($konektor, $sql8);
    if (!$result8) {
        die("Query SQL8 gagal: " . mysqli_error($konektor));
    }

    $saldo_laba_ditahan = 0; // Default value jika tidak ada data
    if ($row = mysqli_fetch_assoc($result8)) {
        $saldo_laba_ditahan = $row['s_laba_ditahan'];
    }

    // Query untuk saldo laba tahun berjalan
    $sql9 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
    AND transaksi_memorial.tanggal <= '$tanggal_batas'
) +
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND transaksi.tanggal <= '$tanggal_batas'
) AS s_laba_tahun_berjalan
FROM akun
WHERE akun.kode_akun = '403'";

    $result9 = mysqli_query($konektor, $sql9);
    if (!$result9) {
        die("Query SQL9 gagal: " . mysqli_error($konektor));
    }

    $saldo_laba_tahun_berjalan = 0; // Default value jika tidak ada data
    if ($row = mysqli_fetch_assoc($result9)) {
        $saldo_laba_tahun_berjalan = $row['s_laba_tahun_berjalan'];
    }


    // Menghitung total akhir
    $laba_ditahan = $total_pendapatan - $total_biaya + $saldo_laba_ditahan + $saldo_laba_tahun_berjalan; // Adjust this condition accordingly


    //query laba ditahan tahunan
    if ($bulan_tanggal_akhir >= '07-01' && $bulan_tanggal_akhir <= '12-31') {
        // Jika $tanggal_akhir antara 1 Juli hingga 31 Desember, tahun_awal dan tahun_akhir sama
        $tahun_awal = $tahun_akhir;

        $sql3 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
      AND DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
      AND YEAR(transaksi_memorial.tanggal) = $tahun_awal
) +

(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
      AND DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
      AND YEAR(transaksi.tanggal) = $tahun_awal
) AS kreditpendapatantahun,

(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
      AND DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
      AND YEAR(transaksi_memorial.tanggal) = $tahun_awal
) +

(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
      AND DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
      AND YEAR(transaksi.tanggal) = $tahun_awal
) AS debitpendapatantahun

FROM akun
WHERE klasifikasi IN ('16. PENDAPATAN DI LUAR USAHA', '17. PENERIMAAN RUTIN', '18. PENERIMAAN TDK RUTIN')";

        $result3 = mysqli_query($konektor, $sql3);
        if (!$result3) {
            die("Query failed: " . mysqli_error($konektor));
        }

        $total_pendapatantahun = 0;
        while ($row = mysqli_fetch_assoc($result3)) {
            $saldo_pendapatantahun = $row['kreditpendapatantahun'] - $row['debitpendapatantahun'];
            $total_pendapatantahun += $saldo_pendapatantahun;
        }

        $sql4 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
      AND DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
      AND YEAR(transaksi_memorial.tanggal) = $tahun_awal
) +

(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
      AND DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
      AND YEAR(transaksi.tanggal) = $tahun_awal
) AS kreditbiayatahun,

(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
      AND DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
      AND YEAR(transaksi_memorial.tanggal) = $tahun_awal
) +

(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
      AND DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
      AND YEAR(transaksi.tanggal) = $tahun_awal
) AS debitbiayatahun

FROM akun
WHERE klasifikasi IN ('12. BIAYA DI LUAR USAHA', '13. BIAYA UMUM & ADM', '15. OPERASIONAL RUTIN')";


        $result4 = mysqli_query($konektor, $sql4);
        if (!$result4) {
            die("Query failed: " . mysqli_error($konektor));
        }
        $total_biayatahun = 0;
        while ($row = mysqli_fetch_assoc($result4)) {
            $saldo_biayatahun = $row['debitbiayatahun'] - $row['kreditbiayatahun'];
            $total_biayatahun += $saldo_biayatahun;
        }


        $sql7 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(
SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
      AND DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
      AND YEAR(transaksi_memorial.tanggal) = $tahun_awal
) +
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d')
    AND YEAR(transaksi.tanggal) = $tahun_awal
) AS saldo_laba_berjalan
FROM akun
WHERE akun.kode_akun = '403'";

        $result7 = mysqli_query($konektor, $sql7);
        if (!$result7) {
            die("Query SQL7 gagal: " . mysqli_error($konektor));
        }

        $saldo_laba_berjalan = 0; // Default value jika tidak ada data
        if ($row = mysqli_fetch_assoc($result7)) {
            $saldo_laba_berjalan = $row['saldo_laba_berjalan'];
        }


        // Menghitung total akhir
        if ($bulan_tanggal_akhir == '07-31') {
            $laba_tahun = 0;
        } else {
            $laba_tahun = $total_pendapatantahun - $total_biayatahun + $saldo_laba_berjalan; // Adjust this condition accordingly
        }
    } else {
        // Jika $tanggal_akhir antara 1 Januari hingga 30 Juni, tahun_awal adalah tahun sebelumnya
        $tahun_awal = $tahun_akhir - 1;

        // Query untuk rentang 1 Juli tahun_awal hingga tanggal akhir di tahun berikutnya
        $sql3 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,

    (
        SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial 
        WHERE status = 1 
        AND akun.kode_akun = transaksi_memorial.kode_akun
          AND (
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi_memorial.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi_memorial.tanggal) = $tahun_akhir)
              )
    ) +

    (
        SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi 
        WHERE status = 1 
        AND akun.kode_akun = transaksi.kode_akun
          AND (
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi.tanggal) = $tahun_akhir)
              )
    ) AS kreditpendapatantahun,
    
    (
        SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial 
        WHERE status = 1 
        AND akun.kode_akun = transaksi_memorial.kode_akun
          AND (
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi_memorial.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi_memorial.tanggal) = $tahun_akhir)
              )
    ) +

    (
        SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi 
        WHERE status = 1 
        AND akun.kode_akun = transaksi.kode_akun
          AND (
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi.tanggal) = $tahun_akhir)
              )
    ) AS debitpendapatantahun

FROM akun
WHERE klasifikasi IN ('16. PENDAPATAN DI LUAR USAHA', '17. PENERIMAAN RUTIN', '18. PENERIMAAN TDK RUTIN')";

        $result3 = mysqli_query($konektor, $sql3);
        if (!$result3) {
            die("Query failed: " . mysqli_error($konektor));
        }

        $total_pendapatantahun = 0;
        while ($row = mysqli_fetch_assoc($result3)) {
            $saldo_pendapatantahun = $row['kreditpendapatantahun'] - $row['debitpendapatantahun'];
            $total_pendapatantahun += $saldo_pendapatantahun;
        }

        $sql4 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
    
    (
        SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi_memorial 
        WHERE status = 1 
        AND akun.kode_akun = transaksi_memorial.kode_akun
          AND (
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi_memorial.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi_memorial.tanggal) = $tahun_akhir)
              )
    ) +

    (
        SELECT COALESCE(SUM(kredit), 0) 
        FROM transaksi 
        WHERE status = 1 
        AND akun.kode_akun = transaksi.kode_akun
          AND (
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi.tanggal) = $tahun_akhir)
              )
    ) AS kreditbiayatahun,
    
    (
        SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi_memorial 
        WHERE status = 1 
        AND akun.kode_akun = transaksi_memorial.kode_akun
          AND (
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi_memorial.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi_memorial.tanggal) = $tahun_akhir)
              )
    ) +

    (
        SELECT COALESCE(SUM(debit), 0) 
        FROM transaksi 
        WHERE status = 1 
        AND akun.kode_akun = transaksi.kode_akun
          AND (
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi.tanggal) = $tahun_akhir)
              )
    ) AS debitbiayatahun
FROM akun
WHERE klasifikasi IN ('12. BIAYA DI LUAR USAHA', '13. BIAYA UMUM & ADM', '15. OPERASIONAL RUTIN')";

        $result4 = mysqli_query($konektor, $sql4);
        if (!$result4) {
            die("Query failed: " . mysqli_error($konektor));
        }

        $total_biayatahun = 0;
        while ($row = mysqli_fetch_assoc($result4)) {
            $saldo_biayatahun = $row['debitbiayatahun'] - $row['kreditbiayatahun'];
            $total_biayatahun += $saldo_biayatahun;
        }
        $sql7 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,
(SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
          AND (
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi_memorial.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi_memorial.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi_memorial.tanggal) = $tahun_akhir)
              )
) +
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
          AND (
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '07-01' AND '12-31' AND YEAR(transaksi.tanggal) = $tahun_awal)
                OR
                (DATE_FORMAT(transaksi.tanggal, '%m-%d') BETWEEN '01-01' AND DATE_FORMAT(DATE_SUB('$tanggal_akhir', INTERVAL 1 MONTH), '%m-%d') AND YEAR(transaksi.tanggal) = $tahun_akhir)
              )
) AS saldo_laba_berjalan
FROM akun
WHERE akun.kode_akun = '403'";

        $result7 = mysqli_query($konektor, $sql7);
        if (!$result7) {
            die("Query SQL7 gagal: " . mysqli_error($konektor));
        }

        $saldo_laba_berjalan = 0; // Default value jika tidak ada data
        if ($row = mysqli_fetch_assoc($result7)) {
            $saldo_laba_berjalan = $row['saldo_laba_berjalan'];
        }


        // Menghitung total akhir
        if ($bulan_tanggal_akhir == '07-31') {
            $laba_tahun = 0;
        } else {
            $laba_tahun = $total_pendapatantahun - $total_biayatahun + $saldo_laba_berjalan; // Adjust this condition accordingly
        }
    }


    //query laba rugi bulanan 
    $sql5 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,

(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
    AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debitpendapatanbulan,

(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
    AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kreditpendapatanbulan

FROM akun
WHERE klasifikasi IN ('16. PENDAPATAN DI LUAR USAHA', '17. PENERIMAAN RUTIN', '18. PENERIMAAN TDK RUTIN')";

    // Mengambil total pendapatan dari hasil query
    $result5 = mysqli_query($konektor, $sql5);
    $total_pendapatanbulan = 0;
    while ($row = mysqli_fetch_assoc($result5)) {
        $saldo_pendapatanbulan =  $row['kreditpendapatanbulan'] - $row['debitpendapatanbulan'];
        $total_pendapatanbulan += $saldo_pendapatanbulan;
    }

    // Query untuk menghitung total biaya
    $sql6 = "SELECT akun.kode_akun, akun.nama_akun, akun.saldo_normal,

(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(debit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
    AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS debitbiayabulan,


(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi 
    WHERE status = 1 
    AND akun.kode_akun = transaksi.kode_akun
    AND transaksi.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) +
(
    SELECT COALESCE(SUM(kredit), 0) 
    FROM transaksi_memorial 
    WHERE status = 1 
    AND akun.kode_akun = transaksi_memorial.kode_akun
    AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
) AS kreditbiayabulan

FROM akun
WHERE klasifikasi IN ('12. BIAYA DI LUAR USAHA', '13. BIAYA UMUM & ADM', '15. OPERASIONAL RUTIN')";

    // Mengambil total biaya dari hasil query
    $result6 = mysqli_query($konektor, $sql6);
    $total_biayabulan = 0;
    while ($row = mysqli_fetch_assoc($result6)) {
        $saldo_biayabulan = $row['debitbiayabulan'] - $row['kreditbiayabulan'];
        $total_biayabulan += $saldo_biayabulan;
    }

    // Menghitung total akhir
    $laba_bulan = $total_pendapatanbulan - $total_biayabulan; // Adjust this condition accordingly

    //meghitung modal
    $sqlmodal = "SELECT akun.kode_akun, akun.nama_akun, 
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi 
            WHERE status = 1 
            AND akun.kode_akun = transaksi.kode_akun
        ) +
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_memorial 
            WHERE status = 1 
            AND akun.kode_akun = transaksi_memorial.kode_akun
        ) AS saldo_akhir
        FROM akun
        WHERE akun.nama_akun = 'Modal' AND akun.kode_akun = '401'";

    // Eksekusi query
    $result = $konektor->query($sqlmodal);

    // Ambil hasil query
    $row = $result->fetch_assoc();
    $modal = isset($row['saldo_akhir']) ? $row['saldo_akhir'] : 0;

    // Menampilkan tabel modal
    echo '<table>';
    echo '<tr><td colspan="2" style="text-align: center;"><b>EKUITAS</b></td></tr>';
    // echo '<tr>
    //     <td style="text-align: center;"><b>Nama Akun</b></td>
    //     <td style="text-align: center;"><b>Saldo</b></td>
    // </tr>';
    echo '<tr>
        <td>' . 'MODAL' . '</td><td>' . $modal . '</td>
        </tr>' .
        '<tr>
        <td>' . 'LABA RUGI DITAHAN' . '</td><td>' . $laba_ditahan . '</td>
        </tr>' .
        '<tr>
        <td>' . 'LABA RUGI TAHUN BERJALAN' . '</td><td>' . $laba_tahun . '</td>
        </tr>' .
        '<tr>
        <td>' . 'LABA RUGI BULAN BERJALAN' . '</td><td>' . $laba_bulan . '</td>
        </tr>';

    echo '<tr>
            <td style="text-align: center;"><b>JUMLAH EKUITAS</b></td>
            <td style="text-align: center;">' . ((float)$modal + (float)$laba_ditahan + (float)$laba_tahun + (float)$laba_bulan) . ' </td>
        </tr>
        <tr>
            <td></td>
        </tr>

        <tr>
            <td style="text-align: center;">        
                <b>JUMLAH LIABILITAS DAN EKUITAS</b>
            </td>
            <td style="text-align: center;">
                <b>' . ((float)$modal + (float)$laba_ditahan + (float)$laba_tahun + (float)$laba_bulan + (float)$totalhutangjkpendek)  . '</b>
            </td>
        </tr>';
    echo '<tr><td colspan="2"></td></tr>';
    echo '</table>';
    echo '</td>';
    echo '</tr></table>';
    echo '</body></html>';
}

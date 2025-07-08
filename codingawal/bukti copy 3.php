<?php
require('fpdf/fpdf.php');

if (isset($_POST['no_transaksi'])) {
    $konektor = mysqli_connect("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");

    $no_transaksi = $_POST['no_transaksi']; // Set your desired transaction number here

    $sql = $konektor->query("SELECT * FROM transaksi_kas WHERE no_transaksi = $no_transaksi");

    if ($sql) {
        $rows = $sql->fetch_all(MYSQLI_ASSOC);

        if (!empty($rows)) {
            // Assuming all rows have the same no_transaksi, you can use the first row to get common details
            $firstRow = $rows[0];
            $no_bukti = $firstRow['no_transaksi'];
            $tanggal = date('d/m/Y', strtotime($firstRow['tanggal']));
            $sumber_dana = $firstRow['sumber_dana'];
            $jumlah = $firstRow['debit'];
            $tahun_ajaran = $firstRow['tahun_ajaran'];

            // Create PDF
            $pdf = new FPDF();
            $pdf->AddPage();

            // Header
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Bukti Transaksi', 0, 1, 'C');

            // Table1
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(20, 10, 'No.Bukti:', 0);
            $pdf->Cell(20, 10, $no_bukti, 0);
            $pdf->Cell(20, 10, 'Tanggal:', 0);
            $pdf->Cell(20, 10, $tanggal, 0);
            $pdf->Cell(20, 10, 'Sumber Dana:', 0);
            $pdf->Cell(20, 10, $sumber_dana, 0);
            $pdf->Ln();

            // Table2
            $pdf->Cell(0, 10, 'DIBAYARKAN KEPADA:', 0, 1, 'L');
            $pdf->Cell(20, 10, 'Akun', 1);
            $pdf->Cell(20, 10, 'Keterangan', 1);
            $pdf->Cell(20, 10, 'Jumlah', 1);
            $pdf->Ln();

            foreach ($rows as $row) {
                if (empty($row['tahun_ajaran'])) {
                    $pdf->Cell(80, 10, $row['kode_akun'] . '.' . $row['nama_akun'] . ' / ' . $row['nama_jenjang'] . ' / ' . $firstRow['tahun_ajaran'], 1);
                    $pdf->Cell(80, 10, $row['keterangan'], 1);
                    $pdf->Cell(20, 10, 'Rp ' . number_format($row['kredit'], 0, '.', ','), 1);
                    $pdf->Ln();
                }
            }

            // Total
            $pdf->Cell(160, 10, 'Jumlah', 1);
            $pdf->Cell(20, 10, 'Rp ' . number_format($firstRow['debit'], 0, '.', ','), 1);
            $pdf->Ln();

            // Terbilang
            $pdf->Cell(0, 10, 'TERBILANG:', 0, 1, 'L');
            $pdf->Cell(0, 10, $debit_terbilang . ' RUPIAH', 0, 1, 'L');

            // Table3
            $pdf->Ln();
            $pdf->Cell(0, 10, 'Disetujui       Pembukuan       Kasir       Penerima', 0, 1, 'C');

            // Output PDF
            $pdf->Output('output.pdf', 'D');
        } else {
            echo "No data found for transaction number: $no_transaksi";
        }
    } else {
        echo "Error fetching data from the database.";
    }
}

function terbilang($angka) {
    $angka = abs($angka);
    $bilangan = array(
        '',
        'SATU',
        'DUA',
        'TIGA',
        'EMPAT',
        'LIMA',
        'ENAM',
        'TUJUH',
        'DELAPAN',
        'SEMBILAN',
        'SEPULUH',
        'SEBELAS'
    );
    $hasil = '';

    if ($angka < 12) {
        $hasil = $bilangan[$angka];
    } elseif ($angka < 20) {
        $hasil = terbilang($angka - 10) . ' BELAS';
    } elseif ($angka < 100) {
        $hasil = terbilang($angka / 10) . ' PULUH ' . terbilang($angka % 10);
    } elseif ($angka < 200) {
        $hasil = 'Seratus ' . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        $hasil = terbilang($angka / 100) . ' RATUS ' . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        $hasil = 'Seribu ' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        $hasil = terbilang($angka / 1000) . ' RIBU ' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        $hasil = terbilang($angka / 1000000) . ' JUTA ' . terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
        $hasil = terbilang($angka / 1000000000) . ' MILYAR ' . terbilang(fmod($angka, 1000000000));
    } else {
        $hasil = 'Angka terlalu besar';
    }

    return $hasil;
}
$debit_terbilang = terbilang($firstRow['debit']);

?>

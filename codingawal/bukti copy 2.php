<?php
require('fpdf/fpdf.php');

if (isset($_POST['no_transaksi']) && isset($_POST['jenis_transaksi'])) {
    $konektor = mysqli_connect("localhost", "root", "", "1_nusaputera");

    $no_transaksi = $_POST['no_transaksi'];
    $jenis_transaksi = $_POST['jenis_transaksi'];

    $sql = $konektor->query("SELECT * FROM transaksi_kas WHERE no_transaksi = $no_transaksi AND jenis_transaksi = '$jenis_transaksi'");

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
            
            
            // Create PDF
            $pdf = new FPDF();
            $pdf->AddPage();

            // Header
            $pdf->SetFont('Arial', 'B', 14); 
            if ($jenis_transaksi == 'Penerimaan') {
                $pdf->Cell(0, 10, 'Bukti Transaksi Penerimaan Kas', 0, 1, 'C');
            } elseif ($jenis_transaksi == 'Pengeluaran') {
                $pdf->Cell(0, 10, 'Bukti Transaksi Pengeluaran Kas', 0, 1, 'C');
            }

            // Table1
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(18, 10, 'No.Bukti:', 0);
            $pdf->Cell(20, 10, $no_bukti, 0);
            $pdf->Cell(17, 10, 'Tanggal:', 0);
            $pdf->Cell(30, 10, $tanggal, 0);
            $pdf->Cell(27, 10, 'Sumber Dana:', 0);
            $pdf->Cell(20, 10, $sumber_dana, 0);
            $pdf->Ln();

            // Table2
            $pdf->Cell(190, 10, 'DIBAYARKAN KEPADA:', 1, 1);

            $pdf->Cell(70, 10, 'Akun', 1, 0, 'C');
            $pdf->Cell(70, 10, 'Keterangan', 1, 0, 'C');
            $pdf->Cell(50, 10, 'Jumlah', 1, 1, 'C');
            $pdf->Ln();

            foreach ($rows as $row) {
                if (empty($row['tahun_ajaran'])) {
                    $pdf->MultiCell(70, 10, $row['kode_akun'] . '. ' . $row['nama_akun'] . ' / ' . $row['nama_jenjang'] . ' / ' . $firstRow['tahun_ajaran'], 1, 'L');
                    $pdf->SetXY(80, $pdf->GetY() - 20);
                    $pdf->MultiCell(70, 20, $row['keterangan'], 1);
                    $pdf->SetXY(150, $pdf->GetY() - 20);
            
                    // Check the jenis_transaksi for Penerimaan or Pengeluaran
                    if ($jenis_transaksi == 'Penerimaan') {
                        $pdf->MultiCell(50, 20, 'Rp ' . number_format($row['kredit'], 0, '.', ','), 1, 'C');
                        $pdf->SetXY(150, $pdf->GetY() - 20);                    
                    } elseif ($jenis_transaksi == 'Pengeluaran') {
                        $pdf->MultiCell(50, 20, 'Rp ' . number_format($row['debit'], 0, '.', ','), 1, 'C');
                        $pdf->SetXY(150, $pdf->GetY() - 20);                    
                    }
            
                    $pdf->Ln();
                }
            }
            

            // Total
            $pdf->Cell(160, 10, 'Jumlah', 1);
            if ($jenis_transaksi == 'Penerimaan') {
                $pdf->Cell(50, 10, 'Rp ' . number_format($firstRow['debit'], 0, '.', ','), 1, 0, 'C');
            } elseif ($jenis_transaksi == 'Pengeluaran') {
                $pdf->Cell(50, 10, 'Rp ' . number_format($firstRow['kredit'], 0, '.', ','), 1,0, 'C');
            }
            $pdf->Ln();


            // Terbilang
            $pdf->Cell(190, 10, 'TERBILANG:', 1, 1);
            $pdf->Cell(0, 10, $debit_terbilang . ' RUPIAH', 0, 1, 'L');

            // Table3
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Disetujui', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Pembukuan', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Kasir', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Penerima', 1, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(40, 20, '', 1, 0, 'C');
            $pdf->Cell(40, 20, '', 1, 0, 'C');
            $pdf->Cell(40, 20, '', 1, 0, 'C');
            $pdf->Cell(40, 20, '', 1, 0, 'C');
            $pdf->SetFont('Arial', '', 10);
            // Output PDF
            $pdf->Output('Bukti_Transaksi.pdf', 'D');
        } else {
            echo "No data found for transaction number: $no_transaksi and transaction type: $jenis_transaksi";
        }
    } else {
        echo "Error fetching data from the database. Details: " . $konektor->error;
    }
}


?>

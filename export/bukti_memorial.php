<?php
require('fpdf/fpdf.php');

if (isset($_POST['no_transaksi'])) {
    $konektor = mysqli_connect("localhost", "root", "", "1_nusaputera");

    $no_transaksi = $_POST['no_transaksi'];

    $sql = $konektor->query("SELECT * FROM transaksi_memorial WHERE no_transaksi = $no_transaksi");

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
            // function terbilang($angka) {
            //     $angka = abs($angka);
            //     $bilangan = array(
            //         '',
            //         'SATU',
            //         'DUA',
            //         'TIGA',
            //         'EMPAT',
            //         'LIMA',
            //         'ENAM',
            //         'TUJUH',
            //         'DELAPAN',
            //         'SEMBILAN',
            //         'SEPULUH',
            //         'SEBELAS'
            //     );
            //     $hasil = '';
            
            //     if ($angka < 12) {
            //         $hasil = $bilangan[$angka];
            //     } elseif ($angka < 20) {
            //         $hasil = terbilang($angka - 10) . ' BELAS';
            //     } elseif ($angka < 100) {
            //         $hasil = terbilang($angka / 10) . ' PULUH ' . terbilang($angka % 10);
            //     } elseif ($angka < 200) {
            //         $hasil = 'Seratus ' . terbilang($angka - 100);
            //     } elseif ($angka < 1000) {
            //         $hasil = terbilang($angka / 100) . ' RATUS ' . terbilang($angka % 100);
            //     } elseif ($angka < 2000) {
            //         $hasil = 'Seribu ' . terbilang($angka - 1000);
            //     } elseif ($angka < 1000000) {
            //         $hasil = terbilang($angka / 1000) . ' RIBU ' . terbilang($angka % 1000);
            //     } elseif ($angka < 1000000000) {
            //         $hasil = terbilang($angka / 1000000) . ' JUTA ' . terbilang($angka % 1000000);
            //     } elseif ($angka < 1000000000000) {
            //         $hasil = terbilang($angka / 1000000000) . ' MILYAR ' . terbilang(fmod($angka, 1000000000));
            //     } else {
            //         $hasil = 'Angka terlalu besar';
            //     }
            
            //     return $hasil;
            // }
            // $debit_terbilang = terbilang($firstRow['debit']);

            $pdf = new Fpdf();
            $pdf->AddPage();

            $pdf->SetFont('Arial', 'B', 14); 
            $pdf->Cell(0, 10, 'BUKTI TRANSAKSI MEMORIAL', 0, 1, 'C');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(18, 10, 'No.Bukti:', 0);
            $pdf->Cell(20, 10, $no_bukti, 0);
            $pdf->Cell(17, 10, 'Tanggal:', 0);
            $pdf->Cell(30, 10, $tanggal, 0);
            $pdf->Cell(27, 10, 'Sumber Dana:', 0);
            $pdf->Cell(20, 10, $sumber_dana, 0);
            $pdf->Ln();

            $pdf->Cell(80, 7, 'Akun', 1, 0, 'C');
            $pdf->Cell(70, 7, 'Keterangan', 1, 0, 'C');
            $pdf->Cell(20, 7, 'Debit', 1, 0, 'C');
            $pdf->Cell(20, 7, 'Kredit', 1, 0, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Ln();


            if (count($rows) > 0) {
            $currentY1 = 37;
            $currentY2 = 37;
            $currentY3 = 37;
            $totalDebit = 0;
            $totalKredit = 0;
            

            foreach ($rows as $row) {
                if (!empty($row['tahun_ajaran'])) {
                    $pdf->MultiCell(80, 7, $row['kode_akun'] . '. ' . $row['nama_akun'] . ' / ' . $row['nama_jenjang'] .  ' / ' . $firstRow['tahun_ajaran'], 1, 'L'); 
                    $pdf->SetY($currentY1);
                    $pdf->SetX(90);
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->MultiCell(70, 7, $row['keterangan'], 1, 'L');    
                    // $currentY1 += 14;
                    $pdf->SetY($currentY2);        
                    $pdf->SetX(160);               
                    $pdf->Cell(20, 14, number_format($row['debit'], 0, '.', ','), 1, 1, 'C');
                    $currentY2 += 14;
                    $pdf->SetY($currentY3);
                    $currentY1 += 14;
                    $pdf->SetX(180); 
                    $pdf->Cell(20, 14, number_format($row['kredit'], 0, '.', ','), 1, 1, 'C');
                    $currentY3 += 14;
                        $pdf->SetFont('Arial', '', 8);
                    $totalDebit += $row['debit'];
                    $totalKredit += $row['kredit'];
                }
            }
        }
            
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(150, 7, 'Total', 1, 0, 'C');
            $pdf->Cell(20, 7, number_format($totalDebit, 0, '.', ','), 1, 0, 'C');
            $pdf->Cell(20, 7, number_format($totalKredit, 0, '.', ','), 1, 0, 'C'); 
        
            
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Cell(35, 7, 'Disetujui', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Pembukuan', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Kasir', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Penerima', 1, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(35, 20, '', 1, 0, 'C');
            $pdf->Cell(35, 20, '', 1, 0, 'C');
            $pdf->Cell(35, 20, '', 1, 0, 'C');
            $pdf->Cell(35, 20, '', 1, 0, 'C');
            $pdf->SetFont('Arial', '', 10);

            $pdf->Output('bukti_memorial.pdf', 'D');
        } else {
            echo "Nomor transaksi $no_transaksi tidak ditemukan";
        }
    } else {
        echo "Error fetching data from the database.";
    }
}
?>
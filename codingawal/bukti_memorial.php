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

            $pdf->Cell(70, 7, 'Akun', 1, 0, 'C');
            $pdf->Cell(70, 7, 'Keterangan', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Debit', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Kredit', 1, 0, 'C');
            $pdf->Ln();


            if (count($rows) > 0) {
            // $currentY1 = 37;
            // $currentY2 = 37;
            // $currentY3 = 37;
            $totalDebit = 0;
            $totalKredit = 0;

            $y = $pdf->GetY();

            foreach ($rows as $row) {
                if (!empty($row['sumber_dana'])) {
                    $akun = strtoupper($row['kode_akun']) . '. ' . strtoupper($row['nama_akun']) . '  /  ' . strtoupper($row['nama_jenjang']) .  '  /  ' . strtoupper($firstRow['tahun_ajaran']);
                    $panjang = strlen($akun);
                    $tinggi = ($panjang <= 45) ? 14 : 7;
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->MultiCell(70, $tinggi, $akun, 1, 'L'); 

                    $pdf->SetXY(80, $y);
                    $pdf->SetFont('Arial', '', 9);
                    $keterangan = strtoupper($row['keterangan']);
                    $tinggi = (strlen($keterangan) <= 35) ? 14 : 7;
                    $pdf->MultiCell(70, $tinggi, $keterangan, 1, 'L');    

                    $pdf->SetXY(150, $y);
                    $pdf->Cell(25, 14, number_format($row['debit'], 0, '.', ','), 1, 1, 'C');

                    $pdf->SetXY(175, $y);
                    $pdf->Cell(25, 14, number_format($row['kredit'], 0, '.', ','), 1, 1, 'C');

                    $totalDebit += $row['debit'];
                        $totalKredit += $row['kredit'];



                    // if ($jenis_transaksi == 'Penerimaan') {
                    //     $pdf->SetFont('Arial', '', 10);
                    //     $pdf->Cell(35, 14, 'Rp. ' . number_format($row['kredit'], 0, '.', ','), 1, 1, 'C');
                    // } elseif ($jenis_transaksi == 'Pengeluaran') {
                    //     $pdf->SetFont('Arial', '', 10);
                    //     $pdf->Cell(35, 14, 'Rp. ' . number_format($row['debit'], 0, '.', ','), 1, 1, 'C');
                    // }

                    $y += max($tinggi, 14);
                }
            }
        }

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(140, 7, 'Total', 1, 0, 'C');
            $pdf->Cell(25, 7, number_format($totalDebit, 0, '.', ','), 1, 0, 'C');
            $pdf->Cell(25, 7, number_format($totalKredit, 0, '.', ','), 1, 0, 'C'); 
        
            
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
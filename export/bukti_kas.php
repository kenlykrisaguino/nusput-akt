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
            if ($jenis_transaksi == 'Penerimaan') {
                $pdf->Cell(0, 10, 'BUKTI PENERIMAAN KAS', 0, 1, 'C');
            } elseif ($jenis_transaksi == 'Pengeluaran') {
                $pdf->Cell(0, 10, 'BUKTI PENGELUARAN KAS', 0, 1, 'C');
            }

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(18, 10, 'No.Bukti:', 0);
            $pdf->Cell(20, 10, $no_bukti, 0);
            $pdf->Cell(17, 10, 'Tanggal:', 0);
            $pdf->Cell(30, 10, $tanggal, 0);
            $pdf->Cell(27, 10, 'Sumber Dana:', 0);
            $pdf->Cell(20, 10, $sumber_dana, 0);
            $pdf->Ln();

            $pdf->Cell(190, 7, 'DIBAYARKAN KEPADA:', 1, 1);

            $pdf->Cell(85, 7, 'Akun', 1, 0, 'C');
            $pdf->Cell(75, 7, 'Keterangan', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah', 1, 1, 'C');
            $pdf->SetFont('Arial', '', 8);

            $currentY1 = 44;
            $currentY2 = 44;

            foreach ($rows as $row) {
                if (empty($row['tahun_ajaran'])) {
                    $pdf->MultiCell(85, 7, $row['kode_akun'] . '. ' . $row['nama_akun'] . ' / ' . $row['nama_jenjang'] .  ' / ' . $firstRow['tahun_ajaran'], 1, 'L'); 
                    $pdf->SetY($currentY1);
                    $pdf->SetX(95);
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->MultiCell(75, 7, $row['keterangan'], 1, 'L');    
                    $currentY1 += 14;
                    $pdf->SetY($currentY2);        
                    $pdf->SetX(170);               
                    if ($jenis_transaksi == 'Penerimaan') {
                        $pdf->Cell(30, 14, 'Rp ' . number_format($row['kredit'], 0, '.', ','), 1, 1, 'C');
                        $pdf->SetFont('Arial', '', 8);
                    } elseif ($jenis_transaksi == 'Pengeluaran') {
                        $pdf->Cell(30, 14, 'Rp ' . number_format($row['debit'], 0, '.', ','), 1, 1, 'C');
                        $pdf->SetFont('Arial', '', 8);
                    }
                    $currentY2 += 14;
                }
            }

            
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(160, 7, 'Jumlah Total', 1, 0, 'C');
            if ($jenis_transaksi == 'Penerimaan') {
                $pdf->Cell(30, 7, 'Rp ' . number_format($firstRow['debit'], 0, '.', ','), 1, 0, 'C');
            } elseif ($jenis_transaksi == 'Pengeluaran') {
                $pdf->Cell(30, 7, 'Rp ' . number_format($firstRow['kredit'], 0, '.', ','), 1,0, 'C');
            }
            
            $pdf->Ln();
            $pdf->Cell(190, 7, 'TERBILANG:', 1, 1);
            // $pdf->MultiCell(0, 10, terbilang($firstRow['debit']) . ' RUPIAH', 0, 'L');

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

            $pdf->Output('bukti_kas.pdf', 'D');
        } else {
            echo "Nomor transaksi $no_transaksi tidak ditemukan";
        }
    } else {
        echo "Error fetching data from the database.";
    }
}


?>
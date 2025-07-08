<?php
require('fpdf/fpdf.php');

if (isset($_POST['no_transaksi']) && isset($_POST['jenis_transaksi'])) {
    $konektor = mysqli_connect("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");

    $no_transaksi = $_POST['no_transaksi'];
    $jenis_transaksi = $_POST['jenis_transaksi'];

    $sql = $konektor->query("SELECT * FROM transaksi_bank WHERE no_transaksi = $no_transaksi AND jenis_transaksi = '$jenis_transaksi'");

    if ($sql) {
        $rows = $sql->fetch_all(MYSQLI_ASSOC);

        if (!empty($rows)) {
            // Assuming all rows have the same no_transaksi, you can use the first row to get common details
            $firstRow = $rows[0];
            $no_bukti = $firstRow['no_transaksi'];
            $tanggal = date('d/m/Y', strtotime($firstRow['tanggal']));
            $sumber_dana = $firstRow['sumber_dana'];
            $jumlah = $firstRow['debit'];
            $nama_akun = $firstRow['nama_akun'];
            $no_kasbon = $firstRow['no_kasbon'];
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
                $pdf->Cell(0, 10, 'BUKTI PENERIMAAN BANK', 0, 1, 'C');
            } elseif ($jenis_transaksi == 'Pengeluaran') {
                $pdf->Cell(0, 10, 'BUKTI PENGELUARAN BANK', 0, 1, 'C');
            }

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(190, 10, $nama_akun, 0, 1, 'C');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(18, 10, 'No.Bukti:', 0);
            $pdf->Cell(20, 10, $no_bukti, 0);
            $pdf->Cell(17, 10, 'Tanggal:', 0);
            $pdf->Cell(30, 10, $tanggal, 0);
            $pdf->Cell(27, 10, 'Sumber Dana:', 0);
            $pdf->Cell(20, 10, $sumber_dana, 0);
            $pdf->Cell(23, 10, 'No. Kasbon:', 0);
            $pdf->Cell(20, 10, $no_kasbon, 0);
            $pdf->Ln();

            $pdf->Cell(190, 7, 'DIBAYARKAN KEPADA:', 1, 1);

            $pdf->Cell(80, 7, 'Akun', 1, 0, 'C');
            $pdf->Cell(75, 7, 'Keterangan', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Jumlah', 1, 1, 'C');


            $currentY1 = 54;
            $currentY2 = 54;

            foreach ($rows as $row) {
                if (empty($row['tahun_ajaran'])) {
                    $akun = strtoupper($row['kode_akun']) . '. ' . strtoupper($row['nama_akun']) . ' / ' . strtoupper($row['nama_jenjang']) .  ' / ' . strtoupper($firstRow['tahun_ajaran']);
                    $tinggi = (strlen($akun) <= 35) ? 14 : 7;
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->MultiCell(80, $tinggi, $akun, 1, 'L');

                    $pdf->SetY($currentY1);
                    $pdf->SetX(90);
                    $pdf->SetFont('Arial', '', 9);
                    $keterangan = strtoupper($row['keterangan']);
                    $tinggi = (strlen($keterangan) <= 38) ? 14 : 7;
                    $pdf->MultiCell(75, $tinggi, $keterangan, 1, 'L');  

                    $currentY1 += 14;
                    $pdf->SetY($currentY2);        
                    $pdf->SetX(165);               
                    if ($jenis_transaksi == 'Penerimaan') {
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(35, 14, 'Rp. ' . number_format($row['kredit'], 0, '.', ','), 1, 1, 'C');
                    } elseif ($jenis_transaksi == 'Pengeluaran') {
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(35, 14, 'Rp. ' . number_format($row['debit'], 0, '.', ','), 1, 1, 'C');
                    }
                    $currentY2 += 14;
                }
            }
            
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(155, 7, 'Jumlah Total', 1, 0, 'C');
            if ($jenis_transaksi == 'Penerimaan') {
                $pdf->Cell(35, 7, 'Rp ' . number_format($firstRow['debit'], 0, '.', ','), 1, 0, 'C');
            } elseif ($jenis_transaksi == 'Pengeluaran') {
                $pdf->Cell(35, 7, 'Rp ' . number_format($firstRow['kredit'], 0, '.', ','), 1,0, 'C');
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

            $pdf->Output('bukti_bank.pdf', 'D');
        } else {
            echo "Nomor transaksi $no_transaksi tidak ditemukan";
        }
    } else {
        echo "Error fetching data from the database.";
    }
}


?>
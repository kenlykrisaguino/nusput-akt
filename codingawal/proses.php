<?php
require('fpdf/fpdf.php');

// Ambil data dari formulir
$nama = $_POST['nama'];
$email = $_POST['email'];

// Proses data
// ... (lakukan sesuatu dengan data)

// Buat file PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Nama: ' . $nama);
$pdf->Ln();
$pdf->Cell(40,10,'Email: ' . $email);

// Simpan file PDF
$pdf_file = 'output_form.pdf';
$pdf->Output($pdf_file, 'F');

echo 'Data telah diproses. <a href="' . $pdf_file . '" target="_blank">Download PDF</a>';
?>

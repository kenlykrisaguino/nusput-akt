<?php
include 'connect.php';

$no_bukti = $tanggal = $sumber_dana = $no_kasbon = "";

if (isset($_POST['no_transaksi']) ) {
    $no_transaksi = $_POST['no_transaksi'];

    $stmt = $konektor->prepare("SELECT * FROM transaksi_bank WHERE no_transaksi = ? AND jenis_transaksi = 'Penerimaan'");
    $stmt->bind_param("s", $no_transaksi);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    if (!empty($rows)) {
        $firstRow = $rows[0];
        $no_bukti = $firstRow['no_transaksi'];
        $tanggal = date('d/m/Y', strtotime($firstRow['tanggal']));
        $sumber_dana = $firstRow['sumber_dana'];
        $jumlah = $firstRow['debit'];
        $nama_akun = $firstRow['nama_akun'];
        $no_kasbon = $firstRow['no_kasbon'];
        $tahun_ajaran = $firstRow['tahun_ajaran'];
    } else {
        // Jika tidak ada data, beri nilai default
        $no_bukti = "-";
        $tanggal = "-";
        $sumber_dana = "-";
        $no_kasbon = "-";
    }
}
?>

<div class="container-fluid">
    <div class="card-header py-3">
        <h3 class="text-center m-0 font-weight-bold text-dark">BUKTI PEMBALIK KASBON</h3>
    </div>      

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary"></div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">

                    <!-- Bagian yang akan dicetak -->

                    <div class="d-flex justify-content-between font-weight-bold mt-3 mb-3">
                        <span>No. Bukti: <?php echo htmlspecialchars($no_bukti); ?></span>
                        <span>Tanggal: <?php echo htmlspecialchars($tanggal); ?></span>
                        <span>Sumber Dana: <?php echo htmlspecialchars($sumber_dana); ?></span>
                        <span>No. Kasbon: <?php echo htmlspecialchars($no_kasbon); ?></span>
                    </div>

                    <table class="table table-bordered table-hover">
                        <tr id="input" style= "background-color:rgb(255, 255, 255);">
                            <th colspan="4">DIBAYARKAN KEPADA:</th>
                        </tr>
                        <tr style="text-align: center; background-color:rgb(255, 255, 255);">
                            <th style="text-align:center; width: 30%;">Akun</th>
                            <th style="text-align:center; width: 40%;">Keterangan</th>
                            <th style="text-align:center; width: 15%;">Debit</th>
                            <th style="text-align:center; width: 15%;">Kredit</th>
                        </tr>

                        <?php if (!empty($rows)): ?>
                            <?php 
                            $total_debit = 0; 
                            $total_kredit = 0;

                            foreach ($rows as $row): 
                                $debit = $row['debit']; 
                                $kredit = $row['kredit']; 

                                // Menambahkan ke total masing-masing
                                $total_debit += $debit; 
                                $total_kredit += $kredit;
                            ?>
                                <tr style="background-color:rgb(255, 255, 255);">
                                    <td>
                                        <?php 
                                        echo strtoupper($row['kode_akun']) . '. ' . 
                                        strtoupper($row['nama_akun']) . ' / ' . 
                                        strtoupper($row['nama_jenjang']) . ' / ' . 
                                        strtoupper($row['tahun_ajaran']); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo strtoupper($row['keterangan']); ?>
                                    </td>
                                    <td style="text-align:center">
                                        Rp. <?php echo number_format($debit, 0, '.', ','); ?>
                                    </td>
                                    <td style="text-align:center">
                                        Rp. <?php echo number_format($kredit, 0, '.', ','); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if ($total_debit > 0 || $total_kredit > 0): ?>
                                <tr style="background-color:rgb(255, 255, 255); font-weight:bold;">
                                    <th colspan="2" style="text-align:center">TOTAL</th>
                                    <th style="text-align:center">
                                        Rp. <?php echo number_format($total_debit, 0, '.', ','); ?>
                                    </th>
                                    <th style="text-align:center">
                                        Rp. <?php echo number_format($total_kredit, 0, '.', ','); ?>
                                    </th>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data transaksi</td>
                                </tr>
                            <?php endif; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data transaksi</td>
                            </tr>
                        <?php endif; ?>
                    </table>

                    <table class="table table-bordered" style="width: 70%; text-align: left;">
                        <tr class="input" style="text-align: center; background-color: rgb(255, 255, 255);">
                            <th style="width: 25%;">Disetujui</th>
                            <th style="width: 25%;">Pembukuan</th>
                            <th style="width: 25%;">Kasir</th>
                            <th style="width: 25%;">Penerima</th>
                        </tr>
                        <tr class="input" style="text-align: center; background-color: rgb(255, 255, 255);">
                            <td rowspan="3" style="height: 80px;"></td>
                            <td rowspan="3" style="height: 80px;"></td>
                            <td rowspan="3" style="height: 80px;"></td>
                            <td rowspan="3" style="height: 80px;"></td>
                        </tr>
                    </table>

                </div>
                    
                <!-- Tombol Print -->
                <button type="button" class="btn btn-primary mb-3" onclick="printPage()">Print</button>

            </form>
        </div>
    </div>
</div>

<style>
@media print {
    body {
        margin: 0;
        padding: 0;
    }
    
    /* Sembunyikan elemen yang tidak diperlukan saat print */
    .sidebar, .logout-btn, .navbar, .header, .btn, footer {
        display: none !important;
    }
    
    /* Pastikan konten utama tetap terlihat */
    .content {
        width: 100%;
    }
}
</style>

<script>
function printPage() {
    window.print();
}
</script>

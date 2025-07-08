<?php
include 'connect.php';

$no_bukti = $tanggal = $sumber_dana = $no_kasbon = "";
$jenis_transaksi = ""; // Inisialisasi variabel

if (isset($_POST['no_transaksi']) && isset($_POST['jenis_transaksi'])) {
    $no_transaksi = $_POST['no_transaksi'];
    $jenis_transaksi = $_POST['jenis_transaksi'];

    $stmt = $konektor->prepare("SELECT * FROM transaksi_bank WHERE no_transaksi = ? AND jenis_transaksi = ?");
    $stmt->bind_param("ss", $no_transaksi, $jenis_transaksi);
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
        <h3 class="text-center m-0 font-weight-bold text-dark">
            <?php
            if ($jenis_transaksi == 'Penerimaan') {
                echo 'BUKTI PENERIMAAN BANK';
            } elseif ($jenis_transaksi == 'Pengeluaran') {
                echo 'BUKTI PENGELUARAN BANK';
            } else {
                echo 'BUKTI TRANSAKSI BANK';
            }
            ?>
        </h3>
    </div>      

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary"></div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">

                    <!-- Bagian yang akan dicetak -->
                    <h4 class="text-center font-weight-bold text-dark"><?php echo htmlspecialchars($nama_akun); ?></h4>

                    <div class="d-flex justify-content-between font-weight-bold mt-3 mb-3">
                        <span>No. Bukti: <?php echo htmlspecialchars($no_bukti); ?></span>
                        <span>Tanggal: <?php echo htmlspecialchars($tanggal); ?></span>
                        <span>Sumber Dana: <?php echo htmlspecialchars($sumber_dana); ?></span>
                        <span>No. Kasbon: <?php echo htmlspecialchars($no_kasbon); ?></span>
                    </div>

                        <table class="table table-bordered table-hover border: 3px solid black !important;">
                            <tr id="input" style= "background-color:rgb(255, 255, 255);">
                            <th colspan="3">DIBAYARKAN KEPADA:</th>
                        </tr>
                        <tr style="text-align: center; background-color:rgb(255, 255, 255);">
                    <th style="text-align:center; width:25%;">Akun</th> <!-- Lebar Akun dikurangi -->
                    <th style="text-align:center; width:50%;">Keterangan</th>
                    <th style="text-align:center; width:25%;">Jumlah</th>
                    </tr>


                        <?php if (!empty($rows)): ?>
                              <?php 
                              $total = 0; // Inisialisasi total
                              foreach ($rows as $row): 
                              if (empty($row['sumber_dana'])): // Hanya menampilkan jika sumber dana kosong
                                        $jumlah = ($jenis_transaksi == 'Penerimaan') ? $row['kredit'] : $row['debit'];
                                        $total += $jumlah; // Menambahkan jumlah ke total
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
                                                  Rp. <?php echo number_format($jumlah, 0, '.', ','); ?>
                                        </td>
                                        </tr>
                              <?php 
                              endif;
                              endforeach; 
                              ?>
                              
                              <?php if ($total > 0): // Tampilkan total hanya jika ada data ?>
                              <tr style="background-color:rgb(255, 255, 255);">
                                        <th colspan="2" style="text-align:center">TOTAL</th>
                                        <th style="text-align:center">
                                        Rp. <?php echo number_format($total, 0, '.', ','); ?>
                                        </th>
                              </tr>
                              <?php else: ?>
                              <tr>
                                        <td colspan="3" class="text-center">Tidak ada data transaksi dengan sumber dana kosong</td>
                              </tr>
                              <?php endif; ?>

                              <?php else: ?>
                              <tr>
                              <td colspan="3" class="text-center">Tidak ada data transaksi</td>
                              </tr>
                              <?php endif; ?>


                            <table class="table table-bordered" style="width: 70%; text-align: left;">
                              <!-- Header Tabel -->
                              <tr class="input" style="text-align: center; background-color: rgb(255, 255, 255);">
                              <th style="width: 25%;">Disetujui</th>
                              <th style="width: 25%;">Pembukuan</th>
                              <th style="width: 25%;">Kasir</th>
                              <th style="width: 25%;">Penerima</th>
                              </tr>

                              <!-- Baris Kosong untuk Isi Tabel dengan Tinggi Lebih Panjang -->
                              <tr class="input" style="text-align: center; background-color: rgb(255, 255, 255);">
                              <td rowspan="3" style="height: 80px;"></td>
                              <td rowspan="3" style="height: 80px;"></td>
                              <td rowspan="3" style="height: 80px;"></td>
                              <td rowspan="3" style="height: 80px;"></td>
                              </tr>
                              </table>


                    </div>
                    
                    <!-- Tambahkan Tombol Print -->
                    <button type="button" class="btn btn-primary mb-3" onclick="printPage()">Print</button>

                </div>
            </form>
                    <style>
                /* Gaya teks agar tetap dark */
                body, h3, h4, span, th, td {
                    color: #000 !important;
                }

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


<!-- Tambahkan Script Print -->
<script>
function printPage() {
    window.print();
}
</script>




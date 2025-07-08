<?php
include 'connect.php';

$no_bukti = $tanggal = $sumber_dana = "";
$jenis_transaksi = ""; // Inisialisasi variabel

if (isset($_POST['no_transaksi']) && !empty($_POST['no_transaksi'])) {
          $konektor = mysqli_connect("localhost", "root", "", "nusput");
          
          // Pastikan nomor transaksi yang diproses hanya satu (ambil baris pertama saja)
          $no_transaksi = mysqli_real_escape_string($konektor, $_POST['no_transaksi']);
          
          // Query transaksi
          $sql = $konektor->query("SELECT * FROM transaksi WHERE no_transaksi = '$no_transaksi' LIMIT 1");
          
          if ($sql && $sql->num_rows > 0) {
              $data = $sql->fetch_assoc(); // Ambil hanya satu baris data
              
              // Ambil data transaksi
              $tanggal = date('d/m/Y', strtotime($data['tanggal']));
              $no_bukti = $data['no_transaksi'];
              $kategori_transaksi = $data['kode_transaksi'];
              $kategoritransaksi = $data['kategori_transaksi'];
              $sumber_dana = $data['sumber_dana'];
              $jenjang = $data['nama_jenjang'];
              $tahun_ajaran = $data['tahun_ajaran'];
              $keterangan = $data['keterangan'];
              $nominal = number_format($data['debit'], 0, ',', '.'); // Format angka
              
              function terbilang($angka) {
                  $angka = abs($angka);
                  $bilangan = array(
                      '', 'SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM', 'TUJUH', 'DELAPAN', 'SEMBILAN', 'SEPULUH', 'SEBELAS'
                  );
                  $hasil = '';
      
                  if ($angka < 12) {
                      $hasil = $bilangan[$angka];
                  } elseif ($angka < 20) {
                      $hasil = terbilang($angka - 10) . ' BELAS';
                  } elseif ($angka < 100) {
                      $hasil = terbilang($angka / 10) . ' PULUH ' . terbilang($angka % 10);
                  } elseif ($angka < 200) {
                      $hasil = 'SERATUS ' . terbilang($angka - 100);
                  } elseif ($angka < 1000) {
                      $hasil = terbilang($angka / 100) . ' RATUS ' . terbilang($angka % 100);
                  } elseif ($angka < 2000) {
                      $hasil = 'SERIBU ' . terbilang($angka - 1000);
                  } elseif ($angka < 1000000) {
                      $hasil = terbilang($angka / 1000) . ' RIBU ' . terbilang($angka % 1000);
                  } elseif ($angka < 1000000000) {
                      $hasil = terbilang($angka / 1000000) . ' JUTA ' . terbilang($angka % 1000000);
                  } elseif ($angka < 1000000000000) {
                      $hasil = terbilang($angka / 1000000000) . ' MILYAR ' . terbilang(fmod($angka, 1000000000));
                  } else {
                      $hasil = 'ANGKA TERLALU BESAR';
                  }
      
                  return $hasil;
              }
              
              $debit_terbilang = terbilang((int)$data['debit']);
          }
      }
?>

<div class="container-fluid">
          <div class="card-header py-3">
                    <h3 class="text-center m-0 font-weight-bold text-dark">BUKTI TRANSAKSI KEUANGAN</h3>
          </div>

          <div class="row">
                    <div class="col-md-12">
                              <div class="card card-primary"></div>
                              <div class="card-body">
                                        <form method="POST" enctype="multipart/form-data">

                                        <div class="d-flex justify-content-between font-weight-bold mt-3 mb-3">
                        <span>No. Bukti: <?php echo htmlspecialchars($no_bukti); ?></span>
                        <span>Tanggal: <?php echo htmlspecialchars($tanggal); ?></span>
                        <span>Sumber Dana: <?php echo htmlspecialchars($sumber_dana); ?></span>
                    </div>

                    <table class="table table-bordered table-hover">
                        <tr style="background-color:rgb(255, 255, 255);">
                            <th style="width: 30%;">Kategori</th>
                            <td><?php echo strtoupper(($kategori_transaksi ?: '-') . ' - ' . ($kategoritransaksi ?: '-')); ?></td>
                            </tr>
                        <tr style="background-color:rgb(255, 255, 255);">
                            <th style="width: 40%;">Keterangan</th>
                            <td><?php echo strtoupper($keterangan ?: '-'); ?></td>
                        </tr>
                        <tr style="background-color:rgb(255, 255, 255);">
                            <th style="width: 15%;">Nominal</th>
                            <td>Rp. <?php echo $nominal ?: '0'; ?></td>
                        </tr>
                        <tr style="background-color:rgb(255, 255, 255);">
                            <th style="width: 15%;">Terbilang</th>
                            <td><?php echo strtoupper(($debit_terbilang ?: '-') . ' RUPIAH'); ?></td>
                            </tr>
                    </table>

                                                  <table class="table table-bordered" style="width: 70%; text-align: left;">
                                                            <tr style="text-align: center; background-color: rgb(255, 255, 255);">
                                                                      <th style="width: 25%;">Disetujui</th>
                                                                      <th style="width: 25%;">Pembukuan</th>
                                                                      <th style="width: 25%;">Kasir</th>
                                                                      <th style="width: 25%;">Penerima</th>
                                                            </tr>
                                                            <tr style="text-align: center; background-color: rgb(255, 255, 255);">
                                                                      <td rowspan="3" style="height: 80px;"></td>
                                                                      <td rowspan="3" style="height: 80px;"></td>
                                                                      <td rowspan="3" style="height: 80px;"></td>
                                                                      <td rowspan="3" style="height: 80px;"></td>
                                                            </tr>
                                                  </table>

                                                  <button type="button" class="btn btn-primary mb-3" onclick="printPage()">Print</button>
                                        </form>
                              </div>
                    </div>
          </div>
</div>

<style>
          @media print {
                    body {
                              margin: 0;
                              padding: 0;
                    }

                    .sidebar,
                    .logout-btn,
                    .navbar,
                    .header,
                    .btn,
                    footer {
                              display: none !important;
                    }

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
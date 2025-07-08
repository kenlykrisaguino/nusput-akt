<?php
$query = "SELECT MAX(CAST(no_transaksi AS SIGNED)) AS max_code FROM transaksi_memorial";
$result = $konektor->query($query);
$row = $result->fetch_assoc();
$urutan = isset($row['max_code']) ? (int) $row['max_code'] + 1 : 1;


    $kode_akun = $_GET['kode_akun'];
    $normal = $konektor->query("SELECT * FROM akun WHERE kode_akun = '$kode_akun'");
    $tampil = $normal->fetch_assoc();
?>
    <div class="container-fluid">
    <div class="card shadow mb-2">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Transaksi Memorial</h3>
    </div>
        <div class="row">
        <div class="col-md-12">
        <div class="card card-primary">
          </div>        
        <div class="card-body">		
    <form method="POST" enctype="multipart/form-data">

    <input type="hidden" name="no_transaksi" id="no_transaksi" value="<?= $urutan ?>" class="form-control col-sm-9">

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tanggal</b></label>
          <input type="date" name="tanggal" id="tanggal" class="form-control col-sm-9" required>
        </div>
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("tanggal").setAttribute("max", today);
            document.getElementById("tanggal").setAttribute("value", today);
          });
        </script>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Sumber Dana</b></label>
          <select name="sumber_dana" id="sumber_dana" class="form-control col-sm-9" required>
            <option value="">Pilih Sumber Dana</option>
            <option value="Rutin">Rutin</option>
            <option value="Bantuan">Bantuan</option>oi
          </select>
        </div>        

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tahun Ajaran</b></label>
          <select class="form-control select2 col-sm-9" name="kode_tahun" id="kode_tahun" required>
          <option value="">Pilih Tahun Ajaran</option>
        <?php
        $query = "SELECT * FROM th_ajaran";
        $result = $konektor->query($query);
        if ($result && $result->num_rows > 0) { 
            while ($data = mysqli_fetch_assoc($result)) {
                $kode_tahun = $data['kode_tahun'];
                $tahun_ajaran = $data['tahun_ajaran'];
        ?>
          <option value="<?= $kode_tahun ?>" data-tahun="<?= $tahun_ajaran ?>"><?= $kode_tahun . ' → ' . $tahun_ajaran ?></option>
        <?php
          }}
        ?>
          </select>
          <span class="col-1"></span>
          <input type="hidden" class="form-control col-sm-4" id="tahun_ajaran" readonly>
        </div>
        <script>

        <div class="form-group row" style="display: none;">
        <label for="nama" class="col-sm-2"><b>Status</b></label>
          <select name="status" id="status" class="form-control col-sm-9" readonly>
            <option value="1">Aktif</option>
          </select>
          </div>

          <hr>

                          <table class="table table-bordered table-hover">
                            <tr id="input">
                              <th style="text-align:center">Akun</th>
                              <th style="text-align:center">Jenjang</th>
                              <th style="text-align:center">Keterangan</th>
                              <th style="text-align:center">Debit</th>
                              <th style="text-align:center">Kredit</th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                                  }}
                              ?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>
                            <th>
        <select class="form-control select2" name="kode_jenjang1" id="kode_jenjang1" required="">
          <option value="">Pilih Jenjang</option>
          <?php
                  $query = "SELECT * FROM master_jenjang";
                  $result = $konektor->query($query);
                  $num_result = $result->num_rows;
                  if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_jenjang = $data['kode_jenjang'];
                        $nama_jenjang = $data['nama_jenjang'];
                  ?>
                    <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                  <?php
                    }}
                  ?>
        </select>
        <input type="hidden" id="nama_jenjang1" readonly>
      </th>

      <th><input type="text" name="keterangan1" id="keterangan1" class="form-control" placeholder="Input Keterangan"></th>

                            <th><input style="text-align:center" type="text" class="form-control" name="saldo1" id="saldo1" oninput="formatNumber(this); calculateTotal();" ></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo2" id="saldo2" oninput="formatNumber(this); calculateTotal();" ></th>

                            </tr>

                            <th>
                              <select class="form-control select2" name="kode_akun2" id="kode_akun2" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal2 = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank2="<?= $akun ?>" data-saldo-normal2="<?= $saldo_normal2 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                                  }}
                              ?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun2" id="akun2" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal2" readonly>

                              <th><input style="text-align:center" type="text" class="form-control" name="saldo3" id="saldo3" oninput="formatNumber(this); calculateTotal();" ></th>
                              <th><input style="text-align:center" type="text" class="form-control" name="saldo4" id="saldo4" oninput="formatNumber(this); calculateTotal();" ></th>
                  </tr>
                            </tr>
                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun3" id="kode_akun3" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal3 = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank3="<?= $akun ?>" data-saldo-normal3="<?= $saldo_normal3 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                                  }}
                              ?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun3" id="akun3" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal3" readonly>

                            <th><input style="text-align:center" type="text" class="form-control" name="saldo5" id="saldo5" oninput="formatNumber(this); calculateTotal();"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo6" id="saldo6" oninput="formatNumber(this); calculateTotal();"></th>

                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun4" id="kode_akun4" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal4 = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank4="<?= $akun ?>" data-saldo-normal4="<?= $saldo_normal4 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                                  }}
                              ?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun4" id="akun4" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal4" readonly>

                            <th><input style="text-align:center" type="text" class="form-control" name="saldo7" id="saldo7" oninput="formatNumber(this); calculateTotal();"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo8" id="saldo8" oninput="formatNumber(this); calculateTotal();"></th>

                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun5" id="kode_akun5" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal5 = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank5="<?= $akun ?>" data-saldo-normal5="<?= $saldo_normal5 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                                  }}
                              ?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun5" id="akun5" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal5" readonly>
               
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo9" id="saldo9" oninput="formatNumber(this); calculateTotal();"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo10" id="saldo10" oninput="formatNumber(this); calculateTotal();"></th>

                            </tr>

                            <tr id="input">
                                <th style="text-align:center"> Total </th>
                          <th><input style="text-align:center" type="text" class="form-control" id="total" readonly></th>                      
                          <th><input style="text-align:center" type="text" class="form-control" id="total2" readonly></th>
                          <script>
                            function formatNumber(input) {
                                var value = input.value.replace(/[^0-9.]/g, '');
                                var parts = value.split('.');
                                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                input.value = parts.join('.');
                            }

                            function removeFormat(input) {
                                input.value = input.value.replace(/,/g, '');
                            }

                            function calculateTotal() {
                                var saldo1 = parseFloat(document.getElementById('saldo1').value.replace(/,/g, '')) || 0;
                                var saldo2 = parseFloat(document.getElementById('saldo2').value.replace(/,/g, '')) || 0;
                                var saldo3 = parseFloat(document.getElementById('saldo3').value.replace(/,/g, '')) || 0;
                                var saldo4 = parseFloat(document.getElementById('saldo4').value.replace(/,/g, '')) || 0;
                                var saldo5 = parseFloat(document.getElementById('saldo5').value.replace(/,/g, '')) || 0;
                                var saldo6 = parseFloat(document.getElementById('saldo6').value.replace(/,/g, '')) || 0;
                                var saldo7 = parseFloat(document.getElementById('saldo7').value.replace(/,/g, '')) || 0;
                                var saldo8 = parseFloat(document.getElementById('saldo8').value.replace(/,/g, '')) || 0;
                                var saldo9 = parseFloat(document.getElementById('saldo9').value.replace(/,/g, '')) || 0;
                                var saldo10 = parseFloat(document.getElementById('saldo10').value.replace(/,/g, '')) || 0;

                                var total = saldo1 + saldo3 + saldo5 + saldo7 + saldo9;
                                var total2 = saldo2 + saldo4 + saldo6 + saldo8 + saldo10;

                                // Mengatur format angka pada hasil total
                                var formattedTotal = total.toLocaleString('id-ID');
                                var formattedTotal2 = total2.toLocaleString('id-ID');

                                // Menampilkan total dalam input 'total' dengan format angka dan satuan mata uang
                                document.getElementById('total').value = 'Rp. ' + formattedTotal;
                                document.getElementById('total2').value = 'Rp. ' + formattedTotal2;
                            }
                        </script>
                            </tr>
                          </table>
                          </div>
                            <script>
                            function removeFormatFromSaldoInputs() {
                                removeFormat(document.getElementById('saldo1'));
                                removeFormat(document.getElementById('saldo2'));
                                removeFormat(document.getElementById('saldo3'));
                                removeFormat(document.getElementById('saldo4'));
                                removeFormat(document.getElementById('saldo5'));
                                removeFormat(document.getElementById('saldo6'));
                                removeFormat(document.getElementById('saldo7'));
                                removeFormat(document.getElementById('saldo8'));
                                removeFormat(document.getElementById('saldo9'));
                                removeFormat(document.getElementById('saldo10'));
                            }
                            </script>
                              <div class="card-body">
                              <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" onclick="removeFormatFromSaldoInputs()"></input> 
                              <a href="?page=transaksi_memorial&aksi=data" class="btn btn-success">Transaksi Terbuat</a>                              
</div>
                      </form>

<?php
include "connect.php";

if (isset($_POST['simpan'])) {
  $status = $_POST['status'];    
  $kode_akun = $_POST['kode_akun'];
  $kode_akun2 = $_POST['kode_akun2'];
  $kode_akun3 = $_POST['kode_akun3'];
  $kode_akun4 = $_POST['kode_akun4'];
  $kode_akun5 = $_POST['kode_akun5'];
  $no_transaksi = $_POST['no_transaksi'];
  $tanggal = $_POST['tanggal'];
  $sumber_dana = $_POST['sumber_dana'];
  $kode_tahun = $_POST['kode_tahun'];
  $kode_jenjang = $_POST['kode_jenjang'];
  $keterangan = $_POST['keterangan'];
  $saldo1 = $_POST['saldo1'];
  $saldo2 = $_POST['saldo2'];
  $saldo3 = $_POST['saldo3'];
  $saldo4 = $_POST['saldo4'];
  $saldo5 = $_POST['saldo5'];
  $saldo6 = $_POST['saldo6'];
  $saldo7 = $_POST['saldo7'];
  $saldo8 = $_POST['saldo8'];
  $saldo9 = $_POST['saldo9'];
  $saldo10 = $_POST['saldo10'];

    $query_jenjang = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang'";
    $result_jenjang = $konektor->query($query_jenjang);
    $data_jenjang = $result_jenjang->fetch_assoc();
    $nama_jenjang = $data_jenjang['nama_jenjang'];

    $query_tahun = "SELECT tahun_ajaran FROM th_ajaran WHERE kode_tahun='$kode_tahun'";
    $result_tahun = $konektor->query($query_tahun);
    $data_tahun = $result_tahun->fetch_assoc();
    $tahun_ajaran = $data_tahun['tahun_ajaran'];

    $query_akun = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun'";
    $result_akun = $konektor->query($query_akun);
    $data_akun = $result_akun->fetch_assoc();
    $nama_akun = $data_akun['nama_akun'];

    $query_akun2 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun2'";
    $result_akun2 = $konektor->query($query_akun2);
    $data_akun2 = $result_akun2->fetch_assoc();
    $nama_akun2 = $data_akun2['nama_akun'];

    $query_akun3 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun3'";
    $result_akun3 = $konektor->query($query_akun3);
    $data_akun3 = $result_akun3->fetch_assoc();
    $nama_akun3 = $data_akun3['nama_akun'];

    $query_akun4 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun4'";
    $result_akun4 = $konektor->query($query_akun4);
    $data_akun4 = $result_akun4->fetch_assoc();
    $nama_akun4 = $data_akun4['nama_akun'];

    $query_akun5 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun5'";
    $result_akun5 = $konektor->query($query_akun5);
    $data_akun5 = $result_akun5->fetch_assoc();
    $nama_akun5 = $data_akun5['nama_akun'];

    $queryz_akun = "SELECT saldo_normal FROM akun WHERE kode_akun='$kode_akun'";
    $resultz_akun = $konektor->query($queryz_akun);
    $dataz_akun = $resultz_akun->fetch_assoc();
    $saldo_normal = $dataz_akun['saldo_normal'];

    $queryz_akun2 = "SELECT saldo_normal FROM akun WHERE kode_akun='$kode_akun2'";
    $resultz_akun2 = $konektor->query($queryz_akun2);
    $dataz_akun2 = $resultz_akun2->fetch_assoc();
    $saldo_normal2 = $dataz_akun2['saldo_normal'];

    $queryz_akun3 = "SELECT saldo_normal FROM akun WHERE kode_akun='$kode_akun3'";
    $resultz_akun3 = $konektor->query($queryz_akun3);
    $dataz_akun3 = $resultz_akun3->fetch_assoc();
    $saldo_normal3 = $dataz_akun3['saldo_normal'];

    $queryz_akun4 = "SELECT saldo_normal FROM akun WHERE kode_akun='$kode_akun4'";
    $resultz_akun4 = $konektor->query($queryz_akun4);
    $dataz_akun4 = $resultz_akun4->fetch_assoc();
    $saldo_normal4 = $dataz_akun4['saldo_normal'];

    $queryz_akun5 = "SELECT saldo_normal FROM akun WHERE kode_akun='$kode_akun5'";
    $resultz_akun5 = $konektor->query($queryz_akun5);
    $dataz_akun5 = $resultz_akun5->fetch_assoc();
    $saldo_normal5 = $dataz_akun5['saldo_normal'];

    if((isset($_POST['simpan']))){
      if (!empty($kode_akun) && !empty($kode_akun2)) {
      $insertquery = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun','$nama_akun','$saldo1','$saldo2','$saldo_normal')";
      
      $insertquery2 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun2','$nama_akun2','$saldo3','$saldo4','$saldo_normal')";
  
      }if (!empty($kode_akun3)) {
      $insertquery = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun','$nama_akun','$saldo1','$saldo2','$saldo_normal')";
      
      $insertquery2 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun2','$nama_akun2','$saldo3','$saldo4','$saldo_normal')";
  
      $insertquery3 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun3','$nama_akun3','$saldo5','$saldo6','$saldo_normal')";
    
      }if (!empty($kode_akun4)) {
      $insertquery = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun','$nama_akun','$saldo1','$saldo2','$saldo_normal')";
        
      $insertquery2 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun2','$nama_akun2','$saldo3','$saldo4','$saldo_normal')";
    
      $insertquery3 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun3','$nama_akun3','$saldo5','$saldo6','$saldo_normal')";  

      $insertquery4 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun4','$nama_akun4','$saldo7','$saldo8','$saldo_normal')";
      
      }if (!empty($kode_akun5)){
      $insertquery = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun','$nama_akun','$saldo1','$saldo2','$saldo_normal')";
        
      $insertquery2 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun2','$nama_akun2','$saldo3','$saldo4','$saldo_normal')";
    
      $insertquery3 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun3','$nama_akun3','$saldo5','$saldo6','$saldo_normal')";  

      $insertquery4 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun4','$nama_akun4','$saldo7','$saldo8','$saldo_normal')";
      
      $insertquery5 = "INSERT INTO transaksi_memorial (status, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, saldo_normal) 
      VALUES('$status','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang','$nama_jenjang','$kode_tahun','$tahun_ajaran','$keterangan','$kode_akun5','$nama_akun5','$saldo9','$saldo10','$saldo_normal')";

         if (!empty($saldo1)) {
          if ($saldo_normal == 'Debit') {
              $updatequery = "UPDATE akun SET saldo=saldo+$saldo1 WHERE kode_akun='$kode_akun'";
          } else if ($saldo_normal == 'Kredit') {
              $updatequery = "UPDATE akun SET saldo=saldo-$saldo1 WHERE kode_akun='$kode_akun'";
          }
        }

        if (!empty($saldo2)) {
          if ($saldo_normal == 'Kredit') {
              $updatequery = "UPDATE akun SET saldo=saldo+$saldo2 WHERE kode_akun='$kode_akun'";
          } else if ($saldo_normal == 'Debit') {
              $updatequery = "UPDATE akun SET saldo=saldo-$saldo2 WHERE kode_akun='$kode_akun'";
          }
        }

        if (!empty($saldo3)) {
          if ($saldo_normal == 'Debit') {
              $updatequery2 = "UPDATE akun SET saldo=saldo+$saldo3 WHERE kode_akun='$kode_akun2'";
          } else if ($saldo_normal == 'Kredit') {
              $updatequery2 = "UPDATE akun SET saldo=saldo-$saldo3 WHERE kode_akun='$kode_akun2'";
          }
        }

        if (!empty($saldo4)) {
          if ($saldo_normal == 'Kredit') {
              $updatequery2 = "UPDATE akun SET saldo=saldo+$saldo4 WHERE kode_akun='$kode_akun2'";
          } else if ($saldo_normal == 'Debit') {
              $updatequery2 = "UPDATE akun SET saldo=saldo-$saldo4 WHERE kode_akun='$kode_akun2'";
          }
        }

        if (!empty($saldo5)) {
          if ($saldo_normal == 'Debit') {
              $updatequery3 = "UPDATE akun SET saldo=saldo+$saldo5 WHERE kode_akun='$kode_akun3'";
          } else if ($saldo_normal == 'Kredit') {
              $updatequery3 = "UPDATE akun SET saldo=saldo-$saldo5 WHERE kode_akun='$kode_akun3'";
          }
        }

        if (!empty($saldo6)) {
          if ($saldo_normal == 'Kredit') {
              $updatequery3 = "UPDATE akun SET saldo=saldo+$saldo6 WHERE kode_akun='$kode_akun3'";
          } else if ($saldo_normal == 'Debit') {
              $updatequery3 = "UPDATE akun SET saldo=saldo-$saldo6 WHERE kode_akun='$kode_akun3'";
          }
        }

        if (!empty($saldo7)) {
          if ($saldo_normal == 'Debit') {
              $updatequery4 = "UPDATE akun SET saldo=saldo+$saldo7 WHERE kode_akun='$kode_akun4'";
          } else if ($saldo_normal == 'Kredit') {
              $updatequery4 = "UPDATE akun SET saldo=saldo-$saldo7 WHERE kode_akun='$kode_akun4'";
          }
        }

        if (!empty($saldo8)) {
          if ($saldo_normal == 'Kredit') {
              $updatequery4 = "UPDATE akun SET saldo=saldo+$saldo8 WHERE kode_akun='$kode_akun4'";
          } else if ($saldo_normal == 'Debit') {
              $updatequery4 = "UPDATE akun SET saldo=saldo-$saldo8 WHERE kode_akun='$kode_akun4'";
          }
        }

        if (!empty($saldo9)) {
          if ($saldo_normal == 'Debit') {
              $updatequery5 = "UPDATE akun SET saldo=saldo+$saldo9 WHERE kode_akun='$kode_akun5'";
          } else if ($saldo_normal == 'Kredit') {
              $updatequery5 = "UPDATE akun SET saldo=saldo-$saldo9 WHERE kode_akun='$kode_akun5'";
          }
        }

        if (!empty($saldo10)) {
          if ($saldo_normal == 'Kredit') {
              $updatequery5 = "UPDATE akun SET saldo=saldo+$saldo10 WHERE kode_akun='$kode_akun5'";
          } else if ($saldo_normal == 'Debit') {
              $updatequery5 = "UPDATE akun SET saldo=saldo-$saldo10 WHERE kode_akun='$kode_akun5'";
          }
        }
      }
    }
      
      ?>        

<script type="text/javascript">
      alert("Data Berhasil Disimpan");
      window.location.href="?page=transaksi_bank&aksi=data";
      </script>                   
    <?php
    if (mysqli_query($konektor, $insertquery) && 
        mysqli_query($konektor, $insertquery2) &&
        mysqli_query($konektor, $insertquery3) &&
        mysqli_query($konektor, $updatequery)  && 
        mysqli_query($konektor, $insertquery4) &&
        mysqli_query($konektor, $insertquery5) &&
        mysqli_query($konektor, $updatequery2) &&
        mysqli_query($konektor, $updatequery3) &&
        mysqli_query($konektor, $updatequery4) &&
        mysqli_query($konektor, $updatequery5)) {
          "Upload sukses";
        } else {
         "Error: " . $sql . "<br>" . mysqli_error($konektor);
        }
      }
        mysqli_close($konektor);
    ?>
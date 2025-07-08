<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jenis_transaksi = $_POST["jenis_transaksi"];

    // Query untuk mendapatkan kode maksimum untuk jenis_transaksi yang dipilih
    $query = "SELECT MAX(no_transaksi) AS max_code FROM transaksi_kas WHERE jenis_transaksi = '$jenis_transaksi'";
    $result = $konektor->query($query);
    $row = $result->fetch_assoc();
    $max_code = isset($row['max_code']) ? (int) $row['max_code'] : 0;
    // Tentukan angka awal untuk kode
    $starting_number = $max_code + 1;
        // Generate kode lengkap
    $kode_transaksi = $starting_number . "-" . strtoupper(substr($jenis_transaksi, 0, 3));
}
    $kode_akun = $_GET['kode_akun'];
    $normal = $konektor->query("SELECT * FROM akun WHERE kode_akun = '$kode_akun'");
    $tampil = $normal->fetch_assoc();
?>
    <div class="container-fluid">
    <div class="card shadow mb-2">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Transaksi Kas</h3>
    </div>
        <div class="row">
        <div class="col-md-12">
        <div class="card card-primary">
          </div>        
        <div class="card-body">		
    <form method="POST" enctype="multipart/form-data">



    <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Jenis Transaksi</b></label>
        <select name="jenis_transaksi" id="jenis_transaksi" class="form-control col-sm-9" onchange="updateKodeTransaksi()" required>
            <option value="">Pilih Jenis Transaksi</option>
            <option value="Penerimaan">Penerimaan</option>
            <option value="Pengeluaran">Pengeluaran</option>
        </select>
    </div>

    <input type="hidden" name="no_transaksi" id="no_transaksi" value="<?= $kode_transaksi ?>" class="form-control col-sm-9">

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Akun</b></label>
          <select name="akun_kas" id="akun_kas" class="form-control col-sm-9" readonly>
                                <!-- <option value="">Pilih Akun</option> -->
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1 AND nama_akun LIKE 'kas%'";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      // $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-name="<?= $akun ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
                            ?>
                              </select></div>
                              </th>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tanggal</b></label>
          <input type="date" name="tanggal" id="tanggal" class="form-control col-sm-9" required="">
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
            <option value="Bantuan">Bantuan</option>
          </select>
        </div>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tahun Ajaran</b></label>
          <select class="form-control select2 col-sm-9" name="kode_tahun" id="kode_tahun" required="">
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

        <input type="hidden" name="status" id="status" value="1" class="form-control col-sm-9">

        <hr>

        <hr>
            <table class="table table-bordered table-hover">
              <tr id="input">
                <th style="text-align:center">Akun</th>
                <th style="text-align:center">Jenjang</th>
                <th style="text-align:center">Keterangan</th>
                <th style="text-align:center">Saldo</th>
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

              <th><input style="text-align:center" type="text" class="form-control" name="saldo1" id="saldo1" value="0" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
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
              <th>
                <select class="form-control select2" name="kode_jenjang2" id="kode_jenjang2">
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
                            <option value="<?= $kode_jenjang ?>" data-name2="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                          <?php
                            }}
                          ?>
                </select>
                <input type="hidden" id="nama_jenjang2" readonly>
              </th>

              <th><input type="text" name="keterangan2" id="keterangan2" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo2" id="saldo2" value="0" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              
              <tr id="input" >
              <th style="text-align:center" colspan="3"> Total </th>
              <th><input style="text-align:center" type="text" class="form-control" id="total" readonly></th>                      
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

                    var total = saldo1 + saldo2;

                    // Mengatur format angka pada hasil total
                    var formattedTotal = total.toLocaleString('id-ID');

                    // Menampilkan total dalam input 'total' dengan format angka dan satuan mata uang
                    document.getElementById('total').value = 'Rp. ' + formattedTotal;
                }
            </script>
                </tr>
              </table>
              </div>
                <script>
                function removeFormatFromSaldoInputs() {
                    removeFormat(document.getElementById('saldo1'));
                    removeFormat(document.getElementById('saldo2'));

                }
                </script>
                  <div class="card-body">
                  <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" onclick="removeFormatFromSaldoInputs()"></input> 
                  <a href="?page=transaksi_kas&aksi=data" class="btn btn-success">Transaksi Terbuat</a>                              
          </div>
          </form>

<?php
include "connect.php";

if (isset($_POST['simpan'])) {
  $status = $_POST['status']; 
  $no_transaksi = $_POST['no_transaksi'];
  $tanggal = $_POST['tanggal'];
  $sumber_dana = $_POST['sumber_dana'];
  $kode_tahun = $_POST['kode_tahun'];
  $akun_kas = $_POST['akun_kas'];
  $total = $_POST['total'];


  $query_tahun = "SELECT tahun_ajaran FROM th_ajaran WHERE kode_tahun='$kode_tahun'";
  $result_tahun = $konektor->query($query_tahun);
  $data_tahun = $result_tahun->fetch_assoc();
  $tahun_ajaran = $data_tahun['tahun_ajaran'];

  $query_akun = "SELECT nama_akun FROM akun WHERE kode_akun='$akun_kas'";
  $result_akun = $konektor->query($query_akun);
  $data_akun = $result_akun->fetch_assoc();
  $nama = $data_akun['nama_akun'];


  $kode_akun = $_POST['kode_akun'];
  $kode_akun2 = $_POST['kode_akun2'];
  $kode_akun3 = $_POST['kode_akun3'];


  $kode_jenjang1 = $_POST['kode_jenjang1'];
  $kode_jenjang2 = $_POST['kode_jenjang2'];
  $kode_jenjang3 = $_POST['kode_jenjang3'];


  $keterangan1 = $_POST['keterangan1'];
  $keterangan2 = $_POST['keterangan2'];
  $keterangan3 = $_POST['keterangan3'];


  $saldo1 = $_POST['saldo1'];
  $saldo2 = $_POST['saldo2'];
  $saldo3 = $_POST['saldo3'];


    $query_jenjang1 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang1'";
    $result_jenjang1 = $konektor->query($query_jenjang1);
    $data_jenjang1 = $result_jenjang1->fetch_assoc();
    $nama_jenjang1 = $data_jenjang1['nama_jenjang'];

    $query_jenjang2 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang2'";
    $result_jenjang2 = $konektor->query($query_jenjang2);
    $data_jenjang2 = $result_jenjang2->fetch_assoc();
    $nama_jenjang2 = $data_jenjang2['nama_jenjang'];

  

    $query_akun = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun'";
    $result_akun = $konektor->query($query_akun);
    $data_akun = $result_akun->fetch_assoc();
    $nama_akun = $data_akun['nama_akun'];

    $query_akun2 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun2'";
    $result_akun2 = $konektor->query($query_akun2);
    $data_akun2 = $result_akun2->fetch_assoc();
    $nama_akun2 = $data_akun2['nama_akun'];


    
    if((isset($_POST['simpan']))){
      if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun)) {
        $insertquery = "INSERT INTO transaksi_kas (no_transaksi, jenis_transaksi, status, tanggal, sumber_dana, 	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran, akun_kas, nama,	keterangan,	kode_akun,	nama_akun,	debit, kredit) 
        VALUES('$no_transaksi','$jenis_transaksi','$status','$tanggal','$sumber_dana','$kode_jenjang1','$nama_jenjang1','$kode_tahun','$tahun_ajaran','$akun_kas','$nama','$keterangan1','$kode_akun','$nama_akun','$total','$saldo1')";
      }
      
    } else if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun)) {
        $insertquery = "INSERT INTO transaksi_kas (no_transaksi, jenis_transaksi, status, tanggal, sumber_dana, 	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran, akun_kas, nama,	keterangan,	kode_akun,	nama_akun, kredit, debit) 
        VALUES('$no_transaksi','$jenis_transaksi','$status','$tanggal','$sumber_dana','$kode_jenjang1','$nama_jenjang1','$kode_tahun','$tahun_ajaran','$akun_kas','$nama','$keterangan1','$kode_akun','$nama_akun','$total','$saldo1')";
    }

?>        

      <script type="text/javascript">
      alert("Data Berhasil Disimpan");
      window.location.href="?page=transaksi_kas&aksi=data";
      </script>                       
    <?php
    if (mysqli_query($konektor, $insertquery) &&
        mysqli_query($konektor, $insertquery2)) {
          "Upload sukses";
        } else {
         "Error: " . $sql . "<br>" . mysqli_error($konektor);
        }
      }
        mysqli_close($konektor);
    ?>
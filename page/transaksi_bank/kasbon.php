<?php
if (isset($_POST['no_kasbon'])) {
    $no_kasbon = $_POST['no_kasbon'];
    $konektor = mysqli_connect("localhost", "root", "", "1_nusaputera");

    $sql = $konektor->query("SELECT * FROM transaksi_bank WHERE no_kasbon = $no_kasbon AND status = 1");

    if (!empty($sql)) {
        $rows = $sql->fetch_all(MYSQLI_ASSOC);

        if (!empty($rows)) {
            $firstRow = $rows[0];
            $no_bukti = $firstRow['no_transaksi'];
            $tanggal = date('d/m/Y', strtotime($firstRow['tanggal']));
            $sumber_dana = $firstRow['sumber_dana'];
            $jumlah = $firstRow['debit'];
            $tahun_ajaran = $firstRow['tahun_ajaran'];
      
    


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jenis_transaksi = $_POST["jenis_transaksi"];

    $query = "SELECT MAX(no_transaksi) AS max_code FROM transaksi_bank WHERE jenis_transaksi = 'Penerimaan'";
    $result = $konektor->query($query);
    $row = $result->fetch_assoc();
    $max_code = isset($row['max_code']) ? (int) $row['max_code'] : 0;
    $starting_number = $max_code + 1;
    $kode_transaksi = $starting_number . "-" . strtoupper(substr($jenis_transaksi, 0, 3));
}

$kode_akun = $_GET['kode_akun'];
$normal = $konektor->query("SELECT * FROM akun WHERE kode_akun = '$kode_akun'");
$tampil = $normal->fetch_assoc();
?>


<div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Transaksi Pembalik Kasbon</h3>
	</div>


	<div class="card shadow mb-">
	<div class="card-header py-2">
		<h3 class="m-0 font-weight-bold text-primary"><a href="?page=transaksi_bank" class="btn btn-primary" >Tambah Data</a>  
		<!-- <a href="?page=transaksi_bank&aksi=transaksi_cancel" class="btn btn-dark" >Transaksi Dibatalkan</a> -->
	</h3>
  </div>

  <div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0"  style="border: 1px solid #dddddd;">
			<tr style="text-align: center; background-color: #f2f2f2;">
				<th>Tanggal</th>
				<th>No. Kasbon</th>
        <th>Th. Ajaran</th>
				<th>Jenjang</th>
				<th>Keterangan</th>
				<th>No Akun</th>       		
				<th>Akun</th>	
				<th>Debit</th>
				<th>Kredit</th>
			</tr>	

<?php
foreach ($rows as $row) {
    ?>
    <tr>
        <td><?php echo $row['tanggal']; ?></td>
        <td><?php echo $row['no_kasbon']; ?></td>
        <td><?php echo $row['tahun_ajaran']; ?></td>
        <td><?php echo $row['nama_jenjang']; ?></td>
        <td><?php echo $row['keterangan']; ?></td>
        <td><?php echo $row['kode_akun']; ?></td>  
        <td><?php echo $row['nama_akun']; ?></td>
        <td>Rp. <?php echo number_format($row['debit'], 0, ',', '.'); ?></td>
        <td>Rp. <?php echo number_format($row['kredit'], 0, ',', '.'); ?></td>
    </tr>
<?php } ?>
</tbody>
</div>
</div>

	</div>
      <div class="row">    
      <div class="col-md-12">
      <div class="card card-primary">
      <div class="card-body">		
      <form method="POST" enctype="multipart/form-data">

      <div class="form-group row" style="display: none;">
          <label for="nama" class="col-sm-2"><b>Jenis Transaksi</b></label>
          <select name="jenis_transaksi" id="jenis_transaksi" class="form-control col-sm-9" onchange="updateKodeTransaksi()" required>
              <option value="Penerimaan">Penerimaan</option>
          </select>
      </div>
  
      <input type="hidden" name="no_transaksi" id="no_transaksi" value="<?= $kode_transaksi ?>" class="form-control col-sm-9">
  

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
            <span class="col-1"></span><input type="hidden" class="form-control col-sm-4" id="tahun_ajaran" readonly>
          </div>
  
  
          <div class="form-group row">
          <label for="nama" class="col-sm-2"><b>No Kas Bon</b></label>
            <input type="number" name="no_kasbon" id="no_kasbon" class="form-control col-sm-9" placeholder="Input No Kas Bon">
          </div>
  
          <div class="form-group row" style="display: none;">
          <label for="nama" class="col-sm-2"><b>Status</b></label>
            <select name="status" id="status" class="form-control col-sm-9" readonly>
              <option value="1">Aktif</option>
            </select>
          </div>
          
          
		<div class="table-responsive">
            <table class="table table-bordered table-hover">
              <tr id="input" style="text-align: center; background-color: #f2f2f2;"><br>
                <th style="text-align:center">Akun</th>
                <th style="text-align:center">Jenjang</th>
                <th style="text-align:center">Keterangan</th>
                <th style="text-align:center">Debit</th>
                <th style="text-align:center">Kredit</th>
              </tr>

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
                <select class="form-control select2" name="kode_jenjang1" id="kode_jenjang1" >
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

              <th><input style="text-align:center" type="text" class="form-control" name="saldo3" id="saldo3" oninput="formatNumber(this); calculateTotal();" ></th>
              <th><input style="text-align:center" type="text" class="form-control" name="saldo4" id="saldo4" oninput="formatNumber(this); calculateTotal();" ></th>

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
              <th>
                <select class="form-control select2" name="kode_jenjang3" id="kode_jenjang3">
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
                <input type="hidden" id="nama_jenjang3" readonly>
              </th>

              <th><input type="text" name="keterangan3" id="keterangan3" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo5" id="saldo5" oninput="formatNumber(this); calculateTotal();" ></th>
              <th><input style="text-align:center" type="text" class="form-control" name="saldo6" id="saldo6" oninput="formatNumber(this); calculateTotal();" ></th>

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
              <th>
                <select class="form-control select2" name="kode_jenjang4" id="kode_jenjang4">
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
                <input type="hidden" id="nama_jenjang4" readonly>
              </th>

              <th><input type="text" name="keterangan4" id="keterangan4" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo7" id="saldo7" oninput="formatNumber(this); calculateTotal();" ></th>
              <th><input style="text-align:center" type="text" class="form-control" name="saldo8" id="saldo8" oninput="formatNumber(this); calculateTotal();" ></th>

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
              <th>
                <select class="form-control select2" name="kode_jenjang5" id="kode_jenjang5">
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
                <input type="hidden" id="nama_jenjang5" readonly>
              </th>

              <th><input type="text" name="keterangan5" id="keterangan5" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo9" id="saldo9" oninput="formatNumber(this); calculateTotal();" ></th>
              <th><input style="text-align:center" type="text" class="form-control" name="saldo10" id="saldo10" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>
              <tr id="input">
              <th style="text-align:center" colspan="3"> Total </th>
              <th><input style="text-align:center" type="text" class="form-control" id="total" name="total" readonly></th>                      
              <th><input style="text-align:center" type="text" class="form-control" id="total2" name="total2" readonly></th>
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
                    <?php if ($total == $total2): ?>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" onclick="removeFormatFromSaldoInputs()">
                        <a href="?page=transaksi_bank&aksi=data" class="btn btn-success">Transaksi Terbuat</a> 
                    <?php else: ?>
                        <p style="color: red;">Nominal yang dimasukkan tidak seimbang.</p>
                    <?php endif; ?>
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

  $kode_akun = $_POST['kode_akun'];
  $kode_akun2 = $_POST['kode_akun2'];
  $kode_akun3 = $_POST['kode_akun3'];
  $kode_akun4 = $_POST['kode_akun4'];
  $kode_akun5 = $_POST['kode_akun5'];

  $kode_jenjang1 = $_POST['kode_jenjang1'];
  $kode_jenjang2 = $_POST['kode_jenjang2'];
  $kode_jenjang3 = $_POST['kode_jenjang3'];
  $kode_jenjang4 = $_POST['kode_jenjang4'];
  $kode_jenjang5 = $_POST['kode_jenjang5'];

  $keterangan1 = $_POST['keterangan1'];
  $keterangan2 = $_POST['keterangan2'];
  $keterangan3 = $_POST['keterangan3'];
  $keterangan4 = $_POST['keterangan4'];
  $keterangan5 = $_POST['keterangan5'];

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

    $query_jenjang1 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang1'";
    $result_jenjang1 = $konektor->query($query_jenjang1);
    $data_jenjang1 = $result_jenjang1->fetch_assoc();
    $nama_jenjang1 = $data_jenjang1['nama_jenjang'];

    $query_jenjang2 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang2'";
    $result_jenjang2 = $konektor->query($query_jenjang2);
    $data_jenjang2 = $result_jenjang2->fetch_assoc();
    $nama_jenjang2 = $data_jenjang2['nama_jenjang'];

    $query_jenjang3 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang3'";
    $result_jenjang3 = $konektor->query($query_jenjang3);
    $data_jenjang3 = $result_jenjang3->fetch_assoc();
    $nama_jenjang3 = $data_jenjang3['nama_jenjang'];

    $query_jenjang4 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang4'";
    $result_jenjang4 = $konektor->query($query_jenjang4);
    $data_jenjang4 = $result_jenjang4->fetch_assoc();
    $nama_jenjang4 = $data_jenjang4['nama_jenjang'];

    $query_jenjang5 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang5'";
    $result_jenjang5 = $konektor->query($query_jenjang5);
    $data_jenjang5 = $result_jenjang5->fetch_assoc();
    $nama_jenjang5 = $data_jenjang5['nama_jenjang'];


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

    if((isset($_POST['simpan']))){
      if (!empty($kode_akun) && !empty($kode_akun2)) {
      $insertquery = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana, no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang1','$nama_jenjang1','$kode_tahun','$tahun_ajaran','$keterangan1','$kode_akun','$nama_akun','$saldo1','$saldo2','$no_kasbon')";
      
      $insertquery2 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana, no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang2','$nama_jenjang2','$kode_tahun','','$keterangan2','$kode_akun2','$nama_akun2','$saldo3','$saldo4','$no_kasbon')";
  
      }if (!empty($kode_akun3)) {
      $insertquery = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana, no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang1','$nama_jenjang1','$kode_tahun','$tahun_ajaran','$keterangan1','$kode_akun','$nama_akun','$saldo1','$saldo2','$no_kasbon')";
      
      $insertquery2 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana, no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang2','$nama_jenjang2','$kode_tahun','','$keterangan2','$kode_akun2','$nama_akun2','$saldo3','$saldo4','$no_kasbon')";
  
      $insertquery3 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang3','$nama_jenjang3','$kode_tahun','','$keterangan3','$kode_akun3','$nama_akun3','$saldo5','$saldo6','$no_kasbon')";
    
      }if (!empty($kode_akun4)) {
      $insertquery = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana, no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang1','$nama_jenjang1','$kode_tahun','$tahun_ajaran','$keterangan1','$kode_akun','$nama_akun','$saldo1','$saldo2','$no_kasbon')";
      
      $insertquery2 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana, no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang2','$nama_jenjang2','$kode_tahun','','$keterangan2','$kode_akun2','$nama_akun2','$saldo3','$saldo4','$no_kasbon')";
  
      $insertquery3 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang3','$nama_jenjang3','$kode_tahun','','$keterangan3','$kode_akun3','$nama_akun3','$saldo5','$saldo6','$no_kasbon')";
    
      $insertquery4 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang4','$nama_jenjang4','$kode_tahun','','$keterangan4','$kode_akun4','$nama_akun4','$saldo7','$saldo8','$no_kasbon')";
      
      }if (!empty($kode_akun5)){
      $insertquery = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana, no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','$sumber_dana','$no_transaksi','$kode_jenjang1','$nama_jenjang1','$kode_tahun','$tahun_ajaran','$keterangan1','$kode_akun','$nama_akun','$saldo1','$saldo2','$no_kasbon')";
      
      $insertquery2 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana, no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang2','$nama_jenjang2','$kode_tahun','','$keterangan2','$kode_akun2','$nama_akun2','$saldo3','$saldo4','$no_kasbon')";
  
      $insertquery3 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang3','$nama_jenjang3','$kode_tahun','','$keterangan3','$kode_akun3','$nama_akun3','$saldo5','$saldo6','$no_kasbon')";
    
      $insertquery4 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang4','$nama_jenjang4','$kode_tahun','','$keterangan4','$kode_akun4','$nama_akun4','$saldo7','$saldo8','$no_kasbon')";

      $insertquery5 = "INSERT INTO transaksi_bank (status, jenis_transaksi, tanggal,	sumber_dana,	no_transaksi,	kode_jenjang,	nama_jenjang,	kode_tahun,	tahun_ajaran,	keterangan,	kode_akun,	nama_akun,	debit, kredit, no_kasbon) 
      VALUES('$status','$jenis_transaksi','$tanggal','','$no_transaksi','$kode_jenjang5','$nama_jenjang5','$kode_tahun','','$keterangan5','$kode_akun5','$nama_akun5','$saldo9','$saldo10','$no_kasbon')";
}}

?>        
      <script type="text/javascript">
      alert("Data Berhasil Disimpan");
      window.location.href="?page=transaksi_bank&aksi=data";
      </script>                       
    <?php
    if (mysqli_query($konektor, $insertquery) &&
        mysqli_query($konektor, $insertquery2) && 
        mysqli_query($konektor, $insertquery3) &&
        mysqli_query($konektor, $insertquery4) &&
        mysqli_query($konektor, $insertquery5) &&
        mysqli_query($konektor, $insertquery6) &&
        mysqli_query($konektor, $insertquery7) &&
        mysqli_query($konektor, $insertquery8) &&
        mysqli_query($konektor, $insertquery9) &&
        mysqli_query($konektor, $insertquery10) &&
        mysqli_query($konektor, $insertquery11) &&
        mysqli_query($konektor, $insertquery12) &&
        mysqli_query($konektor, $insertquery13) &&
        mysqli_query($konektor, $insertquery14) &&
        mysqli_query($konektor, $insertquery15)) {
          "Upload sukses";
        } else {
         "Error: " . $sql . "<br>" . mysqli_error($konektor);
        }
      }
        mysqli_close($konektor);
    ?>


<?php
        } else {
            echo "Nomor kasbon $no_kasbon tidak ditemukan";
        }
    } else {
        echo "Error executing SQL query: " . $konektor->error;
    }
} else {
    // Display your original form or an error message
    echo "No kasbon not provided";
}
?>
<!-- Rest of your HTML code for the website -->
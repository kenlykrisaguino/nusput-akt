<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  include $_SERVER['DOCUMENT_ROOT'] . "/aktnusaputera/connect.php";

  if (isset($_POST['get_no_transaksi']) && isset($_POST['jenis_transaksi'])) {
      $jenis_transaksi = $_POST['jenis_transaksi'];

      $query = $konektor->prepare("SELECT MAX(CAST(no_transaksi AS UNSIGNED)) AS max_code FROM transaksi_kas WHERE jenis_transaksi = ?");
      $query->bind_param("s", $jenis_transaksi);
      $query->execute();
      $result = $query->get_result();
      $row = $result->fetch_assoc();

      $max_code = isset($row['max_code']) ? (int) $row['max_code'] : 0;
      $starting_number = $max_code + 1;

      echo $starting_number; 
      exit();
  }
}
    $kode_akun = $_GET['kode_akun'];
    $normal = $konektor->query("SELECT * FROM akun WHERE kode_akun = '$kode_akun'");
    $tampil = $normal->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Transaksi Kas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateKodeTransaksi() {
    var jenisTransaksi = $("#jenis_transaksi").val(); 

    if (jenisTransaksi !== "") {
        $.ajax({
            url: "page/transaksi_kas/input_transaksi.php",
            type: "POST",
            data: { get_no_transaksi: 1, jenis_transaksi: jenisTransaksi },
            success: function(response) {
                console.log("Nomor Transaksi Baru: " + response); 
                $("#no_transaksi").val(response); 
            },
            error: function() {
                alert("Gagal mengambil nomor transaksi.");
            }
        });
    } else {
        $("#no_transaksi").val(""); // Jika tidak memilih jenis transaksi, kosongkan field
    }
}
    </script>
</head>
<body>
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

    <div class="form-group row">
                            <label for="no_transaksi" class="col-sm-2"><b>No Transaksi</b></label>
                            <input type="text" name="kode_transaksi" id="no_transaksi" value="<?php echo $kode_transaksi; ?>" class="form-control col-sm-9" readonly>
                        </div>

    <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Akun</b></label>
          <select name="kode_akun0" id="kode_akun0" class="form-control col-sm-9" readonly>
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
                              </select>
                            </div>


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

        <div class="form-group row" style="display: none;">
        <label for="nama" class="col-sm-2"><b>Status</b></label>
          <select name="status" id="status" class="form-control col-sm-9" readonly>
            <option value="1">Aktif</option>
          </select>
        </div>

        <hr>
        <table class="table table-bordered table-hover">
          <tr id="input" style="text-align: center; background-color: #f2f2f2;">
            <th style="text-align:center">Kode Akun</th>
            <th style="text-align:center">Jenjang</th>
            <th style="text-align:center">Keterangan</th>
            <th style="text-align:center">Jumlah</th>
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
                ?>
            <option value="<?= $kode_akun ?>" data-bank2="<?= $akun ?>" ><?= $kode_akun . ' → ' . $akun ?></option>
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

              <th><input style="text-align:center" type="text" class="form-control" name="saldo2" id="saldo2" oninput="formatNumber(this); calculateTotal();" ></th>

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
                ?>
            <option value="<?= $kode_akun ?>" data-bank3="<?= $akun ?>" ><?= $kode_akun . ' → ' . $akun ?></option>
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

              <th><input style="text-align:center" type="text" class="form-control" name="saldo3" id="saldo3" oninput="formatNumber(this); calculateTotal();" ></th>
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

              <th><input style="text-align:center" type="text" class="form-control" name="saldo4" id="saldo4" oninput="formatNumber(this); calculateTotal();" ></th>

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

              <th><input style="text-align:center" type="text" class="form-control" name="saldo5" id="saldo5" oninput="formatNumber(this); calculateTotal();" ></th>
              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun6" id="kode_akun6" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal6 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank6="<?= $akun ?>" data-saldo-normal6="<?= $saldo_normal6 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun6" id="akun6" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal6" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang6" id="kode_jenjang6">
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
                <input type="hidden" id="nama_jenjang6" readonly>
              </th>

              <th><input type="text" name="keterangan6" id="keterangan6" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo6" id="saldo6" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun7" id="kode_akun7" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal6 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank7="<?= $akun ?>" data-saldo-normal7="<?= $saldo_normal7 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun7" id="akun7" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal7" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang7" id="kode_jenjang7">
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
                <input type="hidden" id="nama_jenjang7" readonly>
              </th>

              <th><input type="text" name="keterangan7" id="keterangan7" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo7" id="saldo7" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun8" id="kode_akun8" >
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
            <option value="<?= $kode_akun ?>" data-bank8="<?= $akun ?>" data-saldo-normal8="<?= $saldo_normal8 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun8" id="akun8" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal8" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang8" id="kode_jenjang8">
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
                <input type="hidden" id="nama_jenjang8" readonly>
              </th>

              <th><input type="text" name="keterangan8" id="keterangan8" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo8" id="saldo8" oninput="formatNumber(this); calculateTotal();" ></th>
              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun9" id="kode_akun9" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal6 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank9="<?= $akun ?>" data-saldo-normal9="<?= $saldo_normal9 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun9" id="akun9" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal9" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang9" id="kode_jenjang9">
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
                <input type="hidden" id="nama_jenjang9" readonly>
              </th>

              <th><input type="text" name="keterangan9" id="keterangan9" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo9" id="saldo9" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun10" id="kode_akun10" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal6 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank10="<?= $akun ?>" data-saldo-normal10="<?= $saldo_normal10 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun10" id="akun10" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal10" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang10" id="kode_jenjang10">
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
                <input type="hidden" id="nama_jenjang10" readonly>
              </th>

              <th><input type="text" name="keterangan10" id="keterangan10" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo10" id="saldo10" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun11" id="kode_akun11" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal6 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank11="<?= $akun ?>" data-saldo-normal11="<?= $saldo_normal11 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun11" id="akun11" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal6" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang11" id="kode_jenjang11">
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
                <input type="hidden" id="nama_jenjang11" readonly>
              </th>

              <th><input type="text" name="keterangan11" id="keterangan11" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo11" id="saldo11" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun12" id="kode_akun12" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal6 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank12="<?= $akun ?>" data-saldo-normal12="<?= $saldo_normal12 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun12" id="akun12" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal12" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang12" id="kode_jenjang12">
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
                <input type="hidden" id="nama_jenjang12" readonly>
              </th>

              <th><input type="text" name="keterangan12" id="keterangan12" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo12" id="saldo12" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun13" id="kode_akun13" >
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
            <option value="<?= $kode_akun ?>" data-bank13="<?= $akun ?>" data-saldo-normal13="<?= $saldo_normal13 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun13" id="akun13" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal13" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang13" id="kode_jenjang13">
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
                <input type="hidden" id="nama_jenjang13" readonly>
              </th>

              <th><input type="text" name="keterangan13" id="keterangan13" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo13" id="saldo13" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun14" id="kode_akun14" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal6 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank14="<?= $akun ?>" data-saldo-normal14="<?= $saldo_normal14 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun14" id="akun14" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal14" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang14" id="kode_jenjang14">
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
                <input type="hidden" id="nama_jenjang14" readonly>
              </th>

              <th><input type="text" name="keterangan14" id="keterangan14" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo14" id="saldo14" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun15" id="kode_akun15" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal6 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank15="<?= $akun ?>" data-saldo-normal15="<?= $saldo_normal15 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun15" id="akun15" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal15" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang15" id="kode_jenjang15">
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
                <input type="hidden" id="nama_jenjang15" readonly>
              </th>

              <th><input type="text" name="keterangan15" id="keterangan15" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo15" id="saldo15" oninput="formatNumber(this); calculateTotal();" ></th>
              </tr>

              <tr id="input">
                <th style="text-align:center" colspan="3"> Total </th>
                <input type="hidden" name="total" id="total" value="">
                <th><input style="text-align:center" type="text" class="form-control" id="totalField" name="totalField" readonly></th>
              </tr>
              </table>
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
          var saldo11 = parseFloat(document.getElementById('saldo11').value.replace(/,/g, '')) || 0;
          var saldo12 = parseFloat(document.getElementById('saldo12').value.replace(/,/g, '')) || 0;
          var saldo13 = parseFloat(document.getElementById('saldo13').value.replace(/,/g, '')) || 0;
          var saldo14 = parseFloat(document.getElementById('saldo14').value.replace(/,/g, '')) || 0;
          var saldo15 = parseFloat(document.getElementById('saldo15').value.replace(/,/g, '')) || 0;

          var total = saldo1 + saldo2 + saldo3 + saldo4 + saldo5 + saldo6 + saldo7 + saldo8 + saldo9 + saldo10 + saldo11 + saldo12 + saldo13 + saldo14 + saldo15;
          var formattedTotal = total.toLocaleString('id-ID');
          document.getElementById('totalField').value = 'Rp. ' + formattedTotal; // Menampilkan dengan format
          document.getElementById('total').value = total; // Menyimpan nilai tanpa format ke input tersembunyi
        }


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
            removeFormat(document.getElementById('saldo11'));
            removeFormat(document.getElementById('saldo12'));
            removeFormat(document.getElementById('saldo13'));
            removeFormat(document.getElementById('saldo14'));
            removeFormat(document.getElementById('saldo15'));
        }
    </script>
    <div class="card-body">
      <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" onclick="removeFormatFromSaldoInputs()"></input> 
      <a href="?page=transaksi_kas&aksi=data" class="btn btn-success">Transaksi Terbuat</a> 
    </div>
    </form>  
</body>
</html>

<?php
include "connect.php";

if (isset($_POST['simpan'])) {
    $jenis_transaksi = $_POST['jenis_transaksi'];
    $kode_akun0 = $_POST['kode_akun0'];
    $kode_transaksi = $_POST['kode_transaksi'];
    $tanggal = $_POST['tanggal'];
    $sumber_dana = $_POST['sumber_dana'];
    $kode_tahun = $_POST['kode_tahun'];
    $status = $_POST['status'];
    $total = $_POST['total'];

    $kode_akun = $_POST['kode_akun'];
    $kode_akun2 = $_POST['kode_akun2'];
    $kode_akun3 = $_POST['kode_akun3'];
    $kode_akun4 = $_POST['kode_akun4'];
    $kode_akun5 = $_POST['kode_akun5'];
    $kode_akun6 = $_POST['kode_akun6'];
    $kode_akun7 = $_POST['kode_akun7'];
    $kode_akun8 = $_POST['kode_akun8'];
    $kode_akun9 = $_POST['kode_akun9'];
    $kode_akun10 = $_POST['kode_akun10'];
    $kode_akun11 = $_POST['kode_akun11'];
    $kode_akun12 = $_POST['kode_akun12'];
    $kode_akun13 = $_POST['kode_akun13'];
    $kode_akun14 = $_POST['kode_akun14'];
    $kode_akun15 = $_POST['kode_akun15'];

 
    $kode_jenjang1 = $_POST['kode_jenjang1'];
    $kode_jenjang2 = $_POST['kode_jenjang2'];
    $kode_jenjang3 = $_POST['kode_jenjang3'];
    $kode_jenjang4 = $_POST['kode_jenjang4'];
    $kode_jenjang5 = $_POST['kode_jenjang5'];
    $kode_jenjang6 = $_POST['kode_jenjang6'];
    $kode_jenjang7 = $_POST['kode_jenjang7'];
    $kode_jenjang8 = $_POST['kode_jenjang8'];
    $kode_jenjang9 = $_POST['kode_jenjang9'];
    $kode_jenjang10 = $_POST['kode_jenjang10'];
    $kode_jenjang11 = $_POST['kode_jenjang11'];
    $kode_jenjang12 = $_POST['kode_jenjang12'];
    $kode_jenjang13 = $_POST['kode_jenjang13'];
    $kode_jenjang14 = $_POST['kode_jenjang14'];
    $kode_jenjang15 = $_POST['kode_jenjang15'];

    $keterangan1 = $_POST['keterangan1'];
    $keterangan2 = $_POST['keterangan2'];
    $keterangan3 = $_POST['keterangan3'];
    $keterangan4 = $_POST['keterangan4'];
    $keterangan5 = $_POST['keterangan5'];
    $keterangan6 = $_POST['keterangan6'];
    $keterangan7 = $_POST['keterangan7'];
    $keterangan8 = $_POST['keterangan8'];
    $keterangan9 = $_POST['keterangan9'];
    $keterangan10 = $_POST['keterangan10'];
    $keterangan11 = $_POST['keterangan11'];
    $keterangan12 = $_POST['keterangan12'];
    $keterangan13 = $_POST['keterangan13'];
    $keterangan14 = $_POST['keterangan14'];
    $keterangan15 = $_POST['keterangan15'];

    $saldo1 = $_POST['saldo1'];
    $saldo2 = $_POST['saldo2'];
    $saldo3 = $_POST['saldo3'];
    $saldo4 = $_POST['saldo4'];
    $saldo5 = $_POST['saldo5'];
    $saldo6 = $_POST['saldo6'];
    $saldo7 = $_POST['saldo7'];
    $saldo8 = $_POST['saldo8'];
    $saldo9 = $_POST['saldo9'];
    $saldo10 = $_POST['saldo10'];;
    $saldo11 = $_POST['saldo11'];
    $saldo12 = $_POST['saldo12'];
    $saldo13 = $_POST['saldo13'];
    $saldo14 = $_POST['saldo14'];
    $saldo15 = $_POST['saldo15'];

    
    $query_akun = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun0'";
    $result_akun = $konektor->query($query_akun);
    $data_akun = $result_akun->fetch_assoc();
    $nama_akun0 = $data_akun['nama_akun'];


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

    $query_akun6 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun6'";
    $result_akun6 = $konektor->query($query_akun6);
    $data_akun6 = $result_akun6->fetch_assoc();
    $nama_akun6 = $data_akun6['nama_akun'];

    $query_akun7 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun7'";
    $result_akun7 = $konektor->query($query_akun7);
    $data_akun7 = $result_akun7->fetch_assoc();
    $nama_akun7 = $data_akun7['nama_akun'];

    $query_akun8 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun8'";
    $result_akun8 = $konektor->query($query_akun8);
    $data_akun8 = $result_akun8->fetch_assoc();
    $nama_akun8 = $data_akun8['nama_akun'];

    $query_akun9 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun9'";
    $result_akun9 = $konektor->query($query_akun4);
    $data_akun9 = $result_akun9->fetch_assoc();
    $nama_akun9 = $data_akun9['nama_akun'];

    $query_akun10 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun10'";
    $result_akun10 = $konektor->query($query_akun5);
    $data_akun10 = $result_akun10->fetch_assoc();
    $nama_akun10 = $data_akun10['nama_akun'];

    $query_akun11 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun11'";
    $result_akun11 = $konektor->query($query_akun11);
    $data_akun11 = $result_akun11->fetch_assoc();
    $nama_akun11 = $data_akun11['nama_akun'];

    $query_akun12 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun12'";
    $result_akun12 = $konektor->query($query_akun12);
    $data_akun12 = $result_akun12->fetch_assoc();
    $nama_akun12 = $data_akun12['nama_akun'];

    $query_akun13 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun13'";
    $result_akun13 = $konektor->query($query_akun13);
    $data_akun13 = $result_akun13->fetch_assoc();
    $nama_akun13 = $data_akun13['nama_akun'];

    $query_akun14 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun14'";
    $result_akun14 = $konektor->query($query_akun14);
    $data_akun14 = $result_akun14->fetch_assoc();
    $nama_akun14 = $data_akun14['nama_akun'];

    $query_akun15 = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun15'";
    $result_akun15 = $konektor->query($query_akun15);
    $data_akun15 = $result_akun15->fetch_assoc();
    $nama_akun15 = $data_akun15['nama_akun'];


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

    $query_jenjang6 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang6'";
    $result_jenjang6 = $konektor->query($query_jenjang6);
    $data_jenjang6 = $result_jenjang6->fetch_assoc();
    $nama_jenjang6 = $data_jenjang6['nama_jenjang'];

    $query_jenjang7 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang7'";
    $result_jenjang7 = $konektor->query($query_jenjang7);
    $data_jenjang7 = $result_jenjang7->fetch_assoc();
    $nama_jenjang7 = $data_jenjang7['nama_jenjang'];

    $query_jenjang8 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang8'";
    $result_jenjang8 = $konektor->query($query_jenjang8);
    $data_jenjang8 = $result_jenjang8->fetch_assoc();
    $nama_jenjang8 = $data_jenjang8['nama_jenjang'];

    $query_jenjang9 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang9'";
    $result_jenjang9 = $konektor->query($query_jenjang9);
    $data_jenjang9 = $result_jenjang9->fetch_assoc();
    $nama_jenjang9 = $data_jenjang9['nama_jenjang'];

    $query_jenjang10 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang10'";
    $result_jenjang10 = $konektor->query($query_jenjang10);
    $data_jenjang10 = $result_jenjang10->fetch_assoc();
    $nama_jenjang10 = $data_jenjang10['nama_jenjang'];

    $query_jenjang11 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang11'";
    $result_jenjang11 = $konektor->query($query_jenjang11);
    $data_jenjang11 = $result_jenjang11->fetch_assoc();
    $nama_jenjang11 = $data_jenjang11['nama_jenjang'];

    $query_jenjang12 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang12'";
    $result_jenjang12 = $konektor->query($query_jenjang12);
    $data_jenjang12 = $result_jenjang12->fetch_assoc();
    $nama_jenjang12 = $data_jenjang12['nama_jenjang'];

    $query_jenjang13 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang13'";
    $result_jenjang13 = $konektor->query($query_jenjang13);
    $data_jenjang13 = $result_jenjang13->fetch_assoc();
    $nama_jenjang13 = $data_jenjang13['nama_jenjang'];

    $query_jenjang14 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang14'";
    $result_jenjang14 = $konektor->query($query_jenjang14);
    $data_jenjang14 = $result_jenjang14->fetch_assoc();
    $nama_jenjang14 = $data_jenjang14['nama_jenjang'];

    $query_jenjang15 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang15'";
    $result_jenjang15 = $konektor->query($query_jenjang15);
    $data_jenjang15 = $result_jenjang15->fetch_assoc();
    $nama_jenjang15 = $data_jenjang15['nama_jenjang'];


    $query_tahun = "SELECT tahun_ajaran FROM th_ajaran WHERE kode_tahun='$kode_tahun'";
    $result_tahun = $konektor->query($query_tahun);
    $data_tahun = $result_tahun->fetch_assoc();
    $tahun_ajaran = $data_tahun['tahun_ajaran'];


    if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  
    
    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  
    

    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun2)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')"; 
      
      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";  

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun2)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 


    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun3)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun3)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";


    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun4)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";          

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun4)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";
    

    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun5)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun5)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";  
      
      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";


    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun6)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";


    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun6)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";
      
      $insertquery7  = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";


    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun7)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun7)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";


    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun8)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";


    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun8)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";


    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun9)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun9)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";

      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";


    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun10)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun10)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";
   

    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun11)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun11)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";
  
      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";
  
      
    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun12)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";

      $insertquery13 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang12','$nama_jenjang12','','$keterangan12','$kode_akun12','$nama_akun12','$saldo12')";

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun12)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";

      $insertquery13 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang12','$nama_jenjang12','','$keterangan12','$kode_akun12','$nama_akun12','$saldo12')";
  

    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun13)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";

      $insertquery13 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang12','$nama_jenjang12','','$keterangan12','$kode_akun12','$nama_akun12','$saldo12')";

      $insertquery14 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang13','$nama_jenjang13','','$keterangan13','$kode_akun13','$nama_akun13','$saldo13')";

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun13)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";
  
      $insertquery13 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang12','$nama_jenjang12','','$keterangan12','$kode_akun12','$nama_akun12','$saldo12')";

      $insertquery14 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang13','$nama_jenjang13','','$keterangan13','$kode_akun13','$nama_akun13','$saldo13')";


    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun14)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";

      $insertquery13 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang12','$nama_jenjang12','','$keterangan12','$kode_akun12','$nama_akun12','$saldo12')";

      $insertquery14 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang13','$nama_jenjang13','','$keterangan13','$kode_akun13','$nama_akun13','$saldo13')";

      $insertquery15 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang14','$nama_jenjang14','','$keterangan14','$kode_akun14','$nama_akun14','$saldo14')";


    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun14)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";
  
      $insertquery13 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang12','$nama_jenjang12','','$keterangan12','$kode_akun12','$nama_akun12','$saldo12')";

      $insertquery14 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang13','$nama_jenjang13','','$keterangan13','$kode_akun13','$nama_akun13','$saldo13')";

      $insertquery15 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang14','$nama_jenjang14','','$keterangan14','$kode_akun14','$nama_akun14','$saldo14')";


    } if ($jenis_transaksi === 'Penerimaan' && !empty($kode_akun15)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";  

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')";
      
      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')"; ;

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";

      $insertquery13 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang12','$nama_jenjang12','','$keterangan12','$kode_akun12','$nama_akun12','$saldo12')";

      $insertquery14 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang13','$nama_jenjang13','','$keterangan13','$kode_akun13','$nama_akun13','$saldo13')";

      $insertquery15 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang14','$nama_jenjang14','','$keterangan14','$kode_akun14','$nama_akun14','$saldo14')";

      $insertquery16 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang15','$nama_jenjang15','','$keterangan15','$kode_akun15','$nama_akun15','$saldo15')";

    } if ($jenis_transaksi === 'Pengeluaran' && !empty($kode_akun15)) {
      $insertquery1 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, kredit)
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','','','$sumber_dana','','$kode_akun0','$nama_akun0','$total')";
      
      $insertquery2 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang1','$nama_jenjang1','','$keterangan1','$kode_akun','$nama_akun','$saldo1')";

      $insertquery3 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang2','$nama_jenjang2','','$keterangan2','$kode_akun2','$nama_akun2','$saldo2')"; 

      $insertquery4 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang3','$nama_jenjang3','','$keterangan3','$kode_akun3','$nama_akun3','$saldo3')";

      $insertquery5 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang4','$nama_jenjang4','','$keterangan4','$kode_akun4','$nama_akun4','$saldo4')";

      $insertquery6 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang5','$nama_jenjang5','','$keterangan5','$kode_akun5','$nama_akun5','$saldo5')";

      $insertquery7 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang6','$nama_jenjang6','','$keterangan6','$kode_akun6','$nama_akun6','$saldo6')";

      $insertquery8 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang7','$nama_jenjang7','','$keterangan7','$kode_akun7','$nama_akun7','$saldo7')";

      $insertquery9 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang8','$nama_jenjang8','','$keterangan8','$kode_akun8','$nama_akun8','$saldo8')";

      $insertquery10 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang9','$nama_jenjang9','','$keterangan9','$kode_akun9','$nama_akun9','$saldo9')";

      $insertquery11 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang10','$nama_jenjang10','','$keterangan10','$kode_akun10','$nama_akun10','$saldo10')";

      $insertquery12 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang11','$nama_jenjang11','','$keterangan11','$kode_akun11','$nama_akun11','$saldo11')";
  
      $insertquery13 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang12','$nama_jenjang12','','$keterangan12','$kode_akun12','$nama_akun12','$saldo12')";

      $insertquery14 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang13','$nama_jenjang13','','$keterangan13','$kode_akun13','$nama_akun13','$saldo13')";

      $insertquery15 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang14','$nama_jenjang14','','$keterangan14','$kode_akun14','$nama_akun14','$saldo14')";

      $insertquery16 = "INSERT INTO transaksi_kas (status, jenis_transaksi, no_transaksi, tanggal, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, sumber_dana, keterangan, kode_akun, nama_akun, debit) 
      VALUES('$status','$jenis_transaksi','$kode_transaksi','$tanggal','$kode_tahun','$tahun_ajaran','$kode_jenjang15','$nama_jenjang15','','$keterangan15','$kode_akun15','$nama_akun15','$saldo15')";

    }

    ?>                      
      <script type="text/javascript">
      alert("Data Berhasil Disimpan");
      window.location.href="?page=transaksi_kas&aksi=data";
      </script>                       
    <?php
        if (mysqli_query($konektor, $insertquery1) && 
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
        mysqli_query($konektor, $insertquery15) &&
        mysqli_query($konektor, $insertquery16)) {
          "Upload sukses";
        } else {
        "Error: " . $sql . "<br>" . mysqli_error($konektor);
        }
      }
        mysqli_close($konektor);
    ?>
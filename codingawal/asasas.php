
    <div class="container-fluid">
    <div class="card shadow mb-2">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Transaksi Bank</h3>
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

    <input type="hidden" name="no_transaksi" id="no_transaksi" value="<?= $kode_transaksi ?>" class="form-control col-sm-9" readonly>



        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Akun Bank</b></label>
          <select name="akun_bank" id="akun_bank" class="form-control col-sm-4" required>
          <option value="">Pilih Akun Bank</option>
          </select>
          <span class="col-1"></span>
          <input type="text" class="form-control col-sm-4" id="nama_akun" readonly>
</div>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tanggal</b></label>
          <input type="date" name="tanggal" id="tanggal" class="form-control col-sm-9" required="">
        </div>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Sumber Dana</b></label>
          <select name="sumber_dana" id="sumber_dana" class="form-control col-sm-9" required>
            <option value="">Pilih Sumber Dana</option>
            <option value="Rutin">Rutin</option>
            <option value="Bantuan">Bantuan</option>
          </select>
        </div>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Jenjang</b></label>
          <select class="form-control select2 col-sm-4" name="kode_jenjang" id="kode_jenjang" required="">
          <option value="">Pilih Jenjang</option>
          </select>
          <span class="col-1"></span>
          <input type="text" class="form-control col-sm-4" id="nama_jenjang" readonly>
        </div>


        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tahun Ajaran</b></label>
          <select class="form-control select2 col-sm-4" name="kode_tahun" id="kode_tahun" required="">
          <option value="">Pilih Tahun Ajaran</option>
          </select>
          <span class="col-1"></span>
          <input type="text" class="form-control col-sm-4" id="tahun_ajaran" readonly>
        </div>


        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>No Kas Bon</b></label>
          <input type="text" name="no_kasbon" id="no_kasbon" class="form-control col-sm-9" placeholder="Input No Kas Bon">
        </div>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Keterangan</b></label>
          <input type="text" name="keterangan" id="keterangan" class="form-control col-sm-9" placeholder="Input Keterangan">
        </div>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Status</b></label>
          <select name="status" id="status" class="form-control col-sm-9" readonly>
            <option value="1">Aktif</option>
          </select>
        </div>


        <hr>
        <table class="table table-bordered table-hover">
          <tr id="input">
            <th style="text-align:center"> Kode Akun</th>
            <th style="text-align:center"> Nama Akun</th>
            <th style="text-align:center"> Jumlah</th>
          </tr>
          <tr>
            <th>
            <select class="form-control select2" name="kode_akun" id="kode_akun" required>
              <option value="">Pilih Akun</option>
            </select>
            </th>
            
            <th><input style="text-align:center" type="text" class="form-control" name="akun" id="akun" readonly></th>


            <th><input style="text-align:center" type="number" class="form-control" name="saldo" id="saldo" value="0" min="0" required=""></th>
          </tr>
        </table>
        </div>
            
            <div class="card-body">
              <input type="submit" name="simpan" value="Simpan" class="btn btn-primary"></input> <a href="?page=transaksi_bank&aksi=data" class="btn btn-success" >Transaksi Terbuat</a>
            </div>
    </form>
          
<?php
include "connect.php";

if (isset($_POST['simpan'])) {
    $jenis_transaksi = $_POST['jenis_transaksi'];
    $kode_akun = $_POST['kode_akun'];
    $akun_bank = $_POST['akun_bank'];
    $no_transaksi = $_POST['no_transaksi'];
    $tanggal = $_POST['tanggal'];
    $sumber_dana = $_POST['sumber_dana'];
    $kode_tahun = $_POST['kode_tahun'];
    $kode_jenjang = $_POST['kode_jenjang'];
    $no_kasbon = $_POST['no_kasbon'];
    $keterangan = $_POST['keterangan'];
    $saldo = $_POST['saldo'];
    $status = $_POST['status'];
    
    if ($jenis_transaksi == 'Penerimaan') {
        $insertquery = "INSERT INTO transaksi_bank (no_transaksi, jenis_transaksi, kode_akun, nama_akun, akun_bank, nama_bank, tanggal, sumber_dana, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, no_kasbon, keterangan, kredit, status) 
        VALUES('$kode_transaksi', '$jenis_transaksi','$kode_akun','$nama_akun','$akun_bank','$nama_bank','$tanggal','$sumber_dana','$kode_tahun','$tahun_ajaran','$kode_jenjang','$nama_jenjang', '$no_kasbon','$keterangan','$saldo','$status')";
        $updatequery = "UPDATE akun SET saldo=saldo+'$saldo' WHERE kode_akun='$akun_bank' OR kode_akun='$kode_akun'";

    } else if ($jenis_transaksi == 'Pengeluaran') {
      $insertquery = "INSERT INTO transaksi_bank (no_transaksi, jenis_transaksi, kode_akun, nama_akun, akun_bank, nama_bank, tanggal, sumber_dana, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, no_kasbon, keterangan, debit, status) 
      VALUES('$kode_transaksi', '$jenis_transaksi','$kode_akun','$nama_akun','$akun_bank','$nama_bank','$tanggal','$sumber_dana','$kode_tahun','$tahun_ajaran','$kode_jenjang','$nama_jenjang', '$no_kasbon','$keterangan','$saldo', '$status')";
        $updatequery = "UPDATE akun SET saldo=saldo-'$saldo' WHERE kode_akun='$akun_bank'";
        $updatequery2 = "UPDATE akun SET saldo=saldo+'$saldo' WHERE kode_akun='$kode_akun'";
    }
  

?>                      
  <script type="text/javascript">
  alert("Data Berhasil Disimpan");
  window.location.href="?page=transaksi_bank&aksi=data";
  </script>                       
<?php
    if (mysqli_query($konektor, $insertquery) && mysqli_query($konektor, $updatequery) && mysqli_query($konektor, $updatequery2)) {
      "Upload sukses";
	  } else {
		 "Error: " . $sql . "<br>" . mysqli_error($konektor);
	  }
	}
	  mysqli_close($konektor);
?>

cara update saldo dari tabel akun  jika ada kolom saldo_normal maka perhitungannya jika jenis transaksi penerimaan dan saldo_normal= kredit maka saldo bertambah, tapi ketika saldo_normal = debit maka saldo akan berkurang


<div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Akun Bank</b></label>
          <select name="akun_bank" id="akun_bank" class="form-control col-sm-4" required>
          <option value="">Pilih Akun Bank</option>
        <?php
        $query = "SELECT * from akun WHERE nama_akun LIKE 'bank%'";
        $result = $konektor->query($query);
        if ($result && $result->num_rows > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
                $kode_akun = $data['kode_akun'];
                $nama_akun = $data['nama_akun'];
        ?>
          <option value="<?= $kode_akun ?>" data-nama="<?= $nama_akun ?>"><?= $kode_akun. ' → ' .$nama_akun ?></option>
        <?php
            }}
        ?>
          </select>
          <span class="col-1"></span>
          <input type="text" class="form-control col-sm-4" id="nama_akun" readonly>
        </div>
        <script>
          var selectAkunBank = document.getElementById("akun_bank");
          var inputNamaAkunBank = document.getElementById("nama_akun");

          selectAkunBank.addEventListener("change", function () {
            var selectedOption = selectAkunBank.options[selectAkunBank.selectedIndex];
            inputNamaAkunBank.value = selectedOption.getAttribute("data-nama");
          });
        </script>

cara agar kolom saldo_normal dari tabel akun masuk ke form tapi tidak tertampil saat menekan pilihan di dropdown
            <th>
            <select class="form-control select2" name="kode_akun" id="kode_akun" required>
              <option value="">Pilih Akun</option>
            <?php
            $query = "SELECT * FROM akun WHERE nama_akun NOT LIKE '%bank%'";
            $result = $konektor->query($query);
            $num_result = $result->num_rows;
            if ($num_result > 0) {
                while ($data = $result->fetch_assoc()) {
                    $kode_akun = $data['kode_akun'];
                    $akun = $data['nama_akun'];
            ?>
              <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>"><?= $kode_akun . ' → ' . $akun ?></option>
            <?php
                }}
            ?>
            </select>
            </th>
            
            <th><input style="text-align:center" type="text" class="form-control" name="akun" id="akun" readonly>
            <input type="text" class="form-control col-sm-9" id="saldo_normal" readonly>
</th>

            <script>
              var selectAkun = document.getElementById("kode_akun");
              var inputNamaAkun = document.getElementById("akun");

              selectAkun.addEventListener("change", function () {
                  var selectedOption = selectAkun.options[selectAkun.selectedIndex];
                  inputNamaAkun.value = selectedOption.getAttribute("data-bank");
              });
            </script>
cara agar kolom saldo_normal dari tabel akun masuk ke form tapi tidak tertampil saat menekan pilihan di dropdown


<div class="container-fluid">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Laporan Tunggakan Kasbon</h3>
        </div>

        <div class="card shadow mb-">
            <div class="card-header py-2">
                <a href="page/jenjang/export.php" class="btn btn-success">Export ke Excel</a>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="">
                <div class="form-group row">
                    <label for="periode_start" class="col-sm-2 col-form-label">Periode Mulai</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="periode_start" id="periode_start" required>
                    </div>
                    <label for="periode_end" class="col-sm-2 col-form-label">Periode Akhir</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="periode_end" id="periode_end" required>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Jenis Transaksi</th>
                            <th>No Bukti</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Kode Akun</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                            <th>No Kasbon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["periode_start"]) && isset($_GET["periode_end"])) {
                            $periode_start = $_GET["periode_start"];
                            $periode_end = $_GET["periode_end"];
                            $sql = $konektor->query("SELECT * FROM transaksi_bank WHERE tanggal BETWEEN '$periode_start' AND '$periode_end'");
                        } else {
                            $sql = $konektor->query("SELECT * FROM transaksi_bank");
                        }

                        while ($data = $sql->fetch_assoc()) {
                            $jenisTransaksi = $data['jenis_transaksi'];
                            $rowClass = ($jenisTransaksi == 'Penerimaan') ? 'table-secondary' : 'table-light';

                            if ($data['status'] == 1 && !empty($data['no_kasbon'])) {
                                ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td><?php echo $data['jenis_transaksi'] ?></td>
                                    <td><?php echo $data['no_transaksi'] ?></td>
                                    <td><?php echo $data['tanggal'] ?></td>
                                    <td><?php echo $data['keterangan'] ?></td>
                                    <td><?php echo $data['kode_akun'] ?></td>
                                    <td>Rp. <?= number_format($data['kredit'], 0, ',', '.'); ?></td>
                                    <td>Rp. <?= number_format($data['debit'], 0, ',', '.'); ?></td>
                                    <td>Aktif</td>
                                    <td><?php echo $data['no_kasbon'] ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</script>

<th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun";
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
                            <input type="text" class="form-control col-sm-4" id="saldo_normal" readonly>
                            <script>
                                var selectAkun = document.getElementById("kode_akun");
                                var inputNamaAkun = document.getElementById("akun");
                                var inputSaldoNormal = document.getElementById("saldo_normal");

                                selectAkun.addEventListener("change", function () {
                                    var selectedOption = selectAkun.options[selectAkun.selectedIndex];
                                    inputNamaAkun.value = selectedOption.getAttribute("data-bank");
                                    inputSaldoNormal.value = selectedOption.getAttribute("data-saldo-normal"); 
                                });
                            </script>

                            <th><input style="text-align:center" type="text" class="form-control" name="saldo1" id="saldo1" value="0" oninput="formatNumber(this); calculateTotal();" required></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo2" id="saldo2" value="0" oninput="formatNumber(this); calculateTotal();" required></th>

                            </tr>
                            <?php

                            include "connect.php";

if (isset($_POST['simpan'])) 
    $kode_akun = $_POST['kode_akun'];
    $saldo1 = $_POST['saldo1'];
    $saldo2 = $_POST['saldo2'];


    // $query_akun = "SELECT nama_akun FROM akun WHERE kode_akun='$kode_akun'";
    // $result_akun = $konektor->query($query_akun);
    // $data_akun = $result_akun->fetch_assoc();
    // $nama_akun = $data_akun['nama_akun'];


    // if((isset($_POST['simpan']))){
    //   $insertquery = "INSERT INTO transaksi_memorial (kode_akun,	nama_akun,	debit, kredit) 
    //   VALUES('$kode_akun','$nama_akun','$saldo1','$saldo2')";

    //     if ($saldo_normal == 'Debit') {
    //       $updatequery1 = "UPDATE akun SET saldo=saldo+'$saldo1' WHERE kode_akun='$kode_akun'";
    //       $updatequery2 = "UPDATE akun SET saldo=saldo-'$saldo2' WHERE kode_akun='$kode_akun'";
    //     } else if ($saldo_normal == 'Kredit') {
    //       $updatequery3 = "UPDATE akun SET saldo=saldo-'$saldo1' WHERE kode_akun='$kode_akun'";
    //       $updatequery4 = "UPDATE akun SET saldo=saldo+'$saldo2' WHERE kode_akun='$kode_akun'";  
    //     }
    //   }
    //                  

    //     alert("Data Berhasil Disimpan");
    //     window.location.href="?page=transaksi_memorial&aksi=data";
    //     </script>                       
   
    //   if (mysqli_query($konektor, $insertquery) && 
    //   mysqli_query($konektor, $updatequery1) &&
    //   mysqli_query($konektor, $updatequery2) &&
    //   mysqli_query($konektor, $updatequery3) &&
    //   mysqli_query($konektor, $updatequery4)) {
    //         "Upload sukses";
    //       } else {
    //        "Error: " . $sql . "<br>" . mysqli_error($konektor);
    //       }
    //     }
    //       mysqli_close($konektor);
    //   ?>

<!-- bagaimana caranya jika saldo1 saldo_normal nya kredit maka saldo di tabel akun akan berkurang, lalu jika saldo1 saldo_normal nya di debit maka saldo di tabel akun akan bertambah, jika saldo2 saldo_normal di debit maka saldo di tabel akun akan berkurang, lalu jika saldo2 saldo_normal nya di kredit maka saldo di tabel akun akan bertambah

if (isset($_POST['simpan'])) 
    // ... (kode sebelumnya)

    if (!empty($saldo1) || !empty($saldo2) || !empty($saldo3) || !empty($saldo4) || !empty($saldo5) || !empty($saldo6) || !empty($saldo7) || !empty($saldo8) || !empty($saldo9) || !empty($saldo10)) {
        // Lakukan operasi insert dan update hanya jika setidaknya satu input telah diisi
        if (!empty($saldo1)) {
            // ... (kode update dan insert sebelumnya)
        }

        // Lakukan hal yang sama untuk input lainnya...
        
        ?> -->
        <!-- <script type="text/javascript">
            alert("Data Berhasil Disimpan");
            window.location.href="?page=transaksi_memorial&aksi=data";
        </script>
        php
     else 
        ?>
        <script type="text/javascript">
            alert("Harap isi minimal salah satu input.");
        </script>
        <php -->
  

<!-- <div class="card-body">
    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" onclick="validateAndSubmit()"></input>
    <a href="?page=transaksi_memorial&aksi=data" class="btn btn-success">Transaksi Terbuat</a>
</div>

<script>
    function validateAndSubmit() {
        var inputSaldo3 = document.getElementById("saldo3").value;
        var inputSaldo4 = document.getElementById("saldo4").value;

        if (inputSaldo3 !== "" || inputSaldo4 !== "") {
            removeFormatFromSaldoInputs();
            document.getElementById("form").submit();
        } else {
            alert("Harap isi minimal salah satu input.");
        }
    }
</script>

<select class="form-control select2" name="kode_akun3" id="kode_akun3" required>
    <!-- Options... 
</select>
<input style="text-align:center" type="text" class="form-control" name="saldo5" id="saldo5" value="0" oninput="formatNumber(this); calculateTotal();" required>

<select class="form-control select2" name="kode_akun4" id="kode_akun4" required>
    <!-- Options... 
</select>
<input style="text-align:center" type="text" class="form-control" name="saldo7" id="saldo7" value="0" oninput="formatNumber(this); calculateTotal();" required>

<select class="form-control select2" name="kode_akun5" id="kode_akun5" required>
    <!-- Options... 
</select>
<input style="text-align:center" type="text" class="form-control" name="saldo9" id="saldo9" value="0" oninput="formatNumber(this); calculateTotal();" required>

<div class="card-body">
    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" onclick="validateAndSubmit()"></input>
    <a href="?page=transaksi_memorial&aksi=data" class="btn btn-success">Transaksi Terbuat</a>
</div>

<script>
    function validateAndSubmit() {
        var inputSaldo5 = document.getElementById("saldo5").value;
        var inputSaldo7 = document.getElementById("saldo7").value;
        var inputSaldo9 = document.getElementById("saldo9").value;

        var formAkun3 = document.getElementById("kode_akun3").value;
        var formAkun4 = document.getElementById("kode_akun4").value;
        var formAkun5 = document.getElementById("kode_akun5").value;

        if ((formAkun3 === "" && formAkun4 === "" && formAkun5 === "") || 
            (!inputSaldo5 && !inputSaldo7 && !inputSaldo9)) {
            alert("Harap isi minimal satu form.");
        } else {
            removeFormatFromSaldoInputs();
            document.getElementById("form").submit();
        }
    }
</script> -->
<!-- ?php
if (isset($_POST['simpan'])) {
  // ... (kode sebelumnya)

  if ((!empty($saldo1) || !empty($saldo2)) || 
      (!empty($saldo3) || !empty($saldo4)) ||
      (!empty($saldo5) || !empty($saldo6)) || 
      (!empty($saldo7) || !empty($saldo8)) ||
      (!empty($saldo9) || !empty($saldo10))) {
      // Lakukan operasi insert dan update hanya jika setidaknya satu input telah diisi
      if (!empty($saldo1)) {
          // ... (kode update dan insert sebelumnya)
      }

      // Lakukan hal yang sama untuk input lainnya...
      
      ?>
      <script type="text/javascript">
          alert("Data Berhasil Disimpan");
          window.location.href="?page=transaksi_memorial&aksi=data";
      </script>
      ?php
  } else {
      ?>
      <script type="text/javascript">
          alert("Harap isi minimal satu form.");
      </script>
      ?php
  }

  // ... (kode setelahnya)
}
?> -->
        
<!-- 
if ($saldo_normal2 == 'Debit') {          
  $updatequery3 = "UPDATE akun SET saldo=saldo+'$saldo3' WHERE kode_akun='$kode_akun2'";
  $updatequery4 = "UPDATE akun SET saldo=saldo-'$saldo4' WHERE kode_akun='$kode_akun2'";
} else if ($saldo_normal2 == 'Kredit') {
  $updatequery13 = "UPDATE akun SET saldo=saldo-'$saldo3' WHERE kode_akun='$kode_akun2'";
  $updatequery14 = "UPDATE akun SET saldo=saldo+'$saldo4' WHERE kode_akun='$kode_akun2'";
}  

  if ($saldo_normal3 == 'Debit') {
  $updatequery5 = "UPDATE akun SET saldo=saldo+'$saldo5' WHERE kode_akun='$kode_akun3'";
  $updatequery6 = "UPDATE akun SET saldo=saldo-'$saldo6' WHERE kode_akun='$kode_akun3'";
} else if ($saldo_normal3 == 'Kredit') {
  $updatequery15 = "UPDATE akun SET saldo=saldo-'$saldo5' WHERE kode_akun='$kode_akun3'";
  $updatequery16 = "UPDATE akun SET saldo=saldo+'$saldo6' WHERE kode_akun='$kode_akun3'";
}

  if ($saldo_normal4 == 'Debit') {
  $updatequery7 = "UPDATE akun SET saldo=saldo+'$saldo7' WHERE kode_akun='$kode_akun4'";
  $updatequery8 = "UPDATE akun SET saldo=saldo-'$saldo8' WHERE kode_akun='$kode_akun4'";
} else if ($saldo_normal4 == 'Kredit') {
  $updatequery17 = "UPDATE akun SET saldo=saldo-'$saldo7' WHERE kode_akun='$kode_akun4'";
  $updatequery18 = "UPDATE akun SET saldo=saldo+'$saldo8' WHERE kode_akun='$kode_akun4'";
}

  if ($saldo_normal5 == 'Debit') {
  $updatequery9 = "UPDATE akun SET saldo=saldo+'$saldo9' WHERE kode_akun='$kode_akun5'";
  $updatequery10 = "UPDATE akun SET saldo=saldo-'$saldo10' WHERE kode_akun='$kode_akun5'";
} else if ($saldo_normal5 == 'Kredit') {
  $updatequery19 = "UPDATE akun SET saldo=saldo-'$saldo9' WHERE kode_akun='$kode_akun5'";
  $updatequery20 = "UPDATE akun SET saldo=saldo+'$saldo10' WHERE kode_akun='$kode_akun5'";

} -->

<!-- <script>
    function validateAndSubmit() {
        var total1Value = parseFloat(document.getElementById('total').value.replace(/[^0-9.]/g, '')) || 0;
        var total2Value = parseFloat(document.getElementById('total2').value.replace(/[^0-9.]/g, '')) || 0;

        if (total1Value === total2Value) {
            // Total sesuai, submit data
            document.getElementById('yourFormId').submit(); // Ganti 'yourFormId' dengan id formulir Anda
        } else {
            // Total tidak sesuai, tampilkan pesan kesalahan
            alert('Total penjumlahan tidak sesuai. Periksa kembali input Anda.');
        }
    }
</script>

<th><input style="text-align:center" type="text" class="form-control" id="total" readonly></th>
<th><input style="text-align:center" type="text" class="form-control" id="total" readonly></th>
<input type="submit" name="simpan" value="Simpan" class="btn btn-primary" onclick="validateAndSubmit()"></input> -->

<!-- if (isset($_POST['simpan'])) {
    // Inisialisasi array untuk menampung data yang akan disimpan
    $dataToInsert = array();

    // Loop melalui form saldo dan memeriksa jika nilainya tidak kosong
    for ($i = 1; $i <= 10; $i++) {
        $saldoName = 'saldo' . $i;
        if (!empty($_POST[$saldoName])) {
            // Saldo yang diisi tidak kosong, tambahkan ke array data yang akan disimpan
            $dataToInsert[$saldoName] = $_POST[$saldoName];
        }
    }

    // Loop melalui form kode akun dan memeriksa jika nilainya tidak kosong
    for ($i = 1; $i <= 5; $i++) {
        $kodeAkunName = 'kode_akun' . $i;
        if (!empty($_POST[$kodeAkunName])) {
            // Kode akun yang diisi tidak kosong, tambahkan ke array data yang akan disimpan
            $dataToInsert[$kodeAkunName] = $_POST[$kodeAkunName];
        }
    }

    // Jika ada data yang diisi, lakukan proses INSERT atau UPDATE ke database
    if (!empty($dataToInsert)) {
        // Lakukan query INSERT atau UPDATE dengan data yang ada dalam array $dataToInsert
        // ...

        // Tampilkan pesan sukses atau lakukan redirect
        // ...
    } else {
        // Tampilkan pesan bahwa tidak ada data yang diisi
        // ...
    }
} -->

            <?php for ($i = 1; $i <= 20; $i++) { ?>
            <tr>
                <td>
                    <select class="form-control select2" name="kode_jenjang[]" required="">
                        <option value="">Pilih Jenjang</option>
                        <!-- Isi pilihan jenjang dari database atau sumber data lainnya -->
                    </select>
                    <input type="hidden" name="nama_jenjang[]" readonly>
                </td>
                <td><input type="text" name="keterangan[]" class="form-control" placeholder="Input Keterangan"></td>
                <td><input style="text-align:center" type="text" class="form-control" name="saldo[]" value="0" oninput="formatNumber(this); calculateTotal();" required></td>
            </tr>
            <?php } ?>
        </table>
        <button type="submit">Simpan</button>
    </form>

    <script>
        // Fungsi formatNumber() dan calculateTotal() dapat Anda definisikan di sini
    </script>
</body>
</html>


<form method="POST" action="proses.php"> <!-- Ganti "proses.php" dengan file yang sesuai untuk penanganan data -->

  <?php
  for ($i = 1; $i <= 20; $i++) {
  ?>
    <tr>
      <th>
        <select class="form-control select2" name="kode_akun<?= $i ?>" id="kode_akun<?= $i ?>" required>
          <option value="">Pilih Akun</option>
          <?php

          while ($data = $result->fetch_assoc()) {
            $kode_akun = $data['kode_akun'];
            $akun = $data['nama_akun'];
          ?>
            <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
          <?php
          }
          ?>
        </select>
        <input style="text-align:center" type="hidden" name="akun<?= $i ?>" id="akun<?= $i ?>" readonly>
        <input type="hidden" class="form-control col-sm-9" id="saldo_normal<?= $i ?>" readonly>
      </th>

      <th>
        <select class="form-control select2" name="kode_jenjang<?= $i ?>" id="kode_jenjang<?= $i ?>" required="">
          <option value="">Pilih Jenjang</option>
          <?php
          while ($data = $result->fetch_assoc()) {
            $kode_jenjang = $data['kode_jenjang'];
            $nama_jenjang = $data['nama_jenjang'];
          ?>
            <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
          <?php
          }
          ?>
        </select>
        <input type="hidden" id="nama_jenjang<?= $i ?>" readonly>
      </th>

      <th><input type="text" name="keterangan<?= $i ?>" id="keterangan<?= $i ?>" class="form-control" placeholder="Input Keterangan"></th>
      <th><input style="text-align:center" type="text" class="form-control" name="saldo2<?= $i ?>" id="saldo2<?= $i ?>" value="0" oninput="formatNumber(this); calculateTotal();" required></th>
    </tr>
  <?php
  }
  ?>
</form>


         <!-- <tr>
            <th>
                <select class="form-control select2" name="kode_akun" id="kode_akun" required>
                  <option value="">Pilih Akun</option>
                  <?php
                  $query = "SELECT * FROM akun WHERE status = 1 AND nama_akun NOT LIKE '%Kas%'";
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
                <input style="text-align:center" type="hidden" name="akun" id="akun" readonly>
                <input type="hidden" class="form-control col-sm-9" id="saldo_normal" readonly>
            </th>
                

            <th>
                <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
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
                  <input type="hidden" id="nama_jenjang" readonly>
            </th>

            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
            <th><input style="text-align:center" type="text" class="form-control" name="saldo1" id="saldo1" value="0" oninput="formatNumber(this); calculateTotal();" required></th>
          </tr> -->


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
    var total = 0;
    for (var i = 1; i <= 10; i++) {
      var saldo = parseFloat(document.getElementById('saldo' + i).value.replace(/,/g, '')) || 0;
      total += saldo;
    }
    var formattedTotal = total.toLocaleString('id-ID');
    document.getElementById('total').value = 'Rp. ' + formattedTotal;
  }

  function removeFormatFromSaldoInputs() {
    for (var i = 1; i <= 10; i++) {
      removeFormat(document.getElementById('saldo' + i));
    }
  }
</script>




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
                                var saldo10 = parseFloat(document.getElementById('saldo10').value.replace(/,/g, '')) || 0;
                                var saldo10 = parseFloat(document.getElementById('saldo10').value.replace(/,/g, '')) || 0;
                                var saldo10 = parseFloat(document.getElementById('saldo10').value.replace(/,/g, '')) || 0;
                                var saldo10 = parseFloat(document.getElementById('saldo10').value.replace(/,/g, '')) || 0;
                                var saldo10 = parseFloat(document.getElementById('saldo10').value.replace(/,/g, '')) || 0;

                                var total = saldo1 + saldo2 + saldo3 + saldo4 + saldo5 + saldo6 + saldo7 + saldo8 + saldo9 + saldo10 + saldo10 + saldo10 + saldo10 + saldo10 + saldo10;
                                var formattedTotal = total.toLocaleString('id-ID');
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
                                removeFormat(document.getElementById('saldo3'));
                                removeFormat(document.getElementById('saldo4'));
                                removeFormat(document.getElementById('saldo5'));
                                removeFormat(document.getElementById('saldo6'));
                                removeFormat(document.getElementById('saldo7'));
                                removeFormat(document.getElementById('saldo8'));
                                removeFormat(document.getElementById('saldo9'));
                                removeFormat(document.getElementById('saldo10'));
                                removeFormat(document.getElementById('saldo10'));
                                removeFormat(document.getElementById('saldo10'));
                                removeFormat(document.getElementById('saldo10'));
                                removeFormat(document.getElementById('saldo10'));
                                removeFormat(document.getElementById('saldo10'));
                            }
                            </script>


<?php
// Impor file koneksi.php
require_once 'koneksi.php';

if (isset($_POST['simpan'])) {
    // Mengambil data dari formulir POST
    $total = $_POST['total'];
    
    // Anda dapat menggunakan loop untuk mengambil data lain sesuai dengan nama elemen formulir
    for ($i = 1; $i <= 20; $i++) {
        $kode_akun = $_POST['kode_akun' . $i];
        $kode_jenjang = $_POST['kode_jenjang' . $i];
        $keterangan = $_POST['keterangan' . $i];
        $saldo = $_POST['saldo2' . $i];
        
        // Selanjutnya, gunakan data ini untuk menyusun dan menjalankan query SQL untuk menyimpan data
        $query = "INSERT INTO nama_tabel (nama_kolom1, nama_kolom2, nama_kolom3, nama_kolom4) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ssss", $kode_akun, $kode_jenjang, $keterangan, $saldo);
        
        if ($stmt->execute()) {
            // Data berhasil disimpan ke database
        } else {
            // Terjadi kesalahan saat menyimpan data
        }
        
        // Tutup statement
        $stmt->close();
    }
}
?>

<?php
  for ($i = 1; $i <= 20; $i++) {
  ?>
    <tr>
      <th>
        <select class="form-control select2" name="kode_akun<?= $i ?>" id="kode_akun<?= $i ?>" required>
          <option value="">Pilih Akun</option>
          <?php
                  $query = "SELECT * FROM akun WHERE status = 1 AND nama_akun NOT LIKE '%Kas%'";
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
        <input style="text-align:center" type="hidden" name="akun<?= $i ?>" id="akun<?= $i ?>" readonly>
        <input type="hidden" class="form-control col-sm-9" id="saldo_normal<?= $i ?>" readonly>
      </th>

      <th>
        <select class="form-control select2" name="kode_jenjang<?= $i ?>" id="kode_jenjang<?= $i ?>" required="">
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
        <input type="hidden" id="nama_jenjang<?= $i ?>" readonly>
      </th>

      <th><input type="text" name="keterangan<?= $i ?>" id="keterangan<?= $i ?>" class="form-control" placeholder="Input Keterangan"></th>
      <th><input style="text-align:center" type="text" class="form-control" name="saldo<?= $i ?>" id="saldo<?= $i ?>" value="0" oninput="formatNumber(this); calculateTotal();" required></th>
    </tr>
  <?php
  }
  ?>        


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
    var total = 0;
    for (var i = 1; i <= 20; i++) {
      var saldo = parseFloat(document.getElementById('saldo' + i).value.replace(/,/g, '')) || 0;
      total += saldo;
    }
    var formattedTotal = total.toLocaleString('id-ID');
    document.getElementById('total').value = 'Rp. ' + formattedTotal;
  }

  function removeFormatFromSaldoInputs() {
    for (var i = 1; i <= 20; i++) {
      removeFormat(document.getElementById('saldo' + i));
    }
  }
</script>


<tr id="input">
                                <th style="text-align:center" colspan = 3> Total </th>
                          <th><input style="text-align:center" type="text" class="form-control" id="total" readonly></th> 



            <div class="card-body">
            <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" onclick="removeFormat(document.getElementById('saldo'))"></input> <a href="?page=transaksi_kas&aksi=data" class="btn btn-success" >Transaksi Terbuat</a>
            </div>
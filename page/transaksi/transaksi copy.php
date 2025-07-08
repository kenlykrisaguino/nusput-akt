<?php
$host = "localhost";
$user = "root"; // Ganti dengan username database Anda
$pass = ""; // Ganti dengan password database Anda
$db = "nusput"; // Ganti dengan nama database Anda
$konektor = new mysqli($host, $user, $pass, $db);

if ($konektor->connect_error) {
  die("Koneksi gagal: " . $konektor->connect_error);
}

$query = "SELECT kode_transaksi, kategori_transaksi, akun_debit, kode_akun_debit, akun_kredit, kode_akun_kredit 
          FROM master_transaksi WHERE status = 1";
$result = $konektor->query($query);

$transaksiData = [];
$transaksiData2 = [];

while ($data = $result->fetch_assoc()) {
    $kode_transaksi = $data['kode_transaksi'];
    
    // Data Akun Debit
    $transaksiData[$kode_transaksi] = [
        'kategori' => $data['kategori_transaksi'],
        'akun_debit' => $data['akun_debit'],
        'kode_akun_debit' => $data['kode_akun_debit']
    ];
    
    // Data Akun Kredit
    $transaksiData2[$kode_transaksi] = [
        'kategori' => $data['kategori_transaksi'],
        'akun_kredit' => $data['akun_kredit'],
        'kode_akun_kredit' => $data['kode_akun_kredit']
    ];
}
?>

    <div class="container-fluid">
    <div class="card shadow mb-2">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Transaksi Keuangan</h3>
    </div>
        <div class="row">
        <div class="col-md-12">
        <div class="card card-primary">
          </div>        
        <div class="card-body">		
    <form method="POST" enctype="multipart/form-data">

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
        <label for="nama" class="col-sm-2"><b>Tahun Ajaran</b></label>
          <select class="form-control select2 col-sm-9" name="kode_tahun" id="kode_tahun" required="">
          <option value="">Pilih Tahun Ajaran</option>
        <?php
        $query = "SELECT * FROM th_ajaran WHERE status = 1";
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
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Transaksi</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Dropdown Kategori Transaksi -->
    <div class="form-group row">
        <label for="kategori_transaksi" class="col-sm-2"><b>Kategori Transaksi</b></label>
        <select name="kode_transaksi" id="kode_transaksi" class="form-control col-sm-9">
            <option value="">Pilih Kategori Transaksi</option>
            <?php
            foreach ($transaksiData as $kode => $data) {
                echo "<option value='{$kode}' data-kategori='{$data['kategori']}'>{$kode} → {$data['kategori']}</option>";
            }
            ?>
        </select>
    </div>
    <input type="hidden" name="kategori_transaksi" id="kategori_transaksi">
    <script>
          $(document).ready(function() {
          $("#kode_transaksi").change(function() {
              var selectedOption = $(this).find(":selected");
              var kategoriTransaksi = selectedOption.data("kategori");

              // Set nilai kategori_transaksi di input hidden
              $("#kategori_transaksi").val(kategoriTransaksi);
          });
      });
    </script>

    <!-- Dropdown Akun Debit -->
    <div class="form-group row">
        <label for="akun_debit" class="col-sm-2"><b>Akun Debit</b></label>
        <select name="akun_debit" id="akun_debit" class="form-control col-sm-9" readonly>
        </select>
    </div>

    <!-- Dropdown Akun kredit -->
    <div class="form-group row">
        <label for="akun_debit" class="col-sm-2"><b>Akun Kredit</b></label>
        <select name="akun_kredit" id="akun_kredit" class="form-control col-sm-9" readonly>
        </select>
    </div>

    <script>
       $(document).ready(function() {
    var transaksiDebit = <?php echo json_encode($transaksiData); ?>;
    var transaksiKredit = <?php echo json_encode($transaksiData2); ?>;

    $("#kode_transaksi").change(function() {
        var selectedKode = $(this).val();
        
        // Panggil fungsi untuk memperbarui dropdown akun debit & kredit
        updateAkunDebit(selectedKode);
        updateAkunKredit(selectedKode);
    });

    function updateAkunDebit(selectedKode) {
        var akunDebitSelect = $("#akun_debit");
        akunDebitSelect.empty();

        if (selectedKode && transaksiDebit[selectedKode]) {
            var kodeAkunDebit = transaksiDebit[selectedKode]['kode_akun_debit'];
            var namaAkunDebit = transaksiDebit[selectedKode]['akun_debit'];
            var formattedAkunDebit = kodeAkunDebit + " → " + namaAkunDebit;

            akunDebitSelect.append('<option value="'+ namaAkunDebit +'">'+ formattedAkunDebit +'</option>');
        } else {
            akunDebitSelect.append('<option value="">Pilih Akun Debit</option>');
        }
    }

    function updateAkunKredit(selectedKode) {
        var akunKreditSelect = $("#akun_kredit");
        akunKreditSelect.empty();

        if (selectedKode && transaksiKredit[selectedKode]) {
            var kodeAkunKredit = transaksiKredit[selectedKode]['kode_akun_kredit'];
            var namaAkunKredit = transaksiKredit[selectedKode]['akun_kredit'];
            var formattedAkunKredit = kodeAkunKredit + " → " + namaAkunKredit;

            akunKreditSelect.append('<option value="'+ namaAkunKredit +'">'+ formattedAkunKredit +'</option>');
        } else {
            akunKreditSelect.append('<option value="">Pilih Akun Kredit</option>');
        }
    }
});
    </script>

</body>
</html>
    
        

        <div class="form-group row" style="display: none;">
        <label for="nama" class="col-sm-2"><b>Status</b></label>
          <select name="status" id="status" class="form-control col-sm-9" readonly>
            <option value="1">Aktif</option>
          </select>
        </div>

        <hr>
        <table class="table table-bordered table-hover">
          <tr id="input" style="text-align: center; background-color: #f2f2f2;">
            <th style="width: 25%; text-align:center">Jenjang</th>
            <th style="width: 55%; text-align:center">Keterangan</th>
            <th style="width: 20%; text-align:center">Jumlah</th>
          </tr>

              
              <th>
                <select class="form-control select2" name="kode_jenjang1" id="kode_jenjang1" required="">
                  <option value="">Pilih Jenjang</option>
                  <?php
                          $query = "SELECT * FROM master_jenjang WHERE status = 1";
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

               function removeFormatFromSaldoInputs() {
            removeFormat(document.getElementById('saldo1'));
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
    $kode_transaksi = $_POST['kode_transaksi'];
    $kategori_transaksi = $_POST['kategori_transaksi'];
    $kode_tahun = $_POST['kode_tahun'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $tanggal = $_POST['tanggal'];
    $akun_debit = $_POST['akun_debit'];
    $status = $_POST['status'];
    $akun_kredit = $_POST['akun_kredit']; 
    $kode_jenjang1 = $_POST['kode_jenjang1'];
    $nama_jenjang1 = $_POST['nama_jenjang1'];
    $keterangan1 = $_POST['keterangan1'];
    $saldo1 = $_POST['saldo1'];

    
    $query_jenjang1 = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang1'";
    $result_jenjang1 = $konektor->query($query_jenjang1);
    $data_jenjang1 = $result_jenjang1->fetch_assoc();
    $nama_jenjang1 = $data_jenjang1['nama_jenjang'];


    $query_tahun = "SELECT tahun_ajaran FROM th_ajaran WHERE kode_tahun='$kode_tahun'";
    $result_tahun = $konektor->query($query_tahun);
    $data_tahun = $result_tahun->fetch_assoc();
    $tahun_ajaran = $data_tahun['tahun_ajaran'];


    $insertquery1 = "INSERT INTO transaksi (status, tanggal, kode_transaksi, kategori_transaksi, kode_tahun, tahun_ajaran, akun_debit, akun_kredit, kode_jenjang, nama_jenjang, keterangan, saldo) 
    VALUES ('$status', '$tanggal','$kode_transaksi','$kategori_transaksi','$kode_tahun','$tahun_ajaran','$akun_debit','$akun_kredit','$kode_jenjang1','$nama_jenjang1','$keterangan1','$saldo1')";
    ?>                      
      <script type="text/javascript">
      alert("Data Berhasil Disimpan");
      window.location.href="?page=transaksi&aksi=data";
      </script>                       
    <?php
        if (mysqli_query($konektor, $insertquery1)) {
          "Upload sukses";
        } else {
        "Error: " . $sql . "<br>" . mysqli_error($konektor);
        }
      }
        mysqli_close($konektor);
    ?>
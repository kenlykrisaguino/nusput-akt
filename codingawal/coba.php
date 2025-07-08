<!-- /.content --><!DOCTYPE html>
<html>
<head>
    <title>Insert dan Update Data</title>
</head>
<body>

<h2>Insert dan Update Data</h2>

<form action="process.php" method="post">
    <label for="nama">Nama:</label><br>
    <input type="text" id="nama" name="nama"><br>

    <label for="umur">Umur:</label><br>
    <input type="number" id="umur" name="umur"><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br><br>

    <input type="submit" name="insert" value="Insert">
    <input type="submit" name="update" value="Update">
</form>

</body>
</html>

<?php
// Koneksi ke database
$conn = new mysqli("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil dan mengupdate data transaksi
$sql = "SELECT id, amount, type FROM transaksi";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $transaksiID = $row["id"];
    $amount = $row["amount"];
    $jenisTransaksi = $row["type"];
    
    // Update saldo berdasarkan jenis transaksi
    if ($jenisTransaksi == "penerimaan") {
        $saldoBaru = "+ " . $amount;
    } elseif ($jenisTransaksi == "pengeluaran") {
        $saldoBaru = "- " . $amount;
    }

    $updateSaldoSQL = "UPDATE transaksi SET saldo = saldo $saldoBaru WHERE id = '$transaksiID'";
    $conn->query($updateSaldoSQL);
}

$conn->close();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Otomatis Dengan PHP Mysqli</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>


// koneksi database kodegenerator
$koneksi = mysqli_connect('localhost','root','','tagy3641_akt');
// mengambil data barang dari tabel dengan kode terbesar
$query = mysqli_query($koneksi, "SELECT max(kode) as kodeTerbesar FROM tabel");
$data = mysqli_fetch_array($query);
$kodeBarang = $data['kodeTerbesar'];
// mengambil angka dari kode barang terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
$urutan = (int) substr($kodeBarang, 3, 3);
// nomor yang diambil akan ditambah 1 untuk menentukan nomor urut berikutnya
$urutan++;
// membuat kode barang baru
// string sprintf("%03s", $urutan); berfungsi untuk membuat string menjadi 3 karakter
// misalnya string sprintf("%03s", 22); maka akan menghasilkan '022'
// angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya PC
$huruf = "PC";
$kodeBarang = $huruf . sprintf("%03s", $urutan);


<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Data Barang</h5>
      </div>
      <div class="modal-body">
		  <!-- method="post" untuk mengirim data kedalam database, dan action="simpan.php" adalah fungsi untuk menyimpan data -->
      <form method="post" action="simpan.php">
  <div class="form-row">
    <div class="form-group mx-auto">
		<!-- name="kode" adalah variabel untuk field kode, dan php echo kodebarang adalah string untuk menghasilkan kode otomatis -->
      <input type="text" class="form-control" placeholder="Kode Barang" name="kode" value="<?php echo $kodeBarang ?>" readonly required="required">
    </div>
    <div class="form-group mx-auto">
		<!-- nama="nama_brg" adalah variabel untuk field nama barang -->
      <input type="text" class="form-control" placeholder="Nama Barang" name="nama_brg" required="required">
    </div>
	<div class="form-group mx-auto">
		<!-- onkeypress="return angkasaja(event)" kode pemanggilan fungsi javascript untuk hanya bisa menginputkan angka saja, dan name="harga" adalah variabel untuk field harga -->
      <input type="text" class="form-control" onkeypress="return angkasaja(event)" placeholder="Harga Barang" name="harga" required="required">
    </div>
	<div class="form-group mx-auto">
		<!-- onkeypress="return angkasaja(event)" kode pemanggilan fungsi javascript untuk hanya bisa menginputkan angka saja, dan name="jumlah" adalah variabel untuk field jumlah -->
      <input type="text" class="form-control" onkeypress="return angkasaja(event)" placeholder="Jumlah Barang" name="jumlah" required="required">
    </div>
  </div>
  <!-- tombol untuk memasukan data kedalam database -->
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<!-- tabel untuk menampilkan data barang -->
<table class="table table-striped">
		<thead>
			<tr>
				<th>Kode</th>
				<th>Nama Barang</th>
				<th>Harga</th>
				<th>Jumlah</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$barang = mysqli_query($koneksi,"SELECT * FROM tabel");
			while($b = mysqli_fetch_array($barang)){
				?>
				<tr>
					<td><?php echo $b['kode']; ?></td>
					<td><?php echo $b['nama_brg']; ?></td>
					<td><?php echo "Rp. ".number_format($b['harga'])." ,-"; ?></td>
					<td><?php echo $b['jumlah']; ?></td>
				</tr>
				<?php 
			}
			?>
		</tbody>
	</table>
	<footer class="text-center">&copy;<a href="https://www.panduancode.com"> www.panduancode.com</a></footer>
      </div>
	   </div>
  </div>
  <!-- javascript untuk fungsi input angka saja pada form -->
  <script>
		function angkasaja(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
	</script>
</body>
</html>

<form method="post" action="proses_form.php">
  <!-- Hidden input untuk ID Transaksi Penerimaan -->
  <input type="hidden" name="id_transaksi_penerimaan" value="<?php echo $idTransaksiPenerimaan; ?>">

  <!-- Hidden input untuk ID Transaksi Pengeluaran -->
  <input type="hidden" name="id_transaksi_pengeluaran" value="<?php echo $idTransaksiPengeluaran; ?>">

  <!-- Input dan elemen lain dalam form -->
  <div class="form-group row">
      <label for="nama" class="col-sm-2"><b>No Transaksi Penerimaan</b></label>
      <input type="text" name="no_transaksi_penerimaan" id="no_transaksi_penerimaan" value="<?php echo $urutanPenerimaan; ?>" class="form-control col-sm-9" readonly>
  </div>

  <div class="form-group row">
      <label for="nama" class="col-sm-2"><b>No Transaksi Pengeluaran</b></label>
      <input type="text" name="no_transaksi_pengeluaran" id="no_transaksi_pengeluaran" value="<?php echo $urutanPengeluaran; ?>" class="form-control col-sm-9" readonly>
  </div>

  <!-- Tombol Submit -->
  <button type="submit">Submit</button>
</form>


<select name="kode_akun">
  <?php
  $query = "SELECT * FROM akun";
  $result = $konektor->query($query);
  $num_result = $result->num_rows;

  if ($num_result > 0) {
      while ($data = $result->fetch_assoc()) {
          $kode_akun = $data['kode_akun'];
          $nama_akun = $data['nama_akun'];
  ?>
      <option value="<?= $kode_akun ?>"><?= $kode_akun . ' → ' . $nama_akun ?></option>
  <?php
      }
  }
  ?>
</select>

<div class="form-group row">
  <label for="nama" class="col-sm-2"><b>Jenjang</b></label>
  <select class="form-control select2 col-sm-9" name="kode_jenjang" id="kode_jenjang" required="">
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
          <option value="<?= $kode_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
      <?php
          }
      }
      ?>
  </select>
</div>

<?php
include "connect.php"; // Pastikan Anda sudah memasukkan file koneksi

if (isset($_POST['simpan'])) {
    $kode_jenjang = $_POST['kode_jenjang'];
    
    // Mendapatkan nama jenjang berdasarkan kode jenjang yang dipilih
    $query_nama_jenjang = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang = '$kode_jenjang'";
    $result_nama_jenjang = $konektor->query($query_nama_jenjang);
    $data_nama_jenjang = $result_nama_jenjang->fetch_assoc();
    $nama_jenjang = $data_nama_jenjang['nama_jenjang'];

    // Melakukan query INSERT dengan data kode dan nama jenjang
    $insertquery = "INSERT INTO transaksi_bank (kode_jenjang, nama_jenjang) VALUES ('$kode_jenjang', '$nama_jenjang')";

    if ($konektor->query($insertquery)) {
        // Berhasil dimasukkan ke dalam database
    } else {
        // Terjadi kesalahan
    }
}
?>


<div class="form-group row">
  <label for="nama" class="col-sm-2"><b>Jenjang</b></label>
  <select class="form-control select2 col-sm-9" name="kode_jenjang" id="kode_jenjang" required="">
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
          <option value="<?= $kode_jenjang ?>" data-nama="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
      <?php
          }
      }
      ?>
  </select>
</div>

<div class="form-group row">
  <label for="nama" class="col-sm-2"><b>Nama Jenjang</b></label>
  <input type="text" name="nama_jenjang" id="nama_jenjang" class="form-control col-sm-9" readonly>
</div>

<script>
  // Skrip JavaScript untuk menampilkan data dari dropdown ke form
  var select = document.getElementById("kode_jenjang");
  var inputNamaJenjang = document.getElementById("nama_jenjang");

  select.addEventListener("change", function() {
      var selectedOption = select.options[select.selectedIndex];
      inputNamaJenjang.value = selectedOption.getAttribute("data-nama");
  });
</script>






<!DOCTYPE html>
<html>
<head>
    <title>Contoh Form</title>
    <script>
        // Skrip JavaScript untuk menampilkan data dari dropdown ke form
        function displayData() {
            var dropdown = document.getElementById("kode_jenjang");
            var selectedOption = dropdown.options[dropdown.selectedIndex];
            
            var kodeJenjang = selectedOption.value;
            var namaJenjang = selectedOption.getAttribute("data-nama");

            document.getElementById("nama_jenjang").value = namaJenjang;
        }
    </script>
</head>
<body>
    <form method="post" action="">
        <div class="form-group row">
            <label for="nama" class="col-sm-2"><b>Jenjang</b></label>
            <select class="form-control select2 col-sm-9" name="kode_jenjang" id="kode_jenjang" onchange="displayData()" required="">
                <option value="">Pilih Jenjang</option>
                <!-- Isi opsi dropdown dari database -->
            </select>
        </div>

        <div class="form-group row">
            <label for="nama" class="col-sm-2"><b>Nama Jenjang</b></label>
            <input type="text" name="nama_jenjang" id="nama_jenjang" class="form-control col-sm-9" readonly>
        </div>

        <button type="submit" name="simpan">Simpan</button>
    </form>

    <?php
    include "connect.php"; // Pastikan Anda sudah memasukkan file koneksi
    
    if (isset($_POST['simpan'])) {
        $kode_jenjang = $_POST['kode_jenjang'];
        $nama_jenjang = $_POST['nama_jenjang'];

        // Lakukan operasi insert ke database
        $insertQuery = "INSERT INTO transaksi_bank (kode_jenjang, nama_jenjang) VALUES ('$kode_jenjang', '$nama_jenjang')";
        
        if ($konektor->query($insertQuery) === TRUE) {
            echo "Data berhasil dimasukkan ke dalam database.";
        } else {
            echo "Error: " . $konektor->error;
        }
    }
    ?>
</body>
</html>

<div class="form-group row">
  <label for="nama" class="col-sm-2">Jenis Usaha</label>
  <select class="form-control select2 col-sm-5" name="id_kegiatan">
      <?php
      $query = "SELECT * FROM tb_kegiatan WHERE id_unit='$id_unit'";
      $result = $mysqli->query($query);
      $num_result = $result->num_rows;
      if ($num_result > 0) {
          $no = 0;
          while ($data = mysqli_fetch_assoc($result)) { ?>
              <option value="<?= $data['id_kegiatan'] ?>" <?= isselect($data['id_kegiatan'], $id_kegiatan) ?>>
                  <?= $data['nama_kegiatan'] ?>
              </option>
          <?php }
      }
      ?>
  </select>
</div>


<div class="form-group row">
  <label for="nama" class="col-sm-2">Nama Kegiatan</label>
  <input type="text" class="form-control col-sm-5" name="nama_kegiatan" value="<?= $nama_kegiatan ?>" readonly>
</div>


<div class="form-group row">
  <label for="nama" class="col-sm-2"><b>Jenjang</b></label>
  <select class="form-control select2 col-sm-4" name="kode_jenjang" id="kode_jenjang" required="">
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
          }
      }
      ?>
  </select>
  <!-- Menampilkan Nama Jenjang di Form Sebelahnya -->
  <input type="text" class="form-control col-sm-4" id="nama_jenjang" readonly>
</div>

<script>
  var selectJenjang = document.getElementById("kode_jenjang");
  var inputNamaJenjang = document.getElementById("nama_jenjang");

  selectJenjang.addEventListener("change", function () {
      var selectedOption = selectJenjang.options[selectJenjang.selectedIndex];
      inputNamaJenjang.value = selectedOption.getAttribute("data-name");
  });
</script>


$query_jenjang = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang='$kode_jenjang'";
$result_jenjang = $konektor->query($query_jenjang);
$data_jenjang = $result_jenjang->fetch_assoc();
$nama_jenjang = $data_jenjang['nama_jenjang'];


$query_insert = "INSERT INTO nama_tabel (kolom_kode_jenjang, kolom_nama_jenjang) VALUES ('$kode_jenjang', '$nama_jenjang')";


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
              <option value="<?= $kode_akun ?>" data-nama="<?= $nama_akun ?>"><?= $kode_akun ?></option>
      <?php
          }
      }
      ?>
  </select>
  <span class="col-1"></span>
  <input type="text" class="form-control col-sm-4" id="nama_akun" readonly>
</div>

      <script>
  var selectAkunBank = document.getElementById("akun_bank");
  var inputNamaAkun = document.getElementById("nama_akun");

  selectAkunBank.addEventListener("change", function () {
      var selectedOption = selectAkunBank.options[selectAkunBank.selectedIndex];
      inputNamaAkun.value = selectedOption.getAttribute("data-nama");
  });
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jenis_transaksi = $_POST["jenis_transaksi"];

    // Determine the appropriate starting value based on the selected jenis_transaksi
    if ($jenis_transaksi === "Penerimaan") {
        $query = "SELECT MAX(no_transaksi) AS max_code FROM transaksi_bank WHERE jenis_transaksi = 'Penerimaan'";
    } elseif ($jenis_transaksi === "Pengeluaran") {
        $query = "SELECT MAX(no_transaksi) AS max_code FROM transaksi_bank WHERE jenis_transaksi = 'Pengeluaran'";
    } else {
        // Handle other cases if needed
        $query = "SELECT MAX(no_transaksi) AS max_code FROM transaksi_bank";
    }

    $result = $konektor->query($query);
    $row = $result->fetch_assoc();
    $urutan = isset($row['max_code']) ? (int) $row['max_code'] + 1 : 1;
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jenis_transaksi = $_POST["jenis_transaksi"];

    // Determine the appropriate starting value based on the selected jenis_transaksi
    if ($jenis_transaksi === "Penerimaan") {
        $query = "SELECT MAX(no_transaksi) AS max_code FROM transaksi_bank WHERE jenis_transaksi = 'Penerimaan'";
    } elseif ($jenis_transaksi === "Pengeluaran") {
        $query = "SELECT MAX(no_transaksi) AS max_code FROM transaksi_bank WHERE jenis_transaksi = 'Pengeluaran'";
    } else {
        // Handle other cases if needed
        $query = "SELECT MAX(no_transaksi) AS max_code FROM transaksi_bank";
    }

    $result = $konektor->query($query);
    $row = $result->fetch_assoc();
    $urutan = isset($row['max_code']) ? (int) $row['max_code'] + 1 : 1;
}
?>

<form method="POST" action="">
    <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Jenis Transaksi</b></label>
        <select name="jenis_transaksi" id="jenis_transaksi" class="form-control col-sm-9" required>
            <option value="">Pilih Jenis Transaksi</option>
            <option value="Penerimaan">Penerimaan</option>
            <option value="Pengeluaran">Pengeluaran</option>
        </select>
    </div>
    <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>No Transaksi</b></label>
        <input type="text" name="no_transaksi" id="no_transaksi" value="<?= isset($urutan) ? $urutan : '' ?>" class="form-control col-sm-9" readonly>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jenis_transaksi = $_POST["jenis_transaksi"];

    // Query to get the maximum code for the selected jenis_transaksi
    $query = "SELECT MAX(no_transaksi) AS max_code FROM transaksi_bank WHERE jenis_transaksi = '$jenis_transaksi'";
    $result = $konektor->query($query);
    $row = $result->fetch_assoc();
    $max_code = isset($row['max_code']) ? (int) $row['max_code'] : 0;

    // Determine the starting number for the code
    $starting_number = $max_code + 1;

    // Generate the full code
    $kode_transaksi = $starting_number . "-" . strtoupper(substr($jenis_transaksi, 0, 3));
}
?>

<table class="table">
    <?php
    while ($data = mysqli_fetch_assoc($result)) {
        $jenis_transaksi = $data['jenis_transaksi'];
        $kelas_css = ($jenis_transaksi === 'Penerimaan') ? 'penerimaan' : 'pengeluaran';
    ?>
    <tr class="<?= $kelas_css ?>">
        <td><?= $data['kolom1'] ?></td>
        <td><?= $data['kolom2'] ?></td>
        <td><?= $data['kolom3'] ?></td>
    </tr>
    <?php
    }
    ?>
</table>

<?php 
$no = 1;
$sql = $konektor->query("select * from transaksi_bank ");
while ($data = $sql->fetch_assoc()) {	
    // Tentukan warna berdasarkan jenis transaksi
    $warnaBaris = $data['jenis_transaksi'] == 'JenisTransaksiYangDiinginkan' ? 'background-color: yellow;' : '';
?>

    <td><?php echo $data['tanggal'] ?></td>
    <td><?php echo $data['jenis_transaksi'] ?></td>
    <td><?php echo $data['no_transaksi'] ?></td>
    <td><?php echo $data['nama_bank']?></td>
    <td><?php echo $data['nama_akun']?></td>
    <td><?php echo $data['nama_jenjang'] ?></td>
    <td><?php echo $data['tahun_ajaran'] ?></td>
    <td><?php echo $data['keterangan'] ?></td>
    <td><?php echo $data['sumber_dana'] ?></td>
    <td>Rp. <?=number_format($data['debit'],0,',','.');?></td>
    <td>Rp. <?=number_format($data['kredit'],0,',','.');?></td>
    <td><?php echo $data['no_kasbon'] ?></td>
    <td><a href="?page=jenjang&aksi=ubah1&kode_jenjang=<?php echo $data['kode_jenjang'] ?>" class="btn btn-info">Ubah</a></td>
</tr>
<?php } ?>

<?php
// Langkah 2: Temukan transaksi yang dihapus
$transaksi_id = $_GET['transaksi_id']; // Anda perlu mengambil ID transaksi yang dihapus

// Langkah 3: Hitung ulang saldo berdasarkan transaksi yang dihapus
$sql = "SELECT jenis_transaksi, jumlah FROM transaksi WHERE id = $transaksi_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jenis_transaksi = $row['jenis_transaksi'];
    $jumlah = $row['jumlah'];

    // Hitung ulang saldo sesuai jenis transaksi
    if ($jenis_transaksi == 'Penerimaan') {
        $saldo_update = "UPDATE saldo SET jumlah = jumlah + $jumlah";
    } elseif ($jenis_transaksi == 'Pengeluaran') {
        $saldo_update = "UPDATE saldo SET jumlah = jumlah - $jumlah";
    }

    // Langkah 4: Update saldo dalam tabel saldo
    if ($conn->query($saldo_update) === TRUE) {
        echo "Saldo berhasil diupdate.";
    } else {
        echo "Error updating saldo: " . $conn->error;
    }

    // Anda juga bisa menghapus transaksi dari tabel transaksi jika diperlukan
    // $delete_transaksi = "DELETE FROM transaksi WHERE id = $transaksi_id";
    // $conn->query($delete_transaksi);

} else {
    echo "Transaksi tidak ditemukan.";
}

$conn->close();
?>

<?php
	$no_transaksi = $_GET['no_transaksi'];
    $jumlah = "UPDATE transaksi_bank SET status = 0";

	if ($sql) {
		?>
			<script type="text/javascript">
			alert("Data Berhasil Dihapus");
			window.location.href="?page=transaksi_bank&aksi=data";
			</script>
		<?php
	}
?>
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
    $saldo_normal = $_POST['saldo_normal']; // assuming you get this from the form

    if ($jenis_transaksi == 'Penerimaan') {
        if ($saldo_normal == 'kredit') {
            $insertquery = "INSERT INTO transaksi_bank (no_transaksi, jenis_transaksi, kode_akun, nama_akun, akun_bank, nama_bank, tanggal, sumber_dana, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, no_kasbon, keterangan, kredit, status) 
VALUES('$kode_transaksi','$jenis_transaksi','$kode_akun','$nama_akun','$akun_bank','$nama_bank','$tanggal','$sumber_dana','$kode_tahun','$tahun_ajaran','$kode_jenjang','$nama_jenjang', '$no_kasbon','$keterangan','$saldo','$status')";

            $updatequery = "UPDATE akun SET saldo=saldo+'$saldo' WHERE kode_akun='$akun_bank' OR kode_akun='$kode_akun'";
        } elseif ($saldo_normal == 'debit') {
            $insertquery = "INSERT INTO transaksi_bank (no_transaksi, jenis_transaksi, kode_akun, nama_akun, akun_bank, nama_bank, tanggal, sumber_dana, kode_tahun, tahun_ajaran, kode_jenjang, nama_jenjang, no_kasbon, keterangan, debit, status) 
VALUES('$kode_transaksi','$jenis_transaksi','$kode_akun','$nama_akun','$akun_bank','$nama_bank','$tanggal','$sumber_dana','$kode_tahun','$tahun_ajaran','$kode_jenjang','$nama_jenjang', '$no_kasbon','$keterangan','$saldo','$status')";

            $updatequery = "UPDATE akun SET saldo=saldo-'$saldo' WHERE kode_akun='$akun_bank' OR kode_akun='$kode_akun'";
        }
    }
}

/*$update= array();
      $update2= array();

      if (!empty($saldo1)) {
        $update[] = array(
            "kode_akun" => $kode_akun,
            "saldo_normal" => $saldo_normal,
            "saldo" => $saldo1
        );
    }

    if (!empty($saldo2)) {
        $update2[] = array(
            "kode_akun" => $kode_akun,
            "saldo_normal" => $saldo_normal2,
            "saldo" => $saldo2
        );
    }

    // if(!empty($update)){
      
    // }

    foreach($update as $up){
        $kodeakunup = $up['kode_akun'];
        $saldonormalup=$up['saldo_normal'];
        $saldoup=$up['saldo'];

        var_dump($saldonormalup);
        
        $updatequery="UPDATE akun SET saldo= ";
        if($saldonormalup=='Debit'){
          $updatequery.= "saldo+$saldoup"; 
        } else if ($saldonormalup=='Kredit'){
          $updatequery.= "saldo-$saldoup";
        }
        $updatequery.=" WHERE kode_akun='$kodeakunup'";
        $result=$konektor->query($updatequery);
    }
  }
  
  //   foreach($update2 as $up){
  //       $kodeakunup = $up['kode_akun'];
  //       $saldonormalup=$up['saldo_normal'];
  //       $saldoup=$up['saldo'];

  //       $updatequery="UPDATE akun SET saldo= ";
  //       if($saldonormalup=='Debit'){
  //         $updatequery.= "saldo-$saldoup"; 
  //       } else if ($saldonormalup=='Kredit'){
  //         $updatequery.= "saldo+$saldoup";
  //       }
  //       $updatequery.=" WHERE kode_akun='$kodeakunup'";
  //       $result=$konektor->query($updatequery);
  //   }
  // }*/
  /*if ($saldo_normal == 'Debit') {
    $updatequery = "UPDATE akun SET saldo = CASE WHEN kode_akun = '$kode_akun' THEN saldo + '$saldo1' ELSE saldo END,
                      saldo = CASE WHEN kode_akun = '$kode_akun' THEN saldo + '$saldo2' ELSE saldo END";
} else if ($saldo_normal == 'Kredit') {
    $updatequery = "UPDATE akun SET saldo = CASE WHEN kode_akun = '$kode_akun' THEN saldo - '$saldo1' ELSE saldo END,
                      saldo = CASE WHEN kode_akun = '$kode_akun' THEN saldo - '$saldo2' ELSE saldo END";
}}*/
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
 <div class="container-fluid">

    <div class="card shadow mb-4">
    <div class="card-header py-3">
	    <h3 class="m-0 font-weight-bold text-primary">Tambah Data Master Lokasi</h3>
    </div>
    <div class="card-body">
    <div class="table-responsive">
			
		<div class="body">
		<form method="POST" enctype="multipart/form-data">
		

		<!-- Input yang ditampilkan tetapi tidak bisa diedit -->
		<label for="">Kode Lokasi</label>
		<div class="form-group">
			<div class="form-line">
				<input type="text" id="kode_lokasi_display" class="form-control" readonly>
			</div>
		</div>

		<!-- Input tersembunyi untuk dikirim ke database -->
		<input type="hidden" name="kode_lokasi" id="kode_lokasi">


									
		<label for="">Nama Lokasi</label>
		<div class="form-group">
		<div class="form-line">
			<input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" required=""/>	 
		</div>
		</div>

		<label for="">Tempat</label>
		<div class="form-group">
		<div class="form-line">
			<select name="tempat" id ="tempat" class="form-control show-tick" required>
			<option value="">Pilih Tempat</option>
				<option value="PUSAT">PUSAT</option>
				<option value="MEDOHO">MEDOHO</option>
			</select>
		</div>
		</div>

		<label for="">Lantai</label>
		<div class="form-group">
		<div class="form-line">
			<select name="lantai" id ="lantai" class="form-control show-tick" required>
				<option value="">Pilih Lantai</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
			</select>
		</div>
		</div>

		<div class="form-group" style="display: none;">
		<div class="form-line">		
		<label for="">Status → 0=Non-Aktif; 1=Aktif</label>
			<select name="status" id ="status" class="form-control show-tick" required>
				<option value="1">1</option>				
			</select>
		</div>
		</div>

		<script>
		document.addEventListener("DOMContentLoaded", function() {
			let tempatField = document.getElementById("tempat");
			let lantaiField = document.getElementById("lantai");
			let kodeLokasiField = document.getElementById("kode_lokasi"); // Hidden input
			let kodeLokasiDisplay = document.getElementById("kode_lokasi_display"); // Readonly input

			function updateKodeLokasi() {
				let tempat = tempatField.value.trim();
				let lantai = lantaiField.value.trim();

				if (!tempat || !lantai) {
					// Jika input kosong, reset kode lokasi
					kodeLokasiField.value = "";
					kodeLokasiDisplay.value = "";
					return;
				}

				fetch(`generate_kode.php?tempat=${encodeURIComponent(tempat)}&lantai=${encodeURIComponent(lantai)}`)
					.then(response => response.text())
					.then(data => {
						console.log("Kode Lokasi:", data); // Debugging di Console
						kodeLokasiField.value = data; // Menyimpan ke input hidden
						kodeLokasiDisplay.value = data; // Menampilkan di input readonly
					})
					.catch(error => console.error("Error:", error));
			}

			// Update kode lokasi setiap kali "tempat" atau "lantai" berubah
			tempatField.addEventListener("change", updateKodeLokasi);
			lantaiField.addEventListener("change", updateKodeLokasi);
		});
		</script>


		<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
		</form>

</body>
</html>

<?php
include "connect.php"; // Pastikan koneksi sudah dimuat
    // Ambil data dari form
    $kode_lokasi = $_POST['kode_lokasi'];
    $nama_lokasi = $_POST['nama_lokasi'];
    $tempat = $_POST['tempat'];
    $lantai = $_POST['lantai'];
    $status = $_POST['status']; // Default status ke 1 (Aktif)


    if((isset($_POST['simpan']))){
		$sql = "INSERT INTO lokasi (kode_lokasi, nama_lokasi, tempat, lantai, status) 
        VALUES ('$kode_lokasi', '$nama_lokasi', '$tempat', '$lantai', '$status')";
		
		?>                      
			<script type="text/javascript">
			alert("Data Berhasil Disimpan");
			window.location.href="?page=lokasi";
			</script>                       
		<?php
		
		if (mysqli_query($konektor, $sql)) {
			 "Upload sukses";
		  } else {
			 "Error: " . $sql . "<br>" . mysqli_error($konektor);
		  }
		}
		  mysqli_close($konektor);
	?>


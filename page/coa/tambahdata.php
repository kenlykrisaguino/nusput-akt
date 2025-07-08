<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tambah Master Data Jenjang</title>
</head>
<body>
 <div class="container-fluid">

    <div class="card shadow mb-4">
    <div class="card-header py-3">
	    <h3 class="m-0 font-weight-bold text-primary">Tambah Data Master Chart of Account</h3>
    </div>
    <div class="card-body">
    <div class="table-responsive">
	<script>

</script>						
							
		<div class="body">
		<form method="POST" enctype="multipart/form-data">
		
		<label for="">Kode Akun</label>
		<div class="form-group">
		<div class="form-line">
		<input type="number" name="kode_akun" id="kode_akun" class="form-control" required=""/>	 
		</div>
		</div>
									
		<label for="">Nama Akun</label>
		<div class="form-group">
		<div class="form-line">
			<input type="text" name="nama_akun" id="nama_akun" class="form-control" required=""/>	 
		</div>
		</div>

		<label for="">Klasifikasi</label>
		<div class="form-group">
		<div class="form-line">
			<select name="klasifikasi" id ="klasifikasi" class="form-control show-tick" required>
			<option value="">Pilih Klasifikasi</option>
				<option value="10. ASET LANCAR">10. ASET LANCAR</option>
				<option value="11. ASET TETAP">11. ASET TETAP</option>
				<option value="12. BIAYA DI LUAR USAHA">12. BIAYA DI LUAR USAHA</option>
				<option value="13. BIAYA UMUM & ADM">13. BIAYA UMUM & ADM</option>
				<option value="14. HUTANG JK PENDEK">14. HUTANG JK PENDEK</option>
				<option value="15. OPERASIONAL RUTIN">15. OPERASIONAL RUTIN</option>
				<option value="16. PENDAPATAN DI LUAR USAHA">16. PENDAPATAN DI LUAR USAHA</option>
				<option value="17. PENERIMAAN RUTIN">17. PENERIMAAN RUTIN</option>
				<option value="18. PENERIMAAN TDK RUTIN">18. PENERIMAAN TDK RUTIN</option>
				<option value="19. PERSEDIAAN">19. PERSEDIAAN</option>
				<option value="20. MODAL">20. MODAL</option>
			</select>
		</div>
		</div>

		<label for="">Saldo Normal</label>
		<div class="form-group">
		<div class="form-line">
			<select name="saldo_normal" id ="saldo_normal" class="form-control show-tick" required>
				<option value="">Pilih Saldo Normal</option>
				<option value="Debit">Debit</option>
				<option value="Kredit">Kredit</option>
			</select>
		</div>
		</div>

		<!-- <label for="">Saldo</label>
		<div class="form-group">
		<div class="form-line">
		<input type="number" name="saldo" id="saldo" class="form-control" required=""/>	 
		</div>
		</div> -->

		<div class="form-group" style="display: none;">
		<div class="form-line">		
		<label for="">Status → 0=Non-Aktif; 1=Aktif</label>
			<select name="status" id ="status" class="form-control show-tick" required>
				<option value="1">1</option>				
			</select>
		</div>
		</div>

		<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
		</form>

		</script>
</body>
</html>

<?php
include "connect.php";
	$kode_akun= $_POST['kode_akun'];
	$nama_akun= $_POST['nama_akun'];
	$klasifikasi= $_POST['klasifikasi'];
	$saldo_normal= $_POST['saldo_normal'];
	// $saldo= $_POST['saldo'];
	$status= $_POST['status'];

    if((isset($_POST['simpan']))){
	$sql = "INSERT INTO akun (kode_akun, nama_akun, klasifikasi, saldo_normal, arus_kas, jenis, status) 
	VALUES('$kode_akun','$nama_akun','$klasifikasi','$saldo_normal','','','$status')";
	
	?>                      
        <script type="text/javascript">
        alert("Data Berhasil Disimpan");
        window.location.href="?page=coa";
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
										
										
										
								
								
								
								
								

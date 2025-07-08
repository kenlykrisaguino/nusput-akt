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
	    <h3 class="m-0 font-weight-bold text-primary">Tambah Data Master Jenjang</h3>
    </div>
    <div class="card-body">
    <div class="table-responsive">
	<script>

</script>						
							
		<div class="body">
		<form method="POST" enctype="multipart/form-data">
		
		<label for="">Kode Jenjang</label>
		<div class="form-group">
		<div class="form-line">
		<input type="number" name="kode_jenjang" id="kode_jenjang" class="form-control" required=""/>	 
		</div>
		</div>
									
		<label for="">Nama Jenjang</label>
		<div class="form-group">
		<div class="form-line">
			<input type="text" name="nama_jenjang" id="nama_jenjang" class="form-control" required=""/>	 
		</div>
		</div>

		<label for="">Kelompok</label>
		<div class="form-group">
		<div class="form-line">
            <input type="text" name="kelompok" id="kelompok" class="form-control" required=""/> 	 
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

		<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
		</form>

		</script>
</body>
</html>

<?php
include "connect.php";
	$kode_jenjang= $_POST['kode_jenjang'];
	$nama_jenjang= $_POST['nama_jenjang'];
	$kelompok= $_POST['kelompok'];
	$status= $_POST['status'];

    if((isset($_POST['simpan']))){
	$sql = "INSERT INTO master_jenjang (kode_jenjang, nama_jenjang, kelompok, status) 
	VALUES('$kode_jenjang','$nama_jenjang','$kelompok','$status')";
	
	?>                      
        <script type="text/javascript">
        alert("Data Berhasil Disimpan");
        window.location.href="?page=jenjang";
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
										
										
										
								
								
								
								
								

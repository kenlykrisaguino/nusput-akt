<?php
 $kode_lokasi = $_GET['kode_lokasi'];
 $sblm = $konektor->query("SELECT * from akun where kode_lokasi = '$kode_lokasi'");
 $tampil = $sblm->fetch_assoc();

 $admin = $tampil['admin'];	
 ?>
 
  <div class="container-fluid">

	<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Ubah Data Master Lokasi</h3>
	</div>
	<div class="card-body">
	<div class="table-responsive">    
		<div class="body">

		<form method="POST" enctype="multipart/form-data">
		
		<label for="">Kode Lokasi</label>
		<div class="form-group">
		<div class="form-line">
		    <input type="text" name="kode_lokasi" readonly value="<?php echo $tampil['kode_lokasi']; ?>" class="form-control" required=""/>
		</div>
		</div>
									
		<label for="">Nama Lokasi</label>
		<div class="form-group">
		<div class="form-line">
            	<input type="text" name="nama_lokasi" value="<?php echo $tampil['nama_lokasi']; ?>" class="form-control" required=""/> 	 
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


		<label for="">Status → 0=Non-Aktif; 1=Aktif</label>
		<div class="form-group">
		<div class="form-line">
			<select name="status" id ="status" value="<?php echo $tampil['status']; ?>" class="form-control show-tick" required>
				<option value="">Pilih Status</option>
				<option value="1">1</option>				
				<option value="0">0</option>

			</select>
		</div>
		</div>
                                  
        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                            
        </form>             
                            
        <?php
                            
        if (isset($_POST['simpan'])) {
			$kode_lokasi = $_POST['kode_lokasi'];
			$nama_lokasi = $_POST['nama_lokasi'];
			$tempat = $_POST['tempat'];
			$lantai = $_POST['lantai'];
			$status = $_POST['status'];                            
                                
        $sql = $konektor->query("UPDATE akun SET nama_lokasi='$nama_lokasi', tempat = '$tempat', lantai = '$lantai', status='$status' WHERE kode_lokasi='$kode_lokasi'"); 
        
        if ($sql) {
        ?>                      
        <script type="text/javascript">
        alert("Data Berhasil Diubah");
        window.location.href="?page=coa";
        </script>                       
        <?php
        }               
        }
?>
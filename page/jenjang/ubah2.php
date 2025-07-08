<?php
 $kode_jenjang = $_GET['kode_jenjang'];
 $sblm = $konektor->query("SELECT * from master_jenjang where kode_jenjang = '$kode_jenjang'");
 $tampil = $sblm->fetch_assoc();

 $admin = $tampil['admin'];	
 ?>
 
  <div class="container-fluid">

	<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Ubah Data Master Jenjang</h3>
	</div>
	<div class="card-body">
	<div class="table-responsive">    
		<div class="body">

		<form method="POST" enctype="multipart/form-data">
		
		<label for="">Kode Jenjang</label>
		<div class="form-group">
		<div class="form-line">
		    <input type="number" name="kode_jenjang" readonly value="<?php echo $tampil['kode_jenjang']; ?>" class="form-control" required=""/>
		</div>
		</div>
									
		<label for="">Nama Jenjang</label>
		<div class="form-group">
		<div class="form-line">
            <input type="text" name="nama_jenjang" value="<?php echo $tampil['nama_jenjang']; ?>" class="form-control" required=""/> 	 
		</div>
		</div>

		<label for="">Kelompok</label>
		<div class="form-group">
		<div class="form-line">
            <input type="text" name="kelompok" value="<?php echo $tampil['kelompok']; ?>" class="form-control" required=""/> 	 
		</div>
		</div>
		<label for="">Status → 0=Non-Aktif; 1=Aktif</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select name="status" class="form-control show-tick" required>
                                <option value="1" <?php echo ($tampil['status'] == 1) ? "selected" : ""; ?>>1</option>
                                <option value="0" <?php echo ($tampil['status'] == 0) ? "selected" : ""; ?>>0</option>
                            </select>
                        </div>
                    </div>
                                  
        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                            
        </form>             
                            
        <?php
                            
        if (isset($_POST['simpan'])) {
            $kode_jenjang= $_POST['kode_jenjang'];
            $nama_jenjang= $_POST['nama_jenjang'];
			$kelompok= $_POST['kelompok'];  
			$status= $_POST['status'];                         
                                
        $sql = $konektor->query("update master_jenjang set nama_jenjang='$nama_jenjang', kelompok='$kelompok', status='$status' where kode_jenjang='$kode_jenjang'"); 
        
        if ($sql) {
        ?>                      
        <script type="text/javascript">
        alert("Data Berhasil Diubah");
        window.location.href="?page=jenjang&aksi=backup";
        </script>                       
        <?php
        }               
        }
?>
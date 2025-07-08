<?php
 $kode_tahun = $_GET['kode_tahun'];
 $sblm = $konektor->query("select * from th_ajaran where kode_tahun = '$kode_tahun'");
 $tampil = $sblm->fetch_assoc();

 $admin = $tampil['admin'];	
 ?>
 
  <div class="container-fluid">

	<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Ubah Data Master Tahun Ajaran</h3>
	</div>
	<div class="card-body">
	<div class="table-responsive">    
		<div class="body">

		<form method="POST" enctype="multipart/form-data">
		
		<label for="">Kode Tahun Ajaran</label>
		<div class="form-group">
		<div class="form-line">
		    <input type="number" name="kode_tahun" readonly value="<?php echo $tampil['kode_tahun']; ?>" class="form-control" required=""/>
		</div>
		</div>
									
		<label for="">Nama Tahun Ajaran</label>
		<div class="form-group">
		<div class="form-line">
            <input type="text" name="tahun_ajaran" value="<?php echo $tampil['tahun_ajaran']; ?>" class="form-control" required=""/> 	 
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
			$kode_tahun= $_POST['kode_tahun'];
            $tahun_ajaran= $_POST['tahun_ajaran'];
			$status= $_POST['status'];                            
                                
        $sql = $konektor->query("update th_ajaran set tahun_ajaran='$tahun_ajaran', status='$status' where kode_tahun='$kode_tahun'"); 
        
        if ($sql) {
        ?>                      
        <script type="text/javascript">
        alert("Data Berhasil Diubah");
        window.location.href="?page=th_ajaran&aksi=backup";
        </script>                       
        <?php
        }               
        }
?>
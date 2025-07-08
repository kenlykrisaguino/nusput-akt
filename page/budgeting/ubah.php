<?php
    $kode_jenjang = $_GET['kode_jenjang'];
    $kegiatan = $_GET['kegiatan'];
 $sblm = $konektor->query("SELECT * FROM budgeting WHERE kegiatan = '$kegiatan' AND kode_jenjang = '$kode_jenjang'");
 $tampil = $sblm->fetch_assoc();

 $admin = $tampil['admin'];	
 ?>
 
  <div class="container-fluid">

	<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Ubah Data Budgeting</h3>
	</div>
	<div class="card-body">
	<div class="table-responsive">    
		<div class="body">

		<form method="POST" enctype="multipart/form-data">
        <label for="">Nama Jenjang</label>
        <div class="form-group">
            <div class="form-line">
                <input type="text" name="nama_jenjang" value="<?php echo $tampil['nama_jenjang']; ?>" class="form-control" readonly>
            </div>
        </div>

        <label for="">Divisi</label>
        <div class="form-group">
            <div class="form-line">
                <input type="text" name="divisi" value="<?php echo $tampil['divisi']; ?>" class="form-control" readonly>
            </div>
        </div>
		
		<label for="">Kegiatan</label>
		<div class="form-group">
		<div class="form-line">
		    <input type="text" name="kegiatan" readonly value="<?php echo $tampil['kegiatan']; ?>" class="form-control" readonly>
		</div>
		</div>
									
		<label for="">Nominal</label>
		<div class="form-group">
		<div class="form-line">
            <input type="text" name="nominal" value="<?php echo $tampil['nominal']; ?>" class="form-control" required=""/> 	 
		</div>

		</div>
        <label for="">Rincian</label>
        <div class="form-group">
            <div class="form-line">
                <input type="text" name="rincian" value="<?php echo $tampil['rincian']; ?>" class="form-control" required=""/>
            </div>
        </div>

		<label for="">Sumber Dana</label>
		<div class="form-group">
		<div class="form-line">
			<select name="sumber_dana" id ="sumber_dana" value="<?php echo $tampil['sumber_dana']; ?>" class="form-control show-tick" required>
                <option value="">Pilih Sumber Dana</option>
                <option value="Rutin">Rutin</option>
                <option value="BOS">BOS</option>
                <option value="Titipan Siswa">Titipan Siswa</option>

			</select>
		</div>
		</div>
                                  
        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                            
        </form>             
                            
        <?php
                            
        if (isset($_POST['simpan'])) {
			$kegiatan= $_POST['kegiatan'];
            $nominal= $_POST['nominal'];
			$sumber_dana= $_POST['sumber_dana'];                            
                                
        $sql = $konektor->query("UPDATE budgeting SET nominal='$nominal', sumber_dana='$sumber_dana' WHERE kegiatan='$kegiatan'"); 
        
        if ($sql) {
        ?>                      
        <script type="text/javascript">
        alert("Data Berhasil Diubah");
        window.location.href="?page=budgeting";
        </script>                       
        <?php
        }               
        }
?>
<?php
 $kode_akun = $_GET['kode_akun'];
 $sblm = $konektor->query("SELECT * from akun where kode_akun = '$kode_akun'");
 $tampil = $sblm->fetch_assoc();

 $admin = $tampil['admin'];	
 ?>
 
  <div class="container-fluid">

	<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Ubah Data Master Chart of Account</h3>
	</div>
	<div class="card-body">
	<div class="table-responsive">    
		<div class="body">

		<form method="POST" enctype="multipart/form-data">
		
		<label for="">Kode Akun</label>
		<div class="form-group">
		<div class="form-line">
		    <input type="number" name="kode_akun" readonly value="<?php echo $tampil['kode_akun']; ?>" class="form-control" required=""/>
		</div>
		</div>
									
		<label for="">Nama Akun</label>
		<div class="form-group">
		<div class="form-line">
            	<input type="text" name="nama_akun" value="<?php echo $tampil['nama_akun']; ?>" class="form-control" required=""/> 	 
		</div>
		</div>

		<label for="klasifikasi">Klasifikasi</label>
<div class="form-group">
    <div class="form-line">
        <select name="klasifikasi" id="klasifikasi" class="form-control show-tick" required>
            <option value="10. ASET LANCAR" <?php echo ($tampil['klasifikasi'] == "10. ASET LANCAR") ? "selected" : ""; ?>>10. ASET LANCAR</option>
            <option value="11. ASET TETAP" <?php echo ($tampil['klasifikasi'] == "11. ASET TETAP") ? "selected" : ""; ?>>11. ASET TETAP</option>
            <option value="12. BIAYA DI LUAR USAHA" <?php echo ($tampil['klasifikasi'] == "12. BIAYA DI LUAR USAHA") ? "selected" : ""; ?>>12. BIAYA DI LUAR USAHA</option>
            <option value="13. BIAYA UMUM & ADM" <?php echo ($tampil['klasifikasi'] == "13. BIAYA UMUM & ADM") ? "selected" : ""; ?>>13. BIAYA UMUM & ADM</option>
            <option value="14. HUTANG JK PENDEK" <?php echo ($tampil['klasifikasi'] == "14. HUTANG JK PENDEK") ? "selected" : ""; ?>>14. HUTANG JK PENDEK</option>
            <option value="15. OPERASIONAL RUTIN" <?php echo ($tampil['klasifikasi'] == "15. OPERASIONAL RUTIN") ? "selected" : ""; ?>>15. OPERASIONAL RUTIN</option>
            <option value="16. PENDAPATAN DI LUAR USAHA" <?php echo ($tampil['klasifikasi'] == "16. PENDAPATAN DI LUAR USAHA") ? "selected" : ""; ?>>16. PENDAPATAN DI LUAR USAHA</option>
            <option value="17. PENERIMAAN RUTIN" <?php echo ($tampil['klasifikasi'] == "17. PENERIMAAN RUTIN") ? "selected" : ""; ?>>17. PENERIMAAN RUTIN</option>
            <option value="18. PENERIMAAN TDK RUTIN" <?php echo ($tampil['klasifikasi'] == "18. PENERIMAAN TDK RUTIN") ? "selected" : ""; ?>>18. PENERIMAAN TDK RUTIN</option>
            <option value="19. PERSEDIAAN" <?php echo ($tampil['klasifikasi'] == "19. PERSEDIAAN") ? "selected" : ""; ?>>19. PERSEDIAAN</option>
            <option value="20. MODAL" <?php echo ($tampil['klasifikasi'] == "20. MODAL") ? "selected" : ""; ?>>20. MODAL</option>
        </select>
    </div>
</div>


		<label for="">Saldo Normal</label>
		<div class="form-group">
		<div class="form-line">
			<select name="saldo_normal" id ="saldo_normal" class="form-control show-tick" required>
				<option value="Debit" <?php echo ($tampil['saldo_normal'] == debit) ? "selected" : ""; ?>>debit</option>
                                	<option value="Kredit" <?php echo ($tampil['saldo_normal'] == kredit) ? "selected" : ""; ?>>kredit</option>
			</select>
		</div>
		</div>

		<!-- <label for="">Saldo</label>
		<div class="form-group">
		<div class="form-line">
		    <input type="number" name="saldo_awal" value="<?php echo $tampil['saldo_awal']; ?>" class="form-control" required=""/>
		</div>
		</div> -->

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
			$kode_akun= $_POST['kode_akun'];
            		$nama_akun= $_POST['nama_akun'];
			$klasifikasi= $_POST['klasifikasi']; 
			$saldo_normal= $_POST['saldo_normal']; 
			// $saldo_awal= $_POST['saldo_awal'];
			$status= $_POST['status'];                            
                                
        $sql = $konektor->query("update akun set nama_akun='$nama_akun', klasifikasi='$klasifikasi', saldo_normal='$saldo_normal', arus_kas='', jenis='',  status='$status' where kode_akun='$kode_akun'"); 
        
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
<?php
 $kode_transaksi = $_GET['kode_transaksi'];
 $sblm = $konektor->query("SELECT * from master_transaksi where kode_transaksi = '$kode_transaksi'");
 $tampil = $sblm->fetch_assoc();
 ?>
 
  <div class="container-fluid">
	<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Ubah Data Master Jurnal</h3>
	</div>	
	<div class="card-body">
	<div class="table-responsive">    
		<div class="body">
		<form method="POST" enctype="multipart/form-data">
		
		<label for="">Kode Transaksi</label>
		<div class="form-group">
		<div class="form-line">
		    <input type="text" name="kode_transaksi" readonly value="<?php echo $tampil['kode_transaksi']; ?>" class="form-control" required=""/>
		</div>
		</div>

		<label for="">Kategori Transaksi</label>
		<div class="form-group">
		<div class="form-line">
		    <input type="text" name="kategori_transaksi" value="<?php echo $tampil['kategori_transaksi']; ?>" class="form-control" required=""/>
		</div>
		</div>

                    <label for="">Akun Debit</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select name="akun_debit" class="form-control" required>
                                <option value="">Pilih Akun</option>
                                <?php
                                $query_debit = $konektor->query("SELECT * FROM akun WHERE status = 1");
                                while ($row = $query_debit->fetch_assoc()) {
                                    $selected = ($row['nama_akun'] == $tampil['akun_debit']) ? "selected" : "";
                                    echo "<option value='{$row['nama_akun']}' $selected>{$row['kode_akun']} → {$row['nama_akun']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

		<label for="">Akun Kredit</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select name="akun_kredit" class="form-control" required>
                                <option value="">Pilih Akun</option>
                                <?php
                                $query_kredit = $konektor->query("SELECT * FROM akun WHERE status = 1");
                                while ($row = $query_kredit->fetch_assoc()) {
                                    $selected = ($row['nama_akun'] == $tampil['akun_kredit']) ? "selected" : "";
                                    echo "<option value='{$row['nama_akun']}' $selected>{$row['kode_akun']} → {$row['nama_akun']}</option>";
                                }
                                ?>
                            </select>
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
	$kode_transaksi= $_POST['kode_transaksi'];
	$kategori_transaksi= $_POST['kategori_transaksi'];
	$akun_debit= $_POST['akun_debit'];
	$akun_kredit= $_POST['akun_kredit'];
	$status= $_POST['status'];
                            
                                
        $sql = $konektor->query("update master_transaksi set kategori_transaksi='$kategori_transaksi', akun_debit='$akun_debit', akun_kredit='$akun_kredit', status='$status' where kode_transaksi='$kode_transaksi'"); 
        
        if ($sql) {
        ?>                      
        <script type="text/javascript">
        alert("Data Berhasil Diubah");
        window.location.href="?page=master_transaksi";
        </script>                       
        <?php
        }               
        }
?>
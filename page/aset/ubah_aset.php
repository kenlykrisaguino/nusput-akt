<?php
 $kode_aset = $_GET['kode_aset'];
 $sblm = $konektor->query("SELECT * from aset where kode_aset = '$kode_aset'");
 $tampil = $sblm->fetch_assoc();

 $admin = $tampil['admin'];	
 ?>
 
  <div class="container-fluid">

	<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Ubah Data Aset - <?php echo $tampil['kode_aset']; ?></h3>
	</div>
	<div class="card-body">
	<div class="table-responsive">    
		<div class="body">

		<form method="POST" enctype="multipart/form-data">
		
        <label for="">Kode Aset</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="kode_aset" readonly value="<?php echo htmlspecialchars($tampil['kode_aset']); ?>" class="form-control">
                            </div>
                        </div>

                        <label for="">Nama Aset</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="nama_aset" value="<?php echo htmlspecialchars($tampil['nama_aset']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <label for="">Spesifikasi</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="spesifikasi" value="<?php echo htmlspecialchars($tampil['spesifikasi']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <label for="">Kode Lokasi</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control select2" name="kode_lokasi" required>
                                    <option value="">Pilih Lokasi</option>
                                    <?php
                                    $query = "SELECT * FROM lokasi";
                                    $result = $konektor->query($query);
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $selected = ($data['kode_lokasi'] == $tampil['kode_lokasi']) ? "selected" : "";
                                        echo "<option value='{$data['kode_lokasi']}' $selected>{$data['kode_lokasi']} → {$data['nama_lokasi']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <label for="">Kode Jenjang</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control select2" name="kode_jenjang" required>
                                    <option value="">Pilih Jenjang</option>
                                    <?php
                                    $query = "SELECT * FROM master_jenjang";
                                    $result = $konektor->query($query);
                                    while ($data = $result->fetch_assoc()) {
                                        $selected = ($data['kode_jenjang'] == $tampil['kode_jenjang']) ? "selected" : "";
                                        echo "<option value='{$data['kode_jenjang']}' $selected>{$data['kode_jenjang']} → {$data['nama_jenjang']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <label for="">Sumber Dana</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select name="sumber_dana" class="form-control" required>
                                    <option value="">Pilih Sumber Dana</option>
                                    <?php
                                    $sumber_dana_options = ["Investasi", "BOS", "RAPBS", "Bantuan"];
                                    foreach ($sumber_dana_options as $option) {
                                        $selected = ($tampil['sumber_dana'] == $option) ? "selected" : "";
                                        echo "<option value='$option' $selected>$option</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <label for="">Tanggal Pembelian</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" name="tanggal_pembelian" value="<?php echo htmlspecialchars($tampil['tanggal_pembelian']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <label for="">Harga Perolehan</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="number" name="harga_perolehan" value="<?php echo htmlspecialchars($tampil['harga_perolehan']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <label for="">Umur Ekonomis</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="number" name="umur_ekonomis" value="<?php echo htmlspecialchars($tampil['umur_ekonomis']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <label for="">Depresiasi</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="number" step="0.01" name="depresiasi" value="<?php echo htmlspecialchars($tampil['depresiasi']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                    </form>            
                            
        <?php
                            
                            if (isset($_POST['simpan'])) {
                                $kode_aset = $_POST['kode_aset'];
                                $nama_aset = $_POST['nama_aset'];
                                $spesifikasi = $_POST['spesifikasi'];
                                $kode_lokasi = $_POST['kode_lokasi'];
                                $kode_jenjang = $_POST['kode_jenjang'];
                                $sumber_dana = $_POST['sumber_dana'];
                                $tanggal_pembelian = $_POST['tanggal_pembelian'];
                                $harga_perolehan = $_POST['harga_perolehan'];
                                $umur_ekonomis = $_POST['umur_ekonomis'];
                                $depresiasi = $_POST['depresiasi'];
        
                                $sql = $konektor->query("UPDATE aset SET 
                                    nama_aset='$nama_aset', 
                                    spesifikasi='$spesifikasi', 
                                    kode_lokasi='$kode_lokasi', 
                                    kode_jenjang='$kode_jenjang', 
                                    sumber_dana='$sumber_dana', 
                                    tanggal_pembelian='$tanggal_pembelian', 
                                    harga_perolehan='$harga_perolehan', 
                                    umur_ekonomis='$umur_ekonomis', 
                                    depresiasi='$depresiasi' 
                                    WHERE kode_aset='$kode_aset'");
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
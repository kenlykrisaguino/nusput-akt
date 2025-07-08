<?php
if (isset($_POST['no_kasbon'])) {
    $no_kasbon = $_POST['no_kasbon'];
    $konektor = mysqli_connect("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");

    $sql = $konektor->query("SELECT * FROM transaksi_bank WHERE no_kasbon = $no_kasbon");

    if (!empty($sql)) {
        $rows = $sql->fetch_all(MYSQLI_ASSOC);

        if (!empty($rows)) {
            $firstRow = $rows[0];
            $no_bukti = $firstRow['no_transaksi'];
            $tanggal = date('d/m/Y', strtotime($firstRow['tanggal']));
            $sumber_dana = $firstRow['sumber_dana'];
            $jumlah = $firstRow['debit'];
            $tahun_ajaran = $firstRow['tahun_ajaran'];
?>
<div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Transaksi Pembalik Kasbon</h3>
	</div>

	<div class="card shadow mb-">
	<div class="card-header py-2">
		<h3 class="m-0 font-weight-bold text-primary"><a href="?page=transaksi_bank" class="btn btn-primary" >Tambah Data</a>  
		<a href="?page=transaksi_bank&aksi=transaksi_cancel" class="btn btn-dark" >Transaksi Dibatalkan</a>
		<a href="page/transaksi_bank/export.php" class="btn btn-success" >Export ke Excel</a>
	</h3>
	</div>
  
	<div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			
			<tr>
				<th>Tanggal</th>
				<th>No. Kasbon</th>
        <th>Th. Ajaran</th>
				<th>Jenjang</th>
				<th>Keterangan</th>		
				<th>Akun</th>	
				<th>Debit</th>
				<th>Kredit</th>
			</tr>
		
			<tbody>
        <tr>
      <td><?php echo $row['tanggal'] ?></td>
      <td><?php echo $row['no_kasbon']; ?></td>
      <td><?php echo $row['tahun_ajaran']; ?></td>
      <td><?php echo $row['nama_jenjang']; ?></td>
      <td><?php echo $row['keterangan']; ?></td>
      <td><?php echo $row['nama_akun']; ?></td>
      <td>Rp. <?php echo number_format($row['debit'], 0, ',', '.'); ?></td>
      <td>Rp. <?php echo number_format($row['kredit'], 0, ',', '.'); ?></td>
      <tr>
      </tbody>
<div class="container-fluid">
    <div>
        <h3>No. Bukti: <?php echo $no_bukti; ?></h3>
        <p>Tanggal: <?php echo $tanggal; ?></p>
        <p>Sumber Dana: <?php echo $sumber_dana; ?></p>
        <table>
            <tr>
                <th>Tanggal</th>
                <th>No. Kasbon</th>
                <th>Th. Ajaran</th>
                <th>Jenjang</th>
                <th>Akun</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>

            <?php
            foreach ($rows as $row) {
                // Display each transaction row
                // You can customize this part based on your requirements
                ?>
                <tr>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td><?php echo $row['no_kasbon']; ?></td>
                    <td><?php echo $row['tahun_ajaran']; ?></td>
                    <td><?php echo $row['nama_jenjang']; ?></td>
                    <td><?php echo $row['keterangan']; ?></td>
                    <td><?php echo $row['nama_akun']; ?></td>
                    <td>Rp. <?php echo number_format($row['debit'], 0, ',', '.'); ?></td>
                    <td>Rp. <?php echo number_format($row['kredit'], 0, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </table>

        <!-- Rest of your HTML code for the website layout -->
    </div>
</div>



<div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Transaksi Pembalik Kasbon</h3>
	</div>

	<div class="card shadow mb-">
	<div class="card-header py-2">
		<h3 class="m-0 font-weight-bold text-primary"><a href="?page=transaksi_bank" class="btn btn-primary" >Tambah Data</a>  
		<a href="?page=transaksi_bank&aksi=transaksi_cancel" class="btn btn-dark" >Transaksi Dibatalkan</a>
		<a href="page/transaksi_bank/export.php" class="btn btn-success" >Export ke Excel</a>
	</h3>
	</div>
  
	<div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			
			<tr>
				<th>Tanggal</th>
				<th>No. Kasbon</th>
        <th>Th. Ajaran</th>
				<th>Jenjang</th>
				<!-- <th>Keterangan</th>		 -->
				<th>Akun</th>	
				<th>Debit</th>
				<th>Kredit</th>
			</tr>
		
			<tbody>
			<?php 
				$no = 1;
				$sql = $konektor->query("select * from transaksi_bank ");
				while ($data = $sql->fetch_assoc()) {
					$jenisTransaksi = $data['jenis_transaksi'];
					$rowClass = ($jenisTransaksi == 'Penerimaan') ? 'table-info' : '';
			?>
				<?php if (!empty($data['no_kasbon'])) { ?>

				<tr class="<?php echo $rowClass; ?>">
					<td><?php echo $data['tanggal'] ?></td>
			
					<?php } ?>

				</tr>
			<?php } ?>

			</tbody>
			<hr>
            <table class="table table-bordered table-hover">
              <tr id="input">
                <th style="text-align:center">Akun</th>
                <th style="text-align:center">Jenjang</th>
                <th style="text-align:center">Keterangan</th>
                <th style="text-align:center">Debit</th>
                <th style="text-align:center">Kredit</th>
              </tr>

<tr>
                <th>
                <select class="form-control select2" name="kode_akun" id="kode_akun" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang1" id="kode_jenjang1" required="">
                  <option value="">Pilih Jenjang</option>
                  <?php
                          $query = "SELECT * FROM master_jenjang";
                          $result = $konektor->query($query);
                          $num_result = $result->num_rows;
                          if ($num_result > 0) {
                            while ($data = $result->fetch_assoc()) {
                                $kode_jenjang = $data['kode_jenjang'];
                                $nama_jenjang = $data['nama_jenjang'];
                          ?>
                            <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                          <?php
                            }}
                          ?>
                </select>
                <input type="hidden" id="nama_jenjang1" readonly>
              </th>

              <th><input type="text" name="keterangan1" id="keterangan1" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo1" id="saldo1" oninput="formatNumber(this); calculateTotal();" ></th>
              <th><input style="text-align:center" type="text" class="form-control" name="saldo2" id="saldo2" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun2" id="kode_akun2" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal2 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank2="<?= $akun ?>" data-saldo-normal2="<?= $saldo_normal2 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun2" id="akun2" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal2" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang2" id="kode_jenjang2">
                  <option value="">Pilih Jenjang</option>
                  <?php
                          $query = "SELECT * FROM master_jenjang";
                          $result = $konektor->query($query);
                          $num_result = $result->num_rows;
                          if ($num_result > 0) {
                            while ($data = $result->fetch_assoc()) {
                                $kode_jenjang = $data['kode_jenjang'];
                                $nama_jenjang = $data['nama_jenjang'];
                          ?>
                            <option value="<?= $kode_jenjang ?>" data-name2="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                          <?php
                            }}
                          ?>
                </select>
                <input type="hidden" id="nama_jenjang2" readonly>
              </th>

              <th><input type="text" name="keterangan2" id="keterangan2" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo3" id="saldo3" oninput="formatNumber(this); calculateTotal();" ></th>
              <th><input style="text-align:center" type="text" class="form-control" name="saldo4" id="saldo4" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun3" id="kode_akun3" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal3 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank3="<?= $akun ?>" data-saldo-normal3="<?= $saldo_normal3 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun3" id="akun3" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal3" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang3" id="kode_jenjang3">
                  <option value="">Pilih Jenjang</option>
                  <?php
                          $query = "SELECT * FROM master_jenjang";
                          $result = $konektor->query($query);
                          $num_result = $result->num_rows;
                          if ($num_result > 0) {
                            while ($data = $result->fetch_assoc()) {
                                $kode_jenjang = $data['kode_jenjang'];
                                $nama_jenjang = $data['nama_jenjang'];
                          ?>
                            <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                          <?php
                            }}
                          ?>
                </select>
                <input type="hidden" id="nama_jenjang3" readonly>
              </th>

              <th><input type="text" name="keterangan3" id="keterangan3" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo5" id="saldo5" oninput="formatNumber(this); calculateTotal();" ></th>
              <th><input style="text-align:center" type="text" class="form-control" name="saldo6" id="saldo6" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun4" id="kode_akun4" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal4 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank4="<?= $akun ?>" data-saldo-normal4="<?= $saldo_normal4 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun4" id="akun4" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal4" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang4" id="kode_jenjang4">
                  <option value="">Pilih Jenjang</option>
                  <?php
                          $query = "SELECT * FROM master_jenjang";
                          $result = $konektor->query($query);
                          $num_result = $result->num_rows;
                          if ($num_result > 0) {
                            while ($data = $result->fetch_assoc()) {
                                $kode_jenjang = $data['kode_jenjang'];
                                $nama_jenjang = $data['nama_jenjang'];
                          ?>
                            <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                          <?php
                            }}
                          ?>
                </select>
                <input type="hidden" id="nama_jenjang4" readonly>
              </th>

              <th><input type="text" name="keterangan4" id="keterangan4" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo7" id="saldo7" oninput="formatNumber(this); calculateTotal();" ></th>
              <th><input style="text-align:center" type="text" class="form-control" name="saldo8" id="saldo8" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>

              <tr>
                <th>
                <select class="form-control select2" name="kode_akun5" id="kode_akun5" >
                  <option value="">Pilih Akun</option>
                <?php
                $query = "SELECT * FROM akun WHERE status = 1";
                $result = $konektor->query($query);
                $num_result = $result->num_rows;
                if ($num_result > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $kode_akun = $data['kode_akun'];
                        $akun = $data['nama_akun'];
                        $saldo_normal5 = $data['saldo_normal'];
                ?>
            <option value="<?= $kode_akun ?>" data-bank5="<?= $akun ?>" data-saldo-normal5="<?= $saldo_normal5 ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                <?php
                    }}
                ?>
                </select>
                </th>
              <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun5" id="akun5" readonly>
              <input type="hidden" class="form-control col-sm-4" id="saldo_normal5" readonly>
              <th>
                <select class="form-control select2" name="kode_jenjang5" id="kode_jenjang5">
                  <option value="">Pilih Jenjang</option>
                  <?php
                          $query = "SELECT * FROM master_jenjang";
                          $result = $konektor->query($query);
                          $num_result = $result->num_rows;
                          if ($num_result > 0) {
                            while ($data = $result->fetch_assoc()) {
                                $kode_jenjang = $data['kode_jenjang'];
                                $nama_jenjang = $data['nama_jenjang'];
                          ?>
                            <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                          <?php
                            }}
                          ?>
                </select>
                <input type="hidden" id="nama_jenjang5" readonly>
              </th>

              <th><input type="text" name="keterangan5" id="keterangan5" class="form-control" placeholder="Input Keterangan"></th>

              <th><input style="text-align:center" type="text" class="form-control" name="saldo9" id="saldo9" oninput="formatNumber(this); calculateTotal();" ></th>
              <th><input style="text-align:center" type="text" class="form-control" name="saldo10" id="saldo10" oninput="formatNumber(this); calculateTotal();" ></th>

              </tr>
		</table>
		</div>
	</div>
	</div>
</div>	
<?php
        } else {
            echo "Nomor kasbon $no_kasbon tidak ditemukan";
        }
    } else {
        echo "Error executing SQL query: " . $konektor->error;
    }
} else {
    // Display your original form or an error message
    echo "No kasbon not provided";
}
?>
<!-- Rest of your HTML code for the website -->
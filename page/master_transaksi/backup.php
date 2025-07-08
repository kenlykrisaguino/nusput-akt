<div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Backup Data Master Jurnal</h3>
	</div>

	<div class="card shadow mb-">
	<div class="card-header py-2">
		<h3 class="m-0 font-weight-bold text-primary">  
		<a href="?page=master_transaksi" class="btn btn-primary" >Data Aktif</a> 
		<a href="page/master_transaksi/export2.php" class="btn btn-success" >Export ke Excel</a>
	</h3>
	
	<div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th style="width: 7%; text-align:center">Kode Transaksi</th>
				<th style="width: 20%; text-align:center">Kategori Transaksi</th>
				<th style="width: 23%; text-align:center">Akun Debit</th>
				<th style="width: 23%; text-align:center">Akun Kredit</th>
				<th style="width: 7%; text-align:center">Status</th>
				<th style="width: 12%; text-align:center">Opsi</th>
			</tr>
		</thead>		
		
			<tbody>
				<?php 
					$no = 1;
					$sql = $konektor->query("SELECT * from master_transaksi");
					while ($data = $sql->fetch_assoc()) {	
					?>
					<?php if ($data['status'] == 0) { ?>
						<tr>
							<td><?php echo $data['kode_transaksi'] ?></td>
							<td><?php echo $data['kategori_transaksi'] ?></td>
							<td><?php echo $data['kode_akun_debit'] . " - " . $data['akun_debit']; ?></td>
							<td><?php echo $data['kode_akun_kredit'] . " - " . $data['akun_kredit']; ?></td>
							<td>Non-Aktif</td>
							<td>
							<a href="?page=master_transaksi&aksi=ubah1&kode_transaksi=<?php echo $data['kode_transaksi'] ?>" class="btn btn-info" >Ubah</a>
							<a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=master_transaksi&aksi=hapus&kode_transaksi=<?php echo $data['kode_transaksi'] ?>" class="btn btn-danger" >Hapus</a>
							</td>                      
                    		<?php } ?>
						</tr>
				<?php }?>					
			</tbody>
		</table>
		</div>
	</div>
	</div>
</div>	
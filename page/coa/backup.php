<div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Backup Data Master Chart of Account</h3>
	</div>

	<div class="card shadow mb-">
	<div class="card-header py-2">
		<h3 class="m-0 font-weight-bold text-primary">  
		<a href="?page=coa" class="btn btn-primary" >Data Aktif</a> 
		<a href="page/coa/export.php" class="btn btn-success" >Export ke Excel</a>
	</h3>
	
	</div>

	<div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th>Kode Akun</th>
				<th>Nama Akun</th>
				<th>Klasifikasi</th>
				<th>Saldo Normal</th>
				<!-- <th>Saldo</th> -->
				<th>Status</th>
				<th>Opsi</th>
			</tr>
		</thead>		
		
			<tbody>
				<?php 
					$no = 1;
					$sql = $konektor->query("SELECT * from akun");
					while ($data = $sql->fetch_assoc()) {	
					?>
					<?php if ($data['status'] == 0) { ?>
						<tr>
							<td><?php echo $data['kode_akun'] ?></td>
							<td><?php echo $data['nama_akun'] ?></td>
							<td><?php echo $data['klasifikasi'] ?></td>
							<td><?php echo $data['saldo_normal'] ?></td>
							<!-- <td>Rp. <?=number_format($data['saldo_awal'],0,',','.');?></td> -->
							<td>Non-Aktif</td>
							<td>
							<a href="?page=coa&aksi=ubah2&kode_akun=<?php echo $data['kode_akun'] ?>" class="btn btn-info" >Ubah</a>
							<a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=coa&aksi=hapus&kode_akun=<?php echo $data['kode_akun'] ?>" class="btn btn-danger" >Hapus</a>
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
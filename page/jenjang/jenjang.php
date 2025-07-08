<div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Data Master Jenjang</h3>
	</div>

	<div class="card shadow mb-">
	<div class="card-header py-2">
		<h3 class="m-0 font-weight-bold text-primary"><a href="?page=jenjang&aksi=tambah" class="btn btn-primary" >Tambah Data</a>  
			<a href="?page=jenjang&aksi=backup" class="btn btn-secondary" >Backup Data</a> 
		<a href="page/jenjang/export.php" class="btn btn-success" >Export ke Excel</a>
	</h3>
	
	</div>

	<div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th>Kode Jenjang</th>
				<th>Nama Jenjang</th>
				<th>Kelompok</th>
				<th>Status</th>
				<th>Opsi</th>
			</tr>
		</thead>		
		
			<tbody>
				<?php 
					$no = 1;
					$sql = $konektor->query("select * from master_jenjang");
					while ($data = $sql->fetch_assoc()) {	
					?>
					
					<?php if ($data['status'] == 1) { ?>
						<tr>
							
							<td><?php echo $data['kode_jenjang'] ?></td>
							<td><?php echo $data['nama_jenjang'] ?></td>
							<td><?php echo $data['kelompok'] ?></td>
							<td>Aktif</td>
							<td>
							<a href="?page=jenjang&aksi=ubah1&kode_jenjang=<?php echo $data['kode_jenjang'] ?>" class="btn btn-info">Ubah</a>
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
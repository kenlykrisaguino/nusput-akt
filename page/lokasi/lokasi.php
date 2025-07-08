<div class="container-fluid">
	<div class="card shadow mb-2">
		<div class="card-header py-3">
			<h3 class="m-0 font-weight-bold text-primary">Data Master Lokasi</h3>
		</div>

		<div class="card shadow mb-">
			<div class="card-header py-2">
				<h3 class="m-0 font-weight-bold text-primary"><a href="?page=lokasi&aksi=tambah" class="btn btn-primary">Tambah Data</a>
					<a href="?page=lokasi&aksi=backup" class="btn btn-secondary">Backup Data</a>
					<a href="page/lokasi/export.php" class="btn btn-success">Export ke Excel</a>
				</h3>


			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Kode Lokasi</th>
								<th>Nama Lokasi</th>
								<th>Status</th>
								<th>Opsi</th>
							</tr>
						</thead>

						<tbody>
							<?php
							$no = 1;
							$sql = $konektor->query("SELECT * FROM lokasi");
							while ($data = $sql->fetch_assoc()) {
							?>
								<?php if ($data['status'] == 1) { ?>
									<tr>
										<td><?php echo $data['kode_lokasi'] ?></td>
										<td><?php echo $data['nama_lokasi'] ?></td>
										<td>Aktif</td>
										<td><a href="?page=lokasi&aksi=ubah1&kode_lokasi=<?php echo $data['kode_lokasi'] ?>" class="btn btn-info">Ubah</a></td>
									<?php } ?>
									</tr>
								<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<div class="container-fluid">
	<div class="card shadow mb-2">
		<div class="card-header py-3">
			<h3 class="m-0 font-weight-bold text-primary">Data Master Kegiatan per Jenjang</h3>
		</div>

		<div class="card shadow mb-">
			<div class="card-header py-2">
				<h3 class="m-0 font-weight-bold text-primary"><a href="?page=kegiatan&aksi=tambah" class="btn btn-primary">Tambah Data</a>
					<!-- <a href="?page=kegiatan&aksi=backup" class="btn btn-secondary">Backup Data</a> -->
					<a href="page/kegiatan/export.php" class="btn btn-success">Export ke Excel</a>
				</h3>


			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Kode Jenjang</th>
								<th>Nama Jenjang</th>
								<th>Divisi</th>
								<th>Kode Akun</th>
								<th>Nama Akun</th>
								<th>Kegiatan</th>
								<th>Opsi</th>
							</tr>
						</thead>

						<tbody>
							<?php
							$no = 1;
							$sql = $konektor->query("SELECT * FROM master_kegiatan");
							while ($data = $sql->fetch_assoc()) {
							?>

								<tr>
									<td><?php echo $data['kode_jenjang'] ?></td>
									<td><?php echo $data['nama_jenjang'] ?></td>
									<td><?php echo $data['divisi'] ?></td>
									<td><?php echo $data['kode_akun'] ?></td>
									<td><?php echo $data['nama_akun'] ?></td>
									<td><?php echo $data['kegiatan'] ?></td>
									<td>
										<a href="?page=kegiatan&aksi=hapus&kode_jenjang=<?php echo $data['kode_jenjang']; ?>&kegiatan=<?php echo urlencode($data['kegiatan']); ?>"
											class="btn btn-danger"
											onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">
											Hapus
										</a>
										<a href="?page=kegiatan&aksi=ubah1&kode_jenjang=<?php echo $data['kode_jenjang']; ?>"
											class="btn btn-dark">
											ubah
										</a>
									</td>
								<?php } ?>
								</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
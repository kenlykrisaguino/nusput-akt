<div class="container-fluid">
	<div class="card shadow mb-2">
		<div class="card-header py-3">
			<h3 class="m-0 font-weight-bold text-primary">Data Budgeting</h3>
		</div>

		<div class="card shadow mb-">
			<div class="card-header py-2">
				<h3 class="m-0 font-weight-bold text-primary"><a href="?page=budgeting&aksi=tambah" class="btn btn-primary">Input Budgeting</a>
					<a href="?page=budgeting&aksi=form" class="btn btn-warning text-dark">Realisasi</a>
					<a href="?page=budgeting&aksi=print" class="btn btn-success">Export ke Excel</a>
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
								<th>Nominal</th>
								<th>Rincian</th>
								<th>Sumber Dana</th>
								<th>Opsi</th>
							</tr>
						</thead>

						<tbody>
							<?php
							$no = 1;
							$sql = $konektor->query("SELECT * FROM budgeting");
							while ($data = $sql->fetch_assoc()) {
							?>

									<tr>
										<td><?php echo $data['kode_jenjang'] ?></td>
										<td><?php echo $data['nama_jenjang'] ?></td>
										<td><?php echo $data['divisi'] ?></td>
										<td><?php echo $data['kode_akun'] ?></td>
										<td><?php echo $data['nama_akun'] ?></td>
										<td><?php echo $data['kegiatan'] ?></td>
										<td>Rp. <?=number_format($data['nominal'],0,',','.');?></td>
										<td><?php echo $data['rincian'] ?></td>
										<td><?php echo $data['sumber_dana'] ?></td>
										<td>
										<a href="?page=budgeting&aksi=ubah&kode_jenjang=<?php echo $data['kode_jenjang']; ?>&kegiatan=<?php echo urlencode($data['kegiatan']);  ?>"
											class="btn btn-info">
											Ubah
										</a>
										<a href="?page=budgeting&aksi=hapus&kode_jenjang=<?php echo $data['kode_jenjang']; ?>&kegiatan=<?php echo urlencode($data['kegiatan']); ?>"
											class="btn btn-danger"
											onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">
											Hapus
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




	
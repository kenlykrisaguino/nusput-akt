<div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Data Transaksi Keuangan Dibatalkan</h3>
	</div>

	<div class="card shadow mb-">
	<div class="card-header py-2">
  <!-- <h3 class="m-0 font-weight-bold text-primary"><a href="?page=transaksi" class="btn btn-primary" >Tambah Data</a>   -->
  <a href="?page=transaksi&aksi=data" class="btn btn-info" >Data Transaksi Aktif</a>  
	</h3>
	
	</div>

	<div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		<thead>
			
			<tr>
				<th>Tanggal</th>
				<th>No Transaksi</th>
            			<th>Kategori Transaksi</th>
				<th>Sumber Dana</th>
				<th>Jenjang</th>
				<th>Tahun Ajaran</th>
				<th>Keterangan</th>
				<th>Nominal</th>
			</tr>
		</thead>		
		
			<tbody>
			<?php 
				$no = 1;
				$sql = $konektor->query("select * from transaksi WHERE status = 0 AND sumber_dana != ''");
				while ($data = $sql->fetch_assoc()) {
					$jenisTransaksi = $data['jenis_transaksi'];
					$rowClass =  'table-danger';
			?>
				<?php if ($data['status'] == 0) { ?>

				<tr class="<?php echo $rowClass; ?>">
					<td><?php echo $data['tanggal'] ?></td>
					<td><?php echo $data['no_transaksi'] ?></td>
					<td><?php echo $data['kode_transaksi'] ?></td>
					<td><?php echo $data['sumber_dana'] ?></td>
					<td><?php echo $data['nama_jenjang'] ?></td>
					<td><?php echo $data['tahun_ajaran'] ?></td>
					<td><?php echo $data['keterangan'] ?></td>
					<td>Rp. <?=number_format($data['debit'],0,',','.');?></td>
					<?php } ?>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
	</div>
</div>
<div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Data Transaksi Kas Dibatalkan</h3>
	</div>

	<div class="card shadow mb-">
	<div class="card-header py-2">
  <h3 class="m-0 font-weight-bold text-primary"><a href="?page=transaksi_kas" class="btn btn-primary" >Tambah Data</a>  
  <a href="?page=transaksi_kas&aksi=data" class="btn btn-info" >Data Transaksi</a>  
	</h3>
	
	</div>

	<div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		<thead>
			
			<tr>
				<th>Tanggal</th>
				<th>Transaksi</th>
				<th>No. Transaksi</th>
				<th>Kas</th>	
				<th>Akun</th>			
				<th>Jenjang</th>
        		<th>Th. Ajaran</th>
				<th>Keterangan</th>
				<th>Sumber Dana</th>
				<th>Debit</th>
				<th>Kredit</th>
				<th>No. Kasbon</th>
			</tr>
		</thead>		
		
			<tbody>
			<?php 
				$no = 1;
				$sql = $konektor->query("select * from transaksi_kas ");
				while ($data = $sql->fetch_assoc()) {
					$jenisTransaksi = $data['jenis_transaksi'];
					$rowClass =  'table-danger';
			?>
				<?php if ($data['status'] == 0) { ?>

				<tr class="<?php echo $rowClass; ?>">
					<td><?php echo $data['tanggal'] ?></td>
					<td><?php echo $data['jenis_transaksi'] ?></td>
					<td><?php echo $data['no_transaksi'] ?></td>
					<td><?php echo $data['nama']?></td>
					<td><?php echo $data['nama_akun']?></td>
					<td><?php echo $data['nama_jenjang'] ?></td>
					<td><?php echo $data['tahun_ajaran'] ?></td>
					<td><?php echo $data['keterangan'] ?></td>
					<td><?php echo $data['sumber_dana'] ?></td>
					<td>Rp. <?=number_format($data['debit'],0,',','.');?></td>
					<td>Rp. <?=number_format($data['kredit'],0,',','.');?></td>
					<td><?php echo $data['no_kasbon'] ?></td>
					<?php } ?>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
	</div>
</div>
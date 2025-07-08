<div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Data Penjurnalan Memorial Dibatalkan</h3>
	</div>

	<div class="card shadow mb-">
	<div class="card-header py-2">
  <!-- <h3 class="m-0 font-weight-bold text-primary"><a href="?page=transaksi_memorial" class="btn btn-primary" >Tambah Data</a>   -->
  <a href="?page=transaksi_memorial&aksi=data" class="btn btn-info" >Data Transaksi Aktif</a>  
	</h3>
	
	</div>

	<div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		<thead>
			
			<tr>
				<th>Tanggal</th>
				<th>Sumber Dana</th>				
				<th>No. Transaksi</th>		
				<th>Jenjang</th>
                			<th>Th. Ajaran</th>
				<th>Keterangan</th>
				<th>Akun</th>
				<th>Debit</th>
				<th>Kredit</th>
			</tr>
		</thead>		
		
			<tbody>
			<?php 
				$no = 1;
				$sql = $konektor->query("SELECT * from transaksi_memorial ");
				while ($data = $sql->fetch_assoc()) {
					$rowClass =  'table-danger';
			?>
			
				<?php if ($data['status'] == 0) { ?>
				<tr class="<?php echo $rowClass; ?>">
					<td><?php echo $data['tanggal'] ?></td>
					<td><?php echo $data['sumber_dana'] ?></td>					
					<td><?php echo $data['no_transaksi'] ?></td>					
					<td><?php echo $data['nama_jenjang'] ?></td>
					<td><?php echo $data['tahun_ajaran'] ?></td>
					<td><?php echo $data['keterangan'] ?></td>
					<td><?php echo $data['kode_akun'] . " → " . $data['nama_akun']; ?></td>
					<td>Rp. <?=number_format($data['debit'],0,',','.');?></td>
					<td>Rp. <?=number_format($data['kredit'],0,',','.');?></td>
					<?php } ?>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
	</div>
</div>
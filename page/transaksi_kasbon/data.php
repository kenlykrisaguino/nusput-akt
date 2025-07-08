<div class="container-fluid">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Data Transaksi Kasbon Lunas</h3>
        </div>

        <div class="card shadow mb-2">
            <div class="card-header py-2">
                <h3 class="m-0 font-weight-bold text-primary">
                    <a href="?page=transaksi_kasbon&aksi=input" class="btn btn-primary">Tambah Data</a>  
                    <a href="?page=transaksi_kasbon&aksi=transaksi_cancel" class="btn btn-dark">Transaksi Dibatalkan</a>
                    <a href="?page=transaksi_kasbon&aksi=print" class="btn btn-info">Cetak Bukti</a>
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
                                <th>No. Kasbon</th>
                                <th>Jenjang</th>
                                <th>Th. Ajaran</th>
                                <th>Akun</th>
			                    <th>Keterangan</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>		
		
                        <tbody>
                            <?php 
                            $sql = $konektor->query("SELECT jenis_transaksi, sumber_dana, tanggal, tahun_ajaran, no_transaksi, keterangan, nama_akun, debit, kredit, no_kasbon, nama_jenjang
				FROM transaksi_bank
				WHERE 
				no_kasbon IS NOT NULL 
				AND status = 1 
				AND jenis_transaksi = 'Penerimaan' -- Hanya transaksi dari Penerimaan
				AND nama_jenjang IS NOT NULL -- Pastikan jenjang tidak kosong
				AND no_kasbon IN (
				SELECT no_kasbon FROM transaksi_bank WHERE no_kasbon IS NOT NULL
				GROUP BY no_kasbon
				HAVING 
					SUM(CASE WHEN jenis_transaksi = 'Pengeluaran' THEN debit ELSE 0 END) =
					SUM(CASE WHEN jenis_transaksi = 'Penerimaan' THEN kredit ELSE 0 END)
				)
				ORDER BY tanggal");


                            while ($data = $sql->fetch_assoc()) { 
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($data['tanggal']); ?></td>
                                    <td><?php echo htmlspecialchars($data['sumber_dana']); ?></td>					
                                    <td><?php echo htmlspecialchars($data['no_transaksi']); ?></td>
                                    <td><?php echo htmlspecialchars($data['no_kasbon']); ?></td>					
                                    <td><?php echo htmlspecialchars($data['nama_jenjang']); ?></td>
                                    <td><?php echo htmlspecialchars($data['tahun_ajaran']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nama_akun'])  ?></td>
			                        <td><?php echo htmlspecialchars($data['keterangan']); ?></td>
                                    <td>Rp. <?= number_format($data['debit'], 0, ',', '.'); ?></td>
                                    <td>Rp. <?= number_format($data['kredit'], 0, ',', '.'); ?></td>
                                    <td>
                                    <?php if (!empty($data['sumber_dana'])) { ?>
                                    <a href="?page=transaksi_kasbon&aksi=detail&no_transaksi=<?php echo urlencode($data['no_transaksi']); ?>" class="btn btn-info">Detail</a>
                                    <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=transaksi_kasbon&aksi=cancel&no_transaksi=<?php echo $data['no_transaksi'] ?>" class="btn btn-danger" >Hapus</a>
                                    <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

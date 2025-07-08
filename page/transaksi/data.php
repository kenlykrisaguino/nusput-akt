<div class="container-fluid">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Data Transaksi Keuangan</h3>
        </div>

        <div class="card shadow mb-">
            <div class="card-header py-2">
                <h3 class="m-0 font-weight-bold text-primary">
                    <a href="?page=transaksi" class="btn btn-primary">Tambah Data</a>  
                    <a href="?page=transaksi&aksi=transaksi_cancel" class="btn btn-dark">Transaksi Dibatalkan</a>
                    <a href="?page=transaksi&aksi=print" class="btn btn-info">Cetak Bukti</a>
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
                                <th>Opsi</th>
                            </tr>
                        </thead>      
                        <tbody>
                            <?php 
                                $sql = $konektor->query("SELECT * FROM transaksi WHERE status = 1 AND sumber_dana != ''");
                                while ($data = $sql->fetch_assoc()) {
                                    $jenisTransaksi = $data['jenis_transaksi'];
                                    $rowClass = ($jenisTransaksi == 'Penerimaan') ? 'table-info' : 'table-none';
                            ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td><?php echo $data['tanggal'] ?></td>
                                    <td><?php echo $data['no_transaksi'] ?></td>
                                    <td><?php echo $data['kode_transaksi'] ?></td>
                                    <td><?php echo $data['sumber_dana'] ?></td>
                                    <td><?php echo $data['nama_jenjang'] ?></td>
                                    <td><?php echo $data['tahun_ajaran'] ?></td>
                                    <td><?php echo $data['keterangan'] ?></td>
                                    <td>Rp. <?= number_format($data['debit'], 0, ',', '.'); ?></td>
                                    <td><a href="?page=transaksi&aksi=jurnal&no_transaksi=<?php echo $data['no_transaksi'] ?>" class="btn btn-info" >Jurnal</a>
                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=transaksi&aksi=cancel&no_transaksi=<?php echo $data['no_transaksi'] ?>" class="btn btn-danger">Hapus</a>
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


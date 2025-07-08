<?php
// Koneksi ke database
include "connect.php";

// Periksa apakah parameter lokasi ada
$kode_lokasi = isset($_GET['kode_lokasi']) ? $_GET['kode_lokasi'] : '';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Aset</title>
</head>

<div class="container-fluid">
  <div class="card shadow mb-2">
    <div class="card-header py-3">
      <h3 class="m-0 font-weight-bold text-primary">Daftar Aset di Lokasi: <?php echo htmlspecialchars($kode_lokasi); ?></h3>
    </div>

    <div class="card shadow mb-">
      <div class="card-header py-2">
        <a href="?page=transaksi_bank&aksi=print" class="btn btn-info">Cetak Data</a>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Kode Aset</th>
                <th>Nama Aset</th>
                <th>Spesifikasi</th>
                <th>Kode Lokasi</th>
                <th>Jenjang</th>
                <th>Sumber Dana</th>
                <th>Tanggal Pembelian</th>
                <th>Harga Perolehan</th>
                <th>Umur Ekonomis</th>
                <th>Depresiasi</th>
                <th>Option</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $sql = $konektor->prepare("
                  SELECT aset.*, master_jenjang.nama_jenjang 
                  FROM aset 
                  LEFT JOIN master_jenjang ON aset.kode_jenjang = master_jenjang.kode_jenjang 
                  WHERE aset.kode_lokasi = ?
              ");
              $sql->bind_param("s", $kode_lokasi);
              $sql->execute();
              $result = $sql->get_result();

              while ($data = $result->fetch_assoc()) {
              ?>
                <tr>
                  <td><a href="?page=aset&aksi=detail&kode_aset=<?php echo htmlspecialchars($data['kode_aset']); ?>"><?php echo htmlspecialchars($data['kode_aset']); ?></a></td>
                  <td><?php echo htmlspecialchars($data['nama_aset']); ?></td>
                  <td><?php echo htmlspecialchars($data['spesifikasi']); ?></td>
                  <td><?php echo htmlspecialchars($data['kode_lokasi']); ?></td>
                  <td><?php echo htmlspecialchars($data['nama_jenjang']); ?></td>
                  <td><?php echo htmlspecialchars($data['sumber_dana']); ?></td>
                  <td><?php echo htmlspecialchars($data['tanggal_pembelian']); ?></td>
                  <td>Rp. <?= number_format($data['harga_perolehan'], 0, ',', '.'); ?></td>
                  <td><?php echo htmlspecialchars($data['umur_ekonomis']); ?></td>
                  <td>Rp. <?= number_format($data['depresiasi'], 0, ',', '.'); ?></td>
                  <td>
                    <a href="?page=aset&aksi=ubah&kode_aset=<?php echo htmlspecialchars($data['kode_aset']); ?>" class="btn btn-success">Ubah</a>
                    <a onclick="return confirm('Apakah Anda yakin akan menghapus data ini?')" href="?page=aset&aksi=hapus&kode_aset=<?php echo htmlspecialchars($data['kode_aset']); ?>" class="btn btn-danger">Hapus</a>
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

</body>
</html>

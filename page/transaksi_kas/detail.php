<?php
include 'connect.php'; // Pastikan file koneksi database sudah di-include

// Ambil data dari URL
$jenis_transaksi = $_GET['jenis_transaksi'];
$no_transaksi = $_GET['no_transaksi'];

// Query untuk mendapatkan header transaksi (hanya 1 baris pertama)
$query_header = $konektor->query("SELECT * FROM transaksi_kas WHERE jenis_transaksi = '$jenis_transaksi' AND no_transaksi = '$no_transaksi' LIMIT 1");
$tampil_header = $query_header->fetch_assoc();

// Pastikan data ditemukan
if (!$tampil_header) {
    echo "<script>alert('Data transaksi tidak ditemukan!'); window.location.href='?page=transaksi&aksi=data';</script>";
    exit;
}

// Query untuk mendapatkan detail transaksi tanpa sumber_dana (NULL atau kosong)
$query = $konektor->query("SELECT * FROM transaksi_kas WHERE jenis_transaksi = '$jenis_transaksi' AND no_transaksi = '$no_transaksi' AND (sumber_dana IS NULL OR sumber_dana = '')");

// Variabel untuk menyimpan total transaksi
$total_transaksi = 0;
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">
                Detail Transaksi (<?php echo $jenis_transaksi; ?> - <?php echo $no_transaksi; ?>)
            </h3>
        </div>    

        <div class="card-body">
            <div class="table-responsive">    
                <div class="body">
                    <form method="POST" enctype="multipart/form-data">
                    
                        <label><b>Jenis Transaksi</b></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="jenis_transaksi" readonly value="<?php echo $tampil_header['jenis_transaksi']; ?>" class="form-control"/>
                            </div>
                        </div>

                        <label><b>No Transaksi</b></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="no_transaksi" readonly value="<?php echo $tampil_header['no_transaksi']; ?>" class="form-control"/>
                            </div>
                        </div>

                        <label><b>Akun Kas</b></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="akun" readonly 
                                    value="<?php echo $tampil_header['kode_akun'] . ' → ' . $tampil_header['nama_akun']; ?>" 
                                    class="form-control"/>
                            </div>
                        </div>

                        <label><b>Tanggal</b></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" name="tanggal" readonly value="<?php echo $tampil_header['tanggal']; ?>" class="form-control"/>
                            </div>
                        </div>

                        <label><b>Sumber Dana</b></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="sumber_dana" readonly value="<?php echo $tampil_header['sumber_dana']; ?>" class="form-control"/>
                            </div>
                        </div>

                        <label><b>Tahun Ajaran</b></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="tahun_ajaran" readonly value="<?php echo $tampil_header['tahun_ajaran']; ?>" class="form-control"/>
                            </div>
                        </div>

                        <!-- TABEL DETAIL TRANSAKSI -->
                        <table class="table table-bordered table-hover">
                            <tr style="text-align: center; background-color: #f2f2f2;">
                                <th style="width: 40%;">Akun</th>
                                <th style="width: 15%;">Jenjang</th>
                                <th style="width: 30%;">Keterangan</th>
                                <th style="width: 15%;">Nominal</th>
                            </tr>

                            <?php 
                            // Loop untuk menampilkan data berdasarkan jenis transaksi
                            while ($tampil = $query->fetch_assoc()) { 
                                // Menentukan nominal yang akan ditampilkan berdasarkan jenis transaksi
                                if (strtolower($jenis_transaksi) == "penerimaan") {
                                    $nominal = $tampil['kredit']; // Ambil dari kolom kredit jika penerimaan
                                } else {
                                    $nominal = $tampil['debit']; // Ambil dari kolom debit jika pengeluaran
                                }

                                // Menjumlahkan total transaksi
                                $total_transaksi += $nominal;
                            ?>
                                <tr>
                                    <td>
                                        <input type="text" name="akun" readonly 
                                            value="<?php echo $tampil['kode_akun'] . ' → ' . $tampil['nama_akun']; ?>" 
                                            class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="text" name="jenjang" readonly 
                                            value="<?php echo $tampil['nama_jenjang']; ?>" 
                                            class="form-control text-center"/>
                                    </td>
                                    <td>
                                        <input type="text" name="keterangan" readonly 
                                            value="<?php echo $tampil['keterangan']; ?>" 
                                            class="form-control text-center"/>
                                    </td>
                                    <td>
                                        <input type="text" name="nominal" readonly 
                                            value="<?php echo 'Rp. ' . number_format($nominal, 0, ',', '.'); ?>"
                                            class="form-control text-center"/>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr style="background-color: #e9ecef; font-weight: bold;">
                                <td colspan="3" class="text-center">Total</td>
                                <td>
                                    <input type="text" name="total_debit" readonly 
                                        value="<?php echo 'Rp. ' . number_format($total_transaksi, 0, ',', '.'); ?>" 
                                        class="form-control text-center"/>
                            </td>
                            </tr>

                        </table>


                        <a href="?page=transaksi_bank&aksi=data" class="btn btn-info">Kembali</a>     
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

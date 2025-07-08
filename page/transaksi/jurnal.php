<?php
$no_transaksi = $_GET['no_transaksi'];
$sblm = $konektor->query("SELECT * FROM transaksi WHERE no_transaksi = '$no_transaksi'");
$tampil = $sblm->fetch_assoc();

// Ambil data untuk akun kredit dengan sumber_dana kosong
$kreditQuery = $konektor->query("SELECT * FROM transaksi WHERE no_transaksi = '$no_transaksi' AND sumber_dana = ''");
$kreditTampil = $kreditQuery->fetch_assoc();
?>
 
  <div class="container-fluid">
	<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Jurnal Transaksi (No Transaksi = <?php echo $no_transaksi; ?>)
        </h3>
	</div>	

	<div class="card-body">
	<div class="table-responsive">    
		<div class="body">
		<form method="POST" enctype="multipart/form-data">

        <label><b>Tanggal</b></label>
        <div class="form-group">
            <div class="form-line">
                <input type="date" name="tanggal" readonly value="<?php echo $tampil['tanggal']; ?>" class="form-control"/>
            </div>
        </div>
		
		<label for=""><b>Kode Transaksi</b></label>
		<div class="form-group">
		<div class="form-line">
		    <input type="text" name="kode_transaksi" readonly value="<?php echo $tampil['kode_transaksi']; ?>" class="form-control" required=""/>
		</div>
		</div>

		<label for=""><b>Kategori Transaksi</b></label>
		<div class="form-group">
		<div class="form-line">
		    <input type="text" name="kategori_transaksi" readonly value="<?php echo $tampil['kategori_transaksi']; ?>" class="form-control" required=""/>
		</div>
		</div>

        <label for=""><b>Jenjang</b></label>
		<div class="form-group">
		<div class="form-line">
		    <input type="text" name="nama_jenjang" readonly value="<?php echo $tampil['nama_jenjang']; ?>" class="form-control" required=""/>
		</div>
		</div>

        <label for=""><b>Keterangan</b></label>
		<div class="form-group">
		<div class="form-line">
		    <input type="text" name="keterangan" readonly value="<?php echo $tampil['keterangan']; ?>" class="form-control" required=""/>
		</div>
		</div>

    
       

<table class="table table-bordered table-hover">
    <tr id="input" style="text-align: center; background-color: #f2f2f2;">
        <th style="width: 10%; text-align:center">Keterangan</th>
        <th style="width: 60%; text-align:center">Akun</th>
        <th style="width: 30%; text-align:center">Nominal</th>
    </tr>

    <!-- Baris Pertama (Debit) -->
    <tr>
        <td>
            <input type="text" name="akun_ket" readonly 
                value="Debit" 
                class="form-control text-center" required=""/>
        </td>

        <td>
            <input type="text" name="akun" readonly 
                value="<?php echo $tampil['kode_akun'] . ' → ' . $tampil['nama_akun']; ?>" 
                class="form-control" required=""/>
        </td>

        <td>
            <input type="text" name="debit" readonly 
                value="<?php echo 'Rp. ' . number_format($tampil['debit'], 0, ',', '.'); ?>"
                class="form-control text-center" required=""/>
        </td>
    </tr>

    <!-- Baris Kedua (Kredit) dengan sumber_dana kosong -->
    <?php if ($kreditTampil) { ?>
    <tr>
        <td>
            <input type="text" name="akun_ket2" readonly 
                value="Kredit" 
                class="form-control text-center" required=""/>
        </td>

        <td>
            <input type="text" name="akun2" readonly 
                value="<?php echo $kreditTampil['kode_akun'] . ' → ' . $kreditTampil['nama_akun']; ?>" 
                class="form-control" required=""/>
        </td>

        <td>
            <input type="text" name="kredit" readonly 
                value="<?php echo 'Rp. ' . number_format($kreditTampil['kredit'], 0, ',', '.'); ?>"
                class="form-control text-center" required=""/>
        </td>
    </tr>
    <?php } ?>
</table>


        <a href="?page=transaksi&aksi=data" class="btn btn-info">Kembali</a>     

        










<div class="container-fluid">
    <div class="card shadow mb-2">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Laporan Laba Rugi</h3>
    </div>
        <div class="row">
        <div class="col-md-12">
        <div class="card card-primary">
          </div>     
        <div class="card-body">		
        <form action="export_labarugi.php" method="POST">

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tanggal Awal</b></label>
          <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control col-sm-3" required>
        </div>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tanggal Akhir</b></label>
          <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control col-sm-3" required>
        </div>

<div class="card-body">
<button type="submit" class="btn btn-primary">Cetak</button>
</div>

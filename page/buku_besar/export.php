<div class="container-fluid">
    <div class="card shadow mb-2">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Buku Besar</h3>
    </div>
        <div class="row">
        <div class="col-md-12">
        <div class="card card-primary">
          </div>        
        <div class="card-body">		
        <form action="export_buku_besar.php" method="POST">

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tanggal Awal</b></label>
          <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control col-sm-3" required>
        </div>

        <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Tanggal Akhir</b></label>
          <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control col-sm-3" required>
        </div>

        <!-- <div class="form-group row">
        <label for="nama" class="col-sm-2"><b>Kode Akun </b></label>
          <input type="text" name="kode_akun" id="kode_akun" class="form-control col-sm-3" placeholder="Input Kode Akun" required>
        </div> -->

        <div class="form-group row">
    <label for="kode_akun" class="col-sm-2"><b>Akun</b></label>
    <select name="kode_akun" id="kode_akun" class="form-control col-sm-3" required>
        <option value="">Pilih Akun</option>
        <?php
        include "connect.php";
        $query = "SELECT * FROM akun WHERE status = 1";
        $result = $konektor->query($query);
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                echo "<option value='" . $data['kode_akun'] . "'>" . $data['kode_akun'] . " → " . $data['nama_akun'] . "</option>";
            }
        }
        ?>
    </select>
</div>

<div class="card-body">
<button type="submit" class="btn btn-primary">Cetak</button>
</div>

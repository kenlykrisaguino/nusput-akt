<div class="container-fluid">
    <div class="card shadow mb-2">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Realisasi Budgeting</h3>
    </div>
        <div class="row">
        <div class="col-md-12">
        <div class="card card-primary">
          </div>     
        <div class="card-body">		
        <form action="?page=budgeting&aksi=realisasi" method="POST">

        <div class="form-group row">
                            <label for="kode_tahun" class="col-sm-2"><b>Tahun Ajaran</b></label>
                            <select class="form-control select2 col-sm-9" name="tahun_ajaran" id="tahun_ajaran" required>
                                <option value="">Pilih Tahun Ajaran</option>
                                <?php
                                $query = "SELECT * FROM th_ajaran";
                                $result = $konektor->query($query);
                                if ($result && $result->num_rows > 0) {
                                    while ($data = mysqli_fetch_assoc($result)) {
                                ?>
                                        <option value="<?= $data['tahun_ajaran'] ?>">
                                            <?= $data['tahun_ajaran'] ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="kode_jenjang" class="col-sm-2"><b>Jenjang</b></label>
                            <select class="form-control col-sm-9" name="nama_jenjang" id="nama_jenjang" required>
                                <option value="">Pilih Jenjang</option>
                                <?php
                                $query = "SELECT * FROM master_jenjang";
                                $result = $konektor->query($query);
                                if ($result && $result->num_rows > 0) {
                                    while ($data = mysqli_fetch_assoc($result)) {
                                ?>
                                        <option value="<?= $data['nama_jenjang'] ?>">
                                            <?= $data['nama_jenjang'] ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

<div class="card-body">
<button type="submit" class="btn btn-primary">Filter</button>
</div>
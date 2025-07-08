<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tambah Master Data Transaksi</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Tambah Data Master Jurnal</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form method="POST" enctype="multipart/form-data">
                    
                    <label for="">Kode Transaksi</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="kode_transaksi" id="kode_transaksi" class="form-control" required>
                        </div>
                    </div>

                    <label for="">Kategori Transaksi</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="kategori_transaksi" id="kategori_transaksi" class="form-control" required>
                        </div>
                    </div>

                    <label for="">Akun Debit</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control select2" name="kode_akun_debit" id="kode_akun_debit" required>
                                <option value="">Pilih Akun</option>
                                <?php
                                include "connect.php";
                                $query = "SELECT * FROM akun WHERE status = 1";
                                $result = $konektor->query($query);
                                while ($data = $result->fetch_assoc()) {
                                    echo "<option value='{$data['kode_akun']}' data-nama='{$data['nama_akun']}'>
                                        {$data['kode_akun']} → {$data['nama_akun']}
                                        </option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" name="akun_debit" id="akun_debit">
                        </div>
                    </div>

                    <label for="">Akun Kredit</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control select2" name="kode_akun_kredit" id="kode_akun_kredit" required>
                                <option value="">Pilih Akun</option>
                                <?php
                                include "connect.php";
                                $query = "SELECT * FROM akun WHERE status = 1";
                                $result = $konektor->query($query);
                                while ($data = $result->fetch_assoc()) {
                                    echo "<option value='{$data['kode_akun']}' data-nama='{$data['nama_akun']}'>
                                        {$data['kode_akun']} → {$data['nama_akun']}
                                        </option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" name="akun_kredit" id="akun_kredit">
                        </div>
                    </div>

                    <div class="form-group" style="display: none;">
                        <div class="form-line">
                            <label for="">Status → 0=Non-Aktif; 1=Aktif</label>
                            <select name="status" id="status" class="form-control show-tick" required>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>

                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#kode_akun_debit").change(function () {
            var selectedOption = $(this).find("option:selected");
            var namaAkun = selectedOption.attr("data-nama"); // Ambil Nama Akun
            $("#akun_debit").val(namaAkun); // Simpan Nama Akun ke Input Hidden
            console.log("Akun Debit:", namaAkun); // Debugging
        });

        $("#kode_akun_kredit").change(function () {
            var selectedOption = $(this).find("option:selected");
            var namaAkun = selectedOption.attr("data-nama"); // Ambil Nama Akun
            $("#akun_kredit").val(namaAkun); // Simpan Nama Akun ke Input Hidden
            console.log("Akun Kredit:", namaAkun); // Debugging
        });
    });
</script>

</body>
</html>

<?php
if (isset($_POST['simpan'])) {
    include "connect.php";

    // Debugging untuk cek data yang dikirim
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    $kode_transaksi = $_POST['kode_transaksi'];
    $kategori_transaksi = $_POST['kategori_transaksi'];
    $kode_akun_debit = $_POST['kode_akun_debit'];
    $kode_akun_kredit = $_POST['kode_akun_kredit'];
    $akun_debit = $_POST['akun_debit']; // Nama Akun Debit
    $akun_kredit = $_POST['akun_kredit']; // Nama Akun Kredit
    $status = $_POST['status'];

    // Simpan ke database
    $sql = "INSERT INTO master_transaksi (kode_transaksi, kategori_transaksi, kode_akun_debit, kode_akun_kredit, akun_debit, akun_kredit, status) 
            VALUES('$kode_transaksi', '$kategori_transaksi', '$kode_akun_debit', '$kode_akun_kredit', '$akun_debit', '$akun_kredit', '$status')";

    if (mysqli_query($konektor, $sql)) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location.href='?page=master_transaksi';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($konektor);
    }

    mysqli_close($konektor);
}
?>

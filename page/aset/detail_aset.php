<?php
$kode_aset = $_GET['kode_aset'];
$sql = $konektor->query("SELECT * FROM aset WHERE kode_aset = '$kode_aset'");
$data = $sql->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<body>
    <div class="container-fluid">
        <div class="card shadow mb-2">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">
                    Data Aset <?php echo $data['kode_aset']; ?>
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form method="POST" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">


                            <tr>
			<td><label for="">QR Code Aset</label></td>
			<td align="center"><img src="foto_aset/<?php echo $data['foto_aset']; ?>" width="155" height="200" alt="Foto Aset"><br></td>
		</tr>

                            <tr>
                                <td width="20%"><label for="">Kode Aset</label></td>
                                <td><?php echo $data['kode_aset'] ?></td>
                            </tr>

                            <tr>
                                <td><label for="">Nama Aset</label></td>
                                <td><?php echo $data['nama_aset'] ?></td>
                            </tr>

                            <tr>
                                <td><label for="">Spesifikasi</label></td>
                                <td><?php echo $data['spesifikasi'] ?></td>
                            </tr>

                            <tr>
                                <td><label for="">Kode Lokasi</label></td>
                                <td><?php echo $data['kode_lokasi'] ?></td>
                            </tr>

                            <tr>
                                <td><label for="">Kode Jenjang</label></td>
                                <td><?php echo $data['kode_jenjang'] ?></td>
                            </tr>

                            <tr>
                                <td><label for="">Sumber Dana</label></td>
                                <td><?php echo $data['sumber_dana'] ?></td>
                            </tr>

                            <tr>
                                <td><label for="">Tanggal Pembelian</label></td>
                                <td><?php echo $data['tanggal_pembelian'] ?></td>
                            </tr>

                            <tr>
                                <td><label for="">Harga Perolehan</label></td>
                                <td>Rp. <?php echo number_format($data['harga_perolehan'], 0, ',', '.') ?></td>
                            </tr>

                            <tr>
                                <td><label for="">Umur Ekonomis</label></td>
                                <td><?php echo $data['umur_ekonomis'] ?> bulan</td>
                            </tr>

                            <tr>
                                <td><label for="">Depresiasi</label></td>
                                <td>Rp. <?php echo number_format($data['depresiasi'], 0, ',', '.') ?></td>
                            </tr>

                        </table>
                    </form>

</body>

</html>

<a href="?page=aset&aksi=ubah&kode_aset=<?php echo $data['kode_aset'] ?>" class="btn btn-success">Ubah</a>
<a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=aset&aksi=hapus&kode_aset=<?php echo $data['kode_aset'] ?>" class="btn btn-danger">Hapus</a>
<br>
<br>

<!-- coding submit depresiasi -->

<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Harga Perolehan</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<table border="1">
    <thead>
        <tr>
            <th>Harga Perolehan</th>
        </tr>
    </thead>
    <tbody id="hargaTable">
        <tr>
            <td>Rp. 34.000.000</td>
        </tr>
        <tr>
            <td>Rp. 45.000.000</td>
        </tr>
        <tr>
            <td>Rp. 72.000.000</td>
        </tr>
    </tbody>
</table>

<button id="submitData">Simpan ke Database</button>

<script>
$(document).ready(function(){
    $("#submitData").click(function(){
        let dataHarga = [];

        // Loop semua baris dan ambil nilai harga perolehan
        $("#hargaTable tr").each(function(){
            let hargaText = $(this).find("td").text().trim(); 
            let hargaNumber = hargaText.replace(/[^\d]/g, ''); // Hapus "Rp." dan titik
            dataHarga.push(hargaNumber);
        });

        // Kirim data ke PHP menggunakan AJAX
        $.ajax({
            url: "simpan_data.php",
            type: "POST",
            data: { harga: dataHarga },
            success: function(response){
                alert(response); // Notifikasi hasil penyimpanan
            }
        });
    });
});
</script>

</body>
</html>


include 'koneksi.php'; // Pastikan koneksi database sudah ada

if(isset($_POST['harga'])) {
    $hargaArray = $_POST['harga'];
    $errors = [];

    foreach($hargaArray as $harga) {
        $harga = intval($harga); // Pastikan format angka
        $sql = "INSERT INTO aset (harga_perolehan) VALUES ('$harga')";
        if (!mysqli_query($konektor, $sql)) {
            $errors[] = "Gagal menyimpan: " . mysqli_error($konektor);
        }
    }

    if (empty($errors)) {
        echo "Semua data berhasil disimpan!";
    } else {
        echo implode(", ", $errors);
    }
} -->
<?php
include "connect.php";

// Fungsi untuk mengonversi teks menjadi format slug (tanpa spasi dan karakter aneh)
function createSlug($text) {
    return strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($text)));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
</head>

<div class="container-fluid">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Pencatatan Aset Tetap</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary"></div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">



                    <div class="form-group row">
                    <label class="col-sm-2"><b>Kode Aset</b></label>
                    <input type="text" name="kode_aset" id="kode_aset" class="form-control col-sm-9" readonly>
                </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-2"><b>Nama Aset</b></label>
                            <input type="text" name="nama_aset" id="nama_aset" class="form-control col-sm-9" oninput="generateKodeAset()">
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-2"><b>Spesifikasi Aset</b></label>
                            <input type="text" name="spesifikasi" id="spesifikasi" class="form-control col-sm-9">
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-2"><b>Lokasi</b></label>
                            <select class="form-control select2 col-sm-9" name="kode_lokasi" id="kode_lokasi"  required onchange="generateKodeAset()" required>
                                <option value="">Pilih Lokasi</option>
                                <?php
                                $query = "SELECT * FROM lokasi";
                                $result = $konektor->query($query);
                                if ($result && $result->num_rows > 0) {
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $kode_lokasi = $data['kode_lokasi'];
                                        $nama_lokasi = $data['nama_lokasi'];
                                ?>
                                        <option value="<?= $kode_lokasi ?>" data-tahun="<?= $nama_lokasi ?>"><?= $kode_lokasi . ' → ' . $nama_lokasi ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" class="form-control col-sm-4" id="nama_lokasi" readonly>
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-2"><b>Jenjang</b></label>
                            <select class="form-control select2 col-sm-9" name="kode_jenjang" id="kode_jenjang" required  required="">
                                <option value="">Pilih Jenjang</option>
                                <?php
                                $query = "SELECT * FROM master_jenjang";
                                $result = $konektor->query($query);
                                $num_result = $result->num_rows;
                                if ($num_result > 0) {
                                    while ($data = $result->fetch_assoc()) {
                                        $kode_jenjang = $data['kode_jenjang'];
                                        $nama_jenjang = $data['nama_jenjang'];
                                ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" onchange="generateKodeAset()" readonly>
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-2"><b>Sumber Dana</b></label>
                            <select name="sumber_dana" id="sumber_dana" class="form-control col-sm-9" required onchange="generateKodeAset()" required>
                                <option value="">Pilih Sumber Dana</option>
                                <option value="Investasi">Investasi</option>
                                <option value="BOS">BOS</option>
                                <option value="RAPBS">RAPBS</option>
                                <option value="Bantuan">Bantuan</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-2"><b>Tanggal Pembelian</b></label>
                            <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="form-control col-sm-9" placeholder="Input Tanggal Pembelian">
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-2"><b>Harga Perolehan</b></label>
                            <input type="text" name="harga_perolehan" id="harga_perolehan" class="form-control col-sm-9" oninput="formatNumber(this); calculateDepreciation()" placeholder="Input Harga Perolehan">
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-2"><b>Umur Ekonomis (Dalam Bulan) </b></label>
                            <input type="text" name="umur_ekonomis" id="umur_ekonomis" class="form-control col-sm-9" oninput="formatNumber(this); calculateDepreciation()" placeholder="Masukkan Umur Ekonomis">
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-2"><b>Depresiasi</b></label>
                            <input type="text" name="Jdepresiasi" id="Jdepresiasi" class="form-control col-sm-9" placeholder="Hasil Depresiasi" readonly>
                            <input type="hidden" name="depresiasi" id="depresiasi" readonly>

                        </div>

                        <div class="card-body">
                            <button type="submit" name="simpan" value="Simpan" class="btn btn-primary" onclick="prepareSubmission()">Simpan</button>
                        </div>


                        <script>
                            function formatNumber(input) {
                                var value = input.value.replace(/[^0-9.]/g, '');
                                var parts = value.split('.');
                                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                input.value = parts.join('.');
                            }

                            function removeFormat(input) {
                                input.value = input.value.replace(/,/g, '');
                            }

                            function calculateDepreciation() {

                                var harga_perolehan = parseFloat(document.getElementById('harga_perolehan').value.replace(/,/g, '')) || 0;
                                var umur_ekonomis = parseFloat(document.getElementById('umur_ekonomis').value.replace(/,/g, '')) || 0;

                                var depresiasi = harga_perolehan / umur_ekonomis;
                                var formattedTotal = depresiasi.toLocaleString('id-ID');
                                document.getElementById('Jdepresiasi').value = formattedTotal;
                                document.getElementById('depresiasi').value = depresiasi;
                            }

                            function prepareSubmission() {
                                removeFormat(document.getElementById('harga_perolehan'));
                                removeFormat(document.getElementById('umur_ekonomis'));
                                removeFormat(document.getElementById('depresiasi'));

                            }
                            function generateKodeAset() {
                            let namaJenjang = document.getElementById("kode_jenjang").options[document.getElementById("kode_jenjang").selectedIndex].dataset.name;
                            let namaAset = document.getElementById("nama_aset").value.trim();
                            let kodeLokasi = document.getElementById("kode_lokasi").value;
                            let sumberDana = document.getElementById("sumber_dana").value;

                            if (namaJenjang && namaAset && kodeLokasi && sumberDana) {
                                // Format kode aset: namaJenjang/namaAset/kodeLokasi/sumberDana
                                let kodeAset = `${namaJenjang}/${namaAset}/${kodeLokasi}/${sumberDana}`;
                                kodeAset = kodeAset.replace(/\s+/g, '-').toUpperCase(); // Format slug tanpa spasi
                                document.getElementById("kode_aset").value = kodeAset;
                            }
                        }
                        </script>

                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        $kode_aset = $_POST['kode_aset'];
                        $nama_aset = $_POST['nama_aset'];
                        $spesifikasi = $_POST['spesifikasi'];
                        $kode_lokasi = $_POST['kode_lokasi']; // Sesuai dengan form
                        $kode_jenjang = $_POST['kode_jenjang']; // Tambahan jika diperlukan
                        $sumber_dana = $_POST['sumber_dana'];
                        $tanggal_pembelian = $_POST['tanggal_pembelian'];
                        $harga_perolehan = $_POST['harga_perolehan']; // Menghapus format angka
                        $umur_ekonomis = $_POST['umur_ekonomis'];
                        $depresiasi = $_POST['depresiasi'];

                        $sql = "INSERT INTO aset (kode_aset, nama_aset, spesifikasi, kode_lokasi, kode_jenjang, sumber_dana, tanggal_pembelian, harga_perolehan, umur_ekonomis, depresiasi) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
                            $stmt = $konektor->prepare($sql);
                            $stmt->bind_param("ssssssssss", $kode_aset, $nama_aset, $spesifikasi, $kode_lokasi, $kode_jenjang, $sumber_dana, $tanggal_pembelian, $harga_perolehan, $umur_ekonomis, $depresiasi);
                        
                            if ($stmt->execute()) {
                                echo "<script>alert('Data Berhasil Disimpan!'); window.location.href = '?page=aset';</script>";
                            } else {
                                echo "Error: " . $stmt->error;
                            }
                        
                            $stmt->close();
                
                        }
                        mysqli_close($konektor);
                        ?>
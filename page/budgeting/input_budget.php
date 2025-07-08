<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connect.php';
    error_reporting(E_ALL); // Tampilkan semua error
    ini_set('display_errors', 1);

    $tahun_ajaran = $_POST['tahun_ajaran'];

    if (!isset($_POST['kode_jenjang'])) {
        die("Data tidak lengkap!");
    }

    for ($i = 0; $i < count($_POST['saldo']); $i++) {
        $kode_jenjang = $_POST['kode_jenjang'][$i] ?? '';
        $nama_jenjang = $_POST['nama_jenjang'][$i] ?? '';
        $divisi = $_POST['divisi'][$i] ?? '';
        $kode_akun = $_POST['kode_akun'][$i] ?? '';
        $nama_akun = $_POST['nama_akun'][$i] ?? '';
        $kegiatan = $_POST['kegiatan'][$i] ?? '';
        $nominal = str_replace(['.', ','], '', $_POST['saldo'][$i]); // Bersihkan format angka
        $rincian = $_POST['rincian'][$i] ?? '';
        $sumber_dana = $_POST['sumber_dana'][$i] ?? '';

        // Pastikan semua data tidak kosong sebelum disimpan
        if (!empty($kode_jenjang) && !empty($nama_jenjang) && !empty($divisi) && !empty($kode_akun) && !empty($nama_akun) && !empty($kegiatan) && !empty($nominal) && !empty($rincian) && !empty($sumber_dana)) {

            $insert = $konektor->prepare("INSERT INTO budgeting (tahun_ajaran, kode_jenjang, nama_jenjang, divisi, kode_akun, nama_akun, kegiatan, nominal, rincian, sumber_dana) 
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->bind_param("ssssssssss", $tahun_ajaran, $kode_jenjang, $nama_jenjang, $divisi, $kode_akun, $nama_akun, $kegiatan, $nominal, $rincian, $sumber_dana);
            
            if (!$insert->execute()) {
                die("Error saat menyimpan data: " . $insert->error);
            }
        } else {
            echo "Data tidak lengkap, tidak disimpan.<br>";
        }
    }

    echo "<script>alert('Data budgeting berhasil disimpan!'); window.location.href='index.php';</script>";
}
?>


<div class="container-fluid">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Budgeting</h3>
        </div>
        <div class="card-body">
            <form method="POST" id="budgeting-form" enctype="multipart/form-data">
                <!-- Dropdown Tahun Ajaran -->
                <div class="form-group row">
                    <label for="kode_tahun" class="col-sm-2"><b>Tahun Ajaran</b></label>
                    <select class="form-control select2 col-sm-9" name="tahun_ajaran" id="kode_tahun" required>
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

                <!-- Dropdown Jenjang -->
                <div class="form-group row mt-2">
                    <label for="kode_jenjang" class="col-sm-2"><b>Jenjang</b></label>
                    <select class="form-control select2 col-sm-9" name="kode_jenjang" id="kode_jenjang" required>
                        <option value="">Pilih Jenjang</option>
                        <?php
                        $query = "SELECT DISTINCT kode_jenjang, nama_jenjang FROM master_kegiatan";
                        $result = $konektor->query($query);
                        if ($result && $result->num_rows > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                                <option value="<?= $data['kode_jenjang'] ?>">
                                    <?= $data['nama_jenjang'] ?>
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <!-- Tabel Budgeting -->
                <div id="budgeting-table" style="display: none;">
                    <table class="table table-bordered table-hover mt-4">
                        <tr style="text-align: center; background-color: #f2f2f2;">
                            <th>Jenjang</th>
                            <th>Divisi</th>
                            <th>Akun</th>
                            <th>Kegiatan</th>
                            <th>Nominal</th>
                            <th>Rincian</th>
                            <th>Sumber Dana</th>
                        </tr>

                        <?php
                        $query = "SELECT * FROM master_kegiatan";
                        $result = $konektor->query($query);
                        if ($result && $result->num_rows > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr class="jenjang-row" data-jenjang="<?= $data['kode_jenjang'] ?>" style="display: none;">
                                    <td><?= htmlspecialchars($data['nama_jenjang']); ?></td>
                                    <td><?= htmlspecialchars($data['divisi']); ?></td>
                                    <td><?= htmlspecialchars($data['kode_akun']) . " → " . htmlspecialchars($data['nama_akun']); ?></td>
                                    <td><?= htmlspecialchars($data['kegiatan']); ?></td>
                                    <input type="hidden" name="kode_jenjang[]" value="<?= $data['kode_jenjang'] ?>">
                                <input type="hidden" name="nama_jenjang[]" value="<?= $data['nama_jenjang'] ?>">
                                <input type="hidden" name="divisi[]" value="<?= $data['divisi'] ?>">
                                <input type="hidden" name="kode_akun[]" value="<?= $data['kode_akun'] ?>">
                                <input type="hidden" name="nama_akun[]" value="<?= $data['nama_akun'] ?>">
                                <input type="hidden" name="kegiatan[]" value="<?= $data['kegiatan'] ?>">
                                    <td>
                                        <input type="text" class="form-control text-end" name="saldo[]" oninput="formatNumber(this);" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="rincian[]" placeholder="Input Rincian" required>
                                    </td>
                                    <td>
                                        <select name="sumber_dana[]" class="form-control" required>
                                            <option value="">Pilih Sumber Dana</option>
                                            <option value="Rutin">Rutin</option>
                                            <option value="BOS">BOS</option>
                                            <option value="Titipan Siswa">Titipan Siswa</option>
                                        </select>
                                    </td>

                                </tr>


                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan</td></tr>";
                        }
                        ?>
                    </table>
                </div>

                <!-- Tombol Submit Pindah ke Luar Tabel -->
                <div class="mt-3">
                    <button type="button" id="submit-budgeting" class="btn btn-primary">Simpan Budgeting</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById("kode_jenjang").addEventListener("change", function() {
        var selectedJenjang = this.value;
        document.getElementById("budgeting-table").style.display = "block";

        document.querySelectorAll(".jenjang-row").forEach(function(row) {
            row.style.display = (row.getAttribute("data-jenjang") === selectedJenjang) ? "" : "none";
        });
    });

    function formatNumber(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    // **Simpan data sebelum submit**
    document.getElementById("kode_jenjang").addEventListener("change", function() {
        var selectedJenjang = this.value;
        document.getElementById("budgeting-table").style.display = "block";

        document.querySelectorAll(".jenjang-row").forEach(function(row) {
            row.style.display = (row.getAttribute("data-jenjang") === selectedJenjang) ? "" : "none";
        });
    });

    function formatNumber(input) {
        let value = input.value.replace(/\D/g, ''); // Hanya angka
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    // **Simpan data sebelum submit**
    document.getElementById("submit-budgeting").addEventListener("click", function(event) {
    event.preventDefault(); 

    let form = document.getElementById("budgeting-form");
    let rows = document.querySelectorAll(".jenjang-row");

    // Hapus input hidden sebelumnya
    document.querySelectorAll(".hidden-input").forEach(e => e.remove());

    let tahunAjaran = document.getElementById("kode_tahun").value;
    let kodeJenjang = document.getElementById("kode_jenjang").value;

    form.innerHTML += `<input type="hidden" class="hidden-input" name="tahun_ajaran" value="${tahunAjaran}">`;
    
    rows.forEach(row => {
        if (row.style.display !== "none") {
            let saldo = row.querySelector("input[name='saldo[]']").value.replace(/\D/g, '');
            let rincian = row.querySelector("input[name='rincian[]']").value.trim();
            let sumber = row.querySelector("select[name='sumber_dana[]']").value;

            let namaJenjang = row.cells[0].textContent.trim();
            let divisi = row.cells[1].textContent.trim();
            let akun = row.cells[2].textContent.split(" → ");
            let kodeAkun = akun[0].trim();
            let namaAkun = akun[1].trim();
            let kegiatan = row.cells[3].textContent.trim();

            if (saldo && rincian && sumber) {
                form.innerHTML += `<input type="hidden" class="hidden-input" name="kode_jenjang[]" value="${kodeJenjang}">`;
                form.innerHTML += `<input type="hidden" class="hidden-input" name="nama_jenjang[]" value="${namaJenjang}">`;
                form.innerHTML += `<input type="hidden" class="hidden-input" name="divisi[]" value="${divisi}">`;
                form.innerHTML += `<input type="hidden" class="hidden-input" name="kode_akun[]" value="${kodeAkun}">`;
                form.innerHTML += `<input type="hidden" class="hidden-input" name="nama_akun[]" value="${namaAkun}">`;
                form.innerHTML += `<input type="hidden" class="hidden-input" name="kegiatan[]" value="${kegiatan}">`;
                form.innerHTML += `<input type="hidden" class="hidden-input" name="saldo[]" value="${saldo}">`;
                form.innerHTML += `<input type="hidden" class="hidden-input" name="rincian[]" value="${rincian}">`;
                form.innerHTML += `<input type="hidden" class="hidden-input" name="sumber_dana[]" value="${sumber}">`;
            }
        }
    });

    form.submit(); 
});

</script>
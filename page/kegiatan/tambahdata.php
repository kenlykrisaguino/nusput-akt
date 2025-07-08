<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tambah Data Master Kegiatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function updateNamaJenjang() {
            let select = document.getElementById("kode_jenjang");
            let selectedOption = select.options[select.selectedIndex];
            document.getElementById("nama_jenjang").value = selectedOption.getAttribute("data-nama");
        }

        function updateNamaAkun(divisiId, akunId) {
            let select = document.getElementById(`kode_akun${divisiId}_${akunId}`);
            let selectedOption = select.options[select.selectedIndex];
            document.getElementById(`nama_akun${divisiId}_${akunId}`).value = selectedOption.getAttribute("data-nama");
        }
    </script>
</head>

<body>
    <?php
    include 'connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $kode_jenjang = $_POST['kode_jenjang'];

        // Ambil nama_jenjang dari database berdasarkan kode_jenjang
        $query_jenjang = "SELECT nama_jenjang FROM master_jenjang WHERE kode_jenjang = ?";
        $stmt = $konektor->prepare($query_jenjang);
        $stmt->bind_param("s", $kode_jenjang);
        $stmt->execute();
        $result_jenjang = $stmt->get_result();
        $data_jenjang = $result_jenjang->fetch_assoc();
        $stmt->close();

        // Pastikan nama_jenjang tidak kosong
        $nama_jenjang = $data_jenjang['nama_jenjang'] ?? 'Tidak Diketahui';

        // Ambil jumlah data terakhir untuk kode_jenjang ini
        $query = "SELECT COUNT(*) as jumlah FROM master_kegiatan WHERE kode_jenjang = ?";
        $stmt = $konektor->prepare($query);
        $stmt->bind_param("s", $kode_jenjang);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();



        // Looping untuk setiap Divisi
        foreach ($_POST['divisi'] as $divisi_index => $divisi_nama) {
            foreach ($_POST['kode_akun'][$divisi_index] as $akun_index => $kode_akun) {
                $nama_akun = $_POST['nama_akun'][$divisi_index][$akun_index];

                foreach ($_POST['kegiatan'][$divisi_index][$akun_index] as $kegiatan_nama) {
                    // Pastikan kode budgeting tidak null


                    // Simpan data ke database
                    $stmt = $konektor->prepare("INSERT INTO master_kegiatan (kode_jenjang, nama_jenjang, divisi, kode_akun, nama_akun, kegiatan) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $kode_jenjang, $nama_jenjang, $divisi_nama, $kode_akun, $nama_akun, $kegiatan_nama);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        echo "<script>alert('Data berhasil disimpan!'); window.location.href='index.php?page=kegiatan';</script>";
    }
    ?>

<head>
    <meta charset="utf-8">
    <title>Tambah Data Master Kegiatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function updateNamaJenjang() {
            let select = document.getElementById("kode_jenjang");
            let selectedOption = select.options[select.selectedIndex];
            document.getElementById("nama_jenjang").value = selectedOption.getAttribute("data-nama");
        }

        function tambahDivisi() {
            let container = document.getElementById("formContainer");
            let divisiCount = container.children.length;
            let divisiId = `divisi_${divisiCount}`;

            let divisiDiv = document.createElement("div");
            divisiDiv.classList.add("border", "p-3", "mb-3");
            divisiDiv.setAttribute("id", divisiId);

            divisiDiv.innerHTML = `
                <div class="form-group d-flex align-items-center">
                    <label class="mr-2">Divisi</label>
                    <input type="text" class="form-control" name="divisi[]" required style="width: 500px;">
                    <button type="button" class="btn btn-danger btn-sm ml-3" onclick="hapusDivisi('${divisiId}')">Hapus Divisi</button>
                </div>
                <div id="akunContainer_${divisiCount}" class="ml-4"></div>
                <button type="button" class="btn btn-dark btn-sm" onclick="tambahKodeAkun(${divisiCount})">Tambah Kode Akun</button>
            `;

            container.appendChild(divisiDiv);
        }

        function tambahKodeAkun(divisiId) {
            let container = document.getElementById(`akunContainer_${divisiId}`);
            let akunCount = container.children.length;
            let akunId = `akun_${divisiId}_${akunCount}`;

            let akunDiv = document.createElement("div");
            akunDiv.classList.add("border", "p-3", "mb-3");
            akunDiv.setAttribute("id", akunId);

            akunDiv.innerHTML = `
                <div class="form-group d-flex align-items-center">
                    <label class="mr-2">Kode Akun</label>
                    <select class="form-control" name="kode_akun[${divisiId}][]" id="kode_akun${divisiId}_${akunCount}" required onchange="updateNamaAkun(${divisiId}, ${akunCount})">
                        <option value="">Pilih Akun</option>
                        <?php
                        include 'connect.php';
                        $query = "SELECT * FROM akun WHERE status = 1";
                        $result = $konektor->query($query);
                        while ($data = $result->fetch_assoc()) {
                            echo '<option value="' . $data['kode_akun'] . '" data-nama="' . $data['nama_akun'] . '">' . $data['kode_akun'] . ' → ' . $data['nama_akun'] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="hidden" name="nama_akun[${divisiId}][]" id="nama_akun${divisiId}_${akunCount}">
                    <button type="button" class="btn btn-danger btn-sm ml-2" onclick="hapusKodeAkun('${akunId}', ${divisiId}, ${akunCount})">Hapus</button>
                </div>
                <div id="kegiatanContainer_${divisiId}_${akunCount}" class="ml-4"></div>
                <button type="button" class="btn btn-warning btn-sm" id="btnKegiatan_${divisiId}_${akunCount}" onclick="tambahKegiatan(${divisiId}, ${akunCount})">Tambah Kegiatan</button>
            `;

            container.appendChild(akunDiv);
        }

        function tambahKegiatan(divisiId, akunId) {
            let container = document.getElementById(`kegiatanContainer_${divisiId}_${akunId}`);
            let kegiatanDiv = document.createElement("div");
            kegiatanDiv.classList.add("form-group", "d-flex", "align-items-center");

            kegiatanDiv.innerHTML = `
                <label class="mr-2">Kegiatan</label>
                <input type="text" name="kegiatan[${divisiId}][${akunId}][]" class="form-control mr-2" required>
                <button type="button" class="btn btn-danger btn-sm" onclick="hapusField(this)">Hapus</button>
            `;

            container.appendChild(kegiatanDiv);
        }

        function hapusField(button) {
            button.parentElement.remove();
        }

        function hapusKodeAkun(akunId, divisiId, akunIndex) {
            let akunDiv = document.getElementById(akunId);
            let kegiatanContainer = document.getElementById(`kegiatanContainer_${divisiId}_${akunIndex}`);
            let btnKegiatan = document.getElementById(`btnKegiatan_${divisiId}_${akunIndex}`);

            if (kegiatanContainer) kegiatanContainer.innerHTML = ""; // Hapus semua kegiatan dalam akun
            if (btnKegiatan) btnKegiatan.remove(); // Hapus tombol "Tambah Kegiatan"
            if (akunDiv) akunDiv.remove(); // Hapus akun itu sendiri
        }

        function hapusDivisi(divisiId) {
            let divisiDiv = document.getElementById(divisiId);
            if (divisiDiv) divisiDiv.remove();
        }
    </script>
</head>

<body>
    <div class="container-fluid mt-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Tambah Data Master Kegiatan</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group row">
                        <label for="kode_jenjang" class="col-sm-2"><b>Jenjang</b></label>
                        <select class="form-control col-sm-9" name="kode_jenjang" id="kode_jenjang" required onchange="updateNamaJenjang()">
                            <option value="">Pilih Jenjang</option>
                            <?php
                            $query = "SELECT * FROM master_jenjang";
                            $result = $konektor->query($query);
                            while ($data = $result->fetch_assoc()) {
                                echo '<option value="' . $data['kode_jenjang'] . '" data-nama="' . $data['nama_jenjang'] . '">' . $data['kode_jenjang'] . ' → ' . $data['nama_jenjang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="nama_jenjang" id="nama_jenjang">

                    <div id="formContainer"></div>

                    <button type="button" class="btn btn-primary mt-2" onclick="tambahDivisi()">Tambah Divisi</button>
                    <button type="submit" class="btn btn-success mt-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
// Koneksi ke database
include 'connect.php'; // Pastikan file koneksi ada

// Dapatkan tahun ajaran & jenjang dari halaman lain (misalnya dari $_POST atau session)
$tahun_ajaran = isset($_POST['tahun_ajaran']) ? $_POST['tahun_ajaran'] : '';
$nama_jenjang = isset($_POST['nama_jenjang']) ? $_POST['nama_jenjang'] : '';

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Budgeting</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>

    <div class="container-fluid mt-4">
        <div class="card shadow mb-2">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary text-center">REALISASI RAPBS JENJANG <?= htmlspecialchars($nama_jenjang) ?> TAHUN AJARAN <?= htmlspecialchars($tahun_ajaran) ?></h3>
            </div>

            <div class="card shadow mb-">
                <div class="card-header py-2">
                    <!-- <h3 class="m-0 font-weight-bold text-primary"><a href="?page=budgeting&aksi=tambah" class="btn btn-primary">Input Budgeting</a>
                        <a href="?page=budgeting&aksi=form" class="btn btn-warning text-dark">Realisasi</a> -->
                        <a href="export_realisasi.php?tahun_ajaran=<?= urlencode($tahun_ajaran) ?>&nama_jenjang=<?= urlencode($nama_jenjang) ?>" class="btn btn-success">Export ke Excel</a>
                        </div>

                <!-- Gunakan Grid agar tabel sejajar -->
                <div class=card-body>
                    <div class="row d-flex">

                        <!-- Tabel Budgeting -->
                        <div class="col-md-5">
                            <table class="table table-bordered table-hover mt-4" style="width: 100%;">
                                <tr class="text-center" style="background-color: #f2f2f2;">
                                    <th>Divisi</th> <!-- Kolom baru untuk Divisi -->

                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Total Anggaran</th>
                                </tr>
                                <?php
                                // Query untuk tabel 1 (Total Budgeting dengan Divisi)
                                $query1 = "SELECT kode_akun, nama_akun, divisi, SUM(nominal) AS total_nominal 
                   FROM budgeting 
                   WHERE tahun_ajaran = ? 
                   AND nama_jenjang = ? 
                   GROUP BY kode_akun, nama_akun, divisi";

                                $stmt = $konektor->prepare($query1);
                                $stmt->bind_param("ss", $tahun_ajaran, $nama_jenjang);
                                $stmt->execute();
                                $result1 = $stmt->get_result();

                                $budget_data = [];
                                if ($result1->num_rows > 0) {
                                    while ($data = $result1->fetch_assoc()) {
                                        $budget_data[$data['kode_akun']] = $data['total_nominal']; // Simpan total nominal berdasarkan kode akun
                                        echo "<tr>
                                                            <td>" . htmlspecialchars($data['divisi']) . "</td> <!-- Menampilkan divisi -->

                    <td>" . htmlspecialchars($data['kode_akun']) . "</td>
                    <td>" . htmlspecialchars($data['nama_akun']) . "</td>
                    <td>Rp. " . number_format($data['total_nominal'], 0, ',', '.') . "</td>
                </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>Data tidak ditemukan</td></tr>";
                                }
                                ?>
                            </table>
                        </div>





                        <!-- Tabel 3 Penggunaan Budget -->
                        <div class="col-md-5">
                            <table class="table table-bordered table-hover mt-4" style="width: 100%;">


                                <tr class="text-center" style="background-color: #f2f2f2;">
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Total Digunakan</th>
                                </tr>
                                <?php
                                // Pastikan array kosong sebelum digunakan
                                $nominal_terpakai = [];

                                // Query untuk mengambil total penggunaan budget
                                $query2 = "SELECT 
                                        budgeting.kode_akun, 
                                        budgeting.nama_akun, 
                                        akun.saldo_normal, 
                                        SUM(
                                            (SELECT COALESCE(SUM(debit), 0) FROM transaksi_kas WHERE status = 1 AND budgeting.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tahun_ajaran = ? AND transaksi_kas.nama_jenjang = ?)
                                        ) +
                                        SUM(
                                            (SELECT COALESCE(SUM(debit), 0) FROM transaksi_bank WHERE status = 1 AND budgeting.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tahun_ajaran = ? AND transaksi_bank.nama_jenjang = ?)
                                        ) +
                                        SUM(
                                            (SELECT COALESCE(SUM(debit), 0) FROM transaksi_memorial WHERE status = 1 AND budgeting.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tahun_ajaran = ? AND transaksi_memorial.nama_jenjang = ?)
                                        ) AS total_debit,

                                        SUM(
                                            (SELECT COALESCE(SUM(kredit), 0) FROM transaksi_kas WHERE status = 1 AND budgeting.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tahun_ajaran = ? AND transaksi_kas.nama_jenjang = ?)
                                        ) +
                                        SUM(
                                            (SELECT COALESCE(SUM(kredit), 0) FROM transaksi_bank WHERE status = 1 AND budgeting.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tahun_ajaran = ? AND transaksi_bank.nama_jenjang = ?)
                                        ) +
                                        SUM(
                                            (SELECT COALESCE(SUM(kredit), 0) FROM transaksi_memorial WHERE status = 1 AND budgeting.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tahun_ajaran = ? AND transaksi_memorial.nama_jenjang = ?)
                                        ) AS total_kredit

                                    FROM budgeting
                                    LEFT JOIN akun ON budgeting.kode_akun = akun.kode_akun
                                    WHERE budgeting.tahun_ajaran = ? AND budgeting.nama_jenjang = ?
                                    GROUP BY budgeting.kode_akun, budgeting.nama_akun, akun.saldo_normal";

                                $stmt = $konektor->prepare($query2);
                                $stmt->bind_param(
                                    "ssssssssssssss", // 14 parameter
                                    $tahun_ajaran,
                                    $nama_jenjang,
                                    $tahun_ajaran,
                                    $nama_jenjang,
                                    $tahun_ajaran,
                                    $nama_jenjang,
                                    $tahun_ajaran,
                                    $nama_jenjang,
                                    $tahun_ajaran,
                                    $nama_jenjang,
                                    $tahun_ajaran,
                                    $nama_jenjang,
                                    $tahun_ajaran,
                                    $nama_jenjang // Tambahan 2 parameter terakhir untuk WHERE
                                );

                                $stmt->execute();
                                $result2 = $stmt->get_result();

                                // Simpan nominal yang dipakai
                                if ($result2->num_rows > 0) {
                                    while ($data = $result2->fetch_assoc()) {
                                        $total_debit = $data['total_debit'];
                                        $total_kredit = $data['total_kredit'];
                                        $saldo_normal = $data['saldo_normal'];

                                        // Hitung nominal berdasarkan saldo normal
                                        if ($saldo_normal == 'Debit') {
                                            $nominal = $total_debit - $total_kredit;
                                        } else {
                                            $nominal = $total_kredit - $total_debit;
                                        }

                                        // Simpan nominal yang dipakai untuk perhitungan persentase
                                        $nominal_terpakai[$data['kode_akun']] = $nominal;

                                        echo "<tr>
                        <td>" . htmlspecialchars($data['kode_akun']) . "</td>
                        <td>" . htmlspecialchars($data['nama_akun']) . "</td>
                        <td>Rp. " . number_format($nominal, 0, ',', '.') . "</td>
                      </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>Data tidak ditemukan</td></tr>";
                                }
                                ?>
                            </table>


                        </div>

                        <!-- Tabel Persentase Penggunaan Budget -->
                        <div class="col-md-2">
                            <table class="table table-bordered table-hover mt-4 text-center" style="width: 100%;">
                                <tr style="background-color: #f2f2f2;">
                                    <th>Persentase Penggunaan</th>
                                </tr>
                                <?php
                                foreach ($budget_data as $kode_akun => $total_nominal) {
                                    $nominal_digunakan = isset($nominal_terpakai[$kode_akun]) ? $nominal_terpakai[$kode_akun] : 0;
                                    $persentase = ($total_nominal > 0) ? ($nominal_digunakan / $total_nominal) * 100 : 0;

                                    echo "<tr>
                <td>" . number_format($persentase, 2, ',', '.') . "%</td>
            </tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div> <!-- End Row -->
                </div>

            </div>
        </div>

</body>

</html>
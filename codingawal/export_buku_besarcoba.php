<?php
if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {
    $konektor = mysqli_connect("localhost", "root", "", "1_nusaputera");

    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $kode_akun = $_POST['kode_akun'];
    $nama_akun = $_POST['nama_akun'];


    $tanggal_awal_edit = date('F Y', strtotime($_POST['tanggal_awal']));
    $tanggal_akhir_edit = strtoupper(date('F Y', strtotime($_POST['tanggal_akhir'])));
    

    $tanggal_awal_edit2 = date('d-m-Y', strtotime($_POST['tanggal_awal']));
    $tanggal_akhir_edit2 = date('d-m-Y', strtotime($_POST['tanggal_akhir']));

    $filename = "Buku Besar Akun " . $kode_akun . " Periode " . $tanggal_awal_edit . ".xls";

    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");

    echo "<h3>LAPORAN BUKU BESAR AKUN $kode_akun SEKOLAH NUSAPUTERA BULAN $tanggal_akhir_edit <br>Periode $tanggal_awal_edit2 - $tanggal_akhir_edit2 </h3>";



    // Gabungkan hasil dari tiga tabel menggunakan UNION
    $sql = " SELECT DISTINCT 
        t.tanggal,
        t.jenis_transaksi,    
        t.no_transaksi,
        t.kode_akun,
        a.nama_akun,
        t.nama_jenjang,
        t.tahun_ajaran,
        t.debit,
        t.kredit
    FROM 
        transaksi_bank t
    JOIN 
        akun a ON t.kode_akun = a.kode_akun
    WHERE 
        t.kode_akun = '$kode_akun'
        AND t.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        AND EXISTS (
            SELECT 1
            FROM transaksi_bank tb
            WHERE tb.kode_akun = t.kode_akun 
            AND ((tb.debit > 0 AND t.kredit > 0) OR
                 (tb.kredit > 0 AND t.debit > 0) OR
                 t.jenis_transaksi = 'pengeluaran')
        )
    GROUP BY 
        t.no_transaksi  -- Mengelompokkan per no_transaksi
    ORDER BY 
        t.tanggal ASC;
    ";
    
    // Eksekusi query dan cek hasil
    $result = $konektor->query($sql);
    
    if (!$result) {
        die("Error pada query: " . $konektor->error);
    }
    
    if ($result->num_rows > 0) {
        // Tampilkan header tabel
        echo "<table border='1'>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Bank</th>
                    <th>Jenis Transaksi</th>
                    <th>No. Transaksi</th>
                    <th>Kode Akun</th>
                    <th>Nama Akun</th>
                    <th>Nama Jenjang</th>
                    <th>Tahun Ajaran</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                </tr>";
        
        // Output data untuk setiap baris
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>" . $row["tanggal"] . "</td>
            <td>" . $nama_akun . "</td>
            <td>" . $row["jenis_transaksi"] . "</td>
            <td>" . $row["no_transaksi"] . "</td>
            <td>" . $row["kode_akun"] . "</td>
            <td>" . $row["nama_akun"] . "</td>
            <td>" . $row["nama_jenjang"] . "</td>
            <td>" . $row["tahun_ajaran"] . "</td>
            <td>" . number_format($row["debit"], 2, ',', '.') . "</td>
            <td>" . number_format($row["kredit"], 2, ',', '.') . "</td>
        </tr>";
        }
        
        // Tutup tabel
        echo "</table>";
    } else {
        echo "Tidak ada data yang ditemukan.";
    }
    

    // Tutup koneksi database
    $konektor->close();
} else {
    // Jika tanggal_awal, tanggal_akhir, atau kode_akun tidak diisi, kembali ke halaman sebelumnya atau berikan pesan kesalahan.
    echo "Mohon masukkan tanggal awal, tanggal akhir, dan kode akun.";
}
?>


<!-- SELECT akun.nama_akun, transaksi_bank.tanggal, transaksi_bank.kode_akun, transaksi_bank.keterangan, transaksi_bank.kredit, transaksi_bank.debit
    FROM transaksi_bank
    JOIN akun ON transaksi_bank.kode_akun = akun.kode_akun
    WHERE akun.arus_kas = 'BANK' AND transaksi_bank.kredit > 0 AND tanggal >= '$tanggal_awal' AND tanggal <= '$tanggal_akhir' AND kode_akun = '$kode_akun' AND status = 1
    
    UNION ALL
    
    SELECT akun.nama_akun,transaksi_kas.tanggal,transaksi_kas.kode_akun,transaksi_kas.keterangan,transaksi_kas.kredit,transaksi_kas.debit
    FROM transaksi_kas
    JOIN akun ON transaksi_kas.kode_akun = akun.kode_akun
    WHERE akun.arus_kas = 'BANK' AND transaksi_kas.kredit > 0 AND tanggal >= '$tanggal_awal' AND tanggal <= '$tanggal_akhir' AND kode_akun = '$kode_akun' AND status = 1

    UNION ALL
    
    SELECT akun.nama_akun,transaksi_memorial.tanggal,transaksi_memorial.kode_akun,transaksi_memorial.keterangan,transaksi_memorial.kredit,transaksi_memorial.debit
    FROM transaksi_memorial
    JOIN akun ON transaksi_memorial.kode_akun = akun.kode_akun
    WHERE  akun.arus_kas = 'BANK' AND transaksi_memorial.kredit > 0 AND tanggal >= '$tanggal_awal' AND tanggal <= '$tanggal_akhir' AND kode_akun = '$kode_akun' AND status = 1";

    ORDER BY 
        tanggal ASC; -->
<!-- 
SELECT 
    'BANK' AS nama_akun,
    tanggal,
    kategori,
    kode_akun,
    keterangan,
    kredit,
    debit
FROM 
    transaksi
WHERE 
    kategori = 'Penerimaan' AND kredit > 0
ORDER BY 
    tanggal ASC;




    WITH BankPosition AS (
    SELECT 
        kode_akun,
        debit,
        kredit
    FROM 
        transaksi_bank
    WHERE 
        kode_akun = '110'  -- Ganti '110' dengan kode akun "Bank" yang ingin Anda cari
    LIMIT 1  -- Ambil satu baris untuk memastikan tidak ada duplikasi dalam kondisi
)

SELECT DISTINCT 
    t.tanggal,
    t.jenis_transaksi,    
    t.no_transaksi,
    t.kode_akun,
    a.nama_akun,  -- Nama akun akan diambil berdasarkan setiap kode akun transaksi
    t.nama_jenjang,
    t.tahun_ajaran,
    t.debit,
    t.kredit
FROM 
    transaksi_bank t
JOIN 
    akun a ON t.kode_akun = a.kode_akun
JOIN 
    BankPosition bp ON 
        (bp.debit > 0 AND t.kredit > 0) OR  -- Jika akun bank ada di debit, pilih kredit
        (bp.kredit > 0 AND t.debit > 0)     -- Jika akun bank ada di kredit, pilih debit
WHERE 
    t.kode_akun != '110'  -- Hindari menampilkan baris dengan kode akun "Bank" itu sendiri
ORDER BY 
    t.tanggal ASC









// Koneksi ke database
$konektor = mysqli_connect("localhost", "username", "password", "nama_database");

// Pastikan koneksi berhasil
if (!$konektor) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Kode akun untuk Bank yang dicari
$kode_akun_bank = '110';

// SQL query
$sql = "
WITH BankPosition AS (
    SELECT 
        kode_akun,
        debit,
        kredit
    FROM 
        transaksi_bank
    WHERE 
        kode_akun = '$kode_akun'
    LIMIT 1
),
BankName AS (
    SELECT 
        kode_akun,
        nama_akun AS nama_akun_bank
    FROM 
        akun
    WHERE 
        kode_akun = '$kode_akun'
)

SELECT DISTINCT 
    t.tanggal,
    t.no_transaksi,
    t.kode_akun,
    a.nama_akun,
    t.nama_jenjang,
    t.tahun_ajaran,
    t.debit,
    t.kredit,
    bn.nama_akun_bank
FROM 
    transaksi_bank t
JOIN 
    akun a ON t.kode_akun = a.kode_akun
JOIN 
    BankPosition bp ON 
        (bp.debit > 0 AND t.kredit > 0) OR 
        (bp.kredit > 0 AND t.debit > 0)
JOIN 
    BankName bn ON bn.kode_akun = bp.kode_akun
WHERE 
    t.kode_akun != '$kode_akun'
ORDER BY 
    t.tanggal ASC";

// Eksekusi query
$result = mysqli_query($konektor, $sql);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($konektor));
}

// Tampilkan hasil
while ($row = mysqli_fetch_assoc($result)) {
    echo "Tanggal: " . $row['tanggal'] . "<br>";
    echo "No Transaksi: " . $row['no_transaksi'] . "<br>";
    echo "Kode Akun: " . $row['kode_akun'] . "<br>";
    echo "Nama Akun: " . $row['nama_akun'] . "<br>";
    echo "Nama Akun Bank: " . $row['nama_akun_bank'] . "<br>";
    echo "Nama Jenjang: " . $row['nama_jenjang'] . "<br>";
    echo "Tahun Ajaran: " . $row['tahun_ajaran'] . "<br>";
    echo "Debit: " . $row['debit'] . "<br>";
    echo "Kredit: " . $row['kredit'] . "<br><br>";
}

// Tutup koneksi
mysqli_close($konektor);
?>



WITH BankPosition AS (
    SELECT 
        kode_akun,
        debit,
        kredit
    FROM 
        transaksi_bank
    WHERE 
        kode_akun = '110'  -- Ganti '110' dengan kode akun bank yang diinginkan
    LIMIT 1
)

SELECT DISTINCT 
    t.tanggal,
    t.jenis_transaksi,    
    t.no_transaksi,
    t.kode_akun,
    a.nama_akun,
    t.nama_jenjang,
    t.tahun_ajaran,
    t.debit,
    t.kredit
FROM 
    transaksi_bank t
JOIN 
    akun a ON t.kode_akun = a.kode_akun
CROSS JOIN 
    BankPosition bp  -- Gunakan CROSS JOIN agar tidak membatasi kondisi JOIN
WHERE 
    t.kode_akun != '110'  -- Hindari menampilkan baris dengan kode akun bank itu sendiri
    AND (
        (bp.debit > 0 AND t.kredit > 0) OR  -- Jika akun bank ada di posisi debit, pilih transaksi kredit
        (bp.kredit > 0 AND t.debit > 0) OR  -- Jika akun bank ada di posisi kredit, pilih transaksi debit
        t.jenis_transaksi = 'pengeluaran'    -- Tambahkan pengeluaran agar selalu muncul
    ) -->
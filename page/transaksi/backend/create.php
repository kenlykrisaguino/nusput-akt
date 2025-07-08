<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid API endpoint',
        'errors' => [],
    ]);
    exit();
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_nusput_akt';
$konektor = new mysqli($host, $user, $pass, $db);

if ($konektor->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$rawData = file_get_contents('php://input');
$trxData = json_decode($rawData, true);

// --- Awal Kode Pengambilan Data ---
$kodeTrx = [];
$academicYear = [];
$listJenjang = [];

foreach ($trxData as $trx) {
    $kodeTrx[] = "'" . $konektor->real_escape_string($trx['kode_transaksi']) . "'";
    $academicYear[] = "'" . $konektor->real_escape_string($trx['tahun_ajaran']) . "'";
    $listJenjang[] = "'" . $konektor->real_escape_string($trx['nama_jenjang']) . "'";
}

// Ambil master transaksi
$kodeStr = implode(',', array_unique($kodeTrx));
$query = "SELECT kode_transaksi, kategori_transaksi, akun_debit, kode_akun_debit, akun_kredit, kode_akun_kredit
          FROM master_transaksi WHERE status = 1 AND kode_transaksi IN ($kodeStr)";
$result = $konektor->query($query);
$trxCode = [];
if ($result->num_rows > 0) {
    while ($trx = $result->fetch_assoc()) {
        $trxCode[$trx['kode_transaksi']] = $trx;
    }
}

// Ambil tahun ajaran
$tahunStr = implode(',', array_unique($academicYear));
$query = "SELECT kode_tahun, tahun_ajaran FROM th_ajaran WHERE status = 1 AND tahun_ajaran IN ($tahunStr)";
$result = $konektor->query($query);
$tahun_ajaran = [];
if ($result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
        $tahun_ajaran[$data['tahun_ajaran']] = $data['kode_tahun'];
    }
}

// Ambil jenjang
$jenjangStr = implode(',', array_unique($listJenjang));
$query = "SELECT kode_jenjang, nama_jenjang FROM master_jenjang WHERE status = 1 AND nama_jenjang IN ($jenjangStr)";
$result = $konektor->query($query);
$jenjang = [];
if ($result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
        $jenjang[$data['nama_jenjang']] = $data['kode_jenjang'];
    }
}
// --- Akhir Kode Pengambilan Data ---


// --- Awal Kode Proses & Insert ---
try {
    $query = $konektor->query('SELECT MAX(CAST(no_transaksi AS UNSIGNED)) AS max_code FROM transaksi');
    $row = $query->fetch_assoc();
    $kode_transaksi = isset($row['max_code']) ? (int) $row['max_code'] + 1 : 1;
    
    $now = date('Y-m-d H:i:s');
    $trxArr = [];

    foreach ($trxData as $data) {
        $kode_trx_input = $data['kode_transaksi'];
        $master_transaksi = $trxCode[$kode_trx_input] ?? null;
        if (!$master_transaksi) {
            throw new Exception("Transaksi tidak ditemukan ($kode_trx_input)");
        }

        $kode_tahun = $tahun_ajaran[$data['tahun_ajaran']] ?? null;
        if (!$kode_tahun) {
            throw new Exception("Tahun Ajaran tidak ditemukan ({$data['tahun_ajaran']})");
        }

        $kode_jenjang = $jenjang[$data['nama_jenjang']] ?? null;
        if (!$kode_jenjang) {
            throw new Exception("Jenjang tidak ditemukan ({$data['nama_jenjang']})");
        }

        $isPenggantianDenda = isset($data['penggantian_denda']) && $data['penggantian_denda'];

        $akunDebit = [
            'kode' => $isPenggantianDenda ? $master_transaksi['kode_akun_kredit'] : $master_transaksi['kode_akun_debit'],
            'akun' => $isPenggantianDenda ? $master_transaksi['akun_kredit'] : $master_transaksi['akun_debit'],
        ];
        $akunKredit = [
            'kode' => $isPenggantianDenda ? $master_transaksi['kode_akun_debit'] : $master_transaksi['kode_akun_kredit'],
            'akun' => $isPenggantianDenda ? $master_transaksi['akun_debit'] : $master_transaksi['akun_kredit'],
        ];

        // Escape semua value string untuk keamanan
        $esc_kategori     = $konektor->real_escape_string($master_transaksi['kategori_transaksi']);
        $esc_thn_ajaran   = $konektor->real_escape_string($data['tahun_ajaran']);
        $esc_nama_jenjang = $konektor->real_escape_string($data['nama_jenjang']);
        $esc_sumber_dana  = $konektor->real_escape_string($data['sumber_dana']);
        $bulan            = substr($data['bulan'], 0, 3);
        $esc_keterangan   = $konektor->real_escape_string("$esc_kategori ($bulan)");
        $saldo            = (float) $data['saldo'];

        // Baris untuk jurnal DEBIT
        $esc_kode_akun_debit = $konektor->real_escape_string($akunDebit['kode']);
        $esc_nama_akun_debit = $konektor->real_escape_string($akunDebit['akun']);
        $trxArr[] = "('1', '$kode_transaksi', '$now', 
                      '$kode_trx_input', '$esc_kategori', '$kode_tahun', 
                      '$esc_thn_ajaran', '$esc_kode_akun_debit', '$esc_nama_akun_debit', 
                      '$kode_jenjang', '$esc_nama_jenjang','$esc_keterangan',
                      '$esc_sumber_dana', $saldo, 0)";

        // Baris untuk jurnal KREDIT
        $esc_kode_akun_kredit = $konektor->real_escape_string($akunKredit['kode']);
        $esc_nama_akun_kredit = $konektor->real_escape_string($akunKredit['akun']);
        $trxArr[] = "('1', '$kode_transaksi', '$now', 
                      '$kode_trx_input', '$esc_kategori', '$kode_tahun', 
                      '$esc_thn_ajaran', '$esc_kode_akun_kredit', '$esc_nama_akun_kredit', 
                      '$kode_jenjang', '$esc_nama_jenjang','$esc_keterangan',
                      '', 0, $saldo)";
        
        $kode_transaksi++;
    }

    if (empty($trxArr)) {
        throw new Exception("Tidak ada data transaksi untuk diproses.");
    }

    $insertStr = implode(',', $trxArr);
    $stmt = "INSERT INTO transaksi (
                status, no_transaksi, tanggal, 
                kode_transaksi, kategori_transaksi,
                kode_tahun, tahun_ajaran, kode_akun,
                nama_akun, kode_jenjang, nama_jenjang,
                keterangan, sumber_dana, debit, kredit
              ) VALUES $insertStr";

    if ($konektor->query($stmt)) {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Berhasil memasukkan data ke dalam sistem AKT',
            'errors' => [],
        ]);
    } else {
        throw new Exception("Gagal memasukan data ke dalam sistem AKT: " . $konektor->error);
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        'errors' => [], 
    ]);
} finally {
    $konektor->close();
}
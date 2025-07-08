<?php

	function terlambat($tanggal_dateline, $tanggal_kembali){
	
	$tanggal_dateline_pecah = explode("-", $tanggal_dateline);
	$tanggal_dateline_pecah = $tanggal_dateline_pecah[2]."-".$tanggal_dateline_pecah[1]."-".$tanggal_dateline_pecah[0];
	
	$tanggal_kembali_pecah = explode("-", $tanggal_kembali);
	$tanggal_kembali_pecah = $tanggal_kembali_pecah[2]."-".$tanggal_kembali_pecah[1]."-".$tanggal_kembali_pecah[0];
	
	$selisih = strtotime($tanggal_kembali_pecah)- strtotime($tanggal_dateline_pecah);
	$selisih = $selisih/86400;
	
	if ($selisih>=1) {
		$hasil_tanggal = floor($selisih);
	}
	else{
		$hasil_tanggal = 0;
	}
	return  $hasil_tanggal;
	}
	
	?>

<?php

$servername = "localhost";
$username = "tagy3641_aktsystem";
$password = "ku+P.uz?[p$3ldj6";
$dbname = "tagy3641_akt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT akun.kode_akun, akun.nama_akun, 
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_kas 
            WHERE akun.kode_akun = transaksi_kas.kode_akun
        ) +
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_bank 
            WHERE akun.kode_akun = transaksi_bank.kode_akun
        ) +
        (
            SELECT COALESCE(SUM(debit), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
        ) AS total_debit,
        
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_kas 
            WHERE akun.kode_akun = transaksi_kas.kode_akun
        ) +
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_bank 
            WHERE akun.kode_akun = transaksi_bank.kode_akun
        ) +
        (
            SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_memorial 
            WHERE akun.kode_akun = transaksi_memorial.kode_akun
        ) AS total_kredit

        FROM akun";

$result = $conn->query($sql);

if ($result === false) {
    die("Error in SQL query: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Create table structure outside the loop
    echo "<table border='1'>
            <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Saldo Awal</th>
                <th>Total Debit</th>
                <th>Total Kredit</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        // Output data for each row
        echo "<tr>
                <td>" . $row['kode_akun'] . "</td>
                <td>" . $row['nama_akun'] . "</td>
                <td>test</td>
                <td>" . number_format($row['total_debit'], 0, ',', '.') . "</td>
                <td>" . number_format($row['total_kredit'], 0, ',', '.') . "</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();

?>

(SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_kas 
            WHERE akun.kode_akun = transaksi_kas.kode_akun
            AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir') 
            +
            (SELECT COALESCE(SUM(kredit), 0) 
            FROM transaksi_bank 
            WHERE akun.kode_akun = transaksi_bank.kode_akun
            AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir') 
            +
            (
                SELECT COALESCE(SUM(kredit), 0) 
                FROM transaksi_memorial 
                WHERE akun.kode_akun = transaksi_memorial.kode_akun
                AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            ) AS total_kredit












            (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS tk

    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS sd

    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS smp

    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS sma
    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS smk1

    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS smk2

    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS stifera

    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS mess

    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS sekolah_basket

    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS les_mandarin

    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND transaksi_bank.kode_jenjang = '1'), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND transaksi_bank.kode_jenjang = '1'), 0), 0
    ) AS umum





    (SELECT 
    COALESCE((SUM(debit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_bank.kode_jenjang = '1' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_kas.kode_jenjang = '1' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ), 0) 
        +
    COALESCE((SUM(debit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '1 AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ), 0), 0
    ) -
    (SELECT 
    COALESCE((SUM(kredit) 
    FROM transaksi_kas WHERE akun.kode_akun = transaksi_kas.kode_akun AND transaksi_bank.kode_jenjang = '1' AND transaksi_kas.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ), 0) 
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_bank WHERE akun.kode_akun = transaksi_bank.kode_akun AND transaksi_kas.kode_jenjang = '1' AND transaksi_bank.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'), 0)         
        +
    COALESCE((SUM(kredit) 
    FROM transaksi_memorial WHERE akun.kode_akun = transaksi_memorial.kode_akun AND transaksi_memorial.kode_jenjang = '1'AND transaksi_memorial.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'), 0), 0
    ) AS day_care
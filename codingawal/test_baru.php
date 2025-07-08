<?php

$servername = "localhost";
$username = "tagy3641_nusa";
$password = "29^mcZTa}bLfDPrc";
$dbname = "tagy3641_akt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT kode_akun, nama_akun FROM akun";
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Create table structure outside the loop
    echo "<table border='1'>
            <tr>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Jenjang</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        $kode_akun = $row['kode_akun'];
        
        // Combine all queries into one
        $sql1 = "SELECT tanggal, no_transaksi, kode_akun, nama_akun, nama_jenjang, keterangan, SUM(debit) AS totdebit, SUM(kredit) AS totkredit FROM transaksi_kas WHERE kode_akun='$kode_akun' GROUP BY kode_akun
        UNION ALL
        SELECT tanggal, no_transaksi, kode_akun, nama_akun, nama_jenjang, keterangan, SUM(debit) AS totdebit, SUM(kredit) AS totkredit FROM transaksi_bank WHERE kode_akun='$kode_akun' GROUP BY kode_akun
        UNION ALL
        SELECT tanggal, no_transaksi, kode_akun, nama_akun, nama_jenjang, keterangan, SUM(debit) AS totdebit, SUM(kredit) AS totkredit FROM transaksi_memorial WHERE kode_akun='$kode_akun' GROUP BY kode_akun";

        
        $result1 = $conn->query($sql1);

        if ($result1 === false) {
            die("Error in SQL query: " . $conn->error);
        }
        
        while ($row1 = $result1->fetch_assoc()) {
            // Output data for each row
            echo "<tr>
                    <td>" . $row1['tanggal'] . "</td>
                    <td>" . $row1['no_transaksi'] . "</td>
                    <td>" . $row1['kode_akun'] . "</td>
                    <td>" . $row1['nama_akun'] . "</td>
                    <td>" . $row1['nama_jenjang'] . "</td>
                    <td>" . $row1['keterangan'] . "</td>
                    <td>" . $row1['totdebit'] . "</td>
                    <td>" . $row1['totkredit'] . "</td>
                </tr>";
        }
        
    }

    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();

?>

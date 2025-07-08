<?php
$konektor = mysqli_connect("localhost", "tagy3641_nusa", "29^mcZTa}bLfDPrc", "tagy3641_akt");
$sql = $konektor->query("SELECT * FROM transaksi_kas WHERE no_transaksi = 18");

if ($sql) {
    $data = $sql->fetch_assoc();
    $no_bukti = $data['no_transaksi'];
    $tanggal = $data['tanggal'];
    $sumber_dana = $data['sumber_dana'];
    $nama_akun = $data['nama_akun'];
    $keterangan = $data['keterangan'];
    $jumlah = $data['debit']; // Replace 'jumlah' with the actual column name

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <style>
            table {
                border-collapse: collapse;
                width: 50%;
            }
            th, td {
                border: 1px solid black;
                padding: 4px;
                text-align: left;
            }
            .center {
                text-align: center;
            }
            .table2 {
                border-collapse: collapse;
                width: 40%;
            }
            .table1 {
                border-collapse: collapse;
                width: 50%;
                border: none;
            }
            .table1 th, .table1 td {
                border: none;
                padding: 4px;
                text-align: left;
            }
            .table2 th, .table2 td {
                border: 1px solid black;
                padding: 4px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <h2>Bukti Transaksi</h2>

        <table class="table1">
            <tr>
                <th width="10%">No.Bukti:</th>
                <td width="10%"><?= $no_bukti ?></td>
                <th width="10%">Tanggal:</th>
                <td width="10%"><?= $tanggal ?></td>
                <th width="10%">Sumber Dana:</th>
                <td width="10%"><?= $sumber_dana ?></td>
            </tr>
        </table>

        <table>
            <tr>
                <th colspan="10">DIBAYARKAN KEPADA:</th>
            </tr>
            <tr>
                <th class="center" colspan="4">Akun</th>
                <th class="center" colspan="4">Keterangan</th>
                <th class="center" colspan="2">Jumlah</th>
            </tr>
            <tr>
                <td colspan="4"><?= $nama_akun ?></td>
                <td colspan="4"><?= $keterangan ?></td>
                <td colspan="2"><?= $jumlah ?></td>
            </tr>
            <tr>
                <th class="center" colspan="8">Jumlah</th>
                <th colspan="2">Total jumlah</th>
            </tr>
            <tr>
                <th colspan="10">TERBILANG:</th>
            </tr>
        </table>
        <br>
        <table class="table2">
            <tr>
                <th width="25%" class="center" colspan="2">Disetujui</th>
                <th width="25%" class="center" colspan="2">Pembukuan</th>
                <th width="25%" class="center" colspan="2">Kasir</th>
                <th width="25%" class="center" colspan="2">Penerima</th>
            </tr>
            <tr>
                <th class="center" colspan="2" rowspan="2">-</th>
                <th class="center" colspan="2" rowspan="2">-</th>
                <th class="center" colspan="2" rowspan="2">-</th>
                <th class="center" colspan="2" rowspan="2">-</th>
            </tr>
        </table>
    </body>
    </html>

    <?php
} else {
    echo "Error fetching data from the database.";
}
?>

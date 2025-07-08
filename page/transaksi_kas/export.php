<!DOCTYPE html>
<html>
<head>
	<title>Export Data Ke Excel</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: none;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
 
	<?php
    header("Content-type: application/xls");  
    header("Content-Disposition: attachment; filename=Transaksi Kas.xls");  
	?>
 
	<center>
		<h3>Transaksi Kas</h3>
	</center>
 
	<table border="1">
		<tr>
			<th>Tanggal</th>
			<th>No. Transaksi</th>
			<th>Transaksi</th>
			<th>Akun</th>			
			<th>Jenjang</th>
			<th>Th. Ajaran</th>
			<th>Keterangan</th>
			<th>Sumber Dana</th>
			<th>Debit</th>
			<th>Kredit</th>
		</tr>

		<?php 
		$konektor = mysqli_connect("localhost","root","","1_nusaputera");
 		$sql = $konektor->query("SELECT * FROM transaksi_kas");
		$no = 1;
		while ($data = $sql->fetch_assoc()) {
		?>
		<?php if ($data['status'] == 1) { ?>

        <tr>
			<td><?php echo $data['tanggal'] ?></td>
			<td><?php echo $data['no_transaksi'] ?></td>
			<td><?php echo $data['jenis_transaksi'] ?></td>
			<td><?php echo $data['nama_akun']?></td>
			<td><?php echo $data['nama_jenjang'] ?></td>
			<td><?php echo $data['tahun_ajaran'] ?></td>
			<td><?php echo $data['keterangan'] ?></td>
			<td><?php echo $data['sumber_dana'] ?></td>
			<?php } ?>
			<?php if ($data['debit'] == 0) { ?>
			<td></td>
			<?php } else { ?>
			<td>Rp. <?= number_format($data['debit'], 0, ',', '.'); ?></td>
			<?php } ?>
			<?php if ($data['kredit'] == 0) { ?>
			<td></td>
			<?php } else { ?>
			<td>Rp. <?= number_format($data['kredit'], 0, ',', '.'); ?></td>
			<?php } ?>


		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>
<?
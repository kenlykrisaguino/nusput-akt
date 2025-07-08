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
    header("Content-Disposition: attachment; filename=Backup Data Master Jurnal.xls");  
	?>
 
	<center>
		<h3>Backup Data Master Jurnal</h3>
	</center>
 
	<table border="1">
		<tr>
			<th>Kode Transaksi</th>
			<th>Kategori Transaksi</th>
			<th>Akun Debit</th>
			<th>Akun Kredit</th>
            		<th>Status</th>
		</tr>
		<?php 
		$konektor = mysqli_connect("localhost","tagy3641_nusa","29^mcZTa}bLfDPrc","tagy3641_akt");
 		$sql = $konektor->query("SELECT * from master_transaksi");
		$no = 1;
		while ($data = $sql->fetch_assoc()) {
		?>
        <tr>
			<?php if ($data['status'] == 0) { ?>
			<td><?php echo $data['kode_transaksi'] ?></td>
			<td><?php echo $data['kategori_transaksi'] ?></td>
			<td><?php echo $data['kode_akun_debit'] . " - " . $data['akun_debit']; ?></td>
			<td><?php echo $data['kode_akun_kredit'] . " - " . $data['akun_kredit']; ?></td>
			<td><?php echo $data['status'] ?></td>
		</tr>
		<?php 
		}}
		?>
	</table>
</body>
</html>
<?php
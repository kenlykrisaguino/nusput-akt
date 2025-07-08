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
    header("Content-Disposition: attachment; filename=Data Master Lokasi (Non-Aktif).xls");  
	?>
 
	<center>
		<h3>Master Chart of Account</h3>
	</center>
 
	<table border="1">
		<tr>
			<th>Kode Lokasi</th>
			<th>Nama Lokasi</th>
            <th>Status</th>
		</tr>
		<?php 
		$konektor = mysqli_connect("localhost","tagy3641_aktsystem","ku+P.uz?[p$3ldj6","tagy3641_akt");
 		$sql = $konektor->query("SELECT * FROM lokasi");
		$no = 1;
		while ($data = $sql->fetch_assoc()) {
		?>
        <tr>
			<?php if ($data['status'] == 0) { ?>
			<td><?php echo $data['kode_lokasi'] ?></td>
            <td><?php echo $data['nama_lokasi'] ?></td>
			<td><?php echo $data['status'] ?></td>
		</tr>
		<?php 
		}}
		?>
	</table>
</body>
</html>
<?php
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
    header("Content-Disposition: attachment; filename=Master Tahun Ajaran.xls");  
	?>
 
	<center>
		<h3>Master Tahun Ajaran</h3>
	</center>
 
	<table border="1">
		<tr>
			<th>Kode Tahun Ajaran</th>
			<th>Nama Tahun Ajaran</th>
			<th>Status</th>
		</tr>
		<?php 
		$konektor = mysqli_connect("localhost","tagy3641_aktsystem","ku+P.uz?[p$3ldj6","tagy3641_akt");
 		$sql = $konektor->query("select * from th_ajaran");
		$no = 1;
		while ($data = $sql->fetch_assoc()) {
		?>
        <tr>
			<?php if ($data['status'] == 1) { ?>
			<td><?php echo $data['kode_tahun'] ?></td>
			<td><?php echo $data['tahun_ajaran'] ?></td>
			<td><?php echo $data['status'] ?></td>
		</tr>
		<?php 
		}}
		?>
	</table>
</body>
</html>
<?php
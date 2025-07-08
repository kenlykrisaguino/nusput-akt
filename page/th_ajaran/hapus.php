<?php
	$kode_tahun = $_GET['kode_tahun'];
	$sql = $konektor->query("delete from th_ajaran where kode_tahun = '$kode_tahun'");

	if ($sql) {
		?>
			<script type="text/javascript">
			alert("Data Berhasil Dihapus");
			window.location.href="?page=th_ajaran&aksi=backup";
			</script>
		<?php
	}
?>
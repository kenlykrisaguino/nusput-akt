<?php
	$kode_lokasi = $_GET['kode_lokasi'];
	$sql = $konektor->query("DELETE FROM lokasi WHERE kode_lokasi = '$kode_lokasi'");

	if ($sql) {
		?>
			<script type="text/javascript">
			alert("Data Berhasil Dihapus");
			window.location.href="?page=lokasi&aksi=backup";
			</script>
		<?php
	}
?>